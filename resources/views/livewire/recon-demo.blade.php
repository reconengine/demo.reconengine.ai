<div class="container mx-auto mt-12">
    <input wire:model="search" type="search" placeholder="Search posts by title...">

    <h1>Articles:</h1>

    @foreach($articles as $article)
        <div class="rounded-lg shadow-lg hover:shadow-md p-6 mb-8 bg-white transition-shadow">
            <div class="text-xl font-bold">{{ $article->title }}</div>
            <div class="text-xs text-gray-600 max-h-16 overflow-hidden">{{ $article->text }}</div>
            <div class="flex flex-row space-x-2 items-center mt-4">
                <x-jet-button wire:click="displayRelatedArticles({{$article->id}})" wire:loading.attr="disabled">
                    {{ __('View Related Articles') }}
                </x-jet-button>
                <x-jet-secondary-button wire:click="articleSelected({{$article->id}})" wire:loading.attr="disabled">
                    {{ __('View More') }}
                </x-jet-secondary-button>
                <a href="{{$article->url}}" target="_blank" class="text-indigo-600 hover:text-indigo-800">View Original Article</a>
            </div>
        </div>
    @endforeach

    <!-- Token Value Modal -->
    <x-jet-dialog-modal wire:model="displayingArticle">
        <x-slot name="title">
            {{ optional($selectedArticle)->title }}
        </x-slot>

        <x-slot name="content">
            <div class="text-xs">
                {{ optional($selectedArticle)->text }}
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('displayingArticle', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>


    <!-- Token Value Modal -->
    <x-jet-dialog-modal wire:model="displayingRelatedArticle">
        <x-slot name="title">
            Related to: <div class="font-bold">"{{ optional($selectedArticle)->title }}"</div>
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col space-y-2">
                @if($relatedArticles)
                    @foreach($relatedArticles as $i => $article)
                        <div>{{$i + 1}}. {{ $article->title }}</div>
                    @endforeach
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('displayingRelatedArticle', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
