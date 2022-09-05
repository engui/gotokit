<?php

class verconocimiento_controller extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('conocimientos_model');
        $this->load->model('etiquetas_model'); 
        $this->load->model('clientes_model');
        $this->output->nocache();
    }

    public function mostrarConocimiento($cod_conocimiento)
    {
    	$nombre_conocimiento=$this->conocimientos_model->getNombre($cod_conocimiento);
        
        $this->session->set_userdata('titulo_pagina',$nombre_conocimiento);

        $datos_conocimiento = $this->conocimientos_model->mostrarConocimiento($cod_conocimiento);
        $etiquetas_conocimiento = $this->etiquetas_model->getEtiquetasCodigo($cod_conocimiento);
        $etiquetas = $this->etiquetas_model->getEtiquetas();
        $clientes_conocimiento = $this->clientes_model->mostrarClientesCodigo($cod_conocimiento);
        $clientes = $this->clientes_model->mostrarClientes();
        $rutasArchivos = $this->conocimientos_model->obtenerRutaArchivos($cod_conocimiento);

        $data['datos_conocimiento'] = $datos_conocimiento;
        $data['etiquetas_conocimiento'] = $etiquetas_conocimiento;
        $data['etiquetas'] = $etiquetas;
        $data['clientes_conocimiento'] = $clientes_conocimiento;
        $data['clientes'] = $clientes;
        $data['cod_conocimiento'] = $cod_conocimiento;
        $data['rutasArchivos'] = $rutasArchivos;
    	$this->load->view('verconocimiento_view',$data);
    }

    public function actualizarConocimiento()
    {
    	$cod_conocimiento=$this->input->post('cod_conocimiento');
        $asunto=$this->input->post('nombreConocimiento');
        $etiquetas=$this->input->post('etiquetasConocimiento');
        $clientes=$this->input->post('clientesConocimiento');

        $param['cod_conocimiento']=$cod_conocimiento;
        $param['asunto']=$asunto;
        $param['etiquetas']=$etiquetas;
        $param['clientes']=$clientes;

        $cod_conocimiento=$this->conocimientos_model->actualizarConocimiento($param);

        redirect('conocimiento/'.$cod_conocimiento);
    }

    public function editarMensaje()
    {
    	$mensaje = $this->input->post('mensaje');
    	$cod_conocimiento = $this->input->post('cod_conocimiento');
    	$data['mensaje'] = $mensaje;
    	$data['cod_conocimiento'] = $cod_conocimiento;
    	$this->conocimientos_model->actualizarMensaje($data);
    }

    public function anyadirArchivos()
    {
        $cod_conocimiento=$this->input->post('cod_conocimiento');
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

                    $ruta = 'archivosConocimientos//'.$cod_conocimiento.'//';
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
                        // Get data about the file
                        $uploadData = $this->upload->data();
                        $filename = $uploadData['file_name'];

                        //*******************************************************************
                        $ficheros[$i] = $filename;
                    }
                }
            }
        }
        $this->conocimientos_model->anyadirArchivosConocimiento($ficheros,$cod_conocimiento);
        //*******************************************************************
        redirect('conocimiento/'.$cod_conocimiento); 
    }

    public function descargarCarpeta()
    {
        $descargar = $this->input->post('descargar');
        if($descargar!=null)
        {
            $cod_conocimiento = $this->input->post('cod_conocimiento');
            $path = 'archivosConocimientos/'.$cod_conocimiento.'/';
            $this->zip->read_dir($path, FALSE);
            $this->zip->download($cod_conocimiento.'.zip');
        }
    }

    public function borrarArchivo()
    {
        $cod_conocimiento = $this->input->post('cod_conocimiento');
        $cod_archivo = $this->input->post('cod_archivo');
        $ruta = $this->conocimientos_model->obtenerRutaArchivo($cod_conocimiento,$cod_archivo);

        $data['cod_conocimiento'] = $cod_conocimiento;
        $data['cod_archivo'] = $cod_archivo;
        $data['ruta'] = $ruta;

        $this->conocimientos_model->eliminarArchivo($data);
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