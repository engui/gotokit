<?php

class nuevatarea_controller extends CI_Controller
{
     
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('tareas_model');
        $this->load->model('usuarios_model');
        //$this->load->library('encrypt');
        //$this->load->library('session');
        $this->output->nocache();
        
    }
    
    public function index()
    {
        if($this->session->userdata('cod_usuario')=='')
        {
            redirect(base_url());
        }
        $opcion_menu='nueva_tarea';
        $this->session->set_userdata('opcion_menu',$opcion_menu);
        $this->session->set_userdata('titulo_pagina','Nueva Tarea');
        
        $usuarios=$this->usuarios_model->getUsuarios();
        //$grupos=$this->usuarios_model->getGrupos();
        
        $query = $this->db->query('SELECT * FROM clientes');
        $clientes=$query->result_array();


        $data['usuarios']=$usuarios;
        //$data['grupos']=$grupos;
        $data['clientes']=$clientes;
        $data['cod_usuario']=$this->session->userdata('cod_usuario');
        
        $this->load->view('nuevatarea_view',$data);
      
    }

    public function nuevaTarea()
    {
        $nombre_tarea=$this->input->post('nombreTarea');
        $usuario_tarea=$this->input->post('usuarioTarea');
        $fecha_tarea=$this->input->post('fechaTarea');
        $hora_tarea=$this->input->post('horaTarea');
        $mensaje_tarea=$this->input->post('content');
        $prioridad_tarea=$this->input->post('prioridad');
        $clientes_tarea=$this->input->post('clientesTarea');
        $facturable_tarea=$this->input->post('facturable');
        $tiempo_horas=$this->input->post('tiempo_horas');
        $tiempo_minutos=$this->input->post('tiempo_minutos');
        
        
        if($nombre_tarea=='' || $usuario_tarea=='' /*|| $fecha_tarea=='' || $hora_tarea==''*/)
        {
            
            $contenido_error='';
            
            if($nombre_tarea=='')
            {
                $contenido_error=$contenido_error.'<br>-La tarea debe tener un nombre';
            }

            if($usuario_tarea=='')
            {
                $contenido_error=$contenido_error.'<br>-La tarea tiene que ir dirigido a un usuario';
            }
            
            /*if($fecha_tarea=='')
            {
                $contenido_error=$contenido_error.'<br>-Debes introducir una fecha';
            }*/
            
            /*if($hora_tarea=='')
            {
                $contenido_error=$contenido_error.'<br>-Debes introducir una hora';
            }*/
            
            $mensaje_error='✘ ERROR al intentar crear la tarea:'.$contenido_error;

            $usuarios=$this->usuarios_model->getUsuarios();
            //$grupos=$this->usuarios_model->getGrupos();
        
            $data['usuarios']=$usuarios;
            //$data['grupos']=$grupos;
        
            $data['mensaje_error']=$mensaje_error;
            $data['cod_usuario']=$this->session->userdata('cod_usuario');
            $this->load->view('nuevatarea_view',$data);
        }
        else
        {
            $param['nombre_tarea']=$nombre_tarea;
            $param['usuario_tarea']=$usuario_tarea;
            $param['mensaje_tarea']=$mensaje_tarea;
            $param['fecha_tarea']=$fecha_tarea;
            $param['hora_tarea']=$hora_tarea;
            $param['clientesTarea']=$clientes_tarea;
            $param['prioridad_tarea']=$prioridad_tarea;
            $param['facturable_tarea']=$facturable_tarea;
            $param['minutos']=($tiempo_horas*60)+($tiempo_minutos);

            
            $this->tareas_model->nuevaTarea($param);
            //*******************************************************************
            //*******************************************************************************

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

                        $ultimoCodTarea = $this->tareas_model->obtenerUltimaTareaCreada();

                        $ruta = 'uploads//'.$ultimoCodTarea.'//';
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
                            //$this->tareas_model->anyadirArchivosMensajes($filename);
                            //*******************************************************************
                            
                            // Initialize array
                            //$ficheros['filenames'] = $filename;
                        }
                    }
                }
            }

            $this->tareas_model->anyadirArchivosNuevaTarea($ficheros);
            //*******************************************************************************
            //*******************************************************************
            $mensaje_confirmacion='✔ Nueva Tarea añadida correctamente';
            
            
            $opcion_menu='inicio';
        
        
            $this->session->set_userdata('opcion_menu',$opcion_menu);
            $this->session->set_userdata('titulo_pagina','Inicio');
      
            redirect('inicio');
            //$this->load->view('inicio_view',$data);
            //redirect('inicio');
        }
    }
    
   
    
   
    
}

?>