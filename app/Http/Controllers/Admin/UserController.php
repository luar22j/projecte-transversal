<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'telefono' => 'required|string|size:9',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date|before:-18 years',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::create([
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'telefono' => $validated['telefono'],
            'direccion' => $validated['direccion'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
        ]);

        $role = Role::find($validated['role_id']);
        if ($role) {
            $user->roles()->attach($role);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'telefono' => 'required|string|size:9',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date|before:-18 years',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user->update([
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'],
            'direccion' => $validated['direccion'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
        ]);

        // Actualizar roles
        $role = Role::find($validated['role_id']);
        if ($role) {
            $user->roles()->sync([$role->id]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
