<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WorkerGatePass_model extends CI_Model
{
    /**
     * Insert MySQL
     * UI sends date: dd-Mon-YYYY (e.g. 10-Jan-2026)
     * MySQL: STR_TO_DATE(?, '%d-%b-%Y')
     */
public function insert_gate_pass(array $d): bool
{
    $userid = (int)$this->session->userdata('user_id');

    $sql = "
        INSERT INTO EMPMILL12.WORKERGATEPASSTBL
        (gate_pass_date, absent_from, absent_to, no_of_days,
         reasons, pass_given_by, user_id, shift, eb_id)
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";

    $params = [
        $d['issue_date'],   // must be Y-m-d if DATE field
        $d['date_ofwork1'], // Y-m-d
        $d['date_ofwork2'], // Y-m-d
        $d['nodays'],
        $d['remarks'],
        $d['authority'],
        $userid,
        $d['spell'],
        $d['ebid'],
    ];

    return (bool)$this->db->query($sql, $params);
}

    public function delete_by_id(int $tran_id): bool
    {
        return (bool)$this->db->query(
            "DELETE FROM WORKERGATEPASSTBL WHERE TRAN_ID = ?",
            [$tran_id]
        );
    }

    public function get_gate_pass_by_id(int $tran_id): ?array
    {
        $sql = "
            SELECT
                A.TRAN_ID,
                A.EB_NO,
                B.WRK_NAME,
                DATE_FORMAT(A.GATE_PASS_DATE,'%d-%b-%Y') AS GATE_PASS_DATE,
                A.SHIFT,
                DATE_FORMAT(A.ABSENT_FROM,'%d-%b-%Y') AS ABSENT_FROM,
                DATE_FORMAT(A.ABSENT_TO,'%d-%b-%Y')   AS ABSENT_TO,
                A.NO_OF_DAYS,
                A.REASONS,
                A.PASS_GIVEN_BY
            FROM EMPMILL12.WORKERGATEPASSTBL A
            JOIN worker_master B ON A.EB_NO = B.EB_NO
            WHERE A.TRAN_ID = ?
        ";
        $q = $this->db->query($sql, [$tran_id]);
        $row = $q->row_array();
        return $row ?: NULL;
    }

    public function get_worker_info(string $ebno): ?array
    {
        $sql = "SELECT EB_NO, WRK_NAME FROM worker_master WHERE EB_NO = ?";
        $q = $this->db->query($sql, [$ebno]);
        $row = $q->row_array();
        return $row ?: NULL;
    }

    /**
     * DataTables legacy params:
     * iDisplayStart, iDisplayLength, sSearch, iSortCol_0, sSortDir_0, sEcho
     */
public function datatable_list(array $get): array
{
    $draw   = (int)($get['draw'] ?? 1);
    $start  = isset($get['start']) ? (int)$get['start'] : 0;
    $length = isset($get['length']) ? (int)$get['length'] : 10;

    // ORDER column index (with checkbox column at 0)
    $orderCol = (int)($get['order'][0]['column'] ?? 1);
    $orderDir = (($get['order'][0]['dir'] ?? 'desc') === 'asc') ? 'ASC' : 'DESC';

    $map = [
      1 => "A.tran_id",
      2 => "A.eb_id",
      3 => "B.wrk_name",
      4 => "A.gate_pass_date",
      5 => "A.shift",
      6 => "A.absent_from",
      7 => "A.absent_to",
      8 => "A.no_of_days",
      9 => "A.reasons",
      10 => "A.pass_given_by",
    ];
    $orderBy = ($map[$orderCol] ?? "A.tran_id") . " " . $orderDir;

    $where = "WHERE 1=1";
    $params = [];

    // Issue date filter (YYYY-MM-DD)
    $issue_date = trim($get['issue_date'] ?? '');
    		$issue_date=substr($issue_date,6,4).'-'.substr($issue_date,3,2).'-'.substr($issue_date,0,2);

    if ($issue_date !== '') {
        $where .= " AND A.gate_pass_date = ? ";
        $params[] = $issue_date;
    }

    // Search (DataTables 1.10 uses search[value])
    $search = trim($get['search']['value'] ?? '');
    if ($search !== '') {
        $where .= " AND (CAST(A.tran_id AS CHAR) LIKE ? OR CAST(A.eb_id AS CHAR) LIKE ? OR UPPER(B.wrk_name) LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%" . strtoupper($search) . "%";
    }

    $total = (int)$this->db->query("SELECT COUNT(*) CNT FROM EMPMILL12.WORKERGATEPASSTBL")->row()->CNT;

    $filteredSql = "
      SELECT COUNT(*) CNT
      FROM EMPMILL12.WORKERGATEPASSTBL A
      LEFT JOIN worker_master B ON A.eb_id = B.eb_id
      $where
    ";
    $filtered = (int)$this->db->query($filteredSql, $params)->row()->CNT;

    $dataSql = "
      SELECT
        A.tran_id, B.eb_no eb_id, CONCAT(B.worker_name, ' ', B.middle_name, ' ', B.last_name) AS wrk_name,
        DATE_FORMAT(A.gate_pass_date,'%d-%b-%Y') gate_pass_date,
        A.shift,
        DATE_FORMAT(A.absent_from,'%d-%b-%Y') absent_from,
        DATE_FORMAT(A.absent_to,'%d-%b-%Y') absent_to,
        A.no_of_days, A.reasons, A.pass_given_by
      FROM EMPMILL12.WORKERGATEPASSTBL A
      LEFT JOIN worker_master B ON A.eb_id = B.eb_id
      $where
      ORDER BY $orderBy
      LIMIT ? OFFSET ?
    ";
    $rows = $this->db->query($dataSql, array_merge($params, [$length, $start]))->result_array();

    $aaData = [];
    foreach ($rows as $r) {
        $aaData[] = [
            $r['tran_id'],
            $r['eb_id'],
            $r['wrk_name'],
            $r['gate_pass_date'],
            $r['shift'],
            $r['absent_from'],
            $r['absent_to'],
            $r['no_of_days'],
            $r['reasons'],
            $r['pass_given_by'],
        ];
    }

    return [
      "draw" => $draw,
      "recordsTotal" => $total,
      "recordsFiltered" => $filtered,
      "data" => $aaData
    ];
}

public function get_gate_pass_by_ids(array $ids): array
{
    if (empty($ids)) return [];

    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $sql = "
        SELECT
            A.tran_id,
            B.eb_no,
            CONCAT(B.worker_name, ' ', B.middle_name, ' ', B.last_name) AS WRK_NAME,
            DATE_FORMAT(A.gate_pass_date,'%d-%b-%Y') AS GATE_PASS_DATE,
            A.SHIFT,
            DATE_FORMAT(A.ABSENT_FROM,'%d-%b-%Y') AS ABSENT_FROM,
            DATE_FORMAT(A.ABSENT_TO,'%d-%b-%Y')   AS ABSENT_TO,
            round(A.NO_OF_DAYS,0) NO_OF_DAYS,
            A.REASONS,
            A.PASS_GIVEN_BY,dept_desc
        FROM EMPMILL12.WORKERGATEPASSTBL A
        JOIN worker_master B ON A.eb_id = B.eb_id
        left join department_master d on d.dept_id=B.dept_id
        WHERE A.tran_id IN ($placeholders)
        ORDER BY B.EB_NO
    ";

    return $this->db->query($sql, $ids)->result_array();
}




}
