<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Producto;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index(): View
    {
        return view('pages.home');
    }

    /**
     * Handle the contact form submission.
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'nombre' => 'required_if:auth,false|string|min:2|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required_if:auth,false|string|min:2|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'email' => 'required_if:auth,false|email',
            'producto' => 'required|string',
            'consulta' => 'required|string|max:150',
        ]);

        // Verificar que el producto existe
        $producto = Producto::where('nombre', 'like', '%' . $request->producto . '%')
            ->orWhere('referencia', 'like', '%' . $request->producto . '%')
            ->first();

        if (!$producto) {
            return back()->withErrors(['producto' => 'El producto no existe']);
        }

        // Aquí iría la lógica para enviar el email o guardar la consulta en la base de datos

        return redirect()->back()->with('success', 'Consulta enviada correctamente');
    }
} 