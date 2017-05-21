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

	public function set_pagination($pagination_count, $url)
	{
		$this->load->library('pagination');
        
 		$config['first_link'] = 'Primera';
		$config['last_link'] = 'Última';
		$config['next_link'] = 'Siguiente';
		$config['prev_link'] = 'Anterior';
		$config['base_url'] = $url;
		$config['total_rows'] = $pagination_count;
		$config['per_page'] = $this->per_page;
        $config['num_links'] = $pagination_count;

		$this->pagination->initialize($config);
	}
}