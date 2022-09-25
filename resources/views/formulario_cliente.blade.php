<?php
    $total_espacios=0;
    $total_servicios=0;
    foreach ($formulario['data']['espacios'] as $key => $espacio) {
        $total_espacios += $espacio->precio;
    }
    foreach ($formulario['data']['servicios'] as $key => $servicio) {
        $total_servicios += ($servicio->precio_unitario*$servicio->cantidad);
    }
    $total_general=$total_espacios+$total_servicios;
    $current = Carbon\Carbon::now('America/La_Paz');
    $translateTime = Carbon\Carbon::parse($current)->translatedFormat('l  j \d\e F \d\e\l Y');
    $GLOBALS['usuario'] = $formulario['data']['usuario']['nombres'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ asset('/css/pdf.css') }}" media="all" />
    <title>Formulario Participacion</title>
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
            $text2 =$GLOBALS["usuario"].' - '. date('d/m/Y h:i:s a');
            $width = $fontMetrics->get_text_width($text2, $font, $size) / 2;
            $x2 = ($pdf->get_width() - $width) - ($pdf->get_width()-115);
            $y2 = $pdf->get_height() - 40;
            $pdf->page_text($x2, $y2, $text2, $font, $size,$color);
            $x3 = ($pdf->get_width() - $width) /2;
            {{-- $pdf->page_text($x3, $y, $GLOBALS["usuario"], $font, $size, $color); --}}
        }
    </script>
    {{-- TITULO FORMULARIO --}}
    <div class="text-center mb-2">
        <p class="titulo uderline  m-1">FORMULARIO DE REGISTRO - {{strtoupper($formulario['data']['evento']['nombre'])}}</p>
        <p class="m-1">{{$formulario['data']['codigo']}}</p>
    </div>
    {{-- EMRPESA --}}
    @if($secciones['empresa'])
    @include('formulario.empresa',['data_empresa'=>$formulario['data']['empresa']])
    @endif
    {{-- PERSONA DE CONTACTO y FIRMA CONTRATO --}}
    @if($secciones['contacto'])
    @include('formulario.persona_contacto',['data_contacto'=>$formulario['data']['empresa']['contactos']])
    @endif
    {{-- SOBRE EL CONCEPTO DEL INGRESO --}}
    @if($secciones['empresa'])
    @include('formulario.ingreso',['data_empresa'=>$formulario['data']['empresa']])
    @endif
    {{-- ESPACIOS --}}
    @if($secciones['espacios'])
    @include('formulario.espacios',['data_espacios'=>$formulario['data']['espacios']])
    @endif
    {{-- SERVICIOS --}}
    @if($secciones['servicios'])
    @include('formulario.servicios',['data_servicios'=>$formulario['data']['servicios']])
    @endif
    {{-- TOTAL PAGOS --}}
    <table class=" mt-1" width="100%">
        <tr>
            <th class="text-left p-15" width="20%">TOTAL A PAGAR (A+B): </th>
            <th class="text-left p-15" width="20%">Numeral: {{number_format($total_general, 2, ',', '.')}} </th>
            <th class="text-left p-15">Literal: {{NumeroLetras::convertir($total_general,$currency = 'BOLIVIANOS', $format = true, $decimals = '2')}} </th>
        </tr>
    </table>
    {{-- NOTA 1 --}}
    <table class=" mt-1" width="100%">
        <tr class="text-center ">
            <td class="p-1">La presente solicitud de participacion no sera valida mientras no se abone el pago de anticipo y se verifique su legalidad</td>
        </tr>
    </table>
    {{-- FACTURACION --}}
    <table class=" mt-1" width="100%">
        <tr>
            <th colspan="4">DATOS PARA LA FACTURA</th>
        </tr>
        <tr>
            <td class="cell-title" width="15%">NIT:</td>
            <td>{{ $formulario['data']['factura_nit'] }}</td>
            <td class="cell-title" width="20%">Nombre o razon social:</td>
            <td>{{ $formulario['data']['factura_nombre'] }}</td>
        </tr>
    </table>
    {{-- PLAN DE  PAGOS --}}
    <table class=" mt-1" width="100%">
        <tr>
            <th colspan="4">REGISTRO DE PAGOS</th>
        </tr>
        <tr>
            <td class="cell-title" width="20%">TOTAL A PAGAR (Bs.)</td>
            <td colspan="3" class="font-bold">{{number_format($total_general, 2, ',', '.')}} Bs.</td>
        </tr>
        <tr>
            <td class="cell-title">Nro. Cuota</td>
            <td class="cell-title">Fecha</td>
            <td class="cell-title">Monto [Bs.]</td>
            <td class="cell-title">Saldo [Bs.]</td>
        </tr>
        @foreach($formulario['data']['pagos'] as $key => $pago)
        <tr>
            <td>Cuota {{$key+1}}</td>
            <td>{{$pago['fecha']}}</td>
            <td>{{ number_format($pago['monto'], 2, ',', '.') }}</td>
            <td>{{ number_format($pago['saldo'], 2, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>
    {{-- NOTA 2 --}}
    <table class="mt-1" width="100%">
        <tr>
            <td colspan="4" class=" disclaimer"> EL PRESENTE FORMULARIO TIENE CARÁCTER DE UN ACUERDO ENTRE PARTES Y DECLARACION JURADA, POR LO QUE LA INFORMACIÓN CONSIGNADA TIENE PLENA VALIDEZ, ES REAL Y FIDEDIGNA Y SERÁ DE ESTRICTO CUMPLIMIENTO ENTRE PARTES SIENDO EL MISMO INSTRUMENTO VÁLIDO DE COBRANZA A SOLA FIRMA DE AMBAS PARTES, ASUMIENDO COMPROMISO PARA EL CUMPLIMIENTO DE LAS CONDICIONES ESTABLECIDAS ENTRE PARTES, LAS NORMAS LEGALES Y DE BIOSEGURIDAD, DESTINDANDO RESPONSABILIDAD AL CAMPO FERIAL POR PRODUCTOS Y/O ACTIVIDADES NO DECLARADAS Y REALIZADAS POR EL CLIENTE.</td>
        </tr>
    </table>
    {{-- INTERCAMBIO SERVICIOS --}}
    @if($formulario['data']['intercambio_campoferial'])
    <table class="mt-1" width="100%">
        <tr>
            <th class="text-center" colspan="2">INTERCAMBIO DE SERVICIOS</th>
        </tr>
        <tr>
            <td class="cell-title" width="50%">Del Campo Ferial 3 de Julio</td>
            <td class="cell-title" width="50%">Del Expositor</td>
        </tr>
        <tr>
            <td width="50%">{{$formulario['data']['intercambio_campoferial']}}</td>
            <td width="50%">{{$formulario['data']['intercambio_empresa']}}</td>
        </tr>
    </table>
    @endif
    {{-- FIRMAS --}}
    <table class="text-center  width-100pc mt-2" width="100%">
        <tr>
            <td colspan="12" class="text-center no-border">Oruro, {{ ucfirst(trans($translateTime)) }}</td>
        </tr>
        <tr>
            <td width="50%" class="no-border"><br><br><br><br> <br>Firma y nombre del Solicitante</td>
            <td width="50%" class="no-border"><br><br><br><br> <br>Firma y nombre de la Ejecutiva comercial CF3J</td>
        </tr>
    </table>
</body>
</html>
