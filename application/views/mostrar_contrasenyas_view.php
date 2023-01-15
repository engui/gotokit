<?php

include 'includes/headerContrasenyas.php';

?>
<table class="table tabla-tareasConocimiento mt-3" id="tablaContraseñas">
	<thead>
		<tr class="fila-sin-borde">
            <th scope="col"></th>
            <th scope="col" style="width: 320px;">Nombre</th>
            <!--<th scope="col" class="text-center">Etiquetas</th>-->
            <th scope="col" class="text-center">Clientes</th>
            <th scope="col" class="text-center" style="display: none;">Creada</th>
            <th scope="col" class="text-center">Acciones</th>       
        </tr>
	</thead>
	<tbody>
		<?php
			foreach($contraseñas as $contraseña)
            {
            	$cod_contraseña=$contraseña['cod_contraseña'];
            	$nombre=$contraseña['nombre'];
                $clientes=$contraseña['clientes'];
                $colorClientes=$contraseña['colorClientes'];
                $fecha_creada=$contraseña['fecha_creada'];
                $hora_creada=$contraseña['hora_creada'];
                $mensaje=$contraseña['mensaje'];
                
                $date = DateTime::createFromFormat( 'Y-m-d', $fecha_creada);
                $fecha_creada_formateada = $date->format('d-m-Y');
                
                $date = DateTime::createFromFormat( 'H:i:s', $hora_creada);
                $hora_creada_formateada = $date->format('H:i');


                echo '<tr>';
	                echo '<th class="align-middle" scope="row"><input class="checkbox" type="checkbox" id="contraseña'.$cod_contraseña.'" name="contraseña'.$cod_contraseña.'"><label for="contraseña'.$cod_contraseña.'">&nbsp;</label></th>';
	                echo '<th class="align-middle" scope="row"><a href="'.base_url().'contrasenya/'.$cod_contraseña.'">'.$nombre.'</a></th>';
	                echo '<td class="text-center align-middle" style="max-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #FFF;">';
                    for ($i=0; $i <count($clientes) ; $i++) 
                    {
                        echo '<span style="font-weight: 600; background-color: '.$colorClientes[$i].'; color: #FFF; border-radius: 5px; padding-right: 5px; padding-left: 5px;" class="sobretexto" title="'.$clientes[$i].'">'.$clientes[$i].'</span><br>';
                    }
                    echo '</td>';
	                echo '<td class="text-center align-middle" style="display: none;">'.$fecha_creada_formateada.' '.$hora_creada_formateada.'</td>';
	   	?>
	        		<td class="text-center align-middle"><a class="mr-2" href="<?php echo base_url(); ?>contrasenya/<?php echo $cod_contraseña; ?>"><img src="<?php echo base_url(); ?>assets/images/actions/edit.png" width="auto" height="20" title="Editar Contraseña"/></a><a onclick="return confirm('¿Estás seguro de que quieres eliminar esta contraseña?');" class="ml-2" href="<?php echo base_url(); ?>eliminar-contrasenya/<?php echo $cod_contraseña; ?>"><img src="<?php echo base_url(); ?>assets/images/actions/delete.png" width="auto" height="20" title="Eliminar Contraseña"/></a>
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
    $('#tablaContraseñas').DataTable({
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
            { "width": "30%", "targets": 2 },
            { "width": "5%", "targets": 4 },
            { "width": "10%", "targets": 0 }
        ]
    });
} );

/*$("#tablaConocimientos").on("mouseenter", "td", function() {
  $(this).attr('title', this.innerText);
});*/
</script>
<style type="text/css">
    .page-item.active .page-link 
    {
        z-index: 1;
        color: #fff;
        background-color: #35cc00;
        border-color: #35cc00;
    }
    .page-link 
    {
        color: #35cc00;
    }

</style>
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