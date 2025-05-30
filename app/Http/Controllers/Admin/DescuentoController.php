<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Descuento;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DescuentoController extends Controller
{
    public function index(Request $request)
    {
        $descuentos = Descuento::with('productos')->latest()->get();
        
        if ($request->expectsJson()) {
            return response()->json($descuentos);
        }
        
        return view('admin.descuentos.index', compact('descuentos'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('admin.descuentos.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'productos' => 'required|array',
            'productos.*' => 'exists:productos,id'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $descuento = Descuento::create($request->except('productos'));
                $descuento->productos()->attach($request->productos);
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Descuento creado exitosamente',
                    'success' => true
                ]);
            }

            return redirect()->route('admin.descuentos.index')
                ->with('success', 'Descuento creado exitosamente.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Error al crear el descuento',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al crear el descuento');
        }
    }

    public function edit(Descuento $descuento)
    {
        $productos = Producto::select('id', 'nombre')->get();
        $productosSeleccionados = $descuento->productos->pluck('id')->toArray();
        return view('admin.descuentos.edit', compact('descuento', 'productos', 'productosSeleccionados'));
    }

    public function update(Request $request, Descuento $descuento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'productos' => 'required|array',
            'productos.*' => 'exists:productos,id'
        ]);

        try {
            DB::transaction(function () use ($request, $descuento) {
                $descuento->update($request->except('productos'));
                $descuento->productos()->sync($request->productos);
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Descuento actualizado exitosamente',
                    'success' => true
                ]);
            }

            return redirect()->route('admin.descuentos.index')
                ->with('success', 'Descuento actualizado exitosamente.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Error al actualizar el descuento',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el descuento');
        }
    }

    public function destroy(Descuento $descuento)
    {
        try {
            $descuento->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Descuento eliminado exitosamente',
                    'success' => true
                ]);
            }

            return redirect()->route('admin.descuentos.index')
                ->with('success', 'Descuento eliminado exitosamente.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Error al eliminar el descuento',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al eliminar el descuento');
        }
    }

    public function toggleActivo(Descuento $descuento)
    {
        try {
            $descuento->update(['activo' => !$descuento->activo]);

            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Estado del descuento actualizado exitosamente',
                    'success' => true,
                    'descuento' => $descuento
                ]);
            }

            return redirect()->route('admin.descuentos.index')
                ->with('success', 'Estado del descuento actualizado exitosamente.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Error al actualizar el estado del descuento',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el estado del descuento');
        }
    }
} 