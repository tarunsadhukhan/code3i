<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Winding_quality_wise_report extends CI_Controller {

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
		$this->load->database('db2');
		$this->load->model('Winding_doff_Model');
        $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
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
		$this->load->model('Winding_doff_Model');
     
		
		$wndmcdata=$this->Winding_doff_Model->getwndmcnodata();
		$data['wndmcdata']=$wndmcdata;
	
		
		
		$spooldata=$this->Winding_doff_Model->getSpooldata();
		$datas['spooldata']=$spooldata;
	
		$qualitydata=$this->Winding_doff_Model->getQualitydata();
		$dataq['qualitydata']=$qualitydata;

		$data_to_pass['data'] = $data;
		$data_to_pass['datas'] = $datas;
		$data_to_pass['dataq'] = $dataq;
	

	//	var_dump($dataq);

//		$this->load->view('admin/winding_doff/winding_doff_data',$data,$dataq);
		$this->load->view('admin/reports/Winding_quality_wise_report', $data_to_pass);	
	}

 
	public function mcno1_data() {
        $mcno1 = $this->input->post('mcno1');
        $companyId = $this->input->post('companyId');
		$this->load->model('Winding_doff_Model');
		$records = $this->Winding_doff_Model->getwndprvDoffData($companyId,$mcno1);
		$cnt=count($records);
	//	echo 'no record-'. $cnt;

 		$bwt=0;
			
		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$splwt = $record['spoolwt']; // Use the correct key for the 'spoolwt' property
				$trlwt = $record['trollywt']; // Use the correct key for the 'trollywt' property
				$qualityid = $record['quality_id']; // Use the correct key for the 'quality_id' property
				$spool_id = $record['spool_id']; // Use the correct key for the 'spool_id' property
				$trolly_id = $record['trolly_id']; // Use the correct key for the 'trolly_id' property
				$trollyno = $record['trollyno']; //
				$mcid = $record['mechine_id']; //
				
			}
			$response = array(
				'success' => true,
				'trollyWt' => $trlwt,
				'spoolwt' => $splwt,
				'qualityid' => $qualityid,
				'spool_id' => $spool_id,
				'trolly_id' => $trolly_id,
				'trollyno' => $trollyno,
				'mcid' => $mcid
 			 
			);
			

		}		else {

			$response = array(
				'success' => false,
				'trollyWt' => 0,
				'spoolwt' => 0,
				'qualityid' => 0,
				'spool_id' => 0,
				'trolly_id' => 0,
				'trollyno' => '',
				'mcid' => 0
 			 
			);
			

		}	
		
 


        echo json_encode($response);
    }

	public function mcno1_jugardata() {
        $mcno1 = $this->input->post('mcno1');
        $companyId = $this->input->post('companyId');
		$jugarshiftName = $this->input->post('jugarshiftName');
		$windingjugarDate = $this->input->post('windingjugarDate');
		$openclose = $this->input->post('openclose');
		$windingjugarDate=substr($windingjugarDate,6,4).'-'.substr($windingjugarDate,3,2).'-'.substr($windingjugarDate,0,2);


		$this->load->model('Winding_doff_Model');
		$records = $this->Winding_doff_Model->getjugarData($companyId,$mcno1,$jugarshiftName,$windingjugarDate,$openclose);
		$cnt=count($records);
	//	echo 'no record-'. $cnt;
	$jweight=0;
 		$bwt=0;
			
		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$jweight = $record['WEIGHT']; // Use the correct key for the 'spoolwt' property
 			}
			$response = array(
				'success' => false,
				'jweight' => $jweight
	 		 
			);

		}		else {

			$response = array(
				'success' => true,
				'jweight' => 0
  			 
			);
			

		}	
		
 


        echo json_encode($response);
    }
	


	public function mcno2_data() {
        $mcno2 = $this->input->post('mcno2');
        $companyId = $this->input->post('companyId');
		$this->load->model('Winding_doff_Model');
		$records = $this->Winding_doff_Model->getwndmc2Data($companyId,$mcno2);
		$cnt=count($records);
	//	echo 'no record-'. $cnt;

 		$bwt=0;
			
		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$mcid = $record['mechine_id']; // Use the correct key for the 'spoolwt' property
 			}
			$response = array(
				'success' => true,
				'mcid' => $mcid
  			 
			);
			

		}		else {

			$response = array(
				'success' => false,
				'mcid' => 0
  			 
			);
			

		}	
		
        echo json_encode($response);
    }

	public function trolly_data() {
        $trollyNo = $this->input->post('trollyNo');
        $companyId = $this->input->post('companyId');
		$this->load->model('Winding_doff_Model');
		$records = $this->Winding_doff_Model->getwndtrollyData($companyId,$trollyNo);
		$cnt=count($records);
		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$trlwt = $record['trolly_weight']; // Use the correct key for the 'spoolwt' property
				$trlid = $record['trollyid']; // Use the correct key for the 'spoolwt' property
				
 			}
			$response = array(
				'success' => true,
				'trollyWt' => $trlwt,
				'trollyid' => $trlid
  			 
			);
		}		else {

			$response = array(
				'success' => false,
				'trollyWt' => 0,
				'trollyid' => 0
  			 
			);
			

		}	
		
        echo json_encode($response);
    }

	public function spool_data() {
        $spoolcode = $this->input->post('spoolcode');
        $companyId = $this->input->post('companyId');
		$this->load->model('Winding_doff_Model');
		$records = $this->Winding_doff_Model->getwndspoolData($companyId,$spoolcode);
		$cnt=count($records);
		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$splwt = $record['trolly_weight']; // Use the correct key for the 'spoolwt' property
 			}
			$response = array(
				'success' => true,
				'spoolwt' => $splwt
  			 
			);
		}		else {

			$response = array(
				'success' => false,
				'spoolwt' => 0
  			 
			);
			

		}	
		
        echo json_encode($response);
    }


	public function savewndqc_data() {

 
 			$windingDate = $this->input->post('windingqcDate');
			$rec_time =  date('Y-m-d H:i:s');
			$shiftName = $this->input->post('qcshiftName');
			$companyId = $this->input->post('companyId');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$mcno1 = $this->input->post('mcno1');
	 		$nospool = $this->input->post('nospool');
			$quality_id = $this->input->post('quality_id');
			$record_id = $this->input->post('record_id');
            $active=1;
			$entryMode='M';
			$ip = $_SERVER['REMOTE_ADDR'];
			$otherdb = $this->load->database('empmill12', TRUE); 
		 $data = array(
			'quality_id' => $quality_id,
			'update_ip' => $ip,
 			'wnd_mc_id' => $mcno1,
			'no_of_spindle' => $nospool,		
		);
	//	$this->$otherdb->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
//echo $record_id;
    $otherdb->where('auto_id', $record_id );
    $otherdb->update('WINDING_DAILY_SPELL_EB', $data);
  //  echo $otherdb->last_query();
  $otherdb->close();

  
	$data =[];
	  $response = array(
		'success' => true,
		'frameNo' => $mcno1,
		'savedata'=> 'saved'
	);
	
	$frameNo='';        
	echo json_encode($response);
	
	
		}

		public function savejugdoff_data() {

 
			$rec_time =  date('Y-m-d H:i:s');
			$windingDate = $this->input->post('windingjugarDate');
			$shiftName = $this->input->post('jugarshiftName');
			$companyId = $this->input->post('companyId');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$mcno1 = $this->input->post('mcno1');
			$openclose = $this->input->post('openclose');
			$jugarwt = $this->input->post('jugarwt');
            $active=1;
			$entryMode='M';
			$ip = $_SERVER['REMOTE_ADDR'];
			$otherdb = $this->load->database('empmill12', TRUE); 
			 $data = array(
			'tran_date' => $windingDate,
			'spell' => $shiftName,
	 		'weight' => $jugarwt,
			'update_ip' => $ip,
			'entry_date' => $rec_time,
			'wnd_mc_id' => $mcno1,
			'open_close' => $openclose,
			'company_id' => $companyId,
			'is_active' => $active
			// Exclude 'id' and 'updated_by' fields
		);
	//	$this->$otherdb->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
		$otherdb->insert('WINDING_JUGAR_ENTRY', $data);

 
 
    	$data =[];
	  $response = array(
		'success' => true,
		'frameNo' => $mcno1,
		'savedata'=> 'saved'
	);
	
	$frameNo='';        
	echo json_encode($response);
	
	
		}
	
		


		public function get_wndreprecords() {
			$date = $this->input->post('date');
			$shift = $this->input->post('shift');
			$compid = $this->input->post('companyId');
			
            $date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
			$data = [];
	
			
			$records = $this->Winding_doff_Model->get_wndreprecords($date, $shift, $compid);
//			$data=$this->Winding_doff_Model->getfinishalldata($date,$compid);
			$cnt=count($records);
	 
			if ($cnt>0) {
				foreach ($records as $record) {
					$data[] = [
						        // Use array notation instead of object property
						$record['rec_date'],       // Use array notation instead of object property
						$record['spell'],          // Use array notation instead of object property
						$record['mechine_name'],   // Use array notation instead of object property
						$record['eb_no'],       // Use array notation instead of object property
						$record['quality'],      // Use array notation instead of object property
						$record['prod'],       // Use array notation instead of object property
						$record['whrs'],     // Use array notation instead of object property
						$record['no_of_spindle'],     // Use array notation instead of object property
						
					];
				}
		}
	
		// Return the response
			echo json_encode(['data' => $data]);
		}

		public function get_attwndchkrecords() {
			$date = $this->input->post('date');
			$shift = $this->input->post('shift');
			$compid = $this->input->post('companyId');
			
            $date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
			$data = [];
	
			
			$records = $this->Winding_doff_Model->get_attwndchkrecords($date, $shift, $compid);
//			$data=$this->Winding_doff_Model->getfinishalldata($date,$compid);
			$cnt=count($records);
	 
			if ($cnt>0) {
				foreach ($records as $record) {
					$data[] = [
						        // Use array notation instead of object property
						$record['rec_date'],       // Use array notation instead of object property
						$record['spell'],          // Use array notation instead of object property
						$record['mechine_name'],   // Use array notation instead of object property
						$record['eb_no'],       // Use array notation instead of object property
						$record['quality'],      // Use array notation instead of object property
						$record['prod'],       // Use array notation instead of object property
						$record['whrs'],     // Use array notation instead of object property
						$record['no_of_spindle'],     // Use array notation instead of object property
						
					];
				}
		}
	
		// Return the response
			echo json_encode(['data' => $data]);
		}


		public function get_wnduprecords() {
			$date = $this->input->post('windingrepDate');
			$shift = $this->input->post('repshiftName');
			$compid = $this->input->post('companyId');

            $date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
			$records = $this->Winding_doff_Model->get_wnduprecords($date, $shift, $compid);
			$cnta=0;

			$cnt = $this->Winding_doff_Model->getCount(); 
 //			$cnta=count($records);
		//	echo $cnta;
			$data = [];
			if ($cnt>0) {
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$splwt = $record['mech_code']; // Use the correct key for the 'spoolwt' property
 			}
			 $response = array(
				'success' => false,
				'savedata'=> 'Data Not Updated --'.$splwt . '-Duplicate Mc No'
			);

			}	else {
				$response = array(
					'success' => true,
					'savedata'=> 'Data Updated'
				);
			}
			
			
			$frameNo='';        
			echo json_encode($response);
				}




		public function get_wndqcrecords() {
			$date = $this->input->post('date');
			$shift = $this->input->post('shift');
			$compid = $this->input->post('companyId');
			
			$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
		//	$records = $this->Winding_doff_Model->getwndtrollyData($companyId,$trollyNo);
			$records=$this->Winding_doff_Model->getwndqcrecorddata($date, $shift, $compid);
			$cnt=count($records);
	//		echo $cnt;
	//		var_dump($records);

	 
			$data = [];
			if ($cnt>0) {
				foreach ($records as $record) {
					$data[] = [
						$record['auto_id'],         // Use array notation instead of object property
						$record['tran_date'],       // Use array notation instead of object property
						$record['spell'],          // Use array notation instead of object property
						$record['wnd_mc_id'],   // Use array notation instead of object property
						$record['mechine_name'],   // Use array notation instead of object property
						$record['quality_id'],       // Use array notation instead of object property
						$record['quality'],       // Use array notation instead of object property
                        $record['no_of_spindle'],       // Use array notation instead of object property
                    ];
				}
		}
			// Return the response
			echo json_encode(['data' => $data]);
		}



		public function get_jugarrecords() {
			$date = $this->input->post('date');
			$shift = $this->input->post('shift');
			$compid = $this->input->post('companyId');
			$mcno = $this->input->post('mcno');
			$openclose = $this->input->post('openclose');
	//		echo $date;
			$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
		//	$records = $this->Winding_doff_Model->getwndtrollyData($companyId,$trollyNo);
			$records=$this->Winding_doff_Model->getjugDoffdata($date, $shift, $compid,$openclose);
			$cnt=count($records);
	//		echo $cnt;
	//		var_dump($records);

	 
			$data = [];
			if ($cnt>0) {
				foreach ($records as $record) {
					$data[] = [
						$record['AUTO_ID'],         // Use array notation instead of object property
						$record['doffdate'],       // Use array notation instead of object property
						$record['SPELL'],          // Use array notation instead of object property
						$record['mechine_name'],   // Use array notation instead of object property
						$record['OPEN_CLOSE'],       // Use array notation instead of object property
						$record['WEIGHT'],       // Use array notation instead of object property
						$record['WND_MC_ID'],       // Use array notation instead of object property
					 				];
				}
		}
			// Return the response
			echo json_encode(['data' => $data]);
		}

        
        public function getwndqcode_data() {
            $doffdate = $this->input->post('windingqcDate');
            $doffshift = $this->input->post('qcshiftName');
            $companyId = $this->input->post('companyId');
            $created_by=26577;
            $active=1;
            $doffdate=substr($doffdate,6,4).'-'.substr($doffdate,3,2).'-'.substr($doffdate,0,2);
            $this->load->model('Winding_doff_Model');
            $records = $this->Winding_doff_Model->getwndqcData($companyId,$doffdate,$doffshift);
//            echo $records;
            
     
    $response = array(
        'success' => true,
        'doffdate' => $doffdate,
        'savedata'=> $records
    );
    
            echo json_encode($response);
    
    
    }
    
    
	public function exportdbfdata() {
		$date = $this->input->get('date');
		$compid = $this->input->get('companyId');
		$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
		//echo $date;
		$data=$this->Winding_doff_Model->getfinishalldata($date,$compid);
		$jsonData = json_encode($data, JSON_PRETTY_PRINT);

		// Define the JSON file name
		$jsonFileName = 'wnddata.json';
		
		// Write JSON data to the file
		file_put_contents($jsonFileName, $jsonData);
		
		// Create a new ZipArchive instance
		$zip = new ZipArchive();
		
		// Define the zip file name
		$zipFileName = 'wndata.zip';
		
		// Create the zip file
		if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
			// Add the JSON file to the zip
			$zip->addFile($jsonFileName, $jsonFileName);
		
			// Close the zip archive
			$zip->close();
		
			// Set appropriate headers for zip file download
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
			header('Content-Length: ' . filesize($zipFileName));
		
			// Output the zip file content
			readfile($zipFileName);
		
			// Clean up: Delete the temporary JSON and zip files
			unlink($jsonFileName);
			unlink($zipFileName);
		} else {
			echo "Failed to create zip file.";
		}
				 
		
	
	/*
	
	
		$jsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Define the file path to save the JSON file temporarily
    $tempJsonFilePath = FCPATH. 'vowwnd_data.json'; // Change 'temp_data.json' to your desired file name and path





	$txt4= $tempJsonFilePath;
    
    $files = array($txt4);

    $zipname = 'wnddata.zip';
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    foreach ($files as $file) {
      $zip->addFile($file);
    }
    $zip->close();
    
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$zipname);
    header('Content-Length: ' . filesize($zipname));
    readfile($zipname);
    
//            unlink($fileContainerhm);
            unlink( $tempJsonFilePath);
             unlink($zipname);
*/  
/*
if (file_put_contents($tempJsonFilePath, $jsonData)) {
        // Set appropriate headers for file download
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename='.$tempJsonFilePath);
        header('Content-Length: ' . filesize($tempJsonFilePath));

        // Output the file content
        readfile($tempJsonFilePath);

        // Delete the temporary file
    //    unlink($tempJsonFilePath);
    } else {
        echo "Failed to create JSON file.";
    }
*/
		
	
	   exit();
	 
	}
	   
    


}