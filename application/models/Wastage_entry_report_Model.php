<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wastage_entry_report_Model extends  CI_Model   {


    public function __construct() {
        parent::__construct();
        $this->load->database();

        $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
//        $this->load->database('vowsls', TRUE);  // Loads the default database (Doff entry database)
    }


    public function getSpooldata() {
         
       $company_id = $this->session->userdata('company_id');
       $sql='select trollyid,trolly_details from EMPMILL12.trollymst where company_id='.$company_id.' and process_type=101 order by trolly_details';
    //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
       $result = $this->db->query($sql)->result_array();
        return $result;

       }



    
}    