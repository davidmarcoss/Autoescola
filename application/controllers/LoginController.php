<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends MY_Controller 
{

    function __construct()
    {
        parent::__construct();
		
		if($this->session->userdata)
		{
			session_destroy();
		}
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
			$this->session->set_userdata('user_data', array('nif' => $usuari[0]['nif'], 'nom' => $usuari[0]['nom'], 'cognoms' => $usuari[0]['cognoms'], 'correu' => $usuari[0]['correu']));

			if($this->session->userdata('rol'))
			{
				redirect('admin/GestioHomeController/index');
			}
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