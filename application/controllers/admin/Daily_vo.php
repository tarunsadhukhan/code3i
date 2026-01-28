<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Daily_vo extends CI_Controller {

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
		md.rec_id = d.department
				where tran_date ='".$sdate."' and tdohd.company_id = ".$compid."
				and tdohd.is_active =1
			) g where dept_code<='35' group by dept_code,attendance_date
						ORDER BY
						dept_code";
			
		
						 $query = $this->db->query($sql);
						 $data = $query->result_array();
					 
 
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
					if ($ocid==73 || $ocid==73 || $ocid==77 || $ocid==76 || $ocid==79 ) {
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
			


}