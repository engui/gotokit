<?php 

class calendariotareas_controller extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('calendario_model');
        $this->load->model('usuarios_model');   
        $this->output->nocache(); 
    }

    public function index()
    {
        $this->session->set_userdata('titulo_pagina','Calendario');
    	$datosCalendario = $this->calendario_model->obtenerDatosCalendario();
    	$data["datosCalendario"] = $datosCalendario;
        $datosUsuarios = $this->usuarios_model->obtenerTodosUsuarios();
        $data["datosUsuarios"] = $datosUsuarios;
    	$this->load->view('calendariotareas_view',$data);
    }

    public function obtenerDatos()
    {
        $cod_usuario =  $this->input->post('cod_usuario');
    	$datosCalendario = $this->calendario_model->obtenerDatosCalendarioPorUsuario($cod_usuario);
    	echo json_encode($datosCalendario);
    }
}
?>