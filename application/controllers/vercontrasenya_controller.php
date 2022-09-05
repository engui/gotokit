<?php

class vercontrasenya_controller extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('contrasenyas_model'); 
        $this->load->model('clientes_model');
        $this->output->nocache();
    }

    public function mostrarContrasenya($cod_contraseña)
    {
    	$nombre_conocimiento=$this->contrasenyas_model->getNombre($cod_contraseña);
        
        $this->session->set_userdata('titulo_pagina',$nombre_conocimiento);

        $datos_contraseñas = $this->contrasenyas_model->mostrarContraseña($cod_contraseña);
        
        $clientes_contraseña = $this->clientes_model->mostrarClientesCodigoContraseñas($cod_contraseña);
        $clientes = $this->clientes_model->mostrarClientes();

        $data['datos_contrasenyas'] = $datos_contraseñas;
        $data['clientes_contrasenya'] = $clientes_contraseña;
        $data['clientes'] = $clientes;
        $data['cod_contrasenya'] = $cod_contraseña;
    	$this->load->view('vercontrasenya_view',$data);
    }

    public function actualizarContrasenya()
    {
    	$cod_contraseña=$this->input->post('cod_contrasenya');
        $asunto=$this->input->post('nombreContrasenya');
        $clientes=$this->input->post('clientesContrasenya');

        $param['cod_contrasenya']=$cod_contraseña;
        $param['asunto']=$asunto;
        $param['clientes']=$clientes;

        $cod_contraseña=$this->contrasenyas_model->actualizarContraseña($param);

        redirect('contrasenya/'.$cod_contraseña);
    }

    public function editarMensaje()
    {
    	$mensaje = $this->input->post('mensaje');
    	$cod_contraseña = $this->input->post('cod_contrasenya');
    	$data['mensaje'] = $mensaje;
    	$data['cod_contrasenya'] = $cod_contraseña;
    	$this->contrasenyas_model->actualizarMensaje($data);
    }

    public function prueba()
    {
    	/*$etiquetas=$this->input->post('etiquetasConocimiento');
    	$param['etiquetas'] = $etiquetas;
    	$data['etiquetas'] = $this->conocimientos_model->prueba($param);*/
    	
    	$this->load->view('vista_prueba');
    }
}

?>