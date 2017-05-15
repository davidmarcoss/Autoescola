<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends MY_Controller {

    function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$data['titol'] = 'Inici';
		$data['content'] = 'alumne/home_view';

		$this->load->view($this->layout, $data);
	}
}
