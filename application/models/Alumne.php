<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Alumne extends CI_Model
{
    private $table = 'alumnes';
    private $table_tests = 'tests';
    private $table_alumne_tests = 'alumne_tests';
    private $table_alumne_preguntes_respostes = 'alumne_preguntes_respostes';
    private $table_preguntes = 'preguntes';

    function __construct()
    {
        parent::__construct();
    }

    function select()
    {
        $this->db->select('alumnes.*, administradors.nif as admin_nif, administradors.rol as admin_rol, administradors.nom as admin_nom, administradors.cognoms as admin_cognoms');
        $this->db->from('alumnes');
        $this->db->join('administradors', 'administradors.nif = alumnes.professor_nif');
        $this->db->where('administradors.rol', 'professor');
        $query = $this->db->get();

        return $query->result_array();
    }

    function select_where_correu($correu)
    {
        $this->db->select('nif, nom, cognoms, telefon, data_naix, correu');
        $this->db->where('correu', $correu);

        $query = $this->db->get('usuari');

        return $query->num_rows() > 0 ? $query->result_array() : false;
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

    // ------------------------------------------------------------------------------------------------------//

    function select_respostes_test($testCodi)
    {
        $this->db->select('alumne_preguntes_respostes.*, preguntes.*');
        $this->db->from($this->table_alumne_preguntes_respostes);
        $this->db->join($this->table_alumne_tests, 'alumne_tests.id = alumne_preguntes_respostes.alumne_test');
        $this->db->join($this->table_preguntes, 'preguntes.codi = alumne_preguntes_respostes.pregunta_codi');
        $this->db->where('alumne_tests.test_codi', $testCodi);

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_tests_alumne($alumneNIF)
    {
        $this->db->select('alumne_tests.*, tests.*');
        $this->db->from($this->table_alumne_tests);
        $this->db->join($this->table_tests, 'tests.codi = alumne_tests.test_codi');
        $this->db->where('alumne_nif', $alumneNIF);
        $this->db->group_by('alumne_tests.test_codi');
        
        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }
}