<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
    * Funció per a seleccionar els tests d'un carnet específic.
    *
    * @param String $carnet Codi de carnet.
    */
    function select_by_carnet($carnet)
    {
        $this->db->from('tests');
        $this->db->where('test_carnet_codi', $carnet);
        $this->db->join('alumne_tests', 'tests.test_codi = alumne_tests.alu_test_test_codi', 'left outer');
        $this->db->group_by('tests.test_codi');

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    /**
    * Funció per a seleccionar tots els tests
    */
    function select()
    {
        $query = $this->db->get('tests');

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    /**
    * Funció per a seleccionar totes les preguntes d'un test.
    */
    function select_preguntes($test)
    {
        $this->db->from('preguntes');
        $this->db->where('preg_test_codi', $test);
        
        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    /**
    * Funció per a seleccionat un test a partir del seu codi.
    */
    function select_by_codi($codi)
    {
        $this->db->from('tests');
        $this->db->join('preguntes', 'preguntes.preg_test_codi = tests.test_codi');
        $this->db->where('tests.test_codi', $codi);
        $this->db->order_by('tests.test_codi, preguntes.preg_codi');

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    /**
    * Funció per a seleccionar una pregunta a partir del seu codi.
    */
    function select_pregunta($codi)
    {
        $query = $this->db->get_where('preguntes', array('preg_codi' => $codi));

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    /**
    * Funció per a eliminar un test.
    */
    function delete($codi)
    {
        $this->db->where('test_codi', $codi);

        $this->db->update('tests', array('test_desactivat' => 1));

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
    * Inserció d'un test per part de l'administrador.
    *
    * @param Array $dataTest Les dades del test.
    * @param Array $dataPreguntes Les dades de les preguntes.
    */
    function insert_test($dataTest, $dataPreguntes)
    {
        $this->db->trans_begin();

        $this->db->insert('tests', $dataTest);

        foreach($dataPreguntes as $dataPregunta)
        {
            $this->db->insert('preguntes', $dataPregunta);
        }

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

    /**
    * Funció per a inserir un test realitzat per un alumne.
    *
    * @param Array $dataTest Dades del test.
    * @param Array $dataRespostes Dades de les respostes.
    */
    function insert($dataTest, $dataRespostes)
    {
        $this->db->trans_begin();

        $last_id_test = $this->get_last_id('alumne_tests');
        
        $dataTest['alu_test_id'] = $last_id_test;
        $this->db->insert('alumne_tests', $dataTest);

        foreach($dataRespostes as $dataResposta)
        {
            $last_id_resposta = $this->get_last_id('alumne_respostes');
            
            $this->db->insert('alumne_respostes', array('alu_resp_id' => $last_id_resposta, 'alu_resp_pregunta_codi' => $dataResposta['alu_resp_pregunta_codi'], 'alu_resp_resposta_alumne' => $dataResposta['alu_resp_resposta_alumne'], 'alu_resp_isCorrecta' => $dataResposta['alu_resp_isCorrecta'], 'alu_resp_alumne_test' => $last_id_test));

            $this->update_last_id('alumne_respostes', $last_id_resposta);
        }

        $this->update_last_id('alumne_tests', $last_id_test);


        if ($this->db->trans_status() === FALSE)
        {
                $this->db->trans_rollback();
        }
        else
        {
                $this->db->trans_commit();
        }
    }

    /**
    * Funció per a modificar una pregunta.
    *
    * @param Array $pregunta Dades de la pregunta.
    */
    function update_pregunta($pregunta)
    {
        $this->db->where('preg_codi', $pregunta['preg_codi']);
        
        $this->db->update('preguntes', $pregunta);

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
    * Funció per a activar un test.
    *
    * @param String $test_codi Codi del test.
    */
    function activar($test_codi)
    {
        $this->db->where('test_codi', $test_codi);

        $this->db->update('tests', array('test_desactivat' => 0));

        return ($this->db->affected_rows() != 1) ? false : true;
    }
}