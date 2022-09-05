<?php

include 'includes/header-login.php';

?>

<body class="text-center">
    
    <form class="form-signin" action="<?php echo base_url(); ?>iniciar-sesion" method="post">
      <img class="mb-4" src="<?php echo base_url(); ?>assets/images/logo-agenda.png" alt="" width="auto" height="72"><br>Virginia's Edition
        <?php
     
        if(isset($mensaje_error))
        {
    ?>
     
     <div class="alert alert-danger" role="alert"><?php echo $mensaje_error; ?></div>
     
     <?php
            
        }
     
     ?>
      <h1 class="h3 mb-3 font-weight-normal"></h1>
      <label for="inputEmail" class="sr-only">Correo Electrónico</label>
      <input type="search" autocomplete="off" value="<?php echo ($cookie_usuario);?>" type="email" name="usuarioEmail" id="usuarioEmail" class="form-control" placeholder="Correo Electrónico" required autofocus>
      <label for="inputPassword" class="sr-only">Contraseña</label>
      <input type="search" autocomplete="off" value="<?php echo ($cookie_password);?>" type="password" name="usuarioPassword" id="usuarioPassword" class="form-control" placeholder="Contraseña" required>
      <div class="checkbox mb-3">
        <input <?php if ($cookie_recuerdame=='on') echo ('checked');?> class="checkbox" type="checkbox" id="recordarcheck" name="recordarPanel"><label for="recordarcheck">Recordar en este equipo</label>
      </div>
      <button class="btn btn-lg btn-gotosystem btn-block" type="submit">Iniciar Sesión</button>
     
    </form>
  </body>
</html>



