<?php

class archivos_model extends CI_Model
{
	public function obtenerCodLineaRutaArchivos($cod_tarea)
    {
    	$query = $this->db->query('select cod_linea,ruta from archivosadjuntos where cod_tarea='.$cod_tarea);
        $rutasArchivos = $query->result_array();
        
        return $rutasArchivos;
    }

    public function obtenerRutaArchivo($cod_linea,$cod_tarea)
    {
    	$query = $this->db->query('select ruta from archivosadjuntos where cod_tarea='.$cod_tarea.' AND cod_linea='.$cod_linea);
        $rutasArchivos = $query->result_array();
        
        return $rutasArchivos;
    }
}

?>