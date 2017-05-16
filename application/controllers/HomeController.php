<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends MY_Controller {

    function __construct()
    {
        parent::__construct();

		$this->load->model('Test');
    }

	public function index()
	{
		$data['titol'] = 'Inici';
		$data['content'] = 'alumne/home_view';

		$data['tests'] = $this->Test->select_where_alumne($this->session->userdata('nif'));
		$data['mytests'] = $this->get_preguntes_per_test($data['tests']);
		$data['testsCount'] = count($data['tests']);
		$data['testsAprobats'] = $this->get_count_tests_aprobats($data['tests']);
		//var_dump($data['mytests']); exit;
		$this->load->view($this->layout, $data);
	}

	public function get_count_tests_aprobats($tests)
	{
		$testsAprobats = 0;
		
		foreach($tests as $test)
		{
			if($test['nota'] == 'excelente' || $test['nota'] == 'aprobado') 
			{
				$testsAprobats++;
			}
		}

		return $testsAprobats;
	}

	public function get_preguntes_per_test($tests)
	{
		foreach($tests as &$test)
		{
			$test['preguntes'] = $this->Test->select_respostes_where_test($test['test_codi']);
		}

		return $tests;
	}
}