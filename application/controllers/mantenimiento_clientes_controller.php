<?php 

class mantenimiento_clientes_controller extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('clientes_model');    
        $this->output->nocache();   
    }

    public function index()
    {
        $opcion_menu='mantenimiento_clientes';
        $this->session->set_userdata('opcion_menu',$opcion_menu);
        $this->session->set_userdata('titulo_pagina','Mantenimiento Clientes');
    	$data['clientes'] = $this->clientes_model->mostrarClientes();
    	$this->load->view('mantenimiento_clientes_view',$data);
    }

    public function obtenerDatos()
    {
    	$id_cliente =  $this->input->post('id_cliente');
    	$datosClientes = $this->clientes_model->obtenerClientePorID($id_cliente);
    	echo json_encode($datosClientes);
    }

    public function insertarCliente()
    {
    	$data['nombre'] = $this->input->post('nombre');
    	$data['telefono'] = $this->input->post('telefono');
        $data['direccion'] = $this->input->post('direccion');
        $data['cp'] = $this->input->post('cp');
        $data['poblacion'] = $this->input->post('poblacion');
        $data['provincia'] = $this->input->post('provincia');
        $data['pais'] = $this->input->post('pais');
    	$data['tipo'] = $this->input->post('tipo');
        $id = $this->clientes_model->insertarCliente($data);
        echo $id;
    }

    public function modificarCliente()
    {
    	$data['cod_cliente'] = $this->input->post('cod_cliente');
    	$data['nombre'] = $this->input->post('nombre');
    	$data['telefono'] = $this->input->post('telefono');
        $data['direccion'] = $this->input->post('direccion');
        $data['cp'] = $this->input->post('cp');
        $data['poblacion'] = $this->input->post('poblacion');
        $data['provincia'] = $this->input->post('provincia');
        $data['pais'] = $this->input->post('pais');
        $data['tipo'] = $this->input->post('tipo');
    	$this->clientes_model->modificarCliente($data);
    }

    public function eliminarCliente()
    {
    	$data['cod_cliente'] = $this->input->post('cod_cliente');
    	$this->clientes_model->eliminarCliente($data);
    }

    public function actualizar_sololasmias()
    {
        $data = $this->input->post();
        $this->session->set_userdata('sololasmias',$data["pulsado"]);
        echo json_encode($this->session->userdata('sololasmias'));
    }

    
}

?>