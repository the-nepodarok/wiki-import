<div>
    <p class="result-text">Импорт завершён</p>
    <p>Найдена статья по адресу: <b> {{ env('APP_WIKI_URL') . str_replace(' ', '_', $article->header) }}</b></p>
    <p>Время обработки: <b>{{ $time }}с.</b></p>
    <p>Размер статьи: <b>{{ $article->size }}kb</b></p>
@if($article->word_count)
    <p>Кол-во слов: <b>{{ $article->word_count }}</b></p>
@else
    <p wire:poll.1500ms>Кол-во слов: <b>{{ 'Идёт подсчёт...' }}</b></p>
@endif
</div>
