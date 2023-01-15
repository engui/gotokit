<?php 

class configuracion_model extends CI_Model
{
	public function get_config()
    {
        $this->db->select('*')
                 ->from('config');
        $query = $this->db->get();
        return $query;
    }

    public function update_espacioocupado($valor)
    {
        $this->db->update('config',['espacioocupado' => $valor]);
    }

    public function insertar_logacceso($id_usuario)
    {
        $data = [
            "id_usuario" => $id_usuario,
            "fechahora" => date('Y-m-d H:i:s'),
            "ip" => $this->input->ip_address()
        ];
        $this->db->insert('logaccesos', $data);
    }

}	

?>