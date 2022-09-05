<?php

class estados_model extends CI_Model
{
    public function mostrarEstados()
    {
      
        $query = $this->db->query('select * from estados');
        $estados = $query->result_array();
        
        return $estados;
    
    }
    
   
    
    
}

?>