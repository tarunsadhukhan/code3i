<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Issueentry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Issueentry_model');
        
        // Check if company_id is valid, otherwise logout
        $company_id = $this->session->userdata('company_id');
        if (empty($company_id) || $company_id == 0 || $company_id == '0') {
            $this->session->sess_destroy();
            redirect('admin/login');
        }
    }

    public function index() {
        $this->load->view('admin/issueentry/issueentry');
    }

    /**
     * Get quality list from jutemaster
     */
    public function get_quality_list() {
        $qualities = $this->Issueentry_model->get_quality_list();
        header('Content-Type: application/json');
        echo json_encode($qualities);
    }

    /**
     * Get godown list from warehouse_details
     */
    public function get_godown_list() {
        $godowns = $this->Issueentry_model->get_godown_list();
        header('Content-Type: application/json');
        echo json_encode($godowns);
    }

    /**
     * Get unit list from pack_master
     */
    public function get_unit_list() {
        $units = $this->Issueentry_model->get_unit_list();
        header('Content-Type: application/json');
        echo json_encode($units);
    }

    /**
     * Get issue records by date
     */
    public function get_records() {
        $date = $this->input->post('date');
        $records = $this->Issueentry_model->get_issues_by_date($date);
        header('Content-Type: application/json');
        echo json_encode($records);
    }

    /**
     * Get report data for date range
     */
    public function get_report_data_ajax() {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        if (!$from_date || !$to_date) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Both dates are required']);
            return;
        }

        // Check if dates are in dd-mm-yyyy format and convert to yyyy-mm-dd
        $from_date_db = $from_date;
        $to_date_db = $to_date;
        
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $from_date)) {
            $from_parts = explode('-', $from_date);
            $from_date_db = $from_parts[2] . '-' . $from_parts[1] . '-' . $from_parts[0];
        }
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $to_date)) {
            $to_parts = explode('-', $to_date);
            $to_date_db = $to_parts[2] . '-' . $to_parts[1] . '-' . $to_parts[0];
        }

        $report_data = $this->Issueentry_model->get_report_data($from_date_db, $to_date_db);
        
        header('Content-Type: application/json');
        echo json_encode($report_data);
    }

    /**
     * Save new issue record
     */
    public function save_issue() {
        $json_data = $this->input->raw_input_stream;
        $data = json_decode($json_data, true);

        if (!$data || !$data['issuedate'] || !$data['jcode_id'] || 
            !$data['godown_id'] || !$data['bales'] || !$data['packcode'] || !$data['weight']) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
            return;
        }

        $issueData = [
            'issuedate' => $data['issuedate'],
            'jcode_id' => $data['jcode_id'],
            'godown_id' => $data['godown_id'],
            'bales' => $data['bales'],
            'packcode' => $data['packcode'],
            'weight' => $data['weight'],
            'stype' => $data['stype'] ?: '',
            'jute01' => $data['jute01'] ?: '',
            'jute02' => $data['jute02'] ?: '',
            'user_id' => $this->session->userdata('id'),
            'ent_date_time' => date('Y-m-d H:i:s')
        ];

        if ($this->Issueentry_model->insert_issue_item($issueData)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Issue saved successfully']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error saving issue']);
        }
    }

    /**
     * Get issue data by ID
     */
    public function get_issue_data() {
        $issue_id = $this->input->post('issue_id');
        $data = $this->Issueentry_model->get_issue_by_id($issue_id);
        
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Issue not found']);
        }
    }

    /**
     * Update issue record
     */
    public function update_issue() {
        $json_data = $this->input->raw_input_stream;
        $data = json_decode($json_data, true);

        if (!$data['issue_id']) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Issue ID is required']);
            return;
        }

        $issueData = [
            'issuedate' => $data['issuedate'],
            'jcode_id' => $data['jcode_id'],
            'godown_id' => $data['godown_id'],
            'bales' => $data['bales'],
            'packcode' => $data['packcode'],
            'weight' => $data['weight'],
            'stype' => $data['stype'] ?: '',
            'jute01' => $data['jute01'] ?: '',
            'jute02' => $data['jute02'] ?: ''
        ];

        if ($this->Issueentry_model->update_issue_item($data['issue_id'], $issueData)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Issue updated successfully']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error updating issue']);
        }
    }

    /**
     * Delete issue record
     */
    public function delete_issue_item() {
        $issue_id = $this->input->post('issue_id');

        if (!$issue_id) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Issue ID is required']);
            return;
        }

        if ($this->Issueentry_model->delete_issue_item($issue_id)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Issue deleted successfully']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error deleting issue']);
        }
    }

    /**
     * Import data from jute_issue table based on issue date
     */
    public function check_existing_import() {
        header('Content-Type: application/json');
        
        $issue_date = $this->input->post('issue_date');

        $issue_date=substr($issue_date,6,4)."-".substr($issue_date,3,2)."-".substr($issue_date,0,2);    

        
        if (!$issue_date) {
            echo json_encode(['exists' => false, 'message' => 'Issue date is required']);
            return;
        }

        $exists = $this->Issueentry_model->check_issue_exists($issue_date);
        
        echo json_encode(['exists' => (bool)$exists, 'message' => $exists ? 'Data exists' : 'No data']);
    }

    public function import_jute_issue() {
        $issue_date = $this->input->post('issue_date');
        $delete_existing = $this->input->post('delete_existing');
        $issue_date=substr($issue_date,6,4)."-".substr($issue_date,3,2)."-".substr($issue_date,0,2);    
     
        if (!$issue_date) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Issue date is required']);
            return;
        }

        // Delete existing records if requested
        if ($delete_existing) {
            $this->Issueentry_model->delete_issue_by_date($issue_date);
        }

        $data = $this->Issueentry_model->get_jute_issue_data($issue_date);
        
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Data imported successfully', 'data' => $data]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No data found for the selected date']);
        }
    }

    /**
     * Process and calculate weight based on opening balance and received quantity
     * Formula: weight = ((opening_weight + received_weight) / (opening_qty + received_qty)) * issued_qty
     */
    public function process_update_weight() {
        $issue_date = $this->input->post('issue_date');
        
        if (!$issue_date) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Issue date is required']);
            return;
        }

        $result = $this->Issueentry_model->calculate_and_update_weight($issue_date);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    /**
     * Generate report with opening balance, received, adjustment, and closing balance
     */
    public function generate_report() {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
  
              $from_date=substr($from_date,6,4)."-".substr($from_date,3,2)."-".substr($from_date,0,2);    
              $to_date=substr($to_date,6,4)."-".substr($to_date,3,2)."-".substr($to_date,0,2);    
  
        if (!$from_date || !$to_date) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Both dates are required']);
            return;
        }

        // Convert from dd-mm-yyyy to yyyy-mm-dd for query if needed
        $from_date_db = $from_date;
        $to_date_db = $to_date;
        
        // Check if dates are in dd-mm-yyyy format
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $from_date)) {
            $from_parts = explode('-', $from_date);
            $from_date_db = $from_parts[2] . '-' . $from_parts[1] . '-' . $from_parts[0];
        }
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $to_date)) {
            $to_parts = explode('-', $to_date);
            $to_date_db = $to_parts[2] . '-' . $to_parts[1] . '-' . $to_parts[0];
        }

        $report_data = $this->Issueentry_model->get_report_data($from_date_db, $to_date_db);
        
        if (empty($report_data)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No data found for the selected date range']);
            return;
        }

        // Generate Excel file
        $file_name = 'issue_report_' . str_replace('-', '_', $from_date) . '_to_' . str_replace('-', '_', $to_date) . '.xlsx';
        $file_path = $this->generate_excel_report($report_data, $file_name, $from_date_db, $to_date_db);
        
        if ($file_path) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true, 
                'message' => 'Report generated successfully',
                'file_url' => base_url('uploads/' . $file_name)
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error generating Excel file']);
        }
    }

    /**
     * Generate Excel report
     */
    private function generate_excel_report($data, $file_name, $from_date = '', $to_date = '') {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Get company info from session
            $company_id = $this->session->userdata('company_id');
            $company_name = $this->session->userdata('company_name') ?? 'Company';
            
            // Add title row
            $sheet->setCellValue('A1', $company_name);
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->mergeCells('A1:N1');
            
            // Add report title row
            $period_text = '';
            if ($from_date && $to_date) {
                // Convert from yyyy-mm-dd to dd-mm-yyyy for display
                $from_parts = explode('-', $from_date);
                $to_parts = explode('-', $to_date);
                $from_display = $from_parts[2] . '-' . $from_parts[1] . '-' . $from_parts[0];
                $to_display = $to_parts[2] . '-' . $to_parts[1] . '-' . $to_parts[0];
                $period_text = 'Stock Report for the Period ' . $from_display . ' to ' . $to_display;
            } else {
                $period_text = 'Stock Report';
            }
            
            $sheet->setCellValue('A2', $period_text);
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
            $sheet->mergeCells('A2:N2');
            
            // Empty row
            $row = 4;
            
            // Set headers
            $headers = [
                'Quality Code',
                'Quality',
                'Packing',
                'Godown No',
                'Opening Bales',
                'Opening Weight',
                'Receive Bales',
                'Received Weight',
                'Issue Bales',
                'Issue Weight',
                'Adjustment Bales',
                'Adjustment Weight',
                'Closing Bales',
                'Closing Weight'
            ];
            
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $row, $header);
                $col++;
            }
            
            // Set header styleN' . $row)->getFont()->setBold(true);
            $sheet->getStyle('A' . $row . ':N' . $row)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet->getStyle('A' . $row . ':N' . $row)->getFill()->getStartColor()->setRGB('4472C4');
            $sheet->getStyle('A' . $row . ':N' . $row)->getFont()->getColor()->setRGB('FFFFFF');
            
            // Add borders to header
            $this->applyBorders($sheet, 'A' . $row . ':N' . $row);
            
            $row++;
            $current_godown = '';
            $godown_totals = [];
            $grand_totals = [
                'opening_bales' => 0,
                'opening_weight' => 0,
                'receive_bales' => 0,
                'received_weight' => 0,
                'issue_bales' => 0,
                'issue_weight' => 0,
                'adjustment_bales' => 0,
                'adjustment_weight' => 0,
                'closing_bales' => 0,
                'closing_weight' => 0
            ];
            
            // Add data rows
            foreach ($data as $item) {
                // Get godown name
                $godown_name = isset($item['name']) ? $item['name'] : 'N/A';
                
                // Get quality code and name
                $jcode = isset($item['jcode']) ? $item['jcode'] : '';
                $quality = isset($item['quality']) ? $item['quality'] : '';
                
                // Calculate closing balance: opening + received - issue + adjustment
                $closing_bales = ($item['opbales'] ?? 0) + ($item['rcvbales'] ?? 0) - ($item['issbales'] ?? 0) + ($item['adjbales'] ?? 0);
                $closing_weight = ($item['opweight'] ?? 0) + ($item['rcvweight'] ?? 0) - ($item['issweight'] ?? 0) + ($item['adjweight'] ?? 0);
                
                // Add godown total row if godown changed
                if ($current_godown && $current_godown != $godown_name) {
                    $sheet->setCellValue('A' . $row, 'Godown Total: ' . $current_godown);
                    $sheet->getStyle('A' . $row . ':N' . $row)->getFill()->setFillType(Fill::FILL_SOLID);
                    $sheet->getStyle('A' . $row . ':N' . $row)->getFill()->getStartColor()->setRGB('D9E1F2');
                    $sheet->getStyle('A' . $row . ':N' . $row)->getFont()->setBold(true);
                    
                    if (isset($godown_totals[$current_godown])) {
                        $gt = $godown_totals[$current_godown];
                        $sheet->setCellValue('E' . $row, $gt['opening_bales']);
                        $sheet->setCellValue('F' . $row, $gt['opening_weight']);
                        $sheet->setCellValue('G' . $row, $gt['receive_bales']);
                        $sheet->setCellValue('H' . $row, $gt['received_weight']);
                        $sheet->setCellValue('I' . $row, $gt['issue_bales']);
                        $sheet->setCellValue('J' . $row, $gt['issue_weight']);
                        $sheet->setCellValue('K' . $row, $gt['adjustment_bales']);
                        $sheet->setCellValue('L' . $row, $gt['adjustment_weight']);
                        $sheet->setCellValue('M' . $row, $gt['closing_bales']);
                        $sheet->setCellValue('N' . $row, $gt['closing_weight']);
                    }
                    
                    // Apply borders to godown total row
                    $this->applyBorders($sheet, 'A' . $row . ':N' . $row);
                    $row++;
                }
                
                $sheet->setCellValue('A' . $row, $jcode);
                $sheet->setCellValue('B' . $row, $quality);
                $sheet->setCellValue('C' . $row, isset($item['packcode']) ? $item['packcode'] : '');
                $sheet->setCellValue('D' . $row, $godown_name);
                $sheet->setCellValue('E' . $row, $item['opbales'] ?? 0);
                $sheet->setCellValue('F' . $row, $item['opweight'] ?? 0);
                $sheet->setCellValue('G' . $row, $item['rcvbales'] ?? 0);
                $sheet->setCellValue('H' . $row, $item['rcvweight'] ?? 0);
                $sheet->setCellValue('I' . $row, $item['issbales'] ?? 0);
                $sheet->setCellValue('J' . $row, $item['issweight'] ?? 0);
                $sheet->setCellValue('K' . $row, $item['adjbales'] ?? 0);
                $sheet->setCellValue('L' . $row, $item['adjweight'] ?? 0);
                $sheet->setCellValue('M' . $row, $closing_bales);
                $sheet->setCellValue('N' . $row, $closing_weight);
                
                // Apply borders to data row
         //       $this->applyBorders($sheet, 'A' . $row . ':N' . $row);
                $this->applyBorders($sheet, 'A' . $row . ':M' . $row);
                
                // Track godown totals
                if (!isset($godown_totals[$godown_name])) {
                    $godown_totals[$godown_name] = [
                        'opening_bales' => 0,
                        'opening_weight' => 0,
                        'receive_bales' => 0,
                        'received_weight' => 0,
                        'issue_bales' => 0,
                        'issue_weight' => 0,
                        'adjustment_bales' => 0,
                        'adjustment_weight' => 0,
                        'closing_bales' => 0,
                        'closing_weight' => 0
                    ];
                }
                
                $godown_totals[$godown_name]['opening_bales'] += ($item['opbales'] ?? 0);
                $godown_totals[$godown_name]['opening_weight'] += ($item['opweight'] ?? 0);
                $godown_totals[$godown_name]['receive_bales'] += ($item['rcvbales'] ?? 0);
                $godown_totals[$godown_name]['received_weight'] += ($item['rcvweight'] ?? 0);
                $godown_totals[$godown_name]['issue_bales'] += ($item['issbales'] ?? 0);
                $godown_totals[$godown_name]['issue_weight'] += ($item['issweight'] ?? 0);
                $godown_totals[$godown_name]['adjustment_bales'] += ($item['adjbales'] ?? 0);
                $godown_totals[$godown_name]['adjustment_weight'] += ($item['adjweight'] ?? 0);
                $godown_totals[$godown_name]['closing_bales'] += $closing_bales;
                $godown_totals[$godown_name]['closing_weight'] += $closing_weight;
                
                // Track grand totals
                $grand_totals['opening_bales'] += ($item['opbales'] ?? 0);
                $grand_totals['opening_weight'] += ($item['opweight'] ?? 0);
                $grand_totals['receive_bales'] += ($item['rcvbales'] ?? 0);
                $grand_totals['received_weight'] += ($item['rcvweight'] ?? 0);
                $grand_totals['issue_bales'] += ($item['issbales'] ?? 0);
                $grand_totals['issue_weight'] += ($item['issweight'] ?? 0);
                $grand_totals['adjustment_bales'] += ($item['adjbales'] ?? 0);
                $grand_totals['adjustment_weight'] += ($item['adjweight'] ?? 0);
                $grand_totals['closing_bales'] += $closing_bales;
                $grand_totals['closing_weight'] += $closing_weight;
                
                $current_godown = $godown_name;
                $row++;
            }
            
            // Add last godown total
            if ($current_godown) {
                $sheet->setCellValue('A' . $row, 'Godown Total: ' . $current_godown);
                $sheet->getStyle('A' . $row . ':N' . $row)->getFill()->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('A' . $row . ':N' . $row)->getFill()->getStartColor()->setRGB('D9E1F2');
                $sheet->getStyle('A' . $row . ':N' . $row)->getFont()->setBold(true);
                
                if (isset($godown_totals[$current_godown])) {
                    $gt = $godown_totals[$current_godown];
                    $sheet->setCellValue('E' . $row, $gt['opening_bales']);
                    $sheet->setCellValue('F' . $row, $gt['opening_weight']);
                    $sheet->setCellValue('G' . $row, $gt['receive_bales']);
                    $sheet->setCellValue('H' . $row, $gt['received_weight']);
                    $sheet->setCellValue('I' . $row, $gt['issue_bales']);
                    $sheet->setCellValue('J' . $row, $gt['issue_weight']);
                    $sheet->setCellValue('K' . $row, $gt['adjustment_bales']);
                    $sheet->setCellValue('L' . $row, $gt['adjustment_weight']);
                    $sheet->setCellValue('M' . $row, $gt['closing_bales']);
                    $sheet->setCellValue('N' . $row, $gt['closing_weight']);
                }
                
                // Apply borders to last godown total row
             //   $this->applyBorders($sheet, 'A' . $row . ':N
            
                $this->applyBorders($sheet, 'A' . $row . ':M' . $row);
                $row++;
            }
            
            // Add grand total row
            $row++;
            
            $sheet->getStyle('A' . $row . ':N' . $row)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet->getStyle('A' . $row . ':N' . $row)->getFill()->getStartColor()->setRGB('92D050');
            $sheet->getStyle('A' . $row . ':N' . $row)->getFont()->setBold(true);
            
            $sheet->setCellValue('E' . $row, $grand_totals['opening_bales']);
            $sheet->setCellValue('F' . $row, $grand_totals['opening_weight']);
            $sheet->setCellValue('G' . $row, $grand_totals['receive_bales']);
            $sheet->setCellValue('H' . $row, $grand_totals['received_weight']);
            $sheet->setCellValue('I' . $row, $grand_totals['issue_bales']);
            $sheet->setCellValue('J' . $row, $grand_totals['issue_weight']);
            $sheet->setCellValue('K' . $row, $grand_totals['adjustment_bales']);
            $sheet->setCellValue('L' . $row, $grand_totals['adjustment_weight']);
            $sheet->setCellValue('M' . $row, $grand_totals['closing_bales']);
            $sheet->setCellValue('N' . $row, $grand_totals['closing_weight']);
            
            // Apply borders to grand total row
//            $this->applyBorders($sheet, 'A' . $row . ':N
            // Apply borders to grand total row
            $this->applyBorders($sheet, 'A' . $row . ':M' . $row);
            
            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(15);
  //          for ($col = 'E'; $col <= 'N'C')->setWidth(15);
            for ($col = 'D'; $col <= 'M'; $col++) {
                $sheet->getColumnDimension($col)->setWidth(16);
            }
            
            // Save file using PhpSpreadsheet
            $file_path = FCPATH . 'uploads/' . $file_name;
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($file_path);
            
            return $file_path;
            
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Apply borders to a cell range
     */
    private function applyBorders($sheet, $range) {
        $style = array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => array('rgb' => '000000'),
                ),
                'bottom' => array(
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => array('rgb' => '000000'),
                ),
                'left' => array(
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => array('rgb' => '000000'),
                ),
                'right' => array(
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => array('rgb' => '000000'),
                ),
                'vertical' => array(
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => array('rgb' => '000000'),
                ),
                'horizontal' => array(
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => array('rgb' => '000000'),
                ),
            ),
        );
        
        $sheet->getStyle($range)->applyFromArray($style);
    }

    /**
     * Delete Excel report file
     */
    public function delete_excel_file() {
        $file_name = $this->input->post('file_name');
        
        if (!$file_name) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'File name is required']);
            return;
        }

        $file_path = FCPATH . 'uploads/' . $file_name;
        
        // Validate that the file is in the uploads directory and is an xlsx file
        if (!preg_match('/^issue_report_.*\.xlsx$/', $file_name)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid file']);
            return;
        }

        if (file_exists($file_path)) {
            if (unlink($file_path)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'File deleted successfully']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to delete file']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'File not found']);
        }
    }
}
