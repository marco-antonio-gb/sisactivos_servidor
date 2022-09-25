@if(count($data_espacios) > 0)
<table class=" mt-1" width="100%">
    <tr>
        <th colspan="7">REQUERIMIENTOS DEL CLIENTE</th>
    </tr>
    <tr>
        <td class='rotate cell-title' rowspan="{{count($data_espacios)+2}}">
            <div>Espacios</div>
        </td>
        <td class="cell-title">Lugar</td>
        <td class="text-center cell-title" width="20%">Nro. Stand/Espacio</td>
        <td class="text-center cell-title" width="20%">Superficie m <sup style="font-size: 6.5pt !important">2</sup></td>
        <td class="text-center cell-title" width="15%">Nro. Credenciales</td>
        <td class="text-center cell-title" width="20%">Precio Unitario [Bs.]</td>
        <td class="text-right  cell-title" width="13%">SubTotal [Bs.]</td>
    </tr>
    @php($total = 0)
    @foreach ($data_espacios as $espacio)
    <tr>
        <td>{{ $espacio->layout['layout_name'] }}</td>
        <td class="text-center">{{ $espacio->numero }}</td>
        <td class="text-center">{{ $espacio->superficie }}</td>
        <td class="text-center">{{ $espacio->credenciales }}</td>
        <td class="text-center">{{ number_format($espacio->precio, 2, ',', '.') }}</td>
        <td class="text-right">{{ number_format($espacio->precio, 2, ',', '.') }}</td>
    </tr>
    @php($total += $espacio->precio)
    @endforeach
    <tr>
        <td colspan="5" class="font-bold text-right">(A)* TOTAL AREA SOLICITADA</td>
        <td colspan="1" class="font-bold text-right cell-title">{{number_format($total, 2, ',', '.')}}</td>
    </tr>
</table>
@else
<div class="text-center">
    <p>No se pudo cargar la informacion de los ESPACIOS</p>
</div>
@endif
