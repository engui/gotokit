<?php 

class calendario_model extends CI_Model
{
	public function obtenerDatosCalendario()
    {
    	$query = $this->db->query('select R.cod_tarea, T.nombre,R.usuario_destino, U.color_usuario, T.fecha_limite, T.hora_limite FROM reltareausuariodest R,usuarios U, tareas T WHERE R.`usuario_destino` = U.cod_usuario AND R.cod_tarea = T.cod_tarea AND T.fecha_limite != "0000-00-00"');
        $datosCalendario = $query->result_array();
        
        return $datosCalendario;
    }

    public function obtenerDatosCalendarioPorUsuario($cod_usuario)
    {
    	$query = $this->db->query('select T.cod_tarea,T.nombre,T.fecha_limite,T.hora_limite,U.color_usuario FROM tareas T LEFT JOIN usuarios U ON T.usuario_origen = U.cod_usuario WHERE U.cod_usuario = '.$cod_usuario.' AND T.fecha_limite != "0000-00-00")');
        $datosCalendario = $query->result_array();
        
        return $datosCalendario;
    }
}	

?>