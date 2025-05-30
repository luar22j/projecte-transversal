<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class GraficoController extends Controller
{
    public function ventas()
    {
        $productos = Producto::select('productos.nombre')
            ->selectRaw('COALESCE(SUM(detalles_pedido.cantidad), 0) as total_ventas')
            ->leftJoin('detalles_pedido', 'productos.id', '=', 'detalles_pedido.producto_id')
            ->groupBy('productos.id', 'productos.nombre')
            ->orderBy('total_ventas', 'desc')
            ->get();
        
        // Arrays de datos
        $dades = array_values($productos->pluck('total_ventas')->toArray());
        $datosLeyenda = array_values($productos->pluck('nombre')->toArray());
        
        // Generar colores dinámicamente
        $colors = [
            "lightgreen",
            "red",
            "green",
            "magenta",
            "blue",
            "yellow",
            "purple",
            "orange",
            "cyan",
            "pink",
            "brown",
            "gray",
            "lime",
            "teal",
            "indigo"
        ];
        
        // Si hay más productos que colores, generamos colores aleatorios
        while (count($colors) < count($dades)) {
            $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        
        // Aseguramos que tengamos exactamente el mismo número de colores que de datos
        $colors = array_slice($colors, 0, count($dades));
        
        return view('admin.grafico.ventas', compact('dades', 'datosLeyenda', 'colors'));
    }
} 