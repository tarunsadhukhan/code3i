<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hylt_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get quality details from EMPMILL12.hyltmast by qcode
     */
    public function get_quality_by_code($qcode, $company_id) {
        $this->db->select("qcode, width, shots, ports, ozsyds, i_b, unit, stdwt, jborbo, CONCAT(IFNULL(width,''), '\"-', IFNULL(ports,''), 'x', IFNULL(shots,''), ' - ', IFNULL(ozsyds,'')) AS quality_display");
        $this->db->from('EMPMILL12.hyltmast');
        $this->db->where('qcode', $qcode);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Get all hylt transaction records for a specific date
     */
    public function get_records_by_date($date, $company_id) {
        $this->db->select("ht.hylttran_id, ht.tran_date, ht.qcode, ht.orders, ht.bales, 
                          ht.av_mr, ht.av_std, ht.av_obj, ht.av_cor, ht.std_wt, 
                          ht.obj_wt, ht.cor_wt, ht.mlen, ht.unit, ht.diff_wt,
                          CONCAT(IFNULL(hm.width,''), '\"- ', IFNULL(hm.ports,''), 'x', IFNULL(hm.shots,''), ' - ', IFNULL(hm.ozsyds,'')) AS quality_display,
                          hylt_obj, hylt_cor");
        $this->db->from('EMPMILL12.hylttran ht');
        $this->db->join('EMPMILL12.hyltmast hm', 'ht.qcode = hm.qcode', 'left');
        $this->db->where('ht.tran_date', $date);
        $this->db->order_by('ht.hylttran_id', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * Insert new hylt transaction record
     */
    public function insert_transaction($data) {
  //      echo json_encode($data);  // Debugging line to inspect data being inserted
        $this->db->insert('EMPMILL12.hylttran', $data);
        return $this->db->insert_id();
    }

    /**
     * Update existing hylt transaction record
     */
    public function update_transaction($id, $data) {
        $this->db->where('hylttran_id', $id);
        return $this->db->update('EMPMILL12.hylttran', $data);
    }

    /**
     * Delete hylt transaction record
     */
    public function delete_transaction($id) {
        $this->db->where('hylttran_id', $id);
        return $this->db->delete('EMPMILL12.hylttran');
    }

    /**
     * Get single transaction by ID
     */
    public function get_transaction_by_id($id) {
        $this->db->select('*');
        $this->db->from('EMPMILL12.hylttran');
        $this->db->where('hylttran_id', $id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Check for duplicate entry
     */
    public function check_duplicate($qcode, $tran_date, $orders, $exclude_id = 0) {
        $this->db->select('hylttran_id');
        $this->db->from('hylttran');
        $this->db->where('qcode', $qcode);
        $this->db->where('tran_date', $tran_date);
        $this->db->where('orders', $orders);
        
        if ($exclude_id > 0) {
            $this->db->where('hylttran_id !=', $exclude_id);
        }
        
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Get quality name (if you have a quality master table)
     */
    public function get_quality_name($qcode) {
        // This assumes you might have a quality name somewhere
        // You can modify this based on your actual structure
        $this->db->select('qcode');
        $this->db->from('EMPMILL12.hyltmast');
        $this->db->where('qcode', $qcode);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->qcode;
        }
        return '';
    }

    // ========== HYLT MASTER METHODS ==========

    /**
     * Get all hylt master records
     */
    public function get_all_masters() {
        $this->db->select('*');
        $this->db->from('EMPMILL12.hyltmast');
        $this->db->order_by('hyltmast_id', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * Get single master record by ID
     */
    public function get_master_by_id($id) {
        $this->db->select('*');
        $this->db->from('EMPMILL12.hyltmast');
        $this->db->where('hyltmast_id', $id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Check if qcode already exists
     */
    public function check_qcode_exists($qcode, $exclude_id = 0) {
        $this->db->select('hyltmast_id');
        $this->db->from('EMPMILL12.hyltmast');
        $this->db->where('qcode', $qcode);
        
        if ($exclude_id > 0) {
            $this->db->where('hyltmast_id !=', $exclude_id);
        }
        
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Insert new master record
     */
    public function insert_master($data) {
        $this->db->insert('EMPMILL12.hyltmast', $data);
        return $this->db->insert_id();
    }

    /**
     * Update master record
     */
    public function update_master($id, $data) {
        $this->db->where('hyltmast_id', $id);
        return $this->db->update('EMPMILL12.hyltmast', $data);
    }

    /**
     * Delete master record
     */
    public function delete_master($id) {
        $this->db->where('hyltmast_id', $id);
        return $this->db->delete('EMPMILL12.hyltmast');
    }
}
