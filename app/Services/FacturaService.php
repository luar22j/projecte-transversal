<?php

namespace App\Services;

use App\Models\Pedido;
use App\Mail\FacturaMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class FacturaService
{
    public function generarFactura(Pedido $pedido)
    {
        // Cargar las relaciones necesarias
        $pedido->load(['user', 'detalles.producto', 'estado']);
        
        // Generar el PDF
        $pdf = PDF::loadView('facturas.pdf', ['pedido' => $pedido]);
        
        // Crear el directorio si no existe
        $directory = storage_path('app/public/facturas');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Guardar el PDF en storage
        $pdfPath = 'facturas/factura-' . $pedido->id . '.pdf';
        $fullPath = storage_path('app/public/' . $pdfPath);
        
        // Guardar el archivo
        file_put_contents($fullPath, $pdf->output());
        
        // Enviar el email con la factura
        Mail::to($pedido->user->email)->send(new FacturaMail($pedido, $fullPath));
        
        return $pdfPath;
    }

    public function descargarFactura(Pedido $pedido)
    {
        // Cargar las relaciones necesarias
        $pedido->load(['user', 'detalles.producto', 'estado']);
        
        $pdf = PDF::loadView('facturas.pdf', ['pedido' => $pedido]);
        return $pdf->download('factura-' . $pedido->id . '.pdf');
    }
} 