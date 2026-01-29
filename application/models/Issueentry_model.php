<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issueentry_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get quality list from jutemaster
     */
    public function get_quality_list() {
        $this->db->select('jcode_id, jcode, quality, stdrate');
        $this->db->from('EMPMILL12.jutemaster');
        $this->db->order_by('quality', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get godown list from warehouse_details
     */
    public function get_godown_list() {
        $this->db->select('id, name');
        $this->db->from('warehouse_details');
        $this->db->where('type', 'J');
        $this->db->where('company_id', $this->session->userdata('company_id'));
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get unit/packing list from pack_master
     */
    public function get_unit_list() {
        $this->db->select('pack_id, packing');
        $this->db->from('EMPMILL12.pack_master');
        $this->db->order_by('packing', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get all issue records for a specific date
     */
    public function get_issues_by_date($date) {
        $this->db->select('i.issue_id,  i.issuedate, i.fyyear, i.jcode_id, i.godown_id, i.packcode,
                          jm.quality, jm.jcode, wd.name as godownno, i.bales, i.weight, 
                          pm.packing, i.stype, i.rate, i.jute01, i.jute02');
        $this->db->from('EMPMILL12.issufile i');
        $this->db->join('EMPMILL12.jutemaster jm', 'i.jcode_id = jm.jcode_id', 'left');
        $this->db->join('warehouse_details wd', 'i.godown_id = wd.id', 'left');
        $this->db->join('EMPMILL12.pack_master pm', 'i.packcode = pm.pack_id', 'left');
        $this->db->where('i.issuedate', $date);
        $this->db->order_by('i.issue_id', 'DESC');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * Get single issue record by ID
     */
    public function get_issue_by_id($issue_id) {
        $this->db->select('i.*, jm.quality, jm.jcode, wd.name as godownname, pm.packing');
        $this->db->from('EMPMILL12.issufile i');
        $this->db->join('EMPMILL12.jutemaster jm', 'i.jcode_id = jm.jcode_id', 'left');
        $this->db->join('warehouse_details wd', 'i.godown_id = wd.id', 'left');
        $this->db->join('EMPMILL12.pack_master pm', 'i.packcode = pm.pack_id', 'left');
        $this->db->where('i.issue_id', $issue_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return null;
    }

    /**
     * Insert new issue record
     */
    public function insert_issue_item($data) {
        $this->db->insert('EMPMILL12.issufile', $data);
        return $this->db->insert_id();
    }

    /**
     * Update issue record
     */
    public function update_issue_item($id, $data) {
        $this->db->where('issue_id', $id);
        return $this->db->update('EMPMILL12.issufile', $data);
    }

    /**
     * Delete issue record
     */
    public function delete_issue_item($id) {
        $this->db->where('issue_id', $id);
        return $this->db->delete('EMPMILL12.issufile');
    }

    /**
     * Check duplicate issue
     */
    public function check_duplicate_issue($issueno, $fyyear, $exclude_id = 0) {
        $this->db->select('issue_id');
        $this->db->from('EMPMILL12.issufile');
        $this->db->where('issueno', $issueno);
        $this->db->where('fyyear', $fyyear);
        
        if ($exclude_id > 0) {
            $this->db->where('issue_id !=', $exclude_id);
        }
        
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Get next issue number
     */
    public function get_next_issue_no($fyyear) {
        $this->db->select_max('issueno');
        $this->db->from('EMPMILL12.issufile');
        $this->db->where('fyyear', $fyyear);
        $query = $this->db->get();
        
        $result = $query->row();
        if ($result->issueno) {
            return str_pad(intval($result->issueno) + 1, 5, '0', STR_PAD_LEFT);
        }
        return '00001';
    }

    /**
     * Get jute issue data from jute_issue table based on date
     */
    public function get_jute_issue_data($issue_date) {
        // First, perform the INSERT operation
        $insert_sql = "INSERT INTO EMPMILL12.issufile
            (issuedate, godown_id, jcode_id, bales, packcode, weight, fyyear, jute01, jute02, vissno)
            SELECT
            ji.issue_date                                         AS issuedate,
            ji.godown_no                                          AS godown_id,
            vl.jute01_jcode_id                                    AS jcode_id,
            ji.quantity                                           AS bales,
            CASE WHEN ji.bale_loose = 'BALE' THEN 3 ELSE 5 END AS packcode,
            ji.total_weight*100                                       AS weight,
            ji.fin_year                                           AS fyyear,
            'Y'                                                   AS jute01,
            'Y'                                                   AS jute02,
            ji.issue_no                                           AS vissno
            FROM jute_issue ji
            LEFT JOIN EMPMILL12.vowjut01_link vl
            ON vl.vow_jcode_id = ji.jute_quality
            WHERE ji.is_active = 1
            AND ji.company_id = 2
            AND ji.issue_status NOT IN (4, 6)
            AND ji.issue_date = ?";
        
        // Execute insert
        $this->db->query($insert_sql, array($issue_date));
        
        // Now fetch and return the inserted data
        $select_sql = "SELECT * FROM EMPMILL12.issufile WHERE issuedate = ? ORDER BY issue_id DESC LIMIT 1";
        $query = $this->db->query($select_sql, array($issue_date));
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return null;
    }

    /**
     * Check if issue data already exists for a given date
     */
    public function check_issue_exists($issue_date) {
        $this->db->from('EMPMILL12.issufile');
        $this->db->where('issuedate', $issue_date);
        $count = $this->db->count_all_results();
        return $count > 0;
    }

    /**
     * Delete issue records for a given date
     */
    public function delete_issue_by_date($issue_date) {
        $this->db->delete('EMPMILL12.issufile', ['issuedate' => $issue_date]);
    }
}

