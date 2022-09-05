<?php
include 'includes/headerConocimientos.php';
?>

<?php 
  echo $cuerpo_mail;
?>

<?php
include 'includes/footer.php';
?>
<!--<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>bootstrap4</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>
  </head>
  <body>
  	<input value="Editar" name="editar" id="btnEditar" type="button" data-toggle="modal" data-target="#miModal">

	    <div id="miModal" class="modal fade" role="dialog">
	      <div class="modal-dialog">

	        <div class="modal-content">
	          <div class="modal-header">
	            <h5>Editar Mensaje</h5>
	            <button type="button" class="close" data-dismiss="modal">&times;</button>
	          </div>
	          <div class="modal-body">
	            <div name="editorModal" id="editorModal" class="summernote">Mensaje de la base de datos</div>
	          </div>
	          <div class="modal-footer">
	            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	            <button value="aceptar" id="aceptar" type="button" name="aceptar" class="btn btn-primary submitBtn" onclick="prueba()">Aceptar</button>
	          </div>
	        </div>
	      </div>
	    </div>
    <script>
      $('.summernote').summernote({
        placeholder: 'Hello bootstrap 4',
        tabsize: 2,
        height: 100
      });
      function prueba()
      {
      	var markupStr = $('.summernote').summernote('code');
      	alert(markupStr);
      }
    </script>
  </body>
</html>-->