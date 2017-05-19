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
        $query = $this->db->get($this->table_name);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

}