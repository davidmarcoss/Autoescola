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
        $query = $this->db->get_where($this->index_taules, $table_name);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    public function update_last_id($table_name)
    {
        
    }
}