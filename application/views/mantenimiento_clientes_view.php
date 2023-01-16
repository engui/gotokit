<?php

include 'includes/headerMantenimiento.php';

?>

<div class="row">
	<div class="col-xl-5 col-lg-4 col-md-0 col-sm-0">
		<table class="form-gotosystem actualizar-usuario w-100">
			<thead>
                <th colspan="2">
                    <?php
                      echo (ucfirst(STR_CLIENTE).'s'); 
                    ?>
                </th>
            </thead>
            <tbody>
            	<tr>
            		<td>
            			<select name="clienteConocimiento[]" id="menuClientes" onchange="myFunction()">
                            
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
                    <td>Tipo</td>
                    <td colspan="2">    
                        <select name="tipo" id="tipoCliente">
                            <option value="LEAD">LEAD</option>
                            <option selected value="CLIENTE">CLIENTE</option>
                            <option value="PROVEEDOR">PROVEEDOR</option>
                        </select>
                    </td>    
                </tr>    
            	<tr>
            		<td>Nombre:</td>
            		<td colspan="2"><input class="form-control" type="text" name="nombreCliente" id="nombreCliente"></td>
            	</tr>
                <tr>
            		<td>Teléfono:</td>
            		<td colspan="2"><input class="form-control" type="text" name="telefonoCliente" id="telefonoCliente"></td>
            	</tr>
                <tr>
            		<td>Dirección:</td>
            		<td colspan="2"><input class="form-control" type="text" name="direccionCliente" id="direccionCliente"></td>
            	</tr>
                <tr>
            		<td>Código Postal:</td>
            		<td colspan="2"><input class="form-control" type="text" name="cpCliente" id="cpCliente"></td>
            	</tr>
                <tr>
            		<td>Población:</td>
            		<td colspan="2"><input class="form-control" type="text" name="poblacionCliente" id="poblacionCliente"></td>
            	</tr>
                <tr>
            		<td>Provincia:</td>
            		<td colspan="2"><input class="form-control" type="text" name="provinciaCliente" id="provinciaCliente"></td>
            	</tr>
                <tr>
            		<td>País:</td>
            		<td colspan="2"><input class="form-control" type="text" name="paisCliente" id="paisCliente"></td>
            	</tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            	<!--<tr>
            		<td>Color:</td>            		
            		<td colspan="2"><input class="form-control" type="text" id="colorCliente" name="colorCliente" value="#" onblur="evitarVacio()" /><div id="colorpicker" style="color: #000000"></div></td>
            	</tr>-->
                <tr>
                    <td id="celdaBotonInsertar" colspan="2"><input type="button" name="Insertar" value="Insertar" id="Insertar" class="btn btn-lg btn-gotosystem btn-block" onclick="insertarCliente()"></td>
                    <td colspan="2" id="celdaBotonModificar" style="display: none;"><input type="button" name="Modificar" value="Modificar" id="Modificar" class="btn btn-lg btn-gotosystem btn-block" onclick="modificarCliente()"></td>
                    <td colspan="2" id="celdaBotonBorrar" style="display: none;"><input style="background-color: #ff0000; border-color: #ff0000;" type="button" name="Borrar" value="Borrar" id="Borrar" class="btn btn-lg btn-gotosystem btn-block" onclick="eliminarCliente()"></td>
                </tr>
            </tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		
        /*$('#menuClientes').multiselect({
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			numberDisplayed: 3,
			nonSelectedText: 'Selecciona los clientes',
			buttonWidth: '300px'
		});*/
        $('#tipoCliente').select2({
            theme: 'bootstrap4',
            placeholder: 'Selecciona tipo',
            width: '100%' 
        });

        $('#menuClientes').select2({
            theme: 'bootstrap4',
            placeholder: 'Selecciona ' + '<?php echo (STR_CLIENTE);?>',
            width: '100%' 
        });

        $("#menuClientes").val("")
        $("#menuClientes").trigger("change");
		
        var x = document.getElementsByClassName("multiselect-search");
		var buscador = x[0];
		buscador.placeholder = "Buscar"; 
	});
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#colorpicker').farbtastic('#colorCliente');
  });

function evitarVacio()
{
    if ($('#colorCliente').val() == '')
    {
        $('#colorCliente').val("#");
    }
}

function volver()
{
    location.reload();
    $('#menuClientes').val('defecto');
    $('#celdaBotonModificar').hide();
    $('#celdaBotonInsertar').show();
    $('#celdaBotonBorrar').hide();
    $('#volver').hide();  

    $('#nombreCliente').val("");
    $('#telefonoCliente').val("");
    $('#direccionCliente').val("");
    $('#cpCliente').val("");
    $('#poblacionCliente').val("");
    $('#provinciaCliente').val("");
    $('#colorCliente').val("#");

    
}

function myFunction()
{
    var x = document.getElementById("menuClientes").value;
    if (x=="") exit;

    $('#celdaBotonModificar').show();
    $('#celdaBotonInsertar').hide();
    $('#celdaBotonBorrar').show();
    $('#volver').show();

    

	//document.getElementById("nombreCliente").value = "a";
	$.ajax({
        type:"POST",
        dataType: 'json',
        url:"<?php echo base_url(); ?>mantenimiento_clientes_controller/obtenerDatos",
        data: {id_cliente:x},
        success: function(datos)
        {
            //window.location.reload();
            document.getElementById("nombreCliente").value = datos[0]["nombre"];
            document.getElementById("telefonoCliente").value = datos[0]["telefono"];
            document.getElementById("direccionCliente").value = datos[0]["direccion"];
            document.getElementById("cpCliente").value = datos[0]["cp"];
            document.getElementById("poblacionCliente").value = datos[0]["poblacion"];
            document.getElementById("provinciaCliente").value = datos[0]["provincia"];
            document.getElementById("paisCliente").value = datos[0]["pais"];
            $("#tipoCliente").val(datos[0]["tipo"]).trigger("change");
            //document.getElementById("colorCliente").value = datos[0]["color"];
            //$("#colorCliente").css("background-color", datos[0]["color"]);
            //$.farbtastic('#colorpicker').setColor(datos[0]["color"]);
        }
    });
}

function insertarCliente()
{
    var cod_cliente = document.getElementById("menuClientes").value;
    var nombre = $("#nombreCliente").val();
    var telefono = $("#telefonoCliente").val();
    var direccion = $("#direccionCliente").val();
    var cp = $("#cpCliente").val();
    var poblacion = $("#poblacionCliente").val();
    var provincia = $("#provinciaCliente").val();
    var pais = $("#paisCliente").val();
    var tipo = $("#tipoCliente").val();
    //var color = $("#colorCliente").val();
    if(nombre != "")
    {
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>mantenimiento_clientes_controller/insertarCliente",
            data: {nombre:nombre, telefono:telefono, direccion:direccion, cp:cp, poblacion:poblacion, provincia:provincia, pais:pais, tipo:tipo},
            success: function()
            {
                //window.location.reload();
                Swal.fire({
                    type: 'success',
                    title: 'El <?php echo (STR_CLIENTE);?> ha sido insertado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })
                setTimeout("location.reload()",1500);
                
            }
        }); 
    }
    else
    {
        Swal.fire({
          type: 'error',
          title: 'Error al insertar',
          text: 'El <?php echo (STR_CLIENTE);?> necesita un nombre'
        })
    }
}

function modificarCliente()
{
    var mensajeError = '';
    var cod_cliente = document.getElementById("menuClientes").value;
    var nombre = $("#nombreCliente").val();
    var telefono = $("#telefonoCliente").val();
    var direccion = $("#direccionCliente").val();
    var cp = $("#cpCliente").val();
    var poblacion = $("#poblacionCliente").val();
    var provincia = $("#provinciaCliente").val();
    var pais = $("#paisCliente").val();
    var tipo = $("#tipoCliente").val();
    if(nombre == "")
    {
        mensajeError += 'Se necesita un nombre para el usuario.<br>';
    }
    /*if(color.length != 7)
    {
        mensajeError += 'El color especificado no es correcto.<br>';
    }*/
    if(cod_cliente != "defecto")
    {
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>mantenimiento_clientes_controller/modificarCliente",
            data: {cod_cliente:cod_cliente,nombre:nombre, telefono:telefono, direccion:direccion, cp:cp, poblacion:poblacion, provincia:provincia, pais: pais, tipo:tipo},
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
                        title: 'El <?php echo (STR_CLIENTE);?> ha sido actualizado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    
                    
                    setTimeout("location.reload()",1500);
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
            text: 'Recuerda tener seleccionado el <?php echo (STR_CLIENTE);?> en la lista.'
        })
    }
}

function eliminarCliente()
{
    var cod_cliente = document.getElementById("menuClientes").value;
    Swal.fire({
        title: '¿Estás seguro que quieres borrar este <?php echo (STR_CLIENTE);?>?',
        text: "¡Ya no podrás desacerlo!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, borralo!'
    }).then((result) => {
        if (result.value) {
            if(cod_cliente != "defecto")
            {
                $.ajax({
                    type:"POST",
                    url:"<?php echo base_url(); ?>mantenimiento_clientes_controller/eliminarCliente",
                    data: {cod_cliente:cod_cliente},
                    success: function()
                    {
                        Swal.fire({
                            type: 'success',
                            title: '¡Borrado!',
                            text: 'El <?php echo (STR_CLIENTE);?> ha sido borrado correctamente.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        //window.location.reload();
                        setTimeout("location.reload()",1500);
                        //$('#nombreCliente').val("");
                        //$('#colorCliente').val("#");
                        /*$("#defecto").prop("disabled",false);
                        $("#defecto").prop("disabled",true);*/
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
                    text: 'Recuerda tener seleccionado el <?php echo (STR_CLIENTE);?> en la lista.'
                })   
            }
        }
    })
}
</script>
<?php

include 'includes/footer.php';

?>