<?php 

class mantenimiento_etiquetas_controller extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('etiquetas_model');   
        $this->output->nocache();   
    }

    public function index()
    {
        $opcion_menu='mantenimiento_etiquetas';
        $this->session->set_userdata('opcion_menu',$opcion_menu);
        $this->session->set_userdata('titulo_pagina','Mantenimiento Etiquetas');
    	$data['etiquetas'] = $this->etiquetas_model->getEtiquetas();
    	$this->load->view('mantenimiento_etiquetas_view',$data);
    }

    public function obtenerDatos()
    {
    	$cod_etiqueta =  $this->input->post('cod_etiqueta');
    	$datosEtiquetas = $this->etiquetas_model->obtenerEtiquetaPorID($cod_etiqueta);
    	echo json_encode($datosEtiquetas);
    }

    public function insertarEtiqueta()
    {
    	$data['nombre'] = $this->input->post('nombre');
    	$data['color'] = $this->input->post('color');
    	$this->etiquetas_model->insertarEtiqueta($data);
    }

    public function modificarEtiqueta()
    {
    	$data['cod_etiqueta'] = $this->input->post('cod_etiqueta');
    	$data['nombre'] = $this->input->post('nombre');
    	$data['color'] = $this->input->post('color');
    	$this->etiquetas_model->modificarEtiqueta($data);
    }

    public function eliminarEtiqueta()
    {
    	$data['cod_etiqueta'] = $this->input->post('cod_etiqueta');
    	$this->etiquetas_model->eliminarEtiqueta($data);
    }
}

?>