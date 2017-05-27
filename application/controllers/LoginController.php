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
					// Refrescar token a l'alumne.
					$this->load->model('Alumne');
					$this->Alumne->update_token($usuari[0]['alu_nif']);

					$this->session->set_userdata(array('nif' => $usuari[0]['alu_nif'], 'nom' => $usuari[0]['alu_nom'], 'cognoms' => $usuari[0]['alu_cognoms'], 'correu' => $usuari[0]['alu_correu']));
					
					// Assignem el carnet actual a l'alumne.
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

	public function request_mail()
	{
		$this->load->view('change_pass_view');
	}

	public function do_change_pass()
	{
		$token = $this->input->get('token');

		$this->load->model('Alumne');

		if($usuari = $this->Alumne->select_where_token($token))
		{
			$data['usuari'] = $usuari;

			$this->load->view('change_pass_view', $data);
		}
	}

	public function update_password()
	{
		$data = $this->input->post();

		$this->load->model('Alumne');
		
		if($this->Alumne->update_password($data['correu'], md5($data['password'])))
		{
			$this->session->set_flashdata('exits', '<strong>Éxito!</strong> Contraseña modificada correctamente!');
		}
		else
		{
			$this->session->set_flashdata('errors', '<strong>Error!</strong> No se ha podido modificar la contraseña!');
		}

		redirect('LoginController/index');
	}

	public function send_mail()
	{
		$correu = $this->input->post('correu');

		$this->load->model('Alumne');
		if($usuari = $this->Alumne->select_where_correu($correu))
		{
			$this->load->library("email");

			$config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_user' => 'david96marcos@gmail.com',
				'smtp_pass' => 'M4rcos46',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'newline' => "\r\n"
			);

			$this->email->initialize($config);

			$this->email->from('david96marcos@gmail.com');
			$this->email->to($correu);
			$this->email->subject('Autoboxy - Recuperación de contraseña');

			$link = site_url() . '/LoginController/do_change_pass?token='.$usuari[0]['alu_token'];
			$this->email->message(
			'<html>
				<head>
					<title>Cambia tu contraseña de Autoboxy</title>
				</head>
				<body>
				<p>
					<strong>Hemos recibio una solicitud de cambio de contraseña. Puedes pinchar el siguiente enlace para proceder al cambio de contraseña.</strong><br>
					<br/><br/>
					<a href='.$link.'> Cambio de contraseña </a>
				</p>
				</body>
			</html>'
			);

			$this->email->send();

			// Missatge de satisfacció..
		}
		else
		{
			// Missatge d'error...
		}

		redirect('LoginController/index');
	}
}