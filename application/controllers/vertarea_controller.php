<?php

class vertarea_controller extends CI_Controller
{
    private $limit_tareas=10;
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('tareas_model');
        $this->load->model('usuarios_model');
        $this->load->model('estados_model');
        $this->load->model('clientes_model');
        $this->load->model('archivos_model');
        //$this->load->library('encrypt');
        //$this->load->library('session');
        $this->output->nocache();
    }
    
    public function mostrarTarea($cod_tarea)
    {
        if($this->session->userdata('cod_usuario')=='')
        {
            redirect(base_url());
        }
        $opcion_menu='';
        $this->session->set_userdata('opcion_menu',$opcion_menu);
        
        //$cod_tarea=$this->input->get('cod_tarea');
        
        $nombre_tarea=$this->tareas_model->getNombre($cod_tarea);
        
        $this->session->set_userdata('titulo_pagina',$nombre_tarea);
        
        $conversacion=$this->tareas_model->mostrarConversacionTarea($cod_tarea);
        
        $datos_tarea=$this->tareas_model->mostrarTarea($cod_tarea);
        $estados=$this->estados_model->mostrarEstados();
        //*******************************************************

        $clientes=$this->clientes_model->mostrarClientes();
        $tareasClientes=$this->clientes_model->mostrarTablaRelacionTareasClientes($cod_tarea);
        $rutasArchivos=$this->archivos_model->obtenerCodLineaRutaArchivos($cod_tarea);
        
        //*******************************************************

        $usuarios=$this->usuarios_model->getUsuarios();
        $usuariosAsignados=$this->usuarios_model->getUsuariosAsignados($cod_tarea);

        //*******************************************************
        $usuario_session=$this->usuarios_model->getUsuarioSession();
        $prioridad = $this->tareas_model->obtenerPrioridad($cod_tarea);
        $facturable = $this->tareas_model->obtenerFacturable($cod_tarea);
        $minutos = $this->tareas_model->obtenerMinutos($cod_tarea);
        $this->tareas_model->ponerComoLeida($cod_tarea,$usuario_session['cod_usuario']);
        
        
        if($usuario_session['cod_usuario']==$datos_tarea->usuario_origen)
        {
            
        }
        
        $data['datos_tarea']=$datos_tarea;
        $data['estados']=$estados;
        $data['usuario_session']=$usuario_session;    
        $data['conversacion']=$conversacion;        
        $data['nombre_tarea']=$nombre_tarea;
        $data['cod_tarea']=$cod_tarea;
        //*******************************************************
        $data['clientes'] = $clientes;
        $data['tareasClientes'] = $tareasClientes;
        $data['rutasArchivos'] = $rutasArchivos;
        $data['usuarios'] = $usuarios;
        $data['usuariosAsignados'] = $usuariosAsignados;
        $data['prioridad'] = $prioridad;
        $data['facturable'] = $facturable;
        $data['minutos'] = $minutos;
        //*******************************************************
        $this->load->view('vertarea_view',$data);
    }
    
    public function nuevoMensaje()
    {
        $this->actualizarTarea();
        $enviar = $this->input->post('enviar');
            

        if($enviar!=null)
        {
            $cod_tarea=$this->input->post('cod_tarea');
            $cod_usuario=$this->input->post('cod_usuario');
            $mensaje_tarea=$this->input->post('content');
            $tiempo_horas=$this->input->post('tiempo_horas');
            $tiempo_minutos=$this->input->post('tiempo_minutos');
            
            
            if($mensaje_tarea!='')
            {
                
                $param['cod_tarea']=$cod_tarea;
                $param['cod_usuario']=$cod_usuario;
                $param['mensaje_tarea']=$mensaje_tarea;
                $param['tiempo_horas']=$tiempo_horas;
                $param['tiempo_minutos']=$tiempo_minutos;
                
                $this->tareas_model->nuevoMensaje($param);
                //*******************************************************************

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

                            $ruta = 'uploads//'.$cod_tarea.'//';
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
                    //$ficheros[$i+1] = $cod_tarea;
                }
                $this->tareas_model->anyadirArchivosMensajes($ficheros,$cod_tarea);

                //*******************************************************************
            }
            redirect('inicio'); 
        }
    }


    public function editarMensaje()
    {
        $mensaje = $this->input->post('mensaje');
        $cod_tarea = $this->input->post('cod_tarea');
        $cod_linea = $this->input->post('cod_linea');
        $cod_usuario = $this->input->post('cod_usuario');

        $horas = $this->input->post('horas');
        $minutos = $this->input->post('minutos');
        $minutos = ($horas*60)+$minutos;

        $data['mensaje'] = $mensaje;
        $data['cod_tarea'] = $cod_tarea;
        $data['cod_linea'] = $cod_linea;
        $data['cod_usuario'] = $cod_usuario;
        $this->tareas_model->actualizarMensajeTarea($data);
        
        $data['minutos'] = $minutos;
        $data['cod_tarea'] = $cod_tarea;
        $data['cod_linea'] = $cod_linea;
        $data['cod_usuario'] = $cod_usuario;
        $this->tareas_model->actualizarMinutosTarea($data);
        
        
        //redirect('tarea/'.$cod_tarea);
        //$this->load->view('vista_prueba',$data);
    }
    
    public function borrarMensaje()
    {
        $cod_tarea = $this->input->post('cod_tarea');
        $cod_linea = $this->input->post('cod_linea');

        $rutasArchivos = $this->archivos_model->obtenerRutaArchivo($cod_linea,$cod_tarea);

        $data['cod_tarea'] = $cod_tarea;
        $data['cod_linea'] = $cod_linea;
        $data['rutasArchivos'] = $rutasArchivos;

        $this->tareas_model->eliminarMensajeTarea($data);
        //$this->load->view('vista_prueba',$data);
    }
 
    public function actualizarTarea()
    {
        $cod_tarea=$this->input->post('cod_tarea');
        $nombre_tarea=$this->input->post('nombreTarea');
        $estado_tarea=$this->input->post('estadoTarea');
        $fecha_tarea=$this->input->post('fechaTarea');
        $hora_tarea=$this->input->post('horaTarea');
        $clientes_tarea=$this->input->post('clientesTarea');
        $usuario_tarea=$this->input->post('usuarioTarea');
        $prioridad=$this->input->post('prioridad');
        
        $tiempo_principal_horas=$this->input->post('tiempo_principal_horas');
        $tiempo_principal_minutos=$this->input->post('tiempo_principal_minutos');
        $minutos_principal = ($tiempo_principal_horas*60)+$tiempo_principal_minutos;
        
        $param['cod_tarea']=$cod_tarea;
        $param['nombre_tarea']=$nombre_tarea;
        $param['estado_tarea']=$estado_tarea;
        $param['fecha_tarea']=$fecha_tarea;
        $param['hora_tarea']=$hora_tarea;
        $param['clientesTarea']=$clientes_tarea;
        $param['usuario_tarea']=$usuario_tarea;
        $param['prioridad']=$prioridad;
        $param['minutos']=$minutos_principal;

        $cod_tarea=$this->tareas_model->actualizarTarea($param);

//        redirect('/inicio');
    }

    public function actualizarEstadoTarea()
    {
        $cod_tarea=$this->input->post('cod_tarea');
        $estado_tarea=$this->input->post('estadoTarea');

        $param['cod_tarea']=$cod_tarea;
        $param['estado_tarea']=$estado_tarea;
        $cod_tarea=$this->tareas_model->actualizarEstadoTarea($param);

        redirect('tarea/'.$cod_tarea);
    }
   
    public function descargarCarpeta()
    {
        $descargar = $this->input->post('descargar');
        if($descargar!=null)
        {
            $cod_tarea = $this->input->post('cod_tarea');
            $path = 'uploads/'.$cod_tarea.'/';
            $this->zip->read_dir($path, FALSE);
            $this->zip->download($cod_tarea.'.zip');
        }
    }

    
    public function prueba()
    {
        /*$usuarioCorreo = $this->usuarios_model->getUsuariosAsignados(409);
        $prueba = array(
            'usuario_destino' => 1
        );
        array_push($usuarioCorreo, $prueba);
    
        $data['usuarios'] = $usuarioCorreo;
        $this->load->view('vista_prueba',$data);

        $usuarioCorreo = $this->usuarios_model->getUsuariosAsignados(409);
        $usuario_anterior = array();
        for ($i=0; $i <count($usuarioCorreo) ; $i++) 
        { 
            $usuario_anterior[] = $usuarioCorreo[$i]['usuario_destino']."<br>";
        }
        $usuario_anterior[] = 1;
        $data['usuarios'] = $usuario_anterior;

        $usuario_tarea=$this->input->post('usuarioTarea');
        $data['usuario_tarea']=$usuario_tarea;
        $this->load->view('vista_prueba',$data);
        
        $clientes_consulta = $this->clientes_model->mostrarTablaRelacionTareasClientes(409);
        $clientes_anterior = array();
        for ($i=0; $i <count($clientes_consulta) ; $i++) 
        { 
            $clientes_anterior[] = $clientes_consulta[$i]['id_cliente'];
        }
        $data['usuarios'] = $clientes_anterior;

        $clientes_tarea=$this->input->post('clientesTarea');
        $data['usuario_tarea']=$clientes_tarea;
        $this->load->view('vista_prueba',$data);*/
        //ACTUALIZAR TAREA
        /*$cod_tarea=$this->input->post('cod_tarea');
        $nombre_tarea=$this->input->post('nombreTarea');
        $estado_tarea=$this->input->post('estadoTarea');
        $fecha_tarea=$this->input->post('fechaTarea');
        $hora_tarea=$this->input->post('horaTarea');
        $clientes_tarea=$this->input->post('clientesTarea');
        $usuario_tarea=$this->input->post('usuarioTarea');

        $param['cod_tarea']=$cod_tarea;
        $param['nombre_tarea']=$nombre_tarea;
        $param['estado_tarea']=$estado_tarea;
        $param['fecha_tarea']=$fecha_tarea;
        $param['hora_tarea']=$hora_tarea;
        $param['clientesTarea']=$clientes_tarea;
        $param['usuario_tarea']=$usuario_tarea;

        $cuerpo=$this->tareas_model->actualizarTarea($param);
        $data['cuerpo']=$cuerpo;
        $this->load->view('vista_prueba',$data);*/
        //ACTUALIZAR ESTADO TAREA
        /*$cod_tarea=$this->input->post('cod_tarea');
        $estado_tarea=$this->input->post('estadoTarea');

        $param['cod_tarea']=$cod_tarea;
        $param['estado_tarea']=$estado_tarea;
        $cuerpo=$this->tareas_model->actualizarEstadoTarea($param);
        $data['cuerpo']=$cuerpo;
        $this->load->view('vista_prueba',$data);*/
        //NUEVO MENSAJE
        /*$enviar = $this->input->post('enviar');

        if($enviar!=null)
        {
            $cod_tarea=$this->input->post('cod_tarea');
            $cod_usuario=$this->input->post('cod_usuario');
            $mensaje_tarea=$this->input->post('content');
            
            if($mensaje_tarea!='')
            {
                
                $param['cod_tarea']=$cod_tarea;
                $param['cod_usuario']=$cod_usuario;
                $param['mensaje_tarea']=$mensaje_tarea;
                
                $cuerpo = $this->tareas_model->nuevoMensaje($param);
                $data['cuerpo']=$cuerpo;
                $this->load->view('vista_prueba',$data);
            }
        }*/
        //MODIFICAR MENSAJE TAREA
        /*$mensaje = $this->input->post('mensaje');
        $cod_tarea = $this->input->post('cod_tarea');
        $cod_linea = $this->input->post('cod_linea');
        $cod_usuario = $this->input->post('cod_usuario');

        $data['mensaje'] = $mensaje;
        $data['cod_tarea'] = $cod_tarea;
        $data['cod_linea'] = $cod_linea;
        $data['cod_usuario'] = $cod_usuario;
        $cuerpo = $this->tareas_model->actualizarMensajeTarea($data);
        $data['cuerpo']=$cuerpo;
        $this->load->view('vista_prueba',$data);*/
    }
    
}

?>