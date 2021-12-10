<div class="container mx-auto px-4 py-4 md:py-12">
    <div class="flex flex-row items-center space-x-4 mb-8">
        <img src="https://reconengine.ai/favicon.ico" alt="Recon Logo" class="h-24 w-24"/>
        <div class="space-y-2">
            <a class="text-lg underline hover:text-blue-500 font-bold transition-colors" href="https://reconengine.ai/">Recon - World class recommendation engine brought to Laravel</a>
            <div class="text-sm">Recon is a recommendation engine as a service with an intuitive API. Built on the same foundation powering Amazon.com.</div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row space-x-0 sm:space-x-4 space-y-4 sm:space-y-0 mb-8">
        <a class="bg-black rounded text-white text-center py-2 px-3 hover:bg-gray-600 transition-colors" href="https://reconengine.ai/">Recon</a>
        <a class="bg-black rounded text-white text-center py-2 px-3 hover:bg-gray-600 transition-colors" href="https://github.com/reconengine/demo.reconengine.ai">Source Code</a>
        <a class="bg-black rounded text-white text-center py-2 px-3 hover:bg-gray-600 transition-colors" href="https://docs.reconengine.ai/">Documentation</a>
    </div>

    <div class="mb-4 font-bold text-xl">Articles:</div>

    <div class="mb-4">
        <label for="email" class="sr-only">Email</label>
        <input wire:model="search" type="search" name="email" id="email" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Filter Articles">
    </div>

    @foreach($movies as $movie)
        <div class="rounded-lg shadow-xl hover:shadow-md p-6 mb-8 bg-white transition-shadow duration-300">
            <div class="text-xl font-bold">{{ $movie->title }}</div>
            <div class="text-xs text-gray-600 max-h-16 overflow-hidden">{{ $movie->text }}</div>
            <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0 items-center mt-4">
                <x-jet-button wire:click="displayRelatedArticles({{$movie->id}})" wire:loading.attr="disabled" wire:target="displayRelatedArticles({{$movie->id}})">
                    {{ __('View Related Articles') }}
                </x-jet-button>
                <x-jet-secondary-button wire:click="movieSelected({{$movie->id}})" wire:loading.attr="disabled" wire:target="movieSelected({{$movie->id}})">
                    {{ __('View More') }}
                </x-jet-secondary-button>
                <a href="{{$movie->url}}" target="_blank" class="text-blue-600 hover:text-blue-800">View Original Article</a>
            </div>
        </div>
    @endforeach

    <!-- Token Value Modal -->
    <x-jet-dialog-modal wire:model="displayingRelatedArticle">
        <x-slot name="title">
            Related to: <div class="font-bold">"{{ optional($selectedArticle)->title }}"</div>
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col space-y-2">
                @if($relatedArticles)
                    @foreach($relatedArticles as $i => $movie)
                        <div class="text-blue-600 hover:text-blue-800" wire:click="movieSelected({{$movie->id}})" wire:loading.attr="disabled" wire:target="movieSelected({{$movie->id}})">{{$i + 1}}. {{ $movie->title }}</div>
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
</div>
