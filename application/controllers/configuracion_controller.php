<?php 

class configuracion_controller extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('configuracion_model');
        $this->load->model('usuarios_model');
        $this->output->nocache(); 
    }

    public function index()
    {
        $this->session->set_userdata('titulo_pagina','Configuración');
        $data = $this->configuracion_model->get_config()->row();
        $data->usuariosactivos = $this->usuarios_model->getCantUsuariosActivos();
        
    	$this->load->view('configuracion_view', $data);
    }

    public function get_space()
    {
        $esp = $this->formatBytes($this->foldersize(getcwd().'/'),2);
        $this->configuracion_model->update_espacioocupado($esp);
        echo round($esp,0);
    }

    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        //$suffixes = array('', 'K', 'M', 'G', 'T');   
    
        //return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
        return round(pow(1024, $base - floor($base)), $precision);
    }

    public function crear_copia_ajax()
    {
        array_map( 'unlink', array_filter((array) glob(getcwd()."copias/*")));
        $nombre_fichero = date("Y_m_d_H_i", time()).".eng";
        $nombre_url = base_url()."copias/$nombre_fichero";
        $destino = getcwd().'/copias/'.$nombre_fichero;
        $ejecutar_copia = COPIA_COMANDO." ".COPIA_HOST." --user=".COPIA_USER." --password=".COPIA_PASSWORD." --extended-insert=false ".COPIA_DB." -r ".$destino; 
        exec ($ejecutar_copia);
        echo (json_encode($nombre_url));
    }

    public function crear_copia_ficheros_ajax()
    {
        array_map( 'unlink', array_filter((array) glob(getcwd()."/copias/*")));
        $nombre_fichero = "ficheros".date("Y_m_d_H_i", time()).".zip";
        $nombre_url = base_url()."copias/$nombre_fichero";
        $destino = getcwd().'/copias/'.$nombre_fichero;
        $ejecutar_copia = COPIA_ZIP." ".$destino." archivosConocimientos uploads";
        exec ("cd ".COPIA_ZIP);
        exec ($ejecutar_copia);
        echo (json_encode($nombre_url));
    }

    

    public function exportar_a_csv_ajax()
    {
        array_map( 'unlink', array_filter((array) glob(getcwd()."/copias/*")));
        $tablas = $this->db->list_tables();
        foreach ($tablas as $tabla)
        {
            if ($tabla!="config")
            {
                $output = fopen(getcwd()."/copias/$tabla.csv", "a");  
                $campos = $this->db->list_fields($tabla);
                fputcsv($output, $campos);  
                $valores = $this->db->query("select * from $tabla")->result_array();
                foreach ($valores as $valor)
                {
                    fputcsv($output, $valor);
                }
                fclose($output);
            }
        }
        $nombre_fichero = "csv".date("Y_m_d_H_i", time()).".zip";
        $nombre_url = base_url()."copias/$nombre_fichero";
        $ejecutar_copia = COPIA_ZIP." ".$nombre_fichero.' .';
        exec ("cd ".getcwd()."/copias/;$ejecutar_copia");
        echo (json_encode($nombre_url));
    }


    function foldersize($src)
	{
			$total_size = 0;
			if (is_dir($src))
			{
				$dir = opendir($src);
				while ($element = readdir($dir))
				{
					if ($element != '' && $element != '.' && $element != '..')
					{
						$element = $src.$element;
						if (is_dir($element))
						{
							$size = $this->foldersize($element.'/');
							$total_size += $size;
						}
						else
						{
							$size = filesize($element);
							$total_size += $size;
						}
					}
				}
				return $total_size;
			}
		} 
    }

    

    
?>