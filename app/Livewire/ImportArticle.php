<?php

namespace App\Livewire;

use App\Jobs\SplitArticle;
use App\Models\Article;
use App\Services\WikiImporter;
use Illuminate\Database\QueryException;
use Illuminate\View\View;
use Livewire\Component;

class ImportArticle extends Component
{
    public string $word = ''; // текст запроса
    public ?Article $article = null;
    public float $time; // время выполнения
    public string $error = ''; // текст ошибки

    /**
     * @param WikiImporter $wikiImporter Сервис импорта статей
     * @return void
     */
    public function import(WikiImporter $wikiImporter): void
    {
        // Обнулить текущий блок информации о статье
        $this->reset('error', 'article', 'time');

        $responseStartTime = microtime(true);

        // Обработка пустого ввода
        if (!$this->word) {
            $this->error = 'Введите заголовок статьи';
            return;
        }

        try {
            $data = $wikiImporter->bind($this->word)->import();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            return;
        }

        try {
            $article = Article::updateOrCreate([
                'pageid' => $data['pageid'],
                'header' => $data['title'],
            ], ['contents' => $data['text']]);
        } catch (QueryException $e) {
            $this->error = 'Ошибка сохранения данных. Попробуйте позднее или поищите другую статью';
            error_log($e->getMessage());
            return;
        }

        // Поставить в очередь задачу по разбивке текста
        SplitArticle::dispatch($article);

        $this->article = $article;
        $this->time = round(microtime(true) - $responseStartTime, 2);

        // Перерендерить компонент для подгрузки новой статьи в таблице
        $this->dispatch('update')->to(ArticlesTable::class);
    }

    public function render(): View
    {
        return view('livewire.import-article');
    }
}
