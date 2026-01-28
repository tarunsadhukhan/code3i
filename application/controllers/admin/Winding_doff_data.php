<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Winding_doff_data extends CI_Controller {

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
		$this->load->view('admin/winding_doff/winding_doff_data', $data_to_pass);	
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

	public function jugmcno1_data() {
        $mcno1 = $this->input->post('mcno1');
        $companyId = $this->input->post('companyId');
		$shiftname = $this->input->post('shiftname');
		$windingDate = $this->input->post('windingDate');
		$openclose = $this->input->post('openclose');
		$windingcDate = $this->input->post('windingcDate');
		$shiftcname = $this->input->post('shiftcname');
		$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
		$windingcDate=substr($windingcDate,6,4).'-'.substr($windingcDate,3,2).'-'.substr($windingcDate,0,2);
		
		$this->load->model('Winding_doff_Model');

		$records = $this->Winding_doff_Model->getwndprvjugarData($companyId,$mcno1,$shiftname,$windingDate,$openclose,
		$windingcDate,$shiftcname);
		$cnt=count($records);

 		$prvwt=0;
		$autoid=0;	
		$rem='';		
		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$prvwt = $record['weight']; // Use the correct key for the 'spoolwt' property
 				$autoid=$record['auto_id'];
				$rem=$record['rem'];
			}
			if ($rem=='ON') {
				$autoid=0;
			} 
 
			$response = array(
				'success' => true,
				'weight' => $prvwt ,
				'autoid' => $autoid
			);
			

		}		else {

			$response = array(
				'success' => false,
				'weight' => 0, 
				'autoid' => 0
 			 
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


	public function savewnddoff_data() {

 
			$nomcs = $this->input->post('nomcs');
			$windingDate = $this->input->post('windingDate');
			$rec_time =  date('Y-m-d H:i:s');
			$shiftName = $this->input->post('shiftName');
			$companyId = $this->input->post('companyId');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$mcno1 = $this->input->post('mcno1');
			$mcno2 = $this->input->post('mcno2');
			$mcno3 = $this->input->post('mcno3');
			$trollyNo = $this->input->post('trollyNo');
			$trollywt = $this->input->post('trollywt');
			$trollyid = $this->input->post('trollyid');
			$spoolcode = $this->input->post('spoolcode');
			$spoolwt = $this->input->post('spoolwt');
			$quality_id = $this->input->post('quality_id');
			$grosswt = $this->input->post('grosswt');
			$mc1netwt = $this->input->post('mc1netwt');
			$mc2netwt = $this->input->post('mc2netwt');
			$mc3netwt = $this->input->post('mc3netwt');
			$mc1twt=$mc1netwt+$trollywt+$spoolwt;
			$mc2twt=$mc2netwt+$trollywt+$spoolwt;
			$mc3twt=$mc3netwt+$trollywt+$spoolwt;
            $active=1;
			$entryMode='M';
			$ip = $_SERVER['REMOTE_ADDR'];
			$otherdb = $this->load->database('empmill12', TRUE); 
//nomc=1		 
//		$sql="insert into WINDING_SPELL_EB_PROD_QLTY (rec_date,spell) values ('".$windingDate."','".$shiftName."')";
//		$result = $otherdb->query($sql);
//		echo $sql;
		 $data = array(
			'rec_date' => $windingDate,
			'spell' => $shiftName,
			'quality_id' => $quality_id,
			'production' => $mc1netwt,
			'entry_date' => $rec_time,
			'update_ip' => $ip,
			'prod_kgs' => $grosswt,
			'wnd_mc_id' => $mcno1,
			'trolly_id' => $trollyid,
			'trolly_wt' => $trollywt,
			'spool_wt' => $spoolwt,		
			'gross_wt' => $mc1twt,		
			'company_id' => $companyId,
			'spool_id' => $spoolcode,
			'no_mcs' => $nomcs,
			'is_active' => $active
			// Exclude 'id' and 'updated_by' fields
		);
	//	$this->$otherdb->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
		$this->db->insert('EMPMILL12.WINDING_SPELL_EB_PROD_QLTY', $data);

//nomc=2		 
if ($nomcs>=2 ) {
$data = array(
	'rec_date' => $windingDate,
	'spell' => $shiftName,
	'quality_id' => $quality_id,
	'production' => $mc2netwt,
	'entry_date' => $rec_time,
	'update_ip' => $ip,
	'prod_kgs' => $grosswt,
	'wnd_mc_id' => $mcno2,
	'trolly_id' => $trollyid,
	'trolly_wt' => $trollywt,
	'spool_wt' => $spoolwt,		
	'gross_wt' => $mc2twt,		
	'company_id' => $companyId,
	'spool_id' => $spoolcode,
	'no_mcs' => $nomcs,
	'is_active' => $active
	// Exclude 'id' and 'updated_by' fields
);
	$this->db->insert('EMPMILL12.WINDING_SPELL_EB_PROD_QLTY', $data);
}

//nomc=3		 
if ($nomcs==3 ) {

$data = array(
	'rec_date' => $windingDate,
	'spell' => $shiftName,
	'quality_id' => $quality_id,
	'production' => $mc3netwt,
	'entry_date' => $rec_time,
	'update_ip' => $ip,
	'prod_kgs' => $grosswt,
	'wnd_mc_id' => $mcno3,
	'trolly_id' => $trollyid,
	'trolly_wt' => $trollywt,
	'spool_wt' => $spoolwt,		
	'gross_wt' => $mc3twt,		
	'company_id' => $companyId,
	'spool_id' => $spoolcode,
	'no_mcs' => $nomcs,
	'is_active' => $active
	// Exclude 'id' and 'updated_by' fields
);
		$this->db->insert('EMPMILL12.WINDING_SPELL_EB_PROD_QLTY', $data);
}

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
					


	$this->db->insert('EMPMILL12.WINDING_JUGAR_ENTRY', $data);
  
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
	
		public function updatejugdoff_data() {

 
			$rec_time =  date('Y-m-d H:i:s');
			$record_id = $this->input->post('record_id');
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
		 		'weight' => $jugarwt,
			// Exclude 'id' and 'updated_by' fields
		);
	//	$this->$otherdb->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
	 

	$this->db->where('auto_id', $record_id );
    $this->db->update('EMPMILL12.WINDING_JUGAR_ENTRY', $data);
 	
//	$otherdb->insert('WINDING_JUGAR_ENTRY', $data);
  
 
    	$data =[];
	  $response = array(
		'success' => true,
		'frameNo' => $mcno1,
		'savedata'=> 'saved'
	);
	
	$frameNo='';        
	echo json_encode($response);
	
	
		}
	
		
		


		public function get_records() {
			$date = $this->input->post('date');
			$shift = $this->input->post('shift');
			$compid = $this->input->post('companyId');
			$mcno = $this->input->post('mcno');
			$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
		//	$records = $this->Winding_doff_Model->getwndtrollyData($companyId,$trollyNo);
			$records=$this->Winding_doff_Model->getwndDoffdata($date, $shift, $compid,$mcno);
			$cnt=count($records);
	//		echo $cnt;
	//		var_dump($records);

	 
			$data = [];
			if ($cnt>0) {
				foreach ($records as $record) {
					$data[] = [
						$record['auto_id'],         // Use array notation instead of object property
						$record['doffdate'],       // Use array notation instead of object property
						$record['spell'],          // Use array notation instead of object property
						$record['mechine_name'],   // Use array notation instead of object property
						$record['gross_wt'],       // Use array notation instead of object property
						$record['trollyno'],       // Use array notation instead of object property
						$record['trolly_wt'],      // Use array notation instead of object property
						$record['spool_type'],     // Use array notation instead of object property
						$record['spool_wt'],       // Use array notation instead of object property
						$record['production'],     // Use array notation instead of object property
						$record['entry_date']      // Use array notation instead of object property
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
		
		public function deleteRecord() {
			$recordId = $this->input->post('recordId');
	//		echo $recordId;
			// Load the database library
			$otherdb = $this->load->database('empmill12', TRUE); 
			$otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
			$sql="update EMPMILL12.WINDING_SPELL_EB_PROD_QLTY set is_active=0 where auto_id=".$recordId;
			$this->db->query($sql);
		    $response = array(
				'success' => true,
				'frameNo' => $recordId,
				'savedata'=> 'Deleted'
			);
			
					echo json_encode($response);

 		}
	
		 public function mcdupdeleteRecord() {
			$recordId = $this->input->post('recordId');
	//		echo $recordId;
			// Load the database library
			$otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
			$sql="update daily_ebmc_attendance set is_active=0 where dtl_rec_id=".$recordId;
			$this->db->query($sql);
			$otherdb->query($sql);

		    $response = array(
				'success' => true,
				'frameNo' => $recordId,
				'savedata'=> 'Deleted'
			);
			
					echo json_encode($response);

 		}
	


}