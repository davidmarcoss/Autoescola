<?php

class MY_Controller extends CI_controller
{
    public $layout;

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
        
    }

    public function is_logged_in()
    {
        $user = $this->session->userdata('user_data');
        return isset($user);
    }
}