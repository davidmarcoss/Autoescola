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
		
		$count = $this->Alumne->count();

		$data['alumnes'] = $this->Alumne->select_limit($this->per_page, $this->uri->segment(4));
		$data['professors'] = $this->Administrador->select_professors();
		$data['carnets'] = $this->Carnet->select();

		$this->set_pagination($count, base_url().'index.php/admin/GestioAlumnesController/index/');

		$this->load->view($this->layout, $data);
	}

	public function insert()
	{
		$data = $this->input->post();

		$alumne = array(
			'alu_nif' => $data['nif'],
			'alu_nom' => $data['nom'],
			'alu_cognoms' => $data['cognoms'],
			'alu_correu' => $data['correu'],
			'alu_password' => md5($data['password']),
			'alu_poblacio' => $data['poblacio'],
			'alu_adreca' => $data['adreca'],
			'alu_telefon' => $data['telefon'],
			'alu_professor_nif' => $data['professor_nif'],
			'alu_desactivat' => 0,
			'alu_token' => md5(rand())
		);

		$alumne_carnet = array(
			'alu_carn_alumne_nif' => $data['nif'],
			'alu_carn_carnet_codi' => $data['carnet_codi'],
			'alu_carn_data_alta' => date('Y-m-d H:i:s'),
		);

		$this->Alumne->insert($alumne, $alumne_carnet);

		redirect('admin/GestioAlumnesController/index');
	}

	public function update()
	{
		$data = $this->input->post();

		if(strlen($data['password']) < 32 || strlen($data['password']) > 32) $password = md5($data['password']);
		else $password = $data['password'];

		$alumne = array(
			'alu_nif' => $data['nif'],
			'alu_nom' => $data['nom'],
			'alu_cognoms' => $data['cognoms'],
			'alu_correu' => $data['correu'],
			'alu_password' => $password,
			'alu_poblacio' => $data['poblacio'],
			'alu_adreca' => $data['adreca'],
			'alu_telefon' => $data['telefon'],
			'alu_professor_nif' => $data['professor_nif'],
		);

		if( ! $this->Alumne->select_carnet($data['nif'], $data['carnet_codi']))
		{
			$alumne_carnet = array(
				'alu_carn_alumne_nif' => $data['nif'],
				'alu_carn_carnet_codi' => $data['carnet_codi'],
				'alu_carn_data_alta' => date('Y-m-d h:i:s'),
			);
			$this->Alumne->update($alumne, $alumne_carnet);
			$this->session->set_flashdata('exits', '<strong>Éxito!</strong> Alumno modificado correctamente!');
		}
		else
		{
			$this->session->set_flashdata('exits', '<strong>Éxito!</strong> Alumno modificado correctamente, pero no se ha podido modificar el carnet ya que lo habia obtenido antes!');
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

	public function activar()
	{
		$nif = $this->input->post('nif');

		$this->Alumne->activar($nif);

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