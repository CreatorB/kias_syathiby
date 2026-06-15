<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

#[Title('Manajemen User')]
class UserManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $roleFilter = null;
    public $showModal = false;
    public $showDeleteModal = false;

    public $userId, $nama, $email, $password, $role_id, $is_active = true;
    public $isEdit = false;
    public $deleteUserId;

    public function render()
    {
        $query = User::with('role')
            ->whereNotIn('role_id', [1, 2])
            ->when($this->search, function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })->when($this->roleFilter, function($q) {
                $q->where('role_id', $this->roleFilter);
            });

        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        $roles = Role::whereNotIn('id', [1, 2])->get();

        return view('livewire.admin.user.user-management', compact('users', 'roles'));
    }

    public function openModal($id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
            $this->userId = $user->id;
            $this->nama = $user->nama;
            $this->email = $user->email;
            $this->role_id = $user->role_id;
            $this->is_active = $user->is_active;
            $this->isEdit = true;
            $this->password = '';
        } else {
            $this->reset(['userId', 'nama', 'email', 'password', 'role_id', 'is_active', 'isEdit']);
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['userId', 'nama', 'email', 'password', 'role_id', 'is_active', 'isEdit']);
    }

    public function save()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->isEdit ? $this->userId : 'NULL') . ',id',
            'password' => $this->isEdit ? 'nullable|min:6' : 'required|min:6',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'boolean',
        ]);

        $data = [
            'nama' => $this->nama,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'is_active' => $this->is_active,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEdit) {
            User::find($this->userId)->update($data);
            session()->flash('success', 'User berhasil diperbarui!');
        } else {
            User::create($data);
            session()->flash('success', 'User berhasil dibuat!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->deleteUserId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->deleteUserId = null;
        $this->showDeleteModal = false;
    }

    public function delete()
    {
        $user = User::findOrFail($this->deleteUserId);
        
        if ($user->isRoot()) {
            session()->flash('error', 'Tidak dapat menghapus user root!');
        } else {
            $user->delete();
            session()->flash('success', 'User berhasil dihapus!');
        }
        
        $this->cancelDelete();
    }

    public function toggleBan($id)
    {
        $user = User::findOrFail($id);
        if (!$user->isRoot()) {
            $user->toggleBan();
            session()->flash('success', $user->isBanned() ? 'User berhasil diblokir!' : 'User berhasil di-unblokir!');
        } else {
            session()->flash('error', 'Tidak dapat memblokir user root!');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}