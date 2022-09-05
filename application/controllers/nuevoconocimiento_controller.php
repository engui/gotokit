<?php

class nuevoconocimiento_controller extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('conocimientos_model');   
        $this->load->model('etiquetas_model');     
        $this->load->model('clientes_model'); 
        $this->output->nocache();
    }

    public function index()
    {
        $opcion_menu='nuevo_conocimiento';
        $this->session->set_userdata('opcion_menu',$opcion_menu);
        $this->session->set_userdata('titulo_pagina','Nuevo Conocimiento');
    	$etiquetas = $this->etiquetas_model->getEtiquetas();
    	$data['etiquetas'] = $etiquetas;
        $clientes = $this->clientes_model->mostrarClientes();
        $data['clientes'] = $clientes;
    	$this->load->view('nuevoconocimiento_view',$data);
    }

    public function nuevoConocimiento()
    {
    	$asunto = $this->input->post('nombreConocimiento');
    	$fecha_creada = date('y-m-d');
        $hora_actual = date('H:i');
        $etiquetas = $this->input->post('etiquetaConocimiento');
        $mensaje = $this->input->post('mensaje');
        $clientes = $this->input->post('clienteConocimiento');

        if($asunto == '' || $etiquetas == '' || $mensaje == '')
        {
            $contenido_error='';

            if($asunto=='')
            {
                $contenido_error=$contenido_error.'<br>-El conocimiento debe tener un asunto';
            }

            if($etiquetas=='')
            {
                $contenido_error=$contenido_error.'<br>-El conocimiento debe tener al menos una etiqueta';
            }

            if($mensaje=='')
            {
                $contenido_error=$contenido_error.'<br>-El conocimiento debe tener un mensaje';
            }

            $mensaje_error='✘ ERROR al intentar crear el conocimiento:'.$contenido_error;

            $etiquetas = $this->etiquetas_model->getEtiquetas();
            $clientes = $this->clientes_model->mostrarClientes();

            $data['mensaje_error']=$mensaje_error;
            $data['etiquetas'] = $etiquetas;
            $data['clientes'] = $clientes;
            $this->load->view('nuevoconocimiento_view',$data);
        }
        else
        {
            $param['nombre'] = $asunto;
            $param['fecha_creada'] = $fecha_creada;
            $param['hora_creada'] = $hora_actual;
            $param['etiquetas'] = $etiquetas;
            $param['mensaje'] = $mensaje;
            $param['clientes'] = $clientes;

            $this->conocimientos_model->nuevoConocimiento($param);

            $ficheros = array();

            // Count total files
            $countfiles = count($_FILES['files']['name']);

            // Looping all files
            if($countfiles != 0)
            {
                for($i=0;$i<$countfiles;$i++)
                {
                    if(!empty($_FILES['files']['name'][$i]))
                    {
                        // Define new $_FILES array - $_FILES['file']
                        $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                        $ultimoCodConocimiento = $this->conocimientos_model->obtenerUltimoConocimientoCreado();

                        $ruta = 'archivosConocimientos//'.$ultimoCodConocimiento.'//';
                        if (!file_exists($ruta)) 
                        {
                            mkdir($ruta, 0777, true);
                        }
                        // Set preference
                        $config['upload_path'] = $ruta; 
                        $config['allowed_types'] = '*';
                        $config['max_size'] = '*'; // max_size in kb
                        $config['file_name'] = $_FILES['files']['name'][$i];

                        //Load upload library
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);

                        // File upload
                        if($this->upload->do_upload('file'))
                        {
                            $uploadData = $this->upload->data();
                            $filename = $uploadData['file_name'];

                            //*******************************************************************
                            $ficheros[$i] = $filename;
                        }
                    }
                }
            }

            $this->conocimientos_model->anyadirArchivosNuevoConocimiento($ficheros);

            redirect('inicio_conocimientos');
        }
    }
}

?>