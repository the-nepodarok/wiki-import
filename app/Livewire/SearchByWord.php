<?php

namespace App\Livewire;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SearchByWord extends Component
{
    public int $matchCount;
    public string $word = '';
    public string $text = '';
    public string $error;

    public function search(): void
    {
        // обнулить текст статьи и текст ошибки перед обновлением
        $this->reset('text', 'error');

        if ($this->word) {
            if ($this->results) {
                $this->matchCount = $this->results->sum('pivot.count');
            } else {
                $this->error = 'Совпадений не найдено';
            }
        } else {
            $this->error = 'Введите слово для поиска';
        }
    }

    /**
     * Отобразить текст статьи с подсвеченными вхождениями посредством оборачивания в span с заданным классом
     * и применением strip_tags для удаления возможных script-тегов
     * @param string $text
     * @return void
     */
    public function showText(string $text): void
    {
        $this->text = preg_replace("/$this->word\b/u", '<span class="word_highlighted">' . $this->word . '</span>', $text);
    }

    /**
     * "Вычисляемое" свойство для сохранения между состояниями
     * (чтобы Livewire не терял некоторые данные из связи при обновлении состояния)
     * @return Collection|null
     */
    #[Computed]
    public function results(): ?Collection
    {
        return Article::searchByWord($this->word);
    }

    public function render()
    {
        return view('livewire.search-by-word');
    }
}
