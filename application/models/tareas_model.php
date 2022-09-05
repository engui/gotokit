<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require ("_lib/PHPMailerAutoload.php");
require_once 'Classes/PHPExcel.php';

class tareas_model extends CI_Model
{
    public function ponerComoLeida($cod_tarea,$usuario_session)
    {
        $this->db->query ('update reltareausuariodest set noleidos=0 where cod_tarea='.$cod_tarea.' and usuario_destino='.$usuario_session);
    }


    public function mostrarTarea($cod_tarea)
    {

        $query = $this->db->query('select * from tareas where cod_tarea='.$cod_tarea);
        $datos_tarea = $query->row();
        
        return $datos_tarea;
    }
    
    public function mostrarTareas()
    {
        //$query = $this->db->query('select t.*, e.descripcion, e.color, u.nombre as usuario, u.color_usuario from tareas t, estados e, usuarios u where t.estado=e.cod_estado and t.usuario_destino=u.cod_usuario ORDER BY t.fecha_limite ASC, t.hora_limite ASC');
        $super=$this->session->userdata('super');
        $cod_usuario=$this->session->userdata('cod_usuario');
        
        if($super==1)
        {
             $mostrar_todos=$this->session->userdata('mostrar_todos');
            
            if($mostrar_todos!=0)
            {
                $query = $this->db->query('select DISTINCT T.cod_tarea,T.fecha_creada,T.hora_creada,T.fecha_aceptada,T.hora_aceptada,T.fecha_mod,T.hora_mod,T.fecha_completa,T.hora_completa,T.fecha_limite,T.hora_limite,T.nombre,T.estado,T.usuario_origen,T.prioridad FROM tareas T,reltareausuariodest R WHERE T.cod_tarea = R.cod_tarea order by T.fecha_mod DESC, T.hora_mod DESC,FIELD(estado,2,1,3),FIELD(prioridad,"ALTA","MEDIA","BAJA")');
            }
            else
            {
                $query = $this->db->query('select T.cod_tarea,T.fecha_creada,T.hora_creada,T.fecha_aceptada,T.hora_aceptada,T.fecha_mod,T.hora_mod,T.fecha_completa,T.hora_completa,T.fecha_limite,T.hora_limite,T.nombre,T.estado,T.usuario_origen,R.usuario_destino,T.prioridad,R.noleidos  FROM tareas T,reltareausuariodest R WHERE T.cod_tarea = R.cod_tarea AND R.usuario_destino = '.$cod_usuario.' order by T.fecha_mod DESC, T.hora_mod DESC,FIELD(estado,2,1,3),FIELD(prioridad,"ALTA","MEDIA","BAJA")');
            }
        }
        else
        {
            $query = $this->db->query('select T.cod_tarea,T.fecha_creada,T.hora_creada,T.fecha_aceptada,T.hora_aceptada,T.fecha_mod,T.hora_mod,T.fecha_completa,T.hora_completa,T.fecha_limite,T.hora_limite,T.nombre,T.estado,T.usuario_origen,R.usuario_destino,T.prioridad,R.noleidos FROM tareas T,reltareausuariodest R WHERE T.cod_tarea = R.cod_tarea AND R.usuario_destino = '.$cod_usuario.' order by T.fecha_mod DESC, T.hora_mod DESC, FIELD(estado,2,1,3),FIELD(prioridad,"ALTA","MEDIA","BAJA")');
        }

        $tareas=$query->result_array();
        $num_tareas=$query->num_rows();
        
        $lista_tareas=array($num_tareas);
        
        $contador=0;
        
        foreach($tareas as $tarea)
        {
            $cod_tarea=$tarea['cod_tarea'];
            $fecha_creada=$tarea['fecha_creada'];
            $hora_creada=$tarea['hora_creada'];
            $fecha_limite=$tarea['fecha_limite'];
            $hora_limite=$tarea['hora_limite'];
            $nombre_tarea=$tarea['nombre'];
            $estado=$tarea['estado'];
            $usuario_origen=$tarea['usuario_origen'];
            $prioridad = $tarea['prioridad'];
            if (isset($tarea['noleidos'])) $noleidos = $tarea['noleidos'];
            else
            {
                $query = $this->db->query('select ifnull(noleidos,0) as noleidos from reltareausuariodest where cod_tarea='.$cod_tarea.' and usuario_destino='.$cod_usuario);
                $n = $query->row();
                if (!$n) $noleidos=0;
                else $noleidos=$n->noleidos;
            }
            
            
            //$usuario_destino=$tarea['usuario_destino'];
            //$grupo_destino=$tarea['grupo_destino'];

            
            $consulta_estado=$this->db->query('SELECT * FROM estados WHERE cod_estado='.$estado);
            $fila_estado=$consulta_estado->row();
            
            $nombre_estado=$fila_estado->descripcion;
            $color_estado=$fila_estado->color;
            
            //************************************************************************
            $consulta_usuarios=$this->db->query('SELECT usuario_destino from reltareausuariodest where cod_tarea ='.$cod_tarea.' order by field(usuario_destino,'.$usuario_origen.') desc');
            $array_usuarios = $consulta_usuarios->result_array();
            //************************************************************************
            //************************************************************************
            $array_nombre_para = array();
            $array_color_para = array();
            foreach ($array_usuarios as $usuario_destino) 
            {          
                if($usuario_destino['usuario_destino']!=0)
                {
                    $consulta_para=$this->db->query('SELECT * FROM usuarios WHERE cod_usuario='.$usuario_destino['usuario_destino']);
                    $fila_para=$consulta_para->row();

                    //$nombre_para=$fila_para->nombre;
                    $array_nombre_para[] = $fila_para->nombre;
                    //$color_para=$fila_para->color_usuario;
                    $array_color_para[] = $fila_para->color_usuario;

                }
            }

            $consulta_clientes=$this->db->query('SELECT id_cliente from reltareacliente where cod_tarea ='.$cod_tarea);
            $array_clientes = $consulta_clientes->result_array();
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
            //************************************************************************
            /*else//GRUPOOOOOOO
            {
                 $consulta_para=$this->db->query('SELECT * FROM grupos WHERE cod_grupo='.$grupo_destino);
                $fila_para=$consulta_para->row();
                
                $nombre_para=$fila_para->nombre;
                $color_para=$fila_para->color_grupo;
            }*/
            
            $lista_tareas[$contador]=array(
            
                    'cod_tarea' => $cod_tarea,
                    'fecha_creada' => $fecha_creada,
                    'hora_creada' => $hora_creada,
                    'fecha_limite' => $fecha_limite,
                    'hora_limite' => $hora_limite,
                    'nombre' => $nombre_tarea,
                    'nombre_estado' => $nombre_estado,
                    'color_estado' => $color_estado,
                    'nombre_para' => $array_nombre_para,
                    'color_para' => $array_color_para,
                    'clientes' => $array_clientes_nombre,
                    'colorClientes' => $array_clientes_color,
                    'prioridad' => $prioridad,
                    'noleidos' => $noleidos
                    //'nombre_para' => $nombre_para,
                    //'color_para' => $color_para
                    
            
            );
                
            $contador++;
        }

        
        //$tareas=$query->result_array();
        
    
            
        return $lista_tareas;
    }
    
    public function mostrarTareasCreadas()
    {
         //$query = $this->db->query('select t.*, e.descripcion, e.color, u.nombre as usuario, u.color_usuario from tareas t, estados e, usuarios u where t.estado=e.cod_estado and t.usuario_destino=u.cod_usuario ORDER BY t.fecha_limite ASC, t.hora_limite ASC');
        $super=$this->session->userdata('super');
        $cod_usuario=$this->session->userdata('cod_usuario');
        
      
                //$query = $this->db->query('select * from tareas where usuario_origen='.$cod_usuario.' order by fecha_limite, hora_limite');
        $query = $this->db->query('select * from tareas where usuario_origen='.$cod_usuario.' order by fecha_mod DESC, hora_mod DESC');
          

        $tareas=$query->result_array();
        $num_tareas=$query->num_rows();
        
        $lista_tareas=array($num_tareas);
        
        $contador=0;
        
        foreach($tareas as $tarea)
        {
            $cod_tarea=$tarea['cod_tarea'];
            $fecha_creada=$tarea['fecha_creada'];
            $hora_creada=$tarea['hora_creada'];
            $fecha_limite=$tarea['fecha_limite'];
            $hora_limite=$tarea['hora_limite'];
            $nombre_tarea=$tarea['nombre'];
            $estado=$tarea['estado'];
            $usuario_origen=$tarea['usuario_origen'];
            $noleidos = $tarea['noleidos'];


            //$usuario_destino=$tarea['usuario_destino'];
            //$grupo_destino=$tarea['grupo_destino'];

            
            $consulta_estado=$this->db->query('SELECT * FROM estados WHERE cod_estado='.$estado);
            $fila_estado=$consulta_estado->row();
            
            $nombre_estado=$fila_estado->descripcion;
            $color_estado=$fila_estado->color;

            //**********************************************************
            $consulta_usuarios=$this->db->query('SELECT usuario_destino from reltareausuariodest where cod_tarea ='.$cod_tarea);
            $array_usuarios = $consulta_usuarios->result_array();

            $array_nombre_para = array();
            $array_color_para = array();

            foreach ($array_usuarios as $usuario_destino) 
            {
                if($usuario_destino['usuario_destino']!=0)
                {
                    $consulta_para=$this->db->query('SELECT * FROM usuarios WHERE cod_usuario='.$usuario_destino['usuario_destino']);
                    $fila_para=$consulta_para->row();
                    
                    //$nombre_para=$fila_para->nombre;
                    $array_nombre_para[] = $fila_para->nombre;
                    //$color_para=$fila_para->color_usuario;
                    $array_color_para[] = $fila_para->color_usuario;
                }
            }

            $consulta_clientes=$this->db->query('SELECT id_cliente from reltareacliente where cod_tarea ='.$cod_tarea);
            $array_clientes = $consulta_clientes->result_array();
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
            //**************************************************
            /*else
            {
                $consulta_para=$this->db->query('SELECT * FROM grupos WHERE cod_grupo='.$grupo_destino);
                $fila_para=$consulta_para->row();
                
                $nombre_para=$fila_para->nombre;
                $color_para=$fila_para->color_grupo;
            }*/
            
            $lista_tareas[$contador]=array(
            
                    'cod_tarea' => $cod_tarea,
                    'fecha_creada' => $fecha_creada,
                    'hora_creada' => $hora_creada,
                    'fecha_limite' => $fecha_limite,
                    'hora_limite' => $hora_limite,
                    'nombre' => $nombre_tarea,
                    'nombre_estado' => $nombre_estado,
                    'color_estado' => $color_estado,
                    'nombre_para' => $array_nombre_para,
                    'color_para' => $array_color_para,
                    'clientes' => $array_clientes_nombre,
                    'colorClientes' => $array_clientes_color,
                    'noleidos' => $noleidos
            );
                
            $contador++;
        }

        
        //$tareas=$query->result_array();
        
    
            
        return $lista_tareas;
    }
    
    public function mostrarTareasPorEstado($estado)
    {
        
        $super=$this->session->userdata('super');
        $cod_usuario=$this->session->userdata('cod_usuario');
        
        if($super==1)
        {
            $mostrar_todos=$this->session->userdata('mostrar_todos');
            
            if($mostrar_todos!=0)
            {
                $query = $this->db->query('select DISTINCT T.cod_tarea,T.fecha_creada,T.hora_creada,T.fecha_aceptada,T.hora_aceptada,T.fecha_mod,T.hora_mod,T.fecha_completa,T.hora_completa,T.fecha_limite,T.hora_limite,T.nombre,T.estado,T.usuario_origen,T.prioridad FROM tareas T,reltareausuariodest R WHERE T.cod_tarea = R.cod_tarea AND T.estado = '.$estado.' order by T.fecha_mod DESC, T.hora_mod DESC');
            }
            else
            {
                $query = $this->db->query('select T.cod_tarea,T.fecha_creada,T.hora_creada,T.fecha_aceptada,T.hora_aceptada,T.fecha_mod,T.hora_mod,T.fecha_completa,T.hora_completa,T.fecha_limite,T.hora_limite,T.nombre,T.estado,T.usuario_origen,R.usuario_destino,T.prioridad,R.noleidos  FROM tareas T,reltareausuariodest R WHERE T.cod_tarea = R.cod_tarea AND R.usuario_destino = '.$cod_usuario.' AND T.estado = '.$estado.' order by T.fecha_mod DESC, T.hora_mod DESC');
            }
            
            
        }
        else
        {
            $query = $this->db->query('select T.cod_tarea,T.fecha_creada,T.hora_creada,T.fecha_aceptada,T.hora_aceptada,T.fecha_mod,T.hora_mod,T.fecha_completa,T.hora_completa,T.fecha_limite,T.hora_limite,T.nombre,T.estado,T.usuario_origen,R.usuario_destino,T.prioridad,R.noleidos FROM tareas T,reltareausuariodest R WHERE T.cod_tarea = R.cod_tarea AND R.usuario_destino = '.$cod_usuario.' AND T.estado = '.$estado.' order by T.fecha_mod DESC, T.hora_mod DESC');
        }
      
      
        
        $tareas=$query->result_array();
        $num_tareas=$query->num_rows();
      
        $lista_tareas=array($num_tareas);
        
        $contador=0;
        
        foreach($tareas as $tarea)
        {
            $cod_tarea=$tarea['cod_tarea'];
            $fecha_creada=$tarea['fecha_creada'];
            $hora_creada=$tarea['hora_creada'];
            $fecha_limite=$tarea['fecha_limite'];
            $hora_limite=$tarea['hora_limite'];
            $nombre_tarea=$tarea['nombre'];
            $estado=$tarea['estado'];
            $usuario_origen=$tarea['usuario_origen'];
            $prioridad=$tarea['prioridad'];
            if (isset($tarea['noleidos'])) $noleidos = $tarea['noleidos'];
            else
            {
                $query = $this->db->query('select ifnull(noleidos,0) as noleidos from reltareausuariodest where cod_tarea='.$cod_tarea.' and usuario_destino='.$cod_usuario);
                $n = $query->row();
                if (!$n) $noleidos=0;
                else $noleidos=$n->noleidos;
            }


            //$usuario_destino=$tarea['usuario_destino'];
            //$grupo_destino=$tarea['grupo_destino'];

            
            $consulta_estado=$this->db->query('SELECT * FROM estados WHERE cod_estado='.$estado);
            $fila_estado=$consulta_estado->row();
            
            $nombre_estado=$fila_estado->descripcion;
            $color_estado=$fila_estado->color;
            
            //************************************************************************
            $consulta_usuarios=$this->db->query('SELECT usuario_destino from reltareausuariodest where cod_tarea ='.$cod_tarea);
            $array_usuarios = $consulta_usuarios->result_array();
            //************************************************************************
            //************************************************************************
            $array_nombre_para = array();
            $array_color_para = array();
            foreach ($array_usuarios as $usuario_destino) 
            {      
                if($usuario_destino['usuario_destino']!=0)
                {
                    $consulta_para=$this->db->query('SELECT * FROM usuarios WHERE cod_usuario='.$usuario_destino['usuario_destino']);
                    $fila_para=$consulta_para->row();
                    
                    //$nombre_para=$fila_para->nombre;
                    $array_nombre_para[] = $fila_para->nombre;
                    //$color_para=$fila_para->color_usuario;
                    $array_color_para[] = $fila_para->color_usuario;
                }
            }
            
            $consulta_clientes=$this->db->query('SELECT id_cliente from reltareacliente where cod_tarea ='.$cod_tarea);
            $array_clientes = $consulta_clientes->result_array();
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
            /*else
            {
                 $consulta_para=$this->db->query('SELECT * FROM grupos WHERE cod_grupo='.$grupo_destino);
                $fila_para=$consulta_para->row();
                
                $nombre_para=$fila_para->nombre;
                $color_para=$fila_para->color_grupo;
            }*/
            
            $lista_tareas[$contador]=array(
            
                    'cod_tarea' => $cod_tarea,
                    'fecha_creada' => $fecha_creada,
                    'hora_creada' => $hora_creada,
                    'fecha_limite' => $fecha_limite,
                    'hora_limite' => $hora_limite,
                    'nombre' => $nombre_tarea,
                    'nombre_estado' => $nombre_estado,
                    'color_estado' => $color_estado,
                    'nombre_para' => $array_nombre_para,
                    'color_para' => $array_color_para,
                    'clientes' => $array_clientes_nombre,
                    'colorClientes' => $array_clientes_color,
                    'prioridad' => $prioridad,
                    'noleidos' => $noleidos
                    //'nombre_para' => $nombre_para,
                    //'color_para' => $color_para
                    
            
            );
                
            $contador++;
        }

        
        //$tareas=$query->result_array();
        
      
            
        return $lista_tareas;
    }
    
    public function nuevaTarea($param)
    {

        $cod_usuario=$this->session->userdata('cod_usuario');
        
        $ahora = getdate();
        
        $fecha_creada=$ahora['year'].'-'.$ahora['mon'].'-'.$ahora['mday'];
        $hora_creada=$ahora['hours'].':'.$ahora['minutes'].':'.$ahora['seconds'];
        
      
        $fecha_limite=$param['fecha_tarea'];
        $hora_limite=$param['hora_tarea'];
        
        $campos=array(
            'fecha_creada' => $fecha_creada,
            'hora_creada' => $hora_creada,
            'fecha_mod' => $fecha_creada,
            'hora_mod' => $hora_creada,
            'fecha_limite' => $fecha_limite,
            'hora_limite' => $hora_limite,
            'nombre' => $param['nombre_tarea'],
            'estado' => 1,
            'usuario_origen' => $cod_usuario,
            'prioridad' => $param['prioridad_tarea'],
            'facturable' => $param['facturable_tarea']//,'minutos' => $param['minutos']
        );
        
        $this->db->insert('tareas',$campos);
        $cod_tarea=$this->db->insert_id();
        
        //**********************************************
        if(isset($param["usuario_tarea"]))
        {
            foreach ($param["usuario_tarea"] as $usuario)
            {
                $data = array(
                    'cod_tarea' => $cod_tarea,
                    'usuario_destino' => $usuario
                );
                $this->db->insert('reltareausuariodest', $data);
            }
        }
        //**********************************************
        if(isset($param["clientesTarea"]))  
        { 
            foreach ($param["clientesTarea"] as $cliente)
            {
                $data = array(
                    'cod_tarea' => $cod_tarea,
                    'id_cliente' => $cliente
                );
                $this->db->insert('reltareacliente', $data); //tabla y datos
            }
        } 
        //***********************************************
        if($param['mensaje_tarea']!='<p>&nbsp;</p>')
        {
            $campos=array(
                'cod_tarea' => $cod_tarea,
                'cod_linea' => 1,
                'fecha' => $fecha_creada,
                'hora' => $hora_creada,
                'mensaje' => $param['mensaje_tarea'],
                'cod_usuario' => $cod_usuario,
                'minutos' => $param['minutos']
            );
            $this->db->insert('lintareas',$campos);
        }

        if(isset($param["usuario_tarea"]))
        { 
            $nombre_origen=$this->obtenerNombreUsuario($cod_usuario);
            $email_origen=$this->obtenerMailUsuario($cod_usuario);
            //$nombre_destino=$this->obtenerNombreUsuario($usuario_destino);
            //$email_destino=$this->obtenerMailUsuario($usuario_destino);
            
            $date = DateTime::createFromFormat( 'Y-m-d', $fecha_creada);
            $fecha_creada_formateada = $date->format('d-m-Y');
            
            //$date = DateTime::createFromFormat( 'H:i:s', $hora_creada);
            $date = new DateTime($hora_creada);
            $hora_creada_formateada = $date->format('H:i');
            
            $date = DateTime::createFromFormat( 'Y-m-d', $fecha_limite);
            if(!isset($date))
            {
                $fecha_limite_formateada = $date->format('d-m-Y');
            }
            
            //$date = DateTime::createFromFormat( 'H:i:s', $hora_limite);
            $date = new DateTime($hora_limite);
            $hora_limite_formateada = $date->format('H:i');

            $usuarios_anteriores = $param["usuario_tarea"];
            
            $cabecera_mail='NUEVA TAREA: '.$param['nombre_tarea'];            
            $cuerpo_mail='<html>';
            $cuerpo_mail=$cuerpo_mail.'<head>';
            $cuerpo_mail=$cuerpo_mail.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
            $cuerpo_mail=$cuerpo_mail.'<title>NUEVA TAREA</title>';
            $cuerpo_mail=$cuerpo_mail.'</head>';
            $cuerpo_mail=$cuerpo_mail.'<body>';
            $cuerpo_mail=$cuerpo_mail.'Tienes una nueva tarea pendiente de '.$nombre_origen.'('.$email_origen.'): <b>'.$param['nombre_tarea'].'</b><br><br><hr>';
            $cuerpo_mail=$cuerpo_mail.'<b>Fecha creada:</b> '.$fecha_creada_formateada.'  '.$hora_creada_formateada.' horas<br><br>';
            $cuerpo_mail=$cuerpo_mail.'<b>Fecha limite:</b> '.$fecha_limite_formateada.'  '.$hora_limite_formateada.' horas<br><br>';
            
            if($param['mensaje_tarea']!='<p>&nbsp;</p>')
            {
                $cuerpo_mail=$cuerpo_mail.'<b>Mensaje:</b><br> '.$param['mensaje_tarea'];
            }
            $cuerpo_mail=$cuerpo_mail.'<hr><br>Puedes ver el contenido de la tarea en el siguiente enlace: <a href="'.base_url().'tarea/'.$cod_tarea.'">'.base_url().'tarea/'.$cod_tarea.'</a>';
            
            $cuerpo_mail=$cuerpo_mail.'</body>';
            $cuerpo_mail=$cuerpo_mail.'</html>';
            foreach ($usuarios_anteriores as $usuario_destino)
            {    
                $email_destino=$this->obtenerMailUsuario($usuario_destino);
                $cuerpo_mail=$this->quitarCharRaros($cuerpo_mail);
                $cabecera_mail=$this->quitarCharRaros($cabecera_mail);
                $this->enviarmail($email_destino, $cabecera_mail, $cuerpo_mail);
                $this->db->query('UPDATE reltareausuariodest set noleidos=noleidos+1 WHERE cod_tarea ='.$cod_tarea.' and usuario_destino='.$usuario_destino);
            }
        } 
        $this->ponerComoLeida($cod_tarea,$cod_usuario);   
    }
    
    public function eliminarTarea($cod_tarea)
    {
        $cod_usuario=$this->session->userdata('cod_usuario');
        //$usuarios_consulta = $this->usuarios_model->getUsuariosAsignados($cod_tarea);
        $consulta_usuarios=$this->db->query('SELECT usuario_destino from reltareausuariodest where cod_tarea='.$cod_tarea);

        $usuarios_consulta = $consulta_usuarios->result_array();
        $usuarios_anteriores = array();
        for($i=0; $i <count($usuarios_consulta) ; $i++) 
        { 
            $usuarios_anteriores[] = $usuarios_consulta[$i]['usuario_destino'];
        }
        //$usuarios_anteriores[] = $cod_usuario;

        $datosTarea = $this->mostrarTarea($cod_tarea);
        $nombre_origen = $this->obtenerNombreUsuario($cod_usuario);
        $email_origen=$this->obtenerMailUsuario($cod_usuario);
        $cabecera_mail='TAREA '.$datosTarea->nombre.' ELIMINADA';  
        $cuerpo_mail='<html>';
        $cuerpo_mail=$cuerpo_mail.'<head>';
        $cuerpo_mail=$cuerpo_mail.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        $cuerpo_mail=$cuerpo_mail.'<title>TAREA '.$datosTarea->nombre.' ELIMINADA</title>';
        $cuerpo_mail=$cuerpo_mail.'</head>';
        $cuerpo_mail=$cuerpo_mail.'<body>';
        $cuerpo_mail=$cuerpo_mail.'La Tarea <b>'.$datosTarea->nombre.'</b> ha sido borrada por: '.$nombre_origen.'('.$email_origen.')<br>';
        $cuerpo_mail=$cuerpo_mail.'</body>';
        $cuerpo_mail=$cuerpo_mail.'</html>';
        foreach ($usuarios_anteriores as $usuario_destino)
        {    
            $email_destino=$this->obtenerMailUsuario($usuario_destino);
            $cuerpo_mail=$this->quitarCharRaros($cuerpo_mail);
            $cabecera_mail=$this->quitarCharRaros($cabecera_mail);
            $this->enviarmail($email_destino, $cabecera_mail, $cuerpo_mail);
        }
        $campos=array(
            'cod_tarea' => $cod_tarea
        );
        
        $this->db->delete('tareas',$campos);
        $this->db->delete('lintareas',$campos);
        $this->db->delete('reltareausuariodest',$campos);
    }

    public function eliminarCarpetaTarea($carpeta)
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
    
    public function getNombre($cod_tarea)
    {
        $query = $this->db->query('select nombre FROM tareas WHERE cod_tarea='.$cod_tarea);

        
        $tarea=$query->row();
        
        $nombre=$tarea->nombre;
        
            
        return $nombre;
    }

    public function obtenerNombreCliente($id_cliente)
    {
        $query = $this->db->query('select nombre FROM clientes WHERE id='.$id_cliente);
        $cliente=$query->row();
        $nombre=$cliente->nombre;       
            
        return $nombre;
    }
    
    public function obtenerNombreUsuario($cod_usuario)
    {
        $query = $this->db->query('select nombre FROM usuarios WHERE cod_usuario='.$cod_usuario);
        $usuario=$query->row();
        $nombre=$usuario->nombre;       
            
        return $nombre;
    }
    
    public function obtenerMailUsuario($cod_usuario)
    {
        $query = $this->db->query('select email FROM usuarios WHERE cod_usuario='.$cod_usuario);
        $usuario=$query->row();
        $email=$usuario->email;
            
        return $email;
    }
    
    public function mostrarConversacionTarea($cod_tarea)
    {
        $query = $this->db->query('select lt.*, u.nombre, u.color_usuario from lintareas lt, usuarios u where lt.cod_usuario=u.cod_usuario and lt.cod_tarea='.$cod_tarea);

        
        $conversacion=$query->result_array();
            
        return $conversacion;
    }

    public function obtenerNumeroMensajes($cod_tarea)
    {
        $query = $this->db->query('SELECT cod_linea FROM lintareas WHERE cod_tarea ='.$cod_tarea);
        $numeroMensajes=$query->num_rows();
        return $numeroMensajes;
    }

    public function obtenerUltimaTareaCreada()
    {
        $query = $this->db->query('SELECT MAX(cod_tarea) AS maximo FROM tareas');
        $codTarea = $query->row();
        $ultimoCodTarea = $codTarea->maximo;

        return $ultimoCodTarea;
    }

    public function obtenerUltimaMensajeTareaCreada($cod_tarea)
    {
        $query = $this->db->query('SELECT MAX(cod_linea) AS maximo FROM lintareas WHERE cod_tarea ='.$cod_tarea);
        $codTarea = $query->row();
        $ultimoCodTarea = $codTarea->maximo;

        return $ultimoCodTarea;
    }

    public function obtenerUltimoFicheroMensajeTarea($cod_tarea)
    {
        $query = $this->db->query('SELECT MAX(cod_archivo) AS maximo FROM archivosadjuntos WHERE cod_tarea ='.$cod_tarea);
        $codTarea = $query->row();
        $ultimoCodTarea = $codTarea->maximo;

        return $ultimoCodTarea;
    }
    
    public function nuevoMensaje($param)
    {
        $usuario_origen=$this->session->userdata('cod_usuario');
        $nombre_usuario_origen=$this->obtenerNombreUsuario($usuario_origen);
        $email_usuario_origen=$this->obtenerMailUsuario($usuario_origen);
        $cod_tarea=$param['cod_tarea'];
        $cod_usuario=$param['cod_usuario'];
        $mensaje=$param['mensaje_tarea'];
        $minutos=($param['tiempo_horas']*60)+$param['tiempo_minutos'];
        
        $query_tarea=$this->db->query('SELECT * FROM tareas WHERE cod_tarea='.$cod_tarea);
        
        $fila_tarea=$query_tarea->row();
        
        $nombre_tarea=$fila_tarea->nombre;
        
        $ahora = getdate();
        
        $fecha_creada=$ahora['year'].'-'.$ahora['mon'].'-'.$ahora['mday'];
        $hora_creada=$ahora['hours'].':'.$ahora['minutes'].':'.$ahora['seconds'];

        $fecha_creada_formateada=$ahora['mday'].'-'.$ahora['mon'].'-'.$ahora['year'];
        $hora_creada_formateada=$ahora['hours'].':'.$ahora['minutes'];
        
        $query = $this->db->query('SELECT MAX(cod_linea) as maximo FROM lintareas WHERE cod_tarea='.$cod_tarea);
        
        
        $num_filas=$query->num_rows();
        
        if($num_filas>0)
        {
            $fila=$query->row();
            $max_cod_linea=$fila->maximo;
            $nuevo_cod_linea=$max_cod_linea+1;
        }
        else
        {
            $nuevo_cod_linea=1;
        }
        
        //$conversacion=$query->result_array();

        $campos=array(
            'cod_tarea' => $cod_tarea,
            'cod_linea' => $nuevo_cod_linea,
            'fecha' => $fecha_creada,
            'hora' => $hora_creada,
            'mensaje' => $mensaje,
            'cod_usuario' => $cod_usuario,
            'minutos' => $minutos         
        );
        $this->db->insert('lintareas',$campos);
        
        $usuarios_consulta = $this->usuarios_model->getUsuariosAsignados($cod_tarea);
        $usuarios_anteriores = array();
        for($i=0; $i <count($usuarios_consulta) ; $i++) 
        { 
            $usuarios_anteriores[] = $usuarios_consulta[$i]['usuario_destino'];
        }
        //$usuarios_anteriores[] = $usuario_origen;
        $cuerpo_mail="";
        
        $cabecera_mail='NUEVO MENSAJE: '.$nombre_tarea;            
        $cuerpo_mail='<html>';
        $cuerpo_mail=$cuerpo_mail.'<head>';
        $cuerpo_mail=$cuerpo_mail.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        $cuerpo_mail=$cuerpo_mail.'<title>NUEVO MENSAJE</title>';
        $cuerpo_mail=$cuerpo_mail.'</head>';
        $cuerpo_mail=$cuerpo_mail.'<body>';
        $cuerpo_mail=$cuerpo_mail.$nombre_usuario_origen.'('.$email_usuario_origen.') ha dejado un nuevo mensaje en la tarea: <b>'.$nombre_tarea.'</b><br><br>';
        $cuerpo_mail=$cuerpo_mail.'<b>Fecha:</b> '.$fecha_creada_formateada.'<br><br>';
        $cuerpo_mail=$cuerpo_mail.'<b>Hora:</b> '.$hora_creada_formateada.' horas<br><br>';
        $cuerpo_mail=$cuerpo_mail.'<b>Mensaje:</b><br> '.$mensaje.'<br><br>';
        $cuerpo_mail=$cuerpo_mail.'<br>Puedes ver el contenido de la tarea en el siguiente enlace: <a href="'.base_url().'tarea/'.$cod_tarea.'">'.base_url().'tarea/'.$cod_tarea.'</a>';
        $cuerpo_mail=$cuerpo_mail.'</body>';
        $cuerpo_mail=$cuerpo_mail.'</html>';
        foreach ($usuarios_anteriores as $usuario_destino) 
        {
            $email_destino=$this->obtenerMailUsuario($usuario_destino);
            $cuerpo_mail=$this->quitarCharRaros($cuerpo_mail);
            $cabecera_mail=$this->quitarCharRaros($cabecera_mail);
            $this->enviarmail($email_destino, $cabecera_mail, $cuerpo_mail);
            if ($cod_usuario!=$usuario_destino) $this->db->query('UPDATE reltareausuariodest set noleidos=noleidos+1 WHERE cod_tarea ='.$cod_tarea.' and usuario_destino='.$usuario_destino);

        }
        
    }
    
    public function actualizarTarea($param)
    {
        $usuario_origen=$this->session->userdata('cod_usuario');
        $nombre_usuario_origen=$this->obtenerNombreUsuario($usuario_origen);
        $cod_tarea=$param['cod_tarea'];
        $nombre_tarea = $param['nombre_tarea'];
        $query_tarea=$this->db->query('SELECT * FROM tareas WHERE cod_tarea='.$cod_tarea);
        $fila_tarea=$query_tarea->row();
        
        $minutos = $param['minutos'];
        
        $nombre_tarea=$fila_tarea->nombre;
        $prioridad=$param['prioridad'];
        //$usuario_destino=$fila_tarea->usuario_destino;
        $origen_usuario=$fila_tarea->usuario_origen;
        //$grupo_destino=$fila_tarea->grupo_destino;
        
        //***********************************************

        $prioridad_anterior=$fila_tarea->prioridad;
        $nueva_prioridad=$param["prioridad"];

        $estado_anterior=$fila_tarea->estado;
        $nuevo_estado=$param['estado_tarea'];

        $nombre_anterior=$fila_tarea->nombre;
        $nombre_nuevo=$param['nombre_tarea'];

        $fecha_anterior=$fila_tarea->fecha_limite;
        $fecha_nueva=$param['fecha_tarea'];
        if($fecha_nueva == "")
        {
            $fecha_nueva="0000-00-00";
        }

        $hora_anterior=$fila_tarea->hora_limite;
        $hora_nueva=$param['hora_tarea'];
        
        $usuarios_nuevos = $param["usuario_tarea"];
        $usuariosEnviarCorreo = $param["usuario_tarea"];
        //$usuariosEnviarCorreo[] = $origen_usuario;
        $usuarios_consulta = $this->usuarios_model->getUsuariosAsignados($cod_tarea);
        $usuarios_anteriores = array();
        for ($i=0; $i <count($usuarios_consulta) ; $i++) 
        { 
            $usuarios_anteriores[] = $usuarios_consulta[$i]['usuario_destino'];
        }
        //$usuarios_anteriores[] = $origen_usuario;

        $clientes_nuevos = $param["clientesTarea"];
        $clientes_consulta = $this->clientes_model->mostrarTablaRelacionTareasClientes($cod_tarea);
        $clientes_anteriores = array();
        for ($i=0; $i <count($clientes_consulta) ; $i++) 
        { 
            $clientes_anteriores[] = $clientes_consulta[$i]['id_cliente'];
        }

        //***********************************************
        $usuariosCorreo = $this->usuarios_model->getUsuariosAsignados($cod_tarea);
        
        $hoy = getdate();
        
        $fecha_mod=$hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];
        $hora_mod=$hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds'];
        
        $fecha_mod_formateada=$hoy['mday'].'-'.$hoy['mon'].'-'.$hoy['year'];
        $hora_mod_formateada=$hoy['hours'].':'.$hoy['minutes'];
        
        
        $campos=array(
            'nombre' => $param['nombre_tarea'],
            'estado' => $param['estado_tarea'],
            'fecha_limite' => $param['fecha_tarea'],
            'hora_limite' => $param['hora_tarea'],
            'fecha_mod' => $fecha_mod,
            'hora_mod' => $hora_mod,
            'prioridad' => $prioridad,
            'minutos' => $minutos
        );
        
        $this->db->where('cod_tarea',$param['cod_tarea']);
       
        $this->db->update('tareas',$campos);

        //*************************************************

        if(isset($param["clientesTarea"]))  
        {
            $this->db->delete('reltareacliente', array('cod_tarea' => $cod_tarea));// DELETE FROM reltareacliente  // WHERE cod_tarea = $cod_tarea
            foreach ($param["clientesTarea"] as $cliente)
            {
                $data = array(
                    'cod_tarea' => $cod_tarea,
                    'id_cliente' => $cliente
                );
                $this->db->insert('reltareacliente', $data); //tabla y datos
            }
        } 

        //*************************************************
        
        if(isset($param["usuario_tarea"]))
        {
            $this->db->delete('reltareausuariodest', array('cod_tarea' => $cod_tarea));
            foreach ($param["usuario_tarea"] as $usuario)
            {
                $data = array(
                    'cod_tarea' => $cod_tarea,
                    'usuario_destino' => $usuario
                );
                $this->db->insert('reltareausuariodest', $data);
            }
        }
        //*************************************************
        $cuerpo_mail = "";
       // if(!($nombre_anterior==$nombre_nuevo && $estado_anterior==$nuevo_estado && $fecha_anterior==$fecha_nueva && $hora_anterior==$hora_nueva && $usuarios_anteriores==$usuarios_nuevos))

       if(!($nombre_anterior==$nombre_nuevo && $estado_anterior==$nuevo_estado && $usuarios_anteriores==$usuarios_nuevos))

        {
            //$nombre_origen=$this->obtenerNombreUsuario($usuario_origen);
            //$email_origen=$this->obtenerMailUsuario($usuario_origen);
            

            $cabecera_mail = 'TAREA '.$nombre_tarea.' ACTUALIZADA';
            $cuerpo_mail = $cuerpo_mail.'<html>';
            $cuerpo_mail=$cuerpo_mail.'<head>';
            $cuerpo_mail=$cuerpo_mail.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
            $cuerpo_mail=$cuerpo_mail.'<title>TAREA '.$nombre_tarea.' ACTUALIZADA</title>';
            $cuerpo_mail=$cuerpo_mail.'</head>';
            $cuerpo_mail=$cuerpo_mail.'<body>';

            $cuerpo_mail=$cuerpo_mail.'Tarea <b>'.$nombre_tarea.' </b>modificada por '.$nombre_usuario_origen.' a las '.$hora_mod_formateada.' del '.$fecha_mod_formateada.'<br><hr><br>';

            if($nombre_anterior!=$nombre_nuevo)
            {
                $cuerpo_mail=$cuerpo_mail.'El <b>asunto</b> de la tarea ha sido modificado, ha pasado de '.$nombre_anterior.' a '.$nombre_nuevo.'.<br>';
            }

            if ($prioridad_anterior!=$nueva_prioridad)
            {
                $cuerpo_mail=$cuerpo_mail.'La <b>prioridad</b> de la tarea ha sido modificada, ha pasado de '.$prioridad_anterior.' a '.$nueva_prioridad.'.<br>';
            }

            if($estado_anterior!=$nuevo_estado)
            {
                switch ($nuevo_estado) 
                {
                    case 1:
                        $cuerpo_mail=$cuerpo_mail.'El <b>estado</b> de la tarea ha pasado a <b>PENDIENTE</b><br>';
                        break;
                    case 2:
                        $cuerpo_mail=$cuerpo_mail.'El <b>estado</b> de la tarea ha pasado a <b>EN CURSO</b><br>';
                        break;
                    case 3:
                        $cuerpo_mail=$cuerpo_mail.'El <b>estado</b> de la tarea ha pasado a <b>COMPLETADA</b><br>';
                        break;
                }        

                $cuerpo_mail=$cuerpo_mail.'<hr><br>Puedes ver el contenido de la tarea en el siguiente enlace: <a href="'.base_url().'tarea/'.$cod_tarea.'">'.base_url().'tarea/'.$cod_tarea.'</a>';
            }

            

            if($usuarios_anteriores!=$usuarios_nuevos)
            {
                $cuerpo_mail=$cuerpo_mail.'Los usuarios asignados a esta tarea han sido actualizados.<br>Los <b>nuevos usuarios</b> son:';
                $cuerpo_mail=$cuerpo_mail.'<ul>';
                //$quitarCreadorTarea = array_pop($usuarios_nuevos);
                for ($i=0; $i < count($usuarios_nuevos); $i++) 
                { 
                    $nombre_usuario = $nombre_origen=$this->obtenerNombreUsuario($usuarios_nuevos[$i]);
                    $cuerpo_mail=$cuerpo_mail.'<li>'.$nombre_usuario.'</li>';
                } 
                $cuerpo_mail=$cuerpo_mail.'</ul><br>';
            }

            if($clientes_anteriores!=$clientes_nuevos)
            {
                $cuerpo_mail=$cuerpo_mail.'Los clientes asignados a esta tarea han sido actualizados.<br>Los <b>nuevos clientes</b> son:';
                $cuerpo_mail=$cuerpo_mail.'<ul>';
                for ($i=0; $i < count($clientes_nuevos); $i++) 
                { 
                    $nombre_cliente = $nombre_origen=$this->obtenerNombreCliente($clientes_nuevos[$i]);
                    $cuerpo_mail=$cuerpo_mail.'<li>'.$nombre_cliente.'</li>';
                } 
                $cuerpo_mail=$cuerpo_mail.'</ul><br>';
            }
            $cuerpo_mail=$cuerpo_mail.'</body></html>';
            foreach ($usuariosEnviarCorreo as $usuario_destino) 
            {                
                $nombre_destino=$this->obtenerNombreUsuario($usuario_destino);
                $email_destino=$this->obtenerMailUsuario($usuario_destino);
                $cuerpo_mail=$this->quitarCharRaros($cuerpo_mail);
                $cabecera_mail=$this->quitarCharRaros($cabecera_mail);
                $this->enviarmail($email_destino, $cabecera_mail, $cuerpo_mail);
            }
        }

        return $param['cod_tarea'];
        //return $cuerpo_mail;
    }

    public function actualizarEstadoTarea($param)
    {
        $usuario_origen=$this->session->userdata('cod_usuario');
        $nombre_usuario_origen=$this->obtenerNombreUsuario($usuario_origen);
        $cod_tarea=$param['cod_tarea'];
        $nombre_tarea = $param['nombre'];

        $query_tarea=$this->db->query('SELECT * FROM tareas WHERE cod_tarea='.$cod_tarea);
        $fila_tarea=$query_tarea->row();

        $origen_usuario=$fila_tarea->usuario_origen;

        $estado_anterior=$fila_tarea->estado;
        $nuevo_estado=$param['estado_tarea'];

        $usuarios_consulta = $this->usuarios_model->getUsuariosAsignados($cod_tarea);
        for($i=0; $i <count($usuarios_consulta) ; $i++) 
        { 
            $usuariosEnviarCorreo[] = $usuarios_consulta[$i]['usuario_destino'];
        }
        //$usuariosEnviarCorreo[] = $origen_usuario;

        $campos=array(
            'estado' => $param['estado_tarea']
        );
        
        $this->db->where('cod_tarea',$param['cod_tarea']);
       
        $this->db->update('tareas',$campos);

        $hoy = getdate();
        
        $fecha_mod_formateada=$hoy['mday'].'-'.$hoy['mon'].'-'.$hoy['year'];
        $hora_mod_formateada=$hoy['hours'].':'.$hoy['minutes'];

        $cuerpo_mail="";
        if($estado_anterior!=$nuevo_estado) 
        {
            //$nombre_destino=$this->obtenerNombreUsuario($usuario_destino);
            
            $cabecera_mail = 'TAREA '.$nombre_tarea.' ACTUALIZADA';
            $cuerpo_mail = $cuerpo_mail.'<html>';
            $cuerpo_mail=$cuerpo_mail.'<head>';
            $cuerpo_mail=$cuerpo_mail.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
            $cuerpo_mail=$cuerpo_mail.'<title>TAREA '.$nombre_tarea.' ACTUALIZADA</title>';
            $cuerpo_mail=$cuerpo_mail.'</head>';
            $cuerpo_mail=$cuerpo_mail.'<body>';

            switch($nuevo_estado) 
            {
                case 1:
                    $cuerpo_mail=$cuerpo_mail.$nombre_usuario_origen.' ha actualizado el <b>estado</b> de la tarea a las '.$hora_mod_formateada.' del '.$fecha_mod_formateada.', ha pasado a <b>PENDIENTE</b><br>';
                    break;
                case 2:
                    $cuerpo_mail=$cuerpo_mail.$nombre_usuario_origen.' ha actualizado el <b>estado</b> de la tarea a las '.$hora_mod_formateada.' del '.$fecha_mod_formateada.', ha pasado a <b>EN CURSO</b><br>';
                    break;
                case 3:
                    $cuerpo_mail=$cuerpo_mail.$nombre_usuario_origen.' ha actualizado el <b>estado</b> de la tarea a las '.$hora_mod_formateada.' del '.$fecha_mod_formateada.', ha pasado a <b>COMPLETADA</b><br>';
                    break;
            }
            $cuerpo_mail=$cuerpo_mail.'<hr><br>Puedes ver el contenido de la tarea en el siguiente enlace: <a href="'.base_url().'tarea/'.$cod_tarea.'">'.base_url().'tarea/'.$cod_tarea.'</a>';
            $cuerpo_mail=$cuerpo_mail.'</body></html>';
            foreach ($usuariosEnviarCorreo as $usuario_destino) 
            {
                $email_destino=$this->obtenerMailUsuario($usuario_destino);
                $cuerpo_mail=$this->quitarCharRaros($cuerpo_mail);
                $cabecera_mail=$this->quitarCharRaros($cabecera_mail);
                $this->enviarmail($email_destino, $cabecera_mail, $cuerpo_mail);   
            }
        }
        return $param['cod_tarea'];
        //return $cuerpo_mail;
    }

    public function actualizarMensajeTarea($param)
    {
        $mensaje = $param["mensaje"];
        $cod_tarea = $param["cod_tarea"];
        $cod_linea = $param["cod_linea"];
        $cod_usuario=$param['cod_usuario'];
        $nombre_tarea = $param['nombre'];
        
        
        $nombre_usuario_origen = $this->obtenerNombreUsuario($cod_usuario);
        $usuario_origen=$this->session->userdata('cod_usuario');

        if(isset($mensaje) && isset($cod_linea) && isset($cod_linea))
        {
            $query_consulta = $this->db->query('SELECT * FROM lintareas WHERE cod_tarea = '.$cod_tarea.' AND cod_linea = '.$cod_linea.'');
            $query = $this->db->query('UPDATE lintareas SET mensaje = "'.$mensaje.'" WHERE cod_tarea = '.$cod_tarea.' AND cod_linea = '.$cod_linea.'');
            $query = $this->db->query('select * from tareas where cod_tarea='.$cod_tarea);
            $this->db->query($query);
            //************************************************************
            $query_tarea=$this->db->query('SELECT * FROM tareas WHERE cod_tarea='.$cod_tarea);
            $fila_tarea=$query_tarea->row();

            //$usuario_destino=$fila_tarea->usuario_destino;
            //$usuario_origen=$fila_tarea->usuario_origen;
            //$grupo_destino=$fila_tarea->grupo_destino;
            $nombre_tarea=$fila_tarea->nombre;

            $fila_mensaje=$query_consulta->row();
            $mensaje_anterior = $fila_mensaje->mensaje;

            $hoy = getdate();
            
            $fecha_mod_formateada=$hoy['mday'].'-'.$hoy['mon'].'-'.$hoy['year'];
            $hora_mod_formateada=$hoy['hours'].':'.$hoy['minutes'];

            $usuarios_consulta = $this->usuarios_model->getUsuariosAsignados($cod_tarea);
            $usuarios_anteriores = array();
            for ($i=0; $i <count($usuarios_consulta) ; $i++) 
            { 
                $usuarios_anteriores[] = $usuarios_consulta[$i]['usuario_destino'];
            }
            //$usuarios_anteriores[] = $usuario_origen;
            $cuerpo_mail="";
            if($mensaje != $mensaje_anterior)
            {
                //$email_destino=$this->obtenerMailUsuario($usuario_destino);
                $cabecera_mail = 'MENSAJE TAREA '.$nombre_tarea.' EDITADO';
                $cuerpo_mail=$cuerpo_mail.'<html>';
                $cuerpo_mail=$cuerpo_mail.'<head>';
                $cuerpo_mail=$cuerpo_mail.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
                $cuerpo_mail=$cuerpo_mail.'<title>MENSAJE TAREA '.$nombre_tarea.' EDITADO</title>';
                $cuerpo_mail=$cuerpo_mail.'</head>';
                $cuerpo_mail=$cuerpo_mail.'<body>';

                $cuerpo_mail=$cuerpo_mail.'Mensaje de la tarea <b>'.$nombre_tarea.'</b> modificada por '.$nombre_usuario_origen.' a las '.$hora_mod_formateada.' del '.$fecha_mod_formateada.'<br><hr><br>';
                $cuerpo_mail=$cuerpo_mail.'El mensaje ha pasado de '.$mensaje_anterior.' ===> <b>'.$mensaje.'</b>';
                $cuerpo_mail=$cuerpo_mail.'</body></html>';
                foreach ($usuarios_anteriores as $usuario_destino) 
                {
                    $email_destino=$this->obtenerMailUsuario($usuario_destino);
                    $cuerpo_mail=$this->quitarCharRaros($cuerpo_mail);
                    $cabecera_mail=$this->quitarCharRaros($cabecera_mail);
                    $this->enviarmail($email_destino, $cabecera_mail, $cuerpo_mail);
                }
            }
            //return $cuerpo_mail;
        }  
    }

    public function actualizarMinutosTarea($param)
    {
        $minutos = $param["minutos"];
        $cod_tarea = $param["cod_tarea"];
        $cod_linea = $param["cod_linea"];
        $cod_usuario=$param['cod_usuario'];
        $nombre_tarea = $param['nombre'];
        
        
        $nombre_usuario_origen = $this->obtenerNombreUsuario($cod_usuario);
        $usuario_origen=$this->session->userdata('cod_usuario');

        if(isset($minutos) && isset($cod_linea) && isset($cod_linea))
        {
            $query_consulta = $this->db->query('SELECT * FROM lintareas WHERE cod_tarea = '.$cod_tarea.' AND cod_linea = '.$cod_linea.'');
            $query = $this->db->query('UPDATE lintareas SET minutos = "'.$minutos.'" WHERE cod_tarea = '.$cod_tarea.' AND cod_linea = '.$cod_linea.'');
            $query = $this->db->query('select * from tareas where cod_tarea='.$cod_tarea);
            $this->db->query($query);
            
            $query_tarea=$this->db->query('SELECT * FROM tareas WHERE cod_tarea='.$cod_tarea);
            $fila_tarea=$query_tarea->row();

            $nombre_tarea=$fila_tarea->nombre;

            $fila_minutos=$query_consulta->row();
            $minutos_anterior = $fila_minutos->minutos;

            $hoy = getdate();
            
            $fecha_mod_formateada=$hoy['mday'].'-'.$hoy['mon'].'-'.$hoy['year'];
            $hora_mod_formateada=$hoy['hours'].':'.$hoy['minutes'];

            $usuarios_consulta = $this->usuarios_model->getUsuariosAsignados($cod_tarea);
            $usuarios_anteriores = array();
            for ($i=0; $i <count($usuarios_consulta) ; $i++) 
            { 
                $usuarios_anteriores[] = $usuarios_consulta[$i]['usuario_destino'];
            }
            $cuerpo_mail="";
            if($minutos != $minutos_anterior)
            {
                $cabecera_mail = 'MINUTOS TAREA '.$nombre_tarea.' EDITADO';
                $cuerpo_mail=$cuerpo_mail.'<html>';
                $cuerpo_mail=$cuerpo_mail.'<head>';
                $cuerpo_mail=$cuerpo_mail.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
                $cuerpo_mail=$cuerpo_mail.'<title>MINUTOS TAREA '.$nombre_tarea.' EDITADO</title>';
                $cuerpo_mail=$cuerpo_mail.'</head>';
                $cuerpo_mail=$cuerpo_mail.'<body>';

                $cuerpo_mail=$cuerpo_mail.'MINUTOS de la tarea <b>'.$nombre_tarea.'</b> modificada por '.$nombre_usuario_origen.' a las '.$hora_mod_formateada.' del '.$fecha_mod_formateada.'<br><hr><br>';
                $cuerpo_mail=$cuerpo_mail.'Los minutos han pasado de '.$minutos_anterior.' ===> <b>'.$minutos.'</b>';
                $cuerpo_mail=$cuerpo_mail.'</body></html>';
                foreach ($usuarios_anteriores as $usuario_destino) 
                {
                    $email_destino=$this->obtenerMailUsuario($usuario_destino);
                    $cuerpo_mail=$this->quitarCharRaros($cuerpo_mail);
                    $cabecera_mail=$this->quitarCharRaros($cabecera_mail);
                    $this->enviarmail($email_destino, $cabecera_mail, $cuerpo_mail);
                }
            }
            //return $cuerpo_mail;
        }  
    }

    public function eliminarMensajeTarea($param)
    {
        $cod_tarea = $param["cod_tarea"];
        $cod_linea = $param["cod_linea"];
        $rutasArchivos = $param["rutasArchivos"];

        $campos = array(
            'cod_tarea' => $cod_tarea,
            'cod_linea' => $cod_linea
        );
        $this->db->delete('lintareas',$campos);
        $this->db->delete('archivosadjuntos',$campos);
        for ($i=0; $i < count($rutasArchivos); $i++)
        {
            //$nombre = explode("/", $rutasArchivos[$i]['ruta']);
            //unlink('uploads/'.$cod_tarea.'/'.end($nombre));
            unlink($rutasArchivos[$i]['ruta']);
        }
    }

    public function anyadirArchivosNuevaTarea($ficheros)
    {
        $ultimoCodTarea = $this->obtenerUltimaTareaCreada();
        $arrayNombres = $ficheros;
        $numeroNombres = count($arrayNombres);
        if(isset($arrayNombres))
        {
            for ($i=0; $i < $numeroNombres; $i++)
            {
                $datos = array(
                    'cod_tarea' => $ultimoCodTarea,
                    'cod_linea' => 1,
                    'cod_archivo' => $i+1,
                    'ruta' => 'uploads/'.$ultimoCodTarea.'/'.$arrayNombres[$i]
                );
                $this->db->insert('archivosadjuntos',$datos);
            }
        }
    }

    public function anyadirArchivosMensajes($ficheros,$cod_tarea)
    {
        $ultimoCodLineaTarea = $this->obtenerUltimaMensajeTareaCreada($cod_tarea);
        //$ultimoCodArchivoMensajeTarea = $this->obtenerUltimoFicheroMensajeTarea($cod_tarea);
        $arrayNombres = $ficheros;
        $numeroNombres = count($arrayNombres);
        if(isset($arrayNombres))
        {
            for ($i=0; $i < $numeroNombres; $i++)
            {
                $datos = array(
                    'cod_tarea' => $cod_tarea,
                    'cod_linea' => $ultimoCodLineaTarea,
                    'cod_archivo' => $i+1,
                    'ruta' => 'uploads/'.$cod_tarea.'/'.$arrayNombres[$i]
                );
                $this->db->insert('archivosadjuntos',$datos);
            }
        }
    }

    
    public function quitarCharRaros($cadena)
    {
        return $cadena;
        $cadena=str_replace('á','&aacute;',$cadena);
        $cadena=str_replace('Á','&Aacute;',$cadena);
        $cadena=str_replace('é','&eacute;',$cadena);
        $cadena=str_replace('É','&Eacute;',$cadena);
        $cadena=str_replace('í','&iacute;',$cadena);
        $cadena=str_replace('Í','&Iacute;',$cadena);
        $cadena=str_replace('ó','&oacute;',$cadena);
        $cadena=str_replace('Ó','&Oacute;',$cadena);
        $cadena=str_replace('ú','&uacute;',$cadena);
        $cadena=str_replace('Ú','&Uacute;',$cadena);
        
        $cadena=str_replace('ñ','&ntilde;',$cadena);
        $cadena=str_replace('Ñ','&Ntilde;',$cadena);
        
        return $cadena;
    }
        
    function enviarmail($email_destino,$cabecera_mail,$cuerpo_mail)
    {
        $mail=new PHPMailer();
        $mail->Host="mail.gotosystem.com";
        $mail->SMTPAuth=true;
        $mail->Username="samuelleal@gotosystem.com";
        $mail->Password="Samuel2003";
        $mail->From="gotoagenda@gotosystem.net";
        $mail->FromName="GotoAgenda";
        $mail->Subject=utf8_decode($cabecera_mail);
        $mail->AddAddress(utf8_decode($email_destino));
        $mail->IsHTML(true);
        //$mail->AddEmbeddedImage('files/cabecera1.jpg', 'cabecera1.jpg');
        //$mail->Body = file_get_contents('mailing-metallube.html');
        $mail->Body=utf8_decode($cuerpo_mail);
        if(!$mail->Send())
        {
            //echo "Error enviando: " . $mail->ErrorInfo;
        }
        else
        {
            //echo "Mandado!";

        }
    }    

    public function obtenerPrioridad($cod_tarea)
    {
    	$query = $this->db->query('select prioridad from tareas where cod_tarea='.$cod_tarea);
        $prioridad = $query->row()->prioridad;
        return $prioridad;
    } 

    public function obtenerFacturable($cod_tarea)
    {
        $query = $this->db->query('select facturable from tareas where cod_tarea='.$cod_tarea);
        $facturable = $query->row()->facturable;
        return $facturable;
    }

    public function obtenerMinutos($cod_tarea)
    {
        $query = $this->db->query('select minutos from tareas where cod_tarea='.$cod_tarea);
        $minutos = $query->row()->minutos;
        return $minutos;
    }

    

}

?>