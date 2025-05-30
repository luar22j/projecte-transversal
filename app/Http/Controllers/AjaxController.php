<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AjaxController extends Controller
{
    /**
     * Actualiza el stock de un producto
     */
    public function updateStock(Request $request, Producto $producto): JsonResponse
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $producto->update([
            'stock' => $request->stock
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stock actualizado correctamente',
            'producto' => $producto
        ]);
    }

    /**
     * Actualiza el precio de un producto
     */
    public function updatePrecio(Request $request, Producto $producto): JsonResponse
    {
        $request->validate([
            'precio' => 'required|numeric|min:0'
        ]);

        $producto->update([
            'precio' => $request->precio
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Precio actualizado correctamente',
            'producto' => $producto
        ]);
    }

    /**
     * Elimina un producto
     */
    public function deleteProducto(Producto $producto): JsonResponse
    {
        try {
            $producto->delete();
            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto'
            ], 500);
        }
    }

    /**
     * Actualiza la categoría de una subcategoría
     */
    public function updateSubcategoriaCategoria(Request $request, Subcategoria $subcategoria): JsonResponse
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        $subcategoria->update([
            'categoria_id' => $request->categoria_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada correctamente',
            'subcategoria' => $subcategoria
        ]);
    }
}
