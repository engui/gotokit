<?php

include 'includes/header.php';

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
        <form class="py-3" id="FormNuevaTarea" action="<?php echo base_url(); ?>crear-nueva-tarea" method="post" enctype='multipart/form-data'>
        <!--<form class="py-3" action="<?php echo base_url(); ?>nuevatarea_controller/prueba" method="post" enctype='multipart/form-data'> -->
          <input type="hidden" name="cod_usuario" value="">
            <h1 class="pb-1 text-center">Nueva Tarea</h1>
              <table class="form-gotosystem actualizar-usuario w-100">
                <tbody>
                  <tr>
                    <td>Asunto:</td>
                    <td class="px-4 py-2" style="width: 75%;"><input id="asunto" class="form-control" name="nombreTarea" type="text" value=""></td>
                  </tr>
                  <tr>
                    <td>Clientes:</td>
                    <td class="px-4 py-2">
                        <select id="menuClientes" name="clientesTarea[]" multiple="multiple">
                          <?php
                              foreach($clientes as $cliente)
                              {
                                  echo '<option value="'.$cliente['id'].'">'.$cliente['nombre'].'</option>';
                              }
                          ?>
                        </select>
                        <script type="text/javascript">
                          $(document).ready(function() {
                              /*$('#menuClientes').multiselect({
                                  enableFiltering: true,
                                  enableCaseInsensitiveFiltering: true,
                                  numberDisplayed: 4,
                                  nonSelectedText: 'Selecciona los clientes',
                                  buttonWidth: '450px'
                              });*/
                              $('#menuClientes').select2({
                                theme: 'bootstrap4'
                               });
                        
                          });
                        </script>
                      </td>
                  </tr>
                  <tr>
                    <td>Prioridad:</td>      
                    <td class="px-4 py-2">
                      <select class="form-control" name="prioridad">
                          <option value="ALTA">ALTA</option>
                          <option value="MEDIA" selected>MEDIA</option>
                          <option value="BAJA">BAJA</option>
                      </select>
                    </td>
                  </tr>
                  
                  <tr>
                <td>Fecha límite:</td>
                <td class="px-4 py-2"><input class="form-control" name="fechaTarea" type="date"> </td>
                  </tr>

                  <tr>
                  
                  <!-- enguifacturable!-->
                  
                  <tr>
                    <td>Descripción:</td>
                    <td class="px-4 py-2 editor-gotosystem">
                        <textarea name="content" id="editor"></textarea>
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
                    <td>Usuarios:</td>
                      <td class="px-4 py-2">
                        <select class="form-control" multiple="multiple" name="usuarioTarea[]" id="menuUsuarios" >
                          <?php
                            foreach($usuarios as $usuario)
                            {
                                $seleccionado = "";
                                if ($cod_usuario==$usuario['cod_usuario']) $seleccionado=" selected ";
                                echo '<option '.$seleccionado.' value="'.$usuario['cod_usuario'].'">'.$usuario['nombre'].'</option>';
                            }
                          ?>
                        </select>
                        <script type="text/javascript">
                          $(document).ready(function() {
                              $('#menuUsuarios').multiselect({
                                  enableFiltering: true,
                                  enableCaseInsensitiveFiltering: true,
                                  numberDisplayed: 4,
                                  nonSelectedText: 'Selecciona los usuarios',
                                  buttonWidth: '450px'
                              });
                              
                          });
                        </script>
                      </td>
                  </tr>
                  
                  
                  
                  <tr>
                    <td>Archivos:</td>
                    <td class="px-4 py-2">
                      <div class="custom-file">
                        <input class="multi custom-file-input" type="file" name="files[]" multiple id="archivosTareas">
                        <label class="custom-file-label" for="archivosTareas">Elige ficheros...</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="px-5 pt-3"> <input class="btn btn-lg btn-gotosystem btn-block" value="Crear Tarea" type="button" onclick="comprobarCampos()"></td>
                  </tr>
                </tbody>
              </table>
        </form>
    </div>
    <div class="col-xl-2 col-lg-2 col-md-0 col-sm-0"></div>
</div>
<script>



function comprobarCampos()
{
  //$('.btn-gotosystem').prop('disabled',true);
  $.LoadingOverlay("show");
  var mensajeError = '';
  var form = document.getElementById("FormNuevaTarea");
  var etiquetas = $("#menuUsuarios").val();
  var asunto = $("#asunto").val();
  var mensaje = $("#editor").val();

  if(asunto == "")
  {
    mensajeError += 'La tarea debe tener un asunto.<br>';
  }
  if(etiquetas == "")
  {
    mensajeError += 'La tarea debe tener al menos una etiqueta.<br>';
  }
  if(mensaje == "")
  {
    mensajeError += 'La tarea debe tener un mensaje.<br>';
  }

  if (mensajeError == '')
  {
    form.submit();
  }
  else
  {
    $.LoadingOverlay("hide");
    Swal.fire({
        type: 'error',
        title: 'Error al crear',
        html: mensajeError
    })
  }
}

function timeout (ms) {
  return new Promise(res => setTimeout(res,ms));
}


</script>
<?php
include 'includes/footer.php';
?>


