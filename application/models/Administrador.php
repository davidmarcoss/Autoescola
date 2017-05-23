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
        $this->db->where(array('admin_rol' => 'professor'));
        $query = $this->db->get($this->table);

        $data = $query->result_array();

        return $data[0]['count'];
    }

    function select_professors_limit($limit, $segment)
    {
        $this->db->where(array('admin_rol' => 'professor'));
        $query = $this->db->get($this->table, $limit, $segment);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_professors()
    {
        $this->db->where(array('admin_rol' => 'professor'));
        $query = $this->db->get($this->table);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_professors_where_like($nif, $nom, $limit, $segment, $rol)
    {
        $this->db->like('admin_nif', $nif);
        $this->db->like('admin_nom', $nom);
        $this->db->where('admin_rol', $rol);

        $query = $this->db->get('administradors', $limit, $segment);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_where_like($nif, $nom, $limit, $segment, $rol)
    {
        $this->db->where('admin_rol', $rol);        
        $this->db->like('admin_nif', $nif);
        $this->db->like('admin_nom', $nom);

        $query = $this->db->get('administradors', $limit, $segment);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_where_correu($correu)
    {
        $this->db->select('admin_nif, admin_nom, admin_cognoms, admin_telefon, admin_data_naix, admin_correu');
        $this->db->where('admin_correu', $correu);

        $query = $this->db->get('usuari');

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function insert($administrador, $rol)
    {
        $administrador['admin_rol'] = $rol;

        $this->db->insert('administradors', $administrador);
		
		return ($this->db->affected_rows() != 1) ? false : true;
    }

    function update($administrador)
    {
        $this->db->where('admin_nif', $administrador['admin_nif']);

        $this->db->update('administradors', $administrador);

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function delete($nif)
    {
        $this->db->where('admin_nif', $nif);
        
        $this->db->delete('administradors');

        return ($this->db->affected_rows() != 1) ? false : true;
    }
}