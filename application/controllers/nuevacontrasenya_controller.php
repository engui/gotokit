<?php

class nuevacontrasenya_controller extends CI_Controller
{
	function __construct()
    {
        parent::__construct();  
        $this->load->model('contrasenyas_model');     
        $this->load->model('clientes_model'); 
        $this->output->nocache();
    }

    public function index()
    {
        $opcion_menu='nueva_contrasenya';
        $this->session->set_userdata('opcion_menu',$opcion_menu);
        $this->session->set_userdata('titulo_pagina','Nueva Contraseña');
        $clientes = $this->clientes_model->mostrarClientes();
        $data['clientes'] = $clientes;
    	$this->load->view('nuevacontrasenya_view',$data);
    }

    public function nuevaContrasenya()
    {
    	$asunto = $this->input->post('nombreContrasenya');
    	$fecha_creada = date('y-m-d');
        $hora_actual = date('H:i');
        $mensaje = $this->input->post('mensaje');
        $clientes = $this->input->post('clienteContrasenya');

        $param['nombre'] = $asunto;
        $param['fecha_creada'] = $fecha_creada;
        $param['hora_creada'] = $hora_actual;
        $param['mensaje'] = $mensaje;
        $param['clientes'] = $clientes;

        $this->contrasenyas_model->nuevaContrasenya($param);

        redirect('inicio_contrasenyas');
    }
}

?>