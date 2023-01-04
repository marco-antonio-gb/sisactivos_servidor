<?php
$current = Carbon\Carbon::now('America/La_Paz');
$translateTime = Carbon\Carbon::parse($current)->translatedFormat('l  j \d\e F \d\e\l Y');
$GLOBALS['usuario'] = 'Impreso: ';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ asset('/css/pdf.css') }}" media="all" />
    <title>Reporte Articulos</title>
</head>
<body>
    <script type="text/php">
        if (isset($pdf)) {
            $color = array(0.476, 0.476, 0.476);
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $size = 8;
            $font = $fontMetrics->getFont("sans-serif" );
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) - 20;
            $y = $pdf->get_height() - 40;
            $pdf->page_text($x, $y, $text, $font, $size,$color);
            $text2 =$GLOBALS["usuario"].''. date('d/m/Y h:i:s a');
            $width = $fontMetrics->get_text_width($text2, $font, $size) / 2;
            $x2 = ($pdf->get_width() - $width) - ($pdf->get_width()-105);
            $y2 = $pdf->get_height() - 40;
            $pdf->page_text($x2, $y2, $text2, $font, $size,$color);
            $x3 = ($pdf->get_width() - $width) /2;
            {{-- $pdf->page_text($x3, $y, $GLOBALS["usuario"], $font, $size, $color); --}}
        }
    </script>
    {{-- TITULO FORMULARIO --}}
    <div class="text-center mb-3">
        <p class="titulo uderline  m-1">CENTRO DE SALUD "VINTO"</p>
        <p class="m-1">DR. EDWIN BORIS VARGAS FLORES</p>
        <p class="m-1">Reporte de Articulos</p>
    </div>
    @if (count($articulos) > 0)
        <table class=" mt-1" width="100%">
            <tr>
                <td class="text-center cell-title" width="115px">CODIGO</td>
                <td class="text-center cell-title" >UNIDAD</td>
                <td class="text-center cell-title" >DESCRIPCION</td>
                <td class="text-center cell-title" width="30px">ESTADO</td>
            </tr>
            @foreach ($articulos as $articulo)
                <tr>
                    <td class="text-center">{{ $articulo->codigo }}</td>
                    <td class="text-center">{{ $articulo->unidad }}</td>
                    <td>{{ $articulo->descripcion }}</td>
                    <td style="text-transform: uppercase;">{{ $articulo->estado }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <div class="text-center">
            <p>No se pudo cargar la informacion de los Articulos</p>
        </div>
    @endif
</body>
</html>
