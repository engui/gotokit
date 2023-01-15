<?php

class clientes_model extends CI_Model
{
    public function mostrarClientes()
    {
      
        $query = $this->db->query('select * from clientes');
        $clientes = $query->result_array();
        
        return $clientes;  
    }

    public function obtenerClientePorID($id_cliente)
    {
        $query = $this->db->query('select * from clientes where id='.$id_cliente);
        $datosClientes = $query->result_array();

        return $datosClientes;
    }
    
    public function mostrarTablaRelacionTareasClientes($cod_tarea)
    {
    	$query = $this->db->query('select id_cliente from reltareacliente where cod_tarea='.$cod_tarea);
        $tareasClientes = $query->result_array();
        
        return $tareasClientes;
    } 

    public function mostrarClientesCodigo($cod_conocimiento)
    {
        $query = $this->db->query('select id_cliente from relconocimientocliente where cod_conocimiento='.$cod_conocimiento);
        $conocimientosClientes = $query->result_array();
        
        return $conocimientosClientes;
    }

    public function mostrarClientesCodigoContraseñas($cod_contraseña)
    {
        $query = $this->db->query('select id_cliente from relcontraseñacliente where cod_contraseña='.$cod_contraseña);
        $contraseñasClientes = $query->result_array();
        
        return $contraseñasClientes;
    }

    public function insertarCliente($data)
    {
        $campos=array(
            'nombre' => $data['nombre'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
            'cp' => $data['cp'],
            'poblacion' => $data['poblacion'],
            'provincia' => $data['provincia'],
            'pais' => $data['pais']
        );
        $this->db->insert('clientes',$campos);   
        return $this->db->insert_id();
    }

    public function modificarCliente($data)
    {
        //$query = $this->db->query('UPDATE clientes SET nombre = '.$data['nombre'].', color = '.$data['color'].' WHERE id = '.$data['cod_cliente']);
        //$this->db->delete('clientes', array('cod_cliente' => $data['cod_cliente']));
        $this->db->set('nombre', $data['nombre']);
        $this->db->set('telefono', $data['telefono']);
        $this->db->set('direccion', $data['direccion']);
        $this->db->set('cp', $data['cp']);
        $this->db->set('poblacion', $data['poblacion']);
        $this->db->set('provincia', $data['provincia']);
        $this->db->set('pais', $data['pais']);
        $this->db->where('id', $data['cod_cliente']);
        $this->db->update('clientes'); // gives UPDATE mytable SET field = field+1 WHERE id = 2
    }

    public function eliminarCliente($data)
    {
        $campos=array(
            'id' => $data['cod_cliente']
        );
        $this->db->delete('clientes',$campos);
    }
}

?>