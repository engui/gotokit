<?php

class login_controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->helper('cookie');
        //$this->load->library('encrypt');
        //$this->load->library('session');
        $this->output->nocache();
        
    }
    
    public function index()
    {
        
        $data['cookie_usuario'] = get_cookie("usuario");
        $data['cookie_password'] = get_cookie("password");
        $data['cookie_recuerdame'] = get_cookie("recuerdame");

        if (!isset($data['cookie_usuario'])) $data['cookie_usuario'] = "";
        if (!isset($data['cookie_password'])) $data['cookie_password'] = "";
        if (!isset($data['cookie_recuerdame'])) $data['cookie_recuerdame'] = "";
        
        $cod_usuario=$this->session->userdata('cod_usuario');
        
        if($cod_usuario!=null)
        {
            
            $this->irInicio();
        }
        else
        {
          $this->session->sess_destroy();
          $this->load->view('login_view',$data);
           
            
        }
            
        
    }
    
    public function loginUsuario()
    {
        $usuario_email=$this->input->post('usuarioEmail');
        //$password_panel=$this->encrypt->sha1($this->input->post('passwordUsuario'));
        $usuario_password=$this->input->post('usuarioPassword');
        $recuerdame = $this->input->post('recordarPanel');
        
                   
        $res=$this->login_model->loginUsuario($usuario_email, $usuario_password);
        
        if($res == 1)
        {
            //$this->load->view('persona/vUpdatePersona');
            //$data['mensaje_login'] = '<span class="mensaje-login-correcto">Correo electrónico y contraseña correctos</span>';
            //$this->load->view('login_view',$data);
            
            if ($recuerdame=="on")
            {
                $cookie= array(
                    'name'   => 'usuario',
                    'value'  => $usuario_email,
                    'expire' => '0',
                );

                set_cookie($cookie);
                
                $cookie= array(
                    'name'   => 'password',
                    'value'  => $usuario_password,
                    'expire' => '0',
                );

                $cookie= array(
                    'name'   => 'recuerdame',
                    'value'  => 'on',
                    'expire' => '0',
                );
                
                set_cookie($cookie);
            }
            else
            {
                delete_cookie("usuario");
                delete_cookie("password");
                delete_cookie("recuerdame");

            }
            $this->irInicio();
            
            
        }
        else
        {
            $data['mensaje_error'] = 'Correo electrónico o contraseña incorrectos';
            $data['cookie_usuario'] = get_cookie("usuario");
        $data['cookie_password'] = get_cookie("password");
        $data['cookie_recuerdame'] = get_cookie("recuerdame");

        if (!isset($data['cookie_usuario'])) $data['cookie_usuario'] = "";
        if (!isset($data['cookie_password'])) $data['cookie_password'] = "";
        if (!isset($data['cookie_recuerdame'])) $data['cookie_recuerdame'] = "";
            $this->load->view('login_view',$data);
        }
    }
    
    public function cerrarSesion()
    {
        
        $this->session->sess_destroy();
        //$this->load->view('login_view');
        
        
        $this->index();
    }
    
    public function irInicio()
    {
        redirect('inicio');
        //redirect('tareas-pendientes');
    }
    
    
}

?>