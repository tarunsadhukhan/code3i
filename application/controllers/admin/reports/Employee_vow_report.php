<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class Employee_vow_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_vow_report_model');
    }

    /**
     * Load the Employee VOW Report view with filter data
     */
    public function index() {
        // Validate session
        $company_id = $this->session->userdata('company_id');
        if (empty($company_id)) {
            redirect('admin/login/logout');
        }

        // Load filter dropdown data
        $data['departments'] = $this->Employee_vow_report_model->getDepartmentMaster($company_id);
        $data['contractors'] = $this->Employee_vow_report_model->getContractorMaster($company_id);
        $data['designations'] = $this->Employee_vow_report_model->getDesignationMaster($company_id);
        $data['statuses'] = $this->Employee_vow_report_model->getStatusMaster();

        $this->load->view('admin/reports/Employee_vow_report', $data);
    }

    /**
     * Test database connectivity
     */
    public function test_db() {
        header('Content-Type: application/json');
        $company_id = $this->session->userdata('company_id');
        
        $response = [
            'status' => 'ok',
            'company_id' => $company_id,
            'is_authenticated' => !empty($company_id),
            'database_test' => 'pending'
        ];

        try {
            if (!empty($company_id)) {
                // Test query
                $this->db_vow = $this->load->database('vowsls', TRUE);
                $this->db_vow->select('COUNT(*) as count');
                $this->db_vow->from('tbl_hrms_ed_personal_details');
                $this->db_vow->where('company_id', $company_id);
                $query = $this->db_vow->get();
                $result = $query->row_array();
                $response['database_test'] = 'success';
                $response['personal_details_count'] = $result['count'];
                $response['last_query'] = $this->db_vow->last_query();
            }
        } catch (Exception $e) {
            $response['database_test'] = 'error';
            $response['error'] = $e->getMessage();
        }

        echo json_encode($response);
    }

    /**
     * Fetch Employee VOW data for DataTables via AJAX
     * Returns JSON formatted for DataTables
     */
    public function get_employeevowdata() {
        header('Content-Type: application/json');
        $company_id = $this->session->userdata('company_id');
        
        // Check if user is authenticated
        if (empty($company_id)) {
            echo json_encode([
                'draw' => intval($this->input->get('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => true,
                'message' => 'Session expired or user not authenticated. Please login again.'
            ]);
            return;
        }

        try {
            // Load database explicitly
            if (!isset($this->db_vow) || !$this->db_vow) {
                $this->db_vow = $this->load->database('vowsls', TRUE);
            }

            // Collect filters from GET/POST
            $filters = [];
            
            if ($this->input->get('date_of_join_from') && $this->input->get('date_of_join_from') != '') {
                $filters['date_of_join_from'] = $this->_convertDateFormat($this->input->get('date_of_join_from'));
            }
            if ($this->input->get('date_of_join_to') && $this->input->get('date_of_join_to') != '') {
                $filters['date_of_join_to'] = $this->_convertDateFormat($this->input->get('date_of_join_to'));
            }
            if ($this->input->get('departments') && $this->input->get('departments') != '') {
                $filters['departments'] = explode(',', $this->input->get('departments'));
            }
            if ($this->input->get('contractors') && $this->input->get('contractors') != '') {
                $filters['contractors'] = explode(',', $this->input->get('contractors'));
            }
            if ($this->input->get('designations') && $this->input->get('designations') != '') {
                $filters['designations'] = explode(',', $this->input->get('designations'));
            }
            if ($this->input->get('status') && $this->input->get('status') != '') {
                $filters['status'] = $this->input->get('status');
            }

            // Fetch data from model
            $data = $this->Employee_vow_report_model->getEmployeeVowData($company_id, $filters);
            
            if ($data === false || $data === null) {
                $data = [];
            }

            if (!is_array($data)) {
                $data = [];
            }

            // Return JSON response
            echo json_encode([
                'draw' => intval($this->input->get('draw', 1)),
                'recordsTotal' => count($data),
                'recordsFiltered' => count($data),
                'data' => $data,
                'error' => false,
                'debug' => [
                    'company_id' => $company_id,
                    'count' => count($data)
                ]
            ]);
            exit;
        } catch (Exception $e) {
            echo json_encode([
                'draw' => intval($this->input->get('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => true,
                'message' => 'Database Error: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * Export Employee VOW data to Excel
     */
    public function get_employeevowdataexl() {
        $company_id = $this->session->userdata('company_id');
        if (empty($company_id)) {
            redirect('admin/login/logout');
        }

        // Collect filters
        $filters = [];
        
        if ($this->input->get('date_of_join_from') && $this->input->get('date_of_join_from') != '') {
            $filters['date_of_join_from'] = $this->_convertDateFormat($this->input->get('date_of_join_from'));
        }
        if ($this->input->get('date_of_join_to') && $this->input->get('date_of_join_to') != '') {
            $filters['date_of_join_to'] = $this->_convertDateFormat($this->input->get('date_of_join_to'));
        }
        if ($this->input->get('departments') && $this->input->get('departments') != '') {
            $filters['departments'] = explode(',', $this->input->get('departments'));
        }
        if ($this->input->get('contractors') && $this->input->get('contractors') != '') {
            $filters['contractors'] = explode(',', $this->input->get('contractors'));
        }
        if ($this->input->get('designations') && $this->input->get('designations') != '') {
            $filters['designations'] = explode(',', $this->input->get('designations'));
        }
        if ($this->input->get('status') && $this->input->get('status') != '') {
            $filters['status'] = $this->input->get('status');
        }

        // Fetch data
        $records = $this->Employee_vow_report_model->getEmployeeVowData($company_id, $filters);

        // Create spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set page setup
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

        // Set margins
        $sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setRight(0.5);
        $sheet->getPageMargins()->setTop(0.75);
        $sheet->getPageMargins()->setBottom(0.75);

        // Define column headers
        $headers = [
            'Employee ID',
            'Employee Code',
            'Employee Name',
            'Gender',
            'Department Code',
            'Department Description',
            'Designation',
            'Category',
            'Date of Birth',
            'Date of Join',
            'ESI Number',
            'PF Number',
            'PF Date of Join',
            'PF UAN Number',
            'Bank Account Number',
            'IFSC Code',
            'Bank Name',
            'Contractor Name',
            'Status',
            'Pay Scheme',
            'Active Status',
            'Last Working Date'
        ];

        // Style definitions
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '366092']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        $dataStyle = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => false]
        ];

        // Write headers
        $col = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col, 1, $header);
            $sheet->getStyleByColumnAndRow($col, 1)->applyFromArray($headerStyle);
            $col++;
        }

        // Freeze header row
        $sheet->freezePane('A2');

        // Write data rows
        $row = 2;
        $columnMap = [
            'eb_id', 'emp_code', 'emp_name', 'gender', 'dept_code', 'dept_desc',
            'desig', 'cata_desc', 'date_of_birth', 'date_of_join', 'esi_no', 'pf_no',
            'pf_date_of_join', 'pf_uan_no', 'bank_acc_no', 'ifsc_code', 'bank_name',
            'contractor_name', 'status_name', 'pay_scheme', 'isactive', 'last_workings'
        ];

        foreach ($records as $record) {
            $col = 1;
            foreach ($columnMap as $key) {
                $value = isset($record[$key]) ? $record[$key] : '';
                $sheet->setCellValueByColumnAndRow($col, $row, $value);
                $sheet->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                $col++;
            }
            $row++;
        }

        // Auto-fit columns width
        for ($col = 1; $col <= count($headers); $col++) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        // Set header row height
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Generate filename
        $filename = 'employee_vow_report_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');

        // Write to output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Helper function to convert date format from dd-mm-yy to YYYY-MM-DD
     * @param string $date
     * @return string
     */
    private function _convertDateFormat($date) {
        if (empty($date)) {
            return '';
        }
        
        $dateObj = DateTime::createFromFormat('d-m-Y', $date);
        if ($dateObj) {
            return $dateObj->format('Y-m-d');
        }
        
        return $date;
    }
}
