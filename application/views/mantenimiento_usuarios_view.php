<?php

include 'includes/headerMantenimiento.php';

?>

<div class="row">
	<div class="col-xl-5 col-lg-4 col-md-0 col-sm-0">
		<table class="form-gotosystem actualizar-usuario w-100">
			<thead>
                <th colspan="2">Usuarios</th>
            </thead>
            <tbody>
            	<tr>
            		<td>
            			<select name="clienteConocimiento[]" id="menuUsuarios" onchange="myFunction()">
                      <?php
                        foreach($usuarios as $usuario)
                        {
                            echo '<option value="'.$usuario['cod_usuario'].'">'.$usuario['nombre'].'</option>';
                        }
                      ?> 
                    </select>
            		</td>
            	</tr>
                <tr>
                    <td><input style="display: none;" type="button" name="volver" value="↼" id="volver" class="btn btn-lg btn-gotosystem" onclick="volver()"></td>
                </tr>
            </tbody>
		</table>
	</div>
	<div class="col-xl-7 col-lg-8 col-md-12 col-sm-12 px-5">
		<table class="form-gotosystem actualizar-usuario w-100">
			<thead>
                <th colspan="4">Datos</th>
            </thead>
            <tbody>
            	<tr>
            		<td>Nombre:</td>
            		<td colspan="2"><input class="form-control" type="text" name="nombreUsuario" id="nombreUsuario"></td>
            	</tr>
                <tr>
                    <td>Email:</td>
                    <td colspan="2"><input class="form-control" type="email" name="emailUsuario" id="emailUsuario"></td>
                </tr>
                <tr>
                    <td>Contraseña:</td>
                    <td colspan="2"><input class="form-control" type="password" name="contraseñaUsuario" id="contraseñaUsuario"></td>
                </tr>
                <tr>
                    <td>Activo:</td>
                    <td colspan="2"><input class="checkbox" type="checkbox" id="activoUsuario" name="activoUsuario"><label for="activoUsuario">&nbsp;</label></td>
                </tr>
            	<tr>
            		<td>Color:</td>            		
            		<td colspan="2"><input class="form-control" type="text" id="colorUsuario" name="colorUsuario" value="#" onblur="evitarVacio()"/><div id="colorpicker"></div></td>
            	</tr>
                <tr>
                    <td>Super:</td>
                    <td colspan="2"><input class="checkbox" type="checkbox" id="superUsuario" name="superUsuario"><label for="superUsuario">&nbsp;</label></td>
                </tr>
                <tr>
                    <td>Ver Contraseñas:</td>
                    <td colspan="2"><input class="checkbox" type="checkbox" id="verContrasenyas" name="verContrasenyas"><label for="verContrasenyas">&nbsp;</label></td>
                </tr>
                <tr>
                    <td id="celdaBotonInsertar" colspan="2"><input type="button" name="Insertar" value="Insertar" id="Insertar" class="btn btn-lg btn-gotosystem btn-block" onclick="insertarUsuario()"></td>
                    <td colspan="2" id="celdaBotonModificar" style="display: none;"><input type="button" name="Modificar" value="Modificar" id="Modificar" class="btn btn-lg btn-gotosystem btn-block" onclick="modificarUsuario()"></td>
                    <td colspan="2" id="celdaBotonBorrar" style="display: none;"><input style="background-color: #ff0000; border-color: #ff0000;" type="button" name="Borrar" value="Borrar" id="Borrar" class="btn btn-lg btn-gotosystem btn-block" onclick="eliminarUsuario()"></td>
                </tr>
            </tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		/*$('#menuUsuarios').multiselect({
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			numberDisplayed: 3,
			nonSelectedText: 'Selecciona los usuarios',
			buttonWidth: '300px'
		});*/
        $('#menuUsuarios').select2({
            theme: 'bootstrap4',
            placeholder: 'Selecciona usuario',
            width: '100%' 
        });
        $("#menuUsuarios").val("")
        $("#menuUsuarios").trigger("change");
		
		var x = document.getElementsByClassName("multiselect-search");
		var buscador = x[0];
		buscador.placeholder = "Buscar"; 
	});
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#colorpicker').farbtastic('#colorUsuario');
  });

function evitarVacio()
{
    if ($('#colorUsuario').val() == '')
    {
        $('#colorUsuario').val("#");
    }
}

function volver()
{
    location.reload();
    $('#menuUsuarios').val('defecto');
    $('#celdaBotonModificar').hide();
    $('#celdaBotonInsertar').show();
    $('#celdaBotonBorrar').hide();
    $('#volver').hide();  

    $('#nombreUsuario').val("");
    $('#emailUsuario').val("");
    $('#colorUsuario').val("#");
    $("#activoUsuario").prop("checked",false);
    $("#superUsuario").prop("checked",false); 
    $("#verContrasenyas").prop("checked",false);
}

function myFunction()
{
    var x = document.getElementById("menuUsuarios").value;
    if (x=="") exit;
    $('#celdaBotonModificar').show();
    $('#celdaBotonInsertar').hide();
    $('#celdaBotonBorrar').show();
    $('#volver').show();

    

	
    //document.getElementById("nombreUsuario").value = "a";
	$.ajax({
        type:"POST",
        dataType: 'json',
        url:"<?php echo base_url(); ?>mantenimiento_usuarios_controller/obtenerDatos",
        data: {cod_usuario:x},
        success: function(datos)
        {
            //window.location.reload();
            document.getElementById("nombreUsuario").value = datos[0]["nombre"];
            document.getElementById("colorUsuario").value = datos[0]["color_usuario"];
            $("#colorUsuario").css("background-color", datos[0]["color_usuario"]);
            $.farbtastic('#colorpicker').setColor(datos[0]["color_usuario"]);
            document.getElementById("emailUsuario").value = datos[0]["email"];
            document.getElementById("contraseñaUsuario").value = datos[0]["password"];
            if (datos[0]["activo"] == 1)
            {
                $("#activoUsuario").prop("checked",true);
            }
            else
            {
                $("#activoUsuario").prop("checked",false);
            }
            if (datos[0]["super"] == 1)
            {
                $("#superUsuario").prop("checked",true);
            }
            else
            {
                $("#superUsuario").prop("checked",false);   
            }
            if (datos[0]["verContraseñas"] == 1)
            {
                $("#verContrasenyas").prop("checked",true);
            }
            else
            {
                $("#verContrasenyas").prop("checked",false);   
            }
        }
    });
}

function insertarUsuario()
{
    var mensajeError = '';
    var cod_usuario = document.getElementById("menuUsuarios").value;
    var nombre = $("#nombreUsuario").val();
    var color = $("#colorUsuario").val();

    var email = $("#emailUsuario").val(); 
    var comprobacionEmail = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    var contrasenya = $("#contraseñaUsuario").val();

    var activo;
    if($('#activoUsuario').prop('checked')) 
    {
        activo = 1;
    }
    else
    {
        activo = 0;
    }
    var admin;
    if($('#superUsuario').prop('checked'))
    {
        admin = 1;
    }
    else
    {
        admin = 0;
    }
    var verContrasenyas;
    if($('#verContrasenyas').prop('checked'))
    {
        verContrasenyas = 1;
    }
    else
    {
        verContrasenyas = 0;
    }

    if(nombre == "")
    {
        mensajeError += 'Se necesita un nombre para el usuario.<br>';
    }
    if(color.length != 7)
    {
        mensajeError += 'El color especificado no es correcto.<br>';
    }
    if(!comprobacionEmail.test($('#emailUsuario').val().trim()))
    {
        mensajeError += 'El correo no es válido.<br>';
    }
    if(contrasenya.length == 0)
    {
        mensajeError += 'Se necesita una contraseña.<br>';
    }
    if(mensajeError == '') //https://todoprogramacion.com.ve/tutoriales/validar-campos-email-con-jquery
    {
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>mantenimiento_usuarios_controller/insertarUsuario",
            data: {nombre:nombre,color:color,email:email,contrasenya:contrasenya,activo:activo,admin:admin,verContrasenyas:verContrasenyas},
            success: function()
            {
                //window.location.reload();
                Swal.fire({
                    type: 'success',
                    title: 'El usuario ha sido insertado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })
                setTimeout("location.reload()",1500);
                $('#nombreUsuario').val("");
                $('#emailUsuario').val("");
                $('#colorUsuario').val("#");
                $("#activoUsuario").prop("checked",false);
                $("#superUsuario").prop("checked",false);
                $("#verContrasenyas").prop("checked",false);
            },
            error: function()
            {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Error al conectar con la base de datos!'
                })
            }
        }); 
    }
    else
    {
        Swal.fire({
          type: 'error',
          title: 'Error al insertar',
          html: mensajeError
        })
    }
}

function modificarUsuario()
{
    var mensajeError = '';
    var cod_usuario = document.getElementById("menuUsuarios").value;
    var nombre = $("#nombreUsuario").val();
    var color = $("#colorUsuario").val();

    var email = $("#emailUsuario").val(); 
    var comprobacionEmail = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    var contrasenya = $("#contraseñaUsuario").val();

    var activo;
    if($('#activoUsuario').prop('checked')) 
    {
        activo = 1;
    }
    else
    {
        activo = 0;
    }
    var admin;
    if($('#superUsuario').prop('checked'))
    {
        admin = 1;
    }
    else
    {
        admin = 0;
    }
    var verContrasenyas;
    if($('#verContrasenyas').prop('checked'))
    {
        verContrasenyas = 1;
    }
    else
    {
        verContrasenyas = 0;
    }
    if(nombre == "")
    {
        mensajeError += 'Se necesita un nombre para el usuario.<br>';
    }
    if(color.length != 7)
    {
        mensajeError += 'El color especificado no es correcto.<br>';
    }
    if(!comprobacionEmail.test($('#emailUsuario').val().trim()))
    {
        mensajeError += 'El correo no es válido.<br>';
    }
    if(contrasenya.length == 0)
    {
        mensajeError += 'Se necesita una contraseña.<br>';
    }
    if(cod_usuario != "defecto")//if(mensajeError == "" )
    {
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>mantenimiento_usuarios_controller/modificarUsuario",
            data: {cod_usuario:cod_usuario,nombre:nombre,color:color,email:email,contrasenya:contrasenya,activo:activo,admin:admin,verContrasenyas:verContrasenyas},
            success: function()
            {
                if(mensajeError != '')
                {
                    Swal.fire({
                        type: 'error',
                        title: 'Error al modificar',
                        html: mensajeError
                    })
                }
                else
                {
                //window.location.reload();
                    Swal.fire({
                        type: 'success',
                        title: 'El usuario ha sido actualizado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout("location.reload()",1500);
                    $('#nombreUsuario').val("");
                    $('#emailUsuario').val("");
                    $('#colorUsuario').val("#");
                    $("#activoUsuario").prop("checked",false);
                    $("#superUsuario").prop("checked",false);
                    $("#menuUsuarios").val("defecto");
                    $("#verContrasenyas").prop("checked",false);
                }
            },
            error: function()
            {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Error al conectar con la base de datos!'
                })
            }
        }); 
    }
    else
    {
        Swal.fire({
            type: 'error',
            title: 'Error al modificar',
            text: 'Recuerda tener seleccionado el cliente en la lista.'
        })
    }
}

function eliminarUsuario() //consultar tareas,conocimientos, lintareas, reltareacliente, reltareausuariodest
{
    var cod_usuario = document.getElementById("menuUsuarios").value;
    Swal.fire({
        title: '¿Estás seguro que quieres borrar este usuario?',
        text: "¡Ya no podrás desacerlo!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, borralo!'
    }).then((result) => {
        if (result.value) {
            if(cod_usuario != "defecto")
            {
                $.ajax({
                    type:"POST",
                    dataType: 'json',
                    url:"<?php echo base_url(); ?>mantenimiento_usuarios_controller/eliminarUsuario",
                    data: {cod_usuario:cod_usuario},
                    success: function(data)
                    {
                        if (data[0] == "Funciona")
                        {
                            Swal.fire({
                                type: 'success',
                                title: '¡Borrado!',
                                text: 'El cliente ha sido borrado correctamente.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout("location.reload()",1500);
                            $('#nombreUsuario').val("");
                            $('#emailUsuario').val("");
                            $('#colorUsuario').val("#");
                            $("#activoUsuario").prop("checked",false);
                            $("#superUsuario").prop("checked",false);
                            $("#menuUsuarios").val("defecto");
                            $("#verContrasenyas").prop("checked",false);
                        }
                        else
                        {
                        var mensajeError = '';
                        for (var i = 0; i < data.length; i++)
                        {
                            if(data[i] == 0)
                            {
                                mensajeError += 'Este usuario tiene al menos una tarea creada.<br>';
                            }
                            if(data[i] == 1)
                            {
                                mensajeError += 'Este usuario tiene al menos un conocimiento creado.<br>';
                            }
                            if(data[i] == 2)
                            {
                                mensajeError += 'Este usuario tiene al menos un mensaje en una tarea.<br>';
                            }
                            if(data[i] == 3)
                            {
                                mensajeError += 'Este usuario tiene al menos una tarea asignada.<br>'; 
                            }
                        }
                        Swal.fire({
                            type: 'error',
                            title: 'Error al eliminar',
                            html: mensajeError
                        })
                        }
                    },
                    error: function()
                    {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error al conectar con la base de datos!'
                        })
                    }
                });
            }
            else
            {
                Swal.fire({
                    type: 'error',
                    title: 'Error al eliminar',
                    text: 'Recuerda tener seleccionado el cliente en la lista.'
                })   
            }
        }
    })
}
</script>
<?php

include 'includes/footer.php';

?>