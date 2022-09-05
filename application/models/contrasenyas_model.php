<?php 

class contrasenyas_model extends CI_Model
{
	public function mostrarContraseñas()
    {
    	$query = $this->db->query('SELECT * FROM contraseñas order by fecha_creada DESC, hora_creada DESC');

    	$contraseñas=$query->result_array();
        $num_contraseñas=$query->num_rows();
        
        $lista_contraseñas=array($num_contraseñas);
        
        $contador=0;

        foreach($contraseñas as $contraseña)
        {
        	$cod_contraseña = $contraseña['cod_contraseña'];
        	$nombre = $contraseña['nombre'];
        	$fecha_creada=$contraseña['fecha_creada'];
            $hora_creada=$contraseña['hora_creada'];
            $mensaje=$contraseña['mensaje'];

                
            $consulta_etiquetas=$this->db->query('SELECT id_cliente from relcontraseñacliente where cod_contraseña ='.$cod_contraseña);
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
            $lista_contraseñas[$contador]=array(
	            'cod_contraseña' => $cod_contraseña,
                'clientes' => $array_clientes_nombre,
                'colorClientes' => $array_clientes_color,
	            'nombre' => $nombre,
	            'fecha_creada' => $fecha_creada,
	            'hora_creada' => $hora_creada,
            	'mensaje' => $mensaje
            );

            $contador++;
        }
        return $lista_contraseñas;
    }

    public function getNombre($cod_contraseña)
	{
	    $query = $this->db->query('select nombre FROM contraseñas WHERE cod_contraseña='.$cod_contraseña);
	    $contraseña=$query->row();
	    
	    $nombre=$contraseña->nombre;

	    return $nombre;
	}

	public function eliminarContraseña($cod_contraseña)
    {
    	$campos=array(
            'cod_contraseña' => $cod_contraseña
        );
        
        $this->db->delete('contraseñas',$campos);
    }

    public function mostrarContraseña($cod_contraseña)
    {
        $query = $this->db->query('select * from contraseñas where cod_contraseña='.$cod_contraseña);
        $datos_contraseña = $query->row();
        
        return $datos_contraseña;
    }

    public function actualizarContraseña($param)
    {
        $cod_contraseña = $param['cod_contrasenya'];
        $nombre = $param['asunto'];
        $clientes = $param['clientes'];

        $campos=array(
            'nombre' => $nombre
        );
        
        $this->db->where('cod_contraseña',$cod_contraseña);
        $this->db->update('contraseñas',$campos);

        if(isset($clientes))
        {
            $this->db->delete('relcontraseñacliente', array('cod_contraseña' => $cod_contraseña));
            foreach ($clientes as $cliente)
            {
                $data = array(
                    'cod_contraseña' => $cod_contraseña,
                    'id_cliente' => $cliente
                );
                $this->db->insert('relcontraseñacliente', $data); //tabla y datos
            }
        }
        return $cod_contraseña;
    }

    public function actualizarMensaje($param)
    {
        $mensaje = $param["mensaje"];
        $cod_contraseña = $param['cod_contrasenya'];
        if(isset($mensaje))
        {
            $campos = array(
            'mensaje' => $mensaje
            );
            $this->db->where('cod_contraseña', $cod_contraseña);
            $this->db->update('contraseñas', $campos);
        }
    }

    public function nuevaContrasenya($param)
    {
        $cod_usuario=$this->session->userdata('cod_usuario');
        $campos=array(
            'nombre' => $param['nombre'],
            'fecha_creada' => $param['fecha_creada'],
            'hora_creada' => $param['hora_creada'],
            'mensaje' => $param['mensaje'],
            'usuario_origen' => $cod_usuario
        );
       
        $this->db->insert('contraseñas',$campos);
        $cod_contraseña=$this->db->insert_id();

        if(isset($param["clientes"]))  
        {
            foreach ($param["clientes"] as $cliente)
            {
                $data = array(
                    'cod_contraseña' => $cod_contraseña,
                    'id_cliente' => $cliente
                );
                $this->db->insert('relcontraseñacliente', $data); //tabla y datos
            }
        }
    }
}
?>