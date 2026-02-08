<div>
    <div class="col-12 mb-1 text-center">
        <x-buttons.outline-primary wire:click="loadMore" wire:loading.remove>
            Tampilkan Lagi
        </x-buttons.outline-primary>

        <div wire:loading wire:target='loadMore'>
            <x-items.colored-spinner color="primary"></x-items.colored-spinner>
        </div>
    </div>
</div>
