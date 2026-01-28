<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Calculation\Information\Value;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pfesidata extends CI_Controller {


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
        $this->load->model('Pfesidata_Model'); // Load the model
		$this->load->helper('excel');
//		$this->load->helper('csv');		
		$this->load->helper('form');
		$this->load->helper('url');	
	}
	  public function index()
	{
		//$this->load->view('welcome_message');
	//	$data['records'] = $this->Doffdata_Model->get_all_records();
     //   $this->load->view('record_form', $data);
		

	 require FCPATH . 'vendor/autoload.php';
$this->load->helper('excel');
		
		$this->load->library('form_validation');
		$this->load->model('Pfesidata_Model');

      //  $categories = $this->category_model->get_categories();
        // Pass the data to the view
      //  $data['categories'] = $categories;
      //  $this->load->view('your_view', $data);

       $payschemes=$this->Pfesidata_Model->getPfesidata();
	   $data['payschemes']=$payschemes;

	 //  var_dump($data);
		
		$this->load->view('admin/reports/pfesidata',$data);
		
	}

	public function get_records() {
        $sdate = $this->input->post('sdate');
        $edate = $this->input->post('edate');
        $payScheme = $this->input->post('payscheme');
		$compid = $this->input->post('companyId');
	
		
   // echo 'frame--'.$frameNo;
		$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
		$edate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
		
 
        // Get the records for the specified date and shift
    //    $records = $this->Doffdata_Model->get_records($date, $shift,$compid);
		$sql="select PAYPERIOD_ID,eb_no,wname,fpf_no,pf_no,esi_no,
		max( case when COMPONENT_ID=6 then amount else 0 end ) Days,
		max( case when COMPONENT_ID=7 then amount else 0 end ) Basic,
		max( case when COMPONENT_ID=18 then amount else 0 end ) PF,
		max( case when COMPONENT_ID=66 then amount else 0 end ) Gross1,
		max( case when COMPONENT_ID=19 then amount else 0 end ) esi,
		max( case when COMPONENT_ID=62 then amount else 0 end ) otearnings
		from (
		select tpep.PAYPERIOD_ID,tpp.FROM_DATE,tpp.TO_DATE, tpep.EMPLOYEEID,theod.emp_code eb_no, 
		concat(thepd.first_name ,' ',IFNULL(thepd.middle_name,' ')  ,' ',ifnull(thepd.last_name,' ')) wname,
		COMPONENT_ID,tpc.NAME,thee.esi_no,thep.pf_no ,thep.pf_uan_no fpf_no, AMOUNT,tpep.PAYSCHEME_ID  from 
		tbl_pay_employee_payroll tpep
		left join tbl_pay_period tpp on tpep.PAYPERIOD_ID =tpp.ID 
		left join tbl_pay_components tpc on tpep.COMPONENT_ID =tpc.ID 
		left join tbl_hrms_ed_official_details theod on tpep.EMPLOYEEID =theod.eb_id  and theod.is_active =1
		left join tbl_hrms_ed_personal_details thepd on tpep.EMPLOYEEID =thepd.eb_id 
		left join tbl_hrms_ed_esi thee on tpep.EMPLOYEEID =thee.eb_id  and thee.is_active =1
		left join tbl_hrms_ed_pf thep on tpep.EMPLOYEEID =thep.eb_id   and thep.is_active =1
		where  tpep.COMPONENT_ID in (66,7,6,19,18,62)  
		and tpp.FROM_DATE ='".$sdate."' AND tpp.TO_DATE ='".$edate."' and tpep.PAYSCHEME_ID=".$payScheme." 
		and tpep.BUSINESSUNIT_ID =".$compid." and tpp.STATUS =3
		) g  group by PAYPERIOD_ID,eb_no,wname,fpf_no,pf_no,esi_no
		order by eb_no 	";
		
/*
$sql = "SELECT auto_id, DATE_FORMAT(doffdate, '%d-%m-%Y') doffdate, spell, frameno, trollyno, grosswt, tarewt, netwt ,entrytime
            FROM dofftable 
            WHERE doffdate = ? AND spell = ? AND company_id = ? "; 
			if (strlen($frameNo)>0) {
				$sql=$sql."and frameno = $frameNo ";
			}
		$sql=$sql." 
			AND is_active = 1 
            ORDER BY auto_id DESC";
 */   
	
//	$query = $this->db->query($sql, array($date, $shift, $compid));
	$query = $this->db->query($sql);
$records = $query->result();
		
	//	echo $sql;
	//	$records=$this->db->query($sql);
	//	echo $sql;
		// Prepare the response
        $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->PAYPERIOD_ID,
                $record->eb_no,
                $record->wname,
                $record->pf_no,
                $record->fpf_no,
                $record->esi_no,
                $record->Days,
                $record->Basic,
                $record->PF,
                $record->Gross1,
                $record->esi
                
            ];
        }

        // Return the response
        echo json_encode(['data' => $data]);
    }


    public function createExcel() {
		$fileName = 'employee.xlsx';  
	//	$employeeData = $this->EmployeeModel->employeeList();
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
		$sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Skills');
        $sheet->setCellValue('D1', 'Address');
		$sheet->setCellValue('E1', 'Age');
        $sheet->setCellValue('F1', 'Designation');       
        $rows = 2;
      /*
		foreach ($employeeData as $val){
            $sheet->setCellValue('A' . $rows, $val['id']);
            $sheet->setCellValue('B' . $rows, $val['name']);
            $sheet->setCellValue('C' . $rows, $val['skills']);
            $sheet->setCellValue('D' . $rows, $val['address']);
			$sheet->setCellValue('E' . $rows, $val['age']);
            $sheet->setCellValue('F' . $rows, $val['designation']);
            $rows++;
        } 
        */
		$writer = new Xlsx($spreadsheet);
		$writer->save("upload/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/upload/".$fileName);              
    }    


	public function exportToCsv1() {
        // Replace 'your_query_here' with your actual lengthy SQL query
        $sql = 'SELECT * FROM tbl_pay_scheme'; // Your lengthy query here

        // Execute the query and fetch the data
        $query = $this->db->query($sql);
        $data = $query->result_array();

        // Set the filename for the exported CSV file
        $filename = 'data_export_' . date('YmdHis') . '.csv';

        // Call the helper function to export data to CSV
        export_to_csv($data, $filename);
    }

	public function exportToCsv() {
		$postData = json_decode(file_get_contents('php://input'), true);
		$sdate = $postData['payrollstartdate'];
		$edate = $postData['payrollenddate'];
		$compid = $postData['companyId'];
		$payScheme = $postData['payScheme'];		
		$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
		$edate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
		$sql = 'SELECT * FROM tbl_pay_scheme'; // Your lengthy query here
		$sql="select PAYPERIOD_ID,eb_no,wname,ifnull(pf_no,' ') pf_no ,IFNULL(fpf_no,' ') fpf_no,ifnull(esi_no,' ') esi_no,
		max( case when COMPONENT_ID=6 then amount else 0 end ) Days,
		max( case when COMPONENT_ID=7 then amount else 0 end ) Basic,
		max( case when COMPONENT_ID=18 then amount else 0 end ) PF,
		max( case when COMPONENT_ID=66 then amount else 0 end ) Gross1,
		max( case when COMPONENT_ID=19 then amount else 0 end ) esi
		from (
		select tpep.PAYPERIOD_ID,tpp.FROM_DATE,tpp.TO_DATE, tpep.EMPLOYEEID,theod.emp_code eb_no, 
		concat(thepd.first_name ,' ',IFNULL(thepd.middle_name,' ')  ,' ',ifnull(thepd.last_name,' ')) wname,
		COMPONENT_ID,tpc.NAME,thee.esi_no,thep.pf_no ,thep.pf_uan_no fpf_no, AMOUNT,tpep.PAYSCHEME_ID  from 
		tbl_pay_employee_payroll tpep
		left join tbl_pay_period tpp on tpep.PAYPERIOD_ID =tpp.ID 
		left join tbl_pay_components tpc on tpep.COMPONENT_ID =tpc.ID 
		left join tbl_hrms_ed_official_details theod on tpep.EMPLOYEEID =theod.eb_id  and theod.is_active =1
		left join tbl_hrms_ed_personal_details thepd on tpep.EMPLOYEEID =thepd.eb_id 
		left join tbl_hrms_ed_esi thee on tpep.EMPLOYEEID =thee.eb_id  and thee.is_active =1
		left join tbl_hrms_ed_pf thep on tpep.EMPLOYEEID =thep.eb_id   and thep.is_active =1
		where  tpep.COMPONENT_ID in (66,7,6,19,18,62) 
		and tpp.FROM_DATE ='".$sdate."' AND tpp.TO_DATE ='".$edate."' and tpep.PAYSCHEME_ID=".$payScheme." 
		and tpep.BUSINESSUNIT_ID =".$compid." and tpp.STATUS =3
		) g  group by PAYPERIOD_ID,eb_no,wname,fpf_no,pf_no,esi_no
		order by eb_no 	";
		//echo $sql;
		$query = $this->db->query($sql);
		$data = $query->result_array();

	
		  $filename = 'custom_name_' . date('YmdHis') . '.csv';

		  // Set the response headers to trigger the file download with the specific filename
//		  header('Content-Type: text/csv');
		  header('Content-Type: text/plain');
		  header('Content-Disposition: attachment; filename="' . $filename . '"');
		  header('Cache-Control: max-age=0');
	  
		  // Open a memory stream to write CSV data
		  $stream = fopen('php://memory', 'w');
		  
		  // Write the CSV header row (if needed)
		  $headers = array_keys($data[0]);
		  fputcsv($stream, $headers);
		  
		  // Write each row of data into the CSV
	//	  foreach ($data as $row) {
//			  fputcsv($stream, $row);
//		  }
/*		 
		  foreach ($data as &$row) {
			// For example, remove quotes for the "name" field
			$row['PAYPERIOD_ID'] = $row['PAYPERIOD_ID'];
			$row['eb_no'] = $row['eb_no'];
			$nm= trim(str_replace('"', '', $row['wname']));
//			echo $nm;
			$row['name'] =$nm; 
			//str_replace('"', '', $row['wname']);
	//		echo $row['wname'];
			$row['pf_no'] = $row['pf_no'];
			$row['fpf_no'] = $row['fpf_no'];
			$row['esi_no'] = $row['esi_no'];
			$row['Basic'] = $row['Basic'];
			$row['PF'] = $row['PF'];
			$row['Gross1'] = $row['Gross1'];
			$row['esi'] = $row['esi'];
		//	fputcsv($stream, $row);
 		 
  		}



foreach ($data as $row) {
			$csvRow = [];
			foreach ($row as $field) {
				$csvRow[] = str_replace('"', '', $field);
			}
			fputcsv($stream, $csvRow, ',');
		}
		


foreach ($data as $row) {
	$textRow = implode("\t,",$row) . "\n"; // Use tab as a delimiter between fields
	fwrite($stream, $textRow);
}
*/
foreach ($data as $row) {
    // Apply trim to each value in the row
    $trimmedRow = array_map('trim', $row);

    // Join the trimmed values with a tab delimiter and add a new line at the end
    $textRow = implode("\t,", $trimmedRow) . "\n";

    // Write the row to the text file
    fwrite($stream, $textRow);
}


		  // Reset the stream pointer to the beginning
		  rewind($stream);
		  
		  // Output the CSV data to the browser
		  echo stream_get_contents($stream);
		  exit;
	  }
 	  

/*		
		// Set the desired filename for the CSV file
		$filenam = 'pf_esi_data' . '.csv';
	
		// Set the response headers to trigger the file download with the specific filename
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filenam . '"');
		header('Cache-Control: max-age=0');
	
		// Open a memory stream to write CSV data
		$stream = fopen('php://memory', 'w');
		
		// Write the CSV header row (if needed)
		$headers = array_keys($data[0]);
		fputcsv($stream, $headers);
		
		// Write each row of data into the CSV
//		foreach ($data as $row) {
//			fputcsv($stream, $row);
//		}
		


		
		// Reset the stream pointer to the beginning
		rewind($stream);
		
		// Output the CSV data to the browser
		echo stream_get_contents($stream);
		exit;
	}
*/ 	

public function exportToExcelAjax() {
	// Process the Ajax POST request and retrieve the data
	$payrollstartdate = $this->input->post('payrollstartdate');
	// Retrieve other form field data here

	// Generate the data or query the database based on the provided parameters
	// ... Your code to fetch the data or generate the Excel data ...

	// Generate the Excel file using PhpSpreadsheet
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
	// ... Your code to add data to the spreadsheet ...

	// Save the spreadsheet to a temporary file
	$tempFile = tempnam(sys_get_temp_dir(), 'excel');
	$writer = new Xlsx($spreadsheet);
	$writer->save($tempFile);

	// Return the file URL in the Ajax response
	$response = array(
		'success' => true,
		'fileUrl' => base_url($tempFile)
	);
	echo json_encode($response);
}

public function exportToExcel() {
	// Get the parameters from the URL query string
//	$postData = json_decode(file_get_contents('php://input'), true);
// $this->load->view('admin/reports/pfesidata');


$sdate = $this->input->post('payrollstartdate');
$edate = $this->input->post('payrollenddate');
$payScheme = $this->input->post('payScheme');
$compid = $this->input->post('companyId');

$sdate = $this->input->get('payrollstartdate');
$edate = $this->input->get('payrollenddate');
$payScheme = $this->input->get('payScheme');
$compid = $this->input->get('companyId');


//echo 'aha-'.$sdate;

//$sdate='01-06-2023';
//$edate='30-06-2023';
//$compid=2;
//$payScheme = $this->input->GET('payScheme');

//echo 'date-'.$sdate;
 	$sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
	$edate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
	$sql = 'SELECT * FROM tbl_pay_scheme'; // Your lengthy query here
	$sql="select PAYPERIOD_ID,eb_no,wname,ifnull(pf_no,' ') pf_no ,IFNULL(fpf_no,' ') fpf_no,ifnull(esi_no,' ') esi_no,
	max( case when COMPONENT_ID=6 then amount else 0 end ) Days,
	max( case when COMPONENT_ID=7 then amount else 0 end ) Basic,
	max( case when COMPONENT_ID=18 then amount else 0 end ) PF,
	max( case when COMPONENT_ID=66 then amount else 0 end ) Gross1,
	max( case when COMPONENT_ID=19 then amount else 0 end ) esi
	from (
	select tpep.PAYPERIOD_ID,tpp.FROM_DATE,tpp.TO_DATE, tpep.EMPLOYEEID,theod.emp_code eb_no, 
	concat(thepd.first_name ,' ',IFNULL(thepd.middle_name,' ')  ,' ',ifnull(thepd.last_name,' ')) wname,
	COMPONENT_ID,tpc.NAME,thee.esi_no,thep.pf_no ,thep.pf_uan_no fpf_no, AMOUNT,tpep.PAYSCHEME_ID  from 
	tbl_pay_employee_payroll tpep
	left join tbl_pay_period tpp on tpep.PAYPERIOD_ID =tpp.ID 
	left join tbl_pay_components tpc on tpep.COMPONENT_ID =tpc.ID 
	left join tbl_hrms_ed_official_details theod on tpep.EMPLOYEEID =theod.eb_id  and theod.is_active =1
	left join tbl_hrms_ed_personal_details thepd on tpep.EMPLOYEEID =thepd.eb_id 
	left join tbl_hrms_ed_esi thee on tpep.EMPLOYEEID =thee.eb_id  and thee.is_active =1
	left join tbl_hrms_ed_pf thep on tpep.EMPLOYEEID =thep.eb_id   and thep.is_active =1
	where  tpep.COMPONENT_ID in (66,7,6,19,18,62) 
	and tpp.FROM_DATE >='".$sdate."' AND tpp.TO_DATE <='".$edate."' and tpep.PAYSCHEME_ID=".$payScheme." 
	and tpep.BUSINESSUNIT_ID =".$compid." and tpp.STATUS =3
	) g  group by PAYPERIOD_ID,eb_no,wname,fpf_no,pf_no,esi_no
	order by eb_no 	";

	$query = $this->db->query($sql);
	$data = $query->result_array();

	// Create a new Spreadsheet object
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

    $cmpn="company";
   
  $cmpn="The Empire Jute Co Ltd";
//	$active_sheet->setCellValue('A1', $cmpn);
//	$active_sheet->setCellValue('A2', "Reports for Dated : ");
	// Set company name
	$companyName = "Your Company Name";
//	$sheet->setCellValue('A1', $sql);
//	$sheet->setCellValue('A2', $sql);

 
$sheet->setCellValue('A1', $cmpn);
$sheet->setCellValue('A2', "Reports for Month Ending : ".$edate);

$sheet->setCellValue('A2', 'PayPeriod ID');
$sheet->setCellValue('b2', 'Emp Code');
$sheet->setCellValue('c2', 'Name');
$sheet->setCellValue('d2', 'PF No');
$sheet->setCellValue('e2', 'Uan No');
$sheet->setCellValue('f2', 'ESI NO');
$sheet->setCellValue('g2', 'Days');
$sheet->setCellValue('h2', 'Basic');
$sheet->setCellValue('i2', 'PF Amt');
$sheet->setCellValue('j2', 'ESI Gross');
$sheet->setCellValue('k2', 'ESI Amt');
 
$pfg=$pfa=$esig=$esia=0;

//var_dump($data);
$rowIndex = 3;
	foreach ($data as $row) {
		$columnIndex = 1;
		foreach ($row as $value) {
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			
			if ($columnIndex==8 && intval($value)>0) {
			} 
			if ($columnIndex==9 and $value>0) {
				$pfg=$pfg+$row['Basic'] ;
				$pfa=$pfa+$value;
			} 
			if ($columnIndex==10 and $value>0) {
			} 
			if ($columnIndex==11 and $value>0) {
				$esia=$esia+$value;
				$esig=$esig+$row['Gross1'];
			} 


 /*
			$sheet->setCellValueByColumnAndRow($columnIndex+1, $rowIndex, $pfg);
			$sheet->setCellValueByColumnAndRow($columnIndex+2, $rowIndex, $pfa);
			$sheet->setCellValueByColumnAndRow($columnIndex+3, $rowIndex, $esig);
			$sheet->setCellValueByColumnAndRow($columnIndex+4, $rowIndex, $esia);
			$sheet->setCellValueByColumnAndRow($columnIndex+5, $rowIndex, $value);
*/			

			$columnIndex++;
			
		}
		$rowIndex++;
	}	
	$rowIndex++;
	$rowIndex++;

	$col='c'.$rowIndex;
	$sheet->setCellValue($col, 'Total for PF & ESI');
	$col='H'.$rowIndex;
	$sheet->setCellValue($col, $pfg);
	$col='I'.$rowIndex;
	$sheet->setCellValue($col, $pfa);
	$col='j'.$rowIndex;
	$sheet->setCellValue($col, $esig);
	$col='k'.$rowIndex;
	$sheet->setCellValue($col, $esia);
	$rng='a'.$rowIndex.':k'.$rowIndex;
	$sheet->getStyle($rng)->getFont()->setSize(14)->setBold(true);
 	

	$sheet->mergeCells('A1:k1');
	//$sheet->mergeCells('A2:k2');
	$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
	$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
/*

	// Set report period
	$reportPeriod = "Report Period: $sdate to $edate";
	$sheet->setCellValue('A2', $reportPeriod);
	$sheet->mergeCells('A2:E2');
	$sheet->getStyle('A2')->getFont()->setSize(14)->setBold(true);
	$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	// Set headers
	$headers = ['Column 1', 'Column 2', 'Column 3', 'Column 4', 'Column 5'];
	$columnIndex = 1;
	foreach ($headers as $header) {
		$sheet->setCellValueByColumnAndRow($columnIndex, 3, $header);
		$columnIndex++;
	}

	// Fill data rows
	$rowIndex = 4;
	foreach ($data as $row) {
		$columnIndex = 1;
		foreach ($row as $value) {
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
		}
		$rowIndex++;
	}
*/

	// Set headers for Excel file download
//	ob_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//		header('Content-Type: application/vnd.ms-excel');
	$fl='PF ESI FILE for '.$edate.'.xlsx';
	header('Content-Disposition: attachment;filename='.$fl);
	header('Cache-Control: max-age=0');
	ob_clean();

	// Save the Excel file to output stream
	$writer = new Xlsx($spreadsheet);
	$writer->save('php://output');
	// Save the Excel file to output stream
//	$writer = new Xlsx($spreadsheet);
//	$writer->save('php://output');
/*
$file_type='Xlsx';
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, $file_type);

$file_name = 'Item Data' . '.' . strtolower($file_type);

$writer->save($file_name);

header('Content-Type: application/x-www-form-urlencoded');

header('Content-Transfer-Encoding: Binary');

header("Content-disposition: attachment; filename=\"".$file_name."\"");

readfile($file_name);

unlink($file_name);
*/



}




}
 



