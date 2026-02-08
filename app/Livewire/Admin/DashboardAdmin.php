<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;

class DashboardAdmin extends Component
{
    #[Title('Dashboard Admin')]

    public function render()
    {
        return view('livewire.admin.dashboard-admin')->layout('layouts.app');
    }
}
