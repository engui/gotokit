<?php

include 'includes/header.php';

?>
<form id="FormNuevoM" action="<?php echo base_url(); ?>vertarea_controller/nuevoMensaje" method="post" enctype='multipart/form-data'>
<div class="row">

  <div class="col-xl-5 col-lg-4 col-md-0 col-sm-0">
    <?php
      if(isset($mensaje_confirmacion))
      {
    ?>
        <div class="alert alert-success mt-4" role="alert"><?php echo $mensaje_confirmacion; ?></div>
    <?php
            
      }    
    ?>
    <?php
      if(isset($mensaje_error))
      {
    ?>
        <div class="alert alert-danger mt-4" role="alert"><?php echo $mensaje_error; ?></div>
    <?php
      }
    ?>
    <?php
      $ver = False;
      for($i=0; $i < count($usuariosAsignados); $i++) 
      { 
        if($usuario_session['cod_usuario'] == $usuariosAsignados[$i]['usuario_destino'])
        {
          $ver = True;
          break;
        }
      }
      //if($usuario_session['cod_usuario']==$datos_tarea->usuario_origen)
      if($ver == True || $usuario_session['cod_usuario']==$datos_tarea->usuario_origen || $this->session->userdata('super')==1)
      {
    ?>
        <div class="titulo-editar">Editar Tarea</div>
          <input type="hidden" id="cod_tarea" name="cod_tarea" value="<?php echo $cod_tarea; ?>">
          <input type="hidden" id="usuario_activo" value="<?php echo $datos_tarea->usuario_activo;?>">
          <table class="form-gotosystem actualizar-usuario w-100">
            <thead>
            </thead>
            <tbody>
              <tr>
                <td>Asunto:</td>
                <td class="px-4 py-2" style="width: 75%;"><input class="form-control" name="nombreTarea" id="nombreTarea" type="text" value="<?php echo $datos_tarea->nombre; ?>"></td>
              </tr>
              <tr>
                  <td>Clientes:</td>
                  <td class="px-4 py-2">
                    <select class="form-control" id="menuClientes" multiple="multiple" name="clientesTarea[]">
                      <?php
                        //**************************************************************************************************
                        $contador = 0; 
                        for ($c=0; $c < count($clientes) ; $c++) 
                        { 
                          if($clientes[$c]['id'] == $tareasClientes[$contador]['id_cliente'])
                          {
                            echo '<option value="'.$clientes[$c]['id'].'" selected>'.$clientes[$c]['nombre'].'</option>';
                            if($contador < count($tareasClientes))
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
                    <script type="text/javascript">
                      $(document).ready(function() {
                        
                      });
                    </script>
                  </td>
                </tr>
              <tr>
                <td>Prioridad:</td> 
                <td class="px-4 py-2">
                <select class="form-control" name="prioridad">
                    <?php
                      $sel=" ";
                      if ($prioridad=='ALTA') $sel = " selected ";
                      echo ("<option value='ALTA'".$sel.">ALTA</option>");
                      $sel=" ";
                      if ($prioridad=='MEDIA') $sel = " selected ";
                      echo ("<option value='MEDIA'".$sel.">MEDIA</option>");
                      $sel=" ";
                      if ($prioridad=='BAJA') $sel = " selected ";
                      echo ("<option value='BAJA'".$sel.">BAJA</option>");
                    ?>                  
                    </select>   


                </td>     
              </tr>
              <tr>
                <td>Fecha límite:</td>
                <td class="px-4 py-2"><input class="form-control" id="fechaTarea" name="fechaTarea" type="date" value="<?php echo $datos_tarea->fecha_limite; ?>" ></td>
              <tr>
              </tr>
              
              
              <!-- enguifacturable!-->


              <tr>
                <td>Usuarios:</td>
                <td class="px-4 py-2">
                  <select class="form-control" id="menuUsuarios" multiple="multiple" name="usuarioTarea[]">
                    <?php
                      //**************************************************************************************************
                      $contador = 0; 
                      for ($c=0; $c < count($usuarios) ; $c++) 
                      { 
                        if($usuarios[$c]['cod_usuario'] == $usuariosAsignados[$contador]['usuario_destino'])
                        {
                          echo '<option value="'.$usuarios[$c]['cod_usuario'].'" selected>'.$usuarios[$c]['nombre'].'</option>';
                          if($contador < count($usuariosAsignados))
                            $contador++;
                        }
                        else
                        {
                          echo '<option value="'.$usuarios[$c]['cod_usuario'].'">'.$usuarios[$c]['nombre'].'</option>';
                        }
                      }
                      //**************************************************************************************************
                    ?>
                  </select>
                  <script type="text/javascript">
                    $(document).ready(function() {
                      
                      /*$('#menuUsuarios').multiselect({
                          enableFiltering: true,
                          enableCaseInsensitiveFiltering: true,
                          numberDisplayed: 6,
                          nonSelectedText: 'Selecciona los clientes',
                          buttonWidth: '300px'
                      });*/

                      
                      var x = document.getElementsByClassName("multiselect-search");
                      var buscador1 = x[0];
                      buscador1.placeholder = "Buscar"; 
                    });
                  </script>
                </td>
              </tr>

              <tr>
                <td>Usuario activo:</td>
                <td class="px-4 py-2">
                  <select class="form-control" id="menuUsuarioActivo" name="usuarioActivo">
                    
                  </select>
                </td>
              </tr>

                <tr>
                  <td>Estado:</td>
                  <td class="px-4 py-2" >
                    <select class="form-control" name="estadoTarea">
                    <?php
                      foreach($estados as $estado)
                      {
                        if($estado['cod_estado']==$datos_tarea->estado)
                        {
                            echo '<option value="'.$estado['cod_estado'].'" selected>'.$estado['descripcion'].'</option>';
                        }
                        else
                        {
                            echo '<option value="'.$estado['cod_estado'].'">'.$estado['descripcion'].'</option>';
                        }
                      }
                    ?>                  
                    </select>
                  </td>
                </tr>
                
                
                
            </tbody>
          </table>
        
        
    <?php
      }
      /*else if($this->session->userdata('super')==1)
      {*/
    ?>
        <!--<form class="py-3" action="<?php echo base_url(); ?>vertarea_controller/actualizarEstadoTarea" method="post">
          <input type="hidden" name="cod_tarea" value="<?php echo $cod_tarea; ?>">
          <table class="form-gotosystem actualizar-usuario w-100">
            <thead>
              <th>Editar Tarea</th>
            </thead>
            <tbody>
              <tr>
                <td>Asunto:</td>
                <td class="px-4 py-2" style="width: 75%;"><input class="form-control" name="nombreTarea" type="text" value="<?php echo $datos_tarea->nombre; ?>" readonly></td>
              </tr>
              <tr>
                <td>Usuarios:</td>
                <td class="px-4 py-2">
                  <select class="form-control" id="menuUsuarios" multiple="multiple" name="usuarioTarea[]" disabled="">
                    <?php
                        //**************************************************************************************************
                        $contador = 0; 
                        for ($c=0; $c < count($usuarios) ; $c++) 
                        { 
                          if($usuarios[$c]['cod_usuario'] == $usuariosAsignados[$contador]['usuario_destino'])
                          {
                            echo '<option value="'.$usuarios[$c]['cod_usuario'].'" selected>'.$usuarios[$c]['nombre'].'</option>';
                            if($contador < count($usuariosAsignados))
                              $contador++;
                          }
                          else
                          {
                            echo '<option value="'.$usuarios[$c]['cod_usuario'].'">'.$usuarios[$c]['nombre'].'</option>';
                          }
                        }
                        //**************************************************************************************************
                    ?>
                  </select>
                  <script type="text/javascript">
                    $(document).ready(function() {
                      $('#menuUsuarios').multiselect({
                          enableFiltering: true,
                          enableCaseInsensitiveFiltering: true,
                          numberDisplayed: 6,
                          nonSelectedText: 'Selecciona los clientes',
                          buttonWidth: '200px'
                      });
                    });
                  </script>
                </td>
              </tr>
              <tr>
                <td>Estado:</td>
                <td class="px-4 py-2" >
                  <select class="form-control" name="estadoTarea" >
                  <?php
                    foreach($estados as $estado)
                    {
                      if($estado['cod_estado']==$datos_tarea->estado)
                      {
                          echo '<option value="'.$estado['cod_estado'].'" selected>'.$estado['descripcion'].'</option>';
                      }
                      else
                      {
                          echo '<option value="'.$estado['cod_estado'].'">'.$estado['descripcion'].'</option>';
                      }
                    }
                  ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Fecha límite:</td>
                <td class="px-4 py-2"><input class="form-control" name="fechaTarea" type="date" value="<?php echo $datos_tarea->fecha_limite; ?>" readonly></td>
              </tr>
              <tr>
                <td>Hora límite:</td>
                <td class="px-4 py-2"><input class="form-control" name="horaTarea" type="time" value="<?php
                        $date = DateTime::createFromFormat( 'H:i:s', $datos_tarea->hora_limite);
                        $hora_limite = $date->format('H:i');
                        echo $hora_limite;
                    ?>" readonly></td>
              </tr>
              <tr>
                <td>Clientes:</td>
                <td class="px-4 py-2">
                  <select class="form-control" id="menuClientes" multiple="multiple" name="clientesTarea[]" disabled>
                    <?php
                        //**************************************************************************************************
                        $contador = 0;
                        for ($c=0; $c < count($clientes) ; $c++) 
                        { 
                            if($clientes[$c]['id'] == $tareasClientes[$contador]['id_cliente'])
                            {
                                echo '<option value="'.$clientes[$c]['id'].'" selected>'.$clientes[$c]['nombre'].'</option>';
                                if($contador < count($tareasClientes))
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
                  <script type="text/javascript">
                    $(document).ready(function() {
                        $('#menuClientes').multiselect({
                          enableFiltering: true,
                          enableCaseInsensitiveFiltering: true,
                          numberDisplayed: 3,
                          nonSelectedText: 'No hay clientes',
                          buttonWidth: '200px'
                        });
                    });
                  </script>
                </td>
              </tr>
              <tr>
                <td> <input class="btn btn-lg btn-gotosystem btn-block" value="Actualizar estado" type="submit"></td>
              </tr>
            </tbody>
          </table>
        </form>
        <?php 
          if($rutasArchivos != null) 
          {
        ?>
            <form action="<?php echo base_url(); ?>vertarea_controller/descargarCarpeta" method="post" enctype='multipart/form-data'>
              <input type="hidden" name="cod_tarea" value="<?php echo $cod_tarea; ?>">
              <input class="btn btn-lg btn-gotosystem btn-block" name="descargar" value="Descargar Carpeta" type="submit">
            </form>
        <?php 
          }
        ?>
      <?php
        //}
      ?>-->
    </div>
    <?php
      if ($ver == True || $usuario_session['cod_usuario']==$datos_tarea->usuario_origen || $this->session->userdata('super')==1) 
      {
    ?>
    <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12 px-5">
      
        <input type="hidden" name="cod_tarea" value="<?php echo $cod_tarea; ?>">
        <input type="hidden" name="cod_usuario" value="<?php echo $usuario_session['cod_usuario']; ?>">
        <table class="form-gotosystem actualizar-usuario w-100 col-xl-7 col-lg-8 col-md-12 col-sm-12 px-5" id="tablaMensajes">
             <thead>
                <th colspan="3">Conversación</th>
                <th></th>
             </thead>
             <tbody>
                 <?php
                 
                    $num_mensajes=count($conversacion);
                    $num_archivos_mensajes = count($rutasArchivos);
                    //print_r($rutasArchivos);
                    if($num_mensajes>0)
                    {
                        foreach($conversacion as $linea)
                        {

                            $fecha_linea=$linea['fecha'];
                            $hora_linea=$linea['hora'];
                            $mensaje_linea=$linea['mensaje'];
                            $cod_usuario_linea=$linea['cod_usuario'];
                            $cod_linea=$linea['cod_linea'];
                            $minutos = $linea['minutos'];

                            $horas = floor($minutos/60);
                            $minutos = $minutos - ($horas*60);
                            $texto_horas = "horas";
                            if ($horas==1) $texto_horas="hora";

                            if($usuario_session['cod_usuario']==$cod_usuario_linea)
                            {
                             $nombre_usuario='Yo';
                            }
                            else
                            {
                             $nombre_usuario=$linea['nombre'];
                            }

                            $color_usuario=$linea['color_usuario'];

                            $date = DateTime::createFromFormat( 'Y-m-d', $fecha_linea);
                            $fecha_linea_formateada = $date->format('d-m-Y');
            
                            $date = DateTime::createFromFormat( 'H:i:s', $hora_linea);
                            $hora_linea_formateada = $date->format('H:i');
                            echo '<tr>';
                            echo '<td class="mensaje dont-break-out">';
                            echo '<span style="font-weight: 600; color: '.$color_usuario.';">'.$nombre_usuario.'</span> <span style="font-style: italic; font-size: 13px;">- Enviado el '.$fecha_linea_formateada.' a las '.$hora_linea_formateada.' horas</span><br>';
                            echo $mensaje_linea;
                            //hacer bucle comparando los cod_linea********
                            if($num_archivos_mensajes > 0)
                            {
                              foreach ($rutasArchivos as $rutaArchivo) 
                              {
                                $cod_linea_archivo = $rutaArchivo['cod_linea'];
                                if($cod_linea == $cod_linea_archivo)
                                {
                                  $trozos = explode("/", $rutaArchivo['ruta']);
                                  echo '<a class="enlacesArchivos" href="'.base_url().$rutaArchivo['ruta'].'" download>'.end($trozos).'</a><br>';
                                }
                              }
                            }
                            
                            //echo "<p contenteditable>Hola</p>";
                            //echo '<textarea name="mensaje" id="editor" rows="20">'.$mensaje_linea.'</textarea>';
                            //echo '<input name="Hola" value="Hola">';
                            echo '</td>';
                            
                            //echo "<br>";
                            //if($usuario_session['cod_usuario']==$datos_tarea->usuario_origen)
                            if($usuario_session['cod_usuario']==$cod_usuario_linea)
                            {
                                $select_horas = '<select class="form-control" id="tiempo_editar_horas'.$cod_linea.'">';
                                for ($i=0;$i<=200;$i++)
                                {
                                  $seleccionado = " ";
                                  if ($i==$horas) $seleccionado=" selected ";
                                  $select_horas.= "<option ".$seleccionado." value=".$i.">".$i." horas </option>";
                                }
                                $select_horas.='</select>';
                                $select_minutos = '<select class="form-control" id="tiempo_editar_minutos'.$cod_linea.'">';
                                for ($i=0;$i<60;$i+=15)
                                {
                                  $seleccionado = " ";
                                  if ($i==$minutos) $seleccionado=" selected ";
                                  $select_minutos.= "<option ".$seleccionado." value=".$i.">".$i." minutos </option>";
                                }
                                $select_minutos.='</select>';

                                echo '<td>';
                                echo '<input value="" name="editar'.$cod_linea.'" id="btnEditar'.$cod_linea.'" type="button" data-toggle="modal" data-target="#miModal'.$cod_linea.'" class="botonEditarMensaje">';
                                echo '</td>';
                                echo '<td>';
                                echo '<input value="" name="borrar'.$cod_linea.'" id="btnBorrar'.$cod_linea.'" type="button" class="botonBorrarMensaje" onclick="borrarMensaje('.$cod_linea.')">';
                                echo '<!-- Modal -->
                                        <div id="miModal'.$cod_linea.'" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                            <!-- Contenido del modal -->
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5>Editar Mensaje</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              </div>
                                              <div class="modal-body">
                                                <textarea name="editorModal'.$cod_linea.'" id="editorModal'.$cod_linea.'">'.$mensaje_linea.'</textarea>
                                                <input type="hidden" name="cod_tareaModel" value="'.$cod_tarea.'">
                                                <div class="row" style="margin-top:10px">
                                                <!--<div class="col-sm-4">Tiempo:</div>
                                                <div class="col-sm-4">'.$select_horas.'</div>
                                                <div class="col-sm-4">'.$select_minutos.'</div>-->
                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <button value="aceptar'.$cod_linea.'" id="aceptar'.$cod_linea.'" type="button" name="aceptar'.$cod_linea.'" class="btn btn-primary submitBtn" onclick="submitForm('.$cod_linea.','.$cod_usuario_linea.')" data-dismiss="modal">Aceptar</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>';
                                        
                                echo '</td>';
                                

                            }
                            else
                            {
                              echo "<td></td>";
                              echo "<td></td>"; 
                            }
                                    
                            echo '</tr>';
                            //echo '<tr style="border-bottom:1px solid grey"><td colspan="3" style="background-color:white"><span style="text-align:right;float:right;font-style: italic; font-size: 13px;background-color:white">'.$horas.' '.$texto_horas.' '.$minutos.' minutos</span></td></tr>';
                            
                            echo '<script>
                              $(document).ready(function() {
                                  $("#editorModal'.$cod_linea.'").summernote({
                                      toolbar: [
                                    // [groupName, [list of button]]
                                    ["style", ["style","bold", "italic", "underline", "clear"]],
                                    ["para", ["ul", "ol"]]
                                  ]
                                });
                              });
                            </script>';
                        }
                    }
                    else
                    {
                      echo '<tr>';
                      echo '<td style="text-align: center; padding-top: 50px; padding-bottom: 50px;">';
                      echo '<span style="font-weight: 600; font-style: italic;">No hay mensajes que mostrar</span>';
                               

                      echo '</td>';
                      echo '</tr>';
                    }
                ?>
                <script>
                  function submitForm(cod_linea,cod_usuario)
                  {
                    var Mensaje = $('#editorModal'+cod_linea).summernote('code');
                    var horas = $('#tiempo_editar_horas'+cod_linea).val();
                    var minutos = $('#tiempo_editar_minutos'+cod_linea).val();
                    $.ajax({
                        type:"POST",
                        url:"<?php echo base_url(); ?>vertarea_controller/editarMensaje",
                        data: {horas:horas, minutos:minutos, mensaje:Mensaje,cod_linea:cod_linea,cod_tarea:<?php echo $cod_tarea;?>,cod_usuario:cod_usuario},
                        success: function()
                        {
                            window.location.reload();
                        }
                    });  
                  }
                  function borrarMensaje(cod_linea)
                  {
                    var r = confirm("¿Estás seguro de que quieres borrar este mensaje?(Los archivos adjuntos también se borrarán)");
                    if(r == true)
                    {
                      $.ajax({
                        type:"POST",
                        url:"<?php echo base_url(); ?>vertarea_controller/borrarMensaje",
                        data: {cod_linea:cod_linea,cod_tarea:<?php echo $cod_tarea;?>},
                        success: function()
                        {
                            window.location.reload();
                        }
                      });
                    }
                  }
                </script>
                
                <tr>
                  <td>
                    &nbsp;
                  </td>
                </tr>

                </tbody>
                 <tfoot class="foot-tabla">
                 <tr>
                    <td colspan="3" class="editor-gotosystem"><textarea name="content" id="editor"></textarea></td>
                    <script>
                          $(document).ready(function() {
                            $('#editor').summernote({
                                width: 550,
                                disableDragAndDrop: true,
                                toolbar: [
                              // [groupName, [list of button]]
                              ['style', ['style','bold', 'italic', 'underline', 'clear']],
                              ['para', ['ul', 'ol']]
                            ]
                            });
                          });
                          $(document).ready(function()
                            {
                              //$("#tablaMensajes tr:even").css("background-color", "#F2F2F2"); // filas impares
                              //$("#tablaMensajes tfoot>tr>td").css("background-color", "white");
                            });
                    </script>
                 </tr>
                <!-- <tr>
                    <td colspan="3">
                      <div class="row">      
                      <div class="col-sm-5">Tiempo de ejecución:</div>
                      
                      <select class="form-control col-sm-3" name="tiempo_horas">
                      <?php
                        for ($i=0;$i<=200;$i++)
                        {
                          echo ("<option value=".$i.">".$i." horas </option>");
                        }
                      ?>
                      </select>
                      <select class="form-control col-sm-3" name="tiempo_minutos" style="margin-left:10px">
                      <?php
                        for ($i=0;$i<60;$i+=15)
                        {
                          echo ("<option value=".$i.">".$i." minutos </option>");
                        }
                      ?>
                      </select>
                      <div class="col-sm-1"></div>
                      </div>
                    </td>  
                  </tr>-->

                   <tr>
                    <td colspan="3" class="px-4 py-2">
                      <div class="custom-file">
                        <input class="custom-file-input multi" type="file" name="files[]" multiple id="archivosTareas">
                        <label class="custom-file-label" for="archivosTareas">Elige ficheros...</label>
                      </div>
                    </td>
                   </tr>
                   
                 </tfoot> 
                 
                 
                 
         </table>
        
    </div>
    <?php
      }
      else
      {
    ?>
        <script type="text/javascript">
          Swal.fire({
            type: 'warning',
            title: 'No tienes permiso para acceder a esta tarea',
            allowEscapeKey: false,
            allowOutsideClick: false
          }).then((result) => {
            if (result.value) 
            {
              window.location.href = "<?php echo base_url()."inicio" ?>";
            }
          })
        </script>
    <?php
      }
    ?>
</div>

<?php
  $clase = "";
  if ($datos_tarea->fecha_limite==null || $datos_tarea->fecha_limite=="" || $datos_tarea->fecha_limite=="0000-00-00") $clase=" ocultar ";
  //echo ("<a href='".base_url()."generar_ics/".$cod_tarea."'><button id='botonCalendario' style='margin-bottom:20px' type='button' class='".$clase." btn btn-lg btn-info btn-block'>Añadir a calendario</button></a>");
  echo ("<button id='botonCalendario' style='margin-bottom:20px' type='button' class='".$clase." btn btn-lg btn-info btn-block'>Añadir a calendario</button>");
?>

<input class="btn btn-lg btn-gotosystem btn-block" id="botonG" value="Enviar" name="enviar" type="submit" onclick="comprobarCampos()">
</form>

<?php 
       
        if($rutasArchivos != null) 
        {
        ?>
            <form action="<?php echo base_url(); ?>vertarea_controller/descargarCarpeta" method="post" enctype='multipart/form-data'>
              <input type="hidden" name="cod_tarea" value="<?php echo $cod_tarea; ?>">
              <input class="btn btn-lg btn-gotosystem btn-block" name="descargar" value="Descargar Carpeta" type="submit">
            </form>
        <?php 
          }
        ?>
<?php

include 'includes/footer.php';

?>

<script>

var nombres = "engui,pepe";

function comprobarCampos()
{
  $.LoadingOverlay("show");
}

function cargarUsuariosActivos($primeravez=false)
{
  var res_cod = ($('#menuUsuarios').val());
  var res_text = $('#menuUsuarios').select2('data');
  var usuario_activo = $('#menuUsuarioActivo').val();
  if ($primeravez) usuario_activo = $('#usuario_activo').val();
  $('#menuUsuarioActivo').empty().trigger('change');
  $.each(res_cod,function(indice, codigo) {
    var texto = res_text[indice].text;
    var newOption = new Option(texto, codigo, false, false);
    $('#menuUsuarioActivo').append(newOption).trigger('change');  
  });
  
  $('#menuUsuarioActivo').val(usuario_activo).trigger('change');
  

}

$(document).on('change', '#menuUsuarios',  function(){
  cargarUsuariosActivos();
});

$(document).on('change','#fechaTarea', function() {
  var fecha=$("#fechaTarea").val();
  if (fecha=="") $("#botonCalendario").addClass("ocultar");
  else $("#botonCalendario").removeClass("ocultar");
});

function download(filename, text) {
  var element = document.createElement('a');
  element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
  element.setAttribute('download', filename);

  element.style.display = 'none';
  document.body.appendChild(element);

  element.click();

  document.body.removeChild(element);
}



$(document).on('click','#botonCalendario', function() {
  titulo = $("#nombreTarea").val();
  fecha = $("#fechaTarea").val();
  cod_tarea = $("#cod_tarea").val();
  clientes = $("#menuClientes").select2('data');
  str_clientes = " (";
  $.each(clientes, function(indice, cliente) 
  {
    str_clientes+=cliente.text+', ';
  });
  str_clientes+=")";
  str_clientes = str_clientes.replace(', )',')');
  str_clientes = str_clientes.replace(' ()','');
  str_clientes = str_clientes.replace(' )',')');
  titulo = titulo + str_clientes;
  $.ajax({
                        type:"POST",
                        url:"/vertarea_controller/generar_ics",
                        data: {cod_tarea: 2, titulo: titulo, fecha:fecha},
                        success: function(respuesta)
                        {
                          download("tarea"+cod_tarea+".ics",respuesta);
                        }
                    });  
});

$("select").on("select2:unselect", function (evt) {
     if (!evt.params.originalEvent) return;
     evt.params.originalEvent.stopPropagation();
   });
   
   $(document).ready(function() {
    $('#menuClientes').select2({theme: 'bootstrap4'});
    $('#menuUsuarios').select2({theme: 'bootstrap4'});
    $('#menuUsuarioActivo').select2({theme: 'bootstrap4', allowClear: true,placeholder: "Dejar así si no hay activo"});
    cargarUsuariosActivos(true);
    
    /*var x = document.getElementsByClassName("multiselect-search");
    var buscador = x[1];
    buscador.placeholder = "Buscar"; */
    
   });

</script>


