<?php

include 'includes/headerMantenimiento.php';

?>

<div class="row">
	<div class="col-xl-5 col-lg-4 col-md-0 col-sm-0">
		<table class="form-gotosystem actualizar-usuario w-100">
			<thead>
                <th colspan="2">Etiquetas</th>
            </thead>
            <tbody>
            	<tr>
            		<td>
            			<select name="etiquetaConocimiento[]" id="menuEtiquetas" onchange="myFunction()">
                            <option selected value="defecto" id="defecto"> -- Selecciona una Etiqueta -- </option>
                      <?php
                        foreach($etiquetas as $etiqueta)
                        {
                            echo '<option value="'.$etiqueta['cod_etiqueta'].'">'.$etiqueta['nombre'].'</option>';
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
            		<td colspan="2"><input class="form-control" type="text" name="nombreEtiqueta" id="nombreEtiqueta"></td>
            	</tr>
            	<tr>
            		<td>Color:</td>            		
            		<td colspan="2"><input class="form-control" type="text" id="colorEtiqueta" name="colorEtiqueta" value="#" onblur="evitarVacio()"/><div id="colorpicker"/><div id="colorpicker" style="color: #000000"></div></td>
            	</tr>
                <tr>
                    <td id="celdaBotonInsertar" colspan="2"><input type="button" name="Insertar" value="Insertar" id="Insertar" class="btn btn-lg btn-gotosystem btn-block" onclick="insertarEtiqueta()"></td>
                    <td colspan="2" id="celdaBotonModificar" style="display: none;"><input type="button" name="Modificar" value="Modificar" id="Modificar" class="btn btn-lg btn-gotosystem btn-block" onclick="modificarEtiqueta()"></td>
                    <td colspan="2" id="celdaBotonBorrar" style="display: none;"><input style="background-color: #ff0000; border-color: #ff0000;" type="button" name="Borrar" value="Borrar" id="Borrar" class="btn btn-lg btn-gotosystem btn-block" onclick="eliminarEtiqueta()"></td>
                </tr>
            </tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#menuEtiquetas').multiselect({
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			numberDisplayed: 3,
			nonSelectedText: 'Selecciona los etiquetas',
			buttonWidth: '300px'
		});
		var x = document.getElementsByClassName("multiselect-search");
		var buscador = x[0];
		buscador.placeholder = "Buscar"; 
	});
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#colorpicker').farbtastic('#colorEtiqueta');
  });

function evitarVacio()
{
    if ($('#colorEtiqueta').val() == '')
    {
        $('#colorEtiqueta').val("#");
    }
}

function volver()
{
    location.reload();
    $('#menuEtiquetas').val('defecto');
    $('#celdaBotonModificar').hide();
    $('#celdaBotonInsertar').show();
    $('#celdaBotonBorrar').hide();
    $('#volver').hide();  

    $('#nombreEtiqueta').val("");
    $('#colorEtiqueta').val("#");

    
}

function myFunction()
{
    $('#celdaBotonModificar').show();
    $('#celdaBotonInsertar').hide();
    $('#celdaBotonBorrar').show();
    $('#volver').show();

    

	var x = document.getElementById("menuEtiquetas").value;
    //document.getElementById("nombreEtiqueta").value = "a";
	$.ajax({
        type:"POST",
        dataType: 'json',
        url:"<?php echo base_url(); ?>mantenimiento_etiquetas_controller/obtenerDatos",
        data: {cod_etiqueta:x},
        success: function(datos)
        {
            //window.location.reload();
            document.getElementById("nombreEtiqueta").value = datos[0]["nombre"];
            document.getElementById("colorEtiqueta").value = datos[0]["color"];
            $("#colorEtiqueta").css("background-color", datos[0]["color"]);
            $.farbtastic('#colorpicker').setColor(datos[0]["color"]);
        }
    });
}

function insertarEtiqueta()
{
    var cod_etiqueta = document.getElementById("menuEtiquetas").value;
    var nombre = $("#nombreEtiqueta").val();
    var color = $("#colorEtiqueta").val();
    if(nombre != "" && color.length == 7)
    {
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>mantenimiento_etiquetas_controller/insertarEtiqueta",
            data: {nombre:nombre,color:color},
            success: function()
            {
                //window.location.reload();
                Swal.fire({
                    type: 'success',
                    title: 'El etiqueta ha sido insertado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })
                setTimeout("location.reload()",1500);
                $('#nombreEtiqueta').val("");
                $('#colorEtiqueta').val("#");
            }
        }); 
    }
    else
    {
        Swal.fire({
          type: 'error',
          title: 'Error al insertar',
          text: 'El etiqueta necesita un nombre y/o el color no es correcto'
        })
    }
}

function modificarEtiqueta()
{
    var mensajeError = '';
    var cod_etiqueta = document.getElementById("menuEtiquetas").value;
    var nombre = $("#nombreEtiqueta").val();
    var color = $("#colorEtiqueta").val();
    if(nombre == "")
    {
        mensajeError += 'Se necesita un nombre para el usuario.<br>';
    }
    if(color.length != 7)
    {
        mensajeError += 'El color especificado no es correcto.<br>';
    }
    if(cod_etiqueta != "defecto")
    {
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>mantenimiento_etiquetas_controller/modificarEtiqueta",
            data: {cod_etiqueta:cod_etiqueta,nombre:nombre,color:color},
            success: function()
            {
                if(mensajeError != "")
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
                        title: 'La etiqueta ha sido actualizado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout("location.reload()",1500);
                    $('#nombreEtiqueta').val("");
                    $('#colorEtiqueta').val("#");
                    $("#menuEtiquetas").val("defecto");
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

function eliminarEtiqueta()
{
    var cod_etiqueta = document.getElementById("menuEtiquetas").value;
    Swal.fire({
        title: '¿Estás seguro que quieres borrar esta etiqueta?',
        text: "¡Ya no podrás desacerlo!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, borralo!'
    }).then((result) => {
        if (result.value) {
            if(cod_etiqueta != "defecto")
            {
                $.ajax({
                    type:"POST",
                    url:"<?php echo base_url(); ?>mantenimiento_etiquetas_controller/eliminarEtiqueta",
                    data: {cod_etiqueta:cod_etiqueta},
                    success: function()
                    {
                        Swal.fire({
                            type: 'success',
                            title: '¡Borrado!',
                            text: 'El etiqueta ha sido borrado correctamente.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        //window.location.reload();
                        setTimeout("location.reload()",1500);
                        $('#nombreEtiqueta').val("");
                        $('#colorEtiqueta').val("#");
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
                    text: 'Recuerda tener seleccionado la etiqueta en la lista.'
                })   
            }
        }
    })
}
</script>
<?php

include 'includes/footer.php';

?>