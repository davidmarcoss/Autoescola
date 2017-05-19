<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class GestioAlumnesController extends MY_Controller 
{

    function __construct()
    {
        parent::__construct();

        if ( ! $this->is_logged_in())
        {
            redirect('LoginController/index');
        }
		
		$this->load->model('Alumne');
		$this->load->model('Administrador');
    }

	public function index()
	{
		$data['titol'] = 'Inici';
		$data['content'] = 'admin/gestio_alumnes_view';

		$data['alumnes'] = $this->Alumne->select();
		$data['professors'] = $this->Administrador->select_professors();

		$this->load->view($this->layout, $data);
	}

	public function insert()
	{
		$alumne = $this->input->post();

		$this->Alumne->insert($alumne);

		redirect('admin/GestioAlumnesController/index');
	}

	public function update()
	{
		$alumne = $this->input->post();

		$this->Alumne->update($alumne);

		redirect('admin/GestioAlumnesController/index');
	}

	public function delete()
	{
		$nif = $this->input->post('nif');

		$this->Alumne->delete($nif);

		redirect('admin/GestioAlumnesController/index');
	}

}