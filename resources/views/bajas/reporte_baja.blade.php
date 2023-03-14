<?php
$current = Carbon\Carbon::now('America/La_Paz');
$translateTime = Carbon\Carbon::parse($current)->translatedFormat(' j \d\e F \d\e Y');
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
    <title>Reporte baja</title>
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
    <table width="100%">
        <tr style="border: none !important;">
            <td style="border: none !important;" width="33%">
                <img src="{{ url('/images/logomisecofin.png') }}" alt="" width="150">
            </td>
            <td style="border: none !important;" width="33%">
                <div class="text-center">
                    <p class="titulo    m-1">REPORTE BAJA ARTICULO</p>
                </div>
            </td>
            <td style="border: none !important;text-align:right;" width="33%">
                <p class="m-1">FECHA: {{ strtoupper($datos['baja']['creado']) }}</p>
            </td>
        </tr>
    </table>
    <div style="margin-top:10px;margin-bottom:10px; border-bottom: 1px solid #9b9b9b;">
        <table width="100%">
            <tr>
                <th style="border: none !important;" class="text-left">
                    <span>ENTIDAD: </span>
                </th>
                <th style="border: none !important;" class="text-left">
                    <span>CENTRO DE SALUD INTEGRAL VINTO</span>
                </th>
                <th style="border: none !important;" class="text-left">
                    <span>UNIDAD:</span>
                </th>
                <th style="border: none !important;" class="text-left">
                    <span>{{ $datos['servicio']['nombre'] }}</span>
                </th>
            </tr>
            <tr>
                <td style="border: none !important;"></td>
            </tr>
            <tr>
                <td style="border: none !important;">
                    <strong>RESPONSABLE:</strong>
                </td>
                <td style="border: none !important;">
                    <span>{{ $datos['responsable']['nombre_completo'] }}</span>
                </td>
                <td style="border: none !important;">
                    <strong>CI:</strong>
                </td>
                <td style="border: none !important;">
                    <span>{{ $datos['responsable']['cedula'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="border: none !important;">
                    <strong>CARGO:</strong>
                </td>
                <td style="border: none !important;">
                    <span>{{ $datos['responsable']['cargo'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="border: none !important;">
                    <strong>OFICINA:</strong>
                </td>
                <td style="border: none !important;">
                    <span>{{ $datos['servicio']['nombre'] }}</span>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <strong>Articulo</strong>
        <p>Articulo: {{ $datos['articulo']['nombre'] }} ({{ $datos['articulo']['codigo'] }})</h1>
        <p>Descripcion: {{ $datos['articulo']['descripcion'] }}</p>
        <p>Fecha registro: {{ $datos['articulo']['fecha_registro'] }}</p>
        <br>
        <br>
        <strong>Detalle baja</strong>
        <p>Motivo: {{ $datos['detalle_baja']['motivo'] }}</p>
        <p>Informe baja: {{ $datos['detalle_baja']['informebaja'] }}</p>
        <p>Fecha: {{ $datos['detalle_baja']['fecha_hora'] }}</p>
        <br>
        <br>
        <strong>Responsable</strong>
        <p>Nombre: {{ $datos['responsable']['nombre_completo'] }} ({{ $datos['responsable']['cedula'] }})</p>
        <p>Cargo : {{ $datos['responsable']['cargo'] }}</p>
        <br>
        <br>
        <strong>Usuario</strong>
        <p>Nombre: {{ $datos['usuario']['nombre_completo'] }}</p>
        <p>Cargo: {{ $datos['usuario']['cargo'] }}</p>
    </div>
    {{-- <table class="text-center no-border ">
        <tr>
            <td class="no-border ">
                <strong>{{$datos['responsable_activos']}}</strong>
                <p>RESPONSABLE ACTIVOS FIJOS</p>
            </td>
            <td class="no-border ">
                <strong>{{$datos['funcionario']}}</strong>
                <p>TEC. OPERADOR</p>
            </td>
            <td class="no-border ">
                <strong>{{$datos['responsable']['nombre_completo']}}</strong>
                <p>RECIBI CONFORME</p>
            </td>
        </tr>
    </table> --}}
</body>

</html>