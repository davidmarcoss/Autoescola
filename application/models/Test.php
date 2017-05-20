<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Model
{
    private $table_tests = 'tests';
    private $table_preguntes = 'preguntes';

    function __construct()
    {
        parent::__construct();
    }

    function select_by_carnet($carnet)
    {
        $this->db->from($this->table_tests);
        $this->db->where('carnet_codi', $carnet);
        $this->db->join('alumne_tests', 'tests.codi = alumne_tests.test_codi', 'left outer');
        $this->db->group_by('tests.codi');

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select()
    {
        $this->db->from($this->table_tests);
        $this->db->group_by('tests.codi');

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_by_codi($codi)
    {
        $this->db->from($this->table_tests);
        $this->db->join($this->table_preguntes, 'preguntes.test_codi = tests.codi');
        $this->db->where('tests.codi', $codi);
        $this->db->order_by('tests.codi, preguntes.codi');

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function select_pregunta($codi)
    {
        $query = $this->db->get_where($this->table_preguntes, array('codi' => $codi));

        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    /**
    *   Inserció d'un test per part de l'administrador
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
    *   Inserció d'un test realitzat per l'alumne
    */
    function insert($dataTest, $dataRespostes)
    {
        $this->db->trans_begin();

        $last_id_test = $this->get_last_id('alumne_tests');
        $dataTest['id'] = $last_id_test;
        $this->db->insert('alumne_tests', $dataTest);

        foreach($dataRespostes as $dataResposta)
        {
            $last_id_resposta = $this->get_last_id('alumne_preguntes_respostes');

            $this->db->insert('alumne_preguntes_respostes', array('id' => $last_id_resposta, 'pregunta_codi' => $dataResposta['pregunta_codi'], 'resposta_alumne' => $dataResposta['resposta_alumne'], 'isCorrecta' => $dataResposta['isCorrecta'], 'alumne_test' => $last_id_test));

            $this->update_last_id('alumne_preguntes_respostes', $last_id_resposta);
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
}