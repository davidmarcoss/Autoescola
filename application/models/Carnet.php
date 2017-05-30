<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Carnet extends MY_Model
{
    private $table_name = 'carnets';

    function __construct()
    {
        parent::__construct();
    }

    /**
    * Funció per a seleccionar tots els carnets de l'autoescola.
    */
    function select()
    {
        $this->db->where('carnet_desactivat', 0);
        
        $query = $this->db->get($this->table_name);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    /**
    * Funció per a seleccionar un carnet en concret.
    *
    * @param int $codi El codi del carnet.
    */
    function select_where($codi)
    {
        $this->db->where('carnet_codi', $codi);
        $this->db->where('carnet_desactivat', 0);
        
        $query = $this->db->get($this->table_name);

        return $query->num_rows() > 0 ? true : false;
    }

    /**
    * Funció per a inserir un carnet.
    *
    * @param int $codi El codi del carnet.
    */
    function insert($codi)
    {
        $data = array(
            'carnet_codi' => $codi,
            'carnet_desactivat' => 0
        );

        $this->db->insert('carnets', $data);
		
		return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
    * Funció per a eliminar un carnet.
    *
    * @param int $codi El codi del carnet.
    */
    function delete($codi)
    {
        $this->db->where('carnet_codi', $codi);
        
        $this->db->update('carnets', array('carnet_desactivat' => 1));

        return ($this->db->affected_rows() != 1) ? false : true;
    }
}