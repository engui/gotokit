<?php

include 'includes/headerContrasenyas.php';

?>

<div class="row">
	<div class="col-xl-5 col-lg-4 col-md-0 col-sm-0">
		<form action="<?php echo base_url(); ?>vercontrasenya_controller/actualizarContrasenya" method="post">
		<!--<form class="py-3" action="<?php echo base_url(); ?>vercontrasenya_controller/prueba" method="post">-->	
			<input type="hidden" name="cod_contrasenya" value="<?php echo $cod_contrasenya; ?>">
			<table class="form-gotosystem actualizar-usuario w-100">
				<thead>
                	<th colspan="2">Editar Contraseña</th>
             	</thead>
             	<tbody>
             		<tr>
                    	<td>Asunto:</td>
                    	<td class="px-4 py-2" style="width: 75%;"><input class="form-control" name="nombreContrasenya" type="text" value="<?php echo $datos_contrasenyas->nombre; ?>"></td>
                	</tr>
                	<tr>
                		<td>
						<?php
                      		echo (ucfirst(STR_CLIENTE).'s:'); 
                    	?>
						</td>
                		<td class="px-4 py-2">
                			<select class="form-control" id="menuClientes" multiple="multiple" name="clientesContrasenya[]">
                            <?php
                                //**************************************************************************************************
                                $contador = 0; 
                                for ($c=0; $c < count($clientes) ; $c++) 
                                { 
                                  if($clientes[$c]['id'] == $clientes_contrasenya[$contador]['id_cliente'])
                                  {
                                    echo '<option value="'.$clientes[$c]['id'].'" selected>'.$clientes[$c]['nombre'].'</option>';
                                    if($contador < count($clientes_contrasenya))
                                      $contador++;
                                  }
                                  else
                                  {
                                    echo '<option value="'.$clientes[$c]['id'].'">'.$clientes[$c]['nombre'].'</option>';
                                  }
                                }
                                //**************************************************************************************************
                            ?>
                       		</select>
                		</td>
                	</tr>
                	<tr>
                		<td>Fecha Creación:</td>
                		<td class="px-4 py-2">
	                    	<input class="form-control" name="fechaContrasenya" type="date" value="<?php echo $datos_contrasenyas->fecha_creada; ?>" readonly>
	                    </td>
                	</tr>
                	<tr>
                		<td>Hora Creación:</td>
                		<td class="px-4 py-2">
                			<input class="form-control" name="fechaContrasenya" type="time" value="<?php echo $datos_contrasenyas->hora_creada; ?>" readonly>
                		</td>
                	</tr>
                	<tr>
                    	<td colspan="2"><input class="btn btn-lg btn-gotosystem btn-block" value="Actualizar" type="submit"></td>
                 	</tr>
             	</tbody>
			</table>
		</form>
	</div>
	<div class="col-xl-7 col-lg-8 col-md-12 col-sm-12 px-5">
        <!--<form id="Form" class="py-3" action="<?php echo base_url(); ?>vertarea_controller/nuevoMensaje" method="post" enctype='multipart/form-data'>-->
        <table class="form-gotosystem actualizar-usuario w-100" id="tablaMensajes">
            <thead>
            	<th colspan="3">Mensaje</th>
                <th></th>
            </thead>
            <tbody>
            	<tr>
            		<td colspan="3" class="dont-break-out"><?php echo $datos_contrasenyas->mensaje;?></td>
            	</tr>   
            </tbody>
            <tfoot>
				<tr>
					<td colspan="3">
						<input class="btn btn-lg btn-gotosystem btn-block" value="Editar Mensaje" name="editar" type="button" data-toggle="modal" data-target="#Modal">
					</td>
					<!-- Modal -->
            <div id="Modal" class="modal fade" role="dialog">
              	<div class="modal-dialog">
                <!-- Contenido del modal -->
                  <div class="modal-content">
                    	<div class="modal-header">
                        <h5>Editar Mensaje</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    	</div>
                    	<div class="modal-body">
                      	<textarea name="editorModal" id="editorModal"><?php echo $datos_contrasenyas->mensaje;?></textarea>
                      	<!--<input type="hidden" name="cod_tareaModel" value="'.$cod_tarea.'">-->
                    	</div>
                    	<div class="modal-footer">
                      	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      	<button value="aceptar" id="aceptar" type="submit" name="aceptar" class="btn btn-primary submitBtn" data-dismiss="modal" onclick="submitForm()">Aceptar</button>
                    	</div>
                  </div>
              	</div>
            </div>
				</tr>
            </tfoot> 
         </table>
    </div>
</div>
<script>
	function submitForm()
    {
    	var Mensaje = $('#editorModal').summernote('code');

    	$.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>vercontrasenya_controller/editarMensaje",
            data: {mensaje:Mensaje,cod_contrasenya:<?php echo $datos_contrasenyas->cod_contraseña;?>},
            success: function()
            {
                window.location.reload();
            }
        });
    }
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#menuClientes').multiselect({
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			numberDisplayed: 3,
			nonSelectedText: 'Selecciona los clientes',
			buttonWidth: '300px'
		});
		var x = document.getElementsByClassName("multiselect-search");
		var buscador = x[0];
		buscador.placeholder = "Buscar"; 
	});
</script>
<script>
    $(document).ready(function() {
        $("#editorModal").summernote({
        	toolbar: [
          	// [groupName, [list of button]]
          	["style", ["style","bold", "italic", "underline", "clear"]],
          	["para", ["ul", "ol"]]
        	]
        });
      });
</script>
<?php

include 'includes/footer.php';

?>