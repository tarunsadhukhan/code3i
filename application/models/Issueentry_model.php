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

    /**
     * Calculate and update weight for issue records
     * Formula: weight = ((opening_weight + received_weight) / (opening_qty + received_qty)) * issued_qty
     * Grouped by quality, pack code, and godown
     */
    public function calculate_and_update_weight($issue_date) {
        try {
            // Get all unique combinations of quality, packcode, and godown for the date
            
            $sql="select issue_id,i.jcode_id,i.godown_id,i.packcode,i.bales issbales,i.weight issweight,
                ifnull(opbales,0) opbales,ifnull(opweight,0) opweight,ifnull(rcvbales,0) rcvbales,ifnull(rcvweight,0) rcvweight,
                case when (ifnull(opbales,0)+ifnull(rcvbales,0))>0 and (ifnull(opweight,0)+ifnull(rcvweight,0))>0 
                then round((ifnull(opweight,0)+ifnull(rcvweight,0))/(ifnull(opbales,0)+ifnull(rcvbales,0))*bales,0)
                else 0 end calcisswt
                from EMPMILL12.issufile i 
                left join 
                (
                select jcode_id,godown_id,packcode,sum(opbales) opbales,sum(opweight) opweight,sum(rcvbales) rcvbales,sum(rcvweight) rcvweight from (
                select jcode_id,rp.godown_id,packcode,recpbales opbales,netweight as opweight,0 rcvbales,0 rcvweight  from EMPMILL12.recpfile rp
                left join EMPMILL12.recpheader rph on rp.recpmast_id  =rph.recpmast_id 
                where rph.inwarddate <'$issue_date'
                union all
                select jcode_id,i.godown_id,packcode,0-bales opbales,0-i.weight opweight,0 rcvbales,0 rcvweight  from EMPMILL12.issufile i 
                where i.issuedate <'$issue_date'
                union all
                select jcode_id,godwn_id,packcode,bales opbales,weight opweight,0 rcvbales,0 rcvweight from EMPMILL12.stock_adjst sa 
                where sa.tran_date <'$issue_date'
                union all
                select ja.jcode_id_to jcode_id,ja.gcode_id_to godown_id,packcode, bales opbales,ja.weight opweight,0 rcvbales,0 rcvweight  from EMPMILL12.jute_adjust ja 
                where ja.tran_date <'$issue_date'
                union all
                select ja.jcode_id_from jcode_id,ja.gcode_id_frm godown_id,packcode,0- bales opbales,0-ja.weight opweight,0 rcvbales,0 rcvweight from EMPMILL12.jute_adjust ja 
                where ja.tran_date <'$issue_date'
                union all 
                select jcode_id,rp.godown_id,packcode,0 opbales ,0 opweight, recpbales rcvbales,netweight as rcvweight  from EMPMILL12.recpfile rp
                left join EMPMILL12.recpheader rph on rp.recpmast_id  =rph.recpmast_id 
                where rph.inwarddate ='$issue_date'
                union all
                select jcode_id,godwn_id godown_id,packcode,0 opbales ,0 opweight,bales rcvbales,weight rcvweight from EMPMILL12.stock_adjst sa 
                where sa.tran_date ='$issue_date'
                union all
                select ja.jcode_id_to jcode_id,ja.gcode_id_to godown_id,packcode,0 opbales ,0 opweight, bales rcvbales,ja.weight rcvweight from EMPMILL12.jute_adjust ja 
                where ja.tran_date ='$issue_date'
                union all
                select ja.jcode_id_from jcode_id,ja.gcode_id_frm godown_id,packcode,0 opbales ,0 opweight,0- bales rcvbales,0-ja.weight rcvweight from EMPMILL12.jute_adjust ja 
                where ja.tran_date ='$issue_date'
                ) g group by jcode_id,godown_id,packcode
                ) k on k.jcode_id=i.jcode_id and k.godown_id =i.godown_id and k.packcode =i.packcode
                where i.issuedate ='$issue_date'
            ";
            $data=$this->db->query($sql);
            $row=$data->result_array();
            // Update each record with calculated weight
            foreach ($row as $record) {
                $this->db->where('issue_id', $record['issue_id']);
                $this->db->update('EMPMILL12.issufile', ['weight' => $record['calcisswt']]);
            }

            $rowcount=count($row);
            $updated_count = $rowcount;
            return [
                'success' => true, 
                'message' => 'Weight updated successfully for ' . $updated_count . ' record(s)',
                'updated_count' => $updated_count
            ];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    /**
     * Get opening balance for a quality, packcode, and godown
     * This gets the balance from the previous period
     */
    private function get_opening_balance($jcode_id, $packcode, $godown_id, $issue_date) {
        $sql = "SELECT 
                    SUM(bales) as qty, 
                    SUM(weight) as weight
                FROM EMPMILL12.issufile
                WHERE jcode_id = ? 
                AND packcode = ? 
                AND godown_id = ? 
                AND issuedate < ?
                AND fyyear = (SELECT fyyear FROM EMPMILL12.issufile WHERE issuedate = ? LIMIT 1)";
        
        $query = $this->db->query($sql, [$jcode_id, $packcode, $godown_id, $issue_date, $issue_date]);
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return ['qty' => 0, 'weight' => 0];
    }

    /**
     * Get received data (from reception/receiving records) for a quality, packcode, and godown
     */
    private function get_received_data($jcode_id, $packcode, $godown_id, $issue_date) {
        // Query reception table for received quantities and weights
        $sql = "SELECT 
                    SUM(bales) as qty, 
                    SUM(weight) as weight
                FROM EMPMILL12.recpfile
                WHERE jcode_id = ? 
                AND packcode = ? 
                AND godown_id = ? 
                AND recepdate <= ?
                AND fyyear = (SELECT fyyear FROM EMPMILL12.issufile WHERE issuedate = ? LIMIT 1)";
        
        $query = $this->db->query($sql, [$jcode_id, $packcode, $godown_id, $issue_date, $issue_date]);
        
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result;
        }
        return ['qty' => 0, 'weight' => 0];
    }

    /**
     * Get report data for date range
     * Returns opening balance, received, adjustments, and closing balance per quality/godown
     */
    public function get_report_data($from_date, $to_date) {
        $sql = "SELECT 
    stk.*,
    wd.name,
    jm.quality,
    jm.jcode,pm.packing
FROM (
    SELECT 
        jcode_id,
        godown_id,
        packcode,
        SUM(opbales)     AS opbales,
        SUM(opweight)   AS opweight,
        SUM(rcvbales)   AS rcvbales,
        SUM(rcvweight)  AS rcvweight,
        SUM(issbales)   AS issbales,
        SUM(issweight)  AS issweight,
        SUM(adjbales)   AS adjbales,
        SUM(adjweight)  AS adjweight
    FROM (
        SELECT 
            jcode_id,
            rp.godown_id,
            packcode,
            recpbales               AS opbales,
            netweight               AS opweight,
            0 AS rcvbales, 0 AS rcvweight,
            0 AS issbales, 0 AS issweight,
            0 AS adjbales, 0 AS adjweight
        FROM EMPMILL12.recpfile rp
        LEFT JOIN EMPMILL12.recpheader rph 
            ON rp.recpmast_id = rph.recpmast_id
        WHERE rph.inwarddate < '$from_date'
        UNION ALL
        SELECT 
            jcode_id,
            i.godown_id,
            packcode,
            -bales,
            -i.weight,
            0, 0, 0, 0, 0, 0
        FROM EMPMILL12.issufile i
        WHERE i.issuedate < '$from_date'
        UNION ALL
        SELECT 
            jcode_id,
            godwn_id,
            packcode,
            bales,
            weight,
            0, 0, 0, 0, 0, 0
        FROM EMPMILL12.stock_adjst sa
        WHERE sa.tran_date < '$from_date'
        UNION ALL
        SELECT 
            ja.jcode_id_to,
            ja.gcode_id_to,
            packcode,
            bales,
            ja.weight,
            0, 0, 0, 0, 0, 0
        FROM EMPMILL12.jute_adjust ja
        WHERE ja.tran_date < '$from_date'
        UNION ALL
        SELECT 
            ja.jcode_id_from,
            ja.gcode_id_frm,
            packcode,
            -bales,
            -ja.weight,
            0, 0, 0, 0, 0, 0
        FROM EMPMILL12.jute_adjust ja
        WHERE ja.tran_date < '$from_date'
        UNION ALL
        SELECT 
            jcode_id,
            rp.godown_id,
            packcode,
            0, 0,
            recpbales,
            netweight,
            0, 0, 0, 0
        FROM EMPMILL12.recpfile rp
        LEFT JOIN EMPMILL12.recpheader rph 
            ON rp.recpmast_id = rph.recpmast_id
        WHERE rph.inwarddate = '$to_date'
        UNION ALL
        SELECT 
            jcode_id,
            godwn_id,
            packcode,
            0, 0, 0, 0, 0, 0,
            bales,
            weight
        FROM EMPMILL12.stock_adjst sa
        WHERE sa.tran_date = '$to_date'
        UNION ALL
        SELECT 
            ja.jcode_id_to,
            ja.gcode_id_to,
            packcode,
            0, 0, 0, 0, 0, 0,
            bales,
            weight
        FROM EMPMILL12.jute_adjust ja
        WHERE ja.tran_date = '$to_date'
        UNION ALL
        SELECT 
            ja.jcode_id_from,
            ja.gcode_id_frm,
            packcode,
            0, 0, 0, 0, 0, 0,
            -bales,
            -weight
        FROM EMPMILL12.jute_adjust ja
        WHERE ja.tran_date = '$to_date'
        UNION ALL
        SELECT 
            jcode_id,
            i.godown_id,
            packcode,
            0, 0, 0, 0,
            bales,
            weight,
            0, 0
        FROM EMPMILL12.issufile i
        WHERE i.issuedate = '$to_date'
    ) g
    GROUP BY jcode_id, godown_id, packcode
) stk
LEFT JOIN vowsls.warehouse_details wd 
    ON stk.godown_id = wd.id
LEFT JOIN EMPMILL12.jutemaster jm 
    ON stk.jcode_id = jm.jcode_id
    left JOIN EMPMILL12.pack_master pm 
    ON stk.packcode = pm.packcode
 order by wd.name, jm.quality   
    ;";
        
        $query = $this->db->query($sql, [
            $from_date, $from_date,  // opening balance dates
            $from_date, $to_date,    // receive dates
            $from_date, $to_date,    // receive dates again
            $from_date, $to_date,    // adjustment dates
            $from_date, $to_date,    // adjustment dates again
            $to_date, $to_date, $to_date,  // closing balance - opening receipt issue
            $to_date, $to_date, $to_date,  // closing balance weight
            $from_date, $to_date            // main query dates
        ]);
        
        return $query->result_array();
    }
}
