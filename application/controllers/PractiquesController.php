<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class PractiquesController extends MY_Controller {

    function __construct()
    {
        parent::__construct();

		if ( ! $this->is_logged_in())
        {
            redirect('LoginController/index');
        }

    }

	public function index()
	{
		$data['titol'] = 'Practiques';
		$data['content'] = 'alumne/practiques_view';

		$this->load->view($this->layout, $data);
	}
}
