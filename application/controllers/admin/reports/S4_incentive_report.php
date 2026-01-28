<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
	

class S4_incentive_report extends CI_Controller {

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
		$this->load->model('S4_incentive_report_model');
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
		$this->load->view('admin/reports/S4_incentive_report', $data_to_pass);	
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

	public function get_s4incentivedata() {
        $companyId = $this->input->post('companyId');
		$windingperfromDate = $this->input->post('sdate');
		$windingpertodDate = $this->input->post('edate');
		$loomtype = $this->input->post('loomtype');
		$windingperfrDate=substr($windingperfromDate,6,4).'-'.substr($windingperfromDate,3,2).'-'.substr($windingperfromDate,0,2);
		$windingpertoDate=substr($windingpertodDate,6,4).'-'.substr($windingpertodDate,3,2).'-'.substr($windingpertodDate,0,2);


		$this->load->model('S4_incentive_report_model');
		
		$records = $this->S4_incentive_report_model->get_s4incentivedata($companyId,$windingperfrDate,$windingpertoDate,
        $loomtype);

		$cnt=count($records);
//		echo 'no record-'. $cnt;
        $result=$records;

		$cnt=count($records);
        $data=[];
        $cols = array_keys($result[0]);

        if ($cnt>0) {
                foreach ($records as $record) {
                    $row = [];

                    foreach ($cols as $colName) {
                        $row[] = isset($record[$colName]) ? $record[$colName] : '';
                    }

                $data[] = $row;
                }
		    }
//var_dump($data);	
		// Return the response
			echo json_encode(['data' => $data]);
		}


    


	public function get_dailyloomdataexl() {
        $companyId = $this->input->get('companyId');
		$windingperfromDate = $this->input->get('windingperfrDate');
		$windingpertodDate = $this->input->get('windingpertoDate');
		$loomtype = $this->input->get('loomtype');
		$windingperfrDate=substr($windingperfromDate,6,4).'-'.substr($windingperfromDate,3,2).'-'.substr($windingperfromDate,0,2);
		$windingpertoDate=substr($windingpertodDate,6,4).'-'.substr($windingpertodDate,3,2).'-'.substr($windingpertodDate,0,2);


		$this->load->model('S4_incentive_report_model');
		$records = $this->S4_incentive_report_model->get_s4incentivedata($companyId,$windingperfrDate,$windingpertoDate,
        $loomtype);

		$cnt=count($records);
	//	echo 'no record-'. $cnt;
        $result=$records;
 
   // var_dump($result);
//    $query = $this->Njmallwagesprocess->getcntwagespayslip($periodfromdate,$periodtodate,$att_payschm);
    if (!$result) {
        echo "Query failed.";
        return;
    }
    
if (empty($result) || count($result) == 0) {
    echo "No data found.";
    return;
}
        $query = $result;
//    echo "Total Rows: " . $result->num_rows() . "<br>";

	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
$sheet->getPageSetup()
      ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

// (Optional) Fit sheet to A4 paper
$sheet->getPageSetup()
      ->setPaperSize(PageSetup::PAPERSIZE_A4);

// (Optional) Fit to one page wide
$sheet->getPageSetup()
      ->setFitToWidth(1)
      ->setFitToHeight(0);

						$borderStyle = [
							'borders' => [
								'allBorders' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
								],
							],
						];
						$boldFontStyle = [
							'font' => [
								'bold' => true,
								'size' => 10,
							],
						];
$hed1="The Empire Jute Co Ltd"; 
if ($loomtype=='41') {
	$hed='S4 Weavers Incentive For the Peirod From '.$windingperfromDate.' To '.$windingpertodDate;
} else {
	$hed='S4 Helpers Incentive For the Peirod From '.$windingperfromDate.' To '.$windingpertodDate;
}
$sheet->setCellValue('A1', $hed1);
$sheet->setCellValue('A2', $hed);
//$sheet->setCellValue('A2', 'CONTRACTOR WORKERS BANK STATEMENT');


$rowNumber = 4;

$tpay=0;

$columnNames = array_keys($result[0]);
//echo "Column Names: " . implode(", ", $columnNames) . "<br>";
$col = 'A';
    foreach ($columnNames as $column) {
        $sheet->setCellValue($col.'3', $column);
        $col++;
    }
$tcols=$col;

$N=1;
$b='A'.$N.':'.$col.$N;
$sheet->mergeCells($b);
$N=2;
$b='A'.$N.':'.$col.$N;
$sheet->mergeCells($b);


  $spreadsheet->getDefaultStyle()->getFont()->setSize(10);



$rowNumber = 4;

foreach ($result as $row) {
    $col = 'A';
    $colno = 0;

    foreach ($row as $cell) {
        if ($colno <= 0) {
            $sheet->setCellValueExplicit($col . $rowNumber, $cell, DataType::TYPE_STRING);
        } else {
            $sheet->setCellValue($col . $rowNumber, $cell);
//            $tpay=$tpay+$row->NET_PAY;
        }
//$sheet->getStyle($cell)->getFont()->setSize(10);

        $col++;     // move outside
        $colno++;   // move outside
    }

    $rowNumber++;
}

$rn='k'.$rowNumber;
$sheet->setCellValue($rn, $tpay);

    foreach (range('A', $col) as $col) {
   //     $sheet->getColumnDimension($col)->setAutoSize(true);
    }
$col = chr(ord($tcols) - 1);   

 
						 $sheet->getColumnDimension('A')->setWidth(10);
						 $sheet->getColumnDimension('B')->setWidth(20);
						 $sheet->getColumnDimension('C')->setWidth(9);

						$centerAlignment = $sheet->getStyle('A1:a2')->getAlignment();
							$centerAlignment->setHorizontal(Alignment::HORIZONTAL_CENTER);
$rn='A2:'.$col.$rowNumber;

                            $centerAlignment = $sheet->getStyle($rn)->getAlignment();
							$centerAlignment->setHorizontal(Alignment::HORIZONTAL_CENTER);
							
							// Apply font style to cell A1
							$sheet->getStyle('A1:a2')->applyFromArray($boldFontStyle);

$rn='A2:'.$col.$rowNumber;

							$sheet->getStyle('A1:n1')->applyFromArray($borderStyle);
							$sheet->getStyle($rn)->applyFromArray($borderStyle);
	 

//$sheet = $spreadsheet->createSheet($index);
$n=4;
//$col = chr(ord($tcols) - 1);   
$formula='=sum('.$col .$n.':'.$col.$rowNumber.')'; 
$m=2;
            $sheet->setCellValue($col . $m, 'Grand Total');
            $sheet->setCellValue($col . $rowNumber, $formula);

// Rename the sheet
$sheet->setTitle('Template');


if ($loomtype=='41') {	
    $filename="S4Weaver_".$windingperfromDate.'.xlsx';
} else {
    $filename="S4helper_".$windingperfromDate.'.xlsx';

}
// After generating the Excel file
$excelUrl = 'path_to_generated_excel_file.xlsx'; // Change this to the actual URL

// Return the URL along with other response data
echo json_encode(array('success' => true, 'savedata' => $savedata, 'excelUrl' => $excelUrl));

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
	
		// Terminate the script to prevent further output
		exit;



 			

		}	
		
 


    
	
 
 
 
 
 



	 		
		



}