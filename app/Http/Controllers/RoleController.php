<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController
{
    public function index()
    {
        $roles = Role::get();

        $permissions = Permission::get();

        $users = User::get();

        return view('roles.index', compact('roles', 'permissions', 'users'));
    }

    public function store()
    {
        $role = Role::create(['name' => request('role')]);

        $role->syncPermissions(request('permissions'));

        return back();
    }

    public function addUser()
    {
        $user = User::create([
            'name'=>request('name'),
            'email'=>request('email'),
            'password'=>request('password'),
        ]);

        $user->assignRole(request('role'));

        return back();
    }
}
