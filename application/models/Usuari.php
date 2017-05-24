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
        $this->db->where('alu_correu', $correu);
        $this->db->where('alu_password', $password);

        $query = $this->db->get('alumnes');

        if( ! $query->num_rows() > 0)
        {
            $this->db->where('admin_correu', $correu);
            $this->db->where('admin_password', $password);

            $query = $this->db->get('administradors');

            $data = $query->result_array();

            if(count($data) > 0)
            {
                $this->session->set_userdata('rol', $data[0]['admin_rol']);
            }
        }

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    public function carnet_actual($nif)
    {
        $this->db->where('alu_carn_alumne_nif', $nif);
        $this->db->order_by('alu_carn_data_alta', 'desc');
        $this->db->limit(1);

        $query = $this->db->get('alumne_carnets');

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }
}