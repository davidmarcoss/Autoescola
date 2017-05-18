<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuari extends MY_Model
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

        }

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    public function carnet_actual($nif)
    {
        $this->db->where('alumne_nif', $nif);
        $this->db->order_by('data_alta', 'desc');
        $this->db->limit(1);

        $query = $this->db->get('alumne_carnets');

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }
}