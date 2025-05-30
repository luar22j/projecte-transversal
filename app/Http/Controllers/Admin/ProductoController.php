<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Subcategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with(['subcategoria.categoria', 'categoria'])
            ->select('id', 'nombre', 'precio', 'stock', 'imagen', 'subcategoria_id', 'categoria_id');

        if ($request->expectsJson()) {
            $productos = $query->get();
            return response()->json([
                'data' => $productos
            ]);
        }

        $productos = $query->paginate(10);
        $subcategorias = Subcategoria::with('categoria')->get();
        $categorias = Categoria::all();
        return view('admin.productos.index', compact('productos', 'subcategorias', 'categorias'));
    }

    public function create()
    {
        $subcategorias = Subcategoria::with('categoria')->get();
        $categorias = Categoria::all();
        return view('admin.productos.create', compact('subcategorias', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('images'), $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        Producto::create($data);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function show(Producto $producto)
    {
        $producto->load(['subcategoria.categoria', 'categoria']);
        return response()->json($producto);
    }

    public function edit(Producto $producto)
    {
        $subcategorias = Subcategoria::with('categoria')->get();
        $categorias = Categoria::all();
        return view('admin.productos.edit', compact('producto', 'subcategorias', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen && file_exists(public_path('images/' . $producto->imagen))) {
                unlink(public_path('images/' . $producto->imagen));
            }

            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('images'), $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        $producto->update($data);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->imagen && file_exists(public_path('images/' . $producto->imagen))) {
            unlink(public_path('images/' . $producto->imagen));
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    public function updatePrecio(Request $request, Producto $producto)
    {
        $request->validate([
            'precio' => 'required|numeric|min:0'
        ]);

        $producto->update(['precio' => $request->precio]);

        return response()->json([
            'message' => 'Precio actualizado correctamente',
            'producto' => $producto
        ]);
    }

    public function updateStock(Request $request, Producto $producto)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $producto->update(['stock' => $request->stock]);

        return response()->json([
            'message' => 'Stock actualizado correctamente',
            'producto' => $producto
        ]);
    }

    public function updateSubcategoria(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        $subcategorias = Subcategoria::where('categoria_id', $request->categoria_id)->get();
        return response()->json($subcategorias);
    }
} 