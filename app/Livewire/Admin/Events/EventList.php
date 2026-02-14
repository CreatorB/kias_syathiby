<?php

namespace App\Livewire\Admin\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

#[Title('Kelola Event')]
class EventList extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $filterStatus = '';

    public $limitData = 10;

    /**
     * Get filtered events.
     */
    #[Computed]
    public function events()
    {
        return Event::query()
            ->when($this->search, function ($q) {
                return $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($q) {
                return $q->where('status', $this->filterStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->limitData);
    }

    /**
     * Get total events count.
     */
    #[Computed]
    public function totalEvents()
    {
        return Event::count();
    }

    /**
     * Get published events count.
     */
    #[Computed]
    public function publishedCount()
    {
        return Event::where('status', 'published')->count();
    }

    /**
     * Get draft events count.
     */
    #[Computed]
    public function draftCount()
    {
        return Event::where('status', 'draft')->count();
    }

    /**
     * Delete an event.
     */
    public function deleteEvent($id)
    {
        Event::destroy($id);
        $this->dispatch('event-deleted');
    }

    /**
     * Reset filters.
     */
    public function resetFilters()
    {
        $this->reset(['search', 'filterStatus']);
    }

    public function render()
    {
        return view('livewire.admin.events.event-list')
            ->layout('layouts.app', ['title' => 'Kelola Event']);
    }
}
