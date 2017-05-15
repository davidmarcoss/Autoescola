<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class GestioHomeController extends MY_Controller {

    function __construct()
    {
        parent::__construct();
		
        /*if ( ! $this->is_logged_in())
        {
            redirect('LoginController/index');
        }*/
    }

	public function index()
	{
		$data['titol'] = 'Inici';
		$data['content'] = 'admin/gestio_home_view';

		$this->load->view($this->layout, $data);
	}
}
