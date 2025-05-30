<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function getUserData(Request $request)
    {
        try {
            if (!$request->user()) {
                return response()->json([
                    'error' => 'Usuario no autenticado'
                ], 401);
            }

            return response()->json([
                'name' => $request->user()->nombre,
                'email' => $request->user()->email,
                'id' => $request->user()->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener datos del usuario',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 