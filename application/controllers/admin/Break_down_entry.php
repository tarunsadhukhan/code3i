<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Break_down_entry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Break_down_entries_model');
    }

    // Load the view
    public function index() {
        $this->load->view('admin/break_down_entry/break_down_entry');
    }

    // Get records by date
    public function get_records() {
        $date = $this->input->post('date');
        $compId = $this->input->post('compId');

        $records = $this->Break_down_entries_model->get_records_by_date($date, $compId);

        $data = array();
        foreach ($records as $record) {
            // Format date for display
            $formattedDate = date('d-m-Y', strtotime($record['tran_date']));
            
            $row = array(
                $record['bkd_id'],                      // 0: ID
                $formattedDate,                         // 1: Date
                $record['spell'],                       // 2: Spell
                $record['time_from'],                   // 3: Time From
                $record['time_to'],                     // 4: Time To
                $record['total_hours'],                 // 5: Total Hours
                $record['mechine_id'],                  // 6: Machine ID
                $record['mechine_name'],                // 7: Machine Name
                $record['remarks'],                     // 8: Remarks
            );
            array_push($data, $row);
        }

        echo json_encode(array('data' => $data));
    }

    // Save new record
    public function save_data() {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');

        // Convert date from dd-mm-yy to yyyy-mm-dd
        $date = $this->input->post('tran_date');
        $dbDate = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

        $insertData = array(
            'tran_date' => $dbDate,
            'spell' => $this->input->post('spell'),
            'time_from' => $this->input->post('time_from'),
            'time_to' => $this->input->post('time_to'),
            'total_hours' => $this->input->post('total_hours'),
            'remarks' => $this->input->post('remarks'),
            'mechine_id' => $this->input->post('mechine_id'),
            'co_id' => $company_id,
            'updated_by' => $user_id,
            'is_active' => 1
        );

        if ($this->Break_down_entries_model->insert_transaction($insertData)) {
            echo json_encode(array('success' => true, 'message' => 'Record saved successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error saving record'));
        }
    }

    // Update existing record
    public function update_data() {
        $user_id = $this->session->userdata('user_id');

        // Convert date from dd-mm-yy to yyyy-mm-dd
        $date = $this->input->post('tran_date');
        $dbDate = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

        $updateData = array(
            'tran_date' => $dbDate,
            'spell' => $this->input->post('spell'),
            'time_from' => $this->input->post('time_from'),
            'time_to' => $this->input->post('time_to'),
            'total_hours' => $this->input->post('total_hours'),
            'remarks' => $this->input->post('remarks'),
            'mechine_id' => $this->input->post('mechine_id'),
            'updated_by' => $user_id
        );

        $id = $this->input->post('bkd_id');
        if ($this->Break_down_entries_model->update_transaction($id, $updateData)) {
            echo json_encode(array('success' => true, 'message' => 'Record updated successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error updating record'));
        }
    }

    // Delete record
    public function delete_data() {
        $id = $this->input->post('id');
        if ($this->Break_down_entries_model->delete_transaction($id)) {
            echo json_encode(array('success' => true, 'message' => 'Record deleted successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error deleting record'));
        }
    }

    // Get single record
    public function get_record() {
        $id = $this->input->post('id');
        $record = $this->Break_down_entries_model->get_record_by_id($id);
        
        if ($record) {
            $machine = $this->Break_down_entries_model->get_machine_by_id($record['mechine_id']);
            $record['mechine_name'] = isset($machine['mechine_name']) ? $machine['mechine_name'] : 'N/A';
            echo json_encode(array('success' => true, 'data' => $record));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Record not found'));
        }
    }

    // Get data by date for form population
    public function get_data_by_date() {
        $date = $this->input->post('date');
        $company_id = $this->session->userdata('company_id');
        
        $record = $this->Break_down_entries_model->get_first_record_by_date($date, $company_id);
        
        if ($record) {
            $formattedDate = date('d-m-Y', strtotime($record['tran_date']));
            $record['tran_date'] = $formattedDate;
            echo json_encode(array('success' => true, 'data' => $record));
        } else {
            echo json_encode(array('success' => false, 'message' => 'No record found'));
        }
    }

    // Get machine list
    public function get_mechine_list() {
        $machines = $this->Break_down_entries_model->get_mechines();
        echo json_encode(array('success' => true, 'data' => $machines));
    }
}
?>
