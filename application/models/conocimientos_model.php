<?php

class conocimientos_model extends CI_Model
{
	public function mostrarConocimientos()
    {
    	$query = $this->db->query('SELECT * FROM conocimientos order by fecha_creada DESC, hora_creada DESC');

    	$conocimientos=$query->result_array();
        $num_conocimientos=$query->num_rows();
        
        if (sizeof($conocimientos)==0) return [];

        $lista_conocimientos=array($num_conocimientos);
        $contador=0;
        
        foreach($conocimientos as $conocimiento)
        {
        	$cod_conocimiento = $conocimiento['cod_conocimiento'];
        	$nombre = $conocimiento['nombre'];
        	$fecha_creada=$conocimiento['fecha_creada'];
            $hora_creada=$conocimiento['hora_creada'];
            $mensaje=$conocimiento['mensaje'];

                
            $consulta_etiquetas=$this->db->query('SELECT cod_etiqueta from reletiquetaconocimiento where cod_conocimiento ='.$cod_conocimiento);
            $array_etiquetas = $consulta_etiquetas->result_array();
            $array_etiquetas_nombre = array();
            $array_etiquetas_color = array();
            foreach ($array_etiquetas as $etiqueta) 
            {          
                if($etiqueta['cod_etiqueta']!=0)
                {
                    $consulta_para=$this->db->query('SELECT * FROM etiquetaconocimientos WHERE cod_etiqueta='.$etiqueta['cod_etiqueta']);
                    $fila_para=$consulta_para->row();

                    $array_etiquetas_nombre[] = $fila_para->nombre;
                    $array_etiquetas_color[] = $fila_para->color;
                }
            }

            $consulta_etiquetas=$this->db->query('SELECT id_cliente from relconocimientocliente where cod_conocimiento ='.$cod_conocimiento);
            $array_clientes = $consulta_etiquetas->result_array();
            $array_clientes_nombre = array();
            $array_clientes_color = array();
            foreach ($array_clientes as $cliente) 
            {
                if($cliente['id_cliente']!=0)
                {
                    $consulta_para=$this->db->query('SELECT * FROM clientes WHERE id='.$cliente['id_cliente']);
                    $fila_para=$consulta_para->row();

                    $array_clientes_nombre[] = $fila_para->nombre;
                    $array_clientes_color[] = $fila_para->color;
                }
            }
            $lista_conocimientos[$contador]=array(
	            'cod_conocimiento' => $cod_conocimiento,
	            'etiquetas' => $array_etiquetas_nombre,
                'colorEtiquetas' => $array_etiquetas_color,
                'clientes' => $array_clientes_nombre,
                'colorClientes' => $array_clientes_color,
	            'nombre' => $nombre,
	            'fecha_creada' => $fecha_creada,
	            'hora_creada' => $hora_creada,
            	'mensaje' => $mensaje
            );

            $contador++;
        }
        return $lista_conocimientos;
    }

    public function eliminarConocimiento($cod_conocimiento)
    {
    	$campos=array(
            'cod_conocimiento' => $cod_conocimiento
        );
        
        $this->db->delete('conocimientos',$campos);
    }

    public function nuevoConocimiento($param)
    {
    	$cod_usuario=$this->session->userdata('cod_usuario');
    	$campos=array(
            'nombre' => $param['nombre'],
            'fecha_creada' => $param['fecha_creada'],
            'hora_creada' => $param['hora_creada'],
            'mensaje' => $param['mensaje'],
            'usuario_origen' => $cod_usuario
        );
        $etiquetas = $param["etiquetas"];
        $this->db->insert('conocimientos',$campos);
        $cod_conocimiento=$this->db->insert_id();

        for ($i=0; $i < count($etiquetas); $i++) 
        { 
            $etiquetasNuevas = $this->db->query("select * from etiquetaconocimientos where cod_etiqueta='".$etiquetas[$i]."'");
            if ($etiquetasNuevas->num_rows() == 0) 
            {
                $numeroAleatorio = rand(0,7);
                $color = '';
                switch ($numeroAleatorio) {
                    case 0:
                        $color = '#0404B4';
                        break;
                    case 1:
                        $color = '#0080FF';
                        break;
                    case 2:
                        $color = '#088A08';
                        break;
                    case 3:
                        $color = '#04B486';
                        break;
                    case 4:
                        $color = '#F781BE';
                        break;
                    case 5:
                        $color = '#DF0174';
                        break;
                    case 6:
                        $color = '#FA8258';
                        break;
                    case 7:
                        $color = '#7b1195';
                        break;
                    default:
                        $color = '#01A9DB';
                        break;
                }
                $array = array(
                    'nombre' => $etiquetas[$i],
                    'color' => $color
                );  
                $this->db->insert('etiquetaconocimientos', $array);   
                $cod_etiqueta=$this->db->insert_id(); 
                $etiquetas[$i] = $cod_etiqueta;
            }
        }

        if(isset($etiquetas))
        {
        	foreach ($etiquetas as $etiqueta)
            {
                $data = array(
                    'cod_conocimiento' => $cod_conocimiento,
                    'cod_etiqueta' => $etiqueta
                );
                $this->db->insert('reletiquetaconocimiento', $data);
            }
        }

        if(isset($param["clientes"]))  
        {
            foreach ($param["clientes"] as $cliente)
            {
                $data = array(
                    'cod_conocimiento' => $cod_conocimiento,
                    'id_cliente' => $cliente
                );
                $this->db->insert('relconocimientocliente', $data); //tabla y datos
            }
        }
    }

    public function getNombre($cod_conocimiento)
    {
        $query = $this->db->query('select nombre FROM conocimientos WHERE cod_conocimiento='.$cod_conocimiento);
        $conocimiento=$query->row();
        
        $nombre=$conocimiento->nombre;

        return $nombre;
    }

    public function mostrarConocimiento($cod_conocimiento)
    {
    	$query = $this->db->query('select * from conocimientos where cod_conocimiento='.$cod_conocimiento);
        $datos_conocimiento = $query->row();
        
        return $datos_conocimiento;
    }

    public function actualizarConocimiento($param)
    {
    	$cod_conocimiento = $param['cod_conocimiento'];
    	$nombre = $param['asunto'];
    	$etiquetas = $param['etiquetas'];
        $clientes = $param['clientes'];

    	$campos=array(
            'nombre' => $nombre
        );

        //$array = array();
        for ($i=0; $i < count($etiquetas); $i++) 
        { 
            $etiquetasNuevas = $this->db->query("select * from etiquetaconocimientos where cod_etiqueta='".$etiquetas[$i]."'");
            if ($etiquetasNuevas->num_rows() == 0) 
            {
                $numeroAleatorio = rand(0,7);
                $color = '';
                switch ($numeroAleatorio) {
                    case 0:
                        $color = '#0404B4';
                        break;
                    case 1:
                        $color = '#0080FF';
                        break;
                    case 2:
                        $color = '#088A08';
                        break;
                    case 3:
                        $color = '#04B486';
                        break;
                    case 4:
                        $color = '#F781BE';
                        break;
                    case 5:
                        $color = '#DF0174';
                        break;
                    case 6:
                        $color = '#FA8258';
                        break;
                    case 7:
                        $color = '#7b1195';
                        break;
                    default:
                        $color = '#01A9DB';
                        break;
                }
                $array = array(
                    'nombre' => $etiquetas[$i],
                    'color' => $color
                );  
                if ($etiquetas[$i] != "") 
                {
                    $this->db->insert('etiquetaconocimientos', $array);   
                    $cod_etiqueta=$this->db->insert_id(); 
                    $etiquetas[$i] = $cod_etiqueta;
                }
            }
        }
        
    	$this->db->where('cod_conocimiento',$cod_conocimiento);
    	$this->db->update('conocimientos',$campos);

    	if(isset($etiquetas))
    	{
    		$this->db->delete('reletiquetaconocimiento', array('cod_conocimiento' => $cod_conocimiento));// DELETE FROM reltareacliente  // WHERE cod_tarea = $cod_tarea
    		foreach ($etiquetas as $etiqueta)
            {
                $data = array(
                    'cod_conocimiento' => $cod_conocimiento,
                    'cod_etiqueta' => $etiqueta
                );
                $this->db->insert('reletiquetaconocimiento', $data); //tabla y datos
            }
    	}

        if(isset($clientes))
        {
            $this->db->delete('relconocimientocliente', array('cod_conocimiento' => $cod_conocimiento));
            foreach ($clientes as $cliente)
            {
                $data = array(
                    'cod_conocimiento' => $cod_conocimiento,
                    'id_cliente' => $cliente
                );
                $this->db->insert('relconocimientocliente', $data); //tabla y datos
            }
        }
    	return $cod_conocimiento;
    }

    public function actualizarMensaje($param)
    {
    	$mensaje = $param["mensaje"];
    	$cod_conocimiento = $param['cod_conocimiento'];
    	if(isset($mensaje))
    	{
    		$campos = array(
            'mensaje' => $mensaje
        	);
	        $this->db->where('cod_conocimiento', $cod_conocimiento);
	        $this->db->update('conocimientos', $campos);
    	}
    }

    public function prueba($param)
    {
        $etiquetas = $param["etiquetas"];
        $array = array();
        for ($i=0; $i < count($etiquetas); $i++) 
        { 
            $etiquetasNuevas = $this->db->query("select * from etiquetaconocimientos where cod_etiqueta='".$etiquetas[$i]."'");
            if ($etiquetasNuevas->num_rows() == 0) 
            {
                $array[] = $etiquetas[$i];
            }
        }
        return $array;
    }

    public function obtenerUltimoConocimientoCreado()
    {
        $query = $this->db->query('SELECT MAX(cod_conocimiento) AS maximo FROM conocimientos');
        $codConocimiento = $query->row();
        $ultimoCodConocimiento = $codConocimiento->maximo;

        return $ultimoCodConocimiento;
    }

    public function obtenerUltimoArchivo($cod_conocimiento)
    {
        $query = $this->db->query('SELECT MAX(cod_archivo) AS maximo FROM archivosconocimiento WHERE cod_conocimiento='.$cod_conocimiento);
        $cod_archivo = $query->row();
        $ultimoCodArchivo = $cod_archivo->maximo;

        return $ultimoCodArchivo;
    }

    public function anyadirArchivosNuevoConocimiento($ficheros)
    {
        $ultimoCodConocimiento = $this->obtenerUltimoConocimientoCreado();
        $arrayNombres = $ficheros;
        $numeroNombres = count($arrayNombres);
        if(isset($arrayNombres))
        {
            for ($i=0; $i < $numeroNombres; $i++)
            {
                $datos = array(
                    'cod_conocimiento' => $ultimoCodConocimiento,
                    'cod_archivo' => $i+1,
                    'ruta' => 'archivosConocimientos/'.$ultimoCodConocimiento.'/'.$arrayNombres[$i]
                );
                $this->db->insert('archivosconocimiento',$datos);
            }
        }
    }

    public function anyadirArchivosConocimiento($ficheros,$cod_conocimiento)
    {
        $arrayNombres = $ficheros;
        $numeroNombres = count($arrayNombres);
        if(isset($arrayNombres))
        {
            for ($i=0; $i < $numeroNombres; $i++)
            {
                $ultimoCodArchivo = $this->obtenerUltimoArchivo($cod_conocimiento);
                $datos = array(
                    'cod_conocimiento' => $cod_conocimiento,
                    'cod_archivo' => $ultimoCodArchivo+1,
                    'ruta' => 'archivosConocimientos/'.$cod_conocimiento.'/'.$arrayNombres[$i]
                );
                $this->db->insert('archivosconocimiento',$datos);
            }
        }
    }

    public function obtenerRutaArchivos($cod_conocimiento)
    {
        $query = $this->db->query('select cod_archivo,ruta from archivosconocimiento where cod_conocimiento='.$cod_conocimiento);
        $rutasArchivos = $query->result_array();
        
        return $rutasArchivos;
    }

    public function obtenerRutaArchivo($cod_conocimiento,$cod_archivo)
    {
        $query = $this->db->query('select ruta from archivosconocimiento where cod_conocimiento='.$cod_conocimiento.' AND cod_archivo='.$cod_archivo);
        $rutasArchivos = $query->row();
        return $rutasArchivos->ruta;
    }

    public function eliminarArchivo($param)
    {
        $cod_conocimiento = $param['cod_conocimiento'];
        $cod_archivo = $param['cod_archivo'];
        $ruta = $param['ruta'];

        $campos = array(
            'cod_conocimiento' => $cod_conocimiento,
            'cod_archivo' => $cod_archivo
        );
        $this->db->delete('archivosconocimiento',$campos);
        unlink($ruta);
    }

    public function eliminarCarpetaConocimiento($carpeta)
    {
        foreach(glob($carpeta . "/*") as $archivos_carpeta)
        {             
            if (is_dir($archivos_carpeta))
            {
                rmDir_rf($archivos_carpeta);
            } 
            else 
            {
                unlink($archivos_carpeta);
            }
        }
        rmdir($carpeta);
    }
}

?>