<?php

class inicio_contrasenyas_controller extends CI_Controller
{
    private $limit_conocimientos=100;

	function __construct()
    {
        parent::__construct();
        $this->load->model('contrasenyas_model'); 
        $this->output->nocache();     
    }

    public function index()
    {
        $this->session->set_userdata('titulo_pagina','Contraseñas');

        $limit_conocimientos=$this->limit_conocimientos;

        $contraseñas=$this->contrasenyas_model->mostrarContraseñas();

        $data['contraseñas'] = $contraseñas;
        $this->load->view('mostrar_contrasenyas_view',$data);
    }

    public function eliminarContrasenya($cod_contraseña)
    {
        $this->contrasenyas_model->eliminarContraseña($cod_contraseña);
        redirect('inicio_contrasenyas');
    }
}

?>