<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pfesidata_Model extends  CI_Model   {

    public function getPfesidata()
    {
        // Assuming you have a table named 'categories' with 'id' and 'name' columns
        $company_id = $this->session->userdata('company_id');
 //       $query = $this->db->get('tbl_pay_scheme');
        $status=32;
        $this->db->where('BUSINESSUNIT_ID', $company_id);
        $this->db->where('STATUS', $status);
        $query = $this->db->get('tbl_pay_scheme');
        return $query->result();
       // return $query->result();
     //   $sql="select * from tbl_pay_scheme where BUSINESSUNIT_ID=".$company_id." order by NAME";
        //$result = $this->db->query($sql)->result_array();
        //return $result;


    }


}    