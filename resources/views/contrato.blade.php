<?php
    $total_espacios=0;
    $total_servicios=0;
    foreach ($contrato_data['data']['espacios'] as $key => $espacio) {
        $total_espacios += $espacio->precio;
    }
    foreach ($contrato_data['data']['servicios'] as $key => $servicio) {
        $total_servicios += ($servicio->precio_unitario*$servicio->cantidad);
    }
    $total_general=$total_espacios+$total_servicios;
    $current = Carbon\Carbon::now('America/La_Paz');
    $translateTime = Carbon\Carbon::parse($current)->translatedFormat('   j \d\e F \d\e\l Y');
    $GLOBALS['usuario'] = $contrato_data['data']['usuario']['nombres'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ asset('/css/contratos.css') }}" media="all" />
    <title>Formulario Participacion</title>
</head>
<body>
    <script type="text/php">
        if (isset($pdf)) {
            $color = array(0.476, 0.476, 0.476);
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $size = 9;
            $font = $fontMetrics->getFont("sans-serif" );
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) - 35;
            $y = $pdf->get_height() - 45;
            $pdf->page_text($x, $y, $text, $font, $size,$color);
           
        }
    </script>
    {{-- TITULO FORMULARIO --}}
    <div class="text-center mb-2">
        <p class="  m-1">
            CONTRATO DE PARTICIPACIÓN
        </p>
        <p class="m-1 titulo uderline">FERIA INTERNACIONAL DE LA MINERIA, ENERGIA Y MEDIO AMBIENTE – FIMEM BOLIVIA 2021</p>
        <p class="m-1">CAEX/00{{$contrato_data['data']['nro_seguimiento']}}/2021</p>
    </div>
    @include('contrato.pa1')
    <br>
    <p>
        2.-El/La Sr./Sra. <strong>{{strtoupper($persona['nombres']) .'  '. strtoupper($persona['apellidos'])}}</strong> con C.I. {{$persona['ci'] .'-'. $persona['ci_ext']}} mayor de edad, en representación de la empresa {{$contrato_data['data']['empresa']['razon_social']}}, ubicada en territorio nacional y que en lo sucesivo a los fines del presente contrato se denominará EXPOSITOR.
    </p>
    <p>
        <strong>SEGUNDA. - (OBJETO) El EXPOSITOR</strong> se compromete a participar en la <strong>FERIA INTERNACIONAL DE LA MINERIA, ENERGIA Y MEDIO AMBENTE – FIMEM BOLIVIA 2021</strong> que se realizará en la ciudad de <strong>Oruro en predios del Campo Ferial 3 de Julio del jueves 19 al domingo 22 de agosto del año 2021</strong>, con la presentación de {{$contrato_data['data']['productos'][0]['descripcion']}}, objeto por el cual, utilizará los siguientes espacios de conformidad al plano de distribución que declara conocer:
    </p>
    @if($secciones['espacios'])
    @include('contrato.espacios',['data_espacios'=>$contrato_data['data']['espacios']])
    @endif
    {{-- SERVICIOS --}}
    @if($secciones['servicios'])
    @include('contrato.servicios',['data_servicios'=>$contrato_data['data']['servicios']])
    @endif
    <br>
    <p>Así también se compromete en participar de manera virtual del 1 al 30 de agosto del año en curso en la plataforma <u>https://virtual.campoferial3dejulio.com</u>, por lo que diseñará y presentará su stand virtual con información fidedigna y de propiedad del EXPOSITOR, para cuyo efecto se regirá a las condiciones técnicas establecidas para la feria virtual FIMEM BOLIVIA 2021.</p> <br>
    <p>
        <strong>TERCERA. - (SOBRE EL PAGO)</strong> <br>
        El monto total del contrato es de Bs.{{number_format($total_general, 2, ',', '.')}} {{NumeroLetras::convertir($total_general,$currency = 'BOLIVIANOS', $format = true, $decimals = '2')}}, mismo que deberá ser cancelado hasta el {{ \Carbon\Carbon::parse($contrato_data['data']['fecha_limite_pago'])->translatedFormat('j \d\e F, ') }} presente año en curso.
    </p> <br>
    <p>
        Si el EXPOSITOR desiste de su participación de la FERIA (Reglamento del Campo Ferial 3 de Julio Arts. 16 y 22), reconoce a favor del CAMPO FERIAL, todos los pagos anticipados efectuados por concepto de indemnización sin reclamo de devolución alguno.
    </p>
    <br>
    <p>
        <strong>CUARTA. - (DERECHO DE LOS EXPOSITORES)</strong> El EXPOSITOR tendrá derecho a las siguientes cláusulas para un stand o área básica:
    </p>
    <table>
        <tr class="noBorder">
            <td class="noBorder"><b>a) </b></td>
            <td class="noBorder">
                <p class="m-0"> A realizar la conexión de toma de energía y punto de luz. Todo equipo y maquinaria adicional necesaria, teniendo un costo agregado de acuerdo a la evaluación e informe del Personal de Infraestructura y Eléctrico del Campo Ferial “3 de Julio”</p>
            </td>
        </tr>
        <tr>
            <td class="noBorder"><b>b) </b></td>
            <td class="noBorder">
                <p class="m-0"> Cualquier reclamo por parte de EL EXPOSITOR deberá ser comunicado formalmente a los representantes comerciales de EL CAMPO FERIAL para su respectiva evaluación y atención.</p>
            </td>
        </tr>
        <tr>
            <td class="noBorder"><b>c) </b></td>
            <td class="noBorder">
                <p class="m-0"> El EXPOSITOR está autorizado para ofrecer únicamente aquellos productos y servicios declarados oportunamente al momento de la firma del Contrato de Participación.</p>
            </td>
        </tr>
        <tr>
            <td class="noBorder"><b>d) </b></td>
            <td class="noBorder">
                <p class="m-0"> EL EXPOSITOR tiene derecho a solicitar la autorización de parqueo de un vehículo, donde previamente se realizará un análisis, verificación y posterior solicitud de cancelación del monto asignado por EL CAMPO FERIAL para este fin.</p>
            </td>
        </tr>
        <tr>
            <td class="noBorder"><b>e) </b></td>
            <td class="noBorder">
                <p class="m-0"> Espacio en la plataforma <u>https://virtual.campoferial3dejulio.com</u> para su presentación en la Feria.</p>
            </td>
        </tr>
        <tr>
            <td class="noBorder"><b>f) </b></td>
            <td class="noBorder">
                <p class="m-0">Inclusión en el Catálogo Digital de participantes, mismo que será entregado a la conclusión del feria</p>
            </td>
        </tr>
    </table>
    <br>
    <p><strong>QUINTA. - (OBLIGACIONES DEL EXPOSITOR)</strong></p>
    <table>
        <tr class="noBorder">
            <td class="noBorder"><b>a) </b></td>
            <td class="noBorder">
                <p class="m-0"> El EXPOSITOR se compromete a cumplir estrictamente los horarios de abastecimiento, ingreso, salida y permanencia en el stand o espacio para su atención a los visitantes. Los horarios de apertura al público en general será el siguiente:</p>
            </td>
        </tr>
    </table>
    <br>
    <table style="margin-left: 25px ; ">
        <th>DÍAS Y FECHAS</th>
        <th>HORARIOS DE VISITA</th>
        <tr>
            <td>Jueves 19, viernes 20</td>
            <td>De 15:00 hasta las 21:00</td>
        </tr>
        <tr>
            <td>Sábado 21, domingo 22</td>
            <td> De 10:00 hasta las 21:00</td>
        </tr>
    </table>
    <br>
    <table style="margin-left: 25px ; ">
        <th>DÍAS Y FECHAS</th>
        <th>HORARIOS DE ABASTECIMINETO</th>
        <tr>
            <td>Jueves 19, viernes 20</td>
            <td>De 14:00 hasta las 15:00</td>
        </tr>
        <tr>
            <td>Sábado 21, domingo 22</td>
            <td>De 09:00 hasta las 10:00</td>
        </tr>
    </table>
    <br>
    <table>
        <tr class="noBorder">
            <td class="noBorder" style="color:white">n)</td>
            <td class="noBorder">
                <p class="m-0">Se debe resaltar que no se permitirá bajo ningún argumento el abastecimiento de productos durante el desarrollo de la feria, por efecto de las medidas y cumplimiento de protocolo de bioseguridad.Teniendo programado en forma diaria la desinfección de todas las áreas antes de aperturar los pabellones al público.</p>
            </td>
        </tr>
    </table><br>
    <table>
        <tr class="noBorder">
            <td class="noBorder"><b>b) </b></td>
            <td class="noBorder">
                <p class="m-0">El EXPOSITOR se compromete a cumplir con las fechas asignadas para el equipamiento, armado y desarmado de sus stands, de acuerdo al siguiente cronograma:</p>
            </td>
        </tr>
    </table>
    <br>
    <table style="margin-left: 25px ; ">
        <th>DESCRIPCIÓN</th>
        <th>DIAS Y FECHAS</th>
        <th>HORARIO</th>
        <tr>
            <td rowspan="2">Armado y equipamiento del stand</td>
            <td>Lunes 16 al miércoles 18 agosto </td>
            <td>De horas 9:00 hasta 18:00</td>
        </tr>
        <tr>
            <td>Jueves 19 de agosto </td>
            <td>De horas 9:00 hasta las 12:30</td>
        </tr>
        <tr>
            <td>Desarmado del stand</td>
            <td>Desde el día lunes 23 al martes 24 de agosto </td>
            <td>De horas 9:00 hasta 18:00</td>
        </tr>
    </table>
    <br>
    <p style="margin-left: 25px">
        Se establece con carácter de obligatoriedad que el stand con todos los productos de exposición deberán estar completamente instalados como máximo hasta el día jueves 19 de agosto a las 12:30 pm, posterior a esta hora el SEDES realizará la desinfección general a todas las áreas de exposición y visita de la feria; por lo que, ningún EXPOSITOR podrá armar su stand pasado el horario establecido.
        Si el EXPOSITOR no cumpliera con los plazos para el desarmado del stand, correrá con los gastos adicionales de almacenaje (20 Bs/día) desde el miércoles 25 de agosto de 2021 hasta su desalojo del Campo Ferial 3 de Julio de acuerdo a lo establecido en el Reglamento del CAMPO FERIAL.
    </p>
    <br>
    <table>
        <tr class="noBorder">
            <td class="noBorder"><b> c) </b></td>
            <td class="noBorder">
                <p class="m-0"> El EXPOSITOR se obliga a detallar un inventario de los equipos, mobiliario y maquinaria que será utilizado en el stand antes, durante y después de la feria para control en el ingreso y salida de los mismos del CAMPO FERIAL. El CAMPO FERIAL no se responsabiliza por pérdidas de mercaderías, maquinarias, productos, artículos de exposición, muestras o cualquier otro tipo de bienes de propiedad del EXPOSITOR (Reglamento General de Participación Art. 66).</p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> d) </b></td>
            <td class="noBorder">
                <p class="m-0"> El EXPOSITOR debe respetar las obligaciones de uso del espacio de su stand (Capítulo VII del Reglamento), y no salir fuera del mismo con su mobiliario u otros, y no obstruir la fluidez de los visitantes, caso contrario se verá obligado a pagar una multa del 100% del costo por m2 adicional (300 Bs/m2) usado de acuerdo a lo establecido por el CAMPO FERIAL.</p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> e) </b></td>
            <td class="noBorder">
                <p class="m-0"> El EXPOSITOR se compromete a diseñar, elaborar y armar una estructura adecuada para brindar una buena imagen de su empresa, con el nombre y logos respectivos, asimismo se compromete a que el personal encargado del stand esté debidamente presentable para dar realce a la Feria, asumiendo por su cuenta todas las medidas de BIOSEGURIDAD Y DISTANCIAMIENTO SOCIAL</p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b>f) </b></td>
            <td class="noBorder">
                <p class="m-0">Por otro lado, el EXPOSITOR se compromete a evitar la contaminación acústica, debiendo en todo caso medir y cumplir la norma del uso de volumen del stand de manera que no afecte o perjudique la actividad de los stands colindantes. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> g) </b></td>
            <td class="noBorder">
                <p class="m-0">g) El EXPOSITOR también asume el compromiso de que en caso de incluir en su trabajo muñecos, mascotas y otros, estos NO deben invadir el tránsito de paso de los visitantes en la feria (pasillos),ni invadir los espacios para guardar el distanciamiento social debiendo prever el espacio correspondiente para que sus muñecos, mascotas u otros se encuentren dentro del stand. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b>h) </b></td>
            <td class="noBorder">
                <p class="m-0">El EXPOSITOR se compromete a mantener el stand que este a su cargo, limpio y ordenado, recoger permanentemente la basura y desechos de sus visitantes, para depositarlos en los contenedores para basura del CAMPO FERIAL. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b>i) </b></td>
            <td class="noBorder">
                <p class="m-0"> EL EXPOSITOR es responsable por cualquier daño o perjuicio que cause a las instalaciones del CAMPO FERIAL y/o a la sede en que ésta se desarrolla. Éstos serán valorizados y pagados antes de la fecha prevista para el desmontaje.</p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> j) </b></td>
            <td class="noBorder">
                <p class="m-0"> El EXPOSITOR obligatoriamente en caso de exponer productos para la venta deberá tener su registro en la Oficina de Servicio de Impuestos Nacionales con el NIT correspondiente, ya sea en el Régimen General o Simplificado, y cumplir con las obligaciones tributarias respectivas, por las que el CAMPO FERIAL no se hace responsable sobre controles o fiscalizaciones que emerjan de la Oficina Estatal referida.</p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b>k) </b></td>
            <td class="noBorder">
                <p class="m-0">Así también SOBODAYCOM es responsable de emitir las autorizaciones correspondientes por el uso de música sujetándonos estrictamente a la Ley 1322 de Derechos de Autor, y a su Decreto Reglamentario D. S. 23907 EL USO PUBLICO DE LA MÚSICA NACIONAL O INTERNACIONAL, por cualquier medio o modalidad o motivo, ORGANIZADO POR ENTIDADES PUBLICAS O PRIVADAS y/o donde quiera que se interpreten ejecuten obras musicales, mediante la participación de artistas (PRESENTACIONES EN VIVO), y/o a través de sistemas de amplificación, sonoros o audiovisuales (CASSETTES, CDs, VIDEOS, etc.), DEBERÁ SER PREVIA Y EXPRESAMENTE AUTORIZADO por SOBODAYCOM (Art. 47, 48, 68 y 69 de la Ley 1322 y Art. 21 y 27 del D. S. 23907). A tal efecto el CAMPO FERIAL no autorizará la realización de espectáculos o audiciones públicas de obras musicales, sólo que el responsable presente su programa acompañado DE LA AUTORIZACIÓN de los titulares de los derechos o de sus representantes. Las autorizaciones de la utilización de Ejecución Publica de obras musicales podrán ser otorgadas por las sociedades autorales y de Derechos Conexos que reconoce la Ley. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b>l) </b></td>
            <td class="noBorder">
                <p class="m-0">El EXPOSITOR deberá proveer a todo su personal que participe en la feria y personal de abastecimiento todos los implementos de bioseguridad estipulados en la CLAUSULA DECIMA SEGUNDA del presente contrato, debiendo contar con los protocolos de bioseguridad aprobados con la correspondiente ampliación para ferias en el caso que corresponda (servicios gastronómico, restaurants y otros). </p>
            </td>
        </tr>
    </table>
    <br>
    <p><strong><u>SEXTA</u>. - (PROHIBICIONES)</strong> Queda terminantemente prohibido:</p>
    <br>
    <table>
        <tr class="noBorder">
            <td class="noBorder"><b> a) </b></td>
            <td class="noBorder">
                <p class="m-0"> Las campañas con carácter políticas partidarias (Reglamento General de Participación Art. 36). Si el EXPOSITOR incumpliera será inmediatamente desalojado del campo ferial, sin derecho a devolución de pago ni reclamo alguno, prohibiéndose su ingreso durante la duración de la feria. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> b) </b></td>
            <td class="noBorder">
                <p class="m-0">Ceder, alquilar o subarrendar el local o darle uso diferente para el que fue arrendado, la infracción de esta norma acarreará la cancelación inmediata del contrato y la expulsión del recinto, sin que EL CAMPO FERIAL tenga que restituir ningún valor, ni siquiera el canon de arrendamiento, así como tampoco tendrá que reconocer ningún pago por concepto de indemnización; </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> c) </b></td>
            <td class="noBorder">
                <p class="m-0"> Colocar altavoces con fines publicitarios u otro sistema que ocasione ruido o que su volumen pueda causar molestias a los demás expositores y público visitante; </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> d) </b></td>
            <td class="noBorder">
                <p class="m-0"> Mantener vehículos dentro del recinto ferial, excepto en el caso de que estén en exhibición; </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> e) </b></td>
            <td class="noBorder">
                <p class="m-0"> Vender y/o consumir bebidas alcohólicas dentro del recinto ferial de exhibición, salvo los que están autorizados para promocionar dichos productos artesanalmente, tomando en cuenta que estos productos son única y exclusivamente de degustación limitada y controlada. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> f) </b></td>
            <td class="noBorder">
                <p class="m-0"> Transferir las credenciales de identificación para que hagan uso de ellas otras personas. En caso de detectarse tal hecho, serán retiradas inmediatamente de circulación todas las credenciales entregadas a EL EXPOSITOR, </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> g) </b></td>
            <td class="noBorder">
                <p class="m-0"> Colocar cobertores que atenten a la estética, imagen y seguridad del recinto ferial, tales como la utilización de productos combustibles y/o de otros sancionados o no autorizados por ley </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> h) </b></td>
            <td class="noBorder">
                <p class="m-0">Ocupar con vitrinas, perchas o exhibidores en las vías peatonaleso de seguridad. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> i) </b></td>
            <td class="noBorder">
                <p class="m-0"> Irrespetar el ordenamiento zonal de productos y/o actividades similares de exhibición. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> j) </b></td>
            <td class="noBorder">
                <p class="m-0"> Queda prohibida la venta ambulante al interior del recinto ferial o sus áreas circundantes. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> k) </b></td>
            <td class="noBorder">
                <p class="m-0"> No cerrar el local y no retirar a todo su personal a la hora establecida por EL CAMPO FERIAL después de lo cual no se permitirá la permanencia de personas ajenas a la organización de la Feria en el recinto ferial; incluso de expositores, su personal o seguridad privada contratada por EL EXPOSITOR. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> l) </b></td>
            <td class="noBorder">
                <p class="m-0"> Una vez terminada la exposición EL EXPOSITOR no podrá abandonar el recinto ferial si hubiese algún pago pendiente por realizar, ya sea por valor del stand como por cualquier otro servicio, gasto o multa que haya incurrido. El Administrador de la Feria, será quien autorice la salida de todos los expositores </p>
            </td>
        </tr>
    </table>
    <br>
    <p>
        <strong>SEPTIMA. - (INCUMPLIMIENTO) </strong> En caso de incumplimiento, por parte de EL EXPOSITOR, de alguna de las condiciones descritas en el presente Contrato, El CAMPO FERIAL podrá cancelar la participación de EL EXPOSITOR y dar por terminado el presente acuerdo sin estar obligado a dar ningún reembolso.
    </p>
    <br>
    <p>
        En caso de presentar un producto distinto al declarado en el presente contrato se procederá a la sanción monetaria que consta del pago del doble del valor real del stand.
    </p>
    <br>
    <p><strong>OCTAVA. - (OBLIGACIONES DEL CAMPO FERIAL)</strong> Como efecto del presente contrato, el CAMPO FERIAL se compromete a proveer:</p>
    <br>
    <table>
        <tr class="noBorder">
            <td class="noBorder"><b> a) </b></td>
            <td class="noBorder">
                <p class="m-0"> Entregar el Stand o espacio a partir del lunes 16 de agosto del 2021 después de las 09:00, para que EL EXPOSITOR pueda hacer las adecuaciones necesarias, dejando expresa constancia que el CAMPO FERIAL no proveerá ningún tipo de material, herramienta y/o mobiliario y que éstos correrán por cuenta entera y propia de EL EXPOSITOR. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> b)</b></td>
            <td class="noBorder">
                <p class="m-0"> Disponer de personal de apoyo técnico especializado para la atención de emergencia y de prevención en el funcionamiento de instalaciones eléctricas, apoyo logístico y técnico para favorecer la participación de los expositores y buscar conjuntamente soluciones, ante eventualidades y/o emergencias que puedan suscitarse. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> c)</b></td>
            <td class="noBorder">
                <p class="m-0">Una toma de energía eléctrica monofásica (220 v) </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> d) </b></td>
            <td class="noBorder">
                <p class="m-0"> Servicios sanitarios y agua. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> e) </b></td>
            <td class="noBorder">
                <p class="m-0"> Promoción y publicidad general del evento.</p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> f) </b></td>
            <td class="noBorder">
                <p class="m-0">El CAMPO FERIAL se encargará del cuidado de los pabellones durante la noche, una vez cerrada las instalaciones feriales. Durante todas las horas de exposición se hace responsable el EXPOSITOR. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> g) </b></td>
            <td class="noBorder">
                <p class="m-0"> Garantizar el normal desenvolvimiento de la feria desde la inauguración hasta el día de la clausura; </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> h) </b></td>
            <td class="noBorder">
                <p class="m-0"> Brindar limpieza y mantenimiento de todos los espacios públicos del recinto ferial; </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> i) </b></td>
            <td class="noBorder">
                <p class="m-0"> Establecer seguridad física, interna y externa, pública y privada permanente para precautelar la integridad de las personas y de los bienes; </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> j) </b></td>
            <td class="noBorder">
                <p class="m-0"> Entregar credenciales de identificación a EL EXPOSITOR, para que él y su personal tengan libre acceso al recinto ferial en los límites detallados. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> k) </b></td>
            <td class="noBorder">
                <p class="m-0"> Proveer VIDEOS TUTORIALES para el mejor y oportuno diseño y armado del Stand Virtual </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b>l)</b></td>
            <td class="noBorder">
                <p class="m-0"> Velar por el cumplimiento de las medidas de protección y sanidad de bioseguridad para prevenir contagios del COVID-19 </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b>m) </b></td>
            <td class="noBorder">
                <p class="m-0"> Proveer de un área de AISLAMIENTO para posibles casos sospechosos de CONTAGIOS DE COVID -19, para su traslado a las unidades de aislamiento y tratamiento autorizados </p>
            </td>
        </tr>
    </table>
    <br>
    <p>
        <strong>NOVENA.- (NATURALEZA DEL CONTRATO).</strong> -Este contrato por su naturaleza es de índole estrictamente civil y las partes declaran que no existe relación de carácter laboral entre ellas; por lo tanto, los empleados que contrate o llegare a contratar EL EXPOSITOR o EL CAMPO FERIAL se encuentran a exclusivo cargo de cada una de ellas, por ende, los mismos carecen de vínculo y de autorización que les permita anunciarse como empleados, socios, representantes, mandatarios o agentes de la otra parte; por lo que, tampoco tienen derecho a reclamo alguno sobre las prestaciones previstas en la legislación laboral.
    </p>
    <br>
    <p>
        <strong>DECIMA. - (DOMICILIO ESPECIAL) </strong> Para los efectos del presente contrato, las partes contratantes, constituyen Domicilio Especial, en el Campo Ferial 3 de Julio, además del enunciado al principio, donde tendrán valides las notificaciones y requerimientos sometiéndose a la jurisdicción de los tribunales ordinarios de la ciudad de Oruro del Estado Plurinacional de Bolivia, con renuncia a todo otro fuero o jurisdicción si procede.
    </p>
    <br>
    <p>
        Se establece que la responsabilidad del CAMPO FERIAL, se limita al buen funcionamiento de la plataforma virtual, deslindando responsabilidad por caídas del sistema de internet de los proveedores, y/o casos fortuitos no atribuibles a la administración del CAMPO FERIAL.
    </p>
    <br>
    <p>
        <strong>DÉCIMO PRIMERA. -(GARANTÍA) </strong> Se establece para efectos de resguardo de las instalaciones y activos feriales por daños potenciales (Reglamento Art. 63), la empresa estará sujeta a un cobro económico en el caso de incumplir algunos de los puntos del reglamento o efectúen daños al Campo Ferial 3 de julio.
    </p>
    <br>
    <p>
        <strong>DÉCIMA SEGUNDA. - (DEL PROTOCOLO DE BIOSEGURIDAD)</strong> Dada la emergencia sanitaria que se vive en Bolivia y el mundo, el EXPOSITOR se compromete a cumplir mínimamente con todas las normas de bioseguridad que se citan a continuación:
    </p>
    <br>
    <table>
        <tr class="noBorder">
            <td class="noBorder"><b> a)</b></td>
            <td class="noBorder">
                <p class="m-0"> Previo al ingreso de los expositores al Campo Ferial y los diferentes pabellones, se deberá de realizar una desinfección adecuada.</p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b>b) </b></td>
            <td class="noBorder">
                <p class="m-0"> Los expositores deberán de contar con los EPP´s mínimos para poder ingresar a los previos del campo ferial caso contrario se les negara todo acceso </p>
            </td>
        </tr>
    </table>
    <br>
    <p style="margin-left: 25px">
        <strong>Equipo de protección personal:</strong> Guantes de latex (desechables), Barbijo común, Protector facial y/o lentes, Traje de bioseguridad, Cofia
    </p>
    <br>
    <p style="margin-left: 25px">
        <strong>Productos de limpieza y desinfección: </strong> Gel desinfectante para manos o solución de alcohol (concentración mayor al 70%), Limpiadores de superficies, Paños
    </p>
    <br>
    <p style="margin-left: 25px">
        <strong>En adición, los expositores de alimentos dentro y fuera de la plaza de comidas deberán contar con: </strong> Detergente en polvo, Alcohol, Hipoclorito de sodio (lavandina), Escoba y recogedor, Baldes,Bolsas de basura
    </p>
    <br>
    <table>
        <tr class="noBorder">
            <td class="noBorder"><b> c) </b></td>
            <td class="noBorder">
                <p class="m-0"> Los expositores no podrán quitarse sus barbijos bajo ninguna circunstancia durante su permanencia en los predios del Campo ferial. </p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> d) </b></td>
            <td class="noBorder">
                <p class="m-0"> Los expositores deben de traer consigo un desinfectante a base de alcohol.</p>
            </td>
        </tr>
        <tr class="noBorder">
            <td class="noBorder"><b> e) </b></td>
            <td class="noBorder">
                <p class="m-0"> En caso de que algún expositor llegue a sentir algún síntoma relacionado con el COVID-19 deberá de informar a la brevedad posible a Gerencia general y será puesto en aislamiento de forma inmediata. </p>
            </td>
        </tr>
    </table>
    <br>
    <p>
        <strong>DÉCIMA TERCERA. - (CONFORMIDAD) </strong> Estando las partes plenamente conformes con todas y cada una de las cláusulas anteriores del presente contrato, lo suscriben en tres ejemplares de un mismo tenor y a un solo efecto.
    </p>
    {{-- FIRMAS --}}
    <table class="text-center  width-100pc mt-2" width="100%">
        <tr>
            <td colspan="12" class="text-center no-border">Oruro, {{ ucfirst(trans($translateTime)) }}</td>
        </tr>
        <tr>
            <td width="50%" class="no-border"><br><br><br><br> <br> <br>
                <p>Ing. Roció J. Villca Quispe</p>
                <strong>ADMINISTRADOR GERENTE <br>
                    CAMPO FERIAL “3 DE JULIO”</strong>
            </td>
            <td width="50%" class="no-border"><br><br><br><br> <br> <br>
                <p>{{$persona['nombres'] .' '. $persona['apellidos']}}</p>
                <p>C.I. {{$persona['ci'] .' '. $persona['ci_ext']}}</p>
                <strong>REPRESENTANTE</strong>
                <p><strong>{{strtoupper($contrato_data['data']['empresa']['razon_social'])}}</strong></p>
            </td>
        </tr>
    </table>
</body>
</html>
