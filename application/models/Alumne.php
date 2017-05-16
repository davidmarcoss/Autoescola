<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Alumne extends CI_Model
{
    private $table = 'alumnes';

    function __construct()
    {
        parent::__construct();
    }

    function select()
    {
        $this->db->select('nif, nom, cognoms, telefon, data_naix, correu');
        $this->db->get('usuaris');

        $query = $this->db->get($this->table_name);

        return $query->result_array();
    }

    function select_where_correu($correu)
    {
        $this->db->select('nif, nom, cognoms, telefon, data_naix, correu');
        $this->db->where('correu', $correu);

        $query = $this->db->get('usuari');

        if($query->num_rows() > 0) return $query->result_array();
        else return false;
    }

    function insert($usuari)
    {
        $usuari = array(
            'nom' => $usuari['nom']
        );

        $this->db->insert('usuaris',$usuari);
		
		return ($this->db->affected_rows() != 1) ? false : true;
    }

    function update($usuari)
    {
        $data = array(
               'nom' => $usuari['nom']
        );

        $this->db->where('id', $usuari['id']);

        $this->db->update('usuaris', $data);

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function delete($id)
    {
        $this->db->where('id', $id);

        $this->db->delete('empleats');

        return ($this->db->affected_rows() != 1) ? false : true;
    }
}