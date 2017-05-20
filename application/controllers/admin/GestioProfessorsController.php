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

        $this->load->library('pagination');
    }

	public function index()
	{
		$data['content'] = 'admin/gestio_professors_view';

        $count = $this->Administrador->count_professors();

        $this->load->library('pagination');
        
		$config['base_url'] = base_url().'index.php/admin/GestioProfessorsController/index/';
		$config['total_rows'] = $count;
		$config['per_page'] = $this->per_page;
        $config['num_links'] = $count;

		$this->pagination->initialize($config);

        $data['professors'] = $this->Administrador->select_professors_limit($config['per_page'], $this->uri->segment(4));	

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