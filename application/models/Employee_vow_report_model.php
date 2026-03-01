<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_vow_report_model extends CI_Model {

    private $db_vow;

    public function __construct() {
        parent::__construct();
        // Load the vowsls database
        $this->db_vow = $this->load->database('vowsls', TRUE);
    }

    /**
     * Get Employee VOW Data with optional filters
     * @param int $companyId
     * @param array $filters Optional filters (date_of_join_from, date_of_join_to, departments, contractors, designations, status)
     * @return array
     */
    public function getEmployeeVowData($companyId, $filters = []) {
        $this->db_vow->select("
            thepd.eb_id,
            theod.emp_code,
            CONCAT(first_name, ' ', IFNULL(middle_name, ' '), ' ', IFNULL(last_name, ' ')) AS emp_name,
            thepd.gender,
            dm.dept_code,
            dm.dept_desc,
            d.desig,
            cm.cata_desc,
            DATE_FORMAT(thepd.date_of_birth, '%d-%m-%Y') AS date_of_birth,
            DATE_FORMAT(theod.date_of_join, '%d-%m-%Y') AS date_of_join,
            thee.esi_no,
            thep.pf_no,
            DATE_FORMAT(thep.pf_date_of_join, '%d-%m-%Y') AS pf_date_of_join,
            thep.pf_uan_no,
            thebd.bank_acc_no,
            thebd.ifsc_code,
            thebd.bank_name,
            cnt.contractor_name,
            sm.status_name,
            tps.NAME as pay_scheme,
            CASE WHEN thepd.is_active=1 THEN 'Active' ELSE 'InActive' END AS isactive,
            DATE_FORMAT(da.last_workings, '%d-%m-%Y') AS last_workings
        ");

        $this->db_vow->from('tbl_hrms_ed_personal_details thepd');
        $this->db_vow->join('tbl_hrms_ed_official_details theod', 'thepd.eb_id = theod.eb_id AND theod.is_active = 1', 'left');
        $this->db_vow->join('tbl_hrms_ed_bank_details thebd', 'thepd.eb_id = thebd.eb_id AND thebd.is_active = 1', 'left');
        $this->db_vow->join('tbl_hrms_ed_esi thee', 'thepd.eb_id = thee.eb_id AND thee.is_active = 1', 'left');
        $this->db_vow->join('tbl_hrms_ed_pf thep', 'thepd.eb_id = thep.eb_id AND thep.is_active = 1', 'left');
        $this->db_vow->join('department_master dm', 'dm.dept_id = theod.department_id', 'left');
        $this->db_vow->join('designation d', 'd.id = theod.designation_id', 'left');
        $this->db_vow->join('category_master cm', 'cm.cata_id = theod.catagory_id', 'left');
        $this->db_vow->join('contractor_master cnt', 'cnt.cont_id = theod.contractor_id', 'left');
        $this->db_vow->join('status_master sm', 'sm.status_id = thepd.status', 'left');
        $this->db_vow->join('tbl_pay_employee_payscheme tpep', 'thepd.eb_id = tpep.EMPLOYEEID AND tpep.STATUS = 1', 'left');
        $this->db_vow->join('tbl_pay_scheme tps', 'tps.ID = tpep.PAY_SCHEME_ID', 'left');
        $this->db_vow->join(
            '(SELECT eb_id, MAX(attendance_date) as last_workings FROM daily_attendance WHERE is_active=1 GROUP BY eb_id) da',
            'da.eb_id = thepd.eb_id',
            'left'
        );

        // Base filters
        $this->db_vow->where('thepd.company_id', $companyId);
        $this->db_vow->where('theod.emp_code IS NOT NULL');

        // Apply optional filters
        if (!empty($filters['date_of_join_from'])) {
            $this->db_vow->where('DATE(theod.date_of_join) >=', $filters['date_of_join_from']);
        }
        if (!empty($filters['date_of_join_to'])) {
            $this->db_vow->where('DATE(theod.date_of_join) <=', $filters['date_of_join_to']);
        }
        if (!empty($filters['departments']) && is_array($filters['departments'])) {
            $this->db_vow->where_in('dm.dept_id', $filters['departments']);
        }
        if (!empty($filters['contractors']) && is_array($filters['contractors'])) {
            $this->db_vow->where_in('cnt.cont_id', $filters['contractors']);
        }
        if (!empty($filters['designations']) && is_array($filters['designations'])) {
            $this->db_vow->where_in('d.id', $filters['designations']);
        }
        if (!empty($filters['status'])) {
            $this->db_vow->where('thepd.status', $filters['status']);
        }

        // Order by
        $this->db_vow->order_by('cm.cata_desc', 'ASC');
        $this->db_vow->order_by('emp_name', 'ASC');

        $query = $this->db_vow->get();
    
        return $query->result_array();
    }

    /**
     * Get Department Master data for filter dropdown
     * @param int $companyId
     * @return array
     */
    public function getDepartmentMaster($companyId) {
        $this->db_vow->select('dept_id, dept_code, dept_desc');
        $this->db_vow->from('department_master');
        $this->db_vow->where('company_id', $companyId);
        $this->db_vow->order_by('dept_desc', 'ASC');
        $query = $this->db_vow->get();
        return $query->result_array();
    }

    /**
     * Get Contractor Master data for filter dropdown
     * @param int $companyId
     * @return array
     */
    public function getContractorMaster($companyId) {
        $this->db_vow->select('cont_id, contractor_name');
        $this->db_vow->from('contractor_master');
        $this->db_vow->where('company_id', $companyId);
        $this->db_vow->where('is_active', 1);
        $this->db_vow->order_by('contractor_name', 'ASC');
        $query = $this->db_vow->get();
        return $query->result_array();
    }

    /**
     * Get Designation Master data for filter dropdown
     * @param int $companyId
     * @return array
     */
    public function getDesignationMaster($companyId) {
        $this->db_vow->select('d.id, d.desig');
        $this->db_vow->from('designation d');
        $this->db_vow->where('d.company_id', $companyId);
        $this->db_vow->order_by('d.desig', 'ASC');
        $query = $this->db_vow->get();
        return $query->result_array();
    }

    /**
     * Get Status Master data for filter dropdown
     * @return array
     */
    public function getStatusMaster() {
        $this->db_vow->select('status_id, status_name');
        $this->db_vow->from('status_master');
        $this->db_vow->order_by('status_name', 'ASC');
        $query = $this->db_vow->get();
        return $query->result_array();
    }
}
