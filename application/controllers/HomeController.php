<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends MY_Controller 
{

    function __construct()
    {
        parent::__construct();

        if ( ! $this->is_logged_in())
        {
            redirect('LoginController/index');
        }
		
		$this->load->model('Alumne');
    }

	public function index()
	{
		$data['titol'] = 'Inici';
		$data['content'] = 'alumne/home_view';

		$data['tests_sense_preguntes'] = $this->Alumne->select_tests_alumne($this->session->userdata('nif'));
		$data['tests'] = $this->get_respostes_per_test($data['tests_sense_preguntes']);
		$data['tests_realitzats'] = count($data['tests']);
		$data['tests_aprobats'] = $this->tests_aprobats_count($data['tests']);	

		$this->load->view($this->layout, $data);
	}

	private function tests_aprobats_count($tests)
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

	private function get_respostes_per_test($tests)
	{
		foreach($tests as &$test)
		{
			$test['preguntes'] = $this->Alumne->select_respostes_test($test['test_codi']);
		}

		return $tests;
	}
}