<table class="results-table">
    <tr>
        <th>Название статьи</th>
        <th>Ссылка</th>
        <th>Размер статьи</th>
        <th>Кол-во слов</th>
    </tr>
@foreach($entries as $entry)
    <tr wire:key="{{ $entry->pageid }}">
        <th>{{ $entry->header }}</th>
        <th>{{ env('APP_WIKI_URL') . str_replace(' ', '_', $entry->header) }}</th>
        <th>{{ $entry->size }}kb</th>
    @if($entry->word_count)
        <th>{{ $entry->word_count }}</th>
    @else
        <th wire:poll.1500ms>{{ 'Идёт подсчёт...' }}</th>
    @endif
    </tr>
@endforeach
</table>
