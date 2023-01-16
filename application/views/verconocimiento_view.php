<?php

include 'includes/headerConocimientos.php';

?>

<div class="row">
	<div class="col-xl-5 col-lg-4 col-md-0 col-sm-0">
		<form action="<?php echo base_url(); ?>verconocimiento_controller/actualizarConocimiento" method="post">
		<!--<form class="py-3" action="<?php echo base_url(); ?>verconocimiento_controller/prueba" method="post">-->	
			<input type="hidden" name="cod_conocimiento" value="<?php echo $cod_conocimiento; ?>">
			<table class="form-gotosystem actualizar-usuario w-100">
				<thead>
                	<th colspan="2">Editar Conocimiento</th>
             	</thead>
             	<tbody>
             		<tr>
                    	<td>Asunto:</td>
                    	<td class="px-4 py-2" style="width: 75%;"><input class="form-control" name="nombreConocimiento" type="text" value="<?php echo $datos_conocimiento->nombre; ?>"></td>
                	</tr>
                	<tr>
                		<td>Etiquetas:</td>
                		<td class="px-4 py-2">
	                        <select id="menuEtiquetas" multiple="multiple" name="etiquetasConocimiento[]">
	                            <?php
	                                //**************************************************************************************************
	                                $contador = 0; 
	                                for ($c=0; $c < count($etiquetas) ; $c++) 
	                                { 
										if($etiquetas[$c]['cod_etiqueta'] == $etiquetas_conocimiento[$contador]['cod_etiqueta'])
										{
											echo '<option value="'.$etiquetas[$c]['cod_etiqueta'].'" selected>'.$etiquetas[$c]['nombre'].'</option>';
											if($contador < count($etiquetas_conocimiento))
												$contador++;
										}
										else
										{
											echo '<option value="'.$etiquetas[$c]['cod_etiqueta'].'">'.$etiquetas[$c]['nombre'].'</option>';
										}
	                                }
	                                //**************************************************************************************************
	                            ?>
	                       	</select>
	                    </td>
                	</tr>
                	<tr>
                		<td>
						<?php
                      		echo (ucfirst(STR_CLIENTE).'s:'); 
                    	?>
						</td>
                		<td class="px-4 py-2">
                			<select class="form-control" id="menuClientes" multiple="multiple" name="clientesConocimiento[]">
                            <?php
                                //**************************************************************************************************
                                $contador = 0; 
                                for ($c=0; $c < count($clientes) ; $c++) 
                                { 
                                  if($clientes[$c]['id'] == $clientes_conocimiento[$contador]['id_cliente'])
                                  {
                                    echo '<option value="'.$clientes[$c]['id'].'" selected>'.$clientes[$c]['nombre'].'</option>';
                                    if($contador < count($clientes_conocimiento))
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
	                    	<input class="form-control" name="fechaConocimiento" type="date" value="<?php echo $datos_conocimiento->fecha_creada; ?>" readonly>
	                    </td>
                	</tr>
                	<tr>
                		<td>Hora Creación:</td>
                		<td class="px-4 py-2">
                			<input class="form-control" name="fechaConocimiento" type="time" value="<?php echo $datos_conocimiento->hora_creada; ?>" readonly>
                		</td>
                	</tr>
                	<tr>
                    	<td colspan="2"><input class="btn btn-lg btn-gotosystem btn-block" value="Actualizar" type="submit"></td>
                 	</tr>
             	</tbody>
			</table>
		</form>
		<table class="form-gotosystem actualizar-usuario w-100">
			<?php 
				$num_archivos_mensajes = count($rutasArchivos);
				if($num_archivos_mensajes > 0)
				{
					echo "<thead>
						<th>Archivos Adjuntos</th>
					</thead>
					<tbody>";
				
					foreach ($rutasArchivos as $rutaArchivo) 
					{
						$trozos = explode("/", $rutaArchivo['ruta']);
						echo '<tr><td><a class="enlacesArchivos" href="'.base_url().$rutaArchivo['ruta'].'" download>'.end($trozos).'</a></td>';
						echo '<td><input value="" name="borrar'.$rutaArchivo["cod_archivo"].'" id="btnBorrar'.$rutaArchivo["cod_archivo"].'" type="button" class="botonBorrarMensaje" onclick="borrarMensaje('.$datos_conocimiento->cod_conocimiento.','.$rutaArchivo["cod_archivo"].')"></td></tr>';
					}
				}
			?>
				<?php if($rutasArchivos != null) 
               	{
               	?>
					<form action="<?php echo base_url(); ?>verconocimiento_controller/descargarCarpeta" method="post" enctype='multipart/form-data'>
						<input type="hidden" name="cod_conocimiento" value="<?php echo $datos_conocimiento->cod_conocimiento;?>">
						<tr><td colspan="2"><input class="btn btn-lg btn-gotosystem btn-block" name="descargar" value="Descargar Carpeta" type="submit"></td></tr>
					</form>
        		<?php 
        		}
        		?>
			</tbody>
		</table>
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
            		<td colspan="3" class="dont-break-out"><?php echo $datos_conocimiento->mensaje;?></td>
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
	                            	<textarea name="editorModal" id="editorModal"><?php echo $datos_conocimiento->mensaje;?></textarea>
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
         <form id="" action="<?php echo base_url(); ?>verconocimiento_controller/anyadirArchivos" method="post" enctype='multipart/form-data'>
         	<input type="hidden" name="cod_conocimiento" value="<?php echo $datos_conocimiento->cod_conocimiento;?>">
	        <table class="form-gotosystem actualizar-usuario w-100" id="tablaAnyadirArchivos">
	    		<thead>
	    			<th>Añadir Archivos</th>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td colspan="3">
	                     	<div class="custom-file">
	                        	<input class="custom-file-input multi" type="file" name="files[]" multiple id="archivosTareas">
	                        	<label class="custom-file-label" for="archivosTareas">Elige ficheros...</label>
	                      	</div>
	                    </td>
	    			</tr>
	    			<tr>
	    				<td><input class="btn btn-lg btn-gotosystem btn-block" value="Añadir Archivos" name="anyadirArchivos" type="submit"></td>
	    			</tr>
	    		</tbody>
	    	</table>
    	</form>
    </div>
</div>
<script>
	$('#menuEtiquetas').selectize({
		plugins: ['remove_button'],
	    delimiter: ',',
	    persist: false,
	    create: function(input) {
	        return {
	            value: input,
	            text: input
	        }
	    }
	});
</script>
<script>
	function submitForm()
    {
    	var Mensaje = $('#editorModal').summernote('code');

    	$.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>verconocimiento_controller/editarMensaje",
            data: {mensaje:Mensaje,cod_conocimiento:<?php echo $datos_conocimiento->cod_conocimiento;?>},
            success: function()
            {
                window.location.reload();
            }
        });
    }
</script>
<script>
	function borrarMensaje(cod_conocimiento,cod_archivo)
	{
	  var r = confirm("¿Estás seguro de que quieres borrar este archivos?");
	  if(r == true)
	  {
	    $.ajax({
	      type:"POST",
	      url:"<?php echo base_url(); ?>verconocimiento_controller/borrarArchivo",
	      data: {cod_conocimiento:cod_conocimiento,cod_archivo:cod_archivo},
	      success: function()
	      {
	          window.location.reload();
	      }
	    });
	  }
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