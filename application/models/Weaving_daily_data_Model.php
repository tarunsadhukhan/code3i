<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weaving_daily_data_Model extends  CI_Model   {


    public function __construct() {
        parent::__construct();
        $this->load->database();

        $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
//        $this->load->database('vowsls', TRUE);  // Loads the default database (Doff entry database)
    }


        public function getlmmcdata() {
         
             $company_id = $this->session->userdata('company_id');
            $sql='select mechine_id,mech_code,mach_shr_code from mechine_master where company_id='.$company_id.' and type_of_mechine=7 order by mech_code';
         //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
            $result = $this->db->query($sql)->result_array();
            
          //  var_dump($result);
             return $result;
 
            }


public function getmccode($companyId, $mcshrcd)
{
    $sql = "SELECT mechine_id, mech_code, mach_shr_code
            FROM mechine_master
            WHERE company_id = ? AND mach_shr_code = ?
            ORDER BY mech_code ASC";

    $row = $this->db->query($sql, [$companyId, $mcshrcd])->row_array();
    return $row;
}






    
}    