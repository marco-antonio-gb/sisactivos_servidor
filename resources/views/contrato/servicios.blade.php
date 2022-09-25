@if(count($data_servicios) > 0)
<small class=" mt-1">Servicios adicionales</small>
<table  width="100%">
    <tr>
        <td class="cell-title" >Concepto</td>
        <td class="text-center cell-title" width="20%">Unidad</td>
        <td class="text-center cell-title" width="10%">Cantidad</td>
        <td class="text-center cell-title" width="20%">Precio Unitario [Bs.]</td>
        <td class="text-right  cell-title" width="13%">SubTotal [Bs.]</td>
    </tr>
    @php($total = 0)
    @foreach ($data_servicios as $servicio)
    <tr>
        <td >{{ $servicio->servicio }}</td>
        <td class="text-center">{{ $servicio->unidad }}</td>
        <td class="text-center">{{ $servicio->cantidad }}</td>
        <td class="text-center">{{ $servicio->precio_unitario }}</td>
        <td class="text-right" >{{ number_format(($servicio->precio_unitario*$servicio->cantidad), 2, ',', '.') }}</td>
    </tr>
    @php($total += ($servicio->precio_unitario*$servicio->cantidad))
    @endforeach
    <tr>
        <td colspan="4" class="font-bold text-right">(B)* TOTAL OTROS SERVICIOS</td>
        <td  class="font-bold text-right cell-title">{{number_format($total, 2, ',', '.')}}</td>
    </tr>
</table>
@endif
