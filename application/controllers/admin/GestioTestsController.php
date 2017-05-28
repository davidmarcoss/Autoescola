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
        $data['tests_sense_preguntes'] = $this->Test->select();
        $data['tests'] = $this->select_respostes($data['tests_sense_preguntes']);

        $this->set_pagination(count($data['tests']), base_url().'index.php/admin/GestioTestsController/index/');

		$this->load->view($this->layout, $data);
	}

    private function select_respostes($tests)
    {
        if($tests && count($tests) > 0)
        {
            foreach($tests as &$test)
            {
                $test['preguntes'] = $this->Test->select_preguntes($test['test_codi']);
            }
        }

        return $tests;
    }

    /**
    *   upload()
    *
    *   Funció que puja un arxiu .zip al servidor, després
    *   el descomprimeix, i finalment l'esborra per a llegir
    *   el .csv
    */
    public function upload()
    {
        $data = $this->input->post();

        $test = array(
            'test_codi' => $data['codi'],
            'test_nom' => $data['nom'],
            'test_tipus' => $data['tipus'],
            'test_carnet_codi' => $data['carnet'],
        );

        if( ! mkdir('./uploads/' . $data['codi'], 0777, true))
        {
            $this->session->set_flashdata('errors', '<strong>Error!</strong> No se ha podido subir la importación. Comprueba que no hayas hecho esta importación antes');

            redirect('admin/GestioTestsController/index');
        }

        $config['upload_path'] = './uploads/' . $data['codi'];
        $config['allowed_types'] = 'zip|rar';
        $config['file_name'] = $data['codi'];
    
        $this->load->library('upload', $config);

        if($this->upload->do_upload('rar-file'))
        {
            if($this->upload->data('raw_name') == $data['codi'])
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
                    else 
                    {
                        $this->session->set_flashdata('errors', '<strong>Error!</strong> No se ha podido abrir el archivo importado');

                        redirect('admin/GestioTestsController/index');
                    }
                }
            }
            else 
            {
                $this->session->set_flashdata('errors', '<strong>Error!</strong> No se ha podido abrir el archivo importado');

                redirect('admin/GestioTestsController/index');
            }
        }
    }

    /**
    *   read_csv($csv, $test)
    *
    *   Funció llegeix el fitxer .csv estaba dins del
    *   .zip que ens han pujat, juntament amb les imatges.
    *   Finalment crida a la funció insert($test, $preguntes)  
    *
    *   @param string $csv, array $test 
    */
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

                if(!empty($linia[0]) && !empty($linia[1]) && !empty($linia[2]) && !empty($linia[3]) && !empty($linia[4]) && !empty($linia[5]))
                {
                    if(strlen($linia[0]) < 7 || strlen($linia[0]) > 7) 
                    {
                        return false;
                    }
                    if($linia[4] == 'N') 
                    {
                        $linia[4] = null;
                    }
                    if($linia[5] == 'S') 
                    {
                        $linia[5] = $linia[0].'.jpg';
                    }

                    $preguntes[] = array (
                        'preg_codi' => $linia[0],
                        'preg_pregunta' => $linia[1],
                        'preg_opcio_correcta' => $linia[2],
                        'preg_opcio_2' => $linia[3],
                        'preg_opcio_3' => $linia[4],
                        'preg_imatge' => $linia[5],
                        'preg_test_codi' => $test['test_codi']
                    );
                }
                else
                {
                    $this->session->set_flashdata('errors', '<strong>Error!</strong> No se ha podido leer algún registro del fichero .csv, comprueba que los datos sean correctos.');

                    redirect('admin/GestioTestsController/index');
                }
            }

            fclose($handler);
            
            unlink($csv);

            $this->insert($test, $preguntes);
        }
    }

    /**
    *   Funció crida al mètode insert de Test
    *   per a introduïr el test importat mes totes les
    *   seves preguntes.
    *
    *   @param array $test, array $preguntes
    */
    private function insert($test, $preguntes)
    {
        if($this->Test->select_by_codi($test['test_codi']))
        {
            $this->session->set_flashdata('errors', '<strong>Error!</strong> Ya existe este test en nuestra base de datos');

            redirect('admin/GestioTestsController/index');
        }

        $this->Test->insert_test($test, $preguntes);

        $this->session->set_flashdata('exits', '<strong>Éxito!</strong> Se ha realizado la importación correctamente');

        redirect('admin/GestioTestsController/index');
    }

    public function update_pregunta()
    {
        $data = $this->input->post();

        $pregunta = array(
            'preg_codi' => $data['preg_codi'],
            'preg_pregunta' => $data['preg_pregunta'],
            'preg_opcio_correcta' => $data['preg_opcio_correcta'],
            'preg_opcio_2' => $data['preg_opcio_2'],
            'preg_opcio_3' => $data['preg_opcio_3'],
        );

        $this->Test->update_pregunta($pregunta);

        redirect('admin/GestioTestsController/index');
    }

    public function delete()
    {
        $test_codi = $this->input->post('test_codi');

        if($this->Test->delete($test_codi))
        {
            $this->session->set_flashdata('exits', '<strong>Éxito!</strong> El test se ha desactivado correctamente.');
        }
        else
        {
            $this->session->set_flashdata('errors', '<strong>Error!</strong> No se ha podido desactivar el test.');
        }

        redirect('admin/GestioTestsController/index');
    }
}
