<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_loom_report_model extends  CI_Model   {


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
    public function getdailyloomdata($companyId,$windingperfrDate,$windingpertoDate,$loomtype) {
         
             $company_id = $this->session->userdata('company_id');
            $sql="select loom_type,LOOM_NO,QTYA,ifnull(EFFA,0) EFFA,WRKA,QTYB,ifnull(EFFB,0) EFFB,WRKB,QTYC,ifnull(EFFC,0) EFFC,WRKC,
            QTYO,ifnull(EFFO,0) EFFO,WRKO FROM (
SELECT LOOM_NO,case when $loomtype='41' then 'Hessian' else 'S4' end loom_type,SUM(QTYA) QTYA,SUM(WRKA) WRKA,
round(SUM(QTYA)/SUM(EFFA)*100,2) EFFA ,
SUM(QTYB) QTYB,SUM(WRKB) WRKB,round(SUM(QTYB)/sum(EFFB)*100,2) EFFB
,SUM(QTYC) QTYC,SUM(WRKC) WRKC, round(SUM(QTYC)/SUM(EFFC)*100,2) EFFC,round(SUM(QTYA+QTYB+QTYC)/SUM(EFFA+EFFB+EFFC)*100,2) EFFO,
SUM(QTYA+QTYB+QTYC) QTYO,
SUM(lm.WRKA +WRKB+WRKC) WRKO
FROM
(
SELECT LOOM_NO,QUANTITY QTYA,WRK_HOURS WRKA,STDPROD EFFA,0 QTYB,0 WRKB,0 EFFB,
0 QTYC,0 WRKC , 0 EFFC 
FROM EMPMILL12.DAILY_LOOM_DATA WHERE 
substr(loom_no,1,2)='$loomtype' AND SUBSTR(SPELL,1,1)='A' AND STDPROD>0
AND TRAN_DATE>=('$windingperfrDate')
and TRAN_DATE<=('$windingpertoDate')
UNION ALL
SELECT LOOM_NO,0 QTYA,0 WRKA,0 EFFA,QUANTITY QTYB,WRK_HOURS WRKB,STDPROD EFFB,
0 QTYC,0 WRKC , 0 EFFC 
FROM EMPMILL12.DAILY_LOOM_DATA WHERE 
substr(loom_no,1,2)='$loomtype' AND SUBSTR(SPELL,1,1)='B' AND STDPROD>0
AND TRAN_DATE>=('$windingperfrDate')
and TRAN_DATE<=('$windingpertoDate')
UNION ALL
SELECT LOOM_NO,0 QTYA,0 WRKA,0 EFFA,0 QTYB,0 WRKB,0 EFFB,
QUANTITY QTYC,WRK_HOURS WRKC , STDPROD EFFC 
FROM EMPMILL12.DAILY_LOOM_DATA WHERE 
substr(loom_no,1,2)='$loomtype' AND SUBSTR(SPELL,1,1)='C' AND STDPROD>0
AND TRAN_DATE>=('$windingperfrDate')
and TRAN_DATE<=('$windingpertoDate')
) lm 
GROUP BY LOOM_NO 
) g
order by EFFO
";
         //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
            $result = $this->db->query($sql)->result_array();
            
             return $result;
 
            }
    
            public function getwndmcnodata() {
         
                $company_id = $this->session->userdata('company_id');
               $sql='select mechine_id ,mechine_name from mechine_master where company_id='.$company_id.' and type_of_mechine=39 
               order by mach_shr_code';
          //     $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                   $results = $this->db->query($sql)->result_array();
                return $results;
    
               }

               public function getcompanydata() {
         
//                $company_id = $this->session->userdata('company_id');
               $sql='select comp_id mechine_id,company_name mechine_name from company_master
               order by company_name';
              // $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                   $results = $this->db->query($sql)->result_array();
                return $results;
    
               }

    
            public function getQualitydata() {
         
                $company_id = $this->session->userdata('company_id');
                $sql='select wnd_quality_id,concat(WND_Q_CODE,"-",QUALITY) QUALITY from EMPMILL12.WINDING_QUALITY_MASTER where company_id='.$company_id.'  order by quality';
          //      $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                $resultq = $this->db->query($sql)->result_array();
           //     var_dump($resultq);
                return $resultq;
        

            }
       

                public function getwndprvDoffData($companyId,$mcno1) {
        
//                    $company_id = $this->session->userdata('company_id');
                    $sql="SELECT g.mechine_id,g.mech_code,ifnull(k.wnd_mc_id,0) wnd_mc_id,ifnull(k.quality_id,0) quality_id,ifnull(spool_id,0) spool_id,
                    ifnull(k.trolly_id,0) trolly_id,ifnull(t.trolly_weight,0) spoolwt, ifnull(t2.trolly_weight,0) trollywt,ifnull(t2.trollyno,'') trollyno 
                    FROM
                    (
                         select mechine_id,mech_code from mechine_master vm where type_of_mechine=39 and company_id=".$companyId." 
                         and  mechine_id =".$mcno1." 
                    ) g left join 
                     (SELECT wnd_mc_id,quality_id, spool_id, trolly_id 
                     FROM EMPMILL12.WINDING_SPELL_EB_PROD_QLTY wsepq 
                     WHERE auto_id IN (SELECT MAX(auto_id) autoid 
                                       FROM EMPMILL12.WINDING_SPELL_EB_PROD_QLTY wsepqm,mechine_master vm2
                                       WHERE vm2.mechine_id = wsepqm.wnd_mc_id and wsepqm.company_id=".$companyId." 
                                       and vm2.mechine_id =".$mcno1." AND wsepqm.is_active = 1 )
                    ) k on g.mechine_id=k.wnd_mc_id
                    LEFT JOIN EMPMILL12.trollymst t ON t.trollyid = k.spool_id
                    LEFT JOIN EMPMILL12.trollymst t2 ON t2.trollyid = k.trolly_id";
    //    echo $sql;    
                 //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
      //              var_dump($resultq);
                    return $resultq;
                    
                    
                }            

                public function getwndprvjugarData($companyId,$mcno1,$shiftname,$windingDate,$openclose,$windingcDate,$shiftcname) {

                    if ($openclose=='O') {    
                        $sql="SELECT auto_id,wnd_mc_id,tran_date,spell,weight,'OE' rem from EMPMILL12.WINDING_JUGAR_ENTRY where 
                        wnd_mc_id=".$mcno1." and company_id=".$companyId." and spell='".$shiftcname."' and open_close='O' 
                        and is_active=1 and tran_date='".$windingcDate."'";
                   //     $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                        $resultq = $this->db->query($sql)->result_array();
                        $count=count($resultq);                                
                        if ($count==0) {
                            $sql="SELECT auto_id,wnd_mc_id,tran_date,spell,weight,'ON' rem from EMPMILL12.WINDING_JUGAR_ENTRY where
                            wnd_mc_id=".$mcno1." and company_id=".$companyId." and spell='".$shiftname."' and open_close='C' 
                            and is_active=1 and tran_date='".$windingDate."'";
                            
                            $sql="SELECT auto_id,wnd_mc_id,tran_date,spell,weight,'ON' rem from EMPMILL12.WINDING_JUGAR_ENTRY where auto_id = (
                                select auto_id from EMPMILL12.WINDING_JUGAR_ENTRY wje where wnd_mc_id=".$mcno1." and company_id=".$companyId."
                                and is_active=1 and open_close='C' and TRAN_DATE <'".$windingDate."' order by AUTO_ID desc limit 1
                                ) ";
                        }
                    }
                    if ($openclose=='C') {    
                        $sql="SELECT auto_id,wnd_mc_id,tran_date,spell,weight,'CE' rem from EMPMILL12.WINDING_JUGAR_ENTRY where 
                        wnd_mc_id=".$mcno1." and company_id=".$companyId." and spell='".$shiftcname."' and open_close='C' 
                        and is_active=1 and tran_date='".$windingcDate."'";
                   }
              //     echo $sql;

                 //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                }            
                    



                public function getjugarData($companyId,$mcno1,$jugarshiftName,$windingjugarDate,$openclose) {
        
                $sql="select wje.AUTO_ID,wje.WND_MC_ID ,wje.WEIGHT,wje.SPELL ,OPEN_CLOSE  from EMPMILL12.WINDING_JUGAR_ENTRY wje 
                where TRAN_DATE ='".$windingjugarDate."' and WND_MC_ID =".$mcno1." and SPELL='".$jugarshiftName."' 
                and OPEN_CLOSE ='".$openclose."' and company_id=".$companyId
                ;

             //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                $resultq = $this->db->query($sql)->result_array();
                return $resultq;
                                        
                                        
                 }            
                               
                 public function get_wnduprecords($date, $shift, $compid) {
              
                    $msg='';
              
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
                   $multiClause = array('company_id' => $compid );
                   $otherdb->where($multiClause);		
                   $query = $otherdb->delete('worker_master');
                   $multiClause = array('company_id' => $compid );
                   $this->db->where($multiClause);		
                   $query = $this->db->get('worker_master');
                   $records = $query->result_array();
                    if (!empty($records)) {
                        // Insert records into the target table using batch processing
                        $otherdb->insert_batch('worker_master', $records);
                        $otherdb->affected_rows();
                    } else {
  //                      return 0; // No records to transfer
                    }
                    $cmm=0;    
                    $otherdb->where('eb_id >=', $cmm);

         //           $otherdb->where($multiClause);		
                    $query = $otherdb->delete('tbl_hrms_ed_official_details');
                    
                    $otherdb->where('eb_id >=', $cmm);

           //         $otherdb->where($multiClause);		
                    $query = $otherdb->delete('tbl_hrms_ed_personal_details');
                 //   echo   $otherdb->last_query();

                    $multiClause = array('company_id' > $cmm);
             //       $this->db->where($multiClause);		
                    $query = $this->db->get('tbl_hrms_ed_personal_details');
                    $records = $query->result_array();
                     if (!empty($records)) {
                         // Insert records into the target table using batch processing
                         $otherdb->insert_batch('tbl_hrms_ed_personal_details', $records);
                         $otherdb->affected_rows();
                     } else {
   //                      return 0; // No records to transfer
                     }
 
                     $multiClause = array('company_id' > $cmm );
                  //   $this->db->where($multiClause);		
                     $query = $this->db->get('tbl_hrms_ed_official_details');
                     $records = $query->result_array();
                      if (!empty($records)) {
                          // Insert records into the target table using batch processing
                          $otherdb->insert_batch('tbl_hrms_ed_official_details', $records);
                          $otherdb->affected_rows();
                      } else {
    //                      return 0; // No records to transfer
                      }
  
 

                    /*
                    $multiClause = array('company_id' => $compid );
                    $otherdb->where($multiClause);		
                    $query = $otherdb->delete('master_department');
                    $multiClause = array('company_id' => $compid );
                    $this->db->where($multiClause);		
                    $query = $this->db->get('master_department');
                    $records = $query->result_array();
                     if (!empty($records)) {
                         // Insert records into the target table using batch processing
                         $otherdb->insert_batch('master_department', $records);
                         $otherdb->affected_rows();
                     } else {
   //                      return 0; // No records to transfer
                     }
                     $multiClause = array('company_id' => $compid );
                     $otherdb->where($multiClause);		
                     $query = $otherdb->delete('department_master');
                     $multiClause = array('company_id' => $compid );
                     $this->db->where($multiClause);		
                     $query = $this->db->get('department_master');
                     $records = $query->result_array();
                      if (!empty($records)) {
                          // Insert records into the target table using batch processing
                          $otherdb->insert_batch('department_master', $records);
                          $otherdb->affected_rows();
                      } else {
    //                      return 0; // No records to transfer
                      }
                      $multiClause = array('company_id' => $compid );
                      $otherdb->where($multiClause);		
                      $query = $otherdb->delete('designation');
                      $multiClause = array('company_id' => $compid );
                      $this->db->where($multiClause);		
                      $query = $this->db->get('designation');
                      $records = $query->result_array();
                       if (!empty($records)) {
                           // Insert records into the target table using batch processing
                           $otherdb->insert_batch('designation', $records);
                           $otherdb->affected_rows();
                       } else {
     //                      return 0; // No records to transfer
                       }
   
 */                   

                     $multiClause = array('attendace_date' => $date, 'spell' => $shift,'company_id' => $compid );
                    $otherdb->where($multiClause);		
                    $query = $otherdb->delete('daily_ebmc_attendance');
                 
                    $multiClause = array('attendance_date' => $date, 'spell' => $shift,'company_id' => $compid );
                    $otherdb->where($multiClause);		
                    $query = $otherdb->delete('daily_attendance');
              //      echo   $otherdb->last_query();
             
                    $actv=1;
                    $multiClause = array('attendance_date' => $date, 'spell' => $shift, 'is_active' =>$actv,'company_id' => $compid );

                    $this->db->where($multiClause);		
                    $query = $this->db->get('daily_attendance');
  
                    $records = $query->result_array();
                    if (!empty($records)) {
                        // Insert records into the target table using batch processing
                        $otherdb->insert_batch('daily_attendance', $records);
          //              return $otherdb->affected_rows(); // Return the number of inserted rows
                    } else {
        //                return 0; // No records to transfer
                    }
                
               
                    $multiClause = array('attendace_date' => $date, 'spell' => $shift, 'is_active' =>$actv,'company_id' => $compid );

//                    $this->db->where($multiClause);		
//                    $query = $this->db->get('daily_ebmc_attendance');
//                  echo   $otherdb->last_query();
                    
                    $this->db->where($multiClause);
                  //  $this->db->limit(480); // Add this line to limit the result to 10 rows
                    $query = $this->db->get('daily_ebmc_attendance');
                    $records = $query->result_array();
    //                echo   $this->db->last_query();
                    $cnt=count($records);    
    //                echo $cnt;
                 //   var_dump($records);

//                    $records = $query->result_array();
                    if (!empty($records)) {
                        // Insert records into the target table using batch processing
                   //     var_dump($records);
 
                   $otherdb->insert_batch('daily_ebmc_attendance', $records);
 
                        //     echo   $otherdb->last_query();
                        //        return $otherdb->affected_rows(); // Return the number of inserted rows
                    } else {
                //        return 0; // No records to transfer
                    }

                    $sql="UPDATE WINDING_SPELL_EB_PROD_QLTY
                    SET quality_id = (
                        SELECT wdse.quality_id
                        FROM WINDING_DAILY_SPELL_EB wdse
                        WHERE wdse.wnd_mc_id = WINDING_SPELL_EB_PROD_QLTY.wnd_mc_id
                          AND wdse.spell = WINDING_SPELL_EB_PROD_QLTY.spell
                          AND wdse.tran_date = WINDING_SPELL_EB_PROD_QLTY.rec_date
                          AND wdse.company_id = WINDING_SPELL_EB_PROD_QLTY.company_id
                          AND wdse.is_active = 1
                    )
                    WHERE rec_date = '".$date."'
                    AND SPELL='".$shift."'
                    AND is_active = 1
                    AND company_id =".$compid;
      //   echo $sql;       
                    $otherdb->query($sql);

        


                    $sql="select spell,wnd_mc_id,mech_code,count(*) cnt from 
                    ( 
                    select wsepq.*,dea.mc_id,dea.eb_no,vm.mech_code from ( 
                    select company_id,rec_date,spell,WND_MC_ID,wsepq.quality_id , sum(production) prod 
                    from WINDING_SPELL_EB_PROD_QLTY wsepq where rec_date='".$date."' and is_active =1 and 
                    company_id =".$compid." and spell='".$shift."' group by company_id,rec_date,spell,WND_MC_ID,
                    wsepq.quality_id ) wsepq 
                    left join (
                    select * from daily_ebmc_attendance dea 
                    where dea.attendace_date='".$date."' and is_active=1 and spell='".$shift."' and company_id=".$compid."
                    ) dea on 
                    wsepq.rec_date =dea.attendace_date and wsepq.spell =dea.spell and 
                    wsepq.wnd_mc_id =dea.mc_id and wsepq.company_id =dea.company_id 
                    left join 
                    vowmechine_master vm on vm.mechine_id =wsepq.wnd_mc_id
                    ) k 
                    group by spell,mech_code ,wnd_mc_id
                    having count(*)>1
                    ";
//echo $sql;
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                        $resultq = $otherdb->query($sql)->result_array();
          //              var_dump($resultq);
          //            
                        $cnt=count($resultq);



                   if ($cnt>0) {  
              //          echo $sql;       
                //        echo $cnt;        
                        $this->count = $cnt;
                         return $resultq;           
                            }        
                                $this->count = 0;

                                

               
                $sql="UPDATE WINDING_SPELL_EB_PROD_QLTY
                SET eb_id = (
                    SELECT dea.eb_id
                    FROM daily_ebmc_attendance dea
                    WHERE dea.mc_id = WINDING_SPELL_EB_PROD_QLTY.wnd_mc_id
                    AND dea.spell = WINDING_SPELL_EB_PROD_QLTY.spell
                    AND dea.attendace_date = WINDING_SPELL_EB_PROD_QLTY.rec_date
                    AND dea.company_id = WINDING_SPELL_EB_PROD_QLTY.company_id
                    AND dea.is_active = 1
                )
                WHERE rec_date = '".$date."'
                AND SPELL='".$shift."'
                AND is_active = 1
                AND company_id =".$compid;
                $otherdb->query($sql);
        //  
        $otherdb->close();  
                                           
                                                        
    }            
                                                    
            
    public function getCount() {
        // Return the count value stored in the model
        return $this->count;
    }



                public function getwndqcData($companyId,$doffdate,$doffshift) {

                //    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
//                   $query1=$this->$otherdb->query($sql);
                    $windingjugarDate=$doffdate;
                    $jugarshiftName=$doffshift;

                    $sql="select *  from EMPMILL12.WINDING_DAILY_SPELL_EB wje 
                    where TRAN_DATE ='".$windingjugarDate."' and spell='".$doffshift."'  and company_id=".$companyId."
                    and is_active=1";
                  //  $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                
                    $resultq = $this->db->query($sql)->result_array();;
                    $cnt=count($resultq);
                  //  echo $cnt; 
                  if ($cnt>0) {
                    return "Already Quality Updated";
                  }  
                  if ($cnt==0) {
                        $sql="select max(tran_date) mxdate from  EMPMILL12.WINDING_DAILY_SPELL_EB sytd 
                        where company_id =".$companyId." and tran_date<='".$doffdate."' and is_active=1"; 
                        $query = $this->db->query($sql);
                        $row1 = $query->row();
                        $mxdate = $row1->mxdate;
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
                             select vm.mechine_id,vm.mechine_name  from mechine_master vm where vm.type_of_mechine =39 and company_id=2
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
                                          
                                           
                                          $sql="select mechine_id,mech_code from mechine_master vm where type_of_mechine=39 and company_id=".$companyId." 
                                          and  mach_shr_code =".$mcno2 ;
                    
                                          
                                        //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                                                            $resultq = $this->db->query($sql)->result_array();
                                                       //     var_dump($resultq);
                                                            return $resultq;
                                                            
                                                            
                                                        }            
                                                        

                                            
                public function getwndtrollyData($companyId,$trollyNo) {
                    $sql="select trollyid,trolly_weight from EMPMILL12.trollymst tm where process_type=39 and company_id=".$companyId." 
                    and  trollyno =".$trollyNo ;
                //    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                }            
                                                   
                public function getwndspoolData($companyId,$spoolcode) {
                    $sql="select trollyid,trolly_weight from EMPMILL12.trollymst tm where process_type=101 and company_id=".$companyId." 
                    and  trollyno =".$spoolcode ;
                //    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    $otherdb->close();
                    return $resultq;
                }            
                         
                public function getwndDoffdata($date, $shift, $compid,$mcno) {
                    $sql="UPDATE EMPMILL12.WINDING_SPELL_EB_PROD_QLTY AS d1
                    JOIN (
                    SELECT d.company_id, d.rec_date, d.spell, d.entry_date, d.wnd_mc_id, d.is_active, MAX(d.auto_id) AS mxid, 
                    COUNT(*) AS cnt
                    FROM EMPMILL12.WINDING_SPELL_EB_PROD_QLTY  AS d
                    WHERE d.rec_date = '".$date."' and company_id=".$compid." and is_active=1 
                    GROUP BY d.company_id, d.REC_DATE, d.spell, d.entry_date, d.wnd_mc_id, d.is_active
                        HAVING COUNT(*) > 1
                    ) AS g ON d1.entry_date = g.entry_date AND d1.auto_id = g.mxid
                    SET d1.is_active = 0
                    WHERE d1.is_active = 1";
                //    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $this->db->query($sql);
             


                    $sql=" select auto_id,DATE_FORMAT(rec_date,'%d-%m-%Y') doffdate,spell,vm.mechine_name,
                    gross_wt,t.trollyno ,wsepq.trolly_wt ,t2.trollyno spool_type ,spool_wt ,wsepq.production , wsepq.entry_date 
                    from  EMPMILL12.WINDING_SPELL_EB_PROD_QLTY wsepq
                    left join mechine_master vm on wsepq.wnd_mc_id =vm.mechine_id
                    left join EMPMILL12.trollymst t on t.trollyid =wsepq.trolly_id 
                    left join EMPMILL12.trollymst t2 on t2.trollyid =wsepq.spool_id 
                    where rec_date='".$date."' and spell='".$shift."' and wsepq.company_id=".$compid." and wsepq.is_active =1 ";
                    if ($mcno>0) {
                        $sql=$sql." and wnd_mc_id=".$mcno ;
                    }
                    $sql=$sql." order by auto_id";
                //    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            

                public function getwndqcrecorddata($date, $shift, $compid) {
                    $sql=" select wdse.auto_id,DATE_FORMAT(tran_date,'%d-%m-%Y') tran_date,spell,wnd_mc_id,vm.mechine_name,vm.mech_code,
                    ifnull(wdse.quality_id,0) quality_id ,ifnull(wqm.QUALITY,'') quality,no_of_spindle  from EMPMILL12.WINDING_DAILY_SPELL_EB wdse 
                    left join mechine_master vm on wdse.wnd_mc_id =vm.mechine_id 
                    left join EMPMILL12.WINDING_QUALITY_MASTER wqm on wdse.quality_id =wqm.wnd_quality_id 
                    where  wdse.is_active=1 and wdse.company_id =".$compid." and tran_date='".$date."' and spell='".$shift."'
                    ";
                    
                //    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            
 
                public function getwndmcduprecorddata($date, $shift, $compid,$mcno1) {
                    $sql="select dtl_rec_id,dea.attendace_date,dea.spell,d.desig mcdesig,vm.mechine_name,d2.desig attdesig,dea.mc_id
                    ,dea.eb_no 
                    from daily_ebmc_attendance dea
                    left join daily_attendance da on dea.daily_atten_id =da.daily_atten_id 
                    left join designation d on d.id  =dea.designation_id  
                    left join designation d2 on d2.id =da.worked_designation_id
                    left join mechine_master vm on dea.mc_id =vm.mechine_id 
                    where dea.is_active =1 and da.is_active =1 and dea.attendace_date ='".$date."'
                    and dea.spell='".$shift."' and da.company_id=".$compid." and mc_id=".$mcno1."
                    ";
//                    echo $sql;
                 //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            


                public function getjugDoffdata($date, $shift, $compid,$openclose) {

                    $sql="	select wje.WND_MC_ID,max(auto_id) mxautoid from EMPMILL12.WINDING_JUGAR_ENTRY wje 
                    JOIN
                    (   
                     SELECT company_id,TRAN_DATE,SPELL,WND_MC_ID,OPEN_CLOSE,COUNT(*) FROM EMPMILL12.WINDING_JUGAR_ENTRY wje 
                     where TRAN_DATE ='".$date."'  and SPELL='".$shift."' and OPEN_CLOSE ='".$openclose."'
                     and wje.company_id=".$compid." and wje.is_active =1 
                     GROUP BY company_id,TRAN_DATE,SPELL,WND_MC_ID,OPEN_CLOSE HAVING COUNT(*)>1
                     ) g ON wje.TRAN_DATE =g.TRAN_DATE AND wje.spell=g.spell and wje.WND_MC_ID =g.wnd_mc_id
                     and wje.company_id=g.company_id and wje.is_active =1
                    group by wnd_mc_id
                ";
             //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                  
                $query =  $this->db->query($sql );
                $records = $query->result();
                    $data = [];
                    foreach ($records as $record) {
                        
                        $sqla="update EMPMILL12.WINDING_JUGAR_ENTRY set is_active=0 where auto_id=".$record->mxautoid;    
                        $this->db->query($sqla);
                    }
            
              


                    $sql=" select wje.AUTO_ID,DATE_FORMAT(TRAN_DATE,'%d-%m-%Y') doffdate,wje.SPELL ,OPEN_CLOSE, 
                    wje.WND_MC_ID,wje.WEIGHT ,vm.mechine_name  
                    from EMPMILL12.WINDING_JUGAR_ENTRY wje 
                    left join mechine_master vm on wje.WND_MC_ID =vm.mechine_id 
                    where TRAN_DATE ='".$date."'  and SPELL='".$shift."' and OPEN_CLOSE ='".$openclose."'
                    and wje.company_id=".$compid." and wje.is_active =1
                     ";
                     $sql=$sql." order by auto_id";
                    
               //     $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            
 
                public function getfinishalldata($date,  $compid) {
                    $sql = "select rec_date,substr(spell,1,1) shift,eb_no,wnd_q_code,mech_code,no_of_spindle,
                    case when uom='B' then round(sum(prod-opwt+clwt)/14,0) else sum(prod-opwt+clwt) end production,
                    sum(prod-opwt+clwt) prodkgs,round(sum(targetprd),0) targetprd ,sum(working_hours-idle_hours) whrs,0 idlehrs from (
                    select wsepq.*,IFNULL(wje.opwt,0) opwt ,ifnull(wje.clwt,0) clwt,wqm.WND_Q_CODE ,dea.eb_no,vm.mech_code,da.working_hours,da.idle_hours,
                    wdse.no_of_spindle,round(wqm.TARGET_PROD /8*(da.working_hours-da.idle_hours),2) targetprd ,uom  
                    from 
                    (
                    select company_id,rec_date,spell,WND_MC_ID,wsepq.quality_id , sum(production) prod 
                    from EMPMILL12.WINDING_SPELL_EB_PROD_QLTY wsepq where rec_date='".$date."' and is_active =1 and company_id =".$compid."
                    group by company_id,rec_date,spell,WND_MC_ID,wsepq.quality_id 
                    ) wsepq
                    left join (
                    select tran_date,spell,WND_MC_ID ,
                    max(case when OPEN_CLOSE ='O' then WEIGHT else 0 end) opwt,
                    max(case when OPEN_CLOSE ='C' then WEIGHT else 0 end) clwt
                    from EMPMILL12.WINDING_JUGAR_ENTRY wje where wje.TRAN_DATE ='".$date."' and is_active =1 and company_id =".$compid."
                    group by tran_date,spell,WND_MC_ID 
                    ) wje  on wje.TRAN_DATE =wsepq.rec_date and wje.SPELL =wsepq.spell and wje.WND_MC_ID =wsepq.wnd_mc_id 
                    left join (select * from daily_ebmc_attendance dea where dea.attendace_date='".$date."' and is_active=1) dea
                    on wsepq.rec_date =dea.attendace_date and wsepq.spell =dea.spell
                    and wsepq.wnd_mc_id =dea.mc_id and wsepq.company_id =dea.company_id 
                    left join (select * from daily_attendance da where da.is_active=1) da
                    on da.daily_atten_id =dea.daily_atten_id 
                    left join EMPMILL12.WINDING_QUALITY_MASTER wqm on wsepq.quality_id =wqm.wnd_quality_id 
                    left join mechine_master vm on vm.mechine_id =wsepq.wnd_mc_id 
                    left join (select * from EMPMILL12.WINDING_DAILY_SPELL_EB wdse where is_active=1) wdse
                    on wsepq.rec_date=wdse.tran_date and wsepq.spell =wdse.spell 
                    and wsepq.wnd_mc_id =wdse.wnd_mc_id 
                    ) g group by rec_date,substr(spell,1,1),eb_no,wnd_q_code,mech_code,no_of_spindle,uom 
                    
                    ";
                    $sql="select rec_date trandate,shift,eb_no,wnd_q_code,mech_code,no_of_spindle,
                    case when uom='B' then round(production/14,0) else (production) end production,prodkgs,targetprd, 
                    whrs,idlehrs
                    from EMPMILL12.view_winding_all_data vwad where vwad.rec_date='".$date."' and company_id=".$compid;
                    

                    
                   

               //     $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                   
                }            
 
                public function get_wndreprecords($date,$shift, $compid) {
                    $sql = "select wsepq.*,dea.eb_no,concat(first_name,ifnull(middle_name,''),ifnull(last_name,'')) empname,
                    ifnull((da.working_hours-da.idle_hours),0) whrs,vm.mechine_name,wqm.QUALITY quality,no_of_spindle from 
                    (
                    select company_id,date_format(rec_date,'%d-%m-%Y') rec_date   ,spell,eb_id,WND_MC_ID,wsepq.quality_id , sum(production) prod 
                    from EMPMILL12.WINDING_SPELL_EB_PROD_QLTY wsepq where rec_date='".$date."' and is_active =1 and 
                    company_id =".$compid." and spell='".$shift."' and production>0 group by company_id,rec_date,spell,eb_id,
                    WND_MC_ID,wsepq.quality_id
                    ) wsepq left JOIN (select * from daily_ebmc_attendance dea where is_active =1) dea
                    on wsepq.company_id =dea.company_id and wsepq.rec_date =dea.attendace_date and 
                    wsepq.spell =dea.spell and wsepq.wnd_mc_id =dea.mc_id
                    left join (select * from daily_attendance da where is_active=1) da ON 
                    da.daily_atten_id= dea.daily_atten_id 
                    left join mechine_master vm on vm.mechine_id =wsepq.wnd_mc_id
                    left join EMPMILL12.WINDING_QUALITY_MASTER wqm on wqm.wnd_quality_id=wsepq.quality_id  
                    left join (select * from EMPMILL12.WINDING_DAILY_SPELL_EB wdse where wdse.is_active=1) wdse
                    on wdse.tran_date =wsepq.rec_date and wdse.spell =wsepq.spell 
                    and wdse.company_id =wsepq.company_id and wdse.wnd_mc_id=wsepq.wnd_mc_id
                    left join tbl_hrms_ed_personal_details thepd 
                    on dea.eb_id=thepd.eb_id  order by vm.mech_code
                                   ";
                     $sql="select date_format(tran_date,'%d-%m-%Y') tran_date  ,spell,mechine_name,eb_no,empname,wnd_q_code,quality,wrkhrs,no_of_spindle,mech_code, sum(prod) production
                    from EMPMILL12.allwindingdata a where tran_date='".$date."' and spell='".$shift."' and company_id =".$compid."
                    group by tran_date,spell,mechine_name,eb_no,empname,wnd_q_code,quality,wrkhrs,no_of_spindle,mech_code 
                    order by cast(mech_code as UNSIGNED )";
                  //       echo $sql;              
                //    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                   
                }            

                public function get_wndindreprecords($sdate,$edate, $compid,$empcode) {
                   $sql="	select * from (
                    select 1 rem,eb_no,' ' empname,DATE_FORMAT(tran_date,'%d-%m-%Y') tran_date,substr(spell,1,1) shift,quality_id,quality,quality_name,sum(atthrs) atthrs,
                    sum(mcwhrs) mcwhrs,sum(prod)  prod ,
                    sum(target_prod) target_prod ,round(sum(prod)/sum(target_prod)*100,2) eff,round(sum(prod)/sum(atthrs)*8,0) avg_prod,round(sum(target_prod)/sum(atthrs)*8,0) avg_targetprod 
                    from EMPMILL12.view_proc_spellwindingdata vps 
                    where tran_date between '$sdate' and '$edate' and eb_no='$empcode' and company_id=$compid
                    group by tran_date ,substr(spell,1,1) ,quality_id,quality,quality_name,eb_no
                    union all
                    select 2 rem,'' eb_no,' ' empname,'Quality Total' tran_date,' ' shift,quality_id,quality,quality_name,sum(atthrs) atthrs,
                    sum(mcwhrs) mcwhrs,sum(prod)  prod ,
                    sum(target_prod) target_prod ,round(sum(prod)/sum(target_prod)*100,2) eff ,round(sum(prod)/sum(atthrs)*8,0) avg_prod,round(sum(target_prod)/sum(atthrs)*8,0) avg_targetprod
                    from EMPMILL12.view_proc_spellwindingdata vps 
                    where tran_date between '$sdate' and '$edate' and eb_no='$empcode' and company_id=$compid
                    group by quality_id,quality,quality_name
                    union all
                    select 3 rem,'' eb_no,' ' empname,'Grand Total' tran_date,' ' shift, '' quality_id,' ' quality,' ' quality_name,sum(atthrs) atthrs,
                    sum(mcwhrs) mcwhrs,sum(prod)  prod ,
                    sum(target_prod) target_prod ,round(sum(prod)/sum(target_prod)*100,2) eff ,round(sum(prod)/sum(atthrs)*8,0) avg_prod,round(sum(target_prod)/sum(atthrs)*8,0) avg_targetprod
                    from EMPMILL12.view_proc_spellwindingdata vps 
                    where tran_date between '$sdate' and '$edate' and eb_no='$empcode' and company_id=$compid
                     ) g
                    order by rem,tran_date ";     


                  //  $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                   
                    return $resultq;

                   
                }            

                public function get_wndperrecords($sdate, $edate, $compid) {
                    $sql = "select eb_id,eb_no,empname,sum(prod) prod,sum(whrs) whrs,round(sum(prod)/sum(whrs)*8,0) 
                    prod_8hrs,
                    round(sum(targetprod)/sum(whrs)*8,0) target_8hrs,
                    round(sum(targetprod)-sum(prod),0) diff,
                    round((round(sum(prod)/ sum(whrs)* 8, 0))/(round(sum(targetprod)/ sum(whrs)* 8, 0))*100,2) eff,
                    wnd_group_name,image_html from ( 
                    select swd.*,da.eb_id,da.eb_no,(da.working_hours-idle_hours) whrs,da.attendance_type,
                    concat(thepd.first_name, ifnull(thepd.middle_name, ''), ifnull(thepd.last_name, '')) AS empname,d.desig,om.OCCU_CODE,
                    (TARGET_PROD/8*(da.working_hours-idle_hours)) targetprod
                    from EMPMILL12.spellwindingdata swd
                    left join (select * from vowsls.daily_ebmc_attendance dea where dea.is_active=1) dea
                    on dea.attendace_date=swd.tran_date and dea.spell=swd.spell and dea.mc_id=swd.WND_MC_ID
                    left join (select * from vowsls.daily_attendance where is_active=1) da
                    on da.daily_atten_id=dea.daily_atten_id
                    left join vowsls.tbl_hrms_ed_personal_details thepd on thepd.eb_id=da.eb_id
                    left join vowsls.ORA_OCCU_LINK_TABLE oolt on oolt.MYSQL_TABLE_ID=da.worked_designation_id
                    Left join EMPMILL12.OCCUPATION_MASTER om on om.occu_id=oolt.ORA_TABLE_ID
                    left join vowsls.designation d on d.id=da.worked_designation_id
                    where prod>0 and swd.tran_date between '".$sdate."' and '".$edate."' and swd.company_id=".$compid."
                    ) g left join (select * from EMPMILL12.tbl_item_image tii where image_type='E') tii  on eb_id=tii.item_id
                    group by eb_id,eb_no,empname,wnd_group_name,image_html
                    order by wnd_group_name,eb_no";

                //    echo $sql;    
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                   
                }            

                public function get_attwndchkrecords($date,$shift, $compid) {
                    $sql = "select dea.mc_id,dea.attendace_date tran_date,dea.spell, mechine_name,dea.eb_no,wqm.WND_Q_CODE wnd_q_code,  quality,(da.working_hours-idle_hours) whrs,
                    no_of_spindle,ifnull(production,0) production,'' empname,(da.working_hours-da.idle_hours) wrkhrs  from daily_ebmc_attendance dea  
                   left join daily_attendance da ON dea.daily_atten_id =da.daily_atten_id 
                   left join mechine_master vm on dea.mc_id =vm.mechine_id 
                   left join (select rec_date,spell,company_id,wnd_mc_id,quality_id,sum(wsepq.production ) production 
                   from EMPMILL12.WINDING_SPELL_EB_PROD_QLTY wsepq where is_active=1 group by rec_date,spell,company_id,wnd_mc_id,quality_id) wsepq
                   on wsepq.rec_date=dea.attendace_date and wsepq.spell=dea.spell and wsepq.company_id=dea.company_id 
                   and wsepq.wnd_mc_id=dea.mc_id 
                   left join (select * from EMPMILL12.WINDING_DAILY_SPELL_EB wdse where is_active =1) wdse
                   on wdse.tran_date=dea.attendace_date and wdse.spell=dea.spell and wdse.company_id=dea.company_id 
                   and wdse.wnd_mc_id=dea.mc_id 
                   left join EMPMILL12.WINDING_QUALITY_MASTER wqm on wqm.wnd_quality_id =wsepq.quality_id
                   where dea.is_active =1 and dea.company_id =".$compid." and dea.attendace_date ='".$date."'
                   and dea.spell='".$shift."' and vm.dept_id =53 and da.is_active =1
                    ";
     // echo $sql;              
       
                    
               //     $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                   
                }            

                public function get_wndqcwisereport($date,$fdate, $compid)   {
               
               
                    $sql = "select * from (
                    select mwndqcode,tdquality,tdemp,tdprd,ifnull(empla,0) empla,ifnull(emplb,0) emplb,ifnull(emplc,0) emplc,
                    ifnull(empla,0)+ifnull(emplb,0)+ifnull(emplc,0) emplt,
                    ifnull(topdka,0) topdka,ifnull(topdkb,0) topdkb,ifnull(topdkc,0) topdkc,ifnull(totrga,0) totrga
                    ,ifnull(totrgb,0) totrgb,ifnull(totrgc,0) totrgc from
                    ( 
                    select wnd_q_code mwndqcode ,quality tdquality,sum(empla+emplb+emplc) tdemp,
                    sum(topdka+topdkb+topdkc) tdprd from EMPMILL12.view_winding_qualitywise_data
                    where rec_date between '".$fdate."' and '".$date."' and company_id=".$compid." group by wnd_q_code,quality
                    )  tvwgd left join
                    (
                    select vwqd.* from EMPMILL12.view_winding_qualitywise_data vwqd where rec_date ='".$date."' and company_id=".$compid."
                    ) vwgd
                    on vwgd.wnd_q_code=tvwgd.mwndqcode  
                     union all
                    select '99997' mwndqcode,'Grand Total' tdquality,sum(tdemp) tdemp,sum(tdprd) tdprd,sum(empla) empla,sum(emplb) emplb,
                    sum(emplc) emplc,sum(emplt) emplt,sum(topdka) topdka,sum(topdkb) topdkb,sum(topdkc) topdkc,
                    sum(totrga) totrga,sum(totrgb) totrgb,sum(totrgc) totrgc from (
                    select mwndqcode,tdquality,tdemp,tdprd,ifnull(empla,0) empla,ifnull(emplb,0) emplb,ifnull(emplc,0) emplc,
                    ifnull(empla,0)+ifnull(emplb,0)+ifnull(emplc,0) emplt,
                    ifnull(topdka,0) topdka,ifnull(topdkb,0) topdkb,ifnull(topdkc,0) topdkc,ifnull(totrga,0) totrga
                    ,ifnull(totrgb,0) totrgb,ifnull(totrgc,0) totrgc from
                    ( 
                    select wnd_q_code mwndqcode ,quality tdquality,sum(empla+emplb+emplc) tdemp,
                    sum(topdka+topdkb+topdkc) tdprd from EMPMILL12.view_winding_qualitywise_data
                    where rec_date between '".$fdate."' and '".$date."' and company_id=".$compid." group by wnd_q_code,quality
                    )  tvwgd left join
                    (
                    select vwqd.* from EMPMILL12.view_winding_qualitywise_data vwqd where rec_date ='".$date."' and company_id=".$compid."
                    ) vwgd
                    on vwgd.wnd_q_code=tvwgd.mwndqcode  order by mwndqcode
                    ) k
                    
                    ) v order by mwndqcode
                    ";
                 
                    $sql = "select * from (
                        select mwndqcode,tdquality,tdemp,tdprd,ifnull(empla,0) empla,ifnull(emplb,0) emplb,ifnull(emplc,0) emplc,
                        ifnull(empla,0)+ifnull(emplb,0)+ifnull(emplc,0) emplt,
                        ifnull(topdka,0) topdka,ifnull(topdkb,0) topdkb,ifnull(topdkc,0) topdkc,ifnull(totrga,0) totrga
                        ,ifnull(totrgb,0) totrgb,ifnull(totrgc,0) totrgc from
                        ( 
                        select wnd_q_code mwndqcode ,quality tdquality,sum(empla+emplb+emplc) tdemp,
                        sum(topdka+topdkb+topdkc) tdprd from EMPMILL12.view_winding_qualitywise_data
                        where rec_date between '".$fdate."' and '".$date."' and company_id=".$compid." group by wnd_q_code,quality
                        )  tvwgd left join
                        (
                        select vwqd.* from EMPMILL12.view_winding_qualitywise_data vwqd where rec_date ='".$date."' and company_id=".$compid."
                        ) vwgd
                        on vwgd.wnd_q_code=tvwgd.mwndqcode  
                        
                        ) v order by mwndqcode
                        ";
                     
                         $sql = "select wnd_q_code mwndqcode,quality tdquality,sum(tdemp) tdemp,sum(tdprd) tdprd,sum(empla) empla,
                        sum(emplb) emplb,sum(emplc) emplc,sum(emplt) emplt,sum(topdka) topdka ,sum(topdkb) topdkb ,
                        sum(topdkc) topdkc,sum(totrga) totrga ,sum(totrgb) totrgb,sum(totrgc) totrgc from (  
                        select wnd_q_code,quality,0 tdemp,0 tdprd,empla,emplb,emplc,(empla+emplb+emplc) emplt,
                        topdka,topdkb,topdkc,totrga,totrgb,totrgc  
                        from EMPMILL12.view_winding_qualitywise_data vwqd 
                        where rec_date ='".$date."' and company_id=".$compid."
                        union all
                        select wnd_q_code,quality,sum(empla+emplb+emplc) tdemp,
                        sum(topdka+topdkb+topdkc) tdprd,
					    0 empla,0 emplb,0 emplc,0 emplt,
                        0 topdka,0 topdkb,0 topdkc,0 totrga,0 totrgb,0 totrgc
                        from EMPMILL12.view_winding_qualitywise_data
                        where rec_date between '".$fdate."' and '".$date."' and company_id=".$compid." group by wnd_q_code,quality
                        ) g group by wnd_q_code,quality  order by wnd_q_code ";
                        


  //                               echo $sql;
//                    order by mwndqcode
                //     $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
         
          

                }            



                public function get_wndqcsummreports($date,$fdate, $compid)   {

                    $sql = "select * from ( select 1 code, spg_group,sum(empla) empla,sum(emplb) emplb,sum(emplc) emplc,sum(empla+emplb+emplc) emplt,
                    sum(topdka) topdka,sum(topdkb) topdkb,sum(topdkc) topdkc,sum(topdka+topdkb+topdkc) topdkt,
                    sum(spgwnd) spgwnd,sum(spgprda) spgprda,sum(spgprdb) spgprdb,sum(spgprdc) spgprdc , sum(spgprda+spgprdb+spgprdc) spgprdt
                    from (
                    select spg_group,(empla) empla,(emplb) emplb,(emplc) emplc,(empla+emplb+emplc) emplt,
                    (topdka) topdka,(topdkb) topdkb,(topdkc) topdkc,
                    0 spgwnd,0 spgprda,0 spgprdb,0 spgprdc , 0 spgprdt
                    from EMPMILL12.view_winding_qualitywise_data vwqd 
                    left join EMPMILL12.WINDING_QUALITY_MASTER wqm on vwqd.wnd_q_code=wqm.WND_Q_CODE 
                    left join EMPMILL12.WINDING_GROUP_MASTER wgm on wqm.WND_GR_CODE =wgm.WND_GR_CODE 
                    where rec_date ='".$date."' and vwqd.company_id=".$compid." 
                    union ALL 
                    select type spg_group,0 empla,0 emplb,0 emplc,0 emplt,
                    0 topdka,0 topdkb,0 topdkc,
                    (winder) spgwnd,(prd_a) spgprda,(prd_b) spgprdb,(prd_c) spgprdc , (prd_a+prd_b+prd_c) spgprdt
                    from EMPMILL12.spining_daily_transaction sdt 
                    left join EMPMILL12.SPINTYPE s on substr(sdt.q_code,2,2)=s.code
                    where tran_date ='".$date."' and company_id=".$compid."
                    ) g                     
                    group by spg_group
                    union all        
                    select 9 code,'Grand Total' spg_group,sum(empla) empla,sum(emplb) emplb,sum(emplc) emplc,sum(empla+emplb+emplc) emplt,
                    sum(topdka) topdka,sum(topdkb) topdkb,sum(topdkc) topdkc,sum(topdka+topdkb+topdkc) topdkt,
                    sum(spgwnd) spgwnd,sum(spgprda) spgprda,sum(spgprdb) spgprdb,sum(spgprdc) spgprdc , sum(spgprda+spgprdb+spgprdc) spgprdt
                    from (
                    select 1 code, spg_group,sum(empla) empla,sum(emplb) emplb,sum(emplc) emplc,sum(empla+emplb+emplc) emplt,
                    sum(topdka) topdka,sum(topdkb) topdkb,sum(topdkc) topdkc,sum(topdka+topdkb+topdkc) topdkt,
                    sum(spgwnd) spgwnd,sum(spgprda) spgprda,sum(spgprdb) spgprdb,sum(spgprdc) spgprdc , sum(spgprda+spgprdb+spgprdc) spgprdt
                    from (
                    select spg_group,(empla) empla,(emplb) emplb,(emplc) emplc,(empla+emplb+emplc) emplt,
                    (topdka) topdka,(topdkb) topdkb,(topdkc) topdkc,
                    0 spgwnd,0 spgprda,0 spgprdb,0 spgprdc , 0 spgprdt
                    from EMPMILL12.view_winding_qualitywise_data vwqd 
                    left join EMPMILL12.WINDING_QUALITY_MASTER wqm on vwqd.wnd_q_code=wqm.WND_Q_CODE 
                    left join EMPMILL12.WINDING_GROUP_MASTER wgm on wqm.WND_GR_CODE =wgm.WND_GR_CODE 
                    where rec_date ='".$date."' and vwqd.company_id=".$compid."
                    union ALL 
                    select type spg_group,0 empla,0 emplb,0 emplc,0 emplt,
                    0 topdka,0 topdkb,0 topdkc,
                    (winder) spgwnd,(prd_a) spgprda,(prd_b) spgprdb,(prd_c) spgprdc , (prd_a+prd_b+prd_c) spgprdt
                    from EMPMILL12.spining_daily_transaction sdt
                    left join EMPMILL12.SPINTYPE s on substr(sdt.q_code,2,2)=s.code
                    where tran_date='".$date."' and company_id=".$compid."
                    ) g  group by spg_group
                    ) k ) v order by code,spg_group
                    ";
           //   echo $sql;
                 //   $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                   
                    return $resultq;

                }            

                public function mcno1_checkdata($companyId,$windingqcDate,$qcshiftName,$mcno1) {
                    $sql = "select * from EMPMILL12.WINDING_DAILY_SPELL_EB wdse where wdse.wnd_mc_id =$mcno1
                    and wdse.tran_date ='$windingqcDate'
                    and wdse.spell ='$qcshiftName' and wdse.company_id =$companyId and wdse.is_active =1
                    ";
     // echo $sql;              
       
                    
               //     $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                   
                }            


}