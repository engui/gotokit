<?php



class inicio_controller extends CI_Controller
{
     private $limit_tareas=100;
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('tareas_model');
        
        //$this->load->library('encrypt');
        //$this->load->library('session');
        $this->output->nocache();
        
    }
    
    public function index()
    {

        //$event = new ICS("2009-11-06 09:00","2009-11-06 21:00","Test Event","This is an event made by Jamie Bicknell","GU1 1AA");
        //$event->show();
        //return;
        
       
        if($this->session->userdata('cod_usuario')=='')
        {
            redirect(base_url());
        }
        $opcion_menu='inicio';
        
        $this->session->set_userdata('opcion_menu',$opcion_menu);
        $this->session->set_userdata('titulo_pagina','Inicio');
        
        
        $limit_tareas=$this->limit_tareas;
        
        $tareas=$this->tareas_model->mostrarTareas();
        
        $tareas_trozo=array_slice($tareas,0,$limit_tareas);
        $total_paginas=ceil(count($tareas)/$limit_tareas);
        $pagina_actual=1;
        

        $data['tareas'] = $tareas_trozo;
        $data['total_paginas'] = $total_paginas;
        $data['pagina_actual'] = $pagina_actual;
        $this->load->view('inicio_view',$data);
            
        
    }
    
    public function mostrarTareas()
    {

        
        $pagina_actual=$this->input->get('pagina');
                
        $limit_tareas=$this->limit_tareas;
        
        $primer_registro=($pagina_actual-1)*$limit_tareas;
        
        $tareas=$this->tareas_model->mostrarTareas();
        
        $tareas_trozo=array_slice($tareas,$primer_registro,$limit_tareas);
        $total_paginas=ceil(count($tareas)/$limit_tareas);
        //$pagina_actual=1;
        
        $data['tareas'] = $tareas_trozo;
        $data['total_paginas'] = $total_paginas;
        $data['pagina_actual'] = $pagina_actual;
        $this->load->view('inicio_view',$data);
    }
    
    public function eliminarTarea($cod_tarea)
    {
        //$cod_tarea=$this->input->get('cod_tarea');
        
        $this->tareas_model->eliminarTarea($cod_tarea);
        
        //$opcion_menu='inicio';

        $rutaCarpeta = 'uploads/'.$cod_tarea.'/';
        if (file_exists($rutaCarpeta)) 
        {       
            $this->tareas_model->eliminarCarpetaTarea($rutaCarpeta);
        }

        $rutaCarpeta = 'archivosIcs/'.$cod_tarea.'/';
        if (file_exists($rutaCarpeta)) 
        {       
            $this->tareas_model->eliminarCarpetaTarea($rutaCarpeta);
        }
        //$this->session->set_userdata('opcion_menu',$opcion_menu);
        $this->session->set_userdata('titulo_pagina','Inicio');
      
        
        $limit_tareas=$this->limit_tareas;
        
        $tareas=$this->tareas_model->mostrarTareas();
        
        $tareas_trozo=array_slice($tareas,0,$limit_tareas);
        $total_paginas=ceil(count($tareas)/$limit_tareas);
        $pagina_actual=1;
        $mensaje_confirmacion='✔ Tarea eliminada correctamente';
        $data['mensaje_confirmacion']=$mensaje_confirmacion;
        $data['tareas'] = $tareas_trozo;
        $data['total_paginas'] = $total_paginas;
        $data['pagina_actual'] = $pagina_actual;
        $this->load->view('inicio_view',$data);
        
        $opcion_menu=$this->session->userdata('opcion_menu');
        
        switch ($opcion_menu) {
                case 'inicio':
                    redirect('inicio');
                    break;
                case 'tareas_pendientes':
                    redirect('tareas-pendientes');
                    break;
                case 'tareas_curso':
                    redirect('tareas-en-curso');
                    break;
                case 'tareas_completadas':
                    redirect('tareas-completadas');
                    break;
                case 'tareas_creadas':
                    redirect('tareas-creadas');
                    break;
        }
    }
    
    public function mostrarFiltro()
    {
        $cod_usuario=$this->session->userdata('cod_usuario');
        $opcion_menu=$this->session->userdata('opcion_menu');
        echo $opcion_menu;
                
        $mostrar_yo=$this->input->post('mostrar_yo');
        $mostrar_todos=$this->input->post('mostrar_todos');
        
        $mostrarall=-1;
        if($mostrar_yo=='on')
        {
            $mostrarall=0;
            
            $this->session->set_userdata('mostrar_todos',$mostrarall);
        }
        
        if($mostrar_todos=='on')
        {
            $mostrarall=1;
            
            $this->session->set_userdata('mostrar_todos',$mostrarall);
        }
        
        
        switch ($opcion_menu) 
        {
            case 'inicio':
                redirect('inicio');
                break;
            case 'tareas_pendientes':
                redirect('tareas-pendientes');
                break;
            case 'tareas_curso':
                redirect('tareas-en-curso');
                break;
            case 'tareas_completadas':
                redirect('tareas-completadas');
                break;
        }
        
        
    }
        
        
    
   
    
}

?>