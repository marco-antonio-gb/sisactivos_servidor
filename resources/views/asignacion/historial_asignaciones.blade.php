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
    <table width="100%">
        <tr style="border: none !important;">
            <td style="border: none !important;" width="33%">
                <img src="{{ url('/images/logomisecofin.png') }}" alt="" width="150">
            </td>
            <td style="border: none !important;" width="33%">
                <div class="text-center">
                    <h2 ><strong>HISTORIAL</strong></h2>
					<h3>ASIGNACION INDIVIDUAL DE BIENES</h3>

                </div>
            </td>
            <td style="border: none !important;text-align:right;" width="33%">
                {{-- <p class="m-1">FECHA: {{ strtoupper($datos['creado']) }}</p> --}}
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
                    <span>{{ $datos['unidad'] }}</span>
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
                    <span>{{ $datos['unidad'] }}</span>
                </td>
            </tr>
        </table>
    </div>
    @if (count($datos['detalle_asignacion']) > 0)
        @foreach ($datos['detalle_asignacion'] as $asignacion)
            <table class="mt-1" width="100%">
                <tr>
                    <td class="text-center cell-title" width="115px">CODIGO</td>
                    <td class="text-center cell-title">UNIDAD</td>
                    <td class="text-center cell-title">DESCRIPCION / DETALLE</td>
                    <td class="text-center cell-title" width="30px">ESTADO</td>
                </tr>
                @foreach ($asignacion['detalle_asignacion'] as $detalle)
                    <tr>
                        <td class="text-center">{{ $detalle->articulo->codigo }}</td>
                        <td class="text-center">{{ $detalle->articulo->unidad }}</td>
                        <td>{{ $detalle->articulo->descripcion }} <br> <strong>DETALLE:
                                {{ $detalle->detalle }}</strong>
                        </td>
                        <td style="text-transform: uppercase;">{{ $detalle->articulo->estado }}</td>
                    </tr>
                @endforeach
            </table>
            <strong>Cantidad: {{ count($asignacion['detalle_asignacion']) }} Items</strong>
			<br><br>
        @endforeach
    @else
        <div class="text-center">
            <h1>* ERROR *</h1>
            <p>No se pudo cargar la informacion de la Asignacion</p>
        </div>
    @endif
    {{-- <div style="font-size: 10pt !important;margin-top:15px;text-align:justify;">
        <p>El servidor publico queda prohibido de usar o permitir el uso de los bienes para beneficio particular o
            privado, prestar o transferir el bien a otro empleado publico, dañar o averiar sus caracteristicas fisicas o
            tecnicas, poner en riesgo el bien, ingresar o sacar bienes particulares sin autorizacion de la Unidad o
            Responsable de Activos Fijos.</p>
        <p>La no obediencia a estas prohibiciones generara responsabilidades establecidas en la Ley Nro. 1178 y sus
            reglamentos.</p>
        <p>En señal de conformidad y aceptacion se firma el siguiente acta.</p>
    </div> --}}
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table class="text-center no-border ">
        <tr>
            <td class="no-border ">
                <strong>{{ $datos['responsable_activos'] }}</strong>
                <p>RESPONSABLE ACTIVOS FIJOS</p>
            </td>
            {{-- <td class="no-border ">
                <strong>{{$datos['funcionario']}}</strong>
                <p>TEC. OPERADOR</p>
            </td> --}}
            <td class="no-border ">
                <strong>{{ $datos['responsable']['nombre_completo'] }}</strong>
                <p>RECIBI CONFORME</p>
            </td>
        </tr>
    </table>

</body>

</html>
