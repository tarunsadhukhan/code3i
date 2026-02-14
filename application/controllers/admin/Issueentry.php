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
     * Generate report with multiple types and formats
     */
    public function generate_report() {
        $report_type = $this->input->post('report_type');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $format = $this->input->post('format');
    //    $issue_date=substr($issue_date,6,4)."-".substr($issue_date,3,2)."-".substr($issue_date,0,2);    
        
        error_log("Report request - Type: $report_type, Format: $format, From: $from_date, To: $to_date");
        
        if (!$report_type || !$from_date || !$to_date || !$format) {
            error_log("Missing parameters for report generation");
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'All parameters are required']);
            return;
        }

        // Get report data based on type
        $report_data = $this->get_report_data_by_type($report_type, $from_date, $to_date);
        
        if (empty($report_data)) {
            error_log("No data found for report type: $report_type");
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No data found for the selected criteria']);
            return;
        }

        error_log("Report data retrieved. Count: " . count($report_data));

        // Generate file based on format
        $file_extension = '';
        $file_path = '';
        $report_name = $this->get_report_display_name($report_type);
        
        try {
            switch ($format) {
                case 'excel':
                    $file_extension = 'xlsx';
                    $file_path = $this->generate_excel_report($report_data, $report_type, $report_name, $from_date, $to_date);
                    break;
                case 'csv':
                    $file_extension = 'csv';
                    $csv_file = $this->generate_csv_report($report_data, $report_type, $report_name, $from_date, $to_date);
                    // Wrap CSV in ZIP
                    $file_path = $this->wrap_file_in_zip($csv_file, 'zip');
                    $file_extension = 'zip';
                    break;
                case 'text':
                    $file_extension = 'txt';
                    $text_file = $this->generate_text_report($report_data, $report_type, $report_name, $from_date, $to_date);
                    // Wrap text in ZIP
                    $file_path = $this->wrap_file_in_zip($text_file, 'zip');
                    $file_extension = 'zip';
                    break;
                default:
                    error_log("Invalid format: $format");
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Invalid format']);
                    return;
            }
            
            error_log("File path returned: " . ($file_path ? $file_path : 'NULL'));
            
            if ($file_path && file_exists($file_path)) {
                error_log("File exists. Size: " . filesize($file_path));
                $file_name = basename($file_path);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Report generated successfully',
                    'file_url' => base_url('uploads/' . $file_name)
                ]);
            } else {
                error_log("File does not exist or is invalid: " . ($file_path ? $file_path : 'NULL'));
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error generating report file']);
            }
            
        } catch (Exception $e) {
            error_log("Exception in generate_report: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate ZIP file containing both CSV and Text reports
     */
    private function generate_zip_report($data, $report_type, $report_name, $from_date, $to_date) {
        try {
            // Ensure upload directory exists
            if (!is_dir(FCPATH . 'uploads/')) {
                mkdir(FCPATH . 'uploads/', 0755, true);
            }

            // Load ZipArchive
            if (!extension_loaded('zip')) {
                error_log('ZIP extension not loaded');
                return false;
            }

            $timestamp = date('YmdHis');
            $zip_name = strtolower(str_replace(' ', '_', $report_name)) . '_' . $timestamp . '.zip';
            $zip_path = FCPATH . 'uploads/' . $zip_name;
            
            // Create ZIP file
            $zip = new \ZipArchive();
            if ($zip->open($zip_path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                error_log('Failed to create ZIP file: ' . $zip_path);
                return false;
            }

            // Generate CSV report
            $csv_path = $this->generate_csv_report($data, $report_type, $report_name, $from_date, $to_date);
            if ($csv_path && file_exists($csv_path)) {
                $csv_name = basename($csv_path);
                $zip->addFile($csv_path, $csv_name);
                error_log('Added CSV to ZIP: ' . $csv_name);
            }

            // Generate Text report
            $text_path = $this->generate_text_report($data, $report_type, $report_name, $from_date, $to_date);
            if ($text_path && file_exists($text_path)) {
                $text_name = basename($text_path);
                $zip->addFile($text_path, $text_name);
                error_log('Added Text to ZIP: ' . $text_name);
            }

            $zip->close();

            // Verify ZIP was created and has content
            if (file_exists($zip_path) && filesize($zip_path) > 0) {
                error_log('ZIP file created successfully: ' . $zip_path . ' (Size: ' . filesize($zip_path) . ')');
                
                // Clean up source files after zipping
                if ($csv_path && file_exists($csv_path)) {
                    unlink($csv_path);
                }
                if ($text_path && file_exists($text_path)) {
                    unlink($text_path);
                }
                
                return $zip_path;
            }
            
            error_log('ZIP file created but is empty or does not exist: ' . $zip_path);
            return false;

        } catch (Exception $e) {
            error_log('ZIP report generation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Wrap a single file in a ZIP archive
     */
    private function wrap_file_in_zip($file_path, $extension) {
        try {
            if (!$file_path || !file_exists($file_path)) {
                error_log('File not found for zipping: ' . ($file_path ? $file_path : 'NULL'));
                return false;
            }

            if (!extension_loaded('zip')) {
                error_log('ZIP extension not loaded');
                return false;
            }

            // Ensure upload directory exists
            if (!is_dir(FCPATH . 'uploads/')) {
                mkdir(FCPATH . 'uploads/', 0755, true);
            }

            $original_filename = basename($file_path);
            $timestamp = date('YmdHis');
            $zip_name = pathinfo($original_filename, PATHINFO_FILENAME) . '_' . $timestamp . '.zip';
            $zip_path = FCPATH . 'uploads/' . $zip_name;

            // Create ZIP file
            $zip = new \ZipArchive();
            if ($zip->open($zip_path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                error_log('Failed to create ZIP file: ' . $zip_path);
                return false;
            }

            // Add file to ZIP
            $zip->addFile($file_path, $original_filename);
            $zip->close();

            // Verify ZIP was created and has content
            if (file_exists($zip_path) && filesize($zip_path) > 0) {
                error_log('ZIP file created successfully: ' . $zip_path . ' (Size: ' . filesize($zip_path) . ')');
                
                // Delete original file
                if (file_exists($file_path)) {
                    unlink($file_path);
                    error_log('Original file deleted: ' . $file_path);
                }
                
                return $zip_path;
            }

            error_log('ZIP file created but is empty or does not exist: ' . $zip_path);
            return false;

        } catch (Exception $e) {
            error_log('Error wrapping file in ZIP: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get report data based on report type
     */
    private function get_report_data_by_type($report_type, $from_date, $to_date) {


        switch ($report_type) {
            case 'jute_report_01':
                return $this->Issueentry_model->get_jute_report_01($from_date, $to_date);
            case 'jute_report_02':
                return $this->Issueentry_model->get_jute_report_02($from_date, $to_date);
            case 'jute_stock_report':
                return $this->Issueentry_model->get_jute_stock_report($from_date, $to_date);
            case 'issue_report':
                return $this->Issueentry_model->get_issue_report($from_date, $to_date);
            case 'godown_wise_stock':
                return $this->Issueentry_model->get_godown_wise_stock($from_date, $to_date);
            default:
                return [];
        }
    }

    /**
     * Get human readable report name
     */
    private function get_report_display_name($report_type) {
        $names = [
            'jute_report_01' => 'Jute Report (01)',
            'jute_report_02' => 'Jute Report (02)',
            'jute_stock_report' => 'Jute Stock Report',
            'issue_report' => 'Issue Report',
            'godown_wise_stock' => 'Godown Wise Stock'
        ];
        return $names[$report_type] ?? 'Report';
    }

    /**
     * Get report file name based on report type
     */
    private function get_report_file_name($report_type) {
        $file_names = [
            'jute_report_01' => 'Jute0001.prn',
            'jute_report_02' => 'Jute0002.prn',
            'jute_stock_report' => 'jute_stock_report',
            'issue_report' => 'issue_report',
            'godown_wise_stock' => 'godown_wise_stock'
        ];
        return $file_names[$report_type] ?? 'report';
    }

    /**
     * Generate CSV report
     */
    private function generate_csv_report($data, $report_type, $report_name, $from_date, $to_date) {
        $base_file_name = $this->get_report_file_name($report_type);
        $file_name = $base_file_name . '.csv';
        $file_path = FCPATH . 'uploads/' . $file_name;
        
        try {
            // Ensure upload directory exists
            if (!is_dir(FCPATH . 'uploads/')) {
                mkdir(FCPATH . 'uploads/', 0755, true);
            }
            
            $csv_file = fopen($file_path, 'w');
            if (!$csv_file) {
                error_log('Failed to open CSV file: ' . $file_path);
                return false;
            }
            
            // Write BOM for UTF-8 (for proper Excel compatibility)
            fprintf($csv_file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Get company info
            $company_name = $this->session->userdata('company_name') ?? 'Company';
            $from_display = $this->format_date_for_display($from_date);
            $to_display = $this->format_date_for_display($to_date);
            
            // Write header information
            fputcsv($csv_file, [$company_name]);
            fputcsv($csv_file, [$report_name . ' Report']);
            fputcsv($csv_file, ['Period: ' . $from_display . ' to ' . $to_display]);
            fputcsv($csv_file, []); // Empty row
            
            // Write column headers based on report type
            $headers = $this->get_csv_headers($report_type);
            fputcsv($csv_file, $headers);
            
            // Write data rows
            foreach ($data as $item) {
                $row = $this->format_csv_row($item, $report_type);
                fputcsv($csv_file, $row);
            }
            
            fclose($csv_file);
            
            // Verify file was created and has content
            if (file_exists($file_path) && filesize($file_path) > 0) {
                return $file_path;
            }
            error_log('CSV file created but is empty or does not exist: ' . $file_path);
            return false;
            
        } catch (Exception $e) {
            error_log('CSV report generation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate Text report
     */
    private function generate_text_report($data, $report_type, $report_name, $from_date, $to_date) {
        $base_file_name = $this->get_report_file_name($report_type);
        $file_name = $base_file_name ;
        $file_path = FCPATH . 'uploads/' . $file_name;
        
        try {
            // Ensure upload directory exists
            if (!is_dir(FCPATH . 'uploads/')) {
                mkdir(FCPATH . 'uploads/', 0755, true);
            }
            
            $text_file = fopen($file_path, 'w');
            if (!$text_file) {
                return false;
            }
            
            // Set UTF-8 encoding
            fwrite($text_file, "\xEF\xBB\xBF"); // UTF-8 BOM
            
            $company_name = $this->session->userdata('company_name') ?? 'Company';
            $from_display = $this->format_date_for_display($from_date);
            $to_display = $this->format_date_for_display($to_date);
            
            // Special formatting for Jute Report (01)
            if ($report_type === 'jute_report_01') {
                $hd1=" |Jcode|Quality     | Opening|Receipt |<------Issue----------->|Delivery| Adjust |Closing |<---------Month To Date----------->| * |Stock| Group\n";
                $hd2=" |     |            | Weight | Weight | Weight | Rate|  Amount | Weight | Weight |Weight  |Receipt Wt| Issue Wt  | Issue      | * |for  |\n";
                $hd3=" |     |            |  (Mt)  |  (Mt)  |  (Mt)  |(Qtl)|   (Rs.) |  (Mt)  |  (Mt)  | (Mt)   |   (Mt)   |   (Mt)    | Amount     | * |Days |\n";
                $hd4=" |-----|------------|--------|--------|--------|-----|---------|--------|--------|--------|----------|-----------|------------| * |-----|------\n";
                $hd5=" |     |            |        |        |        |     |         |        |        |        |          |           |            | * |     |\n";
                fwrite($text_file, " " . $company_name . "\n");
                fwrite($text_file, " Daily Jute Stock Report Dated :" . $to_display . "                                               Report No:[JUT01]\n");
                fwrite($text_file, "  " . str_repeat('-', 140) . "\n");
                fwrite($text_file, $hd1);
                fwrite($text_file, $hd2);
                fwrite($text_file, $hd3);
                fwrite($text_file, $hd4);
                fwrite($text_file, $hd5);
                
                // Format data rows for Jute Report 01
                if (!empty($data)) {
                    // Initialize totals
                    $total_opening_weight = 0;
                    $total_receipt_weight = 0;
                    $total_issue_weight = 0;
                    $total_amount = 0;
                    $total_delivery_weight = 0;
                    $total_adjust_weight = 0;
                    $total_closing_weight = 0;
                    $total_tdreceipt_weight = 0;
                    $total_tdissue_weight = 0;
                    $total_tdamount = 0;
                    
                    foreach ($data as $item) {
                        $jcode = str_pad($item['jcode'] ?? '', 5);
                        $quality = str_pad(substr($item['quality'] ?? '', 0, 12), 12);
                        $opening_weight = str_pad(number_format($item['opweight'] ?? 0, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                        $receipt_weight = str_pad(number_format($item['rcvweight'] ?? 0, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                        $issue_weight = str_pad(number_format($item['issweight'] ?? 0, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                        $rate = str_pad((int)($item['rate'] ?? 0), 5, ' ', STR_PAD_LEFT);
                        $amount = str_pad(number_format($item['issvalue'] ?? 0, 0, '.', ''), 7, ' ', STR_PAD_LEFT);
                        $delivery_weight = str_pad(number_format($item['delvweight'] ?? 0, 3, '.', ''), 0, ' ', STR_PAD_LEFT);
                        $adjust_weight = str_pad(number_format($item['adjweight'] ?? 0, 3, '.', ''), 0, ' ', STR_PAD_LEFT);
                        $closing_weight = str_pad(number_format(($item['opweight'] ?? 0) + ($item['rcvweight'] ?? 0) - ($item['issweight'] ?? 0) + ($item['adjweight'] ?? 0), 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                        $tdreceipt_weight = str_pad(number_format($item['tdrecvweight'] ?? 0, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                        $tdissue_weight = str_pad(number_format($item['tdisweight'] ?? 0, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                        $tdamount = str_pad(number_format(($item['tdissvalue'] ?? 0), 0, '.', ''), 7, ' ', STR_PAD_LEFT);
                        
                        // Accumulate totals
                        $total_opening_weight += ($item['opweight'] ?? 0);
                        $total_receipt_weight += ($item['rcvweight'] ?? 0);
                        $total_issue_weight += ($item['issweight'] ?? 0);
                        $total_amount += ($item['issvalue'] ?? 0);
                        $total_delivery_weight += ($item['delvweight'] ?? 0);
                        $total_adjust_weight += ($item['adjweight'] ?? 0);
                        $total_closing_weight += (($item['opweight'] ?? 0) + ($item['rcvweight'] ?? 0) - ($item['issweight'] ?? 0) + ($item['adjweight'] ?? 0));
                        $total_tdreceipt_weight += ($item['tdrecvweight'] ?? 0);
                        $total_tdissue_weight += ($item['tdisweight'] ?? 0);
                        $total_tdamount += ($item['tdissvalue'] ?? 0);
                        
                        fwrite($text_file, " |$jcode|$quality|$opening_weight|$receipt_weight|$issue_weight|$rate| $amount |  $delivery_weight |  $adjust_weight |$closing_weight| $tdreceipt_weight |  $tdissue_weight |    $tdamount | * |     |\n");
//                        fwrite($text_file, $hd5);
                        fwrite($text_file, $hd4);
                    }
                    
                    // Write GRAND TOTAL line
                    $gt_opening_weight = str_pad(number_format($total_opening_weight, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                    $gt_receipt_weight = str_pad(number_format($total_receipt_weight, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                    $gt_issue_weight = str_pad(number_format($total_issue_weight, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                    $gt_amount = str_pad(number_format($total_amount, 0, '.', ''), 7, ' ', STR_PAD_LEFT);
                    $gt_delivery_weight = str_pad(number_format($total_delivery_weight, 3, '.', ''), 0, ' ', STR_PAD_LEFT);
                    $gt_adjust_weight = str_pad(number_format($total_adjust_weight, 3, '.', ''), 0, ' ', STR_PAD_LEFT);
                    $gt_closing_weight = str_pad(number_format($total_closing_weight, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                    $gt_tdreceipt_weight = str_pad(number_format($total_tdreceipt_weight, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                    $gt_tdissue_weight = str_pad(number_format($total_tdissue_weight, 3, '.', ''), 8, ' ', STR_PAD_LEFT);
                    $gt_tdamount = str_pad(number_format($total_tdamount, 0, '.', ''), 7, ' ', STR_PAD_LEFT);
                    
                    fwrite($text_file, " |TOTAL|            |$gt_opening_weight|$gt_receipt_weight|$gt_issue_weight|     | $gt_amount |  $gt_delivery_weight |  $gt_adjust_weight |$gt_closing_weight| $gt_tdreceipt_weight |  $gt_tdissue_weight |   $gt_tdamount | * |     |\n");
             //     fwrite($text_file, " |$jcode|$quality|$opening_weight|$receipt_weight|$issue_weight|$rate| $amount |  $delivery_weight |  $adjust_weight |$closing_weight| $tdreceipt_weight |  $tdissue_weight |    $tdamount | * |     |\n");
//                  
//                    fwrite($text_file, $hd5);
                    fwrite($text_file, $hd4);
                    fwrite($text_file, str_repeat('-', 140) . "\n");
                    $tobatch=round($total_amount/($total_issue_weight*10),0);
                    $tdbatch=round($gt_tdamount/($gt_tdissue_weight*10),0);
                    fwrite($text_file, "Batch Cost Today:   $tobatch       To-date:  $tdbatch\n");

                    fwrite($text_file, "Note :- Stock Days Based on Last 15 Days Issue. Report Printing Date: " . date('d.m.Y') . " \n\n");
                    fwrite($text_file, " \n");
                    fwrite($text_file, " \n");
                    fwrite($text_file, "    Jute            Asst. Comm.                General "."\n");           
                    fwrite($text_file, "  Incharge           Manager                  Manager       "."\n");

                    }
            } else {
                // Standard text report format for other report types
                fwrite($text_file, str_repeat('=', 140) . "\n");
                fwrite($text_file, $company_name . "\n");
                fwrite($text_file, $report_name . " Report\n");
                fwrite($text_file, "Period: " . $from_display . " to " . $to_display . "\n");
                fwrite($text_file, "Generated: " . date('d-m-Y H:i:s') . "\n");
                fwrite($text_file, str_repeat('=', 140) . "\n\n");
                
                // Write column headers
                $headers = $this->get_text_headers($report_type);
                $header_line = '';
                $separator_line = '';
                foreach ($headers as $header) {
                    $width = 16;
                    $header = substr($header, 0, $width);
                    $header_line .= str_pad($header, $width) . ' | ';
                    $separator_line .= str_repeat('-', $width) . '-+-';
                }
                
                fwrite($text_file, $header_line . "\n");
                fwrite($text_file, $separator_line . "\n");
                
                // Write data rows
                foreach ($data as $item) {
                    $row = $this->format_text_row($item, $report_type);
                    $data_line = '';
                    foreach ($row as $value) {
                        $width = 16;
                        $value = substr($value, 0, $width);
                        $data_line .= str_pad($value, $width) . ' | ';
                    }
                    fwrite($text_file, $data_line . "\n");
                }
                
                fwrite($text_file, str_repeat('=', 140) . "\n");
            }
            
            fclose($text_file);
            
            // Verify file was created and has content
            if (file_exists($file_path) && filesize($file_path) > 0) {
                return $file_path;
            }
            return false;
            
        } catch (Exception $e) {
            error_log('Text report generation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper function to get CSV headers for a report type
     */
    private function get_csv_headers($report_type) {
        $headers = [
            'jute_report_01' => ['Quality Code', 'Quality', 'Packing', 'Godown', 'Opening Bales', 'Opening Weight', 'Received Bales', 'Received Weight', 'Issue Bales', 'Issue Weight', 'Closing Bales', 'Closing Weight'],
            'jute_report_02' => ['Date', 'Quality', 'Type', 'Bales', 'Weight', 'Rate', 'Amount'],
            'jute_stock_report' => ['Quality Code', 'Quality', 'Packing', 'Godown', 'Opening Bales', 'Opening Weight', 'Received Bales', 'Received Weight', 'Issue Bales', 'Issue Weight', 'Closing Bales', 'Closing Weight'],
            'issue_report' => ['Issue Date', 'Quality', 'Godown', 'Packing', 'Bales', 'Weight', 'Rate', 'S/Type', 'Jute 01', 'Jute 02'],
            'godown_wise_stock' => ['Godown', 'Quality', 'Packing', 'Opening Bales', 'Opening Weight', 'Received Bales', 'Received Weight', 'Issue Bales', 'Issue Weight', 'Closing Bales', 'Closing Weight']
        ];
        return $headers[$report_type] ?? [];
    }

    /**
     * Helper function to get Text headers for a report type
     */
    private function get_text_headers($report_type) {
        return $this->get_csv_headers($report_type);
    }

    /**
     * Helper function to format a CSV row based on report type
     */
    private function format_csv_row($item, $report_type) {
        switch ($report_type) {
            case 'jute_report_01':
            case 'jute_stock_report':
                return [
                    $item['jcode'] ?? '',
                    $item['quality'] ?? '',
                    $item['packcode'] ?? '',
                    $item['name'] ?? '',
                    $item['opbales'] ?? 0,
                    $item['opweight'] ?? 0,
                    $item['rcvbales'] ?? 0,
                    $item['rcvweight'] ?? 0,
                    $item['issbales'] ?? 0,
                    $item['issweight'] ?? 0,
                    ($item['opbales'] ?? 0) + ($item['rcvbales'] ?? 0) - ($item['issbales'] ?? 0),
                    ($item['opweight'] ?? 0) + ($item['rcvweight'] ?? 0) - ($item['issweight'] ?? 0)
                ];
            case 'jute_report_02':
                return [
                    $item['issuedate'] ?? '',
                    $item['quality'] ?? '',
                    $item['stype'] ?? '',
                    $item['bales'] ?? 0,
                    $item['weight'] ?? 0,
                    (int)($item['rate'] ?? 0),
                    ($item['bales'] ?? 0) * ($item['rate'] ?? 0)
                ];
            case 'issue_report':
                return [
                    $item['issuedate'] ?? '',
                    $item['quality'] ?? '',
                    $item['godownno'] ?? '',
                    $item['packing'] ?? '',
                    $item['bales'] ?? 0,
                    $item['weight'] ?? 0,
                    (int)($item['rate'] ?? 0),
                    $item['stype'] ?? '',
                    $item['jute01'] ?? '',
                    $item['jute02'] ?? ''
                ];
            case 'godown_wise_stock':
                return [
                    $item['name'] ?? '',
                    $item['quality'] ?? '',
                    $item['packcode'] ?? '',
                    $item['opbales'] ?? 0,
                    $item['opweight'] ?? 0,
                    $item['rcvbales'] ?? 0,
                    $item['rcvweight'] ?? 0,
                    $item['issbales'] ?? 0,
                    $item['issweight'] ?? 0,
                    ($item['opbales'] ?? 0) + ($item['rcvbales'] ?? 0) - ($item['issbales'] ?? 0),
                    ($item['opweight'] ?? 0) + ($item['rcvweight'] ?? 0) - ($item['issweight'] ?? 0)
                ];
            default:
                return [];
        }
    }

    /**
     * Helper function to format a text row based on report type
     */
    private function format_text_row($item, $report_type) {
        return $this->format_csv_row($item, $report_type);
    }

    /**
     * Format date from yyyy-mm-dd to dd-mm-yyyy
     */
    private function format_date_for_display($date) {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $parts = explode('-', $date);
            return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        return $date;
    }

    /**
     * Generate Excel report
     */
    private function generate_excel_report($data, $report_type, $report_name, $from_date = '', $to_date = '') {
        try {
            // Ensure upload directory exists
            if (!is_dir(FCPATH . 'uploads/')) {
                mkdir(FCPATH . 'uploads/', 0755, true);
            }
            
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Get company info from session
            $company_id = $this->session->userdata('company_id');
            $company_name = $this->session->userdata('company_name') ?? 'Company';
            
            // Add title row
            $sheet->setCellValue('A1', $company_name);
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->mergeCells('A1:L1');
            
            // Add report title row
            $from_display = $this->format_date_for_display($from_date);
            $to_display = $this->format_date_for_display($to_date);
            $period_text = $report_name . ' Report for the Period ' . $from_display . ' to ' . $to_display;
            
            $sheet->setCellValue('A2', $period_text);
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
            $sheet->mergeCells('A2:L2');
            
            // Empty row
            $row = 4;
            
            // Set headers based on report type
            $headers = $this->get_csv_headers($report_type);
            
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $row, $header);
                $col++;
            }
            
            // Set header style
            $last_col = chr(64 + count($headers));
            $sheet->getStyle('A' . $row . ':' . $last_col . $row)->getFont()->setBold(true);
            $sheet->getStyle('A' . $row . ':' . $last_col . $row)->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet->getStyle('A' . $row . ':' . $last_col . $row)->getFill()->getStartColor()->setRGB('4472C4');
            $sheet->getStyle('A' . $row . ':' . $last_col . $row)->getFont()->getColor()->setRGB('FFFFFF');
            
            // Add borders to header
            $this->applyBorders($sheet, 'A' . $row . ':' . $last_col . $row);
            
            $row++;
            
            // Add data rows
            foreach ($data as $item) {
                $row_data = $this->format_csv_row($item, $report_type);
                $col = 'A';
                foreach ($row_data as $value) {
                    $sheet->setCellValue($col . $row, $value);
                    $col++;
                }
                
                // Apply borders to data row
                $this->applyBorders($sheet, 'A' . $row . ':' . $last_col . $row);
                $row++;
            }
            
            // Set column widths
            for ($i = 1; $i <= count($headers); $i++) {
                $col_letter = chr(64 + $i);
                $sheet->getColumnDimension($col_letter)->setWidth(18);
            }
            
            // Save file using PhpSpreadsheet
            $base_file_name = $this->get_report_file_name($report_type);
            $file_name = $base_file_name . '.xlsx';
            $file_path = FCPATH . 'uploads/' . $file_name;
            
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($file_path);
            
            // Verify file was created
            if (file_exists($file_path) && filesize($file_path) > 0) {
                return $file_path;
            }
            error_log('Excel file created but is empty or does not exist: ' . $file_path);
            return false;
            
        } catch (Exception $e) {
            error_log('Excel report generation error: ' . $e->getMessage());
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
     * Delete export file (supports all formats)
     */
    public function delete_export_file() {
        $file_name = $this->input->post('file_name');
        
        if (!$file_name) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'File name is required']);
            return;
        }

        $file_path = FCPATH . 'uploads/' . $file_name;
        
        // Validate that the file is in the uploads directory and has an allowed extension
        $allowed_extensions = ['xlsx', 'csv', 'txt', 'zip', 'prn'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        
        if (!in_array($file_extension, $allowed_extensions)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid file type']);
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

    /**
     * Delete Excel report file (deprecated - use delete_export_file)
     */
    public function delete_excel_file() {
        return $this->delete_export_file();
    }

    /**
     * Download report file directly
     */
    public function download_report() {
        $file_name = $this->input->get('file');
        
        if (!$file_name) {
            show_404();
            return;
        }
        
        $file_path = FCPATH . 'uploads/' . $file_name;
        
        // Security: validate file name and path
        $allowed_extensions = ['xlsx', 'csv', 'txt', 'zip', 'prn'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        
        if (!in_array($file_extension, $allowed_extensions)) {
            show_404();
            return;
        }
        
        // Prevent directory traversal
        if (strpos($file_name, '..') !== false || strpos($file_name, '/') !== false) {
            show_404();
            return;
        }
        
        if (!file_exists($file_path)) {
            show_404();
            return;
        }
        
        // Determine content type
        $mime_types = [
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'csv' => 'text/csv;charset=utf-8',
            'txt' => 'text/plain;charset=utf-8',
            'zip' => 'application/zip',
            'prn' => 'text/plain;charset=utf-8'
        ];
        
        $content_type = $mime_types[$file_extension] ?? 'application/octet-stream';
        
        // Set headers for file download
        header('Content-Type: ' . $content_type);
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Content-Length: ' . filesize($file_path));
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // Output file
        readfile($file_path);
        exit;
    }
}
