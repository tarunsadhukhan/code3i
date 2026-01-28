<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hylt_master extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Hylt_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('admin/hylt/hylt_master');
    }

    /**
     * Check if qcode already exists
     */
    public function check_qcode() {
        $qcode = $this->input->post('qcode');
        $record_id = $this->input->post('record_id');
        
        $exists = $this->Hylt_model->check_qcode_exists($qcode, $record_id);
        
        if ($exists > 0) {
            $response = array(
                'success' => false,
                'duplicate' => true,
                'message' => 'Quality code already exists'
            );
        } else {
            $response = array(
                'success' => true,
                'duplicate' => false
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Get all master records
     */
    public function get_records() {
        $records = $this->Hylt_model->get_all_masters();
        
        $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->hyltmast_id,
                $record->qcode,
                $record->width,
                $record->shots,
                $record->ports,
                $record->ozsyds,
                $record->i_b,
                $record->unit,
                $record->stdwt,
                $record->jborbo
            ];
        }
        
        echo json_encode(['data' => $data]);
    }

    /**
     * Save new master record
     */
    public function save_data() {
        $qcode = $this->input->post('qcode');
        $width = $this->input->post('width');
        $shots = $this->input->post('shots');
        $ports = $this->input->post('ports');
        $ozsyds = $this->input->post('ozsyds');
        $i_b = $this->input->post('i_b');
        $unit = $this->input->post('unit');
        $stdwt = $this->input->post('stdwt');
        $jborbo = $this->input->post('jborbo');
        $user_id = $this->session->userdata('user_id');
        
        // Check if qcode already exists
        if ($this->Hylt_model->check_qcode_exists($qcode)) {
            $response = array(
                'success' => false,
                'message' => 'Quality code already exists'
            );
            echo json_encode($response);
            return;
        }
        
        $data = array(
            'qcode' => $qcode,
            'width' => $width,
            'shots' => $shots,
            'ports' => $ports,
            'ozsyds' => $ozsyds,
            'i_b' => $i_b,
            'unit' => $unit,
            'stdwt' => $stdwt,
            'jborbo' => $jborbo,
            'user_id' => $user_id,
            'ent_date_time' => date('Y-m-d H:i:s')
        );
        
        $insert_id = $this->Hylt_model->insert_master($data);
        
        if ($insert_id) {
            $response = array(
                'success' => true,
                'message' => 'Record saved successfully',
                'savedata' => 'saved',
                'id' => $insert_id
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to save record'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Update existing master record
     */
    public function update_data() {
        $record_id = $this->input->post('record_id');
        $qcode = $this->input->post('qcode');
        $width = $this->input->post('width');
        $shots = $this->input->post('shots');
        $ports = $this->input->post('ports');
        $ozsyds = $this->input->post('ozsyds');
        $i_b = $this->input->post('i_b');
        $unit = $this->input->post('unit');
        $stdwt = $this->input->post('stdwt');
        $jborbo = $this->input->post('jborbo');
        $user_id = $this->session->userdata('user_id');
        
        // Check if qcode already exists (excluding current record)
        if ($this->Hylt_model->check_qcode_exists($qcode, $record_id)) {
            $response = array(
                'success' => false,
                'message' => 'Quality code already exists'
            );
            echo json_encode($response);
            return;
        }
        
        $data = array(
            'qcode' => $qcode,
            'width' => $width,
            'shots' => $shots,
            'ports' => $ports,
            'ozsyds' => $ozsyds,
            'i_b' => $i_b,
            'unit' => $unit,
            'stdwt' => $stdwt,
            'jborbo' => $jborbo,
            'user_id' => $user_id
        );
        
        $result = $this->Hylt_model->update_master($record_id, $data);
        
        if ($result) {
            $response = array(
                'success' => true,
                'message' => 'Record updated successfully',
                'savedata' => 'Updated'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to update record'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Delete master record
     */
    public function delete_data() {
        $record_id = $this->input->post('record_id');
        
        $result = $this->Hylt_model->delete_master($record_id);
        
        if ($result) {
            $response = array(
                'success' => true,
                'message' => 'Record deleted successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to delete record'
            );
        }
        
        echo json_encode($response);
    }
}
