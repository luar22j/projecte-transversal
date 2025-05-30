<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Subcategoria;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index()
    {
        $productos = Producto::where('stock', '>', 0)->get();
        return view('marketplace.index', compact('productos'));
    }

    public function menus()
    {
        $productos = Producto::where('categoria_id', 1)
            ->where('stock', '>', 0)
            ->get();
        return view('marketplace.menus', compact('productos'));
    }

    public function burgers()
    {
        $productos = Producto::where('categoria_id', 2)
            ->where('stock', '>', 0)
            ->get();
        return view('marketplace.burgers', compact('productos'));
    }

    public function bebidas()
    {
        $productos = Producto::where('categoria_id', 3)
            ->where('stock', '>', 0)
            ->get();
        return view('marketplace.bebidas', compact('productos'));
    }

    public function postres()
    {
        $productos = Producto::where('categoria_id', 4)
            ->where('stock', '>', 0)
            ->get();
        return view('marketplace.postres', compact('productos'));
    }
} 