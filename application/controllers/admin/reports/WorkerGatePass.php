<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use Fpdf\Fpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require_once APPPATH . '../vendor/autoload.php';
	
require_once(APPPATH.'libraries/fpdf.php');  
//D:\xampp\htdocs\code3i\application\libraries

class WorkerGatePass extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // If you have admin auth, use it here
        // $this->admin_auth->check();

        $this->load->model('WorkerGatePass_model');
        $this->load->helper(['url', 'security']);
    }

    public function index()
    {
        // Like your create.php / doff10report.php layout
        $this->load->view('admin/attendance/worker_gate_pass_entry');
    }

    // DataTables server-side
    public function ajax_list()
    {
        $result = $this->WorkerGatePass_model->datatable_list($this->input->get(NULL, TRUE));
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }


 

    // Save gate pass
    public function savetab()
    {
        $post = $this->input->post(NULL, TRUE);

//		echo 'bbbb';
//echo var_dump($post);
        $ebno = trim($post['ebno'] ?? '');
        if ($ebno === '') return $this->_plain("Please Enter Ebnumber !");
		$issueDate=$post['issuedate'];
		$date_ofwork1=$post['date_ofwork1'];
		$date_ofwork2=$post['date_ofwork2'];
        // Validate EB exists
//        $info = $this->wgp->get_worker_info($ebno);
//        if (!$info) return $this->_plain("Please Enter Valid EB No !");
		$issueDate=substr($issueDate,6,4).'-'.substr($issueDate,3,2).'-'.substr($issueDate,0,2);
		$date_ofwork1=substr($date_ofwork1,6,4).'-'.substr($date_ofwork1,3,2).'-'.substr($date_ofwork1,0,2);
		$date_ofwork2=substr($date_ofwork2,6,4).'-'.substr($date_ofwork2,3,2).'-'.substr($date_ofwork2,0,2);

		$data = [
            'issue_date'   => $issueDate   ?? '',
            'ebid'         => $post['ebid'] ?? '',
            'ebno'         => $ebno,
            'date_ofwork1' => $date_ofwork1,
            'date_ofwork2' => $date_ofwork2,
            'nodays'       => $post['nodays']       ?? '',
            'remarks'      => $post['remarks']      ?? '',
            'authority'    => $post['authority']    ?? '',
            'spell'        => $post['spell']        ?? '',
        ];
//var_dump($data);
        $ok = $this->WorkerGatePass_model->insert_gate_pass($data);


        if (!$ok) return $this->_plain("Save failed. Please check DB & date formats.");

        return $this->_plain("Record Saved Successfully !");
    }

    // Delete
    public function delete()
    {
        $rec_id = (int)$this->input->post('rec_id', TRUE);
        if ($rec_id <= 0) return $this->_plain("Invalid record!");

        $ok = $this->wgp->delete_by_id($rec_id);
        return $this->_plain($ok ? "Record Deleted Successfully !" : "Delete failed!");
    }

    // EB No => worker name
    public function worker_info()
    {
        $ebno = trim($this->input->post('EBNO', TRUE) ?? '');
        if ($ebno === '') return $this->_json(['name' => 'Invalid EB No']);

        $info = $this->wgp->get_worker_info($ebno);
        if (!$info) return $this->_json(['name' => 'Invalid EB No']);

        return $this->_json([
            'name'  => $info['WRK_NAME'],
            'FDATE' => '',
            'TDATE' => '',
            'NDAYS' => ''
        ]);
    }

    // Print (simple HTML print, replace with real PDF if needed)
    public function print_pdf()
    {
        $rec_id = (int)$this->input->get('rec_id', TRUE);
        if ($rec_id <= 0) show_error('Invalid rec_id', 400);

        $row = $this->wgp->get_gate_pass_by_id($rec_id);
        if (!$row) show_error('Record not found', 404);

        $html  = "<h3 style='text-align:center'>Worker Gate Pass</h3>";
        $html .= "<table border='1' cellpadding='6' cellspacing='0' width='100%'>";
        foreach ($row as $k => $v) {
            $html .= "<tr><th style='text-align:left;width:25%'>" . htmlspecialchars($k) . "</th><td>"
                  . htmlspecialchars((string)$v) . "</td></tr>";
        }
        $html .= "</table>";

        $this->output->set_output($html);
    }

    private function _plain($msg)
    {
        $this->output->set_content_type('text/plain')->set_output($msg);
    }

    private function _json($arr)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($arr));
    }


    public function getebdata() {
        $ebno = $this->input->post('ebno');
        $companyId =$this->session->userdata('company_id');
		$issueDate= $this->input->post('issueDate');
		$issueDate=substr($issueDate,6,4).'-'.substr($issueDate,3,2).'-'.substr($issueDate,0,2);

		$sql="select thepd.eb_id,concat(thepd.first_name,' ',ifnull(thepd.middle_name,''),' ',thepd.last_name)  empname from tbl_hrms_ed_personal_details thepd 
        join (select eb_id,emp_code from tbl_hrms_ed_official_details where is_active=1 ) theod on thepd.eb_id =theod.eb_id
        where theod.emp_code='$ebno' and thepd.is_active =1 and thepd.company_id =$companyId  "; 
        $query = $this->db->query($sql);
        $row1 = $query->row();
		$cnt = $query->num_rows();
        $ebid=0;
        $ebname='';
		$rem='';
		$success=true;
		$frdate='';
		$today='';
		$diffDays=0;
		$todate='';
		if ($cnt>0) {
	         $ebname = $row1->empname;
    	     $ebid = $row1->eb_id;
        }
        if ($ebid==0) {
            $ebname = 'No Data Found';
			$success=false;
        }
		$acnt=0;
		$asql='';
		if ($ebid>0 ) {
			$sql="select * from EMPMILL12.WORKERGATEPASSTBL where gate_pass_date='$issueDate' and eb_id=$ebid";
		//	echo $sql;
			$query = $this->db->query($sql);
    	    $row1 = $query->row();
			$acnt = $query->num_rows();
			$asql=$sql;
			//	echo $sql;
		//	echo $acnt;
			if ($acnt>0) {
				$rem=$ebno.' Already Enter for the Date '.$issueDate;
				$ebb=	$row1->eb_id;		
			}	
		}	

		//		echo $ebid;
		if ($ebid>0 && $acnt==0) {
			$sql="select DATE_ADD(MAX(atdate), INTERVAL 1 DAY) AS lastday from (
			select eb_id,attendance_date atdate from  daily_attendance
			WHERE attendance_date < '$issueDate'
			AND is_active = 1
			AND eb_id = $ebid
			union all 
			select eb_id,leave_date atdate from leave_transactions lt 
			join leave_tran_details ltd on lt.leave_transaction_id =ltd.ltran_id 
			where lt.status in (3) and ltd.is_active =1 and lt.eb_id =$ebid
			) g";
			$query = $this->db->query($sql);
			$row1 = $query->row();
			$frdate = $row1->lastday;          // example: 2026-01-02
			$today  = date('Y-m-d');           // today's date in Y-m-d
			
			if (!empty($frdate)) {
			$d1 = new DateTime($frdate);
			$d2 = new DateTime($today);

			// Difference in days (absolute)
			$diffDays = (int)$d1->diff($d2)->days-1;

			// If gap is less than 3 days (your condition)
			if (($diffDays + 1) < 3) {
				$ebid = 0;
				$rem  = "Gate Pass Not Required. EB No: {$ebno} Absent From: {$frdate}";
				$success=false;
			}
			//2025-01-03
			$frdate=substr($frdate,8,2).'-'.substr($frdate,5,2).'-'.substr($frdate,0,4);
			$todate=substr($today,8,2).'-'.substr($today,5,2).'-'.substr($today,0,4);
			
	
		} else {
			// if lastday is null
	//		$ebid = 0;
			$rem  = "No attendance found for EB No: {$ebno}";
			$success=true;
				}
	}

        $response = array(
				'success' => true,
				'ebid' => $ebid,
				'ebname' => $ebname,
				'rem'=>$rem,
				'frdate'=>$frdate,
				'todate'=>$todate,
				'diffDays'=>$diffDays,
				'asql'=>$asql,
			);
 		
        echo json_encode($response);
    }



public function print_multi1()
{
    $idsStr = $this->input->get('ids', TRUE) ?? '';
    $idsStr = trim($idsStr);

    if ($idsStr === '') show_error('No ids provided', 400);

    // sanitize ids: keep only numbers + commas
    $idsStr = preg_replace('/[^0-9,]/', '', $idsStr);
    $ids = array_filter(array_map('intval', explode(',', $idsStr)));

    if (empty($ids)) show_error('Invalid ids', 400);

    $rows = $this->WorkerGatePass_model->get_gate_pass_by_ids($ids);
    if (empty($rows)) show_error('No records found', 404);

    // Print view (HTML) - you can later replace with PDF
    $data['rows'] = $rows;
//	var_dump($rows);
$tdate=$rows[0]['GATE_PASS_DATE'];

//	$this->load->view('admin/worker_gate_pass_print_multi', $data);
		$pdf = new FPDF();



				$pdf->AddPage();
				// Set font
				
				$pdf->SetFont('Arial', 'B', 16);




				// Company Header
				$pdf->SetXY(10, 10);
				$pdf->Cell(0, 10, 'THE EMPIRE JUTE CO PVT. LTD. ', 0, 1,'C');



		$fl="GatePass.pdf";
 		
				// Set HTTP headers explicitly (optional but good for compatibility)
				header('Content-Type: application/pdf');
				header('Content-Disposition: attachment; filename="'.$fl);
				header('Cache-Control: private, max-age=0, must-revalidate');
				header('Pragma: public');
		
				// Output PDF to browser (force download)
				$pdf->Output($fl, 'D');


}
	


public function print_multi()
{
    $idsStr = $this->input->get('ids', TRUE) ?? '';
    $idsStr = preg_replace('/[^0-9,]/', '', $idsStr);
    $ids = array_filter(array_map('intval', explode(',', $idsStr)));

    if (empty($ids)) show_error('Invalid ids', 400);

    $rows = $this->WorkerGatePass_model->get_gate_pass_by_ids($ids);
//var_dump($rows);

	if (empty($rows)) show_error('No records found', 404);

    //require_once(APPPATH.'third_party/fpdf/fpdf.php');

    $pdf = new FPDF('P','mm','A4');
    $pdf->SetAutoPageBreak(true, 12);

    foreach ($rows as $r) {
        $pdf->AddPage();
        $this->_print_joining_pass_letter($pdf, $r);
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="joining_pass.pdf"');
    $pdf->Output('D', 'joining_pass.pdf');
    exit;
}

public function downloadExcel()
{
    // Get period from and to dates from URL
    $periodFrom = $this->input->get('period_from', TRUE);
    $periodTo = $this->input->get('period_to', TRUE);
    
    // Validate dates
    if (empty($periodFrom) || empty($periodTo)) {
        show_error('Invalid date range', 400);
    }
    
    // Convert dates from dd-mm-yyyy to yyyy-mm-dd for database query
    $fromDateParts = explode('-', $periodFrom);
    $toDateParts = explode('-', $periodTo);
    
    if (count($fromDateParts) !== 3 || count($toDateParts) !== 3) {
        show_error('Invalid date format', 400);
    }
    
    $fromDate = $fromDateParts[2] . '-' . $fromDateParts[1] . '-' . $fromDateParts[0];
    $toDate = $toDateParts[2] . '-' . $toDateParts[1] . '-' . $toDateParts[0];
    
    // Fetch data from database for the period
    $sql = "
        SELECT
            A.tran_id,
            B.eb_no,
            CONCAT(B.worker_name, ' ', B.middle_name, ' ', B.last_name) AS wrk_name,
            DATE_FORMAT(A.gate_pass_date,'%d-%b-%Y') AS gate_pass_date,
            A.shift,
            DATE_FORMAT(A.absent_from,'%d-%b-%Y') AS absent_from,
            DATE_FORMAT(A.absent_to,'%d-%b-%Y') AS absent_to,
            A.no_of_days,
            A.reasons,
            A.pass_given_by
        FROM EMPMILL12.WORKERGATEPASSTBL A
        LEFT JOIN worker_master B ON A.eb_id = B.eb_id
        WHERE DATE(A.gate_pass_date) >= ? AND DATE(A.gate_pass_date) <= ?
        ORDER BY A.gate_pass_date DESC, B.eb_no
    ";
    
    $rows = $this->db->query($sql, [$fromDate, $toDate])->result_array();
    
    if (empty($rows)) {
        show_error('No records found for the selected period', 404);
    }
    
    // Create spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set column widths
    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setWidth(12);
    $sheet->getColumnDimension('C')->setWidth(25);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(10);
    $sheet->getColumnDimension('F')->setWidth(15);
    $sheet->getColumnDimension('G')->setWidth(15);
    $sheet->getColumnDimension('H')->setWidth(10);
    $sheet->getColumnDimension('I')->setWidth(25);
    $sheet->getColumnDimension('J')->setWidth(20);
    
    // Create header row
    $headers = ['TRAN_ID', 'EB_NO', 'NAME', 'GATE PASS DATE', 'SHIFT', 'ABSENT FROM', 'ABSENT TO', 'DAYS', 'REASONS', 'AUTHORITY'];
    
    foreach ($headers as $index => $header) {
        $cell = $sheet->getCellByColumnAndRow($index + 1, 1);
        $cell->setValue($header);
        $cell->getStyle()->getFont()->setBold(true);
        $cell->getStyle()->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        $cell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $cell->getStyle()->getFill()->getStartColor()->setARGB('FF0070C0');
        $cell->getStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $cell->getStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
    
    // Add data rows
    $rowNum = 2;
    foreach ($rows as $row) {
        $sheet->setCellValueByColumnAndRow(1, $rowNum, $row['tran_id']);
        $sheet->setCellValueByColumnAndRow(2, $rowNum, $row['eb_no']);
        $sheet->setCellValueByColumnAndRow(3, $rowNum, $row['wrk_name']);
        $sheet->setCellValueByColumnAndRow(4, $rowNum, $row['gate_pass_date']);
        $sheet->setCellValueByColumnAndRow(5, $rowNum, $row['shift']);
        $sheet->setCellValueByColumnAndRow(6, $rowNum, $row['absent_from']);
        $sheet->setCellValueByColumnAndRow(7, $rowNum, $row['absent_to']);
        $sheet->setCellValueByColumnAndRow(8, $rowNum, $row['no_of_days']);
        $sheet->setCellValueByColumnAndRow(9, $rowNum, $row['reasons']);
        $sheet->setCellValueByColumnAndRow(10, $rowNum, $row['pass_given_by']);
        
        $rowNum++;
    }
    
    // Add borders to all cells with data
    $lastRow = $rowNum - 1;
    $range = 'A1:J' . $lastRow;
    $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    
    // Add text wrapping to all cells
    $sheet->getStyle($range)->getAlignment()->setWrapText(true);
    
    // Center align data columns (except NAME and REASONS)
    for ($col = 1; $col <= 10; $col++) {
        if ($col !== 3 && $col !== 9) { // Skip NAME and REASONS columns
            $sheet->getStyle('A2:J' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }
    }
    
    // Generate Excel file
    $fileName = 'Worker_Gate_Pass_' . date('Y-m-d_H-i-s') . '.xlsx';
    $writer = new Xlsx($spreadsheet);
    
    // Output to browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit;
}

private function _print_joining_pass_letter(FPDF $pdf, array $r)
{
    // ----- DATA (safe defaults) -----
    $ebno   = $r['eb_no'] ?? '';
    $name   = $r['WRK_NAME'] ?? '';
    $dept   = $r['dept_desc'] ?? '';
    $date   = $r['GATE_PASS_DATE'] ?? date('d-M-Y');

    $absFrom = $r['ABSENT_FROM'] ?? '';
    $absTo   = $r['ABSENT_TO'] ?? '';
    $days    = $r['NO_OF_DAYS'] ?? '';
    $auth    = $r['PASS_GIVEN_BY'] ?? '';

    // You can compute joining date = absent_to + 1 day if needed:
    $joinDate = '';
    if (!empty($absTo)) {
        $dt = DateTime::createFromFormat('d-M-Y', $absTo);
        if ($dt) { $dt->modify('+0 day'); $joinDate = $dt->format('d-M-Y'); }
    }
    if ($joinDate === '') $joinDate = '__________';

    // ----- HEADER (Company name + address + Date) -----
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,8,'THE EMPIRE JUTE CO LTD.',0,1,'C');

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,5,'15, B.T. Road, Talpukur, Kolkata-700123',0,1,'C');

    $pdf->Ln(2);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(0,6,'Date : '.$date,0,1,'R');

    $pdf->Ln(6);

    // ----- EB / Name / Department block (left aligned like image) -----
    $x0 = 20; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(25,6,'EB No',0,0,'L');
    $pdf->Cell(5,6,':',0,0,'L');
    $pdf->Cell(60,6,$ebno,0,1,'L');

    $pdf->SetX($x0);
    $pdf->Cell(25,6,'Name',0,0,'L');
    $pdf->Cell(5,6,':',0,0,'L');
    $pdf->Cell(80,6,$name,0,1,'L');

    $pdf->SetX($x0);
    $pdf->Cell(25,6,'Department',0,0,'L');
    $pdf->Cell(5,6,':',0,0,'L');
    $pdf->Cell(80,6,$dept,0,1,'L');

    $pdf->Ln(8);

    // ----- Title -----
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,7,'JOINING PASS FOR DEPARTMENT',0,1,'C');

    $pdf->Ln(6);

    // ----- Body text (like your letter) -----
    $pdf->SetFont('Arial','',11);

    $text =
        "You have been absenting from your duty from {$absFrom} . "
      . "your efficiency during the last fortnight of your working is _____________. "
      . "Your record for number of days presence is last fortnight of your working is ____________ out of ____________ working days. "
      . "You advised to improve your production productivity /attendance record. "
      . "Considering your written appeal management is providing you an opportunity and allowing you to join the duty w.e.f {$date}\n\n"
      . "You are hereby warned not to be absent so long without information to this office in future failing which disciplinary action will be taken against you. "
      . "Please consider this this as the final chance and no more chances will be provided to you.";

    // MultiCell for paragraph wrap
    $pdf->SetLeftMargin(20);
    $pdf->SetRightMargin(20);
    $pdf->MultiCell(0,6,$text,0,'J');

    $pdf->Ln(18);

    // ----- Signature area (center) -----
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(0,6,$name,0,1,'C');
    $pdf->Ln(2);
    $pdf->Cell(0,6,'Signature / L. thumb Impression',0,1,'C');

    $pdf->Ln(16);

    // ----- Authorized block (bottom left) -----
    $pdf->SetLeftMargin(15);
    $pdf->SetRightMargin(15);

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,6,'Authorised by '.($auth ?: '_____________'),0,1,'L');
    $pdf->Ln(10);
    $pdf->Cell(70,0,'',1,1,'L'); // signature line
    $pdf->Ln(4);
    $pdf->Cell(0,6,'Personnel Manager',0,1,'L');

	$pdf->SetLeftMargin(15);
    $pdf->SetRightMargin(15);

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,6,'Pass Issued on '.$joinDate,0,1,'L');
 


}



}
