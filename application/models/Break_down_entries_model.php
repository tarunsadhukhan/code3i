<?php
class Break_down_entries_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all records by date and company
    public function get_records_by_date($date, $company_id) {
        // Convert dd-mm-yy to yyyy-mm-dd for database query
        $dateArray = explode('-', $date);
        if (count($dateArray) == 3) {
            $dbDate = '20' . $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
        } else {
            $dbDate = $date;
        }

        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

        $this->db->select('bde.*, mm.mech_code, CONCAT(mm.mech_code, "-", mm.mechine_name) AS mechine_name');
        $this->db->from('EMPMILL12.break_down_entries bde');
        $this->db->join('mechine_master mm', 'bde.mechine_id = mm.mechine_id', 'left');
        $this->db->where('bde.tran_date', $date);
        $this->db->where('bde.co_id', $company_id);
        $this->db->where('bde.is_active', 1);
        $this->db->order_by('bde.bkd_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get first record by date for form population
    public function get_first_record_by_date($date, $company_id) {
        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

        $this->db->select('*');
        $this->db->from('EMPMILL12.break_down_entries');
        $this->db->where('tran_date', $date);
        $this->db->where('co_id', $company_id);
        $this->db->where('is_active', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Insert new transaction
    public function insert_transaction($data) {
        return $this->db->insert('EMPMILL12.break_down_entries', $data);
    }

    // Update transaction
    public function update_transaction($id, $data) {
        $this->db->where('bkd_id', $id);
        return $this->db->update('EMPMILL12.break_down_entries', $data);
    }

    // Delete transaction (soft delete)
    public function delete_transaction($id) {
        $this->db->where('bkd_id', $id);
        return $this->db->update('EMPMILL12.break_down_entries', array('is_active' => 0));
    }

    // Get record by ID
    public function get_record_by_id($id) {
        $company_id = $this->session->userdata('company_id');

        $this->db->select('*');
        $this->db->from('EMPMILL12.break_down_entries');
        $this->db->where('bkd_id', $id);
        $this->db->where('co_id', $company_id);
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Get all mechines
    public function get_mechines() {
        $company_id = $this->session->userdata('company_id');

        $this->db->select('mechine_id, concat(mech_code,"-", mechine_name) as mechine_name');
        $this->db->from('mechine_master');
        $this->db->where('company_id', $company_id);
        $this->db->order_by('mechine_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get machine by ID
    public function get_machine_by_id($machine_id) {
        $company_id = $this->session->userdata('company_id');

        $this->db->select('mechine_id, concat(mech_code,"/", mechine_name) as mechine_name');
        $this->db->from('mechine_master');
        $this->db->where('mechine_id', $machine_id);
        $this->db->where('company_id', $company_id);
        $query = $this->db->get();
        return $query->row_array();
    }
}
?>
