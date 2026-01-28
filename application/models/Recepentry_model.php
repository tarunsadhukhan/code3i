<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recepentry_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all receipt headers with line items for a specific date
     */
    public function get_receipts_by_date($date, $company_id) {
        $this->db->select('rh.recpmast_id, rh.recpno, rh.lotno, rh.inwarddate, rh.partcode, 
                          rh.challno, rh.chaldate, rh.lorryno, rh.agcode, rh.fyyear, 
                          rh.rukkano, rh.rukkadate, rh.mrdate, rh.jcino, rh.brcode,
                          pm.supp_name as party, jm.quality, wd.name as godownno, mk.mukam_name as agency, rf.recpbales,
                          rf.chalweight, rf.netweight, rf.claimqt, rf.claimmoist');
        $this->db->from('EMPMILL12.recpheader rh');
        $this->db->join('EMPMILL12.recpfile rf', 'rh.recpmast_id = rf.recpmast_id', 'left');
        $this->db->join('suppliermaster pm', 'rh.partcode = pm.supp_id', 'left');
        $this->db->join('EMPMILL12.jutemaster jm', 'rf.jcode_id = jm.jcode_id', 'left');
        $this->db->join('warehouse_details wd', 'rf.godown_id = wd.id', 'left');
        $this->db->join('mukam mk', 'rh.agcode = mk.mukam_id', 'left');
        $this->db->where('rh.inwarddate', $date);
        $this->db->order_by('rh.recpmast_id', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * Get complete receipt data by ID (header + line items with all details)
     */
    public function get_receipt_by_id($recpmast_id) {
        // Get header with joined data
        $this->db->select('rh.*, pm.supp_name as party_name, pm.address, mk.mukam_name as agency_name');
        $this->db->from('EMPMILL12.recpheader rh');
        $this->db->join('suppliermaster pm', 'rh.partcode = pm.supp_id', 'left');
        $this->db->join('mukam mk', 'rh.agcode = mk.mukam_id', 'left');
        $this->db->where('rh.recpmast_id', $recpmast_id);
        $headerQuery = $this->db->get();
        
        $header = ($headerQuery->num_rows() > 0) ? $headerQuery->row_array() : null;
        
        if (!$header) {
            return null;
        }
        
        // Get line items with all details
        $this->db->select('rf.*, jm.quality, jm.jcode, wd.name as godownname, wd.id as godown_id, pac.packing, pac.pack_id');
        $this->db->from('EMPMILL12.recpfile rf');
        $this->db->join('EMPMILL12.jutemaster jm', 'rf.jcode_id = jm.jcode_id', 'left');
        $this->db->join('warehouse_details wd', 'rf.godown_id = wd.id', 'left');
        $this->db->join('EMPMILL12.pack_master pac', 'rf.packcode = pac.pack_id', 'left');
        $this->db->where('rf.recpmast_id', $recpmast_id);
        $this->db->order_by('rf.slno', 'ASC');
        $itemsQuery = $this->db->get();
        
        $items = $itemsQuery->result_array();
        
        return [
            'header' => $header,
            'items' => $items
        ];
    }

    /**
     * Get single receipt header by ID
     */
    public function get_receipt_header($id) {
        $this->db->select('*');
        $this->db->from('EMPMILL12.recpheader');
        $this->db->where('recpmast_id', $id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Get receipt line items
     */
    public function get_receipt_items($recpmast_id) {
        $this->db->select('rf.*, jm.quality, wd.name as godownname, pm.supp_name as party, pac.packing');
        $this->db->from('EMPMILL12.recpfile rf');
        $this->db->join('EMPMILL12.jutemaster jm', 'rf.jcode_id = jm.jcode_id', 'left');
        $this->db->join('EMPMILL12.warehouse_details wd', 'rf.godown_id = wd.id', 'left');
        $this->db->join('suppliermaster pm', 'rf.markcode = pm.supp_id', 'left');
        $this->db->join('EMPMILL12.pack_master pac', 'rf.packcode = pac.pack_id', 'left');
        $this->db->where('rf.recpmast_id', $recpmast_id);
        $this->db->order_by('rf.slno', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * Insert receipt header
     */
    public function insert_receipt_header($data) {
        $this->db->insert('EMPMILL12.recpheader', $data);
        return $this->db->insert_id();
    }

    /**
     * Update receipt header
     */
    public function update_receipt_header($id, $data) {
        $this->db->where('recpmast_id', $id);
        return $this->db->update('EMPMILL12.recpheader', $data);
    }

    /**
     * Insert receipt line item
     */
    public function insert_receipt_item($data) {
        $this->db->insert('EMPMILL12.recpfile', $data);
        return $this->db->insert_id();
    }

    /**
     * Update receipt line item
     */
    public function update_receipt_item($id, $data) {
        $this->db->where('recpfile_id', $id);
        return $this->db->update('EMPMILL12.recpfile', $data);
    }

    /**
     * Delete receipt line item
     */
    public function delete_receipt_item($id) {
        $this->db->where('recpfile_id', $id);
        return $this->db->delete('EMPMILL12.recpfile');
    }

    /**
     * Delete receipt header
     */
    public function delete_receipt_header($id) {
        $this->db->where('recpmast_id', $id);
        return $this->db->delete('EMPMILL12.recpheader');
    }

    /**
     * Get party master by code
     */
    public function get_party_by_code($partcode) {
        $this->db->select('supp_id as party_id, supp_code as partcode, supp_name as party, address');
        $this->db->from('suppliermaster');
        $this->db->where('supp_code', $partcode);
        $this->db->where('supp_type', 'J');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Get quality by code
     */
    public function get_quality_by_code($jcode) {
        $this->db->select('jcode_id, jcode, quality, stdrate');
        $this->db->from('EMPMILL12.jutemaster');
        $this->db->where('jcode', $jcode);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Get godown by code
     */
    public function get_godown_by_code($godownno) {
        $this->db->select('godown_id, godownno');
        $this->db->from('EMPMILL12.godownmaster');
        $this->db->where('godownno', $godownno);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Get agency by code
     */
    public function get_agency_by_code($agcode) {
        $this->db->select('*');
        $this->db->from('EMPMILL12.mukam_master');
        $this->db->where('agcode', $agcode);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Check duplicate receipt
     */
    public function check_duplicate_receipt($recpno, $fyyear, $exclude_id = 0) {
        $this->db->select('recpmast_id');
        $this->db->from('EMPMILL12.recpheader');
        $this->db->where('recpno', $recpno);
        $this->db->where('fyyear', $fyyear);
        
        if ($exclude_id > 0) {
            $this->db->where('recpmast_id !=', $exclude_id);
        }
        
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Get next receipt number
     */
    public function get_next_receipt_no($fyyear) {
        $this->db->select_max('recpno');
        $this->db->from('EMPMILL12.recpheader');
        $this->db->where('fyyear', $fyyear);
        $query = $this->db->get();
        
        $result = $query->row();
        if ($result->recpno) {
            return str_pad(intval($result->recpno) + 1, 5, '0', STR_PAD_LEFT);
        }
        return '00001';
    }

    /**
     * Get jute receipt data for import by receipt date
     */
    public function get_jute_receipt_data($receipt_date) {
        $sql = "SELECT 
                    rh.partcode as party_id,
                    rh.brcode as broker_id,
                    rh.challno,
                    rh.chaldate,
                    rh.lorryno,
                    rh.agcode as agency_id,
                    rh.mrdate,
                    rh.rukkano,
                    rh.rukkadate
                FROM EMPMILL12.recpheader rh
                WHERE rh.inwarddate = ?
                ORDER BY rh.recpmast_id DESC
                LIMIT 1";
        
        $query = $this->db->query($sql, array($receipt_date));
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return null;
    }
}
