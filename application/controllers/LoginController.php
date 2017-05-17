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

		$this->load->model('Usuari');


		if($usuari = $this->Usuari->login($data['correu'], md5($data['password'])))
		{
			$this->session->set_userdata(array('nif' => $usuari[0]['nif'], 'nom' => $usuari[0]['nom'], 'cognoms' => $usuari[0]['cognoms'], 'correu' => $usuari[0]['correu'], 'rol' => $usuari[0]['rol']));

			if($this->session->userdata('rol') == 'admin' ||$this->session->userdata('rol') == 'professor')
			{
				redirect('admin/GestioHomeController/index');
			}
			
			$carnet = $this->Usuari->carnet_actual($this->session->userdata('nif'));
			$this->session->set_userdata('carnet', $carnet[0]['carnet_codi']);

			redirect('HomeController/index');
		}
		else
		{
			$data['error'] = array(
				'login' => 'Error al iniciar sesión, datos incorrectos.'
			);
		}
	}
}