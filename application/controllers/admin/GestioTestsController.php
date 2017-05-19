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
        $this->load->model('Carnet');
    }

	public function index()
	{
		$data['titol'] = 'Inici';
		$data['content'] = 'admin/gestio_tests_view';

        $data['carnets'] = $this->Carnet->select();

		$this->load->view($this->layout, $data);
	}

    public function upload()
    {
        $data = $this->input->post();

        $test = array(
            'codi' => $data['codi'],
            'nom' => $data['nom'],
            'carnet_codi' => $data['carnet'],
        );
        
        if( ! mkdir('./uploads/' . $data['codi'], 0777, true))
        {
            $error['error'] = 'Ya has subido anteriormente esta importación';

            redirect('admin/GestioTestsController/index'); exit;
        }

        $config['upload_path'] = './uploads/' . $data['codi'];
        $config['allowed_types'] = 'zip|rar';
        $config['file_name'] = $data['codi'];
    
        $this->load->library('upload', $config);

        if($this->upload->do_upload('rar-file'))
        {
            $this->load->library('zip');
            
            $filename = './uploads/' . $data['codi'] . '/' . $data['codi'] . '.zip';

            $zip = new ZipArchive;
            if($zip->open($filename))
            {
                $unzip = $zip->extractTo('./uploads/'.$data['codi']);

                if($unzip)
                {
                    $zip->close();

                    unlink($filename);

                    $this->read_csv('./uploads/'.$data['codi'].'/'.$data['codi'].'.csv', $test);
                }
                else {
                    $error['error'] = 'Error en descomprimir el fitxer al servidor.';
                }
            }
        }
    }

    private function read_csv($csv, $test)
    {
        $preguntes = array();

        // codi, pregunta, opcio_correcta, opcio_2, opcio_3, img (s/n).
        if (($handler = fopen($csv, "r")) !== FALSE) 
        {
            while($data = fgetcsv($handler, 1024, ";")) 
            {
                $linia = implode(";", $data);
                $linia = explode(";", $linia);

                if(isset($linia[0]) && isset($linia[1]) && isset($linia[2]) && isset($linia[3]) && isset($linia[4]) && isset($linia[5]))
                {
                    if(strlen($linia[0]) < 7 || strlen($linia[0]) > 7) return false;
                    if($linia[4] == 'N') $linia[4] = null;
                    if($linia[5] == 'S') $linia[5] = $linia[0].'.png';

                    $preguntes[] = array (
                        'codi' => $linia[0],
                        'pregunta' => $linia[1],
                        'opcio_correcta' => $linia[2],
                        'opcio_2' => $linia[3],
                        'opcio_3' => $linia[4],
                        'imatge' => $linia[5],
                        'test_codi' => $test['codi']
                    );
                }
            }
            fclose($handler);
            
            unlink($csv);

            $this->insert($test, $preguntes);
        }
    }

    public function insert($test, $preguntes)
    {
        $this->Test->insert_test($test, $preguntes);
    }
}
