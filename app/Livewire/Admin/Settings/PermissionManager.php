<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

#[Title('Manajemen Hak Akses')]
class PermissionManager extends Component
{
    public $selectedRole = null;
    public $rolePermissions = [];

    public function mount()
    {
        // Only superadmin can access this
        if (!Auth::user()->isSuperadmin()) {
            return redirect()->route('admin::dashboard');
        }

        // Default to admin role
        $this->selectedRole = 2;
        $this->loadRolePermissions();
    }

    public function loadRolePermissions()
    {
        if ($this->selectedRole) {
            $role = Role::find($this->selectedRole);
            $this->rolePermissions = $role?->permissions->pluck('id')->toArray() ?? [];
        }
    }

    public function updatedSelectedRole()
    {
        $this->loadRolePermissions();
    }

    #[Computed]
    public function roles()
    {
        // Exclude superadmin from editable roles
        return Role::where('id', '!=', 1)->get();
    }

    #[Computed]
    public function permissions()
    {
        return Permission::orderBy('group')->orderBy('display_name')->get()->groupBy('group');
    }

    public function togglePermission($permissionId)
    {
        if (!Auth::user()->isSuperadmin()) {
            return;
        }

        $role = Role::find($this->selectedRole);
        if (!$role) return;

        if (in_array($permissionId, $this->rolePermissions)) {
            $role->permissions()->detach($permissionId);
            $this->rolePermissions = array_diff($this->rolePermissions, [$permissionId]);
        } else {
            $role->permissions()->attach($permissionId);
            $this->rolePermissions[] = $permissionId;
        }

        session()->flash('message', 'Hak akses berhasil diperbarui.');
    }

    public function grantAllPermissions()
    {
        if (!Auth::user()->isSuperadmin()) {
            return;
        }

        $role = Role::find($this->selectedRole);
        if (!$role) return;

        $allPermissionIds = Permission::pluck('id')->toArray();
        $role->permissions()->sync($allPermissionIds);
        $this->rolePermissions = $allPermissionIds;

        session()->flash('message', 'Semua hak akses berhasil diberikan.');
    }

    public function revokeAllPermissions()
    {
        if (!Auth::user()->isSuperadmin()) {
            return;
        }

        $role = Role::find($this->selectedRole);
        if (!$role) return;

        $role->permissions()->detach();
        $this->rolePermissions = [];

        session()->flash('message', 'Semua hak akses berhasil dicabut.');
    }

    public function render()
    {
        return view('livewire.admin.settings.permission-manager')
            ->layout('layouts.app', ['title' => 'Manajemen Hak Akses']);
    }
}
