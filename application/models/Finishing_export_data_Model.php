<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finishing_export_data_Model extends  CI_Model   {


    public function __construct() {
        parent::__construct();
   //     $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
   $this->load->database();
}
    public function getSpooldata() {
         
             $company_id = $this->session->userdata('company_id');
            $sql='select trollyid,trolly_details from trollymst where company_id='.$company_id.' and process_type=101 order by trolly_details';
            $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
            $result = $otherdb->query($sql)->result_array();
             return $result;
 
            }
            public function getwndmcnodata() {
         
                $company_id = $this->session->userdata('company_id');
               $sql='select mechine_id ,mechine_name from vowmechine_master where company_id='.$company_id.' and type_of_mechine=39 
               order by mach_shr_code';
               $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                   $results = $otherdb->query($sql)->result_array();
                return $results;
    
               }
       
    
            public function getQualitydata() {
         
                $company_id = $this->session->userdata('company_id');
                $sql='select wnd_quality_id,concat(WND_Q_CODE,"-",QUALITY) QUALITY from WINDING_QUALITY_MASTER where company_id='.$company_id.'  order by quality';
                $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                $resultq = $otherdb->query($sql)->result_array();
           //     var_dump($resultq);
                return $resultq;
        

            }
       

                public function getwndprvDoffData($companyId,$mcno1) {
        
//                    $company_id = $this->session->userdata('company_id');
                    $sql="SELECT g.mechine_id,g.mech_code,ifnull(k.wnd_mc_id,0) wnd_mc_id,ifnull(k.quality_id,0) quality_id,ifnull(spool_id,0) spool_id,
                    ifnull(k.trolly_id,0) trolly_id,ifnull(t.trolly_weight,0) spoolwt, ifnull(t2.trolly_weight,0) trollywt,ifnull(t2.trollyno,'') trollyno 
                    FROM
                    (
                         select mechine_id,mech_code from vowmechine_master vm where type_of_mechine=39 and company_id=".$companyId." 
                         and  mechine_id =".$mcno1." 
                    ) g left join 
                     (SELECT wnd_mc_id,quality_id, spool_id, trolly_id 
                     FROM WINDING_SPELL_EB_PROD_QLTY wsepq 
                     WHERE auto_id IN (SELECT MAX(auto_id) autoid 
                                       FROM WINDING_SPELL_EB_PROD_QLTY wsepqm,vowmechine_master vm2
                                       WHERE vm2.mechine_id = wsepqm.wnd_mc_id and wsepqm.company_id=".$companyId." 
                                       and vm2.mechine_id =".$mcno1." AND wsepqm.is_active = 1 )
                    ) k on g.mechine_id=k.wnd_mc_id
                    LEFT JOIN trollymst t ON t.trollyid = k.spool_id
                    LEFT JOIN trollymst t2 ON t2.trollyid = k.trolly_id";
    //    echo $sql;    
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $otherdb->query($sql)->result_array();
      //              var_dump($resultq);
                    return $resultq;
                    
                    
                }            
           
                public function getwndmc2Data($companyId,$mcno2) {
        
                    //                    $company_id = $this->session->userdata('company_id');
                      
                       
                      $sql="select mechine_id,mech_code from vowmechine_master vm where type_of_mechine=39 and company_id=".$companyId." 
                      and  mach_shr_code =".$mcno2 ;

                      
                       $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                                        $resultq = $otherdb->query($sql)->result_array();
                                   //     var_dump($resultq);
                                        return $resultq;
                                        
                                        
                                    }            
                               
                                            
                public function getwndtrollyData($companyId,$trollyNo) {
                    $sql="select trollyid,trolly_weight from trollymst tm where process_type=39 and company_id=".$companyId." 
                    and  trollyno =".$trollyNo ;
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $otherdb->query($sql)->result_array();
                    $otherdb->close();
                    return $resultq;
                }            
                                                   
                public function getwndspoolData($companyId,$spoolcode) {
                    $sql="select trollyid,trolly_weight from trollymst tm where process_type=101 and company_id=".$companyId." 
                    and  trollyno =".$spoolcode ;
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $otherdb->query($sql)->result_array();
                    $otherdb->close();
                    return $resultq;
                }            
                         
                public function getfinishalldata($date,  $compid) {
                    $sql = "select DATE_FORMAT(entry_date,'%d-%m-%Y') entrydate,fe.spell, fe.eb_no,concat(thepd.first_name ,ifnull(thepd.last_name,'')) name ,
                    ifnull(mm.mechine_name,'') mechine_name,ptm.process_code,ptm.process_type,(fe.production/25) production,fe.work_type , 
                    ifnull(dea.dtl_rec_id,0) dtl_rec_id,
                    (ifnull(da.working_hours,0)-ifnull(da.idle_hours,0)) whrs,noofmc,mm.mech_code,
                    case when fe.work_type =6 then 'Hemming' 
                    when fe.work_type =7 then 'Heracle'
                    when fe.work_type =25 then 'Hand Sewing'  end worktype
                    from finishing_entries fe 
                    left join process_type_master ptm on ptm.process_type_id =fe.work_type 
                    left join tbl_hrms_ed_official_details theod on theod.emp_code =fe.eb_no 
                    left join tbl_hrms_ed_personal_details thepd on theod.eb_id =thepd.eb_id 
                    left join (select * from daily_attendance da where is_active=1) da  
                    on fe.eb_no =da.eb_no and substr(fe.entry_date,1,10)=da.attendance_date and fe.spell =da.spell and da.company_id=fe.company_id
                    LEFT join (select * from daily_ebmc_attendance dea where is_active =1 and company_id=".$compid.") dea
                    on fe.eb_no =dea.eb_no and substr(fe.entry_date,1,10)=dea.attendace_date 
                    and fe.spell =dea.spell  and fe.company_id=dea.company_id
                    left join (select company_id,attendace_date,spell,eb_no,count(*) noofmc from daily_ebmc_attendance dea where is_active=1
                    and dea.attendace_date='".$date."'  group by company_id,attendace_date,spell,eb_no 
                    ) dedup on fe.eb_no =dedup.eb_no and substr(fe.entry_date,1,10)=dedup.attendace_date 
                    and fe.spell =dedup.spell and fe.company_id=dedup.company_id
                    left join mechine_master mm on dea.mc_id =mm.mechine_id 
                    where fe.is_active=1 and  fe.company_id=".$compid." and substr(entry_date,1,10) ='".$date."' and fe.work_type in (6,7,25)
                    order by entry_date ,fe.spell,fe.work_type,mechine_name
                    ";
                    $this->load->database();
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            
 
                public function getfinishchkdata($date,  $compid) {
                    $sql = "select
                    worked_designation_id worktype, desig process_type,
                    DATE_FORMAT(da.attendance_date , '%d-%m-%Y') entrydate ,
                    da.eb_no,
                    concat(thepd.first_name , ifnull(thepd.last_name, '')) name ,
                    ifnull(mm.mechine_name,'') mechine_name ,
                    fe.work_type,
                    da.daily_atten_id ,
                    d.desig ,
                    (da.working_hours -da.idle_hours ) whrs,
                    da.spell,
                    mm.mech_code,
                    fe.finishing_entry_id dtl_rec_id ,
                    ifnull(fe.production,0) production,1 noofmc
                from
                    daily_attendance da
                left join (
                    select
                        *
                    from
                        daily_ebmc_attendance dea
                    where
                        is_active = 1) dea on
                    da.daily_atten_id = dea.daily_atten_id
                left join tbl_hrms_ed_personal_details thepd on
                    da.eb_id = thepd.eb_id
                left join mechine_master mm on
                    dea.mc_id = mm.mechine_id
                left join designation d on
                    da.worked_designation_id = d.id
                left join (
                    select
                        *
                    from
                        finishing_entries fe
                    where
                        is_active = 1) fe on
                    da.attendance_date = substr(fe.entry_date, 1, 10)
                    and da.spell = fe.spell
                    and da.eb_no = fe.eb_no
                where
                    da.company_id =".$compid." 
                    and attendance_date ='".$date."'
                    and worked_designation_id in (105, 108, 239)
                    and da.is_active = 1
                order by
                    spell,
                    mm.mech_code
                                    ";
                    $this->load->database();
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            
                


                public function getfinishhlpdata($date,  $compid) {
                    $sql = "select worked_designation_id dsgid ,DATE_FORMAT(da.attendance_date , '%d-%m-%Y') attendance_date ,da.eb_no,
                    da.spell,mm.mech_code 
                    from daily_attendance da 
                    left join daily_ebmc_attendance dea on da.daily_atten_id =dea.daily_atten_id 
                    left join mechine_master mm on dea.mc_id =mm.mechine_id 
                    where attendance_date  ='".$date."' and worked_designation_id  in (106,109) 
                    and da.is_active =1 and da.company_id=".$compid." and dea.is_active=1
                    order by spell,mm.mech_code
                    ";
                    $this->load->database();
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            
 

}