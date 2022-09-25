@if($data_empresa)
 
<table class=" mt-1" width="100%" id="empresa">
    <tr>
        <th colspan="6">DATOS DE LA EMPRESA SOLICITANTE</th>
    </tr>
    <tr>
        <td class="cell-title" width="13%">Razon Social: </td>
        <td colspan="2">{{$data_empresa['razon_social']}}</td>
        <td width="13%" class="cell-title">NIT: </td>
        <td colspan="2">{{$data_empresa['nit_cedula']}}</td>
    </tr>
    <tr>
        <td class="cell-title">Telf./Cel.: </td>
        <td colspan="2">
            {{ $data_empresa['telefono'] }}
            @isset($data_empresa['celular'])
            <span> - {{$data_empresa['celular']}} </span>
            @endisset
        </td>
        <td class="cell-title">Ciudad/Pais: </td>
        <td colspan="2">{{ $data_empresa['ciudad'] }} - {{  $data_empresa['pais'] }}</td>
    </tr>
    <tr>
        <td class="cell-title" width="10%">Direccion: </td>
        <td colspan="2">{{$data_empresa['direccion']}}</td>
        <td class="cell-title" width="10%">Rubro: </td>
        <td colspan="2">{{$data_empresa['rubro']['nombre']}}</td>
    </tr>
</table>
@else
<div class="text-center">
    <p>No se pudo cargar la informacion de la EMPRESA</p>
</div>
@endif
