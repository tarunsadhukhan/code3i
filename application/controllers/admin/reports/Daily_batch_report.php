<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Daily_batch_report extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	 public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'file'));
        $this->load->library('upload'); // Load the upload library
        $this->load->model('Daily_batch_report_Model');
		$this->load->model('daily_spell_drawing_entry_model');
	
    } 

	  public function index()
	{

		$company_id = $this->session->userdata('company_id');

			if (strlen($company_id)==0) { 
				redirect('admin/login/logout');
			}


		//$this->load->view('welcome_message');
	//	$data['records'] = $this->Doffdata_Model->get_all_records();
     //   $this->load->view('record_form', $data);
		
		$this->load->library('form_validation');
        $this->load->library('form_validation');
		$this->load->model('Winding_doff_Model');
     
		
		$wndmcdata=$this->daily_spell_drawing_entry_model->getwndmcnodata();
		$data['wndmcdata']=$wndmcdata;
	
		
		
		$spooldata=$this->Winding_doff_Model->getSpooldata();
		$datas['spooldata']=$spooldata;

		
		$qualitydata=$this->Winding_doff_Model->getQualitydata();
		$dataq['qualitydata']=$qualitydata;

		$data_to_pass['data'] = $data;
		$data_to_pass['datas'] = $datas;
		$data_to_pass['dataq'] = $dataq;
	

		 
	
		$this->load->view('admin/drawing/Daily_batch_report', $data_to_pass);	
	}

 
 


    public function uploadAndInsertCSV() {
        // Load the upload library
        $this->load->library('upload');
    
        // Define upload configuration
        $config['upload_path']   = 'C:\xampp\htdocs\devcode3i\uploads';
        $config['allowed_types'] = 'csv'; // Allowed file types
        $config['max_size']      = 1024 * 10; // Maximum file size (in kilobytes)
    
        $this->upload->initialize($config);
    
        $files = $_FILES['csv_files'];
        
        foreach ($files['name'] as $key => $name) {
            $_FILES['csv_file']['name']     = $files['name'][$key];
            $_FILES['csv_file']['type']     = $files['type'][$key];
            $_FILES['csv_file']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['csv_file']['error']    = $files['error'][$key];
            $_FILES['csv_file']['size']     = $files['size'][$key];
    
            if ($this->upload->do_upload('csv_file')) {
                $upload_data = $this->upload->data();
                $file_path   = 'C:\xampp\htdocs\devcode3i\uploads\\' . $upload_data['file_name'];
    
                // Read CSV file and insert data into MySQL table
                $this->load->model('Daily_batch_report_Model');
                $this->Daily_batch_report_Model->insertCSVData($file_path);
            } else {
                // Handle upload errors if any
                echo "Error uploading file: " . $this->upload->display_errors();
            }
        }
    
        echo "CSV files uploaded and data inserted into MySQL table successfully.";
    }
    
 

 
 
 
 		
 			
         

}