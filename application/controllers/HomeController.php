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
		$data['content'] = 'alumne/home_view';
		
		$count = $this->Alumne->select_tests_alumne_count($this->session->userdata('nif'));

		$this->load->library('pagination');
        
		$config['base_url'] = base_url().'index.php/HomeController/index/';
		$config['total_rows'] = $count;
		$config['per_page'] = $this->per_page;
        $config['num_links'] = $count;

		$this->pagination->initialize($config);

		$data['tests_sense_preguntes'] = $this->Alumne->select_tests_alumne($this->session->userdata('nif'), $this->per_page, $this->uri->segment(3));
		$data['tests'] = $this->get_respostes_per_test($data['tests_sense_preguntes']);
		$data['tests_realitzats'] = $count;
		$data['tests_aprobats'] = $this->tests_aprobats_count($data['tests']);	

		$this->load->view($this->layout, $data);
	}

	private function tests_aprobats_count($tests)
	{
		$testsAprobats = 0;
		
		if($tests && count($tests) > 0)
		{
			foreach($tests as $test)
			{
				if($test['nota'] == 'excelente' || $test['nota'] == 'aprobado') 
				{
					$testsAprobats++;
				}
			}
		}

		return $testsAprobats;
	}

	private function get_respostes_per_test($tests)
	{
		if($tests && count($tests) > 0)
		{
			foreach($tests as &$test)
			{
				$test['preguntes'] = $this->Alumne->select_respostes_test($test['test_codi']);
			}
		}

		return $tests;
	}
}