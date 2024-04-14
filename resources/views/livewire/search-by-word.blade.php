<div>
    <div class="search-wrapper">
        <input type="text" placeholder="Липецк" wire:model="word" wire:keydown.enter="search" required>
        <button class="button" wire:click="search">Найти</button>
        <span wire:loading>Поиск...</span>
    </div>

    <hr>

    <div class="search-results_wrapper">
        <div class="results-list_wrapper">
    @if ($this->results)
            <div class="results-wrapper">
                <p>Найдено: {{ $this->results->count() }} @choice('plurals.match', $this->results->count()) </p>
            </div>
            <div class="results-links_wrapper">
                <p class="search-query_text">«{{ $word }}» — <span>{{ $matchCount }} @choice('plurals.entry', $matchCount)</span></p>
                <ul class="list results_list">
        @foreach($this->results as $result)
                    <li class="results-option">
                        <p class="search-result" wire:click="$set('text', `{{ $result->contents }}`)">
                            <span>{{ $result->header }}</span>
                            <span>({{ $result->pivot->count }} @choice('plurals.entry', $result->pivot->count))</span>
                        </p>
                    </li>
        @endforeach
                </ul>
            </div>
    @elseif($error)
            <p wire:loading.remove>{{ $error }}</p>
    @endif
        </div>

        <div class="article-frame">
            <article class="article-text">
            @foreach(explode("\n", $text) as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
            </article>
        </div>
    </div>
</div>
