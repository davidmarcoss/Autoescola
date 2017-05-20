<?php

class MY_Controller extends CI_controller
{
    public $layout;
    public $per_page = 10;

    public function __construct()
    {
        parent::__construct();

        if($this->session->userdata('rol') == 'admin' || $this->session->userdata('rol') == 'professor')
        { 
            $this->layout = 'layout/admin_layout';
        }
        else
        {
            $this->layout = 'layout/alumne_layout';
        }
        $config['use_page_numbers'] = TRUE;
 		$config['first_link'] = 'Primera';
		$config['last_link'] = 'Última';
        $config["uri_segment"] = 4;
		$config['next_link'] = 'Siguiente';
		$config['prev_link'] = 'Anterior';
        //$this->output->enable_profiler(true);
    }

    public function is_logged_in()
    {
        $user = $this->session->correu;

        return isset($user);
    }

    public function logout()
    {
        session_destroy();
        
        redirect('LoginController/index');
    }
}