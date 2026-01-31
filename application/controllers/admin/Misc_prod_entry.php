<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Misc_prod_entry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Misc_prod_entries_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('admin/misc_prod_entry/misc_prod_entry');
    }

    /**
     * Get all records for a specific date
     */
    public function get_records() {
        $date = $this->input->post('date');
        $compId = $this->input->post('compId');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
      //  echo $date;
        $records = $this->Misc_prod_entries_model->get_records_by_date($date, $compId);
        
        $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->misc_prod_ent_id,
                date('d-m-Y', strtotime($record->tran_date)),
                $record->sliver_wastage,
                $record->hess_wastage,
                $record->sacking_wastage,
                $record->beaming_wastage,
                $record->winding_wastage,
                $record->finishing_wastage,
                $record->roll_weight_wastage,
                $record->hands_mt_roll,
                $record->sale_yarn,
                $record->purchase_yarn,
                $record->yarn_purchase_hands,
                $record->jbo_consumption,
                $record->jbo_rate,
                $record->c_acid,
                $record->c_acid_rate,
                $record->rbo_cons,
                $record->rbo_rate,
                $record->power_unit,
                $record->adjustment_unit,
                $record->winding_wvg_diff
            ];
        }
        
        echo json_encode(['data' => $data]);
    }

    /**
     * Save new misc prod entry
     */
    public function save_data() {
        $tran_date = $this->input->post('tran_date');
        $user_code = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $tran_date = substr($tran_date, 6, 4) . '-' . substr($tran_date, 3, 2) . '-' . substr($tran_date, 0, 2);
        
        $data = array(
            'tran_date' => $tran_date,
            'sliver_wastage' => $this->input->post('sliver_wastage') ?: 0,
            'hess_wastage' => $this->input->post('hess_wastage') ?: 0,
            'sacking_wastage' => $this->input->post('sacking_wastage') ?: 0,
            'beaming_wastage' => $this->input->post('beaming_wastage') ?: 0,
            'winding_wastage' => $this->input->post('winding_wastage') ?: 0,
            'finishing_wastage' => $this->input->post('finishing_wastage') ?: 0,
            'roll_weight_wastage' => $this->input->post('roll_weight_wastage') ?: 0,
            'hands_mt_roll' => $this->input->post('hands_mt_roll') ?: 0,
            'sale_yarn' => $this->input->post('sale_yarn') ?: 0,
            'purchase_yarn' => $this->input->post('purchase_yarn') ?: 0,
            'yarn_purchase_hands' => $this->input->post('yarn_purchase_hands') ?: 0,
            'jbo_consumption' => $this->input->post('jbo_consumption') ?: 0,
            'jbo_rate' => $this->input->post('jbo_rate') ?: 0,
            'c_acid' => $this->input->post('c_acid') ?: 0,
            'c_acid_rate' => $this->input->post('c_acid_rate') ?: 0,
            'rbo_cons' => $this->input->post('rbo_cons') ?: 0,
            'rbo_rate' => $this->input->post('rbo_rate') ?: 0,
            'power_unit' => $this->input->post('power_unit') ?: 0,
            'adjustment_unit' => $this->input->post('adjustment_unit') ?: 0,
            'winding_wvg_diff' => $this->input->post('winding_wvg_diff') ?: 0,
            'co_id' => $company_id,
            'updated_by' => $user_code
        );
        
        $insert_id = $this->Misc_prod_entries_model->insert_transaction($data);
        
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
     * Update misc prod entry record
     */
    public function update_data() {
        $id = $this->input->post('misc_prod_ent_id');
        $tran_date = $this->input->post('tran_date');
        $user_code = $this->session->userdata('user_id');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $tran_date = substr($tran_date, 6, 4) . '-' . substr($tran_date, 3, 2) . '-' . substr($tran_date, 0, 2);
        
        $data = array(
            'tran_date' => $tran_date,
            'sliver_wastage' => $this->input->post('sliver_wastage') ?: 0,
            'hess_wastage' => $this->input->post('hess_wastage') ?: 0,
            'sacking_wastage' => $this->input->post('sacking_wastage') ?: 0,
            'beaming_wastage' => $this->input->post('beaming_wastage') ?: 0,
            'winding_wastage' => $this->input->post('winding_wastage') ?: 0,
            'finishing_wastage' => $this->input->post('finishing_wastage') ?: 0,
            'roll_weight_wastage' => $this->input->post('roll_weight_wastage') ?: 0,
            'hands_mt_roll' => $this->input->post('hands_mt_roll') ?: 0,
            'sale_yarn' => $this->input->post('sale_yarn') ?: 0,
            'purchase_yarn' => $this->input->post('purchase_yarn') ?: 0,
            'yarn_purchase_hands' => $this->input->post('yarn_purchase_hands') ?: 0,
            'jbo_consumption' => $this->input->post('jbo_consumption') ?: 0,
            'jbo_rate' => $this->input->post('jbo_rate') ?: 0,
            'c_acid' => $this->input->post('c_acid') ?: 0,
            'c_acid_rate' => $this->input->post('c_acid_rate') ?: 0,
            'rbo_cons' => $this->input->post('rbo_cons') ?: 0,
            'rbo_rate' => $this->input->post('rbo_rate') ?: 0,
            'power_unit' => $this->input->post('power_unit') ?: 0,
            'adjustment_unit' => $this->input->post('adjustment_unit') ?: 0,
            'winding_wvg_diff' => $this->input->post('winding_wvg_diff') ?: 0,
            'updated_by' => $user_code
        );
        
        $result = $this->Misc_prod_entries_model->update_transaction($id, $data);
        
        if ($result) {
            $response = array(
                'success' => true,
                'message' => 'Record updated successfully'
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
     * Get record by ID for editing
     */
    public function get_record() {
        $id = $this->input->post('id');
        
        $record = $this->Misc_prod_entries_model->get_record_by_id($id);
        
        if ($record) {
            $response = array(
                'success' => true,
                'data' => $record
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Record not found'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Delete (soft delete) record
     */
    public function delete_data() {
        $id = $this->input->post('id');
        
        $result = $this->Misc_prod_entries_model->delete_transaction($id);
        
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

    /**
     * Get record by date for populating form
     */
    public function get_data_by_date() {
        $date = $this->input->post('date');
        $company_id = $this->session->userdata('company_id');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        
        $record = $this->Misc_prod_entries_model->get_first_record_by_date($date, $company_id);
        
        if ($record) {
            $response = array(
                'success' => true,
                'data' => $record
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'No record found for this date'
            );
        }
        
        echo json_encode($response);
    }
}
?>
