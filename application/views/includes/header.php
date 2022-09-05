<!DOCTYPE html>

<html>

    <head>
        <meta charset="UTF-8">  
        <!-- DESACTIVAR CACHÉ
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
         DESACTIVAR CACHÉ -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-multiselect-master/dist/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/multifile/jquery.MultiFile.js" type="text/javascript" language="javascript"></script>
        <!--<link rel="stylesheet" href="https://getbootstrap.com/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://getbootstrap.com/dist/css/bootstrap.css">-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome/css/fontawesome.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome/css/fontawesome.min.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/select2/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/select2-bootstrap4-theme/select2-bootstrap4.min.css">



         
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/personalizado.css">
        <!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/searchBar.css">-->
        <title>GotoAgenda<?php echo ' - '.$this->session->userdata('titulo_pagina'); ?></title>
        
        <script src='https://unpkg.com/popper.js'></script>
        <script src='https://unpkg.com/tooltip.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-multiselect-master/dist/css/bootstrap-multiselect.css" type="text/css"/>
        
        <!--<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>-->
        <link href="<?php echo base_url(); ?>assets/summernote/dist/summernote-bs4.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/summernote/dist/summernote-bs4.js"></script>

        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/tokenfield/dist/css/bootstrap-tokenfield.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/tokenfield/dist/css/tokenfield-typeahead.min.css">
        <script src="<?php echo base_url(); ?>assets/tokenfield/dist/bootstrap-tokenfield.min.js"></script>-->
        <script src="<?php echo base_url(); ?>assets/selectize/dist/js/standalone/selectize.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/selectize/dist/css/selectize.default.css">

        <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
 
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/DataTables/datatables.min.css"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/datatables.min.js"></script>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/tooltipster/dist/css/tooltipster.bundle.min.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/tooltipster/dist/js/tooltipster.bundle.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/tooltipster/dist/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-punk.min.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/farbtastic/farbtastic.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/farbtastic/farbtastic.css" type="text/css"/>

        <script src="<?php echo base_url(); ?>assets/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/sweetalert2/dist/sweetalert2.min.css">

        <link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
        <script src="<?php echo base_url(); ?>assets/fullcalendar-3.10.0/lib/moment.min.js"></script>
        <script src='<?php echo base_url(); ?>assets/fullcalendar-3.10.0/locale/es.js'></script>
        <link href="<?php echo base_url(); ?>assets/fullcalendar-3.10.0/fullcalendar.min.css" rel="stylesheet"/>
        <script src='<?php echo base_url(); ?>assets/fullcalendar-3.10.0/fullcalendar.min.js'></script>
        <script src='<?php echo base_url(); ?>assets/loadingoverlay/loadingoverlay.min.js'></script>
        <script src='<?php echo base_url(); ?>assets/select2/js/select2.js'></script>
                
        
    </head>
    
<body>

<div class="container gotocontainer">
    
    <div class="header">
        
        <div class="col-lg-12 text-center mt-5">
            
            <img class="mb-4" src="<?php echo base_url(); ?>assets/images/logo-agenda.png" alt="" width="auto" height="72">
        
    </div>  
   
        
    <nav class="navbar navbar-expand-lg navbar-light menu-gotosystem" id="header">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuAgenda" aria-controls="menuAgenda" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon lineas-blancas"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="menuAgenda">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0 w-100">
      <li class="nav-item px-2<?php $menu=$this->session->userdata('opcion_menu'); if($menu=='inicio'){ ?> menu-activo<?php } ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>inicio">Inicio</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Tareas<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="nav-item px-2<?php $menu=$this->session->userdata('opcion_menu'); if($menu=='nueva_tarea'){ ?> menu-activo<?php } ?>">
            <a class="nav-link" href="<?php echo base_url(); ?>nueva-tarea">Nueva Tarea</a>
          </li>
          <li class="nav-item px-2<?php $menu=$this->session->userdata('opcion_menu'); if($menu=='tareas_pendientes'){ ?> menu-activo<?php } ?>">
            <a class="nav-link" href="<?php echo base_url(); ?>tareas-pendientes">Tareas Pendientes</a>
          </li>
          <li class="nav-item px-2<?php $menu=$this->session->userdata('opcion_menu'); if($menu=='tareas_curso'){ ?> menu-activo<?php } ?>">
            <a class="nav-link" href="<?php echo base_url(); ?>tareas-en-curso">Tareas en Curso</a>
          </li>
          <li class="nav-item px-2<?php $menu=$this->session->userdata('opcion_menu'); if($menu=='tareas_completadas'){ ?> menu-activo<?php } ?>">
            <a class="nav-link" href="<?php echo base_url(); ?>tareas-completadas">Tareas Completadas</a>
          </li>
          <?php
            if($this->session->userdata('super')==0) 
            {
          ?>


          <li class="nav-item px-2<?php $menu=$this->session->userdata('opcion_menu'); if($menu=='tareas_creadas'){ ?> menu-activo<?php } ?>">
            <a class="nav-link" href="<?php echo base_url(); ?>tareas-creadas">Tareas Creadas</a>
          </li>
          <?php 
            }
          ?>
        </ul>
      </li> 
      <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>calendario-tareas">Calendario</a>
          </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Base Conocimiento<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="nav-item px-2">
            <a class="nav-link" href="<?php echo base_url(); ?>inicio_conocimientos">Ver</a>
          </li>
          <li class="nav-item px-2">
            <a class="nav-link" href="<?php echo base_url(); ?>nuevo-conocimiento">Nueva</a>
          </li>
        </ul>
      </li> 
      <?php
        if($this->session->userdata('verContraseñas')==1) 
        {
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Contraseñas<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="nav-item px-2">
            <a class="nav-link" href="<?php echo base_url(); ?>inicio_contrasenyas">Ver</a>
          </li>
          <li class="nav-item px-2">
            <a class="nav-link" href="<?php echo base_url(); ?>nueva-contrasenya">Nueva</a>
          </li>
        </ul>
      </li> 
      <?php 
        }
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Mantenimiento<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="nav-item px-2">
            <a class="nav-link" href="<?php echo base_url(); ?>mantenimiento_clientes">Cliente</a>
          </li>
          <?php
            if($this->session->userdata('super')==1) 
            {
          ?>
          <li class="nav-item px-2">
            <a class="nav-link" href="<?php echo base_url(); ?>mantenimiento_usuarios">Usuario</a>
          </li>
          <?php 
            }
          ?>
          <li class="nav-item px-2">
            <a class="nav-link" href="<?php echo base_url(); ?>mantenimiento_etiquetas">Etiquetas</a>
          </li>
        </ul>
      </li>       
      <li class="nav-item px-2">
          <a class="nav-link" href="<?php echo base_url(); ?>cerrar-sesion">Cerrar Sesión</a>
      </li> 
    </ul>
    
  </div>
</nav>
    </div>
    
    

