<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class GestioProfessorsController extends MY_Controller 
{

    function __construct()
    {
        parent::__construct();

        if ( ! $this->is_logged_in())
        {
            redirect('LoginController/index');
        }
		
		$this->load->model('Administrador');
    }

	public function index()
	{
		$data['titol'] = 'Inici';
		$data['content'] = 'admin/gestio_professors_view';

        $data['professors'] = $this->Administrador->select_professors();

		$this->load->view($this->layout, $data);
	}

    public function insert()
    {
        $professor = $this->input->post();

        $this->Administrador->insert($professor, 'professor');

        redirect('admin/GestioProfessorsController/index');
    }

    public function update()
    {
        $professor = $this->input->post();

        $this->Administrador->update($professor);

        redirect('admin/GestioProfessorsController/index');
    }

    public function delete()
    {
        $nif = $this->input->post('nif');

        $this->Administrador->delete($nif);

        redirect('admin/GestioProfessorsController/index');
    }

}