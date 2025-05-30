<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'producto' => 'required|string',
            'consulta' => 'required|string|max:150',
            'nombre' => 'required_if:user_id,null|string|min:2|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required_if:user_id,null|string|min:2|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'email' => 'required_if:user_id,null|email',
        ], [
            'producto.required' => 'El campo producto es obligatorio',
            'consulta.required' => 'El campo consulta es obligatorio',
            'consulta.max' => 'La consulta no puede tener más de 150 caracteres',
            'nombre.required_if' => 'El nombre es obligatorio',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'apellidos.required_if' => 'Los apellidos son obligatorios',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras y espacios',
            'email.required_if' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Buscar el producto
        $producto = Producto::where('nombre', 'like', '%' . $request->producto . '%')
            ->orWhere('referencia', 'like', '%' . $request->producto . '%')
            ->first();

        if (!$producto) {
            return response()->json([
                'success' => false,
                'errors' => ['producto' => ['No se encontró ningún producto con esa referencia']]
            ], 422);
        }

        // Crear la consulta
        $consulta = new Consulta();
        $consulta->producto_id = $producto->id;
        $consulta->consulta = $request->consulta;

        if (Auth::check()) {
            $consulta->user_id = Auth::id();
            $consulta->nombre = Auth::user()->nombre;
            $consulta->apellidos = Auth::user()->apellidos;
            $consulta->email = Auth::user()->email;
        } else {
            $consulta->nombre = $request->nombre;
            $consulta->apellidos = $request->apellidos;
            $consulta->email = $request->email;
        }

        $consulta->save();

        return response()->json([
            'success' => true,
            'message' => 'Consulta enviada correctamente'
        ]);
    }
} 