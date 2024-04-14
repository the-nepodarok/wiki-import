<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * Сервис импорта текста статей из Википедии
 */
class WikiSearchService
{
    private string $apiUrl = 'https://ru.wikipedia.org/w/api.php';
    private array $params = [
        'action' => 'query',
        'format' => 'json',
        'prop' => 'extracts',
        'explaintext' => true,
    ];

    /**
     * Построение структуры запроса
     * @param string $query
     * @return void
     */
    private function buildQuery(string $query): void
    {
        $this->params['titles'] = $query;
    }

    /**
     * Поиск статьи по заголовку
     * @param string $query
     * @return Response
     * @throws BadRequestException
     */
    public function search(string $query): Response
    {
        $this->buildQuery($query);

        $response = Http::get($this->apiUrl, $this->params);

        if ($response->successful()) {
            return $response;
        }

        throw new BadRequestException('Ошибка получения ответа от сервиса, попробуйте снова позднее');
    }
}
