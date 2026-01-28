<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class daily_spell_drawing_entry_model extends  CI_Model   {


    public function __construct() {
        parent::__construct();
        $this->load->database();

        $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
//        $this->load->database('vowsls', TRUE);  // Loads the default database (Doff entry database)
    }


    public function getdesigdata($category_id) {
        // Write a custom SQL query to fetch subcategories
        $sql = "select id,desig name   from designation d
        join master_department md on d.department=md.mdept_id and d.company_id =md.company_id 
        join department_master dm on dm.mdept_id = md.mdept_id and dm.company_id =md.company_id 
        where dm.dept_id =?  order by desig";
        
        // Execute the query, passing in the category_id as a parameter
        $query = $this->db->query($sql, array($category_id));
        
        // Return the result as an array
        return $query->result_array();
    }
    
    public function getmcnodata($category_id,$desig_id) {
        // Write a custom SQL query to fetch subcategories
        $sql = "  select mm.mechine_id id,concat(mm.mech_code,'-',mm.mechine_name) name  from mechine_master mm 
        join mech_occu_link mol on mm.mechine_id =mol.mech_id 
        where mol.occu_id =? order by mm.mech_code
        ";
        
        // Execute the query, passing in the category_id as a parameter
        $query = $this->db->query($sql, array($desig_id));
        
        // Return the result as an array
        return $query->result_array();
    }

    public function getSpooldata() {
         
             $company_id = $this->session->userdata('company_id');
            $sql='select trollyid,trolly_details from trollymst where company_id='.$company_id.' and process_type=101 order by trolly_details';
            $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
            $result = $otherdb->query($sql)->result_array();
            $otherdb->close();
             return $result;
 
            }
            public function getwndmcnodata() {
         
                $company_id = $this->session->userdata('company_id');
               $sql='select mechine_id,concat(mech_code,"-",mechine_name) mechine_name from vowsls.mechine_master where company_id='.$company_id.' and type_of_mechine=14 
               order by mech_code';
             //  $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                $results = $this->db->query($sql)->result_array();
                return $results;
    
               }
               public function getdeptdata() {
         
                $company_id = $this->session->userdata('company_id');
               $sql='select dept_id,dept_desc from vowsls.department_master where company_id='.$company_id.'  
               order by dept_desc';
//               $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                   $results = $this->db->query($sql)->result_array();
  //              echo var_dump($results);
                   return $results;
    
               }

               public function getsprdmcdata() {
         
                $company_id = $this->session->userdata('company_id');
               $sql='select mechine_id,concat(mech_code,"-",mechine_name) mechine_name from vowsls.mechine_master where company_id='.$company_id.' and type_of_mechine=8 
               order by mech_code';
            //   $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
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
                $sql='select wnd_quality_id,concat(WND_Q_CODE,"-",QUALITY) QUALITY from WINDING_QUALITY_MASTER where company_id='.$company_id.'  order by quality';
                $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                $resultq = $otherdb->query($sql)->result_array();
           //     var_dump($resultq);
           $otherdb->close();
                return $resultq;
        

            }
       

                public function getwndprvDoffData($companyId,$mcno1,$windingDate,$shiftName) {
        
//                    $company_id = $this->session->userdata('company_id');
                    $cnt=0;
                    $sql="select ifnull(count(*),0)  cnt  from EMPMILL12.daily_drawing_transaction ddt where 
                    drg_mc_id =".$mcno1." and is_active =1 and company_id=".$companyId." and 
                    spell='".$shiftName."' and tran_date='".$windingDate."'";
                    $resultq = $this->db->query($sql)->result_array();
                    foreach ($resultq as $record) {
                        // Process each record and assign values to variables
                        $cnt = $record['cnt']; // Use the correct key for the 'spoolwt' property
                         
                    }
                    
//        echo $sql;
   //    echo $cnt;
                    $resultq=[];
                    if ($cnt==0) {
                        $sql="select dm.drg_mc_id,dm.drg_mast_id,dm.const_meter,ifnull(g.close_meter,0) close_meter   
                        from EMPMILL12.drawing_master dm 
                        left join
                        (
                        select ddt.drg_mc_id, close_meter from EMPMILL12.daily_drawing_transaction ddt 
                       where drg_mc_id =".$mcno1." and is_active=1 and company_id=2 and substr(spell,1,1)='".substr($shiftName,0,1)."' 
                        and ddt.tran_date  in (
                        select max(tran_date) mxdt from EMPMILL12.daily_drawing_transaction
                        WHERE drg_mc_id =".$mcno1." and is_active =1 and company_id=".$companyId." and 
                        substr(spell,1,1)='".substr($shiftName,0,1)."' ) order by spell desc limit 1
                        ) g on g.drg_mc_id=dm.drg_mc_id 
                        where dm.drg_mc_id=".$mcno1
                    ;
                   // echo $sql;        
                    $resultq = $this->db->query($sql)->result_array();
                    
                        }  
                        return $resultq;
                }            
                public function getsprdprvDoffData($companyId,$mcno1,$windingDate,$shiftName) {
        
                    //                    $company_id = $this->session->userdata('company_id');
                    $windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
		
                   
                         $sql="select dm.drg_mc_id,dm.drg_mast_id,dm.const_meter,ifnull(g.close_meter,0) close_meter,
                         ifnull(cnt,0) cnt  
                      from EMPMILL12.drawing_master dm 
                      left join
                      (
                      select ddt.drg_mc_id, close_meter from EMPMILL12.daily_drawing_transaction ddt 
                      where drg_mc_id =".$mcno1." and is_active=1 and company_id=".$companyId."
                      and ddt.tran_date  in (
                      select max(tran_date) mxdt from EMPMILL12.daily_drawing_transaction
                      WHERE drg_mc_id =".$mcno1." and is_active =1 and company_id=".$companyId."  ) 
                      order by drg_tran_id desc limit 1
                      ) g on g.drg_mc_id=dm.drg_mc_id 
                      left join ( select drg_mc_id,count(*) as cnt from EMPMILL12.daily_drawing_transaction ddt 
                      where ddt.tran_date='".$windingDate."' and spell='".$shiftName."' and drg_mc_id=".$mcno1." 
                      and is_active =1 
                      and company_id=".$companyId.")
                      ddt on ddt.drg_mc_id=g.drg_mc_id 
                         where dm.drg_mc_id=".$mcno1;
                    
                                        //   echo $sql;        
                                        $resultq = $this->db->query($sql)->result_array();
                                        return $resultq;
                                          
                                        
                                    }            
                    
                     
                    



                public function getdrgeditData($companyId,$mcno1,$shiftName,$windingDate) {
                    $sql="select * from EMPMILL12.daily_drawing_transaction ddt where drg_mc_id=".$mcno1." and 
                    tran_date ='".$windingDate."' and substr(spell,1,1)='".$shiftName."' and company_id =".$companyId;
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
                //    echo   $this->db->last_query();

                    $records = $query->result_array();
                    if (!empty($records)) {
                        // Insert records into the target table using batch processing
                        $otherdb->insert_batch('daily_attendance', $records);
          //              return $otherdb->affected_rows(); // Return the number of inserted rows
                    } else {
        //                return 0; // No records to transfer
                    }
                
               
                    $multiClause = array('attendace_date' => $date, 'spell' => $shift, 'is_active' =>$actv,'company_id' => $compid );
                    $this->db->where($multiClause);		
                //    $this->db->limit(313); 
                    
                    $query = $this->db->get('daily_ebmc_attendance');
             

                    $records = $query->result_array();
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

                    $sql="select *  from WINDING_DAILY_SPELL_EB wje 
                    where TRAN_DATE ='".$windingjugarDate."' and spell='".$doffshift."'  and company_id=".$companyId."
                    and is_active=1";
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                
                    $resultq = $otherdb->query($sql)->result_array();;
                    $cnt=count($resultq);
                  //  echo $cnt; 
                  if ($cnt>0) {
                    return "Already Quality Updated";
                  }  
                  if ($cnt==0) {
                        $sql="select max(tran_date) mxdate from  WINDING_DAILY_SPELL_EB sytd 
                        where company_id =".$companyId." and tran_date<='".$doffdate."' and is_active=1"; 
 //                       $query = $otherdb->query($sql, array($companyId,$doffdate ));
 //                       $records = $query->result();
//                         echo $sql;
                        $query = $otherdb->query($sql);
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
                            from WINDING_DAILY_SPELL_EB sytd 
                            where  is_active=1 and company_id =? and tran_date=?
                            ) g ";
                            $created_by=26586;
                            $active=1;
                            $query = $otherdb->query($sql, array($companyId,$mxdate ));
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
                            $sql="insert into WINDING_DAILY_SPELL_EB (company_id,created_by,tran_date,is_active,spell,wnd_mc_id,
                             quality_id,no_of_spindle ) 
                             select ".$companyId.",".$created_by.",'".$doffdate."',".$active.",'".$doffshift."', mechine_id,ifnull(quality_id,0) qc,
                             ifnull(no_of_spindle,0) spnd from 
                             (
                             select vm.mechine_id,vm.mechine_name  from vowmechine_master vm where vm.type_of_mechine =39 and company_id=2
                             ) i left join (select wnd_mc_id,quality_id,no_of_spindle 
                             from WINDING_DAILY_SPELL_EB 
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
                            $otherdb->query($sql);
                            $otherdb->close();
                            return "Quality  Inserted";  

                    }    
                                         
                                        
                                    }            

                                    public function getwndmc2Data($companyId,$mcno2) {
        
                                        //                    $company_id = $this->session->userdata('company_id');
                                          
                                           
                                          $sql="select mechine_id,mech_code from vowmechine_master vm where type_of_mechine=39 and company_id=".$companyId." 
                                          and  mach_shr_code =".$mcno2 ;
                    
                                          
                                           $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                                                            $resultq = $otherdb->query($sql)->result_array();
                                                       //     var_dump($resultq);
                                                       $otherdb->close();
                                                            return $resultq;
                                                            
                                                            
                                                        }            
                                                        

                                            
                public function getwndtrollyData($companyId,$trollyNo) {
                    $sql="select trollyid,trolly_weight from trollymst tm where process_type=39 and company_id=".$companyId." 
                    and  trollyno =".$trollyNo ;
                    $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                    $resultq = $otherdb->query($sql)->result_array();
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
             
                
                public function getsprdDoffdata($date, $shift, $compid) {

              


                    $sql=" select ddt.drg_tran_id,date_format(ddt.tran_date,'%d-%m-%Y') tran_date ,ddt.spell,mm.mech_code,
                    mm.mechine_name,
                    ddt.const_meter ,ddt.open_meter ,
                    ddt.close_meter ,ddt.diff_meter ,ddt.actual_eff,ddt.wrk_hours ,ddt.remarks,ddt.drg_mc_id,ddt.actual_prod  
                    from EMPMILL12.daily_drawing_transaction ddt 
                    left join vowsls.mechine_master mm on mm.mechine_id =ddt.drg_mc_id 
                    where ddt.tran_date ='".$date."' and ddt.is_active =1 and mm.type_of_mechine=8
                    and ddt.company_id =".$compid."  order by mech_code";
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            

                public function getprintsprdDoffdata($date, $shift, $compid) {

              


                    $sql=" select ddt.drg_tran_id,date_format(ddt.tran_date,'%d-%m-%Y') tran_date ,ddt.spell,mm.mech_code,
                    mm.mechine_name,
                    ddt.const_meter ,ddt.open_meter ,
                    ddt.close_meter ,ddt.diff_meter ,ddt.actual_eff,ddt.wrk_hours ,ddt.remarks,ddt.drg_mc_id,ddt.actual_prod  
                    from EMPMILL12.daily_drawing_transaction ddt 
                    left join vowsls.mechine_master mm on mm.mechine_id =ddt.drg_mc_id 
                    where ddt.tran_date ='".$date."' and ddt.is_active =1 and mm.type_of_mechine=8
                    and ddt.company_id =".$compid."  order by mech_code";
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            


                
                public function getattndata($date, $shift, $compid,$deptid) {

                    $sql="select
                    daily_atten_id,
                    DATE_FORMAT(attendance_date, '%d-%m-%Y') Date,
                    spell Spell,
                    eb_no EB_No,
                    name Name,
                    dept_desc Department,
                    desig Designation,
                    attendance_type,
                    whrs Working_Hours,idlehrs,
                    mcnos MC_Nos,
                    attendance_source,
                    remarks,
                    worked_department_id,
                    worked_designation_id,
                    eb_id,mcids
                from
                    (
                    select
                        da.company_id,
                        da.company_name,
                        da.attendance_date,
                        da.spell,
                        da.eb_no,
                        name,
                        da.worked_department_id,
                        dept_desc,
                        da.worked_designation_id,
                        desig,
                        da.attendance_type,
                        whrs,idlehrs,
                        spell_hours,
                        ifnull(mcnos, ' ') mcnos,
                        attendance_source,
                        remarks,da.eb_id,da.daily_atten_id,mcids
                    from
                        (
                        select
                            da.company_id,
                            cm.company_name,
                            da.daily_atten_id,
                            da.attendance_date,
                            da.spell,
                            da.eb_no,
                            concat(thepd.first_name, ' ', ifnull(middle_name, ' '), ' ', ifnull(last_name, ' ')) name,
                            da.worked_department_id,
                            dm.dept_desc,
                            da.worked_designation_id,
                            dsg.desig,
                            da.attendance_type,
                            da.attendance_source,
                            da.working_hours whrs,da.idle_hours idlehrs,
                            da.spell_hours,
                            remarks,
                            da.eb_id
                        from
                            daily_attendance da ,
                            tbl_hrms_ed_personal_details thepd ,
                            department_master dm ,
                            designation dsg,
                            company_master cm
                        where
                            da.eb_id = thepd.eb_id
                            and dm.dept_id = da.worked_department_id
                            and dsg.id = da.worked_designation_id
                            and da.company_id = cm.comp_id
                            and da.is_active = 1
                            and attendance_date between '$date' and '$date'
                            and da.company_id = $compid
                            and da.spell = '$shift'
                            and da.worked_department_id = $deptid ) da
                    left join (
                        select
                            daily_atten_id,
                            eb_no,
                            spell,
                            GROUP_CONCAT(DISTINCT mechine_name SEPARATOR '/') mcnos,
                            GROUP_CONCAT(DISTINCT mc_id SEPARATOR ',') mcids
                        from
                            (
                            select
                                daily_atten_id,
                                eb_no,
                                spell,
                                mechine_name,
                                mc_id
                            from
                                daily_ebmc_attendance dea ,
                                mechine_master mm
                            where
                                dea.mc_id = mm.mechine_id
                                and is_active = 1
                                and attendace_date between '$date' and '$date'
                                and dea.spell = '$shift' ) g
                        group by
                            daily_atten_id,
                            eb_no,
                            spell ) dea on
                        da.daily_atten_id = dea.daily_atten_id ) k
                where
                    attendance_date between '$date' and '$date'
                    and spell = '$shift'
                    and company_id = $compid
                order by
                    eb_no,
                    attendance_date,
                    dept_desc,
                    spell,
                    desig
                
                  
                    ";
               //     echo $sql;
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            

                public function getwndDoffdata($date, $shift, $compid) {

              


                    $sql=" select ddt.drg_tran_id,date_format(ddt.tran_date,'%d-%m-%Y') tran_date ,ddt.spell,mm.mech_code,mm.mechine_name,ddt.const_meter ,ddt.open_meter ,
                    ddt.close_meter ,ddt.diff_meter ,ddt.actual_eff,ddt.wrk_hours ,ddt.remarks,ddt.drg_mc_id  
                    from EMPMILL12.daily_drawing_transaction ddt 
                    left join vowsls.mechine_master mm on mm.mechine_id =ddt.drg_mc_id 
                    where ddt.tran_date ='".$date."' and ddt.is_active =1 and mm.type_of_mechine=14
                    and ddt.company_id =".$compid."  order by mech_code";
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            

                public function getretattndata($date, $shift, $compid,$deptid) {

              


                    $sql="select tdra.*,wm.eb_no emp_code,CONCAT(trim(wm.worker_name), ' ', IFNULL(trim(wm.middle_name), ''), ' ', IFNULL(trim(wm.last_name), '')) AS empname,
                    spell_name,dept_desc,cata_desc from EMPMILL12.tbl_daily_ret_attendance tdra 
                    left join worker_master wm on tdra.eb_id =wm.eb_id
                    left join spell_master sm on sm.spell_id =tdra.spell_id
                    left join department_master dm on dm.dept_id =tdra.dept_id
                    left join category_master cm on wm.cata_id =cm.cata_id
                    where tdra.ret_attend_date ='".$date."' and sm.spell_name ='".$shift."' and dm.dept_id =".$deptid." 
                    and tdra.is_active =1 and tdra.company_id=".$compid;
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            




                public function getsprdspelldata($sdate,  $compid) {

              


                    $sql="select ddt.*,da.eb_no_combined from (
                        select ddt.drg_mc_id ,spell,mech_code,mechine_name,ddt.const_meter, ddt.open_meter,
                        ddt.close_meter,ddt.diff_meter,round(ddt.diff_meter/ddt.const_meter,0) calcroll,  
                        ddt.actual_prod  from EMPMILL12.daily_drawing_transaction ddt 
                        left join mechine_master mm on mm.mechine_id =ddt.drg_mc_id 
                        where ddt.tran_date ='".$sdate."' and mm.type_of_mechine =8 and ddt.company_id =".$compid." and ddt.is_active=1
                        ) ddt left join 
                        (SELECT 
                              da.attendance_date,
                            da.spell,
                            dea.mc_id,
                            GROUP_CONCAT(DISTINCT da.eb_no ) AS eb_no_combined
                        FROM daily_attendance da 
                        LEFT JOIN daily_ebmc_attendance dea ON da.daily_atten_id = dea.daily_atten_id
                        LEFT JOIN mechine_master mm ON dea.mc_id = mm.mechine_id 
                        WHERE da.attendance_date  ='".$sdate."' and da.company_id=".$compid."  
                        AND mm.type_of_mechine = 8 
                        AND da.is_active = 1 
                        AND dea.is_active = 1  
                        GROUP BY da.attendance_date, da.spell, dea.mc_id  )
                        da on da.mc_id=ddt.drg_mc_id and da.spell=ddt.spell
                        order by ddt.spell,mech_code";
                       // echo $sql;
                    $resultq = $this->db->query($sql)->result_array();
                    return $resultq;
                    
                }            
          
 
               

            
        
 
          

              
 
                   




}