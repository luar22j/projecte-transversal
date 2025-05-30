<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => ['required', 'string', 'max:255'],
                'apellidos' => ['required', 'string', 'max:255'],
                'fecha_nacimiento' => ['required', 'date'],
                'telefono' => ['required', 'string', 'regex:/^(\+?[0-9]{9,15})$/'],
                'direccion_envio' => ['required', 'string', 'max:255'],
                'direccion_facturacion' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            // Obtener el rol de usuario
            $role = Role::firstOrCreate(
                ['nombre' => 'user'],
                ['description' => 'Usuario normal']
            );

            $user = User::create([
                'nombre' => $validated['nombre'],
                'apellidos' => $validated['apellidos'],
                'fecha_nacimiento' => $validated['fecha_nacimiento'],
                'telefono' => $validated['telefono'],
                'direccion_envio' => $validated['direccion_envio'],
                'direccion_facturacion' => $validated['direccion_facturacion'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Asignar el rol al usuario
            $user->roles()->attach($role);

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('home')->with('success', '¡Registro exitoso! Bienvenido a Burgers & Roll.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error en el registro: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'Ha ocurrido un error durante el registro. Por favor, inténtalo de nuevo.'])
                ->withInput();
        }
    }
}
