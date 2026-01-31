<?php
class Spreader_lapping_entries_model extends CI_Model {

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

        $this->db->select('sle.*, 
            mm.mech_code,
            wf.eb_no AS feeder_eb_no,
            wf.worker_name AS feeder_name,
            wr.eb_no AS receiver_eb_no,
            wr.worker_name AS receiver_name');
        $this->db->from('EMPMILL12.spreader_lapping_entries sle');
        $this->db->join('mechine_master mm', 'sle.mechine_id = mm.mechine_id', 'left');
        $this->db->join('worker_master wf', 'sle.feeder_id = wf.eb_id', 'left');
        $this->db->join('worker_master wr', 'sle.receiver_id = wr.eb_id', 'left');
        $this->db->where('sle.tran_date', $date);
        $this->db->where('sle.co_id', $company_id);
        $this->db->where('sle.is_active', 1);
        $this->db->order_by('mm.mech_code,sle.spell');

        $query = $this->db->get();
     //   ECHO $this->db->last_query();
        return $query->result_array();
    }

    // Get first record by date for form population
    public function get_first_record_by_date($date, $company_id) {
        // Convert dd-mm-yy to yyyy-mm-dd for database query
        $dateArray = explode('-', $date);
        if (count($dateArray) == 3) {
            $dbDate = '20' . $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
        } else {
            $dbDate = $date;
        }
     $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

        $this->db->select('*');
        $this->db->from('EMPMILL12.spreader_lapping_entries');
        $this->db->where('tran_date', $date);
        $this->db->where('co_id', $company_id);
        $this->db->where('is_active', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Insert new transaction
    public function insert_transaction($data) {
        return $this->db->insert('EMPMILL12.spreader_lapping_entries', $data);
    }

    // Update transaction
    public function update_transaction($id, $data) {
        $this->db->where('sprd_lapp_id', $id);
        return $this->db->update('EMPMILL12.spreader_lapping_entries', $data);
    }

    // Delete transaction (soft delete)
    public function delete_transaction($id) {
        $this->db->where('sprd_lapp_id', $id);
        return $this->db->update('EMPMILL12.spreader_lapping_entries', array('is_active' => 0));
    }

    // Get record by ID
    public function get_record_by_id($id) {
        $this->db->select('*');
        $this->db->from('EMPMILL12.spreader_lapping_entries');
        $this->db->where('sprd_lapp_id', $id);
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Check if record exists
    public function record_exists($date, $company_id) {
        // Convert dd-mm-yy to yyyy-mm-dd for database query
        $dateArray = explode('-', $date);
        if (count($dateArray) == 3) {
            $dbDate = '20' . $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
        } else {
            $dbDate = $date;
        }
     $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

        $this->db->select('COUNT(*) as count');
        $this->db->from('EMPMILL12.spreader_lapping_entries');
        $this->db->where('tran_date', $date);
        $this->db->where('co_id', $company_id);
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['count'] > 0;
    }

    // Get all mechines
    public function get_mechines() {
        $company_id = $this->session->userdata('company_id');

        $this->db->select('mechine_id, concat(mech_code,\'-\', mechine_name) as mechine_name');
        $this->db->from('mechine_master');
        $this->db->where('company_id', $company_id);
        $this->db->order_by('mechine_name', 'ASC');
        $query = $this->db->get();
     //   echo $this->db->last_query();
        return $query->result_array();
    }

    // Get machine by ID
    public function get_machine_by_id($machine_id) {
        $company_id = $this->session->userdata('company_id');

        $this->db->select('mechine_id, concat(mech_code,\'-\', mechine_name) as mechine_name');
        $this->db->from('mechine_master');
        $this->db->where('mechine_id', $machine_id);
        $this->db->where('company_id', $company_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Get worker name by EBNO
    public function get_worker_name($ebno) {
        $company_id = $this->session->userdata('company_id');
        
        $this->db->select('eb_id, eb_no, CONCAT(worker_name, " ", IFNULL(middle_name, ""), " ", IFNULL(last_name, "")) AS worker_name');
        $this->db->from('worker_master');
        $this->db->where('eb_no', $ebno);
        $this->db->where('company_id', $company_id);
        
        $query = $this->db->get();
        return $query->row_array();
    }

    // Import spreader data
    public function import_spreader_data($date, $company_id) {
        // Convert dd-mm-yy to yyyy-mm-dd for database query
        $dateArray = explode('-', $date);
        if (count($dateArray) == 3) {
            $dbDate = '20' . $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
        } else {
            $dbDate = $date;
        }

        $updated_by = $this->session->userdata('user_id');
        $updated_by = 26586;

        $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
        
      //   echo 'updated_by: ' . $updated_by;
        // Custom SQL query to insert from sprdprod table

        $sql="delete from EMPMILL12.spreader_lapping_entries where tran_date='$date' and co_id=$company_id";
        $this->db->query($sql);
        $sql = " 					insert into EMPMILL12.spreader_lapping_entries (tran_date,spell,production,feeder_id,
receiver_id,prod_type,co_id,updated_by,mechine_id,is_active,hours)
select entry_date,spell,prod,feeder_no,receiver_no,0 prodtype,$company_id coid,$updated_by usrid,mechine_id,1 act,
case when spell='A1' then 5 when spell='B1' then 3
when spell='B2' then 5 when spell='A2' then 3 else 7.5 end hours from (
					select *,
    SUBSTRING_INDEX(ebnos, '/', 1)  AS feeder_no,
    SUBSTRING_INDEX(ebnos, '/', -1) AS receiver_no
 from (
 select mm.mechine_id ,mm.mech_code,mm.mechine_name,spd.entry_date ,spd.spell , spd.prod,da.ebnos  from (		
					select spreader_no,entry_date,spell,sum(prod) prod from (
        			select spe.spreader_no, spe.spell,(spe.no_of_rolls) prod,
        			case when spell='C' and entry_time<=6 then date_add(entry_date,interval -1 day)
        			else entry_date end entry_date
        			from EMPMILL12.spreader_prod_entry spe
					) g where entry_date ='$date'
					group by  spreader_no,spell,entry_date ) spd
					left join (		
										select attendace_date,spell,mc_id,GROUP_CONCAT(DISTINCT eb_id SEPARATOR '/') ebnos  from (
										select dea.attendace_date,dea.spell,mc_id,dea.eb_id from  daily_ebmc_attendance dea ,daily_attendance da 
					where  dea.is_active=1  
					and da.daily_atten_id =dea.daily_atten_id and da.is_active =1 and dea.attendace_date ='$date'
										) g group by mc_id	,attendace_date,spell
										) da on da.mc_id=spd.spreader_no and da.attendace_date =spd.entry_date and da.spell =spd.spell 
					left join mechine_master mm on spd.spreader_no=mm.mechine_id 
		) g
					order by mech_code ,spell
					) k					
";

        if ($this->db->query($sql)) {
            $affected_rows = $this->db->affected_rows();
            return array('success' => true, 'message' => 'Imported ' . $affected_rows . ' records from spreader data');
        } else {
            return array('success' => false, 'message' => 'Error importing data: ' . $this->db->error()['message']);
        }
    }
}
?>
