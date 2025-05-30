<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::withCount('subcategorias')
            ->orderBy('nombre')
            ->paginate(10);

        if ($request->expectsJson()) {
            return response()->json($categorias);
        }

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->slug = Str::slug($request->nombre);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/categorias', $nombreImagen);
            $categoria->imagen = 'categorias/' . $nombreImagen;
        }

        $categoria->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Categoría creada correctamente',
                'categoria' => $categoria
            ]);
        }

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada correctamente');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->slug = Str::slug($request->nombre);

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($categoria->imagen) {
                Storage::delete('public/' . $categoria->imagen);
            }

            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/categorias', $nombreImagen);
            $categoria->imagen = 'categorias/' . $nombreImagen;
        }

        $categoria->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Categoría actualizada correctamente',
                'categoria' => $categoria
            ]);
        }

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(Categoria $categoria)
    {
        // Eliminar imagen si existe
        if ($categoria->imagen) {
            Storage::delete('public/' . $categoria->imagen);
        }

        $categoria->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Categoría eliminada correctamente'
            ]);
        }

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada correctamente');
    }
} 