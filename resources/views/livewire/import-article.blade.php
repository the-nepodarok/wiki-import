<div>
    <div class="search-wrapper">
        <input type="search" class="search-input" placeholder="ключевое слово" required wire:model="word" wire:keydown.enter="import">
        <button class="button" wire:click="import">Импортировать</button>
        <p wire:loading>Идёт обработка...</p>
    </div>

@if($article)
    <div class="import-wrapper" wire:loading.remove>
        <livewire:article-info :$article :$time :key="$article->header"/>
    </div>
@elseif($error)
    <p class="import-error" wire:loading.remove> {{ $error }} </p>
@endif

    <hr>

    <livewire:articles-table />
</div>
