<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class GestioAlumnesController extends MY_Controller 
{

    function __construct()
    {
        parent::__construct();

		$this->load->model('Alumne');
    }

	public function index()
	{
		$data['titol'] = 'Inici';
		$data['content'] = 'admin/gestio_alumnes_view';

		$data['alumnes'] = $this->Alumne->select();

		$this->load->view($this->layout, $data);
	}

}