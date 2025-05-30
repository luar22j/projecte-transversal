@extends('layouts.admin')

@section('content')
<div class="admin-panel">
    <h1>Gráfico de Ventas por Producto</h1>
    <div class="graficos">
        <canvas id="grafico"></canvas>
        <canvas id="leyenda"></canvas>
    </div>
</div>

@push('styles')
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 10px;
    }

    .graficos {
        display: flex;
        gap: 20px;
        margin: 20px 0;
    }
</style>
@endpush

@push('scripts')
<script defer>
    let dades = @json($dades);
    let colors = @json($colors);
    let datosLeyenda = @json($datosLeyenda);

    const grafico = document.getElementById("grafico");
    const ctxGrafico = grafico.getContext("2d");

    grafico.style.border = "1px solid white";

    var yTotal = Math.max(...dades);
    var yTotalMultiplicado = Math.max(...dades) * 4.5;

    var xTotal = dades.length;
    var xTotalMultiplicado = xTotal * 70;

    grafico.height = yTotalMultiplicado;
    grafico.width = xTotalMultiplicado;

    function lineas() {
        let y = yTotalMultiplicado - 20;
        let lineas = yTotal / 10;
        lineas++;

        let numeros = [];
        let numero = 0;
        for (let i = 0; i < lineas; i++) {
            numeros[i] = numero;
            numero += 10;
        }

        ctxGrafico.save();
        for (let i = 0; i < lineas; i++) {
            ctxGrafico.beginPath();
            ctxGrafico.lineTo(0, y);
            ctxGrafico.lineTo(xTotalMultiplicado, y);
            ctxGrafico.fillStyle = "white";
            ctxGrafico.fillText(numeros[i], 2, y - 2);
            ctxGrafico.strokeStyle = "white";
            ctxGrafico.stroke();

            y -= 40;
        }
        ctxGrafico.restore();
    }

    function columnas() {
        let x = 30;

        ctxGrafico.save();
        for (let i = 0; i < dades.length; i++) {
            ctxGrafico.beginPath();
            ctxGrafico.fillStyle = colors[i];
            ctxGrafico.fillRect(x, yTotalMultiplicado - 20, 60, -dades[i] * 4);
            ctxGrafico.closePath();

            x += 65;
        }
        ctxGrafico.restore();
    }

    function texto() {
        ctxGrafico.save();
        var centerX = grafico.width / 2;
        ctxGrafico.textAlign = "center";

        ctxGrafico.font = "bold 12px Verdana";
        ctxGrafico.fillStyle = "white";
        ctxGrafico.fillText("Ventas por Producto", centerX, grafico.height - 5);
        ctxGrafico.restore();
    }

    const leyenda = document.getElementById("leyenda");
    const ctxLeyenda = leyenda.getContext("2d");

    leyenda.width = datosLeyenda.length * 40;
    leyenda.height = datosLeyenda.length * 27;

    function lista() {
        let altura = 5;
        ctxLeyenda.save();
        for (let i = 0; i < dades.length; i++) {
            ctxLeyenda.fillStyle = colors[i];
            ctxLeyenda.fillRect(10, altura, 20, 20);
            ctxLeyenda.font = "bold 12px Verdana";
            ctxLeyenda.fillStyle = "white";
            ctxLeyenda.fillText(
                datosLeyenda[i] + " (" + dades[i] + " unidades)",
                40,
                altura + 15
            );
            altura += 25;
        }
        ctxLeyenda.restore();
    }

    // Inicializar el gráfico
    lineas();
    columnas();
    texto();
    lista();
</script>
@endpush
@endsection 