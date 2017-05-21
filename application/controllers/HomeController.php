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
		$this->session->set_flashdata('filtre', null);

		$data['content'] = 'alumne/home_view';
		
		$pagination_count = $this->Alumne->select_tests_alumne_count($this->session->userdata('nif'));
		$this->set_pagination($pagination_count, base_url().'index.php/HomeController/index/');

		$data['tests_sense_preguntes'] = $this->Alumne->select_tests_alumne($this->session->userdata('nif'), $this->per_page, $this->uri->segment(3));
		$data['tests'] = $this->get_respostes_per_test($data['tests_sense_preguntes']);
		$data['tests_realitzats'] = $pagination_count;
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

	public function filtres_ajax()
	{
		$filtre = $this->input->post('filtre-alumne-tests');
		if(isset($filtre) && !empty($filtre))
		{
			$this->session->set_flashdata('filtre', $filtre);
			$data['tests_sense_preguntes'] = $this->Alumne->select_tests_alumne($this->session->userdata('nif'), $this->per_page, $this->uri->segment(3), $filtre);
		}
		else
		{
			$data['tests_sense_preguntes'] = $this->Alumne->select_tests_alumne($this->session->userdata('nif'), $this->per_page, $this->uri->segment(3));
		}

		$data['tests'] = $this->get_respostes_per_test($data['tests_sense_preguntes']);

		if(count($data['tests'] > 0)) echo json_encode($data['tests']);	
	}

}