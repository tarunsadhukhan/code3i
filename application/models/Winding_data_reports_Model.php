<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Winding_data_reports_Model extends  CI_Model   {


    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
    }
    public function getSpooldata() {
         
            $company_id = $this->session->userdata('company_id');
            $sql='select trollyid,trolly_details from EMPMILL12.trollymst where company_id='.$company_id.' and process_type=101 order by trolly_details';
            $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
            $result = $this->db->query($sql)->result_array();
            $otherdb->close();
             return $result;
 
            }
            public function getwndmcnodata() {
         
                $company_id = $this->session->userdata('company_id');
               $sql='select mechine_id ,mechine_name from vowsls.mechine_master where company_id='.$company_id.' and type_of_mechine=39 
               order by mach_shr_code';
               $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                   $results = $this->db->query($sql)->result_array();
                return $results;
    
               }
       
    
            public function getQualitydata() {
         
                $company_id = $this->session->userdata('company_id');
                $sql='select wnd_quality_id,concat(WND_Q_CODE,"-",QUALITY) QUALITY from EMPMILL12.WINDING_QUALITY_MASTER 
                where company_id='.$company_id.'  order by quality';
                $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                $resultq = $this->db->query($sql)->result_array();
                $otherdb->close();
           //     var_dump($resultq);
                return $resultq;
        

            }
       

                public function getwndprvDoffData($companyId,$mcno1) {
        
//                    $company_id = $this->session->userdata('company_id');
                    $sql="SELECT g.mechine_id,g.mech_code,ifnull(k.wnd_mc_id,0) wnd_mc_id,ifnull(k.quality_id,0) quality_id,ifnull(spool_id,0) spool_id,
                    ifnull(k.trolly_id,0) trolly_id,ifnull(t.trolly_weight,0) spoolwt, ifnull(t2.trolly_weight,0) trollywt,ifnull(t2.trollyno,'') trollyno 
                    FROM
                    (
                         select mechine_id,mech_code from vowsls.mechine_master vm where type_of_mechine=39 and company_id=".$companyId." 
                         and  mechine_id =".$mcno1." 
                    ) g left join 
                     (SELECT wnd_mc_id,quality_id, spool_id, trolly_id 
                     FROM EMPMILL12.WINDING_SPELL_EB_PROD_QLTY wsepq 
                     WHERE auto_id IN (SELECT MAX(auto_id) autoid 
                                       FROM EMPMILL12.WINDING_SPELL_EB_PROD_QLTY wsepqm,vowsls.mechine_master vm2
                                       WHERE vm2.mechine_id = wsepqm.wnd_mc_id and wsepqm.company_id=".$companyId." 
                                       and vm2.mechine_id =".$mcno1." AND wsepqm.is_active = 1 )
                    ) k on g.mechine_id=k.wnd_mc_id
                    LEFT JOIN EMPMILL12.trollymst t ON t.trollyid = k.spool_id
                    LEFT JOIN EMPMILL12.trollymst t2 ON t2.trollyid = k.trolly_id";
    //    echo $sql;    
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    $otherdb->close();
      //              var_dump($resultq);
                    return $resultq;
                    
                    
                }            

                public function getjugarData($companyId,$mcno1,$jugarshiftName,$windingjugarDate,$openclose) {
        
                $sql="select wje.AUTO_ID,wje.WND_MC_ID ,wje.WEIGHT,wje.SPELL ,OPEN_CLOSE  from EMPMILL12.WINDING_JUGAR_ENTRY 
                wje 
                where TRAN_DATE ='".$windingjugarDate."' and WND_MC_ID =".$mcno1." and SPELL='".$jugarshiftName."' 
                and OPEN_CLOSE ='".$openclose."' and company_id=".$companyId
                ;
                $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                $resultq = $this->db->query($sql)->result_array();
                $otherdb->close();
                return $resultq;
                                        
                                        
                 }            
                               
                 public function get_wndqcrecords($date, $shift, $compid) {
        echo $date;
/*
        $query = $this->db->query("
                    SELECT
                        emp.WINDING_SPELL_EB_PROD_QLTY.*,
                        vow.worker_master.worker_name
                    FROM
                        empmill12.WINDING_SPELL_EB_PROD_QLTY AS emp
                    JOIN
                        vowsls.worker_master AS vow
                    ON
                        emp.eb_id = vow.eb_id;
                ");
                
                if ($query) {
                    return $query->result(); // Return combined data
                } else {
                    return FALSE; // Query failed
                }
        
                                             
 */                                           
                     }            
                                        


                public function getwndqcData($companyId,$doffdate,$doffshift) {

                //    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
//                   $query1=$this->$otherdb->query($sql);
                    $windingjugarDate=$doffdate;
                    $jugarshiftName=$doffshift;

                    $sql="select *  from EMPMILL12.WINDING_DAILY_SPELL_EB wje 
                    where TRAN_DATE ='".$windingjugarDate."' and spell='".$doffshift."'  and company_id=".$companyId."
                    and is_active=1";
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                
                    $resultq = $this->db->query($sql)->result_array();;
                    $cnt=count($resultq);
                  //  echo $cnt; 
                  if ($cnt>0) {
                    return "Already Quality Updated";
                  }  
                  if ($cnt==0) {
                        $sql="select max(tran_date) mxdate from  EMPMILL12.WINDING_DAILY_SPELL_EB sytd 
                        where company_id =".$companyId." and tran_date<='".$doffdate."' and is_active=1"; 
 //                       $query = $otherdb->query($sql, array($companyId,$doffdate ));
 //                       $records = $query->result();
//                         echo $sql;
                        $query = $this->db->query($sql);
                        $row1 = $query->row();
                        $mxdate = $row1->mxdate;
           //             echo 'max date: ' . $mxdate;

                        $sql="select max(spellno) mxspellno from (
                           select sytd.*,case 
                            when spell='A1' then 1 
                            when spell='B1' then 2 
                            when spell='A2' then 3 
                            when spell='B2' then 4 
                            when spell='C' then 5 END spellno 
                            from EMPMILL12.WINDING_DAILY_SPELL_EB sytd 
                            where  is_active=1 and company_id =? and tran_date=?
                            ) g ";
                            $created_by=26586;
                            $active=1;
                            $query = $this->db->query($sql, array($companyId,$mxdate ));
                            $records = $query->result();
                            $row1 = $query->row();
                            $mxspell=$row1->mxspellno;
/*
                            $sql="insert into WINDING_DAILY_SPELL_EB (company_id,created_by,tran_date,is_active,spell,wnd_mc_id,quality_id,no_of_spindle )  
                            select ".$companyId.",".$created_by.",'".$doffdate."',".$active.",'".$doffshift."',wnd_mc_id,quality_id,no_of_spindle from 
                            WINDING_DAILY_SPELL_EB   where company_id =".$companyId." and tran_date='".$mxdate."'  
                            and is_active=1 ";
                            $s = $mxspell;
                            switch ($s) {
                                case 1:
                                    $sql=$sql." and spell='A1'";
                                    break;
                                    case 2:
                                        $sql=$sql." and spell='B1'";
                                        break;
                                        case 3:
                                            $sql=$sql." and spell='A2'";
                                            break;
                                            case 4:
                                                $sql=$sql." and spell='B2'";
                                                break;
                                                case 5:
                                                    $sql=$sql." and spell='C'";
                                                    break;
                             }
 */
                            $sql="insert into EMPMILL12.WINDING_DAILY_SPELL_EB (company_id,created_by,tran_date,is_active,spell,wnd_mc_id,
                             quality_id,no_of_spindle ) 
                             select ".$companyId.",".$created_by.",'".$doffdate."',".$active.",'".$doffshift."', mechine_id,ifnull(quality_id,0) qc,
                             ifnull(no_of_spindle,0) spnd from 
                             (
                             select vm.mechine_id,vm.mechine_name  from vowsls.mechine_master vm where vm.type_of_mechine =39 and company_id=2
                             ) i left join (select wnd_mc_id,quality_id,no_of_spindle 
                             from EMPMILL12.WINDING_DAILY_SPELL_EB 
                             where company_id =".$companyId." and tran_date='".$mxdate."'  and is_active=1 ";
                             
                             $s = $mxspell;
                             switch ($s) {
                                 case 1:
                                     $sql=$sql." and spell='A1'";
                                     break;
                                     case 2:
                                         $sql=$sql." and spell='B1'";
                                         break;
                                         case 3:
                                             $sql=$sql." and spell='A2'";
                                             break;
                                             case 4:
                                                 $sql=$sql." and spell='B2'";
                                                 break;
                                                 case 5:
                                                     $sql=$sql." and spell='C'";
                                                     break;
                              }
                             $sql=$sql.") g on i.mechine_id=g.wnd_mc_id";
                             

//echo $sql;
                            $this->db->query($sql);
                            return "Quality  Inserted";  
                            $otherdb->close();

                    }    
                                         
                                        
                                    }            

                                    public function getwndmc2Data($companyId,$mcno2) {
        
                                        //                    $company_id = $this->session->userdata('company_id');
                                          
                                           
                                          $sql="select mechine_id,mech_code from vowsls.mechine_master vm where type_of_mechine=39 and company_id=".$companyId." 
                                          and  mach_shr_code =".$mcno2 ;
                    
                                          
                                           $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                                                            $resultq = $this->db->query($sql)->result_array();
                                                       //     var_dump($resultq);
                                                            return $resultq;
                                                            
                                                            
                                                        }            
                                                        

                                            
                public function getwndtrollyData($companyId,$trollyNo) {
                    $sql="select trollyid,trolly_weight from EMPMILL12.trollymst tm where process_type=39 and company_id=".$companyId." 
                    and  trollyno =".$trollyNo ;
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    $otherdb->close();
                    return $resultq;
                }            
                                                   
                public function getwndspoolData($companyId,$spoolcode) {
                    $sql="select trollyid,trolly_weight from EMPMILL12.trollymst tm where process_type=101 and company_id=".$companyId." 
                    and  trollyno =".$spoolcode ;
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    $otherdb->close();
                    return $resultq;
                }            
                         
                public function getwndDoffdata($date, $shift, $compid,$mcno) {
                    $sql=" select auto_id,DATE_FORMAT(rec_date,'%d-%m-%Y') doffdate,spell,vm.mechine_name,
                    gross_wt,t.trollyno ,wsepq.trolly_wt ,t2.trollyno spool_type ,spool_wt ,wsepq.production , wsepq.entry_date 
                    from  EMPMILL12.WINDING_SPELL_EB_PROD_QLTY wsepq
                    left join vowsls.mechine_master vm on wsepq.wnd_mc_id =vm.mechine_id
                    left join EMPMILL12.trollymst t on t.trollyid =wsepq.trolly_id 
                    left join EMPMILL12.trollymst t2 on t2.trollyid =wsepq.spool_id 
                    where rec_date='".$date."' and spell='".$shift."' and wsepq.company_id=".$compid." and wsepq.is_active =1 ";
                    if ($mcno>0) {
                        $sql=$sql." and wnd_mc_id=".$mcno ;
                    }
                    $sql=$sql." order by auto_id";
                    
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    $otherdb->close();
                    return $resultq;
                    
                }            

                public function getwndqcrecorddata($date, $shift, $compid) {
                    $sql=" select wdse.auto_id,DATE_FORMAT(tran_date,'%d-%m-%Y') tran_date,spell,wnd_mc_id,vm.mechine_name,
                    ifnull(wdse.quality_id,0) quality_id ,ifnull(wqm.QUALITY,'') quality,no_of_spindle  from EMPMILL12.WINDING_DAILY_SPELL_EB wdse 
                    left join vowsls.mechine_master vm on wdse.wnd_mc_id =vm.mechine_id 
                    left join EMPMILL12.WINDING_QUALITY_MASTER wqm on wdse.quality_id =wqm.wnd_quality_id 
                    where  wdse.is_active=1 and wdse.company_id =".$compid." and tran_date='".$date."' and spell='".$shift."'
                    ";
                    
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    $otherdb->close();
                    return $resultq;
                    
                }            
 


                public function getjugDoffdata($date, $shift, $compid,$openclose) {
                    $sql=" select wje.AUTO_ID,DATE_FORMAT(TRAN_DATE,'%d-%m-%Y') doffdate,wje.SPELL ,OPEN_CLOSE, 
                    wje.WND_MC_ID,wje.WEIGHT ,vm.mechine_name  
                    from EMPMILL12.WINDING_JUGAR_ENTRY wje 
                    left join vowsls.mechine_master vm on wje.WND_MC_ID =vm.mechine_id 
                    where TRAN_DATE ='".$date."'  and SPELL='".$shift."' and OPEN_CLOSE ='".$openclose."'
                    and wje.company_id=".$compid." and wje.is_active =1
                     ";
                     $sql=$sql." order by auto_id";
                    
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    $otherdb->close();
                    return $resultq;
                    
                }            
 
                public function getwndmcdataexl($date, $compid,$shift)
                {
                $sql="select a.*,DATE_FORMAT(TRAN_DATE,'%d-%m-%Y') doffdate from EMPMILL12.allwindingdata a where  tran_date ='".$date."' 
                and shift='".$shift."' and company_id=".$compid." and wnd_mc_id>0
                order by mech_code,spell,prdrem
                ";
                
                        
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    $otherdb->close();
                    return $resultq;
         
         
                }

                public function getspginputexl($date, $compid)
                {
                $sql="select a.*,DATE_FORMAT(TRAN_DATE,'%d-%m-%Y') doffdate from EMPMILL12.allwindingdata a where  tran_date ='".$date."' 
                and shift='".$shift."' and company_id=".$compid." and wnd_mc_id>0
                order by mech_code,spell,prdrem
                ";
                echo $sql;
              // print_r ($sql);
                
                        
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    $otherdb->close();
//                    var_dump ($resultq);
                    return $resultq;
         
         
                }



}