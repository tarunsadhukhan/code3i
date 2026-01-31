<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Misc_prod_entries_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all records by transaction date
     */
    public function get_records_by_date($date, $company_id) {
        $this->db->select("*");
        $this->db->from('EMPMILL12.misc_prod_entries');
        $this->db->where('tran_date', $date);
        $this->db->where('co_id', $company_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('misc_prod_ent_id', 'DESC');
        $query = $this->db->get();
    //    echo $this->db->last_query(); // Debugging line to check the generated SQL query
        return $query->result();
    }

    /**
     * Get single record by ID
     */
    public function get_record_by_id($id) {
        $this->db->select("*");
        $this->db->from('EMPMILL12.misc_prod_entries');
        $this->db->where('misc_prod_ent_id', $id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }

    /**
     * Insert new misc prod entry record
     */
    public function insert_transaction($data) {
        $this->db->insert('EMPMILL12.misc_prod_entries', $data);
        return $this->db->insert_id();
    }

    /**
     * Update misc prod entry record
     */
    public function update_transaction($id, $data) {
        $this->db->where('misc_prod_ent_id', $id);
        return $this->db->update('EMPMILL12.misc_prod_entries', $data);
    }

    /**
     * Delete (soft delete) misc prod entry record
     */
    public function delete_transaction($id) {
        $data = array('is_active' => 0);
        $this->db->where('misc_prod_ent_id', $id);
        return $this->db->update('EMPMILL12.misc_prod_entries', $data);
    }

    /**
     * Check if record exists for given date and company
     */
    public function record_exists($date, $company_id) {
        $this->db->from('EMPMILL12.misc_prod_entries');
        $this->db->where('tran_date', $date);
        $this->db->where('co_id', $company_id);
        $this->db->where('is_active', 1);
        $count = $this->db->count_all_results();
        return ($count > 0) ? true : false;
    }

    /**
     * Get all dates with entries for a company
     */
    public function get_all_entry_dates($company_id) {
        $this->db->select("DISTINCT tran_date");
        $this->db->from('EMPMILL12.misc_prod_entries');
        $this->db->where('co_id', $company_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('tran_date', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * Get first record by date for form population
     */
    public function get_first_record_by_date($date, $company_id) {
        $this->db->select("*");
        $this->db->from('EMPMILL12.misc_prod_entries');
        $this->db->where('tran_date', $date);
        $this->db->where('co_id', $company_id);
        $this->db->where('is_active', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }
}
?>
