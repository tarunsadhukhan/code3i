<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use Fpdf\Fpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require_once APPPATH . '../vendor/autoload.php';
	

class Absent_warning_entry extends CI_Controller {

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
		$this->load->view('admin/attendance/Absent_warning_entry', $data_to_pass);	
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

		public function addpagepdf($pdf, $tdate) {
			$pdf->SetFont('Arial', 'B', 16);
			$hd1='LONG ABSENTEEISM REPORT Dated '.$tdate;
			// Company Header
			$pdf->SetXY(10, 10);
			$pdf->Cell(0, 10, 'THE EMPIRE JUTE CO PVT. LTD. ', 0, 1,'C');
			$pdf->SetFont('Arial', '', 10);
			$pdf->SetXY(10, 16);
			$pdf->Cell(0, 10,$hd1, 0, 1,'C');
			$pdf->SetLineWidth(0.5); // 0.2 is default
//				$pdf->Line(10, 30, 200, 30);
			// Smaller info under header
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetXY(10, 25);
			$y=20;
			$pdf->SetLineWidth(.25);
			$pdf->line(3,$y+5,203,$y+5);

			$x=5;
			$pdf->SetXY($x,$y);
			 $pdf->Cell(30,15,'EB NO',0,0,'C');
			$x=$x+30;
			$pdf->SetXY($x,$y);
			 $pdf->Cell(30,15,'NAME ',0,0,'L');
			$x=$x+40;
			$pdf->SetXY($x,$y);
			 $pdf->Cell(30,15,'DEPARTMENT',0,0,'L');
			$x=$x+40;
			$pdf->SetXY($x,$y);
			 $pdf->Cell(30,15,'CATAGORY',0,0,'L');
			$x=$x+30;
			$pdf->SetXY($x,$y);
			 $pdf->Cell(30,15,'LAST WORKING ',0,0,'L');
			$x=$x+30;
			$pdf->SetXY($x,$y);
			 $pdf->Cell(30,15,'ABSENT FOR',0,0,'L');
			$x=150;
			$pdf->SetXY($x,$y+4);
			 $pdf->Cell(30,15,'/LEAVE DATE',0,0,'L');
			$x=$x+30;
			$pdf->SetXY($x,$y+4);
			 $pdf->Cell(30,15,' (DAYS) ',0,0,'L');
			
			
			$pdf->SetLineWidth(.25);
			$pdf->line(3,$y+15,203,$y+15);
			$y=$y+14;
}


public function addwarnpagepdf($pdf, $tdate) {

$y=15;
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$hd1='LONG ABSENTEEISM WARNINGS REPORT Dated '.$tdate;
// Company Header
$pdf->SetXY(10, 10);
$pdf->Cell(0, 10, 'THE EMPIRE JUTE CO PVT. LTD. ', 0, 1,'C');
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10, 16);
$pdf->Cell(0, 10,$hd1, 0, 1,'C');
$pdf->SetLineWidth(0.5); // 0.2 is default
//				$pdf->Line(10, 30, 200, 30);
// Smaller info under header
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY(10, 25);
$y=20;
$pdf->SetLineWidth(.25);
$pdf->line(3,$y+5,203,$y+5);

$x=5;
$pdf->SetXY($x,$y);
 $pdf->Cell(30,15,'EB NO',0,0,'C');
$x=$x+30;
$pdf->SetXY($x,$y);
 $pdf->Cell(30,15,'NAME ',0,0,'L');
$x=$x+40;
$pdf->SetXY($x,$y);
 $pdf->Cell(30,15,'DEPARTMENT',0,0,'L');
$x=$x+40;
$pdf->SetXY($x,$y);
 $pdf->Cell(30,15,'CATAGORY',0,0,'L');
$x=$x+30;
$pdf->SetXY($x,$y);
 $pdf->Cell(30,15,'LAST WORKING ',0,0,'L');
$x=$x+30;
$pdf->SetXY($x,$y);
 $pdf->Cell(30,15,'ABSENT FOR',0,0,'L');
$x=150;
$pdf->SetXY($x,$y+4);
 $pdf->Cell(30,15,'/LEAVE DATE',0,0,'L');
$x=$x+30;
$pdf->SetXY($x,$y+4);
$pdf->Cell(30,15,' (DAYS/Warn No) ',0,0,'L');
$pdf->SetLineWidth(.25);
$pdf->line(3,$y+16,203,$y+16);
$y=$y+14;

}


public function preexportpbfdata() {
	$windingDate = $this->input->post('payrollstartdate');
	$tdate = $this->input->get('payrollstartdate');
	$windingDate=substr($tdate,6,4).'-'.substr($tdate,3,2).'-'.substr($tdate,0,2);
	$issueDate= $this->input->get('issueDate');
	
	$issueDate=substr($issueDate,6,4).'-'.substr($issueDate,3,2).'-'.substr($issueDate,0,2);
	$companyId = $this->input->post('companyId');
	$compid = $this->input->get('companyId');

	$pdf = new \FPDF();
	$all=0;
	$this->absentwarningletters($pdf,$tdate,$windingDate,$all,$issueDate)	;

	$fl="Long_absentism_report_".$tdate.".pdf";
 		
	// Set HTTP headers explicitly (optional but good for compatibility)
	header('Content-Type: application/pdf');
	header('Content-Disposition: attachment; filename="'.$fl);
	header('Cache-Control: private, max-age=0, must-revalidate');
	header('Pragma: public');

	// Output PDF to browser (force download)
	$pdf->Output($fl, 'D');




}

			public function exportpdfdata() {
				// No output before headers
				// Create a new PDF
				$windingDate = $this->input->post('payrollstartdate');
				$tdate = $this->input->get('payrollstartdate');
				$windingDate=substr($tdate,6,4).'-'.substr($tdate,3,2).'-'.substr($tdate,0,2);
				$issueDate = $this->input->get('issueDate');
				$issueDate=substr($issueDate,6,4).'-'.substr($issueDate,3,2).'-'.substr($issueDate,0,2);
				$idate=$this->input->get('issueDate');
				$companyId = $this->input->post('companyId');
				$compid = $this->input->get('companyId');
		
				$pdf = new \FPDF();
				$pdf->AddPage();
				// Set font
				$pdf->SetFont('Arial', 'B', 16);
				$hd1='LONG ABSENTEEISM REPORT Dated '.$tdate;
				// Company Header
				$pdf->SetXY(10, 10);
				$pdf->Cell(0, 10, 'THE EMPIRE JUTE CO PVT. LTD. ', 0, 1,'C');
				$pdf->SetFont('Arial', '', 10);
				$pdf->SetXY(10, 16);
				$pdf->Cell(0, 10,$hd1, 0, 1,'C');
				$pdf->SetLineWidth(0.5); // 0.2 is default
//				$pdf->Line(10, 30, 200, 30);
				// Smaller info under header
				$pdf->SetFont('Arial', '', 8);
				$pdf->SetXY(10, 25);
				$y=20;
				$pdf->SetLineWidth(.25);
				$pdf->line(3,$y+5,203,$y+5);

				$x=5;
				$pdf->SetXY($x,$y);
				 $pdf->Cell(30,15,'EB NO',0,0,'C');
				$x=$x+30;
				$pdf->SetXY($x,$y);
				 $pdf->Cell(30,15,'NAME ',0,0,'L');
				$x=$x+40;
				$pdf->SetXY($x,$y);
				 $pdf->Cell(30,15,'DEPARTMENT',0,0,'L');
				$x=$x+40;
				$pdf->SetXY($x,$y);
				 $pdf->Cell(30,15,'CATAGORY',0,0,'L');
				$x=$x+30;
				$pdf->SetXY($x,$y);
				 $pdf->Cell(30,15,'LAST WORKING ',0,0,'L');
				$x=$x+30;
				$pdf->SetXY($x,$y);
				 $pdf->Cell(30,15,'ABSENT FOR',0,0,'L');
				$x=150;
				$pdf->SetXY($x,$y+4);
				 $pdf->Cell(30,15,'/LEAVE DATE',0,0,'L');
				$x=$x+30;
				$pdf->SetXY($x,$y+4);
				 $pdf->Cell(30,15,' (DAYS) ',0,0,'L');
				
				
				$pdf->SetLineWidth(.25);
				$pdf->line(3,$y+15,203,$y+15);
				$y=$y+14;
				$sql="select emp_code,CONCAT(trim(thepd.first_name), ' ', IFNULL(trim(thepd.middle_name), ''), ' ', IFNULL(trim(thepd.last_name), '')) AS empname,
				dept_desc,cata_desc,date_format(DATE_ADD(thlad.absent_data_from_date, INTERVAL -1 DAY)  ,'%d-%m-%Y')  lastwkd,thlad.no_of_days_absent
				from EMPMILL12.tbl_hrms_long_absent_data thlad 
				left join tbl_hrms_ed_personal_details thepd on thepd.eb_id=thlad.eb_id
				left join (select * from tbl_hrms_ed_official_details theod where is_active=1) theod on theod.eb_id=thlad.eb_id
				left join category_master cm on cm.cata_id =theod.catagory_id 
				left join department_master dm on dm.dept_id =theod.department_id
				where thlad.absent_data_tran_date ='".$windingDate."' and prev_warning_no=0 order by dept_code,emp_code";
				$query = $this->db->query($sql);
				$data = $query->result_array();
				foreach ($data as $record) {
					if ($y>250) {
						$y=30;
						$pdf->AddPage();
						$this->addpagepdf($pdf, $tdate);
					}
					$x=5;
					$pdf->SetXY($x,$y);
					$pdf->Cell(30,15,$record['emp_code'],0,0,'C');
					$x=$x+30;
					$pdf->SetXY($x,$y);
					$pdf->Cell(30,15,$record['empname'],0,0,'L');
					$x=$x+40;
					$pdf->SetXY($x,$y);
					$pdf->Cell(30,15,$record['dept_desc'],0,0,'L');
					$x=$x+40;
					$pdf->SetXY($x,$y);
					$pdf->Cell(30,15,$record['cata_desc'],0,0,'L');
					$x=$x+30;
					$pdf->SetXY($x,$y);
					$pdf->Cell(30,15,$record['lastwkd'],0,0,'L');
					$x=$x+30;
					$pdf->SetXY($x,$y);
					$pdf->Cell(22,15,$record['no_of_days_absent'],0,0,'R');
					
					$pdf->SetLineWidth(.25);
					$pdf->line(3,$y+16,203,$y+16);
					$y=$y+14;

			}
			
			$x=5;
			$pdf->SetXY($x,$y);
			$st="Workers were absent for 10 days and more, Please take necessary action";
			$pdf->Cell(30,10,$st,0,0,'L');
	
			$y=15;
			$sql="select emp_code,CONCAT(trim(thepd.first_name), ' ', IFNULL(trim(thepd.middle_name), ''), ' ', IFNULL(trim(thepd.last_name), '')) AS empname,
			dept_desc,cata_desc,date_format(thlad.absent_data_from_date,'%d-%m-%Y') lastwkd,thlad.no_of_days_absent,thawd.absent_warning_no,
			case when thawd.absent_warning_no=1 then '1st Warning' 
				when thawd.absent_warning_no=2 then '2nd Warning'
				when thawd.absent_warning_no=3 then '3rd Warning'
				when thawd.absent_warning_no=4 then 'Show Cause'
				when thawd.absent_warning_no>4 then 'Show Caused' end warntext,thawd.absent_warning_date 
			from EMPMILL12.tbl_hrms_absent_warning_data thawd
			left join EMPMILL12.tbl_hrms_long_absent_data thlad on thawd.long_absent_data_id=thlad.long_absent_data_id
			left join tbl_hrms_ed_personal_details thepd on thepd.eb_id=thlad.eb_id
			left join (select * from tbl_hrms_ed_official_details theod where is_active=1) theod on theod.eb_id=thlad.eb_id
			left join category_master cm on cm.cata_id =theod.catagory_id 
			left join department_master dm on dm.dept_id =theod.department_id
			where thawd.absent_warning_date ='".$windingDate."' and thawd.is_active =1 
			order by thawd.absent_warning_no,dept_code";
			$query = $this->db->query($sql);
			$data = $query->result_array();
			foreach ($data as $record) {
			if ($y==15) {
					$this->addwarnpagepdf($pdf, $tdate);
				$y=$y+20;
				}

			$x=5;
			$pdf->SetXY($x,$y);
			$pdf->Cell(30,15,$record['emp_code'],0,0,'C');
			$x=$x+30;
			$pdf->SetXY($x,$y);
			$pdf->Cell(30,15,$record['empname'],0,0,'L');
			$x=$x+40;
			$pdf->SetXY($x,$y);
			$pdf->Cell(30,15,$record['dept_desc'],0,0,'L');
			$x=$x+40;
			$pdf->SetXY($x,$y);
			$pdf->Cell(30,15,$record['cata_desc'],0,0,'L');
			$x=$x+30;
			$pdf->SetXY($x,$y);
			$pdf->Cell(30,15,$record['lastwkd'],0,0,'L');
			$x=$x+30;
			$pdf->SetXY($x,$y);
			$pdf->Cell(22,15,$record['no_of_days_absent'],0,0,'R');
			$y=$y+5;
			$pdf->SetXY($x,$y);
			$pdf->Cell(22,15,$record['warntext'],0,0,'R');
			$pdf->SetLineWidth(.25);
			$pdf->line(3,$y+16,203,$y+16);
			
			$y=$y+14;

		if ($y>250) {
			$y=15;
 		}

	}
	$all=1;
	$this->absentwarningletters($pdf,$tdate,$windingDate,$all,$issueDate)	;
	 
 

				$fl="Long_absentism_report_".$tdate.".pdf";
 		
				// Set HTTP headers explicitly (optional but good for compatibility)
				header('Content-Type: application/pdf');
				header('Content-Disposition: attachment; filename="'.$fl);
				header('Cache-Control: private, max-age=0, must-revalidate');
				header('Pragma: public');
		
				// Output PDF to browser (force download)
				$pdf->Output($fl, 'D');
			}
		
public function absentwarningletters($pdf,$tdate,$windingDate,$all,$issueDate) {
	$idate=substr($issueDate,8,2).'-'.substr($issueDate,5,2).'-'.substr($issueDate,0,4);
//	2025-05-24		
			$sql="select thawd.eb_id,emp_code,CONCAT(trim(thepd.first_name), ' ', IFNULL(trim(thepd.middle_name), ''), ' ', IFNULL(trim(thepd.last_name), '')) AS empname,
			dept_desc,cata_desc,date_format(thlad.absent_data_from_date,'%d-%m-%Y') lastwkd,
			thlad.no_of_days_absent,thawd.absent_warning_no,
			case when thawd.absent_warning_no=1 then '1st Warning' 
			when thawd.absent_warning_no=2 then '2nd Warning'
			when thawd.absent_warning_no=3 then '3rd Warning'
			when thawd.absent_warning_no=4 then 'Show Cause'
			when thawd.absent_warning_no>4 then 'Show Caused' end warntext,thawd.absent_warning_date 
				from EMPMILL12.tbl_hrms_absent_warning_data thawd
			left join EMPMILL12.tbl_hrms_long_absent_data thlad on thawd.long_absent_data_id=thlad.long_absent_data_id
			left join tbl_hrms_ed_personal_details thepd on thepd.eb_id=thlad.eb_id
			left join (select * from tbl_hrms_ed_official_details theod where is_active=1) theod on theod.eb_id=thlad.eb_id
			left join category_master cm on cm.cata_id =theod.catagory_id 
			left join department_master dm on dm.dept_id =theod.department_id
			where thawd.absent_warning_date ='".$issueDate."' and thawd.is_active =1 ";
			if ($all==0) { $sql=$sql." and thawd.absent_warning_no=1"; }
			$sql=$sql." order by thawd.absent_warning_date,dept_code "; 
			$query = $this->db->query($sql);
			$data = $query->result_array();
			$pdf->SetFont('Arial','',9);
			$pdf->SetFont('Arial','',14);
			$y=15;

//
foreach ($data as $record) {

	$pdf->AddPage();
	$pdf->SetFont('Arial','',9);
	$pdf->SetFont('Arial','',14);
	$y=15;
		$x=15;
		$pdf->SetXY($x,$y);
  	 $pdf->Cell(180,15,'Date : '.$idate,0,0,'R');
		$y=$y+14;
		$pdf->SetFont('Arial','U',16);
		$pdf->SetXY($x,$y);
		 $pdf->Cell(180,15,'Long Absent',0,0,'C');
		$y=$y+10;
		$pdf->SetFont('Arial','U',16);
		$pdf->SetXY($x,$y);
		 $pdf->Cell(180,15,$record['warntext'],0,0,'C');
		$y=$y+14;
		$pdf->SetFont('Arial','',12);
		$pdf->SetXY($x,$y);
		 $pdf->Cell(30,15,'EB No           : '.$record['emp_code'],0,1,'L');
		$y=$y+8;
		$pdf->SetXY($x,$y);
		 $pdf->Cell(30,15,'Name            : '.$record['empname'],0,1,'L');
		$y=$y+8;
		$pdf->SetXY($x,$y);
		 $pdf->Cell(30,15,'Department   : '.$record['dept_desc'],0,0,'L');
		$y=$y+20;

		///1st	

		if ($record['absent_warning_no']==1) {
			$dtf=$record['lastwkd'];	
			$pdf->SetFont('Arial','',12);
			$lnw="It revealed from the record that you have been absenting from work since ".$dtf."  without";
			$pdf->SetXY($x,$y);
			 $pdf->Cell(200,15,$lnw,0,0,'L');
			$y=$y+8;
			$lnw="obtaining  leave.  The  said   unauthorized  absence  without  information  for  more   than 10";
			$pdf->SetXY($x,$y);
			 $pdf->Cell(200,15,$lnw,0,0,'L');
			$y=$y+8;
			$lnw="consecutive days is  a gross misconduct on your part under rule 14C (v) of Certified Standing";
			$pdf->SetXY($x,$y);
			 $pdf->Cell(200,15,$lnw,0,0,'L');
			$y=$y+8;
			$lnw="Order of the company, with which you are charged herein. ";
			$pdf->SetXY($x,$y);
			 $pdf->Cell(200,15,$lnw,0,0,'L');
			$y=$y+10;
			
			
			$lnw="It is presumed that you  are no  more    interested to   continue your   employment  with the  ";
			$pdf->SetXY($x,$y);
			 $pdf->Cell(200,15,$lnw,0,0,'L');
			$y=$y+8;
			$lnw="company.  ";
			$pdf->SetXY($x,$y);
			 $pdf->Cell(200,15,$lnw,0,0,'L');
			$y=$y+8;
			$lnw="However for the sake of natural justice you are hereby provided an opportunity and strongly  ";
			$pdf->SetXY($x,$y);
			 $pdf->Cell(200,15,$lnw,0,0,'L');
			$y=$y+8;
			
			$lnw="warned not to repeat the misconduct in future. You are advised to   report to your duty within";
			$pdf->SetXY($x,$y);
			 $pdf->Cell(200,15,$lnw,0,0,'L');
			$y=$y+8;
			$lnw="7 days  from the  receipt of  this  letter or to  explain the  reason of absence in writing to the";
			$pdf->SetXY($x,$y);
			 $pdf->Cell(200,15,$lnw,0,0,'L');
			$y=$y+8;
			$lnw="management.";
			$pdf->SetXY($x,$y);
			 $pdf->Cell(200,15,$lnw,0,0,'L');
			$y=$y+40;
		

			}
		///1st	
		
///2nd	
if ($record['absent_warning_no']==2) {
	$dtf=$record['lastwkd'];	
	$pdf->SetFont('Arial','',12);
	$lnw="It revealed from the record that you have been absenting from work since ".$dtf."  without";
	$dtw='2025-01-01';
	$ebid=$record['eb_id'];
	$wno=$record['absent_warning_no'];
	$wsql="select date_foRmat(absent_warning_date,'%d-%m-%Y') absent_warning_date from EMPMILL12.tbl_hrms_absent_warning_data thawd where 
	eb_id=".$record['eb_id']." and is_active=1 and 
	absent_warning_no <".$record['absent_warning_no'];
//echo $wsql;

 	$wquery = $this->db->query($wsql);
	$wdata = $wquery->result_array();
	$dtw = null; // default in case no record found

	foreach ($wdata as $wrecord) {
		$dtw = $wrecord['absent_warning_date'];
		$lnw="Ref:  Our letter dated : ".$dtw ;
		$pdf->SetXY($x,$y);
		$pdf->Cell(200,15,$lnw,0,0,'L');
	   $y=$y+14;
   
	}
 	
	$dtf=$record['lastwkd'];	
	 $pdf->SetFont('Arial','',12);


/* 	$lnw="Ref:  Our letter dated ".$ebid.' '.$wno ;
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+14;
 */

	$lnw="With reference to the above, it is observed that you have neither reported to your duties within  ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;


	$lnw="the stipulated period mentioned  in our earlier letter nor intimated  to the management in writing ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="the reason  for  your unauthorized absence, therefore  it is  presumed  that  you are  no  more";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="interested to continue your work with the company and accordingly your name will be struck off";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;

	$lnw="from the master roll of the company.  ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+10;
	
	
	$lnw="However you are provided another opportunity and   advised  to explain in writing within 3 days   ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	
	$lnw="in receipt of this letter the reason for your unauthorized absence , failing which your name will";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="be struck off from the muster  roll of the  company for  committing  gross misconduct  under rule ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="14(C)(V) standing order of the company. ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+40;

	}
///2nd

///3rd	




if ($record['absent_warning_no']==3) {
	$dtf=$record['lastwkd'];	
	$pdf->SetFont('Arial','',12);
	$lnw="It revealed from the record that you have been absenting from work since ".$dtf."  without";
	$dtw='2025-01-01';
	$ebid=$record['eb_id'];
	$wno=$record['absent_warning_no'];
	$wsql="select date_foRmat(absent_warning_date,'%d-%m-%Y') absent_warning_date from EMPMILL12.tbl_hrms_absent_warning_data thawd where 
	eb_id=".$record['eb_id']." and is_active=1 and 
	absent_warning_no <".$record['absent_warning_no'];
//echo $wsql;

 	$wquery = $this->db->query($wsql);
	$wdata = $wquery->result_array();
	$dtw = null; // default in case no record found

	foreach ($wdata as $wrecord) {
		$dtw = $wrecord['absent_warning_date'];
		$lnw="Ref:  Our letter dated : ".$dtw ;
		$pdf->SetXY($x,$y);
		$pdf->Cell(200,15,$lnw,0,0,'L');
	   $y=$y+14;
   
	}
 	
	$dtf=$record['lastwkd'];	
	 $pdf->SetFont('Arial','',12);


 	$y=$y+8;
		
	$pdf->SetFont('Arial','',12);




	$lnw="It is observed that inspite of serving several warning letters mentioned above you have not";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;


	$lnw=" submitted  your  explanation in writing stating  the reason of your  unauthorized  absence,";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw=" therefore it is presumed that you have  no explanation to offer and accordingly your name";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw=" will be struck off from the muster roll of company  for  committing  gross misconduct under";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;

	$lnw=" rule 14 (C) (V) standing order of the company.  ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+10;
	
	
	$lnw="However for the sake of natural justice  you  are  provided a last and  final  opportunities to";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	
	$lnw=" submit an explanation in writing to the Personnel Department within 3 days of the receipt ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="of this letter as to why disciplinary action amounting to struck off your name from the muster";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw=" roll of the company will not be taken against you, failing which your name will be struck off "; 
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="from the muster roll of the company without any further reference to you."; 
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+40;

	}
///3rd
///4th	




if ($record['absent_warning_no']==4) {
	$dtf=$record['lastwkd'];	
	$pdf->SetFont('Arial','',12);
	$lnw="It revealed from the record that you have been absenting from work since ".$dtf."  without";
	$dtw='2025-01-01';
	$ebid=$record['eb_id'];
	$wno=$record['absent_warning_no'];
	$wsql="select date_foRmat(absent_warning_date,'%d-%m-%Y') absent_warning_date from EMPMILL12.tbl_hrms_absent_warning_data thawd where 
	eb_id=".$record['eb_id']." and is_active=1 and 
	absent_warning_no <".$record['absent_warning_no'];
//echo $wsql;

 	$wquery = $this->db->query($wsql);
	$wdata = $wquery->result_array();
	$dtw = null; // default in case no record found

	foreach ($wdata as $wrecord) {
		$dtw = $wrecord['absent_warning_date'];
		$lnw="Ref:  Our letter dated : ".$dtw ;
		$pdf->SetXY($x,$y);
		$pdf->Cell(200,15,$lnw,0,0,'L');
	   $y=$y+14;
   
	}
 	
	$dtf=$record['lastwkd'];	
	 $pdf->SetFont('Arial','',12);


 	$y=$y+8;
	$pdf->SetFont('Arial','',12);




	$lnw="With reference to the above  Warning  Letters,it is  observed  that  we  have not ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;


	$lnw="received any written reply / explanation from your end. Therefore,it is understood ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="that you have no explanation to offer, and you are no more interested to continue ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="your service with the company and left the services on your own accord.";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;

	$lnw="  ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+10;
	
	
	$lnw="In accordance with the above situation, as per the Standing Order of the company, ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="we are striking your name off from the Muster Roll of the company for committing ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="gross misconduct as per cl. 14 (C) (V) standing order of the company which reads ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+8;
	$lnw="as under cl. 14 (C) (v) habitual absence without leave of absence for more than 10  ";
    $pdf->SetXY($x,$y);
 	$pdf->Cell(200,15,$lnw,0,0,'L');
	$y=$y+10;

	$lnw="days.  ";
    $pdf->SetXY($x,$y);
	$pdf->Cell(200,15,$lnw,0,0,'L');
 	$y=$y+40;

	
	
	}
///4th






	
		$pdf->SetLineWidth(.25);
		$pdf->line(15,$y,60,$y);
		 $lnw="Personnel Manager";
		$pdf->SetXY($x,$y);
		 $pdf->Cell(200,15,$lnw,0,0,'L');
		$y=$y+14;
	

}
//




			}


		public function processwarning_data() {
           
			$windingDate = $this->input->post('windingDate');
			$issueDate = $this->input->post('issueDate');
			$companyId = $this->input->post('companyId');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$issueDate=substr($issueDate,6,4).'-'.substr($issueDate,3,2).'-'.substr($issueDate,0,2);
			$fnd="N";
			$sql="select count(*) warncount from EMPMILL12.tbl_hrms_long_absent_data 
			where absent_data_tran_date='".$windingDate."'";
			$query = $this->db->query($sql);
			$row1 = $query->row();
			$cnt = $query->num_rows();
			if ($cnt>0) {
				 $wcnt = $row1->warncount;
			}  
			
			if ($wcnt==0) {	


			$sql="insert into EMPMILL12.tbl_hrms_long_absent_data (eb_id,absent_data_from_date,absent_data_to_date,
			absent_data_tran_date,absent_data_tran_type,no_of_days_absent,prev_warning_no,close_open_tag,company_id
			)
			SELECT 
				eb_id,
				DATE_ADD(mxdt, INTERVAL 1 DAY) AS absent_data_from_date,
				curdate AS absent_data_to_date,
				curdate AS absent_data_tran_date,
				'L' AS absent_data_tran_type,
				absent_days - nwd AS no_of_days_absent,
				ifnull(mxwarn,0) AS prev_warning_no,
				1 AS close_open_tag,
				2 AS company_id
			FROM (
				SELECT 
					abs.eb_id,
					theod.emp_code eb_no,
					abs.mxdt,
					DATEDIFF('$windingDate', abs.mxdt) AS absent_days,
					'$windingDate' AS curdate,
					(
						SELECT COUNT(*) 
						FROM EMPMILL12.tbl_non_working_days tnwd 
						WHERE is_active = 1 
						  AND tnwd.non_working_date BETWEEN abs.mxdt AND '$windingDate'
					) AS nwd,
					thawd.mxwarn
				FROM (
					SELECT eb_id, MAX(attendance_date) AS mxdt
					FROM (
						SELECT DISTINCT 
							eb_id, attendance_date
						FROM daily_attendance 
						WHERE company_id = 2
						  AND is_active = 1 
						  AND attendance_type = 'R'
						  AND attendance_date <= '$windingDate'
						UNION ALL
						SELECT 
							lt.eb_id, ltd.leave_date AS attendance_date
						FROM leave_transactions lt 
						LEFT JOIN leave_tran_details ltd 
							ON lt.leave_transaction_id = ltd.ltran_id AND ltd.is_active = 1
						LEFT JOIN EMPMILL12.tbl_non_working_days tnwd 
							ON ltd.leave_date = tnwd.non_working_date AND tnwd.is_active = 1
						WHERE lt.company_id = 2
						  AND lt.status = 3
						  AND ltd.leave_date <= '$windingDate'
						  AND tnwd.non_working_date IS NULL
					union all	  
						select eb_id,ret_attend_date AS attendance_date from EMPMILL12.tbl_daily_ret_attendance tdra where tdra.ret_attend_date <='$windingDate' and is_active=1
					) AS combined_attendance
					GROUP BY eb_id
				) AS abs
				LEFT JOIN tbl_hrms_ed_personal_details thepd  
					ON abs.eb_id = thepd.eb_id
				left join (select * from tbl_hrms_ed_official_details theod where is_active=1) theod 
				on abs.eb_id=theod.eb_id
				LEFT JOIN (
					SELECT 
						eb_id,
						MAX(absent_warning_no) AS mxwarn
					FROM EMPMILL12.tbl_hrms_absent_warning_data
					WHERE close_tag = 0
					GROUP BY eb_id
				) AS thawd 
					ON abs.eb_id = thawd.eb_id
				WHERE theod.catagory_id IN (3,4,5,6,7)
				  AND thepd.is_active = 1
			) AS alld
			WHERE (absent_days - nwd) >= 10  
 ";
			$this->db->query($sql);
//			$this->db->close();
					



			$fnd=true;
			$saved="Processed Successfully";

			$sql="insert into EMPMILL12.tbl_hrms_absent_warning_data (absent_warning_date,absent_warning_no,
			long_absent_data_id,created_date_time,eb_id,
			prv_warning_no)
			select '$issueDate' awd,mxwarnno+1 awn,thlad.long_absent_data_id,CURRENT_TIMESTAMP() cdt,thlad.eb_id,mxwarnno
			from EMPMILL12.tbl_hrms_long_absent_data thlad
			left join (select eb_id,max(absent_warning_date) mxwrndate,max(absent_warning_no) mxwarnno from  
			EMPMILL12.tbl_hrms_absent_warning_data thawd group by eb_id ) thawd on thawd.eb_id=thlad.eb_id 
			where absent_data_tran_date ='$windingDate' and prev_warning_no >0
			and DATEDIFF('$windingDate',mxwrndate)>=10";
			$this->db->query($sql);

					

			} else {
			$fnd=false;		
			$saved="Already Processed ";
			//$this->exportpdfdata();
				}

  
	$data =[];
	  $response = array(
		'success' => $fnd,
		'savedata'=> $saved
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
		$prcid=0;	
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
		$this->db->close();	

  
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