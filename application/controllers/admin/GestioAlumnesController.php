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
		
		$data['alumnes'] = $this->Alumne->select_limit($this->per_page, $this->uri->segment(3));
		$data['professors'] = $this->Administrador->select_professors();
		
		$this->set_pagination(count($data['alumnes']), base_url().'index.php/HomeController/index/');


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

	public function select_where_like()
	{
		$nif = $this->input->post('nif');
		$nom = $this->input->post('nom');

		$data['alumnes'] = $this->Alumne->select_where_like($nif, $nom, $this->per_page, $this->uri->segment(3));

		echo json_encode($data['alumnes']);
	}

}