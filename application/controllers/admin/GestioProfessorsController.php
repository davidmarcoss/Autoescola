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

        $data['professors'] = $this->Administrador->select_professors_limit($this->per_page, $this->uri->segment(4));	

		$this->set_pagination($count, base_url().'index.php/admin/GestioProfessorsController/index/');

		$this->load->view($this->layout, $data);
	}

    public function insert()
    {
        $data = $this->input->post();

        $professor = array(
            'admin_nif' => $data['nif'],
            'admin_nom' => $data['nom'],
            'admin_cognoms' => $data['cognoms'],
            'admin_correu' => $data['correu']
        );

        $this->Administrador->insert($professor, 'professor');

        redirect('admin/GestioProfessorsController/index');
    }

    public function update()
    {
        $data = $this->input->post();

        $professor = array(
            'admin_nif' => $data['nif'],
            'admin_nom' => $data['nom'],
            'admin_cognoms' => $data['cognoms'],
            'admin_correu' => $data['correu']
        );

        $this->Administrador->update($professor);

        redirect('admin/GestioProfessorsController/index');
    }

    public function delete()
    {
        $nif = $this->input->post('nif');

        if($this->Administrador->is_professor_assignat($nif))
        {
            $this->session->set_flashdata('errors', '<strong>Error!</strong> Este profesor ya esta asignado a uno o más alumnos!');
        }
        else
        {
            if($this->Administrador->delete($nif))
            {
                $this->session->set_flashdata('exits', '<strong>Éxito!</strong> Profesor eliminado correctamente!');
            }
            else
            {
                $this->session->set_flashdata('errors', '<strong>Error!</strong> No se ha podido eliminar este profesor! Inténtelo de nuevo más tarde.');
            }
        }

        redirect('admin/GestioProfessorsController/index');
    }

	public function select_where_like()
	{
		$nif = $this->input->post('nif');
		$nom = $this->input->post('nom');

		$data['professors'] = $this->Administrador->select_where_like($nif, $nom, $this->per_page, $this->uri->segment(3), 'professor');

		echo json_encode($data['professors']);
	}

}