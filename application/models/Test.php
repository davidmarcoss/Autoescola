<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Model
{
    private $table_tests = 'tests';
    private $table_alumne_tests = 'alumne_tests';
    private $table_alumne_preguntes_respostes = 'alumne_preguntes_respostes';
    private $table_preguntes = 'preguntes';

    function __construct()
    {
        parent::__construct();
    }

    function select_where_alumne($alumneNIF)
    {
        $this->db->select('alumne_tests.*, tests.*');
        $this->db->from($this->table_alumne_tests);
        $this->db->join($this->table_tests, 'tests.codi = alumne_tests.test_codi');
        $this->db->where('alumne_nif', $alumneNIF);
        $this->db->group_by('alumne_tests.test_codi');
        
        $query = $this->db->get();

        if($query->num_rows() > 0) return $query->result_array();
        else return false;
    }

    function select_respostes_where_test($testCodi)
    {
        $this->db->select('alumne_preguntes_respostes.*');
        $this->db->from($this->table_alumne_preguntes_respostes);
        $this->db->join($this->table_alumne_tests, 'alumne_tests.id = alumne_preguntes_respostes.alumne_test');
        $this->db->join($this->table_preguntes, 'preguntes.codi = alumne_preguntes_respostes.pregunta');
        $this->db->where('alumne_tests.test_codi', $testCodi);

        $query = $this->db->get();

        if($query->num_rows() > 0) return $query->result_array();
        else return false;
    }
}