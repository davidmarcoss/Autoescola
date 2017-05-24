<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends MY_Controller 
{

    function __construct()
    {
        parent::__construct();
    }
	
	public function index()
	{
		$this->load->view('login_view');
	}

	public function login()
	{
		$data = $this->input->post();

		if(isset($data) && count($data) > 0)
		{
			$this->load->model('Usuari');

			if($usuari = $this->Usuari->login($data['correu'], md5($data['password'])))
			{
				if($this->session->userdata('rol') == 'admin' ||$this->session->userdata('rol') == 'professor')
				{
					$this->session->set_userdata(array('nif' => $usuari[0]['admin_nif'], 'nom' => $usuari[0]['admin_nom'], 'cognoms' => $usuari[0]['admin_cognoms'], 'correu' => $usuari[0]['admin_correu']));
					redirect('admin/GestioHomeController/index');
				}
				else
				{
					$this->session->set_userdata(array('nif' => $usuari[0]['alu_nif'], 'nom' => $usuari[0]['alu_nom'], 'cognoms' => $usuari[0]['alu_cognoms'], 'correu' => $usuari[0]['alu_correu']));
					$carnet = $this->Usuari->carnet_actual($this->session->userdata('nif'));
					$this->session->set_userdata('carnet', $carnet[0]['alu_carn_carnet_codi']);
					redirect('HomeController/index');
				}

			}
			else
			{
				$this->session->set_flashdata('errors', '<strong>Error!</strong> Los datos de inicio de sesión son incorrectos.');
			}
		}

		redirect('LoginController/index');
	}
}