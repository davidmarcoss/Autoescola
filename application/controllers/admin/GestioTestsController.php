<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class GestioTestsController extends MY_Controller {

    function __construct()
    {
        parent::__construct();
		
        if ( ! $this->is_logged_in())
        {
            redirect('LoginController/index');
        }

        $this->load->model('Test');
    }

	public function index()
	{
		$data['titol'] = 'Inici';
		$data['content'] = 'admin/gestio_tests_view';

		$this->load->view($this->layout, $data);
	}

    public function insert_test()
    {
        $data = $this->input->post();
        
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'zip|rar';
        $config['file_name'] = $data['codi'];

        $this->load->library('upload', $config);

        $this->upload->do_upload('rar-file');

        $filename = $data['codi'];
        $filepath = './uploads/';


        $this->load->library('zip');

        $zip = new ZipArchive;
         $res = $zip->open($filepath.$filename); 
         var_dump($res); exit;

    }

}
