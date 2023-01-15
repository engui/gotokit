<?php

include 'includes/header.php';

?>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-5">
		<table class="form-gotosystem actualizar-usuario w-100">
			<thead>
                <th colspan="4">Configuración</th>
            </thead>
            <tbody>
				<tr>
            		<td>Versión gotoagenda:</td>
            		<td colspan="2"><?php echo (VERSION_GOTOAGENDA);?></td>
            	</tr>
				<tr>
            		<td>Actualizaciones:</td>
            		<td colspan="2"><button>Sin actualizaciones pendientes</button></td>
            	</tr>
            	<tr>
            		<td>Usuarios activos:</td>
            		<td colspan="2"><?php echo ($usuariosactivos."/".$maxusuarios);?></td>
            	</tr>
				<tr>
            		<td>Espacion en disco duro:</td>
            		<td colspan="2"><span id="espacio_ocupado">0</span><?php echo ("/".$maxespacio);?></td>
            	</tr>
				<tr>
            		<td>Copia de seguridad base de datos:</td>
            		<td colspan="2"><button id="boton_copia">Descargar copia de seguridad de base de datos</button></td>
            	</tr>
				<tr>
            		<td>Copia de seguridad ficheros adjuntos:</td>
            		<td colspan="2"><button id="boton_copia_adjuntos">Descargar copia de seguridad de ficheros adjuntos</button></td>
            	</tr>
				<tr>
            		<td>Exportar base de datos a csv:</td>
            		<td colspan="2"><button id="exportar_a_csv">Exportar a csv</button></td>
            	</tr>

				
            </tbody>
        </table>
</div>                
    
<script>
	 $.ajax({
              type: "POST",
              url: "configuracion_controller/get_space",
              success: function (response) {
                $("#espacio_ocupado").html(response);
                
              }
            });
	
	$(document).on("click", "#boton_copia", function() {
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: "configuracion_controller/crear_copia_ajax",
			dataType: "json",
			success: function (response) {
				SaveToDisk(response, filename(response));
				$.LoadingOverlay("hide");
			}
		});
	});
	function filename(path){
    path = path.substring(path.lastIndexOf("/")+ 1);
    return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
}
	function SaveToDisk(fileURL, fileName) {
    // for non-IE
    if (!window.ActiveXObject) {
        var save = document.createElement('a');
        save.href = fileURL;
        save.target = '_blank';
        save.download = fileName || 'unknown';

        var evt = new MouseEvent('click', {
            'view': window,
            'bubbles': true,
            'cancelable': false
        });
        save.dispatchEvent(evt);

        (window.URL || window.webkitURL).revokeObjectURL(save.href);
    }

    // for IE < 11
    else if ( !! window.ActiveXObject && document.execCommand)     {
        var _window = window.open(fileURL, '_blank');
        _window.document.close();
        _window.document.execCommand('SaveAs', true, fileName || fileURL)
        _window.close();
    }
	}

	$(document).on("click", "#boton_copia_adjuntos", function() {
    $.LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: "configuracion_controller/crear_copia_ficheros_ajax",
        dataType: "json",
        success: function (response) {
            SaveToDisk(response, filename(response));
            $.LoadingOverlay("hide");
        }
      });
	});

	$(document).on("click","#exportar_a_csv", function() {
    $.LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: "configuracion_controller/exportar_a_csv_ajax",
        dataType: "json",
        success: function (response) {
            SaveToDisk(response, filename(response));
            $.LoadingOverlay("hide");
        }
      });
});

  
</script>

<?php

include 'includes/footer.php';

?>