<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;	

class Daily_layout_print extends CI_Controller {

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
        	$this->load->model('Absent_warning_entry_Model');
	
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
     
		
		$wndmcdata=$this->daily_spell_drawing_entry_model->getwndmcnodata();
		$data['wndmcdata']=$wndmcdata;
	
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
		$this->load->view('admin/attendance/Daily_layout_print', $data_to_pass);	
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




    public function getebmcdata() {
        $deptid = $this->input->post('deptid');
        $shift = $this->input->post('shift');
        $companyId = $this->input->post('companyId');
		$windingDate= $this->input->post('date');
//        echo $windingDate;
		$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);


        $sql="select date_format(dea.attendace_date,'%d-%m-%Y') attendace_date,dea.spell,dea.eb_no,
        concat(thepd.first_name,' ',ifnull(thepd.middle_name,''),' ',ifnull(thepd.last_name,'')) wname,
        d.desig, mm.mech_code ,mm.mechine_name ,da.working_hours -da.idle_hours whrs,ddea.cnt
        from daily_ebmc_attendance dea 
        join daily_attendance da on dea.daily_atten_id =da.daily_atten_id 
        join tbl_hrms_ed_personal_details thepd on dea.eb_id =thepd.eb_id
        join mechine_master mm on dea.mc_id =mm.mechine_id
        join designation d on d.id=da.worked_designation_id 
        join (select dea2.daily_atten_id,mc_id,count(*) cnt from daily_ebmc_attendance dea2 where is_active=1 
        and dea2.attendace_date ='".$windingDate."' and dea2.spell='".$shift."'
        group by dea2.daily_atten_id,mc_id  ) ddea 
        on dea.daily_atten_id=ddea.daily_atten_id and ddea.mc_id=dea.mc_id
        where da.is_active =1 and dea.is_active =1
        and dea.attendace_date ='".$windingDate."' and dea.spell='".$shift."'
        and da.company_id =2 and worked_department_id =".$deptid." 
        order by mm.mech_code 
     ";

     $query = $this->db->query($sql);
     $cnt = $query->num_rows();
     $data = [];
      $rows = $query->result_array(); 
       if ($cnt>0) {
            foreach ($rows as $record) {
                $data[] = [
                    $record['attendace_date'],
                    $record['spell'],
                    $record['eb_no'],
                    $record['wname'],
                    $record['desig'],
                    $record['mech_code'],
                    $record['mechine_name'],
                    $record['whrs'],
                    $record['cnt'],
  // Use array notation instead of object property
                ];
            }
    }
        // Return the response
        echo json_encode(['data' => $data]);
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

		public function savewarn_data() {
           
			$windingDate = $this->input->post('windingDate');
			$record_id = $this->input->post('record_id');
			$companyId = $this->input->post('companyId');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$warntobe = $this->input->post('warntobe');
			$ebid = $this->input->post('ebid');
			$issueDate = $this->input->post('issueDate');
            $issueDate=substr($issueDate,6,4).'-'.substr($issueDate,3,2).'-'.substr($issueDate,0,2);
			$remarks = $this->input->post('remarks');
			$prvwarnno= $warntobe-1;
    	   $data = array(
            'eb_id' => $ebid,
			'absent_warning_date' => $issueDate,
			'absent_warning_no' => $warntobe,
			'prv_warning_no' => $prvwarnno,
			'warning_remarks' => $remarks,
			'join_tag' => 0,
			'close_tag' => 0,
			'long_absent_data_id' => $record_id,
			);
	//	$this->db->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
		$this->db->insert('EMPMILL12.tbl_hrms_absent_warning_data', $data);
//nomc=2
        $sql="select absent_warning_id from EMPMILL12.tbl_hrms_absent_warning_data where eb_id=$ebid and 
        absent_warning_no=$prvwarnno and close_tag=0";
        $query = $this->db->query($sql);
        $row1 = $query->row();
		$cnt = $query->num_rows();
        if ($cnt>0) {
             $prcid = $row1->absent_warning_id;
        }  
        
        $data = array(
             
		 
			'close_tag' => 1,
		 
			);

        $this->db->where('absent_warning_id', $prcid);	
        $this->db->update('EMPMILL12.tbl_hrms_absent_warning_data', $data);
    

  
	$data =[];
	  $response = array(
		'success' => true,
		'savedata'=> 'saved'
	);
	
	$frameNo='';        
	echo json_encode($response);
	
	
		}

			 
		public function updateretattndata() {
			$record_id = $this->input->post('record_id');
			$active=1;
			$data = array(
			'is_active' => $active,
            'is_active' => $record_id,
            'is_active' => $companyId,
            'is_active' => $windingDate,
            'is_active' => $record_id,
            'is_active' => $warntobe,
            'is_active' => $ebid,
            'is_active' => $issueDate,
            'is_active' => $remarks    




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
		 	$compid = $this->input->post('companyId');
		 	$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
			$records=$this->Absent_warning_entry_Model->get_records($date, $compid);
			$cnt=count($records);
            
			$data = [];
			if ($cnt>0) {
				foreach ($records as $record) {
					$data[] = [
						$record['long_absent_data_id'],         // Use array notation instead of object property
						$record['absent_data_tran_date'],       // Use array notation instead of object property
						$record['emp_code'],          // Use array notation instead of object property
						$record['empname'],   // Use array notation instead of object property
						$record['warning_to_be'],       // Use array notation instead of object property
						$record['remarks'],       // Use array notation instead of object property
						$record['warning_date'],      // Use array notation instead of object property
						$record['warntobe'],     // Use array notation instead of object property
						$record['eb_id'],       // Use array notation instead of object property
						      // Use array notation instead of object property
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
            $sql="select mcrun.*,tdl.*,dm.dept_desc from (
                select worked_designation_id,ifnull(mc_id,0) mc_id,GROUP_CONCAT(DISTINCT eb_no SEPARATOR '/') ebnos from ( 
                select worked_department_id,worked_designation_id,working_hours,mc_id,eb_no  from daily_attendance da
                left join (select  daily_atten_id,mc_id from daily_ebmc_attendance dea where is_active=1) dea
                on da.daily_atten_id =dea.daily_atten_id
                where da.is_active =1 and da.attendance_date ='$sdate' and da.worked_department_id =$deptid
                ) g group by worked_designation_id,mc_id
                ) mcrun left join EMPMILL12.tbl_department_layout tdl on mcrun.worked_designation_id=tdl.occu_id 
                and mcrun.mc_id=tdl.mechine_id 
                left join department_master dm on tdl.dept_id=dm.mdept_id"; 
                $query = $this->db->query($sql);
                $cnt = $query->num_rows();
                $row1 = $query->row();
                $s = $row1->dept_id;
                $deptname = $row1->dept_desc;
    

//            $s = '5';

             switch ($s) {
                 case 54:
                    $originalFilePath = './layouts/BEAMING_LAYOUT'; // Path to the original Excel file
                    $filename =$originalFilePath.$tdate.'-'.$shift; // Path to save the modified file
             
                    break;
                 default:
                 $originalFilePath = './uploads/excel_file.xlsx'; // Path to the original Excel file
                 $newFilePath = './uploads/modified_excel_file.xlsx'; // Path to save the modified file
                 break;
             }
             $originalFilePath=$originalFilePath.'.xlsx';
             $filename=$filename.'.xlsx';

     
             // Load the original Excel file
             $spreadsheet = IOFactory::load($originalFilePath);
     
             // Modify the content of the Excel file
             $sheet = $spreadsheet->getActiveSheet();
             $sheet->setCellValue('B1', $tdate); // Example: Modify cell A1
             $sheet->setCellValue('D1', $shift); // Example: Modify cell A1
             $sheet->setCellValue('F1', $deptname); // Example: Modify cell A1
             $query = $this->db->query($sql);
             $data = [];
              $rows = $query->result_array(); 
               if ($cnt>0) {
                    foreach ($rows as $record) {
                      $pos=$record['layout_position'];
                      $ebnos=$record['ebnos'];
                      $sheet->setCellValue($pos, $ebnos); // Example: Modify cell A1

                    }    
               }    

 /*            // Save the modified file as a new file
             $writer = new Xlsx($spreadsheet);
             $writer->save($newFilePath); // Save the modified file
     
             // Return the download link as a JSON response
             $downloadLink = base_url($newFilePath);
             echo json_encode(['download_link' => $downloadLink]);			
*/
//$filename='beaming_layout'.$tdate.$shift.'.xlsx';
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