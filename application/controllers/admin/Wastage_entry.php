<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Wastage_entry extends CI_Controller {

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
     
		
		$wndmcdata=$this->Wastage_entry_report_Model->getsectiondata();
		$data['sectiondata']=$wndmcdata;
	
		$deptdata=$this->daily_spell_drawing_entry_model->getdeptdata();
		$data['deptdata']=$deptdata;
		
		
		$spooldata=$this->Winding_doff_Model->getSpooldata();
		$datas['spooldata']=$spooldata;

		
		$qualitydata=$this->Winding_doff_Model->getQualitydata();
		$dataq['qualitydata']=$qualitydata;

		$data_to_pass['data'] = $data;
		$data_to_pass['datas'] = $datas;
		$data_to_pass['dataq'] = $dataq;
	

	//	var_dump($dataq);

//		$this->load->view('admin/winding_doff/winding_doff_data',$data,$dataq);
		$this->load->view('admin/products/wastage_entry', $data_to_pass);	
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




    public function getebdata() {
        $ebno1 = $this->input->post('ebno1');
        $companyId = $this->input->post('companyId');
		$windingDate= $this->input->post('windingDate');
		$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
	    $sql="select thepd.eb_id,concat(thepd.first_name,' ',ifnull(thepd.middle_name,''),' ',thepd.last_name)  empname from tbl_hrms_ed_personal_details thepd 
        join (select eb_id,emp_code from tbl_hrms_ed_official_details where is_active=1 ) theod on thepd.eb_id =theod.eb_id
        where theod.emp_code='".$ebno1."' and thepd.is_active =1 and thepd.company_id =".$companyId; 
        $query = $this->db->query($sql);
        $row1 = $query->row();
		$cnt = $query->num_rows();
        $ebid=0;
        $ebname='';
        if ($cnt>0) {
         $ebname = $row1->empname;
         $ebid = $row1->eb_id;
        }
        if ($ebid==0) {
            $ebname = 'No Data Found';
 
        }
        $sql="select dept_desc,spell_name from EMPMILL12.tbl_daily_ret_attendance tdra
		left join department_master dm on tdra.dept_id =dm.dept_id 
		left join spell_master sm on sm.spell_id =tdra.spell_id 
		where eb_id=".$ebid." and 
				ret_attend_date='".$windingDate."' and tdra.is_active=1
		";
        $query = $this->db->query($sql);
        $row1 = $query->row();
		$cnt = $query->num_rows();
		if ($cnt>0) {
			$ebid=0;
			$ebname=$ebno1.' Already Entered in '.$row1->dept_desc.' spell '.$row1->spell_name;
		}



        $response = array(
				'success' => true,
				'ebid' => $ebid,
				'ebname' => $ebname,
 			);
 		
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


	public function saveothatt_data() {
			$windingDate = $this->input->post('windingDate');
			$shiftName = $this->input->post('shiftName');
        	$companyId = $this->input->post('companyId');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$mcno1 = $this->input->post('mcno1');
			$ebid1 = $this->input->post('ebid1');
			$remarks = $this->input->post('remarks');
		
            $sql="select * from spell_master   
            where company_id =".$companyId." and spell_name='$shiftName'"; 
            $query = $this->db->query($sql);
            $row1 = $query->row();
            $spellid = $row1->spell_id;

        
            $active=1;
		    $data = array(
			'ret_attend_date' => $windingDate,
			'spell_id' => $spellid,
			'dept_id' => $mcno1,
			'eb_id' => $ebid1,
			'is_active' => $active,
			'remarks' => $remarks,		
			'company_id' => $companyId,		
		);
	//	$this->db->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
		$this->db->insert('EMPMILL12.tbl_daily_ret_attendance', $data);
 
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

			 
		public function updateretattndata() {
			$record_id = $this->input->post('record_id');
			$active=0;
			$data = array(
			'is_active' => $active,
		);
	//	$this->db->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
	$this->db->where('dayly_ret_att_id', $record_id);	
	$this->db->update('EMPMILL12.tbl_daily_ret_attendance', $data);

 
	$data =[];
	  $response = array(
		'success' => true,
		'savedata'=> 'saved'
	);
	
	$frameNo='';        
	echo json_encode($response);
	
	
		}
		
		
		public function get_records() {
			$date = $this->input->post('date');
			$shift = $this->input->post('shift');
			$compid = $this->input->post('companyId');
			$deptid= $this->input->post('deptid');
			
			$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
			$records=$this->daily_spell_drawing_entry_model->getretattndata($date, $shift, $compid,$deptid);
			$cnt=count($records);
 
 	
			$data = [];
			if ($cnt>0) {
				foreach ($records as $record) {
					$data[] = [
						$record['dayly_ret_att_id'],         // Use array notation instead of object property
						$record['ret_attend_date'],       // Use array notation instead of object property
						$record['spell_name'],          // Use array notation instead of object property
						$record['dept_desc'],   // Use array notation instead of object property
						$record['emp_code'],       // Use array notation instead of object property
						$record['empname'],       // Use array notation instead of object property
						$record['eb_id'],      // Use array notation instead of object property
						$record['spell_id'],     // Use array notation instead of object property
						$record['dept_id'],       // Use array notation instead of object property
						$record['remarks'],       // Use array notation instead of object property
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
			$tdate = $this->input->get('payrollstartdate');
			$sdate = $tdate;
			$compid = $this->input->get('companyId');
			$shift = $this->input->get('shift');
			$deptid = $this->input->get('deptid');
			
			
				 $sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
			
				 $sql="select * from vowsls.department_master where dept_id=".$deptid;
				 $query = $this->db->query($sql);
				 $records = $query->result();
				 $dpname='';
				 if ( $query->num_rows()>0 ) {
					  $row1 = $query->row();
					 $dpname=$row1->dept_desc;
				  }	
 
				 $sql="select dayly_ret_att_id,ret_attend_date,tdra.eb_id,emp_code,
				 concat(thepd.first_name,' ',ifnull(thepd.middle_name,''),' ',thepd.last_name) empname,
				 tdra.dept_id,tdra.spell_id,dept_desc,spell_name,remarks,cata_desc 
				 from EMPMILL12.tbl_daily_ret_attendance tdra
				 join department_master dm on tdra.dept_id =dm.dept_id 
				 join spell_master sm on sm.spell_id =tdra.spell_id 
				 join tbl_hrms_ed_personal_details thepd on thepd.eb_id =tdra.eb_id 
				 join (select eb_id,emp_code,catagory_id from tbl_hrms_ed_official_details where is_active=1 ) theod 
				 on thepd.eb_id =theod.eb_id
				 join category_master cm on cata_id =theod.catagory_id
				 where ret_attend_date='".$sdate."' and spell_name='$shift' and tdra.dept_id=$deptid 
				 and tdra.company_id=$compid and  tdra.is_active=1 
				 ";
//echo $sql;

				$query = $this->db->query($sql);
				$data = $query->result_array();
		
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				
				$hd1="Dept ".$dpname.' Dated '.$tdate.' Spell '.$shift;   
				$sheet->setCellValue('A1', 'Return Worker List');
				$sheet->setCellValue('A2', $hd1);
				$rowIndex = 3;
			
				$columnIndex = 1;
			
				$value='Emp Code';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Name';	
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value='Category';
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex = 1;    
				$nn=1;
				foreach ($data as $record) {
					$ebn=$record['emp_code'];
					$nm=$record['empname'];
					$prod=$record['cata_desc'];
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
					}
					$sheet->getColumnDimension('B')->setWidth(20);
					$sheet->getColumnDimension('C')->setWidth(20);
	
					$styleArray = [
						'borders' => [
							'allBorders' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
					
					$sheet->getStyle('A3:c50')->applyFromArray($styleArray);
					$sheet->mergeCells('A1:c1');
					$sheet->mergeCells('A2:c2');
				

					$filename="retatn_".$dpname.'_'.$shift.'.xlsx';
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
			

		 	
			   exit();
			 
			}
			


}