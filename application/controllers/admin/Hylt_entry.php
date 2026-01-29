<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hylt_entry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Hylt_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('admin/hylt/hylt_entry');
    }

    /**
     * Get quality details based on qcode
     */
    public function get_quality() {
        $qcode = $this->input->post('qcode');
        $companyId = $this->input->post('companyId');
        $record_id = $this->input->post('record_id');
        
        // Get quality details from hyltmast
        $quality = $this->Hylt_model->get_quality_by_code($qcode, $companyId);
        
        if ($quality) {
            $response = array(
                'success' => true,
                'qcode' => $quality->qcode,
                'width' => $quality->width,
                'shots' => $quality->shots,
                'ports' => $quality->ports,
                'ozsyds' => $quality->ozsyds,
                'i_b' => $quality->i_b,
                'unit' => $quality->unit,
                'stdwt' => $quality->stdwt,
                'jborbo' => $quality->jborbo,
                'quality_display' => isset($quality->quality_display) ? $quality->quality_display : ''
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Quality code not found'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Get all records for a specific date
     */
    public function get_records() {
        $date = $this->input->post('date');
        $compId = $this->input->post('compId');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        
        $records = $this->Hylt_model->get_records_by_date($date, $compId);
        
        $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->hylttran_id,
                $record->tran_date,
                $record->qcode,
                isset($record->quality_display) ? $record->quality_display : '',
                $record->orders,
                $record->bales,
                $record->av_mr,
                $record->av_std,
                $record->av_obj,
                $record->av_cor,
                $record->std_wt,
                $record->obj_wt,
                $record->cor_wt,
                $record->mlen,
                $record->unit,
                $record->diff_wt,
                $record->hylt_obj,
                $record->hylt_cor
            ];
        }
        
        echo json_encode(['data' => $data]);
    }

    /**
     * Save new hylt entry
     */
    public function save_data() {
        $tran_date = $this->input->post('tran_date');
        $qcode = $this->input->post('qcode');
        $orders = $this->input->post('orders');
        $bales = $this->input->post('bales');
        $av_mr = $this->input->post('av_mr');
        $av_std = $this->input->post('av_std');
        $av_obj = $this->input->post('av_obj');
        $av_cor = $this->input->post('av_cor');
        $hylt_obj = $this->input->post('hylt_obj');
        $hylt_cor = $this->input->post('hylt_cor');
        $mlen = $this->input->post('mlen');
        $unit = $this->input->post('unit');
        $std_wt = $this->input->post('std_wt');
        $obj_wt = $this->input->post('obj_wt');
        $cor_wt = $this->input->post('cor_wt');
        $diff_wt = $this->input->post('diff_wt');
        $user_code = $this->session->userdata('user_id');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $tran_date = substr($tran_date, 6, 4) . '-' . substr($tran_date, 3, 2) . '-' . substr($tran_date, 0, 2);
        
        $data = array(
            'tran_date' => $tran_date,
            'qcode' => $qcode,
            'orders' => $orders,
            'bales' => $bales,
            'av_mr' => $av_mr,
            'av_std' => $av_std,
            'av_obj' => $av_obj,
            'av_cor' => $av_cor,
            'hylt_obj' => $hylt_obj,
            'hylt_cor' => $hylt_cor,
            'mlen' => $mlen,
            'unit' => $unit,
            'std_wt' => $std_wt,
            'obj_wt' => $obj_wt,
            'cor_wt' => $cor_wt,
            'diff_wt' => $diff_wt,
            'user_id' => $user_code,
            'ent_date_time' => date('Y-m-d H:i:s')
        );
        
        $insert_id = $this->Hylt_model->insert_transaction($data);
        
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
     * Update existing hylt entry
     */
    public function update_data() {
        $record_id = $this->input->post('record_id');
        $tran_date = $this->input->post('tran_date');
        $qcode = $this->input->post('qcode');
        $orders = $this->input->post('orders');
        $bales = $this->input->post('bales');
        $av_mr = $this->input->post('av_mr');
        $av_std = $this->input->post('av_std');
        $av_obj = $this->input->post('av_obj');
        $av_cor = $this->input->post('av_cor');
        $hylt_obj = $this->input->post('hylt_obj');
        $hylt_cor = $this->input->post('hylt_cor');
        $mlen = $this->input->post('mlen');
        $unit = $this->input->post('unit');
        $std_wt = $this->input->post('std_wt');
        $obj_wt = $this->input->post('obj_wt');
        $cor_wt = $this->input->post('cor_wt');
        $diff_wt = $this->input->post('diff_wt');
        $user_code = $this->session->userdata('user_id');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $tran_date = substr($tran_date, 6, 4) . '-' . substr($tran_date, 3, 2) . '-' . substr($tran_date, 0, 2);
        
        $data = array(
            'tran_date' => $tran_date,
            'qcode' => $qcode,
            'orders' => $orders,
            'bales' => $bales,
            'av_mr' => $av_mr,
            'av_std' => $av_std,
            'av_obj' => $av_obj,
            'av_cor' => $av_cor,
            'hylt_obj' => $hylt_obj,
            'hylt_cor' => $hylt_cor,
            'mlen' => $mlen,
            'unit' => $unit,
            'std_wt' => $std_wt,
            'obj_wt' => $obj_wt,
            'cor_wt' => $cor_wt,
            'diff_wt' => $diff_wt,
            'user_id' => $user_code
        );
        
        $result = $this->Hylt_model->update_transaction($record_id, $data);
        
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
     * Delete hylt entry
     */
    public function delete_data() {
        $record_id = $this->input->post('record_id');
        
        $result = $this->Hylt_model->delete_transaction($record_id);
        
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
