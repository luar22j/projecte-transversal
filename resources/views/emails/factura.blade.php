<!DOCTYPE html>
<html>
<head>
    <title>Factura de tu pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .order-details {
            margin-bottom: 20px;
        }
        .product-list {
            margin-bottom: 20px;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Gracias por tu compra!</h1>
            <p>Hola {{ $pedido->user->nombre }},</p>
            <p>Adjunto encontrarás la factura de tu pedido #{{ $pedido->id }}.</p>
        </div>

        <div class="order-details">
            <h2>Detalles del pedido:</h2>
            <p><strong>Número de pedido:</strong> {{ $pedido->id }}</p>
            <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Estado:</strong> {{ $pedido->estado->nombre }}</p>
        </div>

        <div class="product-list">
            <h3>Productos:</h3>
            @foreach($pedido->detalles as $detalle)
                <p>{{ $detalle->producto->nombre }} - {{ $detalle->cantidad }} x {{ number_format($detalle->precio_unitario, 2) }}€</p>
            @endforeach
        </div>

        <div class="total">
            <p><strong>Subtotal:</strong> {{ number_format($pedido->subtotal, 2) }}€</p>
            <p><strong>Envío:</strong> {{ $pedido->coste_envio == 0 ? 'Gratis' : number_format($pedido->coste_envio, 2) . '€' }}</p>
            <p><strong>IVA (21%):</strong> {{ number_format(($pedido->subtotal + $pedido->coste_envio) * 0.21, 2) }}€</p>
            <p><strong>Total:</strong> {{ number_format($pedido->total, 2) }}€</p>
        </div>

        <div class="footer">
            <p>Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos.</p>
            <p>© {{ date('Y') }} Burgers & Roll. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html> 