<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administrador extends MY_Model
{
    private $table = 'administradors';

    function __construct()
    {
        parent::__construct();
    }

    function select_professors()
    {
        $query = $this->db->get_where($this->table, array('rol' => 'professor'));

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_where_correu($correu)
    {
        $this->db->select('nif, nom, cognoms, telefon, data_naix, correu');
        $this->db->where('correu', $correu);

        $query = $this->db->get('usuari');

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function insert($administrador, $rol)
    {
        $administrador['rol'] = $rol;

        $this->db->insert('administradors', $administrador);
		
		return ($this->db->affected_rows() != 1) ? false : true;
    }

    function update($administrador)
    {
        $this->db->where('nif', $administrador['nif']);

        $this->db->update('administradors', $administrador);

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function delete($nif)
    {
        $this->db->where('nif', $nif);
        
        $this->db->delete('administradors');

        return ($this->db->affected_rows() != 1) ? false : true;
    }
}