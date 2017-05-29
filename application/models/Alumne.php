<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Alumne extends MY_Model
{
    private $table = 'alumnes';
    private $table_tests = 'tests';
    private $table_alumne_tests = 'alumne_tests';
    private $table_alumne_respostes = 'alumne_respostes';
    private $table_preguntes = 'preguntes';

    function __construct()
    {
        parent::__construct();
    }

    function select_limit($limit, $segment)
    {
        $this->db->join('administradors', 'administradors.admin_nif = alumnes.alu_professor_nif');
        $this->db->join('alumne_carnets', 'alumne_carnets.alu_carn_alumne_nif = alumnes.alu_nif');
        $this->db->where('alumne_carnets.alu_carn_data_alta in (select max(alu_carn_data_alta) from alumne_carnets ac where ac.alu_carn_alumne_nif = alumnes.alu_nif)', NULL, FALSE);
        $this->db->where('administradors.admin_rol', 'professor');
        //$this->db->where('alu_desactivat', 0);

        $query = $this->db->get('alumnes', $limit, $segment);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select()
    {
        $query = $this->db->get('alumnes');

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function count()
    {
        $this->db->select('count(*) as count');
        $this->db->join('administradors', 'administradors.admin_nif = alumnes.alu_professor_nif');
        $this->db->join('alumne_carnets', 'alumne_carnets.alu_carn_alumne_nif = alumnes.alu_nif');
        $this->db->where('alumne_carnets.alu_carn_data_alta in (select max(alu_carn_data_alta) from alumne_carnets ac where ac.alu_carn_alumne_nif = alumnes.alu_nif)', NULL, FALSE);
        $this->db->where('administradors.admin_rol', 'professor');
        //$this->db->where('alu_desactivat', 0);

        $query = $this->db->get('alumnes');
        $data = $query->result_array();

        return $data[0]['count'];
    }

    function select_where_like($nif, $nom, $limit, $segment)
    {
        $this->db->join('administradors', 'administradors.admin_nif = alumnes.alu_professor_nif');
        $this->db->join('alumne_carnets', 'alumne_carnets.alu_carn_alumne_nif = alumnes.alu_nif');
        $this->db->where('alumne_carnets.alu_carn_data_alta in (select max(alu_carn_data_alta) from alumne_carnets ac where ac.alu_carn_alumne_nif = alumnes.alu_nif)', NULL, FALSE);
        //$this->db->where('alu_desactivat', 0);        
        $this->db->like('alumnes.alu_nif', $nif);
        $this->db->like('alumnes.alu_nom', $nom);

        $query = $this->db->get('alumnes', $limit, $segment);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_where_correu($correu)
    {

        $this->db->where('alu_correu', $correu);

        $query = $this->db->get('alumnes');

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_where_token($token)
    {
        $this->db->select('alu_nif, alu_nom, alu_cognoms, alu_correu, alu_token');
        $this->db->where('alu_token', $token);

        $query = $this->db->get('alumnes');

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_carnet($alumneNIF, $carnet_codi)
    {
        $this->db->where(array('alu_carn_alumne_nif' => $alumneNIF, 'alu_carn_carnet_codi' => $carnet_codi));
        $query = $this->db->get('alumne_carnets');

        return $query->num_rows() > 0 ? true : false;
    }

    function insert($alumne, $alumne_carnet)
    {
        $this->db->trans_begin();

        $this->db->insert('alumnes', $alumne);

        $this->db->insert('alumne_carnets', $alumne_carnet);
		
        if( ! $this->db->trans_status())
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    function update($alumne, $alumne_carnet = null)
    {
        $this->db->where('alu_nif', $alumne['alu_nif']);
        $this->db->update('alumnes', $alumne);

        if($alumne_carnet != null)
        {
            $this->db->insert('alumne_carnets', $alumne_carnet);
        }

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function update_password($correu, $password)
    {
        $this->db->where('alu_correu', $correu);

        $this->db->update('alumnes', array('alu_password' => $password));

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function delete($nif)
    {
        $this->db->where('alu_nif', $nif);

        $this->db->update('alumnes', array('alu_desactivat' => 1));

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function activar($nif)
    {
        $this->db->where('alu_nif', $nif);

        $this->db->update('alumnes', array('alu_desactivat' => 0));

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    function update_token($nif)
    {
        $newToken = md5(rand());

        $this->db->where('alu_nif', $nif);

        $this->db->update('alumnes', array('alu_token' => $newToken));

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    // ------------------------------------------------------------------------------------------------------//

    function select_respostes_test($testCodi)
    {
        $this->db->from($this->table_alumne_respostes);
        $this->db->join($this->table_alumne_tests, 'alumne_tests.alu_test_id = alumne_respostes.alu_resp_alumne_test');
        $this->db->join($this->table_preguntes, 'preguntes.preg_codi = alumne_respostes.alu_resp_pregunta_codi');
        $this->db->where('alumne_tests.alu_test_id', $testCodi);

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_tests_alumne($alumneNIF, $limit, $segment, $filtre = null)
    {
        $this->db->join($this->table_tests, 'tests.test_codi = alumne_tests.alu_test_test_codi');
        $this->db->where('alu_test_alumne_nif', $alumneNIF);
        if(!$filtre) $this->db->order_by('alu_test_data_fi', 'desc');
        if($filtre != null)
        {
            if($filtre == 'data_fi') 
            {
                $this->db->order_by('alu_test_data_fi', 'asc');
            }
            else
            {
                if($filtre == 'aprobado') $this->db->where('alu_test_nota', 'excelente')->or_where('alu_test_nota', 'aprobado');
                else if($filtre == 'suspendido') $this->db->where('alu_test_nota', 'suspendido');
            }
        }
        
        $query = $this->db->get($this->table_alumne_tests, $limit, $segment);

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_tests_alumne_count($alumneNIF)
    {
        $this->db->from($this->table_alumne_tests);
        $this->db->where('alu_test_alumne_nif', $alumneNIF);
        
        $query = $this->db->get();

        $data = $query->result_Array();

        return count($data);
    }

    function count_respostes()
    {
        $query = $this->db->get('alumne_respostes');

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_tests_webservice($carnet, $nif)
    {
        $this->db->select('tests.test_codi, alu_test_nota');
        $this->db->join('tests', 'alumne_tests.alu_test_test_codi = tests.test_codi');
        $this->db->where('alu_test_alumne_nif', $nif);
        $this->db->where('tests.test_carnet_codi', $carnet);

        $query = $this->db->get('alumne_tests');

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }
}