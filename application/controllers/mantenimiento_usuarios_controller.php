<?php 

class mantenimiento_usuarios_controller extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');       
        $this->output->nocache();
    }

    public function index()
    {
        $opcion_menu='mantenimiento_usuarios';
        $this->session->set_userdata('opcion_menu',$opcion_menu);
        $this->session->set_userdata('titulo_pagina','Mantenimiento Usuarios');
    	$data['usuarios'] = $this->usuarios_model->obtenerTodosUsuarios();
    	$this->load->view('mantenimiento_usuarios_view',$data);
    }

    public function obtenerDatos()
    {
    	$cod_usuario =  $this->input->post('cod_usuario');
    	$datosUsuarios = $this->usuarios_model->obtenerUsuarioPorID($cod_usuario);
    	echo json_encode($datosUsuarios);
    }

    public function insertarUsuario()
    {
    	$data['nombre'] = $this->input->post('nombre');
    	$data['color'] = $this->input->post('color');
        $data['email'] = $this->input->post('email');
        $data['contrasenya'] = $this->input->post('contrasenya');
        $data['activo'] = $this->input->post('activo');
        $data['admin'] = $this->input->post('admin');
        $data['verContrasenyas'] = $this->input->post('verContrasenyas');
    	$this->usuarios_model->insertarUsuario($data);
    }

    public function modificarUsuario()
    {
    	$data['cod_usuario'] = $this->input->post('cod_usuario');
    	$data['nombre'] = $this->input->post('nombre');
        $data['color'] = $this->input->post('color');
        $data['email'] = $this->input->post('email');
        $data['contrasenya'] = $this->input->post('contrasenya');
        $data['activo'] = $this->input->post('activo');
        $data['admin'] = $this->input->post('admin');
        $data['verContrasenyas'] = $this->input->post('verContrasenyas');
    	$this->usuarios_model->modificarUsuario($data);
    }

    public function eliminarUsuario()
    {
    	$data['cod_usuario'] = $this->input->post('cod_usuario');
        $arrayResultados = $this->usuarios_model->comprobarExistenciaUsuario($data['cod_usuario']);
        $arrayErrores = array();
        //$seguir = True;
        for ($i=0; $i < count($arrayResultados) /*AND $seguir == True*/ ; $i++) 
        { 
            if($arrayResultados[$i] == 0)
            {
                $arrayErrores[] = $i;
                //$seguir = False;
            }
        }
        if(count($arrayErrores) == 0) 
        {
            $this->usuarios_model->eliminarUsuario($data);
            $array = array("Funciona");
            echo json_encode($array);
        }
        else
        {
            echo json_encode($arrayErrores);
        }
    }
}

?>