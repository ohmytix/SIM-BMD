<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Skpd;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class Index extends Component
{
    public $users;

    public $userId;
    public $name;
    public $email;
    public $password;

    public $role = 'operator_skpd';

    public $skpd_id;

    public function getSkpdsProperty()
    {
        return Skpd::orderBy('nama')->get();
    }

    public $isEdit = false;

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    protected function rules()
    {
        return [

            'name' => 'required|string|max:100',

            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->userId,
            ],

            'role' => 'required|in:admin,operator_skpd,viewer',

            'password' => $this->isEdit
                ? 'nullable|min:6'
                : 'required|min:6',

            'skpd_id' => $this->role === 'operator_skpd'
                ? 'required'
                : 'nullable',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount()
    {
        $this->loadUsers();

        $this->skpds = Skpd::orderBy('nama')->get();
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD USERS
    |--------------------------------------------------------------------------
    */

    public function loadUsers()
    {
        $this->users = User::with('skpd')
            ->orderBy('name')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | RESET FORM
    |--------------------------------------------------------------------------
    */

    public function resetForm()
    {
        $this->reset([
            'userId',
            'name',
            'email',
            'password',
            'role',
            'skpd_id',
            'isEdit'
        ]);

        $this->role = 'operator_skpd';
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE USER
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->validate();

        User::create([

            'name' => $this->name,

            'email' => $this->email,

            'password' => Hash::make($this->password),

            'role' => $this->role,

            'skpd_id' => $this->role === 'operator_skpd'
                ? $this->skpd_id
                : null,
        ]);

        $this->resetForm();

        $this->loadUsers();

        session()->flash(
            'success',
            'User berhasil ditambahkan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $this->userId = $user->id;

        $this->name = $user->name;

        $this->email = $user->email;

        $this->role = $user->role;

        $this->skpd_id = $user->skpd_id;

        $this->password = null;

        $this->isEdit = true;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);

        $data = [

            'name' => $this->name,

            'email' => $this->email,

            'role' => $this->role,

            'skpd_id' => $this->role === 'operator_skpd'
                ? $this->skpd_id
                : null,
        ];

        if ($this->password) {

            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        $this->resetForm();

        $this->loadUsers();

        session()->flash(
            'success',
            'User berhasil diperbarui'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $user = User::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | OPTIONAL SAFETY
        |--------------------------------------------------------------------------
        */

        if ($user->id === auth()->id()) {

            session()->flash(
                'error',
                'Tidak bisa menghapus akun sendiri'
            );

            return;
        }

        $user->delete();

        $this->loadUsers();

        session()->flash(
            'success',
            'User berhasil dihapus'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view('livewire.admin.user.index');
    }
}