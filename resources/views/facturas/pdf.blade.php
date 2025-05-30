<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $pedido->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .company-info {
            float: left;
            width: 50%;
        }
        .client-info {
            float: right;
            width: 50%;
            text-align: right;
        }
        .clear {
            clear: both;
        }
        .order-details {
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURA</h1>
        <p>Número: {{ $pedido->id }}</p>
        <p>Fecha: {{ $pedido->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="company-info">
        <h3>Datos de la Empresa</h3>
        <p>Burgers & Roll</p>
        <p>Pl. de Catalunya, 5</p>
        <p>CIF: X12345678</p>
        <p>Email: info@burgersandroll.com</p>
        <p>Teléfono: 123 456 789</p>
    </div>

    <div class="client-info">
        <h3>Datos del Cliente</h3>
        <p>{{ $pedido->user->name }}</p>
        <p>{{ $pedido->direccion_envio }}</p>
        <p>{{ $pedido->user->email }}</p>
        <p>{{ $pedido->telefono }}</p>
    </div>

    <div class="clear"></div>

    <div class="order-details">
        <h3>Detalles del Pedido</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precio_unitario, 2) }}€</td>
                    <td>{{ number_format($detalle->subtotal, 2) }}€</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p>Subtotal: {{ number_format($pedido->subtotal, 2) }}€</p>
            <p>Envío: {{ $pedido->coste_envio == 0 ? 'Gratis' : number_format($pedido->coste_envio, 2) . '€' }}</p>
            <p>IVA (21%): {{ number_format(($pedido->subtotal + $pedido->coste_envio) * 0.21, 2) }}€</p>
            <p>Total: {{ number_format($pedido->total, 2) }}€</p>
        </div>
    </div>

    <div class="footer">
        <p>Gracias por su compra</p>
        <p>© {{ date('Y') }} Burgers & Roll. Todos los derechos reservados.</p>
    </div>
</body>
</html> 