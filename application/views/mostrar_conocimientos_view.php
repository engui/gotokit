<?php

include 'includes/headerConocimientos.php';

?>
<table class="table tabla-tareasConocimiento mt-3" id="tablaConocimientos">
	<thead>
		<tr class="fila-sin-borde">
            <th scope="col"></th>
            <th scope="col" style="width: 320px;">Nombre</th>
            <th scope="col" class="text-center">Etiquetas</th>
            <th scope="col" class="text-center">
            <?php
                      echo (ucfirst(STR_CLIENTE).'s'); 
            ?>
            </th>
            <th scope="col" class="text-center" style="display: none;">Creada</th>
            <th scope="col" class="text-center">Acciones</th>       
        </tr>
	</thead>
	<tbody>
		<?php
        	foreach($conocimientos as $conocimiento)
            {
            	$cod_conocimiento=$conocimiento['cod_conocimiento'];
            	$nombre=$conocimiento['nombre'];
            	$etiquetas=$conocimiento['etiquetas'];
                $colorEtiquetas=$conocimiento['colorEtiquetas'];
                $clientes=$conocimiento['clientes'];
                $colorClientes=$conocimiento['colorClientes'];
                $fecha_creada=$conocimiento['fecha_creada'];
                $hora_creada=$conocimiento['hora_creada'];
                $mensaje=$conocimiento['mensaje'];
                
                $date = DateTime::createFromFormat( 'Y-m-d', $fecha_creada);
                $fecha_creada_formateada = $date->format('d-m-Y');
                
                $date = DateTime::createFromFormat( 'H:i:s', $hora_creada);
                $hora_creada_formateada = $date->format('H:i');


                echo '<tr>';
	                echo '<th class="align-middle" scope="row"><input class="checkbox" type="checkbox" id="conocimiento_'.$cod_conocimiento.'" name="conocimiento_'.$cod_conocimiento.'"><label for="conocimiento_'.$cod_conocimiento.'">&nbsp;</label></th>';
	                echo '<th class="align-middle" scope="row"><a href="'.base_url().'conocimiento/'.$cod_conocimiento.'">'.$nombre.'</a></th>';
	                echo '<td class="text-center align-middle">'; //style="max-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #FFF;"
	                for ($i=0; $i <count($etiquetas) ; $i++) 
                    {
                        echo '<span  style="font-weight: 600; background-color: '.$colorEtiquetas[$i].'; color: #FFF; border-radius: 5px; padding-right: 5px; padding-left: 5px;" class="sobretexto" title="'.$etiquetas[$i].'">'.$etiquetas[$i].'</span><br>';
                    }
                    echo '</td>';
                    echo '<td class="text-center align-middle" style="max-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #FFF;">';
                    for ($i=0; $i <count($clientes) ; $i++) 
                    {
                        //echo '<span  style="font-weight: 600; background-color: #01a9db; color: #FFF; border-radius: 5px; padding-right: 5px; padding-left: 5px;">'.$clientes[$i].'</span>';
                        //echo '<span class="tooltip" data-tooltip-content="#tooltip_content">'.$clientes[$i].'</span>';
                        //echo '<span id="tooltip_content">'.$clientes[$i].'</span><br>';
                        echo '<span style="font-weight: 600; background-color: '.$colorClientes[$i].'; color: #FFF; border-radius: 5px; padding-right: 5px; padding-left: 5px;" class="sobretexto" title="'.$clientes[$i].'">'.$clientes[$i].'</span><br>';
                    }
                    echo '</td>';
	                echo '<td class="text-center align-middle" style="display: none;">'.$fecha_creada_formateada.' '.$hora_creada_formateada.'</td>';
	   	?>
	        		<td class="text-center align-middle"><a class="mr-2" href="<?php echo base_url(); ?>conocimiento/<?php echo $cod_conocimiento; ?>"><img src="<?php echo base_url(); ?>assets/images/actions/edit.png" width="auto" height="20" title="Editar Conocimiento"/></a><a onclick="return confirm('¿Estás seguro de que quieres eliminar este conocimiento?');" class="ml-2" href="<?php echo base_url(); ?>eliminar-conocimiento/<?php echo $cod_conocimiento; ?>"><img src="<?php echo base_url(); ?>assets/images/actions/delete.png" width="auto" height="20" title="Eliminar Conocimiento"/></a>
	        		</td>
        		</tr>
        <?php
            }
		?>
		<!--<tr>
            <td colspan="2" class="text-left">
                <?php
                    if($pagina_actual>1)
                    {                  
                        $primera_pagina=1;

                        echo '<a href="'.base_url().'conocimientos?pagina='.$primera_pagina.'">Primera</a>';
                    }
                ?>
            </td>
            <td class="text-center">
                <?php

                    if($pagina_actual>1)
                    {
                        $pagina_anterior=$pagina_actual-1;

                        echo '<a href="'.base_url().'conocimientos?pagina='.$pagina_anterior.'">Anterior</a> - ';
                    }

                    echo 'Mostrando página '.$pagina_actual.' de '.$total_paginas;

                    if($pagina_actual<$total_paginas)
                    {
                        $pagina_siguiente=$pagina_actual+1;

                        echo ' - <a href="'.base_url().'conocimientos?pagina='.$pagina_siguiente.'">Siguiente</a>';
                    }
                ?>
            </td>
            <td colspan="2" class="text-right">
                <?php
                    if($pagina_actual<$total_paginas)
                    {                  
                        $ultima_pagina=$total_paginas;

                        echo '<a href="'.base_url().'conocimientos?pagina='.$ultima_pagina.'">Última</a>';
                    }

                ?>
            </td>
        </tr>-->
	</tbody>
</table>
<script type="text/javascript">
$(document).ready(function() {
    $('#tablaConocimientos').DataTable({
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
            { "width": "20%", "targets": 2 }
        ]
    });
} );

/*$("#tablaConocimientos").on("mouseenter", "td", function() {
  $(this).attr('title', this.innerText);
});*/
</script>
<script>
$(document).ready(function() {
    $('.sobretexto').tooltipster(
    {
        theme: 'tooltipster-punk'
    });
});

</script>
<?php

include 'includes/footer.php';

?>