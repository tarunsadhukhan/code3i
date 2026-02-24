<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_finishing_entry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Daily_finishing_entry_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('admin/daily_finishing_entry/daily_finishing_entry');
    }

    /**
     * Get all records for a specific date
     */
    public function get_records() {
        $date = $this->input->post('date');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        
        $records = $this->Daily_finishing_entry_model->get_records_by_date($date);
        
        $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->id,
                date('d-m-Y', strtotime($record->date)),
                $record->wvgbag,
                $record->cutting,
                $record->cutmc,
                $record->hemming,
                $record->hemmc,
                $record->sewing,
                $record->sewmc,
                $record->herakle,
                $record->hermc,
                $record->hsewing,
                $record->press,
                $record->premc,
                $record->pckbls,
                $record->packedhs,
                $record->packsheet,
                $record->saletwin,
                $record->user_code
            ];
        }
        
        echo json_encode(['data' => $data]);
    }

    /**
     * Save new daily finishing entry
     */
    public function save_data() {
        $date = $this->input->post('date');
        $user_code = $this->input->post('user_code') ?: $this->session->userdata('user_id');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        
        $data = array(
            'date' => $date,
            'wvgbag' => $this->input->post('wvgbag') ?: 0,
            'cutting' => $this->input->post('cutting') ?: 0,
            'cutmc' => $this->input->post('cutmc') ?: 0,
            'hemming' => $this->input->post('hemming') ?: 0,
            'hemmc' => $this->input->post('hemmc') ?: 0,
            'sewing' => $this->input->post('sewing') ?: 0,
            'sewmc' => $this->input->post('sewmc') ?: 0,
            'herakle' => $this->input->post('herakle') ?: 0,
            'hermc' => $this->input->post('hermc') ?: 0,
            'hsewing' => $this->input->post('hsewing') ?: 0,
            'press' => $this->input->post('press') ?: 0,
            'premc' => $this->input->post('premc') ?: 0,
            'pckbls' => $this->input->post('pckbls') ?: 0,
            'hsewingh' => $this->input->post('hsewingh') ?: 0,
            'packedhs' => $this->input->post('packedhs') ?: 0,
            'yds' => $this->input->post('yds') ?: 0,
            'packsheet' => $this->input->post('packsheet') ?: 0,
            'saletwin' => $this->input->post('saletwin') ?: 0,
            'adj_hs' => $this->input->post('adj_hs') ?: 0,
            'adj_sk' => $this->input->post('adj_sk') ?: 0,
            'adj_sy' => $this->input->post('adj_sy') ?: 0,
            'adj_gc' => $this->input->post('adj_gc') ?: 0,
            'adj_bk' => $this->input->post('adj_bk') ?: 0,
            'packedsk' => $this->input->post('packedsk') ?: 0,
            'packedbk' => $this->input->post('packedbk') ?: 0,
            'outpkbls' => $this->input->post('outpkbls') ?: 0,
            'outpkhs' => $this->input->post('outpkhs') ?: 0,
            'outpksk' => $this->input->post('outpksk') ?: 0,
            'inpkbls' => $this->input->post('inpkbls') ?: 0,
            'inpkhs' => $this->input->post('inpkhs') ?: 0,
            'inpksk' => $this->input->post('inpksk') ?: 0,
            'repakbls' => $this->input->post('repakbls') ?: 0,
            'hndcutting' => $this->input->post('hndcutting') ?: 0,
            'repakwt' => $this->input->post('repakwt') ?: 0,
            'user_code' => $user_code,
            'ent_date' => date('Y-m-d'),
            'ent_time' => date('H:i:s'),
            'joint_bags' => $this->input->post('joint_bags') ?: 0,
            'joint_mc' => $this->input->post('joint_mc') ?: 0,
            'lapp_yds' => $this->input->post('lapp_yds') ?: 0,
            'lapp_mc' => $this->input->post('lapp_mc') ?: 0,
            'exsewing' => $this->input->post('exsewing') ?: 0,
            'exsewmc' => $this->input->post('exsewmc') ?: 0,
            'press_mc_h' => $this->input->post('press_mc_h') ?: 0,
            'inpckbls_h' => $this->input->post('inpckbls_h') ?: 0,
            'repakbls_h' => $this->input->post('repakbls_h') ?: 0,
            'bale_stk_h' => $this->input->post('bale_stk_h') ?: 0,
            'bale_stk_s' => $this->input->post('bale_stk_s') ?: 0
        );
        
        $insert_id = $this->Daily_finishing_entry_model->insert_transaction($data);
        
        if ($insert_id) {
            $response = array(
                'success' => true,
                'message' => 'Record saved successfully',
                'id' => $insert_id
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Error saving record'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Get single record
     */
    public function get_record() {
        $id = $this->input->post('id');
        $record = $this->Daily_finishing_entry_model->get_record_by_id($id);
        
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
     * Update record
     */
    public function update_data() {
        $id = $this->input->post('id');
        $date = $this->input->post('date');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        
        $data = array(
            'date' => $date,
            'wvgbag' => $this->input->post('wvgbag') ?: 0,
            'cutting' => $this->input->post('cutting') ?: 0,
            'cutmc' => $this->input->post('cutmc') ?: 0,
            'hemming' => $this->input->post('hemming') ?: 0,
            'hemmc' => $this->input->post('hemmc') ?: 0,
            'sewing' => $this->input->post('sewing') ?: 0,
            'sewmc' => $this->input->post('sewmc') ?: 0,
            'herakle' => $this->input->post('herakle') ?: 0,
            'hermc' => $this->input->post('hermc') ?: 0,
            'hsewing' => $this->input->post('hsewing') ?: 0,
            'press' => $this->input->post('press') ?: 0,
            'premc' => $this->input->post('premc') ?: 0,
            'pckbls' => $this->input->post('pckbls') ?: 0,
            'hsewingh' => $this->input->post('hsewingh') ?: 0,
            'packedhs' => $this->input->post('packedhs') ?: 0,
            'yds' => $this->input->post('yds') ?: 0,
            'packsheet' => $this->input->post('packsheet') ?: 0,
            'saletwin' => $this->input->post('saletwin') ?: 0,
            'adj_hs' => $this->input->post('adj_hs') ?: 0,
            'adj_sk' => $this->input->post('adj_sk') ?: 0,
            'adj_sy' => $this->input->post('adj_sy') ?: 0,
            'adj_gc' => $this->input->post('adj_gc') ?: 0,
            'adj_bk' => $this->input->post('adj_bk') ?: 0,
            'packedsk' => $this->input->post('packedsk') ?: 0,
            'packedbk' => $this->input->post('packedbk') ?: 0,
            'outpkbls' => $this->input->post('outpkbls') ?: 0,
            'outpkhs' => $this->input->post('outpkhs') ?: 0,
            'outpksk' => $this->input->post('outpksk') ?: 0,
            'inpkbls' => $this->input->post('inpkbls') ?: 0,
            'inpkhs' => $this->input->post('inpkhs') ?: 0,
            'inpksk' => $this->input->post('inpksk') ?: 0,
            'repakbls' => $this->input->post('repakbls') ?: 0,
            'hndcutting' => $this->input->post('hndcutting') ?: 0,
            'repakwt' => $this->input->post('repakwt') ?: 0,
            'joint_bags' => $this->input->post('joint_bags') ?: 0,
            'joint_mc' => $this->input->post('joint_mc') ?: 0,
            'lapp_yds' => $this->input->post('lapp_yds') ?: 0,
            'lapp_mc' => $this->input->post('lapp_mc') ?: 0,
            'exsewing' => $this->input->post('exsewing') ?: 0,
            'exsewmc' => $this->input->post('exsewmc') ?: 0,
            'press_mc_h' => $this->input->post('press_mc_h') ?: 0,
            'inpckbls_h' => $this->input->post('inpckbls_h') ?: 0,
            'repakbls_h' => $this->input->post('repakbls_h') ?: 0,
            'bale_stk_h' => $this->input->post('bale_stk_h') ?: 0,
            'bale_stk_s' => $this->input->post('bale_stk_s') ?: 0
        );
        
        $result = $this->Daily_finishing_entry_model->update_transaction($id, $data);
        
        if ($result) {
            $response = array(
                'success' => true,
                'message' => 'Record updated successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Error updating record'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Delete record
     */
    public function delete_data() {
        $id = $this->input->post('id');
        $result = $this->Daily_finishing_entry_model->delete_transaction($id);
        
        if ($result) {
            $response = array(
                'success' => true,
                'message' => 'Record deleted successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Error deleting record'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Get data by date
     */
    public function get_data_by_date() {
        $date = $this->input->post('date');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        
        $record = $this->Daily_finishing_entry_model->get_first_record_by_date($date);
        
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

    /**
     * Export records to Excel for a specific date
     */
    public function export_excel() {
        $date = $this->input->get('date');
        
        if (!$date) {
            show_error('Date parameter is required');
        }
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $dateForDb = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        
        // Get records for the date
        $records = $this->Daily_finishing_entry_model->get_records_by_date($dateForDb);
        
        // Export using CSV format (Excel can open CSV files)
        $this->exportUsingCsv($records, $date);
    }

    /**
     * Export using CSV format as fallback
     */
    private function exportUsingCsv($records, $date) {
        $filename = 'Daily_Finishing_Report_' . str_replace('-', '', $date) . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8 encoding
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Write headers
        $headers = ['ID', 'Date', 'WVG Bag', 'Cutting', 'Cut MC', 'Hemming', 'Hem MC', 'Sewing', 'Sew MC', 
                    'Herakle', 'Her MC', 'H Sewing', 'Press', 'Press MC', 'PCK Bls', 'Packed HS', 'Pack Sheet', 
                    'Sale Twin', 'User Code'];
        fputcsv($output, $headers);
        
        // Write data rows
        foreach ($records as $record) {
            $row = [
                $record->id,
                date('d-m-Y', strtotime($record->date)),
                $record->wvgbag,
                $record->cutting,
                $record->cutmc,
                $record->hemming,
                $record->hemmc,
                $record->sewing,
                $record->sewmc,
                $record->herakle,
                $record->hermc,
                $record->hsewing,
                $record->press,
                $record->premc,
                $record->pckbls,
                $record->packedhs,
                $record->packsheet,
                $record->saletwin,
                $record->user_code
            ];
            fputcsv($output, $row);
        }
        
        fclose($output);
    }
}
?>
