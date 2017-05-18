<?php

class MY_Model extends CI_Model
{
    private $index_taules = 'index_taules';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_last_id($table_name)
    {
        $query = $this->db->get_where($this->index_taules, array('taula_nom' => $table_name));
        
        $data = $query->result_array();
        $last_id = $data[0]['last_id'];

        return ($last_id + 1);
        //return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    public function update_last_id($table_name, $id)
    {
        $id = ($id + 1);

        $this->db->where('taula_nom', $table_name);
        $this->db->update($this->index_taules, array('last_id' => $id));
		
		return ($this->db->affected_rows() != 1) ? false : true;
    }
}