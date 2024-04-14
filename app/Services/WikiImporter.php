<?php

namespace App\Services;

class WikiImporter implements Interfaces\Importer
{
    public string $word;

    public function __construct(private WikiSearchService $searchService)
    {}

    /**
     * @throws \Exception
     */
    public function import(): array
    {
        // Поиск статьи
        $response = $this->searchService->search($this->word)->json();

        // wiki возвращает статус 200, даже если статьи нет, отсюда такая проверка
        if (array_key_exists(-1, $response['query']['pages'])) {
            throw new \Exception('Такой статьи не найдено. Попробуйте изменить запрос');
        }

        // Получение id страницы
        $pageId = array_key_first($response['query']['pages']);
        $page = $response['query']['pages'][$pageId];
        $text = $page['extract'];

        // Проверка на пустой текст или запрос к статье с перенаправлением
        if (!$text || str_contains($text, 'NewPP limit report')) {
            throw new \Exception('Статья с таким заголовком не найдена');
        }

        return [
            'pageid' => $pageId,
            'title' => $page['title'],
            'text' => $text
        ];
    }

    public function bind(string $word): static
    {
        $this->word = $word;

        return $this;
    }
}
