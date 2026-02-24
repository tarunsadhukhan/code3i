<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_finishing_entry_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all records by transaction date using custom query
     */
    public function get_records_by_date($date) {
        $sql = "SELECT * FROM EMPMILL12.tbl_daily_finishing_entry WHERE date = ? ORDER BY id DESC";
        $query = $this->db->query($sql, array($date));
        return $query->result();
    }

    /**
     * Get single record by ID
     */
    public function get_record_by_id($id) {
        $this->db->select("*");
        $this->db->from('EMPMILL12.tbl_daily_finishing_entry');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Insert new daily finishing entry record
     */
    public function insert_transaction($data) {
        $this->db->insert('EMPMILL12.tbl_daily_finishing_entry', $data);
        return $this->db->insert_id();
    }

    /**
     * Update daily finishing entry record
     */
    public function update_transaction($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('EMPMILL12.tbl_daily_finishing_entry', $data);
    }

    /**
     * Delete daily finishing entry record
     */
    public function delete_transaction($id) {
        $this->db->where('id', $id);
        return $this->db->delete('EMPMILL12.tbl_daily_finishing_entry');
    }

    /**
     * Check if record exists for given date
     */
    public function record_exists($date) {
        $this->db->from('EMPMILL12.tbl_daily_finishing_entry');
        $this->db->where('date', $date);
        $count = $this->db->count_all_results();
        return ($count > 0) ? true : false;
    }

    /**
     * Get all dates with entries
     */
    public function get_all_entry_dates() {
        $this->db->select("DISTINCT date");
        $this->db->from('EMPMILL12.tbl_daily_finishing_entry');
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * Get first record by date for form population
     */
    public function get_first_record_by_date($date) {
        $this->db->select("*");
        $this->db->from('EMPMILL12.tbl_daily_finishing_entry');
        $this->db->where('date', $date);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }
}
?>
