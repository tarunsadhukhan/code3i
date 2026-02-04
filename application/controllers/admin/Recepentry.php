<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recepentry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Recepentry_model');
        $this->load->library('form_validation');
        
        // Check if company_id is valid, otherwise logout
        $company_id = $this->session->userdata('company_id');
        if (empty($company_id) || $company_id == 0 || $company_id == '0') {
            $this->session->sess_destroy();
            redirect('admin/login');
        }
    }

    public function index() {
        $this->load->view('admin/recepentry/recepentry');
    }

    /**
     * Get all party list for dropdown
     */
    public function get_party_list() {
        $company_id = $this->session->userdata('company_id');
        $parties = $this->db->select('supp_id as party_id, supp_name as party')
            ->from('suppliermaster')
            ->where('company_id', $company_id)
            ->where_in('supp_type', ['J', 'O'])
            ->order_by('supp_name', 'ASC')
            ->get()
            ->result();
        
        echo json_encode($parties);
    }

    /**
     * Get party details by code
     */
    public function get_party() {
        $party_id = $this->input->post('party_id');
        $company_id = $this->session->userdata('company_id');
        
        $party = $this->db->select('supp_id as party_id, supp_name as party, address')
            ->from('suppliermaster')
            ->where('supp_id', $party_id)
            ->where('company_id', $company_id)
            ->where_in('supp_type', ['J', 'O'])
            ->get()
            ->row();
        
        if ($party) {
            $response = array(
                'success' => true,
                'party_id' => $party->party_id,
                'party' => $party->party,
                'address' => $party->address
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Party not found'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Get quality details by code
     */
    public function get_quality() {
        $jcode = $this->input->post('jcode');
        
        $quality = $this->Recepentry_model->get_quality_by_code($jcode);
        
        if ($quality) {
            $response = array(
                'success' => true,
                'jcode_id' => $quality->jcode_id,
                'quality' => $quality->quality,
                'stdrate' => $quality->stdrate
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Quality not found'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Get godown details by code
     */
    public function get_godown() {
        $godownno = $this->input->post('godownno');
        
        $godown = $this->Recepentry_model->get_godown_by_code($godownno);
        
        if ($godown) {
            $response = array(
                'success' => true,
                'godown_id' => $godown->godown_id
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Godown not found'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Get agency details by code
     */
    public function get_agency() {
        $agency_id = $this->input->post('agency_id');
        $company_id = $this->session->userdata('company_id');
        
        $agency = $this->db->select('mukam_id as agency_id, mukam_name as agency')
            ->from('mukam')
            ->where('mukam_id', $agency_id)
            ->where('company_id', $company_id)
            ->get()
            ->row();
        
        if ($agency) {
            $response = array(
                'success' => true,
                'agency' => $agency->agency
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Agency not found'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Get all agency list for dropdown
     */
    public function get_agency_list() {
        $company_id = $this->session->userdata('company_id');
        $agencies = $this->db->select('mukam_id as agency_id, mukam_name as agency')
            ->from('mukam')
            ->where('company_id', $company_id)
            ->order_by('mukam_name', 'ASC')
            ->get()
            ->result();
        
        echo json_encode($agencies);
    }

    /**
     * Get all broker list for dropdown
     */
    public function get_broker_list() {
        $company_id = $this->session->userdata('company_id');
        $brokers = $this->db->select('supp_id as broker_id, supp_name as broker_name')
            ->from('suppliermaster')
            ->where('company_id', $company_id)
            ->where_in('supp_type', ['J', 'O'])
            ->order_by('supp_name', 'ASC')
            ->get()
            ->result();
        
        echo json_encode($brokers);
    }

    /**
     * Get broker details by ID
     */
    public function get_broker() {
        $broker_id = $this->input->post('broker_id');
        $company_id = $this->session->userdata('company_id');
        
        $broker = $this->db->select('supp_id as broker_id, supp_name as broker_name')
            ->from('suppliermaster')
            ->where('supp_id', $broker_id)
            ->where('company_id', $company_id)
            ->where_in('supp_type', ['J', 'O'])
            ->get()
            ->row();
        
        if ($broker) {
            $response = array(
                'success' => true,
                'broker_name' => $broker->broker_name
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Broker not found'
            );
        }
        
        echo json_encode($response);
    }

    /**
     * Get all quality/jute list for dropdown
     */
    public function get_quality_list() {
        $qualities = $this->db->select('jcode_id, concat(jcode,\'-\',quality) as quality')
            ->from('EMPMILL12.jutemaster')
            ->order_by('quality', 'ASC')
            ->get()
            ->result();
        
        echo json_encode($qualities);
    }

    /**
     * Get all godown list for dropdown from warehouse_details table
     */
    public function get_godown_list() {
        $company_id = $this->session->userdata('company_id');
        
        $godowns = $this->db->select('id, name, address, type')
            ->from('warehouse_details')
                ->where('company_id', $company_id)
                ->where('type', 'J')
                
            ->order_by('name', 'ASC')
            ->get()
            ->result();
        
        echo json_encode($godowns);
    }

    /**
     * Get all packing/unit list for dropdown
     */
    public function get_unit_list() {
        $units = $this->db->select('pack_id, packing')
            ->from('EMPMILL12.pack_master')
            ->order_by('packing', 'ASC')
            ->get()
            ->result();
        
        echo json_encode($units);
    }

    /**
     * Get all receipt records for a specific date
     */
    public function get_records() {
        $date = $this->input->post('date');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        
        $records = $this->Recepentry_model->get_receipts_by_date($date, $this->session->userdata('company_id'));
        
        $data = [];
        $totalBales = 0;
        $totalWeight = 0;
        
        foreach ($records as $record) {
            $data[] = [
                $record->recpmast_id,
                $record->recpno,
                $record->inwarddate,
                $record->party,
                $record->challno,
                $record->lorryno,
                $record->agency,
                $record->quality,
                $record->godownno,
                $record->recpbales,
                $record->netweight,
                $record->claimqt,
                $record->claimmoist
            ];
            
            // Calculate totals
            $totalBales += floatval($record->recpbales);
            $totalWeight += floatval($record->netweight);
        }
        
        echo json_encode([
            'data' => $data,
            'totals' => [
                'bales' => $totalBales,
                'weight' => $totalWeight
            ]
        ]);
    }

    /**
     * Save new receipt with line items
     */
    public function save_receipt_header() {
        $recpno = $this->input->post('recpno');
        $fyyear = $this->input->post('fyyear');
        $lineItemsJson = $this->input->post('lineItems');
        
        // Parse line items
        $lineItems = json_decode($lineItemsJson, true);
        
        if (!$lineItems || count($lineItems) === 0) {
            echo json_encode(['success' => false, 'message' => 'No line items provided']);
            return;
        }
        
        // Check for duplicate
        if ($this->Recepentry_model->check_duplicate_receipt($recpno, $fyyear) > 0) {
            echo json_encode(['success' => false, 'message' => 'Duplicate Receipt Number']);
            return;
        }
        
        $inwarddate = $this->input->post('inwarddate');
        $inwarddate = substr($inwarddate, 6, 4) . '-' . substr($inwarddate, 3, 2) . '-' . substr($inwarddate, 0, 2);
        
        $headerData = array(
            'recpno' => $recpno,
            'fyyear' => $fyyear,
            'inwarddate' => $inwarddate,
            'lotno' => $this->input->post('lotno'),
            'partcode' => $this->input->post('party_id'),
            'brcode' => $this->input->post('broker_id'),
            'agcode' => $this->input->post('agency_id'),
            'challno' => $this->input->post('challno'),
            'chaldate' => $this->input->post('chaldate') ? substr($this->input->post('chaldate'), 6, 4) . '-' . substr($this->input->post('chaldate'), 3, 2) . '-' . substr($this->input->post('chaldate'), 0, 2) : null,
            'lorryno' => $this->input->post('lorryno'),
            'mrdate' => $this->input->post('mrdate') ? substr($this->input->post('mrdate'), 6, 4) . '-' . substr($this->input->post('mrdate'), 3, 2) . '-' . substr($this->input->post('mrdate'), 0, 2) : null,
            'jcino' => $this->input->post('jcino'),
            'rukkano' => $this->input->post('rukkano'),
            'rukkadate' => $this->input->post('rukkadate') ? substr($this->input->post('rukkadate'), 6, 4) . '-' . substr($this->input->post('rukkadate'), 3, 2) . '-' . substr($this->input->post('rukkadate'), 0, 2) : null,
            'user_id' => $this->session->userdata('user_id')
        );
        
        // Insert header
        $recpmast_id = $this->Recepentry_model->insert_receipt_header($headerData);
        
        if (!$recpmast_id) {
            echo json_encode(['success' => false, 'message' => 'Error Saving Receipt Header']);
            return;
        }
        
        // Insert line items
        $allItemsSaved = true;
        foreach ($lineItems as $item) {
            $itemData = array(
                'recpmast_id' => $recpmast_id,
                'jcode_id' => $item['jcodeid'],
                'godown_id' => $item['godown'],
                'recpbales' => $item['bales'],
                'packcode' => $item['unit'],
                'netweight' => $item['weight']
            );
            
            $itemId = $this->Recepentry_model->insert_receipt_item($itemData);
            if (!$itemId) {
                $allItemsSaved = false;
            }
        }
        
        if ($allItemsSaved) {
            echo json_encode(['success' => true, 'id' => $recpmast_id, 'message' => 'Receipt Saved Successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error saving some line items']);
        }
    }

    /**
     * Save receipt line item
     */
    public function save_receipt_item() {
        $recpmast_id = $this->input->post('recpmast_id');
        
        $data = array(
            'recpmast_id' => $recpmast_id,
            'jcode_id' => $this->input->post('jcode_id'),
            'godown_id' => $this->input->post('godown_id'),
            'chalbales' => $this->input->post('chalbales'),
            'recpbales' => $this->input->post('recpbales'),
            'packcode' => $this->input->post('packcode'),
            'chalweight' => $this->input->post('chalweight'),
            'netweight' => $this->input->post('netweight'),
            'claimqt' => $this->input->post('claimqt'),
            'claimmoist' => $this->input->post('claimmoist'),
            'mark' => $this->input->post('mark'),
            'mark1' => $this->input->post('mark1'),
            'mark2' => $this->input->post('mark2'),
            'remarks' => $this->input->post('remarks'),
            'report' => $this->input->post('report'),
            'qualdetl' => $this->input->post('qualdetl'),
            'season' => $this->input->post('season'),
            'othdetl' => $this->input->post('othdetl')
        );
        
        $id = $this->Recepentry_model->insert_receipt_item($data);
        
        if ($id) {
            echo json_encode(['success' => true, 'id' => $id, 'message' => 'Receipt Item Saved']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error Saving Receipt Item']);
        }
    }

    /**
     * Update receipt header
     */
    public function update_receipt_header() {
        $id = $this->input->post('recpmast_id');
        
        $inwarddate = $this->input->post('inwarddate');
        $inwarddate = substr($inwarddate, 6, 4) . '-' . substr($inwarddate, 3, 2) . '-' . substr($inwarddate, 0, 2);
        
        $data = array(
            'lotno' => $this->input->post('lotno'),
            'partcode' => $this->input->post('partcode'),
            'challno' => $this->input->post('challno'),
            'chaldate' => $this->input->post('chaldate') ? substr($this->input->post('chaldate'), 6, 4) . '-' . substr($this->input->post('chaldate'), 3, 2) . '-' . substr($this->input->post('chaldate'), 0, 2) : null,
            'lorryno' => $this->input->post('lorryno'),
            'agcode' => $this->input->post('agcode'),
            'mrdate' => $this->input->post('mrdate') ? substr($this->input->post('mrdate'), 6, 4) . '-' . substr($this->input->post('mrdate'), 3, 2) . '-' . substr($this->input->post('mrdate'), 0, 2) : null,
            'jcino' => $this->input->post('jcino'),
            'rukkano' => $this->input->post('rukkano'),
            'rukkadate' => $this->input->post('rukkadate') ? substr($this->input->post('rukkadate'), 6, 4) . '-' . substr($this->input->post('rukkadate'), 3, 2) . '-' . substr($this->input->post('rukkadate'), 0, 2) : null,
            'brcode' => $this->input->post('brcode')
        );
        
        if ($this->Recepentry_model->update_receipt_header($id, $data)) {
            echo json_encode(['success' => true, 'message' => 'Receipt Header Updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error Updating Receipt Header']);
        }
    }

    /**
     * Delete receipt item
     */
    public function delete_receipt_item() {
        $id = $this->input->post('recpfile_id');
        
        if ($this->Recepentry_model->delete_receipt_item($id)) {
            echo json_encode(['success' => true, 'message' => 'Receipt Item Deleted']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error Deleting Receipt Item']);
        }
    }

    /**
     * Get receipt data for editing
     */
    public function get_receipt_data() {
        $recpmast_id = $this->input->post('recpmast_id');
        
        $receiptData = $this->Recepentry_model->get_receipt_by_id($recpmast_id);
        
        if ($receiptData) {
            echo json_encode([
                'success' => true,
                'data' => $receiptData
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Receipt not found'
            ]);
        }
    }

    /**
     * Update receipt with all line items
     */
    public function update_receipt() {
        $recpmast_id = $this->input->post('recpmast_id');
        $lineItemsJson = $this->input->post('lineItems');
        
        $lineItems = json_decode($lineItemsJson, true);
        
        if (!$lineItems || count($lineItems) === 0) {
            echo json_encode(['success' => false, 'message' => 'No line items provided']);
            return;
        }
        
        // Prepare header data
        $inwarddate = $this->input->post('inwarddate');
        $inwarddate = substr($inwarddate, 6, 4) . '-' . substr($inwarddate, 3, 2) . '-' . substr($inwarddate, 0, 2);
        
        $headerData = array(
            'inwarddate' => $inwarddate,
            'lotno' => $this->input->post('lotno'),
            'partcode' => $this->input->post('party_id'),
            'brcode' => $this->input->post('broker_id'),
            'agcode' => $this->input->post('agency_id'),
            'challno' => $this->input->post('challno'),
            'chaldate' => $this->input->post('chaldate') ? substr($this->input->post('chaldate'), 6, 4) . '-' . substr($this->input->post('chaldate'), 3, 2) . '-' . substr($this->input->post('chaldate'), 0, 2) : null,
            'lorryno' => $this->input->post('lorryno'),
            'mrdate' => $this->input->post('mrdate') ? substr($this->input->post('mrdate'), 6, 4) . '-' . substr($this->input->post('mrdate'), 3, 2) . '-' . substr($this->input->post('mrdate'), 0, 2) : null,
            'jcino' => $this->input->post('jcino'),
            'rukkano' => $this->input->post('rukkano'),
            'rukkadate' => $this->input->post('rukkadate') ? substr($this->input->post('rukkadate'), 6, 4) . '-' . substr($this->input->post('rukkadate'), 3, 2) . '-' . substr($this->input->post('rukkadate'), 0, 2) : null
        );
        
        // Update header
        if (!$this->Recepentry_model->update_receipt_header($recpmast_id, $headerData)) {
            echo json_encode(['success' => false, 'message' => 'Error Updating Receipt Header']);
            return;
        }
        
        // Delete existing line items
        $this->db->where('recpmast_id', $recpmast_id);
        $this->db->delete('EMPMILL12.recpfile');
        
        // Insert updated line items
        $allItemsSaved = true;
        foreach ($lineItems as $item) {
            $itemData = array(
                'recpmast_id' => $recpmast_id,
                'jcode_id' => $item['jcodeid'],
                'godown_id' => $item['godown'],
                'recpbales' => $item['bales'],
                'packcode' => $item['unit'],
                'netweight' => $item['weight']
            );
            
            $itemId = $this->Recepentry_model->insert_receipt_item($itemData);
            if (!$itemId) {
                $allItemsSaved = false;
            }
        }
        
        if ($allItemsSaved) {
            echo json_encode(['success' => true, 'id' => $recpmast_id, 'message' => 'Receipt Updated Successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating some line items']);
        }
    }

    public function check_existing_import() {
        header('Content-Type: application/json');
        
        $receipt_date = $this->input->post('receipt_date');
        
                $receipt_date = substr($receipt_date, 6, 4) . '-' . substr($receipt_date, 3, 2) . '-' . substr($receipt_date, 0, 2);


        if (!$receipt_date) {
            echo json_encode(['exists' => false, 'message' => 'Receipt date is required']);
            return;
        }

        $exists = $this->Recepentry_model->check_receipt_exists($receipt_date);
        
        echo json_encode(['exists' => (bool)$exists, 'message' => $exists ? 'Data exists' : 'No data']);
    }

    public function import_jute_receipt() {
        $receipt_date = $this->input->post('receipt_date');
        $delete_existing = $this->input->post('delete_existing');
            $receipt_date = substr($receipt_date, 6, 4) . '-' . substr($receipt_date, 3, 2) . '-' . substr($receipt_date, 0, 2);
        
        if (!$receipt_date) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Receipt date is required']);
            return;
        }

        // Delete existing records if requested
        if ($delete_existing) {
            $this->Recepentry_model->delete_receipt_by_date($receipt_date);
        }

        $data = $this->Recepentry_model->get_jute_receipt_data($receipt_date);
        
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Data imported successfully', 'data' => $data]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No data found for the selected date']);
        }
    }

    /**
     * Delete receipt by ID
     */
    public function delete_receipt() {
        $recpmast_id = $this->input->post('recpmast_id');
        
        if (!$recpmast_id) {
            echo json_encode(['success' => false, 'message' => 'Receipt ID is required']);
            return;
        }

        // Delete line items first
        $this->db->where('recpmast_id', $recpmast_id);
        $items_deleted = $this->db->delete('EMPMILL12.recpfile');

        // Delete header
        $this->db->where('recpmast_id', $recpmast_id);
        $header_deleted = $this->db->delete('EMPMILL12.recpheader');

        if ($header_deleted) {
            echo json_encode(['success' => true, 'message' => 'Receipt deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting receipt']);
        }
    }
}
