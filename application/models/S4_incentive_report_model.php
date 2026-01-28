<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class S4_incentive_report_model extends  CI_Model   {


    public function __construct() {
        parent::__construct();
        $this->load->database();

        $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
//        $this->load->database('vowsls', TRUE);  // Loads the default database (Doff entry database)
    }
    public function get_s4incentivedata($companyId,$windingperfrDate,$windingpertoDate,$loomtype) {
             $company_id = $this->session->userdata('company_id');


            $sql="select eb_no,emp_name," ;
            $sqlm='';
            $stdate=$windingperfrDate;
            $start = new DateTime($stdate);
            $end   = new DateTime($windingpertoDate);
            while ($start <= $end) {
                $d = (int)$start->format('d');  // 1, 2, 3...
                $dh=$d;
                if (strlen($d)==1) {
                    $dh="0".$d;
                } 
                $sqlm .= "MAX(CASE WHEN DAY(attendance_date) = $d THEN eff ELSE 0 END) AS `$dh`, ";

                $start->modify('+1 day');
            }

if ($loomtype=='41') { 
$sql=$sql.$sqlm." 
round(sum(QUANTITY)/sum(STDPROD)*100 ,0) avgeff,count(*) nodays,sum(incdays) incdays,sum(incrate) incrate from ( 
select eb_no,g.eb_id,attendance_date,CONCAT(thepd.first_name, ' ', thepd.middle_name, ' ', thepd.last_name) AS emp_name,eff,
ifnull(tid.rate+tid.rate_inc,0) incrate,QUANTITY,STDPROD,case when ifnull(tid.rate+tid.rate_inc,0)>0 then 1 else 0 end incdays  from (
SELECT da.attendance_date,da.eb_no,da.eb_id,round(sum(dld.QUANTITY)/sum(dld.STDPROD)*100 ,0) eff,sum(QUANTITY) QUANTITY,SUM(dld.STDPROD )
STDPROD
FROM daily_attendance da
left join daily_ebmc_attendance dea on da.daily_atten_id =dea.daily_atten_id and dea.is_active =1
left join mechine_master mm on dea.mc_id =mm.mechine_id 
left join EMPMILL12.DAILY_LOOM_DATA dld on dld.LOOM_NO =mm.mech_code and da.attendance_date =dld.TRAN_DATE 
and da.spell =dld.SPELL and da.eb_no=dld.EBNO  
where da.attendance_date between '$windingperfrDate' and '$windingpertoDate' and da.worked_designation_id =78 and da.company_id =2
group by da.attendance_date,da.eb_no,da.eb_id
) g left join
tbl_hrms_ed_personal_details thepd on g.eb_id=thepd.eb_id
left join EMPMILL12.tbl_incentive_data tid on g.eff =tid.eff_inc 
) k group by eb_no,emp_name
order by round(sum(QUANTITY)/sum(STDPROD)*100 ,0)
"; 
}  else {
$sql=$sql.$sqlm."
round(sum(QUANTITY)/sum(STDPROD)*100 ,0) avgeff,count(*) nodays,sum(incdays) incdays,sum(incrate) incrate from ( 
select eb_no,g.eb_id,attendance_date,CONCAT(thepd.first_name, ' ', thepd.middle_name, ' ', thepd.last_name) AS emp_name,eff,
ifnull(tid.rate+tid.rate_inc,0) incrate,QUANTITY,STDPROD,case when ifnull(tid.rate+tid.rate_inc,0)>0 then 1 else 0 end incdays  from (
SELECT da.attendance_date,da.eb_no,da.eb_id 
,round(sum(dld.QUANTITY)/sum(dld.STDPROD)*100 ,0) eff,sum(QUANTITY) QUANTITY,SUM(dld.STDPROD )
STDPROD
FROM daily_attendance da
left join daily_ebmc_attendance dea on da.daily_atten_id =dea.daily_atten_id and dea.is_active =1
left join EMPMILL12.tbl_loom_master_other_details tlmod on tlmod.helper_line_id =dea.mc_id 
left join mechine_master mm on tlmod.mechine_id=mm.mechine_id 
left join EMPMILL12.DAILY_LOOM_DATA dld on dld.LOOM_NO =mm.mech_code and da.attendance_date =dld.TRAN_DATE 
and da.spell =dld.SPELL  
where da.attendance_date between '$windingperfrDate' and '$windingpertoDate' and da.worked_designation_id =79 and da.company_id =2
group by da.attendance_date,da.eb_no,da.eb_id
) g left join
tbl_hrms_ed_personal_details thepd on g.eb_id=thepd.eb_id
left join EMPMILL12.tbl_incentive_data tid on g.eff =tid.eff_inc 
) k group by eb_no,emp_name
order by round(sum(QUANTITY)/sum(STDPROD)*100 ,0)";
}

//echo $sql;
          //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
            $result = $this->db->query($sql)->result_array();
            
             return $result;
 
            }
    
 
  
    
        

    
     


                  
                                                    
            
       
                                            
                                                    
        

         
}