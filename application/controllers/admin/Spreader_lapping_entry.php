<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spreader_lapping_entry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Spreader_lapping_entries_model');
    }

    // Load main view
    public function index() {
        $this->load->view('admin/spreader_lapping_entry/spreader_lapping_entry');
    }

    // Get records by date
    public function get_records() {
        $date = $this->input->post('date');
        $compId = $this->input->post('compId');

        $records = $this->Spreader_lapping_entries_model->get_records_by_date($date, $compId);

        $data = array();
        foreach ($records as $record) {
            // Format date for display
            $formattedDate = date('d-m-Y', strtotime($record['tran_date']));
            
            // Convert prod_type value to label
            $prodType = ($record['prod_type'] == '0' || $record['prod_type'] == 0) ? 'Spreader' : 'Lapping';
            
            $row = array(
                $record['sprd_lapp_id'],                    // ID
                $formattedDate,                             // Date
                $record['spell'],                           // Spell
                $record['hours'],                           // Hours
                $prodType,                                  // Prod Type (converted to label)
                $record['mechine_id'],  
                $record['mech_code'],                    // Machine
                $record['feeder_eb_no'],
                $record['feeder_name'],                     // Feeder Name (to be fetched separately)
                $record['receiver_eb_no'],
                $record['receiver_name'],                   // Receiver Name (to be fetched separately)
                $record['production']                       // Production
            );
            array_push($data, $row);
        }

        echo json_encode(array('data' => $data));
    }

    // Save new record
    public function save_data() {
        $date = $this->input->post('tran_date');
        $company_id = $this->session->userdata('company_id');
        $updated_by = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        // Convert dd-mm-yy to yyyy-mm-dd
        $dateArray = explode('-', $date);
        if (count($dateArray) == 3) {
            $dbDate = '20' . $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
        } else {
            $dbDate = $date;
        }
              $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

        $sql="select eb_id from worker_master where eb_no='".$this->input->post('feeder_id')."' and company_id=".$company_id."";
        $feederData=$this->db->query($sql)->row_array();   
        $sql="select eb_id from worker_master where eb_no='".$this->input->post('receiver_id')."' and company_id=".$company_id."";
        $receiverData=$this->db->query($sql)->row_array(); 

        $insertData = array(
            'tran_date' => $date,
            'spell' => $this->input->post('spell'),
            'production' => $this->input->post('production'),
            'hours' => $this->input->post('hours'),
            'feeder_id' => $feederData['eb_id'],
            'receiver_id' => $receiverData['eb_id'],
            'prod_type' => $this->input->post('prod_type'),
            'mechine_id' => $this->input->post('mechine_id'),
            'co_id' => $company_id,
            'updated_by' => $updated_by,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'is_active' => 1
        );

        if ($this->Spreader_lapping_entries_model->insert_transaction($insertData)) {
            echo json_encode(array('success' => true, 'message' => 'Record saved successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error saving record'));
        }
    }

    // Update record
    public function update_data() {
        $id = $this->input->post('sprd_lapp_id');
        $date = $this->input->post('tran_date');
        $updated_by = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        // Convert dd-mm-yy to yyyy-mm-dd
        $dateArray = explode('-', $date);
        if (count($dateArray) == 3) {
            $dbDate = '20' . $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
        } else {
            $dbDate = $date;
        }
              $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        $sql="select eb_id from worker_master where eb_no='".$this->input->post('feeder_id')."' and company_id=".$company_id."";
        $feederData=$this->db->query($sql)->row_array();   
    //    echo $this->db->last_query();
        $sql="select eb_id from worker_master where eb_no='".$this->input->post('receiver_id')."' and company_id=".$company_id."";
        $receiverData=$this->db->query($sql)->row_array(); 

        $updateData = array(
            'tran_date' => $date,
            'spell' => $this->input->post('spell'),
            'production' => $this->input->post('production'),
            'hours' => $this->input->post('hours'),
            'feeder_id' => $feederData['eb_id'],
            'receiver_id' => $receiverData['eb_id'],
            'prod_type' => $this->input->post('prod_type'),
            'mechine_id' => $this->input->post('mechine_id'),
            'updated_by' => $updated_by,
            'updated_date_time' => date('Y-m-d H:i:s')
        );

        if ($this->Spreader_lapping_entries_model->update_transaction($id, $updateData)) {
            echo json_encode(array('success' => true, 'message' => 'Record updated successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error updating record'));
        }
    }

    // Get single record by ID
    public function get_record() {
        $id = $this->input->post('id');
        $record = $this->Spreader_lapping_entries_model->get_record_by_id($id);

        if ($record) {
            // Format date for display
            $record['tran_date'] = date('d-m-Y', strtotime($record['tran_date']));
            
            // Fetch machine name
            if (!empty($record['mechine_id'])) {
                $machine = $this->Spreader_lapping_entries_model->get_machine_by_id($record['mechine_id']);
                $record['mechine_name'] = $machine ? $machine['mechine_name'] : '';
            }
            
            // Fetch feeder name if feeder_id exists
            if (!empty($record['feeder_id'])) {
                $feeder = $this->Spreader_lapping_entries_model->get_worker_name($record['feeder_id']);
                $record['feeder_name'] = $feeder ? $feeder['worker_name'] : '';
            }
            
            // Fetch receiver name if receiver_id exists
            if (!empty($record['receiver_id'])) {
                $receiver = $this->Spreader_lapping_entries_model->get_worker_name($record['receiver_id']);
                $record['receiver_name'] = $receiver ? $receiver['worker_name'] : '';
            }
            
            echo json_encode(array('success' => true, 'data' => $record));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Record not found'));
        }
    }

    // Delete record
    public function delete_data() {
        $id = $this->input->post('id');

        if ($this->Spreader_lapping_entries_model->delete_transaction($id)) {
            echo json_encode(array('success' => true, 'message' => 'Record deleted successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error deleting record'));
        }
    }

    // Get data by date for form population
    public function get_data_by_date() {
        $date = $this->input->post('date');
        $company_id = $this->session->userdata('company_id');

        $record = $this->Spreader_lapping_entries_model->get_first_record_by_date($date, $company_id);

        if ($record) {
            // Format date for display
            $record['tran_date'] = date('d-m-Y', strtotime($record['tran_date']));
            echo json_encode(array('success' => true, 'data' => $record));
        } else {
            echo json_encode(array('success' => false, 'message' => 'No record found'));
        }
    }

    // Get mechine list
    public function get_mechine_list() {
        $mechines = $this->Spreader_lapping_entries_model->get_mechines();
        echo json_encode(array('success' => true, 'data' => $mechines));
    }

    // Get worker name by EBNO
    public function get_worker_name() {
        $ebno = $this->input->post('ebno');
        $worker = $this->Spreader_lapping_entries_model->get_worker_name($ebno);

        if ($worker) {
            echo json_encode(array('success' => true, 'data' => $worker));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Worker not found'));
        }
    }

    // Import spreader data
    public function import_spreader() {
        $date = $this->input->post('date');
        $company_id = $this->session->userdata('company_id');

        if (!$date) {
            echo json_encode(array('success' => false, 'message' => 'Please select a date'));
            return;
        }

        $result = $this->Spreader_lapping_entries_model->import_spreader_data($date, $company_id);
        echo json_encode($result);
    }
}
?>
