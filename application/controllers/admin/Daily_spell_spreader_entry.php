<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Daily_spell_spreader_entry extends CI_Controller {

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
     
		
		$wndmcdata=$this->daily_spell_drawing_entry_model->getsprdmcdata();
		$data['wndmcdata']=$wndmcdata;
	
		
		
 
		

		$data_to_pass['data'] = $data;
	

	//	var_dump($dataq);

//		$this->load->view('admin/winding_doff/winding_doff_data',$data,$dataq);
		$this->load->view('admin/drawing/Daily_spell_spreader_entry', $data_to_pass);	
	}

 
	public function mcno1_data() {
        $mcno1 = $this->input->post('mcno1');
        $companyId = $this->input->post('companyId');
		$shiftName = $this->input->post('shiftName');
		$windingDate = $this->input->post('windingDate');
		$this->load->model('Winding_doff_Model');
		$records = $this->daily_spell_drawing_entry_model->getsprdprvData($companyId,$mcno1,$windingDate,$shiftName);
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
				$dfmeter1=($clmeter1+100000)-$opmeter;
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
			'act_prod' => $actroll,		
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
		
 	

		 public function exportdbfdata() {
			$sdate = $this->input->post('payrollstartdate');
			$compid = $this->input->post('companyId');
			$sdate = $this->input->get('payrollstartdate');
			$compid = $this->input->get('companyId');
			
			
				 $sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
			
				 $sql=" select ddt.drg_tran_id,date_format(ddt.tran_date,'%d-%m-%Y') tran_date ,ddt.spell,
				 mm.mech_code,mm.mechine_name,ddt.const_meter ,ddt.open_meter ,
				 ddt.close_meter ,ddt.diff_meter ,ddt.actual_eff,ddt.wrk_hours ,ddt.remarks,ddt.drg_mc_id,mc_group  
				 from EMPMILL12.daily_drawing_transaction ddt 
				 left join vowsls.mechine_master mm on mm.mechine_id =ddt.drg_mc_id 
				 left join EMPMILL12.drawing_master dm on ddt.drg_mc_id=dm.drg_mc_id
				 where ddt.tran_date ='".$sdate."' and ddt.is_active =1
				 and ddt.company_id =".$compid."  order by mech_code";

				$query = $this->db->query($sql);
				$data = $query->result_array();
			
				$fileContainer = "drgdata.csv";
				$filePointer = fopen($fileContainer,"w+");
			
				$logMsg='';
				$rowIndex = 4;
				foreach ($data as $row) {
					$cm=round($row['const_meter']/8*$row['wrk_hours'],2);

					$logMsg.= $row['tran_date'].",".$row['spell'].",".$row['mech_code'].",".$row['open_meter'].
					",".$row['close_meter'].",".$row['diff_meter'].",".$row['actual_eff'].
					",0,".$cm.",".$row['mc_group']."\r\n";
			
				}	
			
				fputs($filePointer,$logMsg);
				fclose($filePointer);
			 
				$txt2="drgdata.csv";
				$files = array($txt2);
				$zipname = 'drgdata.zip';
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