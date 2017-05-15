<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class TestsController extends MY_Controller {

	public function index()
	{
		$data['titol'] = 'Tests';
		$data['content'] = 'alumne/tests_view';

		$this->load->view($this->layout, $data);
	}
}
