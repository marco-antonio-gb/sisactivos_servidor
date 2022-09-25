@if($data_empresa)
 
<table class=" mt-1" width="100%">
    <tr>
        <th colspan="2">SOBRE EL CONCEPTO DEL INGRESO</th>
    </tr>
    <tr>
        <td class="cell-title" width="25%">Producto y/o servicio a Ofertar:</td>
        <td>{{ $data_empresa['oferta'] }}</td>
    </tr>
    <tr>
        <td class="cell-title">Producto y/o servicio a Demandar:</td>
        <td>{{ $data_empresa['demanda'] }}</td>
    </tr>
    <tr>
        <td width="13%" class="cell-title">Horarios:</td>
        <td>  </td>
    </tr>
</table>
@else
<div class="text-center">
    <p>No se pudo cargar la informacion del CONCEPTO del INGRESO</p>
</div>
@endif
