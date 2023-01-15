<?php

include 'includes/header.php';

?>

<?php
     
        if(isset($mensaje_confirmacion))
        {
    ?>
     
     <div class="alert alert-success mt-4" role="alert"><?php echo $mensaje_confirmacion; ?></div>
     
     <?php
            
        }
     
     ?>

<table class="table tabla-tareas mt-3" id="tablaTareas">
    
       
    
    
        <?php 
                if($tareas[0]['nombre_para']!='')
                {
    
    ?>
       
              
            
        <thead>
              <?php
                    if($this->session->userdata('super')==1)
                    {


                 ?>



                      <tr>
                    <td colspan="7" style="border-top: none;">
                     <form action="<?php echo base_url(); ?>inicio_controller/MostrarFiltro" method="post">
                     <input type="hidden" name="cod_usuario" value="<?php echo $this->session->userdata('cod_usuario'); ?>">
                     <!--<table>
                            <tr>
                                <td class="pt-4 pb-2" style="border-top: none;">Mostrar:</td>
                                <td class="pt-4 pb-2 px-4" style="border-top: none;">
                                <?php
                                    if($this->session->userdata('mostrar_todos')!=0)
                                    {
                                 ?>
                                    <input class="checkbox" type="checkbox" id="mostrar_yo" name="mostrar_yo" onclick="checkyo(this)">
                                 <?php
                                    }
                                    else
                                    {
                                 ?>
                                    <input class="checkbox" type="checkbox" id="mostrar_yo" name="mostrar_yo" onclick="checkyo(this)" checked>
                                 <?php
                                    }
                                 ?>
                                 <label for="mostrar_yo">Yo</label>
                                </td>
                                <td class="pt-4 pb-2 px-4" style="border-top: none;">
                                 <?php
                                    if($this->session->userdata('mostrar_todos')!=0)
                                    {
                                 ?>
                                 <input class="checkbox" type="checkbox" id="mostrar_todos" name="mostrar_todos" onclick="checktodos(this)" checked>
                                  <?php
                                    }
                                    else
                                    {
                                 ?>
                                 <input class="checkbox" type="checkbox" id="mostrar_todos" name="mostrar_todos" onclick="checktodos(this)">
                                 <?php
                                    }
                                 ?>
                                 <label for="mostrar_todos">Todos</label>

                                </td>
                                <td style="border-top: none;"> <input class="btn btn-lg btn-gotosystem btn-block btn-filtrar" value="Filtrar" type="submit"></td>

                            </tr>


                        </table>-->
                        </form>
                          </td>
                        </tr>
             <?php
                    }
    
        
                ?>
            <tr class="fila-sin-borde">
                <th scope="col"></th>
                <th scope="col" style="width: 250px;">Nombre</th>
                <th scope="col" class="text-center">Para</th>
                <th scope="col" class="text-center" style="display: none;">Clientes</th>
                <th scope="col" class="text-center">Fecha límite</th>
                <th scope="col" class="text-center">Prioridad</th>
                <th scope="col" class="text-center">Estado</th>
                <th scope="col" class="text-center">Acciones</th>
                
            </tr>
        </thead>
        <tbody>
            <?php

                    function hex2rgba($color, $opacity = false) {
                    
                        $default = 'rgb(0,0,0)';
                    
                        //Return default if no color provided
                        if(empty($color))
                            return $default; 
                    
                        //Sanitize $color if "#" is provided 
                            if ($color[0] == '#' ) {
                                $color = substr( $color, 1 );
                            }
                    
                            //Check if color has 6 or 3 characters and get values
                            if (strlen($color) == 6) {
                                    $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
                            } elseif ( strlen( $color ) == 3 ) {
                                    $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
                            } else {
                                    return $default;
                            }
                    
                            //Convert hexadec to rgb
                            $rgb =  array_map('hexdec', $hex);
                    
                            //Check if opacity is set(rgba or rgb)
                            if($opacity){
                                if(abs($opacity) > 1)
                                    $opacity = 1.0;
                                $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
                            } else {
                                $output = 'rgb('.implode(",",$rgb).')';
                            }
                    
                            //Return rgb(a) color string
                            return $output;
                    }        

                foreach($tareas as $tarea)
                {
                    $cod_tarea=$tarea['cod_tarea'];
                    $nombre_tarea=$tarea['nombre'];
                    $para_tarea=$tarea['nombre_para'];
                    $fecha_creada=$tarea['fecha_creada'];
                    $hora_creada=$tarea['hora_creada'];
                    $fecha_limite=$tarea['fecha_limite'];
                    $hora_limite=$tarea['hora_limite'];
                    $estado=$tarea['nombre_estado'];
                    $color_estado=$tarea['color_estado'];
                    $color_usuario=$tarea['color_para'];
                    $clientes=$tarea['clientes'];
                    $colorClientes=$tarea['colorClientes'];
                    $prioridad=$tarea['prioridad'];
                    $noleidos=$tarea['noleidos'];
                    $usuario_activo=$tarea['usuario_activo'];
                    $borde_usuario = $tarea['borde_para'];
                    
                    $nombre_clientes="";
                    foreach ($clientes as $cliente)
                    {
                      $nombre_clientes.="<div class='pildoracliente'>".$cliente."</div>";
                    }
                    

                    $date = DateTime::createFromFormat( 'Y-m-d', $fecha_creada);
                    $fecha_creada_formateada = $date->format('d-m-Y');
            
                    $date = DateTime::createFromFormat( 'H:i:s', $hora_creada);
                    $hora_creada_formateada = $date->format('H:i');
                    if($fecha_limite != '0000-00-00')
                    {
                        $date = DateTime::createFromFormat( 'Y-m-d', $fecha_limite);
                        $fecha_limite_formateada = $date->format('d-m-Y');
                    }
                    else
                    {
                        $fecha_limite_formateada = '';
                    }

                    if($hora_limite != '00:00:00')
                    {
                        $date = DateTime::createFromFormat( 'H:i:s', $hora_limite);
                        $hora_limite_formateada = $date->format('H:i');
                    }
                    else
                    {
                        $hora_limite_formateada = '';
                    }
                    $datediff = (strtotime($fecha_limite_formateada) - time())/ (60 * 60 * 24);

                    //echo '<tr style="background-color:'.hex2rgba("'.$color_usuario[0].'",0.05).'">';
                    echo '<tr style="background-color:'.hex2rgba($color_usuario[0],0.05).'">';
                    //echo '<th class="align-middle" scope="row"><input class="checkbox" type="checkbox" id="tarea_'.$cod_tarea.'" name="tarea_'.$cod_tarea.'"><label for="tarea_'.$cod_tarea.'">&nbsp;</label></th>';
                    
                    $fondo=" red ";
                    if ($noleidos==0)  $fondo=" transparent ";
                    
                    echo '<th class="text-center align-middle" style="color:white;background-color:'.$fondo.'">'.$noleidos.'</th>';
                    echo '<th class="align-middle" scope="row">'.$nombre_clientes.'<a href="'.base_url().'tarea/'.$cod_tarea.'">'.$nombre_tarea.'</a></th>';
                    echo '<td class="text-center align-middle" >';
                    for ($i=0; $i <count($para_tarea) ; $i++) 
                    {
                      $borde = $borde_usuario[$i];  
                      echo '<span  style="'.$borde.' display:inline-block;width:90%;font-weight: 600; background-color: '.$color_usuario[$i].'; color: #FFF; border-radius: 5px; padding-right: 5px; padding-left: 5px;margin-top:1px;margin-bottom:1px">'.$para_tarea[$i].'</span><br>';
                    }
                    echo "</td>";
                    echo '<td class="text-center align-middle" style="display: none;">';
                    for ($i=0; $i <count($clientes) ; $i++) 
                    {
                        echo '<span style="font-weight: 600; background-color: '.$colorClientes[$i].'; color: #FFF; border-radius: 5px; padding-right: 5px; padding-left: 5px;" class="sobretexto" title="'.$clientes[$i].'">'.$clientes[$i].'</span><br>';
                    }
                    echo "</td>";
                    //echo '<td class="text-center align-middle">'.$fecha_creada_formateada.' '.$hora_creada_formateada.'</td>';
                    $clase_fechalimite="fechalimitepasada";
                    if ($datediff>7) $clase_fechalimite="fechalimitemasde7dias";
                    else if ($datediff>0) $clase_fechalimite="fechalimitemenosde7dias";
                    if ($fecha_limite_formateada=='') $clase_fechalimite="";
                    echo '<td class="text-center align-middle"><div class="'.$clase_fechalimite.'">'.$fecha_limite_formateada.'</div></td>';
                    if ($prioridad=='ALTA') $prioridad="<b>ALTA</b>";
                    echo '<td class="text-center align-middle">'.$prioridad.'</td>';
                    echo '<td class="text-center align-middle"><span style="font-weight: 600; color: '.$color_estado.'; ">'.$estado.'</span></td>';
                    ?>
                    <td class="text-center align-middle"><a class="mr-2" href="<?php echo base_url(); ?>tarea/<?php echo $cod_tarea; ?>"><img src="<?php echo base_url(); ?>assets/images/actions/edit.png" width="auto" height="20" title="Editar tarea"/></a><a onclick="return confirm('¿Estás seguro de que quieres eliminar esta tarea?');" class="ml-2" href="<?php echo base_url(); ?>eliminar-tarea/<?php echo $cod_tarea; ?>"><img src="<?php echo base_url(); ?>assets/images/actions/delete.png" width="auto" height="20" title="Editar tarea"/></a></td></tr>
                    <?php
                }
                    ?>
                <!--<tr>
                    <td colspan="2" class="text-left">
                        <?php
                            if($pagina_actual>1)
                            {                  
                                $primera_pagina=1;

                                echo '<a href="'.base_url().'tareas?pagina='.$primera_pagina.'">Primera</a>';
                            }
                        ?>
                    </td>
                    <td  colspan="3" class="text-center">
                        <?php

                            if($pagina_actual>1)
                            {
                                $pagina_anterior=$pagina_actual-1;

                                echo '<a href="'.base_url().'tareas?pagina='.$pagina_anterior.'">Anterior</a> - ';
                            }

                            echo 'Mostrando página '.$pagina_actual.' de '.$total_paginas;

                            if($pagina_actual<$total_paginas)
                            {
                                $pagina_siguiente=$pagina_actual+1;

                                echo ' - <a href="'.base_url().'tareas?pagina='.$pagina_siguiente.'">Siguiente</a>';
                            }
                        ?>
                    </td>
                    <td colspan="2" class="text-right">
                        <?php
                            if($pagina_actual<$total_paginas)
                            {                  
                                $ultima_pagina=$total_paginas;

                                echo '<a href="'.base_url().'tareas?pagina='.$ultima_pagina.'">Última</a>';
                            }

                        ?>
                    </td>
                </tr>-->
        </tbody>

    <?php
                                            
                    }
                    else
                    {
                      
    ?>

                 <thead>
            <tr class="fila-sin-borde">
              
                <th scope="col" class="text-center">No hay tareas que mostrar</th>
              
                
            </tr>
        </thead>

    <?php
                    }
    ?>
    
     </table>
     <div style="height:30px"></div>

<style type="text/css">
    .page-item.active .page-link 
    {
        z-index: 1;
        color: #fff;
        background-color: #ef9a49;
        border-color: #ef9a49;
    }
    .page-link 
    {
        color: #ef9a49;
    }

</style>
<script>
    function checkyo(caja)
    {       
        if (caja.checked)
        {            

            document.getElementById("mostrar_todos").checked=false
            
        }
    }
    
    function checktodos(caja)
    {
        if (caja.checked)
        {
            
            document.getElementById("mostrar_yo").checked=false
            
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {

        function accents_supr(data){
return !data ?
    '' :
    typeof data === 'string' ?
        data
            .replace(/\n/g, ' ')
            .replace(/[\u0061\u24D0\uFF41\u1E9A\u00E0\u00E1\u00E2\u1EA7\u1EA5\u1EAB\u1EA9\u00E3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\u00E4\u01DF\u1EA3\u00E5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250]/g, 'a')
            .replace(/[\u0065\u24D4\uFF45\u00E8\u00E9\u00EA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\u00EB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD]/g, 'e')
            .replace(/[\u0069\u24D8\uFF49\u00EC\u00ED\u00EE\u0129\u012B\u012D\u00EF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131]/g, 'i')
            .replace(/[\u006F\u24DE\uFF4F\u00F2\u00F3\u00F4\u1ED3\u1ED1\u1ED7\u1ED5\u00F5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\u00F6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\u00F8\u01FF\u0254\uA74B\uA74D\u0275]/g, 'o')
            .replace(/[\u0075\u24E4\uFF55\u00F9\u00FA\u00FB\u0169\u1E79\u016B\u1E7B\u016D\u00FC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289]/g, 'u')
            .replace(/[\u0041\u24B6\uFF21\u00C0\u00C1\u00C2\u1EA6\u1EA4\u1EAA\u1EA8\u00C3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\u00C4\u01DE\u1EA2\u00C5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F]/g, 'A')
            .replace(/[\u0045\u24BA\uFF25\u00C8\u00C9\u00CA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\u00CB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E]/g, 'E')
            .replace(/[\u0049\u24BE\uFF29\u00CC\u00CD\u00CE\u0128\u012A\u012C\u0130\u00CF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197]/g, 'I')
            .replace(/[\u004F\u24C4\uFF2F\u00D2\u00D3\u00D4\u1ED2\u1ED0\u1ED6\u1ED4\u00D5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\u00D6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\u00D8\u01FE\u0186\u019F\uA74A\uA74C]/g, 'O')
            .replace(/[\u0055\u24CA\uFF35\u00D9\u00DA\u00DB\u0168\u1E78\u016A\u1E7A\u016C\u00DC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244]/g, 'U')
            .replace(/ç/g, 'c')
            .replace(/Ç/g, 'C') :
        data;
};

jQuery.fn.DataTable.ext.type.search['string'] = function(data) {
    return accents_supr(data);
};
        
$.fn.DataTable.ext.type.search['html'] = function(data) {
    return accents_supr(data);
};


    var tablatareas = $('#tablaTareas').DataTable({
        "ordering": false,
        "oLanguage": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },
        "columnDefs": [
            { "width": "20%", "targets": 3 },
            { "width": "10%", "targets": 2 }
        ]


        
    });

    $('#tablaTareas_filter input[type=search]').keyup( function () {
        var table = $('#tablaTareas').DataTable(); 
        table.search(
            jQuery.fn.DataTable.ext.type.search.string(this.value)
        ).draw();
    } );
   
   

} );




</script>
<?php

include 'includes/footer.php';

?>


