<?php

class usuarios_model extends CI_Model
{
   
    
    public function getUsuarios()
    {
        $query = $this->db->query('SELECT * FROM usuarios WHERE activo=1');

        
        $usuarios=$query->result_array();
            
        return $usuarios;
    }

    public function getCantUsuariosActivos()
    {
        $this->db->select('COUNT(*) as cant')
                 ->from('usuarios')
                 ->where('activo',1);
        $query = $this->db->get();
        return $query->row()->cant;
    }

    public function obtenerTodosUsuarios()
    {
        $query = $this->db->query('SELECT * FROM usuarios');

        
        $usuarios=$query->result_array();
            
        return $usuarios;
    }

    public function getUsuariosAsignados($cod_tarea)
    {
        $query = $this->db->query('SELECT usuario_destino FROM reltareausuariodest WHERE cod_tarea='.$cod_tarea);

        $usuariosAsignados = $query->result_array();

        return $usuariosAsignados;
    }
    
    public function getGrupos()
    {
        $query = $this->db->query('SELECT * FROM grupos WHERE activo=1');

        
        $grupos=$query->result_array();
            
        return $grupos;
    }
    
    public function getUsuarioSession()
    {
        $cod_usuario=$this->session->userdata('cod_usuario');
        $nombre_usuario=$this->session->userdata('nombre_usuario');
        $email_usuario=$this->session->userdata('email_usuario');
        $color_usuario=$this->session->userdata('color_usuario');
        
        $usuario_session=array(
        
                'cod_usuario'       => $cod_usuario,
                'nombre_usuario'    => $nombre_usuario,
                'email_usuario'     => $email_usuario,
                'color_usuario'     => $color_usuario        
        
        );
        
        return $usuario_session;
    }
    
    public function obtenerUsuarioPorID($cod_usuario)
    {
        $query = $this->db->query('select * from usuarios where cod_usuario='.$cod_usuario);
        $datosClientes = $query->result_array();

        return $datosClientes;
    }

    public function insertarUsuario($data)
    {
        $campos=array(
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'password'=> $data['contrasenya'],
            'activo' => $data['activo'],
            'accesos' => 0,
            'color_usuario' => $data['color'],            
            'super' => $data['admin'],
            'verContraseñas' => $data['verContrasenyas']
        );
        $this->db->insert('usuarios',$campos);   
    }

    public function modificarUsuario($data)
    {
        $this->db->set('nombre', $data['nombre']);
        $this->db->set('email', $data['email']);
        $this->db->set('password', $data['contrasenya']);
        $this->db->set('activo', $data['activo']);
        $this->db->set('color_usuario', $data['color']);
        $this->db->set('super', $data['admin']);
        $this->db->set('verContraseñas', $data['verContrasenyas']);
        $this->db->where('cod_usuario', $data['cod_usuario']);
        $this->db->update('usuarios');
        
        $this->session->set_userdata('verContraseñas',$data['verContrasenyas']);
        $this->session->set_userdata('super',$data['admin']);
    }

    public function comprobarExistenciaUsuario($cod_usuario) //consultar tareas,conocimientos, lintareas, reReltareausuariodest
    {
        $arrayResultados = array();
        $queryTareas = $this->db->query('SELECT * FROM tareas WHERE usuario_origen = '.$cod_usuario);
        $datosTarea = $queryTareas->result_array();
        //1 = V  0 = F
        if (count($datosTarea) == 0) 
        {
            $arrayResultados[] = 1; //Si se puede borrar
        }
        else
        {
            $arrayResultados[] = 0; //No se puede borrar
        }

        $queryConocimientos = $this->db->query('SELECT * FROM conocimientos WHERE usuario_origen = '.$cod_usuario);
        $datosConocimientos = $queryConocimientos->result_array();
        if (count($datosConocimientos) == 0) 
        {
            $arrayResultados[] = 1; //Si se puede borrar
        }
        else
        {
            $arrayResultados[] = 0; //No se puede borrar
        }

        $queryLintareas = $this->db->query('SELECT * FROM lintareas WHERE cod_usuario = '.$cod_usuario);
        $datosLintareas = $queryLintareas->result_array();
        if (count($datosLintareas) == 0) 
        {
            $arrayResultados[] = 1; //Si se puede borrar
        }
        else
        {
            $arrayResultados[] = 0; //No se puede borrar
        }

        /*$queryReltareacliente = $this->db->query('SELECT * FROM reltareacliente WHERE id_cliente = '.$cod_usuario);
        $datosReltareacliente = $queryReltareacliente->result_array();
        if (count($datosReltareacliente) == 0) 
        {
            $arrayResultados[] = 1; //Si se puede borrar
        }
        else
        {
            $arrayResultados[] = 0; //No se puede borrar
        }*/

        $queryReltareausuariodest = $this->db->query('SELECT * FROM reltareausuariodest WHERE usuario_destino = '.$cod_usuario);
        $datosReltareausuariodest = $queryReltareausuariodest->result_array();
        if (count($datosReltareausuariodest) == 0) 
        {
            $arrayResultados[] = 1; //Si se puede borrar
        }
        else
        {
            $arrayResultados[] = 0; //No se puede borrar
        }

        return $arrayResultados;
    }

    public function eliminarUsuario($data)
    {
        $campos=array(
            'cod_usuario' => $data['cod_usuario']
        );
        $this->db->delete('usuarios',$campos);
    }
}

?>