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
        <form class="py-3" id="FormNuevaTarea" action="<?php echo base_url(); ?>crear-nueva-tarea" method="post" enctype='multipart/form-data' autocomplete="off">
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
                    <td>
                      <?php 
                        echo ucfirst(STR_CLIENTE).'s:';
                      ?>
                    </td>
                    
                    <td class="px-4 py-2">
                    <div class="input-group mb-3">
                    
                    <select id="menuClientes" class="custom-select" name="clientesTarea[]" multiple="multiple">
                          <?php
                              foreach($clientes as $cliente)
                              {
                                  echo '<option value="'.$cliente['id'].'">'.$cliente['nombre'].'</option>';
                              }
                          ?>
                    </select>
                    <div class="input-group-prepend">
                      <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#botonnuevocliente">Nuevo</button>
                    </div>
                      
                      
                    </div>
                    </td>
                  </tr>  

                    <!-- Modal -->
<div class="modal fade" id="botonnuevocliente" tabindex="-1" role="dialog" aria-labelledby="botonnuevoclienteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="botonnuevoclienteLabel">Nuevo Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modalnuevocliente">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon3">Nombre</span>
          </div>
          <input type="text" class="form-control" id="nuevocliente_nombre" aria-describedby="basic-addon3">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon3">Teléfono</span>
          </div>
          <input type="text" class="form-control" id="nuevocliente_telefono" aria-describedby="basic-addon3">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon3">Dirección</span>
          </div>
          <input type="text" class="form-control" id="nuevocliente_direccion" aria-describedby="basic-addon3">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon3">Código postal</span>
          </div>
          <input type="text" class="form-control" id="nuevocliente_cp" aria-describedby="basic-addon3">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon3">Población</span>
          </div>
          <input type="text" class="form-control" id="nuevocliente_poblacion" aria-describedby="basic-addon3">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon3">Provincia</span>
          </div>
          <input type="text" class="form-control" id="nuevocliente_provincia" aria-describedby="basic-addon3">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon3">País</span>
          </div>
          <input type="text" class="form-control" id="nuevocliente_pais" aria-describedby="basic-addon3">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="boton_nuevo_cliente_crear" class="btn btn-primary">Crear Cliente</button>
      </div>
    </div>
  </div>
</div>                 
                    
                        
                        
                  
                  
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
                
                <td class="px-4 py-2">
                  <div class="input-group mb-3">
                    <input class="form-control" id="fechaTarea" name="fechaTarea" type="date"> 
                  </div>  
                </td>
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
                        
                      </td>
                  </tr>

                  <tr>
                    <td>Usuario activo:</td>
                      <td class="px-4 py-2">
                        <select class="form-control" name="usuario_activo" id="menuUsuarioActivo" >
                          
                        </select>
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
  var usuarios = $("#menuUsuarios").val();
  var asunto = $("#asunto").val();
  var mensaje = $("#editor").val();

  if(asunto == "")
  {
    mensajeError += 'La tarea debe tener un asunto.<br>';
  }
  if(usuarios == "")
  {
    mensajeError += 'La tarea debe tener al menos un usuario.<br>';
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

$(document).on('click', '#boton_nuevo_cliente_crear',  function(){
  var nombre = $("#nuevocliente_nombre").val();
  var telefono = $("#nuevocliente_telefono").val();
  var direccion = $("#nuevocliente_direccion").val();
  var cp = $("#nuevocliente_cp").val();
  var poblacion = $("#nuevocliente_poblacion").val();
  var provincia = $("#nuevocliente_provincia").val();
  var pais = $("#nuevocliente_pais").val();
  
  $.ajax({
      type:"POST",
      url:"<?php echo base_url(); ?>mantenimiento_clientes_controller/insertarCliente",
      data: {nombre:nombre, telefono:telefono, direccion:direccion, cp:cp, poblacion: poblacion, provincia: provincia, pais: pais},
      success: function(response)
      {
        var data = {
            id: response,
            text: nombre
        };

        var newOption = new Option(data.text, data.id, true, true);
        $('#menuClientes').append(newOption).trigger('change');
        $("#nuevocliente_nombre").val("");
        $("#nuevocliente_telefono").val("");
        $("#nuevocliente_direccion").val("");
        $("#nuevocliente_cp").val("");
        $("#nuevocliente_poblacion").val("");
        $("#nuevocliente_provincia").val("");        
        $("#nuevocliente_pais").val("");        
        $('#botonnuevocliente').modal('toggle');

      }
  });  


});

function cargarUsuariosActivos($primeravez=false)
{
  var res_cod = ($('#menuUsuarios').val());
  var res_text = $('#menuUsuarios').select2('data');
  var usuario_activo = $('#menuUsuarioActivo').val();
  $('#menuUsuarioActivo').empty().trigger('change');
  $.each(res_cod,function(indice, codigo) {
    var texto = res_text[indice].text;
    var newOption = new Option(texto, codigo, false, false);
    $('#menuUsuarioActivo').append(newOption).trigger('change');  
  });
  $('#menuUsuarioActivo').val(usuario_activo).trigger('change');
}
  
  

$('#menuUsuarioActivo').select2({theme: 'bootstrap4', allowClear: true,placeholder: "Dejar así si no hay activo"});


$(document).on('change', '#menuUsuarios',  function(){
  cargarUsuariosActivos();
});


$("select").on("select2:unselect", function (evt) {
     if (!evt.params.originalEvent) return;
     evt.params.originalEvent.stopPropagation();
   });




$(document).ready(function() {
                              
          $('#menuClientes').select2({
            theme: 'bootstrap4',
            placeholder: "Pincha para seleccionar",
            });

            $('#menuUsuarios').select2({
            theme: 'bootstrap4',
            placeholder: "Pincha para seleccionar",
            });

            cargarUsuariosActivos();
                        
});


</script>
<?php
include 'includes/footer.php';
?>



