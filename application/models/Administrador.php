<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administrador extends MY_Model
{
    private $table = 'administradors';

    function __construct()
    {
        parent::__construct();
    }

    public function count_professors()
    {
        $this->db->select('count(*) as count');
        $this->db->where(array('rol' => 'professor'));
        $query = $this->db->get($this->table);

        $data = $query->result_array();

        return $data[0]['count'];
    }

    function select_professors_limit($limit, $segment)
    {
        $this->db->where(array('rol' => 'professor'));
        $query = $this->db->get($this->table, $limit, $segment);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_professors()
    {
        $this->db->where(array('rol' => 'professor'));
        $query = $this->db->get($this->table);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_professors_where_like($nif, $nom, $limit, $segment, $rol)
    {
        $this->db->like('nif', $nif);
        $this->db->like('nom', $nom);
        $this->db->where('rol', $rol);

        $query = $this->db->get('administradors', $limit, $segment);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_where_like($nif, $nom, $limit, $segment, $rol)
    {
        $this->db->where('rol', $rol);        
        $this->db->like('nif', $nif);
        $this->db->like('nom', $nom);

        $query = $this->db->get('administradors', $limit, $segment);

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