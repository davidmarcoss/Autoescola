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

		$this->load->view($this->layout, $data);
    }

	public function check()
	{
		$data = $this->input->post();
		
		echo json_encode($data);
		
		//$respostaCorrecta = ;

		
	}
}