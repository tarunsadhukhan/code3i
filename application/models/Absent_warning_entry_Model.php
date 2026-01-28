<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absent_warning_entry_Model extends  CI_Model   {
    public function get_records($date, $compid) {
         
        $company_id = $this->session->userdata('company_id');

       $sql="select thlad.long_absent_data_id,thlad.absent_data_tran_date , thlad.eb_id,emp_code,empname,prev_warning_no+1 warntobe,prev_warning_no,
       case when prev_warning_no =0 then 'Pre Warning' 
       when prev_warning_no=1 then '1st Warning'
       when prev_warning_no=2 then '2nd Warning'
       when prev_warning_no=3 then '3rd Warning'
       when prev_warning_no=4 then 'Show Cause' end 'warning_to_be',ifnull(thawd.absent_warning_date,' ') warning_date,ifnull(warning_remarks,' ') remarks
       from EMPMILL12.tbl_hrms_long_absent_data thlad  
       left join (select eb_id,emp_code from tbl_hrms_ed_official_details theod where theod.is_active=1 ) theod on theod.eb_id=thlad.eb_id 
       left join (select eb_id,concat(thepd.first_name, ' ', ifnull(thepd.middle_name, ''), ' ', thepd.last_name) empname 
       from tbl_hrms_ed_personal_details thepd where is_active=1) thepd on thepd.eb_id=thlad.eb_id
       left join (select * from EMPMILL12.tbl_hrms_absent_warning_data where is_active=1) thawd on thlad.long_absent_data_id=thawd.long_absent_data_id
       where absent_data_tran_date='$date' and prev_warning_no <=3 and absent_data_tran_type='L'
       and prev_warning_no =0
       ";
    
       $result = $this->db->query($sql)->result_array();
        return $result;

       }
}    