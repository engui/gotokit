<?php

class tareascompletadas_controller extends CI_Controller
{
     private $limit_tareas=100;
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('tareas_model');
        $this->output->nocache();
        //$this->load->library('encrypt');
        //$this->load->library('session');
        
    }
    
    public function index()
    { 
        if($this->session->userdata('cod_usuario')=='')
        {
            redirect(base_url());
        }
        $opcion_menu='tareas_completadas';
        
        
        
        $this->session->set_userdata('opcion_menu',$opcion_menu);
        $this->session->set_userdata('titulo_pagina','Tareas Completadas');
      
        
        $limit_tareas=$this->limit_tareas;
        
        $tareas=$this->tareas_model->mostrarTareasPorEstado(3);
        
        $tareas_trozo=array_slice($tareas,0,$limit_tareas);
        $total_paginas=ceil(count($tareas)/$limit_tareas);
        $pagina_actual=1;
        $data['sololasmias'] = $this->session->userdata('sololasmias');
        $data["super"] = $this->session->userdata('super');
        

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
        
        $tareas=$this->tareas_model->mostrarTareasPorEstado(3);
        
        $tareas_trozo=array_slice($tareas,$primer_registro,$limit_tareas);
        $total_paginas=ceil(count($tareas)/$limit_tareas);
        //$pagina_actual=1;
        
        $data['tareas'] = $tareas_trozo;
        $data['total_paginas'] = $total_paginas;
        $data['pagina_actual'] = $pagina_actual;
        $this->load->view('inicio_view',$data);
    }

    
    
   
    
   
   
    
   
    
}

?>