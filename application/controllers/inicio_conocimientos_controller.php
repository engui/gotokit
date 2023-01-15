<?php

class inicio_conocimientos_controller extends CI_Controller
{
    private $limit_conocimientos=100;

	function __construct()
    {
        parent::__construct();
        $this->load->model('conocimientos_model');      
        $this->output->nocache();
    }

    public function index()
    {
        /*$opcion_menu='inicio';
        $this->session->set_userdata('opcion_menu',$opcion_menu);*/
        $this->session->set_userdata('titulo_pagina','Base Conocimientos');
    	//$this->load->view('mostrar_conocimientos_view');

        $limit_conocimientos=$this->limit_conocimientos;

        $conocimientos=$this->conocimientos_model->mostrarConocimientos();
        $conocimientos_trozo=array_slice($conocimientos,0,$limit_conocimientos);
        $total_paginas=ceil(count($conocimientos)/$limit_conocimientos);
        $pagina_actual=1;

        $data['conocimientos'] = $conocimientos_trozo;
        $data['total_paginas'] = $total_paginas;
        $data['pagina_actual'] = $pagina_actual;
        $this->load->view('mostrar_conocimientos_view',$data);
    }

    public function mostrarConocimientos()
    {
        $pagina_actual=$this->input->get('pagina');

        $limit_conocimientos=$this->limit_conocimientos;

        $primer_registro=($pagina_actual-1)*$limit_conocimientos;

        $conocimientos=$this->conocimientos_model->mostrarConocimientos();

        $conocimientos_trozo=array_slice($conocimientos,$primer_registro,$limit_conocimientos);
        $total_paginas=ceil(count($conocimientos)/$limit_conocimientos);
        //$pagina_actual=1;

        $data['conocimientos'] = $conocimientos_trozo;
        $data['total_paginas'] = $total_paginas;
        $data['pagina_actual'] = $pagina_actual;
        $this->load->view('mostrar_conocimientos_view',$data);
    }

    public function eliminarConocimiento($cod_conocimiento)
    {
        $this->conocimientos_model->eliminarConocimiento($cod_conocimiento);
        $rutaCarpeta = 'archivosConocimientos/'.$cod_conocimiento.'/';
        $this->conocimientos_model->eliminarCarpetaConocimiento($rutaCarpeta);
        redirect('inicio_conocimientos');
    }
}

?>