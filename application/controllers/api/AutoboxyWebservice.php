<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class AutoboxyWebservice extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
	}
	
	/*
	*	Webservice per a obtenir els resultats dels tests
	*	d'un carnet en concret d'un usuari.
	*
	*	Els paràmetres són:
	*	$carnet -> Tipus de carnet.
	*	$token -> Token de l'usuari a la base de dades.
	*/
	public function results($carnet, $token)
	{
        $this->load->model('Alumne');

		$data = array();

		if($usuari = $this->Alumne->select_where_token($token))
        {
			$data = $this->Alumne->get_tests_webservice($carnet, $usuari[0]['alu_nif']);
        }

		if($data)
		{
			echo json_encode($data);
		}
		else
		{
			echo json_encode(array('Error' => 'No se han encontrado resultados.'));
		}
	}

}