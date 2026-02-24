<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;



class Daily_vowdata_transfer extends CI_Controller {

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
		$this->load->model('daily_spell_drawing_entry_model');
	//	$this->load->model('Daily_vowdata_transfer');
		
	
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
     
		
		$wndmcdata=$this->daily_spell_drawing_entry_model->getdeptdata();
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
		$this->load->view('admin/reports/daily_vowdata_transfer', $data_to_pass);	
	}

 
	public function mcno1_data() {
        $mcno1 = $this->input->post('mcno1');
        $companyId = $this->input->post('companyId');
		$shiftName = $this->input->post('shiftName');
		$windingDate = $this->input->post('windingDate');
		$this->load->model('Winding_doff_Model');
		$records = $this->daily_spell_drawing_entry_model->getwndprvDoffData($companyId,$mcno1,$windingDate,$shiftName);
		$cnt=count($records);
 		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$constmtr = $record['const_meter']; // Use the correct key for the 'spoolwt' property
				$openmtr = $record['close_meter']; // Use the correct key for the 'trollywt' property
			 	
			}
			$response = array(
				'success' => true,
				'constmtr' => $constmtr,
				'openmtr' => $openmtr
  			 
			);
			

		}		else {

			$response = array(
				'success' => false,
				'constmtr' => 0,
				'openmtr' => 0
 			 
			);
			

		}	
		
 


        echo json_encode($response);
    }
	public function sprdmcno1_data() {
        $mcno1 = $this->input->post('mcno1');
        $companyId = $this->input->post('companyId');
		$shiftName = $this->input->post('shiftName');
		$windingDate = $this->input->post('windingDate');
		$this->load->model('Winding_doff_Model');
		$records = $this->daily_spell_drawing_entry_model->getsprdprvDoffData($companyId,$mcno1,$windingDate,$shiftName);
		$cnt=count($records);
 		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$constmtr = $record['const_meter']; // Use the correct key for the 'spoolwt' property
				$openmtr = $record['close_meter']; // Use the correct key for the 'trollywt' property
			 	
			}
			$response = array(
				'success' => true,
				'constmtr' => $constmtr,
				'openmtr' => $openmtr
  			 
			);
			

		}		else {

			$response = array(
				'success' => false,
				'constmtr' => 0,
				'openmtr' => 0
 			 
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





	public function get_drgedit_data() {
        $mcno1 = $this->input->post('mcno1');
        $companyId = $this->input->post('companyId');
		$shiftName = $this->input->post('shiftName');
		$windingDate = $this->input->post('windingDate');
//		echo $windingDate;
		$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
//echo $windingDate;
		$this->load->model('daily_spell_drawing_entry_model');
		$records = $this->daily_spell_drawing_entry_model->getdrgeditData($companyId,$mcno1,$shiftName,$windingDate);
		$cnt=count($records);
		$hrs1=0;
		$hrs2=0;
		$opmtr=0;
		$clmtr1=0;
		$clmtr2=0;
		$rem='';
		$dfm1=0;
		$dfm2=0;
		$eff=0;
//		echo $shiftName;

		if (count($records) > 0) {			
			foreach ($records as $record) {
				if ($shiftName=='C') {
					$opmtr=$record['open_meter'];		
					$hrs1=$record['wrk_hours'];
					$clmtr1=$record['close_meter'];				
					$rem=$record['remarks'];	
					$dfm1=$record['diff_meter'];		
					$eff=$record['actual_eff'];		
				} else  {
					$spp=substr($record['spell'],1,1);
//echo 'no spl-'. $spp;
					if ($spp==1) {
						$opmtr=$record['open_meter'];
						$hrs1=$record['wrk_hours'];
						$clmtr1=$record['close_meter'];				
						$rem=$record['remarks'];				
						$dfm1=$record['diff_meter'];		
					}
					if ( $spp ==2) {
						$hrs2=$record['wrk_hours'];
						$clmtr2=$record['close_meter'];
						$rem=$record['remarks'];
						$dfm2=$record['diff_meter'];		
					}
				}

			}	
				}
			
	$response = array(
	'success' => true,
	'hrs1'=> $hrs1,
	'hrs2'=> $hrs2,
	'opmtr'=> $opmtr,
	'clmtr1'=> $clmtr1,
	'clmtr2'=> $clmtr2,
	'rem'=> $rem,
	'dfm1'=> $dfm1,
	'dfm2'=> $dfm2
 
);

//var_dump ($response);
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
			$windingDate = $this->input->post('windingDate');
			$shiftName = $this->input->post('shiftName');
			$companyId = $this->input->post('companyId');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$mcno1 = $this->input->post('mcno1');
			$clmeter1 = $this->input->post('clmeter1');
			$clmeter2 = $this->input->post('clmeter2');
			$opmeter = $this->input->post('opmeter');
			$cmeter = $this->input->post('cmeter');
			$splhrs1 = $this->input->post('splhrs1');
			$splhrs2 = $this->input->post('splhrs2');
			$remarks = $this->input->post('remarks');
			$dfmeter1=$clmeter1-$opmeter;
			if ($opmeter>$clmeter1) {
				$dfmeter1=($clmeter1+10000)-$opmeter;
			}
			$dfmeter2=$clmeter2-$clmeter1;
			if ($clmeter1>$clmeter2) {
				$dfmeter2=($clmeter2+10000)-$clmeter1;
			}

			$eff1=$eff2=0;
			if ($dfmeter1>0 ) {   
				$eff1=round($dfmeter1/$cmeter/8*$splhrs1,2); 
			}
			if ($dfmeter2>0 ) {   
				$eff2=round($dfmeter2/$cmeter/8*$splhrs2,2); 
			}
			$active=1;
			$entryMode='M';
			if ($shiftName<>'C') {
				$spell1=$shiftName.'1';
				$spell2=$shiftName.'2';
			}
			if ($shiftName=='C') {
				$spell1=$shiftName;
				$spell2='';
			}
			$ip = $_SERVER['REMOTE_ADDR'];
			 $data = array(
			'tran_date' => $windingDate,
			'spell' => $spell1,
			'drg_mc_id' => $mcno1,
			'open_meter' => $opmeter,
			'close_meter' => $clmeter1,
			'diff_meter' => $dfmeter1,
			'actual_eff' => $eff1,
			'wrk_hours' => $splhrs1,
			'is_active' => $active,
			'const_meter' => $cmeter,
			'remarks' => $remarks,		
			'company_id' => $companyId,		
		);
	//	$this->db->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
		$this->db->insert('EMPMILL12.daily_drawing_transaction', $data);

//nomc=2		 
if ($shiftName<>'C') {
	$data = array(
		'tran_date' => $windingDate,
		'spell' => $spell2,
		'drg_mc_id' => $mcno1,
		'open_meter' => $clmeter1,
		'close_meter' => $clmeter2,
		'diff_meter' => $dfmeter2,
		'actual_eff' => $eff2,
		'wrk_hours' => $splhrs2,
		'is_active' => $active,
		'const_meter' => $cmeter,
		'remarks' => $remarks,		
		'company_id' => $companyId,		
	);
//	$this->db->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
	$this->db->insert('EMPMILL12.daily_drawing_transaction', $data);
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

		public function savesprddoff_data() {
			$windingDate = $this->input->post('windingDate');
			$shiftName = $this->input->post('shiftName');
			$companyId = $this->input->post('companyId');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$mcno1 = $this->input->post('mcno1');
			$clmeter1 = $this->input->post('clmeter1');
			$actroll = $this->input->post('actroll');
			$opmeter = $this->input->post('opmeter');
			$cmeter = $this->input->post('cmeter');
			$splhrs1 = $this->input->post('splhrs1');
			$remarks = $this->input->post('remarks');
			$dfmeter1=$clmeter1-$opmeter;
			if ($opmeter>$clmeter1) {
				$dfmeter1=($clmeter1+1000000)-$opmeter;
			}

			$eff1=$eff2=0;
			if ($dfmeter1>0 ) {   
				$eff1=floor($dfmeter1/$cmeter); 
			}
			$active=1;
			$entryMode='M';
 			$ip = $_SERVER['REMOTE_ADDR'];
			 $data = array(
			'tran_date' => $windingDate,
			'spell' => $shiftName,
			'drg_mc_id' => $mcno1,
			'open_meter' => $opmeter,
			'close_meter' => $clmeter1,
			'diff_meter' => $dfmeter1,
			'actual_eff' => $eff1,
			'wrk_hours' => $splhrs1,
			'is_active' => $active,
			'const_meter' => $cmeter,
			'actual_prod' => $actroll,		
			'remarks' => $remarks,		
			'company_id' => $companyId,		
		);
	//	$this->db->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
		$this->db->insert('EMPMILL12.daily_drawing_transaction', $data);

//nomc=2
  
	$data =[];
	  $response = array(
		'success' => true,
		'frameNo' => $mcno1,
		'savedata'=> 'saved'
	);
	
	$frameNo='';        
	echo json_encode($response);
	
	
		}

			 
		public function updatewnddoff_data() {
			$windingDate = $this->input->post('windingDate');
			$shiftName = $this->input->post('shiftName');
			$companyId = $this->input->post('companyId');
			$record_id = $this->input->post('record_id');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$mcno1 = $this->input->post('mcno1');
			$clmeter1 = $this->input->post('clmeter1');
			$clmeter2 = $this->input->post('clmeter2');
			$opmeter = $this->input->post('opmeter');
			$cmeter = $this->input->post('cmeter');
			$splhrs1 = $this->input->post('splhrs1');
			$splhrs2 = $this->input->post('splhrs2');
			$remarks = $this->input->post('remarks');
			$dfmeter1=$clmeter1-$opmeter;
			if ($opmeter>$clmeter1) {
				$dfmeter1=($clmeter1+10000)-$opmeter;
			}
			$dfmeter2=$clmeter2-$clmeter1;
			if ($clmeter1>$clmeter2) {
				$dfmeter2=($clmeter2+10000)-$clmeter1;
			}

			$eff1=$eff2=0;
			if ($dfmeter1>0 ) {   
				$eff1=round($dfmeter1/$cmeter/8*$splhrs1,2); 
			}
			if ($dfmeter2>0 ) {   
				$eff2=round($dfmeter2/$cmeter/8*$splhrs2,2); 
			}
			$active=1;
			$entryMode='M';
			if ($shiftName<>'C') {
				$spell1=$shiftName.'1';
				$spell2=$shiftName.'2';
			}
			if ($shiftName=='C') {
				$spell1=$shiftName;
				$spell2='';
			}
			$ip = $_SERVER['REMOTE_ADDR'];
			 $data = array(
			'tran_date' => $windingDate,
			'spell' => $spell1,
			'drg_mc_id' => $mcno1,
			'open_meter' => $opmeter,
			'close_meter' => $clmeter1,
			'diff_meter' => $dfmeter1,
			'actual_eff' => $eff1,
			'wrk_hours' => $splhrs1,
			'is_active' => $active,
			'const_meter' => $cmeter,
			'remarks' => $remarks,		
			'company_id' => $companyId,		
		);
	//	$this->db->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
	$this->db->where('drg_tran_id', $record_id);	
	$this->db->update('EMPMILL12.daily_drawing_transaction', $data);

 
	$data =[];
	  $response = array(
		'success' => true,
		'frameNo' => $mcno1,
		'savedata'=> 'saved'
	);
	
	$frameNo='';        
	echo json_encode($response);
	
	
		}

		 
 		
		
		
		public function get_sprd_records() {
			$date = $this->input->post('date');
			$shift = $this->input->post('shift');
			$compid = $this->input->post('companyId');
			$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
			$records=$this->daily_spell_drawing_entry_model->getsprdDoffdata($date, $shift, $compid);
			$cnt=count($records);
	//		echo $cnt;
	//		var_dump($records);

 	
			$data = [];
			if ($cnt>0) {
				foreach ($records as $record) {
					$nrol=floor($record['diff_meter']/$record['const_meter']);
					$drol=floor($record['diff_meter']/$record['const_meter'])-$record['actual_prod'];
					$data[] = [
						$record['drg_tran_id'],         // Use array notation instead of object property
						$record['tran_date'],       // Use array notation instead of object property
						$record['spell'],          // Use array notation instead of object property
						$record['mech_code'],   // Use array notation instead of object property
						$record['mechine_name'],       // Use array notation instead of object property
						$record['const_meter'],       // Use array notation instead of object property
						$record['open_meter'],      // Use array notation instead of object property
						$record['close_meter'],     // Use array notation instead of object property
						$record['diff_meter'], 
						$nrol, 
						$record['actual_prod'],     // Use array notation instead of object property
						$drol, 
						$record['wrk_hours'],      // Use array notation instead of object property
						$record['remarks'],      // Use array notation instead of object property
						$record['drg_mc_id']      // Use array notation instead of object property
					];
				}
		}
			// Return the response
			echo json_encode(['data' => $data]);
		}

		public function get_records() {
			$date = $this->input->post('date');
			$shift = $this->input->post('shift');
			$compid = $this->input->post('companyId');
			$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
			$records=$this->daily_spell_drawing_entry_model->getwndDoffdata($date, $shift, $compid);
			$cnt=count($records);
	//		echo $cnt;
	//		var_dump($records);

 	
			$data = [];
			if ($cnt>0) {
				foreach ($records as $record) {
					$data[] = [
						$record['drg_tran_id'],         // Use array notation instead of object property
						$record['tran_date'],       // Use array notation instead of object property
						$record['spell'],          // Use array notation instead of object property
						$record['mech_code'],   // Use array notation instead of object property
						$record['mechine_name'],       // Use array notation instead of object property
						$record['const_meter'],       // Use array notation instead of object property
						$record['open_meter'],      // Use array notation instead of object property
						$record['close_meter'],     // Use array notation instead of object property
						$record['diff_meter'],       // Use array notation instead of object property
						$record['actual_eff'],     // Use array notation instead of object property
						$record['wrk_hours'],      // Use array notation instead of object property
						$record['remarks'],      // Use array notation instead of object property
						$record['drg_mc_id']      // Use array notation instead of object property
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
	
		public function exphnddata() {
			$sdate = $this->input->post('payrollstartdate');
			$compid = $this->input->post('companyId');
			$sdate = $this->input->get('payrollstartdate');
			$compid = $this->input->get('companyId');
			$deptid = $this->input->get('mc_no1');
            $shiftName = $this->input->get('shiftName');
            $transName = $this->input->get('transName');
			$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
			$sql = "SELECT
			dept_code,
			date_format(attendance_date,'%d/%m/%Y') attendance_date,
			MAX(CASE WHEN shift = 'A' THEN whnd ELSE 0 END) AS sft_a,
			MAX(CASE WHEN shift = 'B' THEN whnd ELSE 0 END) AS sft_b,
			MAX(CASE WHEN shift = 'C' THEN whnd ELSE 0 END) AS sft_c
		FROM (
			SELECT
				dept_code,
				attendance_date,
				shift,
				SUM(whrs) AS whrs,
				SUM(nhrs) AS nhrs,
				ROUND(SUM(whrs + nhrs) / 8, 2) AS whnd
			FROM (
				SELECT
					dept_code,
					attendance_date,
					SUBSTRING(spell, 1, 1) AS shift,
					(working_hours - idle_hours) AS whrs,
					CASE
						WHEN (da.attendance_type = 'R' AND (working_hours - idle_hours) = 7.5 AND spell = 'C') THEN 0.5
						ELSE 0
					END AS nhrs
				FROM
					daily_attendance da
				LEFT JOIN
					department_master dm ON dm.dept_id = da.worked_department_id
				WHERE
					da.attendance_date = '".$sdate."'
					AND is_active = 1
					AND da.company_id = ".$compid."
			) g
			GROUP BY
				dept_code,
				attendance_date,
				shift
		) k
		GROUP BY
			dept_code,
			attendance_date
		ORDER BY
			dept_code;
		";
		 
		$sql="select 		dept_code,attendance_date,sum(sft_a) sft_a,sum(sft_b) sft_b,sum(sft_c) sft_c from (
			SELECT
						dept_code,
						date_format(attendance_date,'%d/%m/%Y') attendance_date,
						MAX(CASE WHEN shift = 'A' THEN whnd ELSE 0 END) AS sft_a,
						MAX(CASE WHEN shift = 'B' THEN whnd ELSE 0 END) AS sft_b,
						MAX(CASE WHEN shift = 'C' THEN whnd ELSE 0 END) AS sft_c
					FROM (
						SELECT
							dept_code,
							attendance_date,
							shift,
							SUM(whrs) AS whrs,
							SUM(nhrs) AS nhrs,
							ROUND(SUM(whrs + nhrs) / 8, 2) AS whnd
						FROM (
							SELECT
								dept_code,
								attendance_date,
								SUBSTRING(spell, 1, 1) AS shift,
								(working_hours - idle_hours) AS whrs,
								CASE
									WHEN (da.attendance_type = 'R' AND (working_hours - idle_hours) = 7.5 AND spell = 'C') THEN 0.5
									ELSE 0
								END AS nhrs
							FROM
								daily_attendance da
							LEFT JOIN
								department_master dm ON dm.dept_id = da.worked_department_id
							WHERE
							da.attendance_date = '".$sdate."'
							AND is_active = 1
							AND da.company_id = ".$compid."
								) g
						GROUP BY
							dept_code,
							attendance_date,
							shift
					) k
					GROUP BY
						dept_code,
						attendance_date
				union all
				select dept_code,date_format(tran_date,'%d/%m/%Y') attendance_date, shift_a sft_a,shift_b sft_b,shift_c sft_c 
				from EMPMILL12.tbl_daily_other_hands_data tdohd 
				join designation d on d.id =tdohd.occu_id 
				join master_department md on
				md.mdept_id = d.department and md.company_id =tdohd.company_id 
				where tran_date ='".$sdate."' and tdohd.company_id = ".$compid."
				and tdohd.is_active =1
			) g where dept_code<='35' group by dept_code,attendance_date
						ORDER BY
						dept_code";
			
	
						 $query = $this->db->query($sql);
						 $data = $query->result_array();
			//	echo		$this->db->last_query()	;
 
			$fileContainer = "CATHND.exp";
			$filePointer = fopen($fileContainer,"w+");
		
			$logMsg='';
			$rowIndex = 4;
			foreach ($data as $row) {

				$logMsg.= $row['attendance_date'].",".$row['dept_code'].",".$row['sft_a'].",".$row['sft_b'].",".
				$row['sft_c']."\r\n";
		
			}	




			fputs($filePointer,$logMsg);
			fclose($filePointer);

			$sql = "select date_format(tran_date,'%d/%m/%Y') attendance_date,mcm.mc_code dept_code,tdsmd.shift_a sft_a,
			shift_b sft_b,shift_c sft_c from EMPMILL12.tbl_daily_summ_mechine_data tdsmd 
			left join EMPMILL12.mechine_code_master mcm on mcm.mc_code_id =tdsmd.mc_code_id 
			where tdsmd.tran_date = '".$sdate."' and tdsmd.company_id= ".$compid." and tdsmd.is_active =1";
						 $query = $this->db->query($sql);
						 $data = $query->result_array();
					 
 
			$fileContainer1 = "dmach.exp";
			$filePointer1 = fopen($fileContainer1,"w+");
		
			$logMsg='';
			$rowIndex = 4;
			foreach ($data as $row) {

				$logMsg.= $row['attendance_date'].",".$row['dept_code'].",".$row['sft_a'].",".$row['sft_b'].",".
				$row['sft_c']."\r\n";
		
			}	
			fputs($filePointer1,$logMsg);
			fclose($filePointer1);

			

			
			$txt1=$fileContainer1;
			$files = array($txt1);
			$txt2=$fileContainer;
			$files = array($txt2,$txt1);
			$zipname = 'cathnd.zip';
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
			
					unlink($fileContainer);
					 unlink($zipname);
			
		
		   exit();
		 
		}

		 public function exportdbfdata() {
			$sdate = $this->input->post('payrollstartdate');
			$compid = $this->input->post('companyId');
			$sdate = $this->input->get('payrollstartdate');
			$compid = $this->input->get('companyId');
			$deptid = $this->input->get('mc_no1');
            $shiftName = $this->input->get('shiftName');
            $transName = $this->input->get('transName');
			$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
            
if ($transName==1) {		
            $sql = "select ORA_TABLE_ID from vowsls.ORA_DEPT_Link_TABLE where MYSQL_TABLE_ID=".$deptid ;
            $query = $this->db->query($sql);
            $row1 = $query->row();
            $sqldppid = $row1->ORA_TABLE_ID;
//	
if ($shiftName<>'ALL') {			
//	$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
    $sql = "SELECT
   CONCAT('INSERT INTO ATTENEMP.DAILY_ATTENDANCE VALUES (', da.daily_atten_id, ', TO_DATE(''', 
   da.attendance_date, ''',''YYYY-MM-DD''), ''',da.spell, ''', ',$sqldppid, ', ',
   da.spell_hours,',0, ''', da.eb_no, ''', ', (da.working_hours - da.idle_hours), ',0, ', ocl.ORA_TABLE_ID, ', ''', 
   da.attendance_type, ''',NULL,TO_DATE(''2023-12-11'', ''YYYY-MM-DD''),null, 0,NULL,NULL,''Y'', ', da.daily_atten_id, ')') AS attdata
    FROM
   daily_attendance da
    JOIN ORA_OCCU_LINK_TABLE ocl ON
   da.worked_designation_id = ocl.MYSQL_TABLE_ID
    WHERE
   da.attendance_date = '".$sdate."'
   AND da.is_active = 1
   AND da.spell = '".$shiftName."'
   AND da.worked_department_id = ".$deptid." 
    ORDER BY
   da.daily_atten_id";


       //          echo $sql;

				$query = $this->db->query($sql);
				$data = $query->result_array();
			
				$fileContainer = "attdata.csv";
				$filePointer = fopen($fileContainer,"w+");
			
				$logMsg='';
                $logMsg.= $sdate.'='.$shiftName."=".$sqldppid."\r\n";

                $rowIndex = 4;
				foreach ($data as $row) {
 
					$logMsg.= $row['attdata']."\r\n";
			
				}	

                $sql="
                SELECT CONCAT('INSERT INTO ATTENEMP.DAILY_ebmc_ATTENDANCE VALUES (',da.daily_atten_id,',''',da.eb_no,''',',oml.ORA_TABLE_ID,',',ocl.ORA_TABLE_ID,',null,''Y'',TO_DATE(''',da.attendance_date, ''',''YYYY-MM-DD''),''',da.spell,''',',da.worked_department_id,
                ')') AS attdata
                FROM daily_ebmc_attendance dem, daily_attendance da,
                ORA_MECH_LINK_TABLE oml, ORA_OCCU_LINK_TABLE ocl
                WHERE dem.is_active = 1 AND da.daily_atten_id = dem.daily_atten_id AND da.is_active = 1
                AND dem.mc_id = oml.MYSQL_TABLE_ID AND da.worked_designation_id = ocl.MYSQL_TABLE_ID
                AND da.attendance_date = '".$sdate."' AND da.spell = '".$shiftName."'
                AND worked_department_id = ".$deptid." order by da.daily_atten_id
                ";
				$query = $this->db->query($sql);
				$data = $query->result_array();
		//		$logMsg='';
				$rowIndex = 4;
				foreach ($data as $row) {
 
					$logMsg.= $row['attdata']."\r\n";
			
				}	
            }                            

            if ($shiftName=='ALL') {			
  //              $sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
                $sql = "SELECT
               CONCAT('INSERT INTO ATTENEMP.DAILY_ATTENDANCE VALUES (', da.daily_atten_id, ', TO_DATE(''', 
               da.attendance_date, ''',''YYYY-MM-DD''), ''',da.spell, ''', ',$sqldppid, ', ',
               da.spell_hours,',0, ''', da.eb_no, ''', ', (da.working_hours - da.idle_hours), ',0, ', ocl.ORA_TABLE_ID, ', ''', 
               da.attendance_type, ''',NULL,TO_DATE(''2023-12-11'', ''YYYY-MM-DD''),null, 0,NULL,NULL,''Y'', ', da.daily_atten_id, ')') AS attdata
            FROM
               daily_attendance da
            JOIN ORA_OCCU_LINK_TABLE ocl ON
               da.worked_designation_id = ocl.MYSQL_TABLE_ID
            WHERE
               da.attendance_date = '".$sdate."'
               AND da.is_active = 1
               AND da.worked_department_id = ".$deptid." 
                ORDER BY
               da.daily_atten_id";
            
            
                   //          echo $sql;
            
                            $query = $this->db->query($sql);
                            $data = $query->result_array();
                        
                            $fileContainer = "attdata.csv";
                            $filePointer = fopen($fileContainer,"w+");
                        
                            $logMsg='';
                            $logMsg.= $sdate."=".$shiftName."=".$sqldppid."\r\n";
                            $rowIndex = 4;
                            foreach ($data as $row) {
             
                                $logMsg.= $row['attdata']."\r\n";
                        
                            }	
            
                            $sql="
                            SELECT CONCAT('INSERT INTO ATTENEMP.DAILY_ebmc_ATTENDANCE VALUES (',da.daily_atten_id,',''',da.eb_no,''',',oml.ORA_TABLE_ID,',',ocl.ORA_TABLE_ID,',null,''Y'',TO_DATE(''',da.attendance_date, ''',''YYYY-MM-DD''),''',da.spell,''',',da.worked_department_id,
                            ')') AS attdata
                            FROM daily_ebmc_attendance dem, daily_attendance da,
                            ORA_MECH_LINK_TABLE oml, ORA_OCCU_LINK_TABLE ocl
                            WHERE dem.is_active = 1 AND da.daily_atten_id = dem.daily_atten_id AND da.is_active = 1
                            AND dem.mc_id = oml.MYSQL_TABLE_ID AND da.worked_designation_id = ocl.MYSQL_TABLE_ID
                            AND da.attendance_date = '".$sdate."' 
                            AND worked_department_id = ".$deptid." order by da.daily_atten_id
                            ";
                            $query = $this->db->query($sql);
                            $data = $query->result_array();
                    //		$logMsg='';
                            $rowIndex = 4;
                            foreach ($data as $row) {
             
                                $logMsg.= $row['attdata']."\r\n";
                        
                            }	
                        }                            
            
            
				fputs($filePointer,$logMsg);
				fclose($filePointer);

                

                
				$txt2="attdata.csv";
				$files = array($txt2);
				$zipname = 'drgdata.zip';
				$zip = new ZipArchive;
				$zip->open($zipname, ZipArchive::CREATE);
				foreach ($files as $file) {
				  $zip->addFile($file);
				}
				$zip->close();

			}				

			if ($transName==2) {		
			
				$sql="select date_format(dea.attendace_date,'%d/%m/%Y') att_date  ,dea.spell,dea.eb_no,concat(thepd.first_name,' ',ifnull(thepd.middle_name,''),' ',ifnull(thepd.last_name,'')) wname,
				d.desig, mm.mech_code ,mm.mechine_name ,da.working_hours -da.idle_hours whrs,ddea.cnt,dea.designation_id
				from daily_ebmc_attendance dea 
				join daily_attendance da on dea.daily_atten_id =da.daily_atten_id 
				join tbl_hrms_ed_personal_details thepd on dea.eb_id =thepd.eb_id
				join mechine_master mm on dea.mc_id =mm.mechine_id
				join designation d on d.id=da.worked_designation_id 
				join (select dea2.daily_atten_id,mc_id,count(*) cnt from daily_ebmc_attendance dea2 where is_active=1 
				and dea2.attendace_date = '".$sdate."' 
				group by dea2.daily_atten_id,mc_id  ) ddea 
				on dea.daily_atten_id=ddea.daily_atten_id and ddea.mc_id=dea.mc_id
				where da.is_active =1 and dea.is_active =1
				and dea.attendace_date = '".$sdate."' 
				and da.company_id =2 and da.worked_department_id= ".$deptid."
				and dea.designation_id in (71,74,75,78,73,72,77,76,79)
      			order by mm.mech_code "; 
				 $query = $this->db->query($sql);
				 $data = $query->result_array();
			 
				 $fileContainer1 = "slvmc.wvr";
				 $filePointer1 = fopen($fileContainer1,"w+");
				 $fileContainer2 = "slvmc.srh";
				 $filePointer2 = fopen($fileContainer2,"w+");
				 
				 $logMsg2=$sql;
			
				 $logMsg='';
//				 $logMsg.= $sdate."=".$shiftName."=".$sqldppid."\r\n";
				 $logMsg2='';
//				 $logMsg2.= $sdate."=".$shiftName."=".$sqldppid."\r\n";

				 $rowIndex = 4;
				 foreach ($data as $row) {
						$ocid=$row['designation_id'];
						$ocf=0;
						$mch=$row['mech_code'];
						if (substr($row['mech_code'],0,1)=='S') {
								$mch='H'.substr($row['mech_code'],1,2);
						}
						if (substr($row['mech_code'],0,1)=='H') {
							$mch='HH'.substr($row['mech_code'],2,2);
						}
					if ($ocid==71 || $ocid==74 || $ocid==78 || $ocid==73 || $ocid==77 )
						{ $ocf=201;} 
					if ($ocid==71 || $ocid==74 || $ocid==78 ) {
					 	$logMsg.= $row['eb_no'].",".$mch.",".$row['spell'].",".$row['att_date'].",".
						$row['whrs'].",".$ocf
						."\r\n";
					}
					if ($ocid==72 || $ocid==73 || $ocid==77 || $ocid==76 || $ocid==79 ) {
						$logMsg2.= $row['eb_no'].",".$mch.",".$row['spell'].",".$row['att_date'].",".
						$row['whrs'].",".$ocf
						."\r\n";
				   }
					   
				 }	
 
				 fputs($filePointer1,$logMsg);
				 fclose($filePointer1);
 
				 fputs($filePointer2,$logMsg2);
				 fclose($filePointer2);
 
				 
 
				 $txt1=$fileContainer1;
				 $txt2=$fileContainer2;
				 $files = array($txt1,$txt2);
				 $zipname = 'wvgdata.zip';
				 $zip = new ZipArchive;
				 $zip->open($zipname, ZipArchive::CREATE);
				 foreach ($files as $file) {
				   $zip->addFile($file);
				 }
				 $zip->close();
  


			}	


				header('Content-Type: application/zip');
				header('Content-disposition: attachment; filename='.$zipname);
				header('Content-Length: ' . filesize($zipname));
				readfile($zipname);
				
						unlink($fileContainer);
						 unlink($zipname);
				
			
			   exit();
			 
			}

			
			public function wndchecklist() {
				$sdate = $this->input->post('payrollstartdate');
				$rdate = $this->input->post('payrollstartdate');
				
				$mrdate = $this->input->post('payrollstartdate');
				
				$compid = $this->input->post('companyId');
				$sdate = $this->input->get('payrollstartdate');
				$rdate = $this->input->get('payrollstartdate');
			//	echo $rdate;
				$compid = $this->input->get('companyId');
				$deptid = $this->input->get('mc_no1');
				$shiftName = $this->input->get('shiftName');
				$transName = $this->input->get('transName');
				$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
				$sql="select w.*,att.desig,att.occu_code from (
					select tran_date prddate ,spell prdspell,mechine_name,eb_no prdebno ,empname,a.wnd_q_code,quality,wrkhrs,no_of_spindle,mech_code,wwl.occu_code prdooccode, 
					sum(prod) production
					from EMPMILL12.allwindingdata a
					left join EMPMILL12.winding_wages_link wwl on a.wnd_q_code=wwl.wnd_q_code
					where tran_date = '$sdate'   and company_id =2
										group by tran_date,spell,mechine_name,eb_no,empname,a.wnd_q_code,quality,wrkhrs,no_of_spindle,mech_code,wwl.occu_code 
									 ) w left join (           
									 SELECT eb_no,attendance_date,spell,da.worked_designation_id,d.desig,om.occu_code from daily_attendance da          
					left join designation d on d.id=da.worked_designation_id 
					left join EMPMILL12.OCCUPATION_MASTER om on d.id=om.vow_occu_id
					where da.attendance_date = '$sdate'  and d.company_id =2 and da.is_active =1
					) att on att.attendance_date=w.prddate and att.spell=w.prdspell and att.eb_no=w.prdebno
					where w.prdooccode <>att.occu_code 
							";		
//				echo $sql;
							$query = $this->db->query($sql);
					$data = $query->result_array();
	 

					$cmpn='The Empire Jute Co Ltd'	;
					$spreadsheet = new Spreadsheet();
					$sheet = $spreadsheet->getActiveSheet();
					$sheet->setCellValue('A1', $cmpn);
					$sheet->setCellValue('A2', "Winding Checklist Input Sheet As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				
				$rowIndex = 3;
				$value='Spell';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Mechine_name';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Prdebno';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='wnd_q_code';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='quality';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='desig';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$sheet->getColumnDimension('A')->setWidth(10);
				$sheet->getColumnDimension('b')->setWidth(15);
				$sheet->getColumnDimension('C')->setWidth(10);
				$sheet->getColumnDimension('d')->setWidth(10);
				$sheet->getColumnDimension('e')->setWidth(15);
				$sheet->getColumnDimension('f')->setWidth(15);
				$sheet->getColumnDimension('g')->setWidth(20);
				
				$sheet->mergeCells('A1:g1');
				$sheet->mergeCells('A2:g2');
				$sheet->getStyle('A3:g50')->applyFromArray($borderStyle);
				foreach ($data as $record) {
					$spl=$record['prdspell'];
					$mcname=$record['mechine_name'];
					$ebno=$record['prdebno'];
					$qc=$record['wnd_q_code'];
					$qual=$record['quality'];
					$prd=$record['production'];
					$desg=$record['desig'];
					$rowIndex++;
					$columnIndex=1;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$mcname;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qc;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qual;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$desg;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
//					$sheet->getRowDimension($rowIndex)->setRowHeight(30);
 	

				}			
				
				$sql="							select w.*,att.desig,att.occu_code from (
					select tran_date prddate ,spell prdspell,mechine_name,eb_no prdebno ,empname,a.wnd_q_code,quality,wrkhrs,no_of_spindle,mech_code,wwl.occu_code prdooccode, 
					sum(prod) production
					from EMPMILL12.allwindingdata a
					left join EMPMILL12.winding_wages_link wwl on a.wnd_q_code=wwl.wnd_q_code
					where tran_date between '$sdate' and '$sdate'   and company_id =2
										group by tran_date,spell,mechine_name,eb_no,empname,a.wnd_q_code,quality,wrkhrs,no_of_spindle,mech_code,wwl.occu_code 
									 ) w right join (          
									 SELECT eb_no,attendance_date,spell,da.worked_designation_id,d.desig,om.occu_code 
									 from daily_attendance da          
					left join designation d on d.id=da.worked_designation_id 
					left join EMPMILL12.OCCUPATION_MASTER om on d.id=om.vow_occu_id
					where da.attendance_date between '$sdate'  and '$sdate'  and da.company_id =2 and da.is_active =1
					and da.worked_designation_id in (199,200,330,201,202)
					) att on att.attendance_date=w.prddate and att.spell=w.prdspell and att.eb_no=w.prdebno 
				   where w.prdooccode is null ";
				   $query = $this->db->query($sql);
				   $data = $query->result_array();
				   $rowIndex++;
				   $rowIndex++;
				   $rowIndex++;

				   foreach ($data as $record) {
					$spl=$record['prdspell'];
					$mcname=$record['mechine_name'];
					$ebno=$record['prdebno'];
					$qc=$record['wnd_q_code'];
					$qual=$record['quality'];
					$prd=$record['production'];
					$desg=$record['desig'];
					$rowIndex++;
					$columnIndex=1;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$mcname;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qc;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qual;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$desg;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
//					$sheet->getRowDimension($rowIndex)->setRowHeight(30);
 	

				}			




				$filename="wndchecklist".$rdate.'.xlsx';
				// Set headers for Excel file download
			//	ob_clean();
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			//	header('Content-Disposition: attachment;filename="your_excel_file.xlsx"');
			
			//		header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename='.$filename);
				header('Cache-Control: max-age=0');
				ob_clean();
			
				// Save the Excel file to output stream
				$writer = new Xlsx($spreadsheet);
				$writer->save('php://output');
				// Save the Excel file to output stream
			//	$writer = new Xlsx($spreadsheet);
			//	$writer->save('php://output');
		


			}			
			

			public function fngchecklist() {

				$redRowStyle = [
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FFFF0000', // Red background
        ],
    ],
    'font' => [
        'color' => [
            'argb' => 'FFFFFFFF', // White text (optional)
        ],
    ],
];




				$sdate = $this->input->post('payrollstartdate');
				$rdate = $this->input->post('payrollstartdate');
				
				$mrdate = $this->input->post('payrollstartdate');
				
				$compid = $this->input->post('companyId');
				$sdate = $this->input->get('payrollstartdate');
				$rdate = $this->input->get('payrollstartdate');
			//	echo $rdate;
				$compid = $this->input->get('companyId');
				$deptid = $this->input->get('mc_no1');
				$shiftName = $this->input->get('shiftName');
				$transName = $this->input->get('transName');
				$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
				$sql="select
				da.eb_id,
				fe.eb_no,
				fe.spell,
				substr(fe.entry_date, 1, 10) proddate,
				ifnull(production,0) production,
				day(fe.entry_date) prodday,
				da.eb_no attebno,
				da.working_hours-idle_hours whrs,
				da.attendance_date attdate,da.spell attspell,dea.mc_id,fe.finishing_entry_id,da.daily_atten_id,mechine_name,mech_code 
			from
				daily_attendance da
			left join daily_ebmc_attendance dea on da.daily_atten_id=dea.daily_atten_id and dea.is_active=1
			left join finishing_entries fe on
				substr(fe.entry_date, 1, 10)= da.attendance_date
				and fe.eb_no = da.eb_no
				and fe.spell = da.spell
				and da.company_id = fe.company_id
				and fe.is_active = 1
			left join mechine_master mm on mm.mechine_id=dea.mc_id	
				where
				da.attendance_date between '$sdate' and '$sdate'
				and da.is_active = 1
				and da.company_id = $compid
				and da.worked_designation_id in (105,  108)";
//echo $sql;
				$query = $this->db->query($sql);
				$data = $query->result_array();
				foreach ($data as $record) {
					$spl=$record['finishing_entry_id'];
					$mcid=$record['mc_id'];
					$atid=$record['daily_atten_id'];
					if ($mcid==null || $atid==null || $spl==null ) 
					{
						echo 'Skipping update for finishing_entry_id: '.$atid.' due to null mcid or atid<br>';
						continue;
					}
					$sqlu="update finishing_entries set machine_id=$mcid where finishing_entry_id=$spl";

//					echo $sqlu.' '.$atid;
					$query = $this->db->query($sqlu);

				}	


					$cmpn='The Empire Jute Co Ltd-1'	;
					$spreadsheet = new Spreadsheet();
					$sheet = $spreadsheet->getActiveSheet();
					$sheet->setCellValue('A1', $cmpn);
					$sheet->setCellValue('A2', "Finishing Checklist( Att But No prod)  As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				
				$rowIndex = 3;
				$value='Date ';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spell';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='EB NO';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Mech Code';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Mechine Name';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Working Hrs';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
 				
				$sheet->mergeCells('A1:g1');
				$sheet->mergeCells('A2:g2');
				$sheet->getStyle('A3:g50')->applyFromArray($borderStyle);

				foreach ($data as $record) {
				//	$spl=$record['finishing_entry_id'];
				//	$mcid=$record['mc_id'];
					$atdt=$record['attdate'];
					$spl=$record['attspell'];
					$mccd=$record['mech_code'];
					$mcnm=$record['mechine_name'];
					$whrs=$record['whrs'];
					$prod=$record['production'];
					$ebno=$record['eb_no'];
					$attebno=$record['attebno'];
					$rowIndex++;
					$columnIndex=1;
					$value=$atdt;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$mccd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$mcnm;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$whrs;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prod;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$attebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);

					if ($prod==0) {
 						    $rowRange = 'A' . $rowIndex . ':g' . $rowIndex;
    						$sheet->getStyle($rowRange)->applyFromArray($redRowStyle);
 
					}

				}	

				$rowIndex++;
				$rowIndex++;
				$rowIndex++;
				$rowIndex++;

 					$rng='A'.$rowIndex;
					$cmpn='The Empire Jute Co Ltd-2'	;
//					$spreadsheet = new Spreadsheet();
//					$sheet = $spreadsheet->getActiveSheet();
					$sheet->setCellValue($rng, $cmpn);
					$rng='A'.$rowIndex+1;
					$sheet->setCellValue($rng, "Finishing Checklist (Prod but no Att)  As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				$rowIndex++;
				$rowIndex++;
				
//				$rowIndex = 3;
				$value='Date ';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spell';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='EB No';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Process';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
 				
				$sheet->mergeCells('A1:g1');
				$sheet->mergeCells('A2:g2');
				$sheet->getStyle('A3:g50')->applyFromArray($borderStyle);

				$sql="select substr(fe.entry_date,1,10) entrydate,spell,eb_no,production ,ptm.process_type   from finishing_entries fe 
				left join process_type_master ptm on fe.work_type =ptm.process_type_id  
				where substr(fe.entry_date,1,10)='$sdate'  and fe.company_id=$compid  and is_active=1
				and work_type=7
				";
//echo $sql;
				$query = $this->db->query($sql);
				$data = $query->result_array();
 				foreach ($data as $record) {
					$prdt=$record['entrydate'];
					$spl=$record['spell'];
					$ebno=$record['eb_no'];
 					$qual=$record['process_type'];
					$prd=$record['production'];
					$rowIndex++;
					$columnIndex=1;
					$value=$prdt;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qual;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
//					$sheet->getRowDimension($rowIndex)->setRowHeight(30);
					if (!isset($ebno) || strlen($ebno)==0) {
 						    $rowRange = 'A' . $rowIndex . ':g' . $rowIndex;
    						$sheet->getStyle($rowRange)->applyFromArray($redRowStyle);
 
					}
 	

				}			

 
				$rowIndex++;
				$rowIndex++;
				$rowIndex++;
				$rowIndex++;

 					$rng='A'.$rowIndex;
					$cmpn='The Empire Jute Co Ltd-3'	;
					$sheet->setCellValue($rng, $cmpn);
					$rng='A'.$rowIndex+1;
					$sheet->setCellValue($rng, "Finishing Checklist (Helper)  As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				$rowIndex++;
				$rowIndex++;
				
//				$rowIndex = 3;
				$value='Date ';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spell';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='EB No';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Mech name';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
 				
				$sheet->mergeCells('A1:g1');
				$sheet->mergeCells('A2:g2');
				$sheet->getStyle('A3:g50')->applyFromArray($borderStyle);


				$sql="select da.attendance_date entrydate,da.eb_no,da.spell,mm.mech_code,mm.mechine_name,da.working_hours -idle_hours whrs,fe.production    from daily_attendance da 
				left join daily_ebmc_attendance dea on da.daily_atten_id =dea.daily_atten_id and dea.is_active =1
				left join finishing_entries fe on da.attendance_date =substr(fe.entry_date,1,10 ) and da.spell =fe.spell and
				dea.mc_id = fe.machine_id
				left join mechine_master mm on mm.mechine_id =dea.mc_id 
				where da.attendance_date ='$sdate' and da.worked_designation_id in (106,109)
				";
				$query = $this->db->query($sql);
				$data = $query->result_array();
 				foreach ($data as $record) {
					$prdt=$record['entrydate'];
					$spl=$record['spell'];
					$ebno=$record['eb_no'];
 					$qual=$record['mechine_name'];
					$prd=$record['production'];
					$rowIndex++;
					$columnIndex=1;
					$value=$prdt;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qual;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
 					if ($prd==0) {
 						    $rowRange = 'A' . $rowIndex . ':g' . $rowIndex;
    						$sheet->getStyle($rowRange)->applyFromArray($redRowStyle);
 
					}
 	

				}			

				$sql="select da.eb_no,da.spell,mm.mech_code,mm.mechine_name,da.working_hours -idle_hours whrs,fe.production,fe.finishing_entry_id,dea.mc_id  from daily_attendance da 
				left join daily_ebmc_attendance dea on da.daily_atten_id =dea.daily_atten_id and dea.is_active =1
				left join finishing_entries fe on da.attendance_date =substr(fe.entry_date,1,10 ) and da.spell =fe.spell and
				dea.eb_no = fe.eb_no and fe.is_active =1
				left join mechine_master mm on mm.mechine_id =dea.mc_id 
				where da.attendance_date ='$sdate' and da.worked_designation_id in (92,93)
				and fe.finishing_entry_id is not null";
				$query = $this->db->query($sql);
				$data = $query->result_array();
				foreach ($data as $record) {
					$spl=$record['finishing_entry_id'];
					$mcid=$record['mc_id'];
			//		$atid=$record['daily_atten_id'];
					$sqlu="update finishing_entries set machine_id=$mcid where finishing_entry_id=$spl";

//					echo $sqlu.' '.$atid;
					$query = $this->db->query($sqlu);
				}	

				$rowIndex++;
				$rowIndex++;
				$rowIndex++;
				$rowIndex++;

 					$rng='A'.$rowIndex;
					$cmpn='The Empire Jute Co Ltd-4'	;
					$sheet->setCellValue($rng, $cmpn);
					$rng='A'.$rowIndex+1;
					$sheet->setCellValue($rng, "Lapping Checklist (Att )  As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				$rowIndex++;
				$rowIndex++;
				
//				$rowIndex = 3;
				$value='Date ';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spell';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='EB No';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Mech name';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$sheet->getColumnDimension('A')->setWidth(10);
				$sheet->getColumnDimension('b')->setWidth(15);
				$sheet->getColumnDimension('C')->setWidth(10);
				$sheet->getColumnDimension('d')->setWidth(10);
				$sheet->getColumnDimension('e')->setWidth(15);
				$sheet->getColumnDimension('f')->setWidth(15);
				$sheet->getColumnDimension('g')->setWidth(20);
				
				$sheet->mergeCells('A1:g1');
				$sheet->mergeCells('A2:g2');
				$sheet->getStyle('A3:g50')->applyFromArray($borderStyle);


				$sql="select da.attendance_date entrydate,da.eb_no,da.spell,mm.mech_code,mm.mechine_name,da.working_hours -idle_hours whrs,fe.production,fe.finishing_entry_id  from daily_attendance da 
				left join daily_ebmc_attendance dea on da.daily_atten_id =dea.daily_atten_id and dea.is_active =1
				left join finishing_entries fe on da.attendance_date =substr(fe.entry_date,1,10 ) and da.spell =fe.spell and
				dea.mc_id = fe.machine_id and fe.is_active =1
				left join mechine_master mm on mm.mechine_id =dea.mc_id 
				where da.attendance_date ='$sdate' and da.worked_designation_id in (92,93)
				";
				$query = $this->db->query($sql);
				$data = $query->result_array();
 				foreach ($data as $record) {
					$prdt=$record['entrydate'];
					$spl=$record['spell'];
					$ebno=$record['eb_no'];
 					$qual=$record['mechine_name'];
					$prd=$record['production'];
					$rowIndex++;
					$columnIndex=1;
					$value=$prdt;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qual;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
 					if ($prd==0) {
 						    $rowRange = 'A' . $rowIndex . ':g' . $rowIndex;
    						$sheet->getStyle($rowRange)->applyFromArray($redRowStyle);
 
					}
 	

				}			
				

				$rowIndex++;
				$rowIndex++;
				$rowIndex++;
				$rowIndex++;

 					$rng='A'.$rowIndex;
					$cmpn='The Empire Jute Co Ltd-5'	;
					$sheet->setCellValue($rng, $cmpn);
					$rng='A'.$rowIndex+1;
					$sheet->setCellValue($rng, "Lapping Checklist (Prod )  As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				$rowIndex++;
				$rowIndex++;
				
//				$rowIndex = 3;
				$value='Date ';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spell';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='EB No';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Mech name';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$sheet->getColumnDimension('A')->setWidth(10);
				$sheet->getColumnDimension('b')->setWidth(15);
				$sheet->getColumnDimension('C')->setWidth(10);
				$sheet->getColumnDimension('d')->setWidth(10);
				$sheet->getColumnDimension('e')->setWidth(15);
				$sheet->getColumnDimension('f')->setWidth(15);
				$sheet->getColumnDimension('g')->setWidth(20);
				
				$sheet->mergeCells('A1:g1');
				$sheet->mergeCells('A2:g2');
				$sheet->getStyle('A3:g50')->applyFromArray($borderStyle);


				$sql="select substr(fe.entry_date,1,1) entrydate,spell,eb_no,production ,ptm.process_type,fe.work_type,mm.mechine_name     from finishing_entries fe 
				left join process_type_master ptm on fe.work_type =ptm.process_type_id 
				left join mechine_master mm on mm.mechine_id =fe.machine_id 
				where substr(fe.entry_date,1,10)='$sdate'  and fe.company_id=2  and fe.is_active =1
				and fe.work_type = 40


				";
				$query = $this->db->query($sql);
				$data = $query->result_array();
 				foreach ($data as $record) {
					$prdt=$record['entrydate'];
					$spl=$record['spell'];
					$ebno=$record['eb_no'];
 					$qual=$record['mechine_name'];
					$prd=$record['production'];
					$rowIndex++;
					$columnIndex=1;
					$value=$prdt;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qual;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					if (!isset($ebno) || strlen($ebno)==0) {
 						    $rowRange = 'A' . $rowIndex . ':g' . $rowIndex;
    						$sheet->getStyle($rowRange)->applyFromArray($redRowStyle);
 
					}
   	

				}			
				
//spreader

				$rowIndex++;
				$rowIndex++;
				$rowIndex++;
				$rowIndex++;

 					$rng='A'.$rowIndex;
					$cmpn='The Empire Jute Co Ltd-6'	;
					$sheet->setCellValue($rng, $cmpn);
					$rng='A'.$rowIndex+1;
					$sheet->setCellValue($rng, "Spreader Checklist (Att )  As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				$rowIndex++;
				$rowIndex++;
				
//				$rowIndex = 3;
				$value='Date ';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spell';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='EB No';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Desig';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Mech name';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
 				
				$sheet->mergeCells('A1:g1');
				$sheet->mergeCells('A2:g2');
				$sheet->getStyle('A3:g50')->applyFromArray($borderStyle);


				$sql="select da.attendance_date entrydate,da.eb_no,da.spell,mm.mech_code,
				mm.mechine_name,da.working_hours -idle_hours whrs,spe.no_of_rolls production,desig   from daily_attendance da 
				left join daily_ebmc_attendance dea on da.daily_atten_id =dea.daily_atten_id and dea.is_active =1
				left join (select spe.entry_date,spe.spell,spe.spreader_no,sum(no_of_rolls) no_of_rolls from  EMPMILL12.spreader_prod_entry spe group by
				spe.entry_date,spe.spell,spe.spreader_no ) spe on spe.entry_date =da.attendance_date and spe.spell =da.spell 
				and dea.mc_id=spe.spreader_no 
				left join mechine_master mm on mm.mechine_id =dea.mc_id 
				left join designation d on d.id=da.worked_designation_id 
				where da.attendance_date ='$sdate' and da.worked_designation_id in (11,12)
				and da.is_active =1


				";
				$query = $this->db->query($sql);
				$data = $query->result_array();
 				foreach ($data as $record) {
					$prdt=$record['entrydate'];
					$spl=$record['spell'];
					$ebno=$record['eb_no'];
 					$qual=$record['mechine_name'];
					$prd=$record['production'];
					$dsg=$record['desig'];
					
					$rowIndex++;
					$columnIndex=1;
					$value=$prdt;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$dsg;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qual;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
 					if ($prd==0) {
 						    $rowRange = 'A' . $rowIndex . ':g' . $rowIndex;
    						$sheet->getStyle($rowRange)->applyFromArray($redRowStyle);
 
					}
  	

				}			

				$rowIndex++;
				$rowIndex++;
				$rowIndex++;
				$rowIndex++;

 					$rng='A'.$rowIndex;
					$cmpn='The Empire Jute Co Ltd-7'	;
					$sheet->setCellValue($rng, $cmpn);
					$rng='A'.$rowIndex+1;
					$sheet->setCellValue($rng, "Spreader Checklist (Prod )  As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				$rowIndex++;
				$rowIndex++;
				
//				$rowIndex = 3;
				$value='Date ';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spell';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='EB No';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Desig';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Mech name';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				
				$sheet->mergeCells('A1:g1');
				$sheet->mergeCells('A2:g2');
				$sheet->getStyle('A3:g50')->applyFromArray($borderStyle);


				$sql="select spe.*,da.working_hours-idle_hours whrs,mm.mechine_name,dea.eb_no ,d.desig  from
				(select spe.entry_date,spe.spell,spe.spreader_no,sum(no_of_rolls) production from  EMPMILL12.spreader_prod_entry spe group by
				spe.entry_date,spe.spell,spe.spreader_no ) spe
				left join daily_ebmc_attendance dea on dea.attendace_date =spe.entry_date and dea.mc_id=spe.spreader_no and dea.spell=spe.spe.spell  
				and dea.is_active =1
				left join daily_attendance da on da.daily_atten_id=dea.daily_atten_id and da.is_active=1
				left join mechine_master mm on mm.mechine_id =spe.spreader_no 
				left join designation d on d.id=da.worked_designation_id 
				where spe.entry_date ='$sdate'
				";
		//		echo $sql;
				$query = $this->db->query($sql);
				$data = $query->result_array();
 				foreach ($data as $record) {
					$prdt=$record['entry_date'];
					$spl=$record['spell'];
					$ebno=$record['eb_no'];
 					$qual=$record['mechine_name'];
					$prd=$record['production'];
					$dsg=$record['desig'];
					
					$rowIndex++;
					$columnIndex=1;
					$value=$prdt;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$dsg;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qual;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
 					if (!isset($ebno) || strlen($ebno)==0) {
 						    $rowRange = 'A' . $rowIndex . ':g' . $rowIndex;
    						$sheet->getStyle($rowRange)->applyFromArray($redRowStyle);
 
					}
 	

				}			


				$rowIndex++;
				$rowIndex++;
				$rowIndex++;
				$rowIndex++;

 					$rng='A'.$rowIndex;
					$cmpn='The Empire Jute Co Ltd-7'	;
					$sheet->setCellValue($rng, $cmpn);
					$rng='A'.$rowIndex+1;
					$sheet->setCellValue($rng, "Press Checklist (Attendance )  As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				$rowIndex++;
				$rowIndex++;
				
//				$rowIndex = 3;
				$value='Date ';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spell';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='No of Workers';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Mech name';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				
				$sheet->mergeCells('A1:g1');
				$sheet->mergeCells('A2:g2');
				$sheet->getStyle('A3:g50')->applyFromArray($borderStyle);

				$sql="select da.*,g.prod from (
					select SUBSTR(entry_date,1,10) fedate,spell,machine_id,mechine_name,sum(production) prod from (
					select fe.*,mm.mechine_name  from vowsls.finishing_entries fe 
					join vowsls.process_type_master ptm on fe.work_type =ptm.process_type_id and ptm.process_type ='PRESS'
					left join vowsls.mechine_master mm on mm.mechine_id =fe.machine_id 
					where fe.company_id=2  and substr(fe.entry_date,1,10) = '$sdate'  
					) g group by   SUBSTR(entry_date,1,10),spell,machine_id,mechine_name
					) g 
					right join 
					(
					select da.attendance_date,da.spell,mc_id,mechine_name,count(*) no_of_workers from (
						select da.attendance_date,da.spell,mc_id,mechine_name from  vowsls.daily_ebmc_attendance dea  
					left join vowsls.daily_attendance da on da.daily_atten_id =dea.daily_atten_id 
					left join vowsls.mechine_master mm on mm.mechine_id =dea.mc_id 
					where dea.is_active=1 and da.is_active and da.attendance_date='$sdate'   and mm.type_of_mechine =31
					) da group by da.attendance_date,da.spell,mc_id,mechine_name
					) da on da.attendance_date =g.fedate and da.spell =g.spell and da.mc_id =g.machine_id 

				";
		//		echo $sql;
				$query = $this->db->query($sql);
				$data = $query->result_array();
 				foreach ($data as $record) {
					$prdt=$record['attendance_date'];
					$spl=$record['spell'];
					$ebno=$record['no_of_workers'];
 					$qual=$record['mechine_name'];
					$prd=$record['prod'];
					$dsg='';
					
					$rowIndex++;
					$columnIndex=1;
					$value=$prdt;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qual;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$dsg;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
 					if (!isset($prd) || strlen($prd)==0) {
 						    $rowRange = 'A' . $rowIndex . ':g' . $rowIndex;
    						$sheet->getStyle($rowRange)->applyFromArray($redRowStyle);
 
					}
 	

				}			
				$rowIndex++;
				$rowIndex++;
				$rowIndex++;
				$rowIndex++;

 					$rng='A'.$rowIndex;
					$cmpn='The Empire Jute Co Ltd-7'	;
					$sheet->setCellValue($rng, $cmpn);
					$rng='A'.$rowIndex+1;
					$sheet->setCellValue($rng, "Press Checklist (Production )  As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				$rowIndex++;
				$rowIndex++;
				
//				$rowIndex = 3;
				$value='Date ';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spell';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='No of Workers';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Mech name';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				
				$sheet->mergeCells('A1:g1');
				$sheet->mergeCells('A2:g2');
				$sheet->getStyle('A3:g50')->applyFromArray($borderStyle);

				$sql="select g.*,da.no_of_workers from (
					select SUBSTR(entry_date,1,10) fedate,spell,machine_id,mechine_name,sum(production) prod from (
					select fe.*,mm.mechine_name  from vowsls.finishing_entries fe 
					join vowsls.process_type_master ptm on fe.work_type =ptm.process_type_id and ptm.process_type ='PRESS'
					left join vowsls.mechine_master mm on mm.mechine_id =fe.machine_id 
					where fe.company_id=2  and substr(fe.entry_date,1,10) = '$sdate'  
					) g group by   SUBSTR(entry_date,1,10),spell,machine_id,mechine_name
					) g 
					left join 
					(
					select da.attendance_date,da.spell,mc_id,count(*) no_of_workers from (
						select da.attendance_date,da.spell,mc_id,mechine_name from  vowsls.daily_ebmc_attendance dea  
					left join vowsls.daily_attendance da on da.daily_atten_id =dea.daily_atten_id 
					left join vowsls.mechine_master mm on mm.mechine_id =dea.mc_id 
					where dea.is_active=1 and da.is_active and da.attendance_date='$sdate'   and mm.type_of_mechine =31
					) da group by da.attendance_date,da.spell,mc_id,mechine_name
					) da on da.attendance_date =g.fedate and da.spell =g.spell and da.mc_id =g.machine_id 

				";
		//		echo $sql;
				$query = $this->db->query($sql);
				$data = $query->result_array();
 				foreach ($data as $record) {
					$prdt=$record['fedate'];
					$spl=$record['spell'];
					$ebno=$record['no_of_workers'];
 					$qual=$record['mechine_name'];
					$prd=$record['prod'];
					$dsg='';
					
					$rowIndex++;
					$columnIndex=1;
					$value=$prdt;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebno;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qual;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$dsg;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
 					if (!isset($ebno) || strlen($ebno)==0) {
 						    $rowRange = 'A' . $rowIndex . ':g' . $rowIndex;
    						$sheet->getStyle($rowRange)->applyFromArray($redRowStyle);
 
					}
 	

				}			



 
 
				$filename="fngchecklist".$rdate.'.xlsx';
				// Set headers for Excel file download
			//	ob_clean();
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			//	header('Content-Disposition: attachment;filename="your_excel_file.xlsx"');
			
			//		header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename='.$filename);
				header('Cache-Control: max-age=0');
				ob_clean();
			
				// Save the Excel file to output stream
				$writer = new Xlsx($spreadsheet);
				$writer->save('php://output');
				// Save the Excel file to output stream
			//	$writer = new Xlsx($spreadsheet);
			//	$writer->save('php://output');
		


			}			
			



			public function exportsprddata() {
				$sdate = $this->input->post('payrollstartdate');
				$rdate = $this->input->post('payrollstartdate');
				
				$mrdate = $this->input->post('payrollstartdate');
				
				$compid = $this->input->post('companyId');
				$sdate = $this->input->get('payrollstartdate');
				$rdate = $this->input->get('payrollstartdate');
				$compid = $this->input->get('companyId');
				$deptid = $this->input->get('mc_no1');
				$shiftName = $this->input->get('shiftName');
				$transName = $this->input->get('transName');
				$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
				$sql="select mm.mech_code,mm.mechine_name,spd.entry_date ,spd.spell , spd.prod,da.ebnos  from (		
					select spreader_no,entry_date,spell,sum(prod) prod from (
        			select spe.spreader_no, spe.spell,(spe.no_of_rolls) prod,
        			case when spell='C' and entry_time<=6 then date_add(entry_date,interval -1 day)
        			else entry_date end entry_date
        			from EMPMILL12.spreader_prod_entry spe
					) g where entry_date ='$sdate'
					group by  spreader_no,spell,entry_date ) spd
					left join (		
					select attendace_date,spell,mc_id,GROUP_CONCAT(DISTINCT eb_no SEPARATOR '/') ebnos  from (
					select dea.attendace_date,dea.spell,mc_id,dea.eb_no from  daily_ebmc_attendance dea ,daily_attendance da 
					where  dea.is_active=1  
					and da.daily_atten_id =dea.daily_atten_id and da.is_active =1 and dea.attendace_date ='$sdate'
					) g group by mc_id	,attendace_date,spell
					) da on da.mc_id=spd.spreader_no and da.attendace_date =spd.entry_date and da.spell =spd.spell 
					left join mechine_master mm on spd.spreader_no=mm.mechine_id 
					order by mech_code ,spell";		
					$query = $this->db->query($sql);
					$data = $query->result_array();
	
					$cmpn='The Empire Jute Co Ltd'	;
					$spreadsheet = new Spreadsheet();
					$sheet = $spreadsheet->getActiveSheet();
					$sheet->setCellValue('A1', $cmpn);
					$sheet->setCellValue('A2', "Spreader Input Sheet As on  : ".$rdate);
					$columnIndex = 1;
					$borderStyle = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
				
					$rowIndex = 3;
				$value='Spreader No';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spereader Name';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Spell';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Production';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Feeder/Receiver';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Remarks';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
 		
				foreach ($data as $record) {
					$mccode=$record['mech_code'];
					$mcname=$record['mechine_name'];
					$spl=$record['spell'];
					$prd=$record['prod'];
					$ebnos=$record['ebnos'];
					$rowIndex++;
					$columnIndex=1;
					$value=$mccode;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$mcname;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebnos;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$sheet->getRowDimension($rowIndex)->setRowHeight(30);
 	

				}			

				$sql="					select dea.*,mm.mech_code,mm.mechine_name,' ' prod from (
					select attendace_date,spell,mc_id,GROUP_CONCAT(DISTINCT eb_no SEPARATOR '/') ebnos  from (
					select dea.attendace_date,dea.spell,mc_id,dea.eb_no from  daily_ebmc_attendance dea ,daily_attendance da 
					where  dea.is_active=1  
					and da.daily_atten_id =dea.daily_atten_id and da.is_active =1 and dea.attendace_date ='$sdate'
					and mc_id in (670,671)) g group by mc_id	,attendace_date,spell
					) dea
					left join mechine_master mm on mm.mechine_id =dea.mc_id			";
			$query = $this->db->query($sql);
			$data = $query->result_array();
			foreach ($data as $record) {
				$mccode=$record['mech_code'];
				$mcname=$record['mechine_name'];
				$spl=$record['spell'];
				$prd=$record['prod'];
				$ebnos=$record['ebnos'];
				$rowIndex++;
				$columnIndex=1;
				$value=$mccode;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$mcname;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$spl;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$prd;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$ebnos;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$sheet->getRowDimension($rowIndex)->setRowHeight(30);
 

			}			

			$sql="select mm.mech_code,mm.mechine_name,spd.entry_date ,spd.spell , spd.prod,da.*  from (		
				select spreader_no,entry_date,spell,sum(prod) prod from (
				select spe.spreader_no, spe.spell,(spe.no_of_rolls) prod,
				case when spell='C' and entry_time<6 then date_add(entry_date,interval -1 day)
				else entry_date end entry_date
				from EMPMILL12.spreader_prod_entry spe
				) g where entry_date ='$sdate'
				group by  spreader_no,spell,entry_date ) spd
				right join (		
				select attendace_date,spell,mc_id,GROUP_CONCAT(DISTINCT eb_no SEPARATOR '/') ebnos  from (
				select dea.attendace_date,dea.spell,mc_id,dea.eb_no from  daily_ebmc_attendance dea ,daily_attendance da 
				where  dea.is_active=1  
				and da.daily_atten_id =dea.daily_atten_id and da.is_active =1 and dea.attendace_date ='$sdate'
				and mc_id in (665,666,667,668,669)
				) g group by mc_id	,attendace_date,spell
				) da on da.mc_id=spd.spreader_no and da.attendace_date =spd.entry_date and da.spell =spd.spell 
				left join mechine_master mm on spd.spreader_no=mm.mechine_id 
				where spd.prod is null
				order by mm.mech_code ,spd.spell";
				$query = $this->db->query($sql);
				$data = $query->result_array();
				foreach ($data as $record) {
					$mccode=$record['mech_code'];
					$mcname=$record['mechine_name'];
					$spl=$record['spell'];
					$prd=$record['prod'];
					$ebnos=$record['ebnos'];
					$rowIndex++;
					$columnIndex=1;
					$value=$mccode;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$mcname;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$prd;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebnos;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$sheet->getRowDimension($rowIndex)->setRowHeight(30);
					$columnIndex++;
					$value='No Prod';
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
	 
	
				}			
	
	




$sheet->getColumnDimension('A')->setWidth(10);
$sheet->getColumnDimension('b')->setWidth(18);
$sheet->getColumnDimension('C')->setWidth(10);
$sheet->getColumnDimension('d')->setWidth(10);
$sheet->getColumnDimension('e')->setWidth(15);
$sheet->getColumnDimension('f')->setWidth(30);

 

$sheet->mergeCells('A1:f1');
$sheet->mergeCells('A2:f2');
$sheet->getStyle('A3:f20')->applyFromArray($borderStyle);
//$sheet->getStyle('A1:f1')->applyFromArray($borderStyle);




				$filename="sprdinput_".$rdate.'.xlsx';
				// Set headers for Excel file download
			//	ob_clean();
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			//	header('Content-Disposition: attachment;filename="your_excel_file.xlsx"');
			
			//		header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename='.$filename);
				header('Cache-Control: max-age=0');
				ob_clean();
			
				// Save the Excel file to output stream
				$writer = new Xlsx($spreadsheet);
				$writer->save('php://output');
				// Save the Excel file to output stream
			//	$writer = new Xlsx($spreadsheet);
			//	$writer->save('php://output');
		


			}			
			

			public function exportmrdata() {
				$sdate = $this->input->post('payrollstartdate');
				$mrdate = $this->input->post('payrollstartdate');
				
				$compid = $this->input->post('companyId');
				$sdate = $this->input->get('payrollstartdate');
				$compid = $this->input->get('companyId');
				$deptid = $this->input->get('mc_no1');
				$shiftName = $this->input->get('shiftName');
				$transName = $this->input->get('transName');
				$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);

	 
				$sql="select smh.jute_receive_no,smh.jute_receive_dt,smh.actual_supplier,smh.vehicle_no,
				smh.challan_no,smh.challan_date,
				smli.actual_weight actualweight,smli.actual_quality,smli.warehouse_no,smli.item_code,
				smli.quantity,
				smh.unit_conversion ,
				jged.actual_weight ,jged.actual_quantity,0 jq,0 ac,0 gd,s.supp_name ,jqpm.jute_quality ,wd.name,
				smli.accepted_weight  
				from scm_mr_hdr smh 
				left  join (select * from scm_mr_line_item smli where smli.is_active=1) smli 
				on smli.jute_receive_no=smh.jute_receive_no 
				left join jute_gate_entry_dtl jged on jged.rec_id =smli.jute_gate_entry_lineitem_no 
				left join suppliermaster s on smh.actual_supplier =s.supp_code and smh.company_id =s.company_id 
				left join jute_quality_price_master jqpm on jqpm.id =smli.actual_quality
				left join warehouse_details wd on wd.id =smli.warehouse_no
				where smh.jute_receive_dt ='".$sdate."' and smh.mr_good_recept_status <>4 and smh.company_id =2";

				$query = $this->db->query($sql);
				$data = $query->result_array();
			
				$fileContainer = "mdata.csv";
				$filePointer = fopen($fileContainer,"w+");
			
				$logMsg='';
			//	$logMsg.= $sdate.'='.$shiftName."=".$sql."\r\n";

				$rowIndex = 4;
				foreach ($data as $row) {
 
					$logMsg.= $row['jute_receive_no'].",".$row['jute_receive_dt'].",".$row['actual_supplier'].",".
					$row['vehicle_no'].",".$row['challan_no'].",".$row['challan_date'].",".$row['actualweight']
					.",".$row['actual_quality'].",".$row['warehouse_no'].",".$row['item_code']
					.",".$row['quantity'].",".$row['unit_conversion'].",".$row['actual_weight']
					.",".$row['actual_quantity'].",".$row['jq'].",".$row['ac'].",".$row['gd']
					.",".$row['supp_name'].",".$row['jute_quality'].",".$row['name'].",".$row['accepted_weight']
					."\r\n";
		
				}		


	                   
				
				
					fputs($filePointer,$logMsg);
					fclose($filePointer);


					$fileContainer1 = "idata.csv";
					$filePointer1 = fopen($fileContainer1,"w+");
	
					
					$sql="select issue_date,jute_type,jute_quality,bale_loose,quantity,total_weight,godown_no  from jute_issue ji 
					where issue_date ='".$sdate."' and is_active =1 and bale_loose not in ('WASTAGE')";
					$sql="select issue_date,jute_type,ji.jute_quality,bale_loose,ji.quantity,total_weight,godown_no,
					0 qc,0 gd,jqpm.jute_quality jquality ,wd.name,smh.actual_supplier ,stock_id,smli.jute_line_item_no,
					ji.issue_no 
					from jute_issue ji 
					left join jute_quality_price_master jqpm on jqpm.id =ji.jute_quality
					left join warehouse_details wd on wd.id =ji.godown_no
					left join scm_mr_line_item smli on ji.stock_id =smli.jute_line_item_no 
					left join scm_mr_hdr smh on smh.jute_receive_no =smli.jute_receive_no 
					where issue_date ='".$sdate."' and ji.company_id=2 and ji.is_active =1 and bale_loose not in ('WASTAGE')";
					$query = $this->db->query($sql);
					$data = $query->result_array();
				
					
					$logMsg1='';
				//	$logMsg.= $sdate.'='.$shiftName."=".$sql."\r\n";
	
					$rowIndex = 4;
					foreach ($data as $row) {
	 
						$logMsg1.= $row['issue_date'].",".$row['jute_type'].",".$row['jute_quality'].",".
						$row['bale_loose'].",".$row['quantity'].",".$row['total_weight'].",".$row['godown_no']
						.",".$row['qc'].",".$row['gd'].",".$row['jquality'].",".$row['name']
						.",".$row['actual_supplier'].",".$row['issue_no']
						."\r\n";
			
					}		
	
	
						   
					
					
						fputs($filePointer1,$logMsg1);
						fclose($filePointer1);
	

					
	
//					$this->close();
			 		 
	 
					 $txt1=$fileContainer;
					 $txt2=$fileContainer1;
					 
					 $files = array($txt1,$txt2);
					 $zipname = 'mrdata.zip';
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
					
							unlink($fileContainer);
							 unlink($zipname);
					
				
				   exit();
				 
				}
				
	
	



}