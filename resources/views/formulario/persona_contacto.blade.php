<?php 
    $contacto="";
    $contrato="";
    $error=array();
    foreach ($data_contacto as $key => $value) {
        if(slugify($value['tipo'])==="persona-de-contacto"){
            $contacto=$value;
        }else{
            $error[]=("No existe persona de contacto");
        }
        if(slugify($value['tipo'])==="firma-de-contrato"){
            $contrato=$value;
        }else{
            $error[]=("No existe persona para firma de Contrato");
        }
    }
?>
@if($data_contacto && $contacto && $contrato)
<table class=" mt-1" width="100%">
    <tr>
        <th colspan="12">DATOS DE LA PERSONA DE CONTACTO</th>
    </tr>
    <tr>
        <td class="cell-title" width="13%">Nombre: </td>
        <td colspan="7">{{$contacto['nombres']}} {{$contacto['apellidos']}}</td>
        <td class="cell-title">Cargo: </td>
        <td colspan="3">{{ $contacto['cargo'] }}</td>
    </tr>
    <tr>
        <td class="cell-title">CI: </td>
        <td colspan="7">{{ $contacto['ci'] }} ({{ $contacto['ci_ext'] }}) </td>
        <td class="cell-title">Celular: </td>
        <td>{{ $contacto['celular'] }}</td>
        <td class="cell-title">e-mail: </td>
        <td>{{ $contacto['correo'] }}</td>
    </tr>
</table>
<table class=" mt-1" width="100%">
    <tr>
        <th colspan="4">DATOS DE LA PERSONA QUE FIRMARA EL CONTRATO</th>
    </tr>
    <tr>
        <td class="cell-title" width="13%">Nombre: </td>
        <td>{{ $contrato['nombres'] }} {{ $contrato['apellidos'] }}</td>
        <td width="13%" class="cell-title">CI: </td>
        <td>{{ $contrato['ci'] }} - ({{ $contrato['ci_ext'] }})</td>
    </tr>
</table>
@else
<div class="text-center" style="color:red">
    <p class="p-1" >No se pudo cargar la informacion de la PERSONA DE CONTACTO ;(</p>
    @foreach($error as $key => $value)
    <strong> {{$value}}</strong> <br>
    @endforeach
</div>
@endif
