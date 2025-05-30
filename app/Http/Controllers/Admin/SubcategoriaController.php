<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubcategoriaController extends Controller
{
    public function index(Request $request)
    {
        $subcategorias = Subcategoria::with(['categoria'])
            ->withCount('productos')
            ->orderBy('nombre')
            ->paginate(10);

        $categorias = Categoria::orderBy('nombre')->get();

        if ($request->expectsJson()) {
            return response()->json($subcategorias);
        }

        return view('admin.subcategorias.index', compact('subcategorias', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('admin.subcategorias.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:subcategorias',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $subcategoria = new Subcategoria();
        $subcategoria->nombre = $request->nombre;
        $subcategoria->categoria_id = $request->categoria_id;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/subcategorias', $nombreImagen);
            $subcategoria->imagen = 'subcategorias/' . $nombreImagen;
        }

        $subcategoria->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Subcategoría creada correctamente',
                'subcategoria' => $subcategoria
            ]);
        }

        return redirect()->route('admin.subcategorias.index')
            ->with('success', 'Subcategoría creada correctamente');
    }

    public function edit(Subcategoria $subcategoria)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('admin.subcategorias.edit', compact('subcategoria', 'categorias'));
    }

    public function update(Request $request, Subcategoria $subcategoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:subcategorias,nombre,' . $subcategoria->id,
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $subcategoria->nombre = $request->nombre;
        $subcategoria->categoria_id = $request->categoria_id;

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($subcategoria->imagen) {
                Storage::delete('public/' . $subcategoria->imagen);
            }

            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/subcategorias', $nombreImagen);
            $subcategoria->imagen = 'subcategorias/' . $nombreImagen;
        }

        $subcategoria->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Subcategoría actualizada correctamente',
                'subcategoria' => $subcategoria
            ]);
        }

        return redirect()->route('admin.subcategorias.index')
            ->with('success', 'Subcategoría actualizada correctamente');
    }

    public function updateCategoria(Request $request, Subcategoria $subcategoria)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        $subcategoria->update($validated);

        return response()->json([
            'message' => 'Categoría actualizada correctamente',
            'subcategoria' => $subcategoria
        ]);
    }

    public function destroy(Subcategoria $subcategoria)
    {
        // Eliminar imagen si existe
        if ($subcategoria->imagen) {
            Storage::delete('public/' . $subcategoria->imagen);
        }

        $subcategoria->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Subcategoría eliminada correctamente'
            ]);
        }

        return redirect()->route('admin.subcategorias.index')
            ->with('success', 'Subcategoría eliminada correctamente');
    }
} 