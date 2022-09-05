<?php

class etiquetas_model extends CI_Model
{
	public function getEtiquetas()
	{
        $query = $this->db->query('SELECT * FROM etiquetaconocimientos');        
        $etiquetas=$query->result_array();
            
        return $etiquetas;
	}

	public function getEtiquetasCodigo($cod_conocimiento)
	{
		$query = $this->db->query('SELECT cod_etiqueta FROM reletiquetaconocimiento WHERE cod_conocimiento ='.$cod_conocimiento);        
        $etiquetas=$query->result_array();
            
        return $etiquetas;
	}

	public function obtenerEtiquetaPorID($cod_etiqueta)
	{
		$query = $this->db->query('SELECT * FROM etiquetaconocimientos WHERE cod_etiqueta = '.$cod_etiqueta);        
        $datosEtiquetas=$query->result_array();
            
        return $datosEtiquetas;
	}

	public function insertarEtiqueta($data)
    {
        $campos=array(
            'nombre' => $data['nombre'],
            'color' => $data['color']
        );
        $this->db->insert('etiquetaconocimientos',$campos);   
    }

    public function modificarEtiqueta($data)
    {
        $this->db->set('nombre', $data['nombre']);
        $this->db->set('color', $data['color']);
        $this->db->where('cod_etiqueta', $data['cod_etiqueta']);
        $this->db->update('etiquetaconocimientos'); // gives UPDATE mytable SET field = field+1 WHERE id = 2
    }

    public function eliminarEtiqueta($data)
    {
        $campos=array(
            'cod_etiqueta' => $data['cod_etiqueta']
        );
        $this->db->delete('etiquetaconocimientos',$campos);
    }
}
?>