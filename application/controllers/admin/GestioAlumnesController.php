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
		$this->load->model('Carnet');
    }

	public function index()
	{
		$data['titol'] = 'Inici';
		$data['content'] = 'admin/gestio_alumnes_view';
		
		$data['alumnes'] = $this->Alumne->select_limit($this->per_page, $this->uri->segment(3));
		$data['professors'] = $this->Administrador->select_professors();
		$data['carnets'] = $this->Carnet->select();
		
		$this->set_pagination(count($data['alumnes']), base_url().'index.php/HomeController/index/');


		$this->load->view($this->layout, $data);
	}

	public function insert()
	{
		$data = $this->input->post();

		$alumne = array(
			'nif' => $data['nif'],
			'nom' => $data['nom'],
			'cognoms' => $data['cognoms'],
			'correu' => $data['correu'],
			'password' => md5($data['password']),
			'poblacio' => $data['poblacio'],
			'adreca' => $data['adreca'],
			'telefon' => $data['telefon'],
			'professor_nif' => $data['professor_nif'],
			'desactivat' => 0
		);

		$alumne_carnet = array(
			'alumne_nif' => $data['nif'],
			'carnet_codi' => $data['carnet_codi'],
			'data_alta' => date('Y-m-d H:i:s'),
		);

		$this->Alumne->insert($alumne, $alumne_carnet);

		redirect('admin/GestioAlumnesController/index');
	}

	public function update()
	{
		$data = $this->input->post();

		if($data['password'] < 32) $password = md5($data['password']);
		else $password = $data['password'];

		$alumne = array(
			'nif' => $data['nif'],
			'nom' => $data['nom'],
			'cognoms' => $data['cognoms'],
			'correu' => $data['correu'],
			'password' => $password,
			'poblacio' => $data['poblacio'],
			'adreca' => $data['adreca'],
			'telefon' => $data['telefon'],
			'professor_nif' => $data['professor_nif'],
		);

		if( ! $this->Alumne->select_carnet($data['nif'], $data['carnet_codi']))
		{
			$alumne_carnet = array(
				'alumne_nif' => $data['nif'],
				'carnet_codi' => $data['carnet_codi'],
				'data_alta' => date('Y-m-d h:i:s'),
			);
			$this->Alumne->update($alumne, $alumne_carnet);
		}
		else
		{
			$this->Alumne->update($alumne);
		}

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