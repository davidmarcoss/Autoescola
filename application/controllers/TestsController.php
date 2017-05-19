<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class TestsController extends MY_Controller 
{
	
    function __construct()
    {
        parent::__construct();

		if ( ! $this->is_logged_in())
        {
            redirect('LoginController/index');
        }

		$this->load->model('Test');
    }

	public function index()
	{
		$data['titol'] = 'Tests';
		$data['content'] = 'alumne/tests_view';

		$data['tests'] = $this->Test->select_by_carnet($this->session->carnet);

		$this->load->view($this->layout, $data);
	}

	public function show($codi)
    {
		$data['titol'] = 'Tests';
		$data['content'] = 'alumne/test_action_view';

		$data['test'] = $this->Test->select_by_codi($codi);

		$this->session->set_userdata(array('codi_test' => $codi, 'nom_test' => $data['test'][0]['nom']));

		$this->load->view($this->layout, $data);
    }

	public function check()
	{
		$data = $this->input->post();
		
		$dataRespostes = array();
		$errades = 0;
		$nota = 0;

		foreach($data as $key => $value)
		{
			$pregunta = $this->Test->select_pregunta($key);

			if($value == $pregunta[0]['opcio_correcta'])
			{
				$isCorrecta = 'S';
				$correcta = null;
			}
			else
			{
				$isCorrecta = 'N';
				$correcta = $pregunta[0]['opcio_correcta'];
				$errades++;
			}

			$dataRespostes[] = array(
				'pregunta_codi' => $key,
				'resposta_alumne' => $value,
				'isCorrecta' => $isCorrecta,
				'correcta' => $correcta
			);
		}

		if($errades == 0) $nota = 'excelente';
		else if($errades > 0 && $errades <= 3) $nota = 'aprobado';
		else $nota = 'suspendido';

		$this->insert($dataRespostes, $nota);

		echo json_encode($dataRespostes);
	}

	private function insert($dataRespostes, $nota)
	{
		$dataTest = array(
			'data_fi' => date('Y-m-d h:i:s'),
			'alumne_nif' => $this->session->userdata('nif'),
			'test_codi' => $this->session->userdata('codi_test'),
			'nota' => $nota
		);

		$this->Test->insert($dataTest, $dataRespostes);
	}

}