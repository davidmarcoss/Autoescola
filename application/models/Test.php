<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Model
{
    private $table_tests = 'tests';
    private $table_preguntes = 'preguntes';

    function __construct()
    {
        parent::__construct();
    }

    function select_by_carnet($carnet)
    {
        $this->db->from($this->table_tests);
        $this->db->where('carnet_codi', $carnet);

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_by_codi($codi)
    {
        $this->db->from($this->table_tests);
        $this->db->join($this->table_preguntes, 'preguntes.test_codi = tests.codi');
        $this->db->where('tests.codi', $codi);
        $this->db->order_by('tests.codi, preguntes.codi');

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }


}