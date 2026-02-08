<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\Reactive;

class LoadMoreButton extends Component
{
    #[Reactive]
    public $tambahData;

    public function loadMore() {
        $this->dispatch('load-data', addData:$this->tambahData);
    }

    public function render()
    {
        return view('livewire.components.load-more-button');
    }
}
