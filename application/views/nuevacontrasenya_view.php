<?php

include 'includes/headerContrasenyas.php';

?>

<div class="row">
	<div class="col-xl-2 col-lg-2 col-md-0 col-sm-0"></div>
	<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 px-5">
		<?php
		if(isset($mensaje_error))
		{
		?>
		<div class="alert alert-danger mt-4" role="alert"><?php echo $mensaje_error; ?></div>
		<?php    
		}
		?>
		<form class="py-3" action="<?php echo base_url(); ?>crear-nueva-contrasenya" method="post" enctype='multipart/form-data' id="FormNuevoContrasenya">
			<h1 class="pb-1 text-center">Nueva Contraseña</h1>
			<table class="form-gotosystem actualizar-usuario w-100">
				<tbody>
				<tr>
	                <td>Asunto:</td>
	                <td class="px-4 py-2" style="width: 75%;"><input class="form-control" id="asunto" name="nombreContrasenya" type="text" value=""></td>
                </tr>
                <tr>
                  <td>
                  <?php
                      echo (ucfirst(STR_CLIENTE).'s:'); 
                    ?>
                  </td>
                  <td class="px-4 py-2">
                    <select multiple name="clienteContrasenya[]" id="menuClientes">
                      <?php
                        foreach($clientes as $cliente)
                        {
                            echo '<option value="'.$cliente['id'].'">'.$cliente['nombre'].'</option>';
                        }
                      ?> 
                    </select>
                  </td>
                </tr>
                <tr>
                 	<td>Mensaje:</td>
                    <td class="px-4 py-2 editor-gotosystem">
                        <textarea class="dont-break-out" name="mensaje" id="editor"></textarea>
                        <script>
                          $(document).ready(function() {
                            $('#editor').summernote({
                                toolbar: [
                              // [groupName, [list of button]]
                              ['style', ['style','bold', 'italic', 'underline', 'clear']],
                              ['para', ['ul', 'ol']]
                            ],
                            width: 450
                            });
                          });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="px-5 pt-3"> <input class="btn btn-lg btn-gotosystem btn-block" value="Crear Contraseña" type="button" onclick="comprobarCampos()"></td>
                </tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
<script>

$('#menuClientes').multiselect({
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  numberDisplayed: 4,
  nonSelectedText: 'Selecciona los clientes',
  buttonWidth: '450px'
});

function comprobarCampos()
{
  var mensajeError = '';
  var form = document.getElementById("FormNuevoContrasenya");
  var asunto = $("#asunto").val();
  var mensaje = $("#editor").val();
  var clientes = $("#menuClientes").val();

  if(asunto == "")
  {
    mensajeError += 'La contraseña debe tener un asunto.<br>';
  }
  if(mensaje == "")
  {
    mensajeError += 'La contraseña debe tener un mensaje.<br>';
  }
  if(clientes == "")
  {
    mensajeError += 'La contraseña debe tener un cliente.<br>';
  }

  if (mensajeError == '')
  {
    form.submit();
  }
  else
  {
    Swal.fire({
        type: 'error',
        title: 'Error al crear',
        html: mensajeError
    })
  }
  
}
                          
</script>
<?php

include 'includes/footer.php';

?>