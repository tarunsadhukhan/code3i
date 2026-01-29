<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
}
