<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pedido;

class FacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $pdfPath;

    public function __construct(Pedido $pedido, $pdfPath)
    {
        $this->pedido = $pedido;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Factura de tu pedido #' . $this->pedido->id)
                    ->view('emails.factura')
                    ->attach($this->pdfPath, [
                        'as' => 'factura-' . $this->pedido->id . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
} 