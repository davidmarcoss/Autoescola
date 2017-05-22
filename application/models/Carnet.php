<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Carnet extends MY_Model
{
    private $table_name = 'carnets';

    function __construct()
    {
        parent::__construct();
    }

    function select()
    {
        $this->db->where('desactivat', 0);
        
        $query = $this->db->get($this->table_name);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_where($codi)
    {
        $this->db->where('codi', $codi);
        $this->db->where('desactivat', 0);
        
        $query = $this->db->get($this->table_name);

        return $query->num_rows() > 0 ? true : false;
    }

    function insert($codi)
    {
        $data = array(
            'codi' => $codi,
            'desactivat' => 0
        );

        $this->db->insert('carnets', $data);
		
		return ($this->db->affected_rows() != 1) ? false : true;
    }

    function delete($codi)
    {
        $this->db->where('codi', $codi);
        
        $this->db->update('carnets', array('desactivat' => 1));

        return ($this->db->affected_rows() != 1) ? false : true;
    }
}