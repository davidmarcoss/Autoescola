<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuari extends CI_Model
{
    private $table_alumnes = 'alumnes';
    private $table_professors = 'administradors';

    function __construct()
    {
        parent::__construct();
    }

    public function login($correu, $password)
    {
        $this->db->where('correu', $correu);
        $this->db->where('password', $password);
        $query = $this->db->get('alumnes');

        if( ! $query->num_rows())
        {
            $this->db->where('correu', $correu);
            $this->db->where('password', $password);
            $query = $this->db->get('administradors');

            $data = $query->result_array();
            $isAdmin = $data[0]['rol'];
            if($isAdmin == 'admin') $this->session->set_userdata('rol', 'admin');
            else $this->session->set_userdata('rol', 'professor');
        }

        if($query->num_rows() > 0) { return $query->result_array(); }
        else { return false; }
    }
}