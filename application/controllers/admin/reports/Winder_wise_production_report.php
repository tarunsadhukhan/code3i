<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Winder_wise_production_report extends CI_Controller {

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
		$this->load->view('admin/reports/Winder_wise_production_report', $data_to_pass);	
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
    $this->db->where('auto_id', $record_id );
    $this->db->update('EMPMILL12.WINDING_DAILY_SPELL_EB', $data);
	$otherdb->close();
  //  echo $otherdb->last_query();
    

  
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
						$record['tran_date'],       // Use array notation instead of object property
						$record['spell'],          // Use array notation instead of object property
						$record['mechine_name'],   // Use array notation instead of object property
						$record['eb_no'], 
						$record['empname'], 
						$record['wnd_q_code'],      // Use array notation instead of object property
						$record['quality'],      // Use array notation instead of object property
						$record['production'],       // Use array notation instead of object property
						$record['wrkhrs'],     // Use array notation instead of object property
						$record['no_of_spindle']     // Use array notation instead of object property
						
					];
				}
		}
//		var_dump($data);
	
		// Return the response
			echo json_encode(['data' => $data]);
		}

		public function get_wndindreprecords() {
			$sdate = $this->input->post('sdate');
			$edate = $this->input->post('edate');
			$compid = $this->input->post('companyId');
			$empcode = $this->input->post('empcode');
			
            $sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
            $edate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
			$data = [];
	
         
			
			$records = $this->Winding_doff_Model->get_wndindreprecords($sdate, $edate, $compid,$empcode);
//			$data=$this->Winding_doff_Model->getfinishalldata($date,$compid);
			$cnt=count($records);
			if ($cnt>0) {
				foreach ($records as $record) {
					$data[] = [
                        $record['eb_no'], 
                        $record['empname'], 
                        $record['tran_date'],       // Use array notation instead of object property
						$record['shift'],          // Use array notation instead of object property
						$record['quality_id'],   // Use array notation instead of object property
						$record['quality'],      // Use array notation instead of object property
						$record['prod'],      // Use array notation instead of object property
						$record['atthrs'],       // Use array notation instead of object property
						$record['avg_prod'],     // Use array notation instead of object property
						$record['avg_targetprod'],     // Use array notation instead of object property
						$record['avg_targetprod']-$record['avg_prod'],     // Use array notation instead of object property
						$record['eff']     // Use array notation instead of object property
						
					];
				}
		}
//		var_dump($data);
	
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
						$record['tran_date'],       // Use array notation instead of object property
						$record['spell'],          // Use array notation instead of object property
						$record['mechine_name'],   // Use array notation instead of object property
						$record['eb_no'],       // Use array notation instead of object property
						$record['empname'],       // Use array notation instead of object property
						$record['wnd_q_code'],      // Use array notation instead of object property
						$record['quality'],      // Use array notation instead of object property
						$record['production'],       // Use array notation instead of object property
						$record['wrkhrs'],     // Use array notation instead of object property
						$record['no_of_spindle'],     // Use array notation instead of object property
						
					];
				}
		}
	
		// Return the response
			echo json_encode(['data' => $data]);
		}

 
		public function get_wnduprecords() {
			
			$company_id = $this->session->userdata('company_id');
			$remno=0;
			$remno = $this->input->post('remno');
			if ($remno>0) {
				$date = $this->input->post('windingrepDate');
				$shift = $this->input->post('repshiftName');
				$compid = $this->input->post('companyId');
			} else {
				$compid = $this->$company_id;
					

			}


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




		public function get_wndperrecords() {
			$sdate = $this->input->post('sdate');
			$edate = $this->input->post('edate');
			$compid = $this->input->post('companyId');
			
			$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
            $edate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
			$records=$this->Winding_doff_Model->get_wndperrecords($sdate, $edate, $compid);
			$cnt=count($records);

	 
			$data = [];
			if ($cnt>0) {
				foreach ($records as $record) {
					$data[] = [
						$record['image_html'],         // Use array notation instead of object property
						$record['eb_no'],       // Use array notation instead of object property
						$record['empname'],          // Use array notation instead of object property
						$record['prod'],   // Use array notation instead of object property
						$record['whrs'],   // Use array notation instead of object property
						$record['prod_8hrs'],       // Use array notation instead of object property
						$record['target_8hrs'],       // Use array notation instead of object property
                        $record['diff'], 
                        $record['eff'], 
                        $record['WND_GROUP_NAME'], 
                        
                        
                        // Use array notation instead of object property



                    ];
				}
		}
			// Return the response
			echo json_encode(['data' => $data]);
		}




		public function get_wndqcwisereport() {
			$date = $this->input->post('date');
			$compid = $this->input->post('companyId');
			$fdate=$date;

			$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
			
			$fdate=substr($fdate,6,4).'-'.substr($fdate,3,2).'-'.'01';
			
//			echo $date.'='.$fdate;
		//	$records = $this->Winding_doff_Model->getwndtrollyData($companyId,$trollyNo);
			$records=$this->Winding_doff_Model->get_wndqcwisereport($date, $fdate,$compid);
			$cnt=count($records);
 
			$data = [];
			if ($cnt>0) {
				$gtopdka=$gtopdkb=$gtopdkc=$gtoprd=$gtotrga=$gtotrgb=$gtotrgc=$gtdprd=$gemplt=0;
				foreach ($records as $record) {
					$toprd=$record['topdka']+$record['topdkb']+$record['topdkc'];
					$trprd=$record['totrga']+$record['totrgb']+$record['totrgc'];
					$prdwnda=0;
//					echo $record['tdprd']; 
					$prdwndb=0;
					$prdwndc=0;
					$prdwndt=0;
					$tdprdwnd=0;
					$dfprd=$trprd-$toprd;
					if (($record['topdka']>0) & ($record['empla']>0)) { $prdwnda=round($record['topdka']/$record['empla'],0);}
					if (($record['topdkb']>0) & ($record['emplb']>0))  { $prdwndb=round($record['topdkb']/$record['emplb'],0);}
					if (($record['topdkc']>0) & ($record['emplc']>0))  { $prdwndc=round($record['topdkc']/$record['emplc'],0);}
					if (($toprd>0) & ($record['emplt']>0)) { $prdwndt=round($toprd/$record['emplt'],0);}
		//			echo $record['tdprd'].'===='.$record['tdemp'].'/';
					if ( ($record['tdprd']>0) and ($record['tdemp']>0) ) { $tdprdwnd=round($record['tdprd']/$record['tdemp'],0);}
	 				
					$gtopdka=$gtopdka+$record['topdka'];
					$gtopdkb=$gtopdkb+$record['topdkb'];
					$gtopdkc=$gtopdkc+$record['topdkc'];
					$gtoprd=$gtoprd+$toprd;
					$gtotrga=$gtotrga+$record['totrga'];
					$gtotrgb=$gtotrgb+$record['totrgb'];
					$gtotrgc=$gtotrgc+$record['totrgc'];
					$gtdprd=$gtdprd+$record['tdprd'];
					$gemplt=$gemplt+$record['emplt'];	
					$data[] = [
						$date,
						$record['mwndqcode'],         // Use array notation instead of object property
						$record['tdquality'],         // Use array notation instead of object property
						$record['emplt'],       // Use array notation instead of object property
						$record['topdka'],          // Use array notation instead of object property
						$record['topdkb'],   // Use array notation instead of object property
						$record['topdkc'],   // Use array notation instead of object property
						$toprd,
						$record['totrga'],       // Use array notation instead of object property
						$record['totrgb'],       // Use array notation instead of object property
                        $record['totrgc'],
						$trprd,
						$dfprd,

						$prdwnda,
						$prdwndb,
						$prdwndc,
						$prdwndt,

						$record['tdprd'],
						$tdprdwnd	
						
                    ];
				}
				$bln='';
				$data[] = [
					$date,
					$bln,         // Use array notation instead of object property
					'Grand Total',         // Use array notation instead of object property
					$gemplt,       // Use array notation instead of object property
					$gtopdka,          // Use array notation instead of object property
					$gtopdkb,   // Use array notation instead of object property
					$gtopdkc,   // Use array notation instead of object property
					$gtoprd,
					$gtotrga,       // Use array notation instead of object property
					$gtotrgb,       // Use array notation instead of object property
					$gtotrgc,
					$bln,
					$bln,

					$bln,
					$bln,
					$bln,
					$bln,

					$gtdprd,
					$bln	
				];


		}
			// Return the response
			echo json_encode(['data' => $data]);
		}



		public function get_wndqcsummreport() {
			$date = $this->input->post('date');
			$compid = $this->input->post('companyId');
			$fdate=$date;

			$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
			
			$fdate=substr($fdate,6,4).'-'.substr($fdate,3,2).'-'.'01';
			
	//		echo $date.'='.$fdate;
		//	$records = $this->Winding_doff_Model->getwndtrollyData($companyId,$trollyNo);
			$records=$this->Winding_doff_Model->get_wndqcsummreports($date, $fdate,$compid);
			$cnt=count($records);
 
			$data = [];
			if ($cnt>0) {
				foreach ($records as $record) {
		  			$data[] = [
						$record['spg_group'],         // Use array notation instead of object property
						$record['empla'],         // Use array notation instead of object property
						$record['emplb'],       // Use array notation instead of object property
						$record['emplc'],          // Use array notation instead of object property
						$record['emplt'],   // Use array notation instead of object property
						$record['topdka'],   // Use array notation instead of object property
						$record['topdkb'],   // Use array notation instead of object property
						$record['topdkc'],   // Use array notation instead of object property
						$record['topdkt'],   // Use array notation instead of object property
						$record['spgwnd'],       // Use array notation instead of object property
						$record['spgprda'],       // Use array notation instead of object property
                        $record['spgprdb'],
                        $record['spgprdc'],
                        $record['spgprdt'],
 		 				
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
			$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
			$records=$this->Winding_doff_Model->getjugDoffdata($date, $shift, $compid,$openclose);
			$cnt=count($records);
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
		$kdate=$date;
		$compid = $this->input->get('companyId');
		$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
		$sdate=substr($kdate,6,4).'-'.substr($kdate,3,2).'-'.'01';
		$pdate=substr($kdate,0,2).'/'.substr($kdate,3,2).'/'.substr($kdate,6,4);
		//echo $date;
/*
		$data=$this->Winding_doff_Model->getfinishalldata($date,$compid);
//	var_dump($data);
	
		$jsonData = json_encode($data, JSON_PRETTY_PRINT);

		// Define the JSON file name
		$jsonFileName = 'wnddata.json';
		
		// Write JSON data to the file
		file_put_contents($jsonFileName, $jsonData);
*/
        $sql="select WND_GR_CODE,sum(prod) prod,sum(wrkhrs) hrs,round(sum(prod)/sum(wrkhrs)*8,0) avg,'D' remarks from (
			select a.*,g.wrkhrs,g.wnd_q_code,WND_GR_CODE from 
			(select wnd_mc_id,a.tran_date,a.spell,sum(prod) prod 
			from EMPMILL12.allwindingdata a where a.tran_date ='".$date."' and a.company_id =".$compid."
			group by wnd_mc_id,a.tran_date,a.spell ) a 
			left join 
			( select distinct(wnd_mc_id) wnd_mc_id,tran_date,spell,wrkhrs,wnd_q_code from  EMPMILL12.allwindingdata a
			where a.tran_date ='".$date."' and a.company_id =".$compid."
			) g on a.wnd_mc_id=g.wnd_mc_id and a.tran_date=g.tran_date and a.spell=g.spell
			left join EMPMILL12.WINDING_QUALITY_MASTER wqm on g.wnd_q_code=wqm.wnd_q_code
			) k group by WND_GR_CODE
			union ALL 
		   select WND_GR_CODE,sum(prod) prod,sum(wrkhrs) hrs,round(sum(prod)/sum(wrkhrs)*8,0) avg,'T' remarks from (
			select a.*,g.wrkhrs,g.wnd_q_code,WND_GR_CODE from 
			(select wnd_mc_id,a.tran_date,a.spell,sum(prod) prod 
			from EMPMILL12.allwindingdata a where a.tran_date between '".$sdate."' and  '".$date."' and a.company_id =".$compid."
			group by wnd_mc_id,a.tran_date,a.spell ) a 
			left join 
			( select distinct(wnd_mc_id) wnd_mc_id,tran_date,spell,wrkhrs,wnd_q_code from  EMPMILL12.allwindingdata a
			where a.tran_date between '".$sdate."' and  '".$date."' and a.company_id =".$compid."
			) g on a.wnd_mc_id=g.wnd_mc_id and a.tran_date=g.tran_date and a.spell=g.spell
			left join EMPMILL12.WINDING_QUALITY_MASTER wqm on g.wnd_q_code=wqm.wnd_q_code
			) k group by WND_GR_CODE " ; 
		$query = $this->db->query($sql);
		$data = $query->result_array();
	    $fileContainer = "dailyupd.txt";
	    $filePointerhhm = fopen($fileContainer,"w+");
  	 	 $logMsghhm='';
    $rowIndex = 4;
	foreach ($data as $row) {
                $logMsghhm.= $pdate.",".$row['WND_GR_CODE'].",".$row['prod'].",".$row['hrs'].",".$row['avg']
				.",".$row['remarks']
				."\r\n";

    }	


    fputs($filePointerhhm,$logMsghhm);
    fclose($filePointerhhm);
 


    $txt1= $fileContainer;
      
 //   $files = array($txt1,$txt2,$txt3,$txt4);

   // $zipname = 'fngdata.zip';

	
	



		// Create a new ZipArchive instance
		$zip = new ZipArchive();
		
		// Define the zip file name
		$zipFileName = 'wndata.zip';
		
		// Create the zip file
		if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
			// Add the JSON file to the zip
			$zip->addFile($txt1);
		
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
	   
	public function expperdataexl() {
	
	
	$sdate = $this->input->get('windingperfrDate');
	$edate = $this->input->get('windingpertoDate');
	$compid = $this->input->get('companyId');
	$sdatep = $this->input->get('windingperfrDate');
	$edatep = $this->input->get('windingpertoDate');
 	
    echo 'start'.$sdate."<br>";
    echo 'end'.$edate;

    $sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
   
	$edate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
 	$sql="select * from vowsls.company_master where comp_id=".$compid;
		$query = $this->db->query($sql);
		$records = $query->result();
		$name='';
		if ( $query->num_rows()>0 ) {
			 $row1 = $query->row();
			$name=$row1->company_name;
		 }	
       $records=$this->Winding_doff_Model->get_wndperrecords($sdate, $edate, $compid);
  		 $cnt=count($records);


		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
	
		
		$cmpn=$name;
		$sheet->setCellValue('A1', $cmpn);
		$sheet->setCellValue('A2', "Winder Performance Report for the Period between ".$sdatep." and ".$edatep);
		$rowIndex = 3;
	
		$columnIndex = 1;
	
		$value='Emp Code';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Name';	
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Production';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Working Hours';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Prod/ 8 Hours';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Target Prod/ 8 Hours';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Difference';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Eff(%)';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Quality Type';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$nn=1;
		$columnIndex++;
		$companyName = $cmpn;
//		$rowIndex ++;;
		$columnIndex = 1;    
		$mcc="";
		$mcnum="";
	   $sp=""; 
	   $cn=0;
	   $tprd=0;
	   $spprd=0;
	   $totprd=0;
	   $totspprd=0;

	   $nn=1;
		foreach ($records as $record) {
            $ebn=$record['eb_no'];
            $nm=$record['empname'];
            $prod=$record['prod'];
			$whrs=$record['whrs'];
			$prod_8hrs=$record['prod_8hrs'];
			$target_8hrs=$record['target_8hrs'];
			$diff=$record['diff'];
            $eff=$record['eff'];
            $wndgrname=$record['WND_GROUP_NAME'];
            
				$tprd=0;
				$spprd=0;
				$rowIndex++;
				$columnIndex=1;
				$value=$ebn;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$nm;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$prod;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$whrs;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$prod_8hrs;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$target_8hrs;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$diff;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$eff;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$wndgrname;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;



}



//$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(20);
//$sheet->getColumnDimension('E')->setWidth(20);
$nn=71;	
while ($nn<=82) { 
	$r1=chr($nn);

	$sheet->getColumnDimension($r1)->setWidth(15);
	$nn++;
}
$sheet->getStyle('A1:J500')->getAlignment()->setWrapText(true);

        $sheet->mergeCells('A1:j1');
		$sheet->mergeCells('A2:j2');
	
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        
        $sheet->getStyle('A3:j170')->applyFromArray($styleArray);
    
        $filename="wndperdetails_".$sdatep.'.xlsx';
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
		
	
	public function expspginputexl() {
	
	
		$sdate = $this->input->get('windingrepDate');
		$compid = $this->input->get('companyId');
	
		$date=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
		$rdate=substr($sdate,0,2).'-'.substr($sdate,3,2).'-'.substr($sdate,6,4);
		 $sql="select * from vowsls.company_master where comp_id=".$compid;
			$query = $this->db->query($sql);
			$records = $query->result();
			$name='';
			if ( $query->num_rows()>0 ) {
				 $row1 = $query->row();
				$name=$row1->company_name;
			 }	
			 $this->load->model('Winding_data_reports_Model');
			 $records = $this->Winding_data_reports_Model->getspginputexl($date, $compid);
			 $cnt=count($records);
	
	//		 var_dump($records);
	
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
		
			
			$cmpn=$name;
			$sheet->setCellValue('A1', $cmpn);
			$sheet->setCellValue('A2', "Winding Quality wise Production Report As on  : ".$rdate);
			$rowIndex = 3;
		
			$columnIndex = 1;
		
			$value='Mechine Name';
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
			$value='Emp Code';
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
			$value='Name';	
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
			$value='Quality Code';
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
			$value='Quality';
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
			$value='Spell';
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
			$nn=1;
			while ($nn<=12) { 
				$value=$nn;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$nn++;
			}
			$value='Spell Total';
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
			$value='Shift Total';
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	
	
			$columnIndex++;
			$companyName = $cmpn;
	//		$rowIndex ++;;
			$columnIndex = 1;    
			$mcc="";
			$mcnum="";
		   $sp=""; 
		   $cn=0;
		   $tprd=0;
		   $spprd=0;
		   $totprd=0;
		   $totspprd=0;
	
		   $nn=1;
			foreach ($records as $record) {
	//			$columnIndex = 1;
	//echo 'for each';
				$mcnum=$record['mechine_name'];
				$spl=$record['spell'];
				$qtlc=$record['wnd_q_code'];
				$qtl=$record['quality'];
				$ebn=$record['eb_no'];
				$nm=$record['empname'];
				$apd=$record['prod'];;
				if ($mcc<>$mcnum ) {		
					if ($spprd>0) {
						$columnIndex=19;
						$value=$spprd;
						$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
						$columnIndex++;
					}
					if ($tprd>0) {
						$columnIndex=20;
						$value=$tprd;
						$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
						$columnIndex++;
					}
					$tprd=0;
					$spprd=0;
					$rowIndex++;
					$columnIndex=1;
					$value=$mcnum;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebn;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$nm;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qtlc;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qtl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					 $mcc=$mcnum;
					$sp=$spl;
					$cn=7;
				}
				if ($sp<>$spl) {
					if ($spprd>0) {
						$columnIndex=19;
						$value=$spprd;
						$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
						$columnIndex++;
					}
					$spprd=0;
					$rowIndex++;
					$columnIndex=1;
					$value=$mcnum;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$ebn;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$nm;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qtlc;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$qtl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					$value=$spl;
					$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
					$columnIndex++;
					 $mcc=$mcnum;
					$sp=$spl;
					$cn=7;
				}	
				$columnIndex=$cn;
				$value=$apd;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
					 $tprd=$tprd+$apd;
					$spprd=$spprd+$apd;
					$totprd=$totprd+$apd;
					$totspprd=$totspprd+$apd;
				$cn++;			
	}
	
	
	if ($spprd>0) {
		$columnIndex=19;
		$value=$spprd;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
	}
	if ($tprd>0) {
		$columnIndex=20;
		$value=$tprd;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
	}
	$rowIndex++;
	
	if ($totspprd>0) {
		$columnIndex=19;
		$value=$totspprd;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
	}
	if ($totprd>0) {
		$columnIndex=20;
		$value=$totprd;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
	}
	
	$sheet->getColumnDimension('A')->setWidth(20);
	$sheet->getColumnDimension('C')->setWidth(20);
	$sheet->getColumnDimension('E')->setWidth(20);
	$nn=71;	
	while ($nn<=82) { 
		$r1=chr($nn);
	
		$sheet->getColumnDimension($r1)->setWidth(4);
		$nn++;
	}
			$sheet->mergeCells('A1:E1');
	//		$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
	//		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('A2:E2');
	//		$sheet->getStyle('A2')->getFont()->setSize(16)->setBold(true);
	//		$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$filename="wndmcdetails_".$date.'.xlsx';
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
			
		



}