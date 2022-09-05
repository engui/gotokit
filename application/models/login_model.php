<?php

class login_model extends CI_Model
{
    public function loginUsuario($usuario_email, $usuario_password)
    {
                
        $query = $this->db->query('SELECT * FROM usuarios WHERE email="'.$usuario_email.'" AND password="'.$usuario_password.'" AND activo=1');

        
        
        $num_filas=$query->num_rows();
        
        //if($resultado->num_rows == 1)
        if($num_filas > 0)
        {
            $fila_usuario=$query->row();
            
            if($fila_usuario->super==1)
            {
                $mostrar_todos=1;
            }
            else
            {
                $mostrar_todos=0;
            }
            
            $session_usuario = array(
                'cod_usuario'       => $fila_usuario->cod_usuario,
                'nombre_usuario'    => $fila_usuario->nombre,
                'email_usuario'     => $fila_usuario->email,
                'color_usuario'     => $fila_usuario->color_usuario,
                'super'             => $fila_usuario->super,
                'verContraseñas'    => $fila_usuario->verContraseñas,
                'mostrar_todos'     => $mostrar_todos
            
            );
            
            $this->session->set_userdata($session_usuario);
            
            //$this->session->set_flashdata('variable que se va al hacer un refresh');
            
            /*$this->session->userdata('s_id_usuario',$r->id_usuario);
            $this->session->userdata('s_usuario',$r->nombre." ".$r->primerapellido);*/
            
            return 1;
        }
        else
        {
            return 0;
        }
    }
    
   
    
    
}

?>