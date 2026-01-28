

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('max_execution_time', 0);

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Physical_item_report extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	 public function __construct() {
        parent::__construct();
		$this->load->database('db2');
		$this->load->model('Winding_doff_Model');
        $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
	} 

	  public function index()
	{

		$company_id = $this->session->userdata('company_id');

			if (strlen($company_id)==0) { 
				redirect('admin/login/logout');
			}


		//$this->load->view('welcome_message');
	//	$data['records'] = $this->Doffdata_Model->get_all_records();
     //   $this->load->view('record_form', $data);
		
		$this->load->library('form_validation');
		$this->load->model('Winding_doff_Model');
     
		
 	

		$this->load->view('admin/reports/Physical_item_report' );	
	}

 

	public function mcno2_data() {
        $mcno2 = $this->input->post('mcno2');
        $companyId = $this->input->post('companyId');
		$this->load->model('Winding_doff_Model');
		$records = $this->Winding_doff_Model->getwndmc2Data($companyId,$mcno2);
		$cnt=count($records);
	//	echo 'no record-'. $cnt;

 		$bwt=0;
			
		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$mcid = $record['mechine_id']; // Use the correct key for the 'spoolwt' property
 			}
			$response = array(
				'success' => true,
				'mcid' => $mcid
  			 
			);
			

		}		else {

			$response = array(
				'success' => false,
				'mcid' => 0
  			 
			);
			

		}	
		
        echo json_encode($response);
    }

	public function trolly_data() {
        $trollyNo = $this->input->post('trollyNo');
        $companyId = $this->input->post('companyId');
		$this->load->model('Winding_doff_Model');
		$records = $this->Winding_doff_Model->getwndtrollyData($companyId,$trollyNo);
		$cnt=count($records);
		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$trlwt = $record['trolly_weight']; // Use the correct key for the 'spoolwt' property
				$trlid = $record['trollyid']; // Use the correct key for the 'spoolwt' property
				
 			}
			$response = array(
				'success' => true,
				'trollyWt' => $trlwt,
				'trollyid' => $trlid
  			 
			);
		}		else {

			$response = array(
				'success' => false,
				'trollyWt' => 0,
				'trollyid' => 0
  			 
			);
			

		}	
		
        echo json_encode($response);
    }

	public function spool_data() {
        $spoolcode = $this->input->post('spoolcode');
        $companyId = $this->input->post('companyId');
		$this->load->model('Winding_doff_Model');
		$records = $this->Winding_doff_Model->getwndspoolData($companyId,$spoolcode);
		$cnt=count($records);
		 if (count($records) > 0) {			
			foreach ($records as $record) {
				// Process each record and assign values to variables
				$splwt = $record['trolly_weight']; // Use the correct key for the 'spoolwt' property
 			}
			$response = array(
				'success' => true,
				'spoolwt' => $splwt
  			 
			);
		}		else {

			$response = array(
				'success' => false,
				'spoolwt' => 0
  			 
			);
			

		}	
		
        echo json_encode($response);
    }


	public function savewndqc_data() {

 
 			$windingDate = $this->input->post('windingqcDate');
			$rec_time =  date('Y-m-d H:i:s');
			$shiftName = $this->input->post('qcshiftName');
			$companyId = $this->input->post('companyId');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$mcno1 = $this->input->post('mcno1');
	 		$nospool = $this->input->post('nospool');
			$quality_id = $this->input->post('quality_id');
			$record_id = $this->input->post('record_id');
            $active=1;
			$entryMode='M';
			$ip = $_SERVER['REMOTE_ADDR'];
			$otherdb = $this->load->database('empmill12', TRUE); 
		 $data = array(
			'quality_id' => $quality_id,
			'update_ip' => $ip,
 			'wnd_mc_id' => $mcno1,
			'no_of_spindle' => $nospool,		
		);
	//	$this->$otherdb->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
//echo $record_id;
    $otherdb->where('auto_id', $record_id );
    $otherdb->update('WINDING_DAILY_SPELL_EB', $data);
    $otherdb->close();
  //  echo $otherdb->last_query();
    

  
	$data =[];
	  $response = array(
		'success' => true,
		'frameNo' => $mcno1,
		'savedata'=> 'saved'
	);
	
	$frameNo='';        
	echo json_encode($response);
	
	
		}

		public function savejugdoff_data() {

 
			$rec_time =  date('Y-m-d H:i:s');
			$windingDate = $this->input->post('windingjugarDate');
			$shiftName = $this->input->post('jugarshiftName');
			$companyId = $this->input->post('companyId');
			$windingDate=substr($windingDate,6,4).'-'.substr($windingDate,3,2).'-'.substr($windingDate,0,2);
			$mcno1 = $this->input->post('mcno1');
			$openclose = $this->input->post('openclose');
			$jugarwt = $this->input->post('jugarwt');
            $active=1;
			$entryMode='M';
			$ip = $_SERVER['REMOTE_ADDR'];
			$otherdb = $this->load->database('empmill12', TRUE); 
			 $data = array(
			'tran_date' => $windingDate,
			'spell' => $shiftName,
	 		'weight' => $jugarwt,
			'update_ip' => $ip,
			'entry_date' => $rec_time,
			'wnd_mc_id' => $mcno1,
			'open_close' => $openclose,
			'company_id' => $companyId,
			'is_active' => $active
			// Exclude 'id' and 'updated_by' fields
		);
	//	$this->$otherdb->insert('WINDING_SPELL_EB_PROD_QLTY', $data);
		$otherdb->insert('WINDING_JUGAR_ENTRY', $data);

 
 
    	$data =[];
	  $response = array(
		'success' => true,
		'frameNo' => $mcno1,
		'savedata'=> 'saved'
	);
	$otherdb->close();
	$frameNo='';        
	echo json_encode($response);
	
	
		}
	
		


		public function get_itemdatarecords() {
			$compid = $this->input->post('companyId');
            $itemcode = $this->input->post('itemcode');
            $startdate = $this->input->post('startdate');
            $enddate = $this->input->post('enddate');
            $stdate=substr($startdate,6,4).'-'.substr($startdate,3,2).'-'.substr($startdate,0,2);
            $endate=substr($enddate,6,4).'-'.substr($enddate,3,2).'-'.substr($enddate,0,2);
			
        
            $sql="select * from (
                select tpi.company company_id ,tpi.inward_id tran_hdr_id,tpid.indent_details_id tran_line_id, 
                tpi.store_receipt_no sr_print_no,tpid.item,concat(group_code,item_code) itemcode,substr(item_desc,1,40) item_name,
                date_format(tpi.store_receipt_date,'%d-%m-%Y') tran_date,
                round(tpid.approved_qty,3) received_qty,0 issued_qty,0 nappissqty,tpid.rate,'SR' trantype,tpid.indent_details_id sr_line_id 
                ,substr(tpi.store_receipt_date,1,10) trandate,1 rem from tbl_proc_inward_detail tpid 
                left join tbl_proc_inward tpi on tpi.inward_id =tpid.inward 
                left join itemmaster i on tpid.item =i.item_id 
                where tpi.sr_status in (1,3,5) and tpid.is_active =1
                union all
                select sih.company_id,sih.inward tran_hdr_id,issue_no tran_line_id,store_receipt_no sr_print_no,
                sih.item_id item,concat(i2.group_code,i2.item_code) itemcode,item_desc item_name,
                date_format(sih.issue_date,'%d-%m-%Y') tran_date,
                0 received_qty,round(issue_qty,3) issued_qty,0 nappissqty,0 rate,'AI' trantype,
                sih.sr_line_id,substr(sih.issue_date,1,10)  trandate,2 rem 
                from scm_issue_hdr sih 
                left join tbl_proc_inward tpi on tpi.inward_id =sih.inward 
                left join itemmaster i2 on i2.item_id =sih.item_id 
                where sih.is_active =1 and issue_status in (3)
                union all
                select sih.company_id,sih.inward tran_hdr_id,issue_no tran_line_id,store_receipt_no sr_print_no,
                sih.item_id item,concat(i2.group_code,i2.item_code) itemcode,item_desc item_name,
                date_format(sih.issue_date,'%d-%m-%Y') tran_date,
                0 received_qty,0  issued_qty,round(issue_qty,3) nappissqty,0 rate,'ANI' trantype,
                sih.sr_line_id ,substr(sih.issue_date,1,10) trandate,3 rem
                from scm_issue_hdr sih 
                left join tbl_proc_inward tpi on tpi.inward_id =sih.inward 
                left join itemmaster i2 on i2.item_id =sih.item_id 
                where sih.is_active =1 and issue_status in (1)
                ) g  where company_id=".$compid." and itemcode='".$itemcode."'
                and  trandate<='".$endate."'
                order by itemcode,trandate,rem
                ";



                //,sr_line_id,tran_line_id
             
//               echo $sql;                
            $records= $this->db->query($sql)->result_array();
        	$cnt=count($records);
			if ($cnt>0) {
                $srbqty=0;
                $stkqty=0;
                $psrid=0;
                $lsrbqty=0;

                foreach ($records as $record) {
                    if ($record['trantype']=='SR') { 
                        $srid=$record['tran_hdr_id'];
                        $lsrbqty=0;
                        if ($psrid<>$srid) { 
                           $lsrbqty=$srbqty;
                           $psrid=$srid;         
                        }

                        $srbqty=$record['received_qty'];
                        $stkqty=$stkqty+$record['received_qty'];
                    }
                    if ($record['trantype']=='AI') { 
                        $srid=$record['tran_hdr_id'];
                        $srbqty=$srbqty-$record['issued_qty'];
                        $stkqty=$stkqty-$record['issued_qty'];
                    }
                    if ($record['trantype']=='ANI') { 
                        $srid=$record['tran_hdr_id'];
                        $srbqty=$srbqty-$record['nappissqty'];
                        $stkqty=$stkqty-$record['nappissqty'];
                    }
//echo $record['tran_date'].'='.$record['tran_hdr_id'].'='.$record['sr_print_no'].'='.$srbqty.'='.'='.$stkqty."<br>";

                    $data[] = [
						$record['tran_hdr_id'],       // Use array notation instead of object property
						$record['tran_line_id'],
                        $record['tran_date'],
                                  // Use array notation instead of object property
						$record['sr_print_no'],   // Use array notation instead of object property
						$record['item'],   // Use array notation instead of object property
						$record['itemcode'],   // Use array notation instead of object property
						$record['item_name'], 
						$record['received_qty'],       // Use array notation instead of object property
						$record['issued_qty'], 
						$record['nappissqty'],
                        round($srbqty,3),
                        round($stkqty,3),
                        0,
                        $record['sr_line_id'],   // Use array notation instead of object property
						
                              // Use array notation instead of object property
 					];
				}
		    }
            else {
                $data[] = [
                    0,       // Use array notation instead of object property
                    0,          // Use array notation instead of object property
                    '',
                    0,   // Use array notation instead of object property
                    0,   // Use array notation instead of object property
                    '',   // Use array notation instead of object property
                    '', 
                    0,       // Use array notation instead of object property
                    0, 
                    0 ,
                    0,
                    0     // Use array notation instead of object property
                 ];
        
            }

			echo json_encode(['data' => $data]);
		}

        public function deleteRecord() {
			$recordId = $this->input->post('recordId');
	//		echo $recordId;
			// Load the database library
		//	$otherdb = $this->load->database('empmill12', TRUE); 
		//	$otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
			$sql="update scm_issue_hdr set is_active=0,internal_note='neg adj' where issue_no=".$recordId;
          //  echo $sql;
			$this->db->query($sql);
          //  echo $otherdb->last_query();
            $response = array(
				'success' => true,
				'frameNo' => $recordId,
				'savedata'=> 'Deleted'
			);
			
					echo json_encode($response);

 		}

         public function dofmodupdate_data() {
            $issqty = $this->input->post('issqty');
            $companyId = $this->input->post('companyId');
            $record_id= $this->input->post('record_id');
            $active=1;
            $entryMode='M';
    
    
             
         $data = array(
            'issue_qty' => $issqty 
            // Exclude 'id' and 'updated_by' fields
        );
    
    
     
    //var dump($data);
    
    $this->db->where('issue_no', $record_id);
    $this->db->update('scm_issue_hdr', $data);
    
    
      $response = array(
        'success' => true,
        'frameNo' => $record_id,
        'savedata'=> 'saved'
    );
    
            echo json_encode($response);
    
        }
    
        public function srissueupdate_data() {
           $itemcode = $this->input->post('itemcode');
           $companyId = $this->input->post('companyId');
           $gcode=substr($itemcode,0,3);
           $icode=substr($itemcode,3,5);
     //      echo $itemcode."<br>"; 
      //     echo $gcode."<br>";
       //    echo $icode."<br>";;
           $data = array(
            'inward' => 0,
            'sr_line_id' => 0,
           );
    
    
     
    //var dump($data);
    
    $this->db->where('company_id', $companyId);
    $this->db->where('group_code', $gcode);
    $this->db->where('item_code', $icode);
    $this->db->where('is_active',1);
    $this->db->update('scm_issue_hdr', $data);
    
           $sql=" select sih.*,round(issue_qty,3) issqty from scm_issue_hdr sih where  
           company_id =".$companyId." and is_active =1 
            and  issue_status in (3,1)   and concat(group_code,item_code)='".$itemcode."'  
            order by item_id,issue_date,issue_no asc";
     //     echo $sql;
            $records= $this->db->query($sql)->result_array();
        	$cnt=count($records);
			if ($cnt>0) {
                $srbqty=0;
                $stkqty=0;
                $psrid=0;
                $lsrbqty=0;

                foreach ($records as $record) {
                    $im=$record['item_id'];
                    $isqty=round($record['issqty'],3);
                    $isno=$record['issue_no'];
                    $hdr_id=$record['hdr_id'];
                    $issue_date=$record['issue_date'];
                    $deptcost=$record['deptcost'];
                    $group_code=$record['group_code'];
                    $item_code=$record['item_code'];
                    $is_active=$record['is_active'];
                    $dept_id=$record['dept_id'];
                    $expcode=$record['expcode'];
                    $fin_year=$record['fin_year'];
                    $company_seq_no=$record['company_seq_no'];
                    $issue_srl_no=	$record['issue_srl_no'];
                    $issue_value=$record['issue_value'];
                    $item_id=$record['item_id'];
                    $process_type_id=$record['process_type_id'];
                    $inward=$record['inward'];
                    $issue_status=$record['issue_status'];
                    $issue_type=$record['issue_type'] ;
                    $lot_no=$record['lot_no'] ;
                    $good_type=$record['good_type'] ;
                            
                    $uom_code=$record['uom_code'];
                    $indent_type_id=$record['indent_type_id'];
                    $project_id=$record['project_id'];
                    $branch_id=$record['branch_id'] ;		
                    $created_by=$record['created_by'] ;		
                    $machine_id=$record['machine_id'] ;		
                    $unit_id=$record['unit_id'] ;		
                    $issued_to=$record['issued_to'] ;		
                    $customer_id=$record['customer_id'] ;		
                    $req_quantity=$record['req_quantity'] ;		
                    $req_by=$record['req_by'] ;		
            
                    
                    $im=$record['item_id'];
                    $cmp=$record['company_id'];
                    $isno=$record['issue_no'];
                    $isqty=$record['issue_qty'];



                    $bisqty=0;
                    $sql1="select inward,inward_detail,tpmi.item,qty,round(balance_qty,3) balance_qty,
                    tpi.store_receipt_no,tpi.store_receipt_date 
                    from tbl_view_proc_material_inventory tpmi,tbl_proc_inward tpi 
                    where tpmi.inward=tpi.inward_id and  tpmi.item=$im and tpmi.sr_status =3 and round(balance_qty,3) >0  
                    and tpmi.company=$cmp order by store_receipt_date,inward_detail ASC 
                    limit 1";
                    $cdate = date('Y-m-d H:i:s');

   //                 echo $cdate.'-same-'.$isno.'='.$sql1;
                    $mrecords= $this->db->query($sql1)->result_array();
                    $cnt=count($mrecords);
                    if ($cnt>0) {
                        foreach ($mrecords as $mrecord) {
                            $minw=$mrecord['inward'];
                            $minwd=$mrecord['inward_detail'];
                            $bqty=round($mrecord['balance_qty'],3);
                            if 	($minw>0) {	
                //              $sql2="update scm_issue_hdr set material_inventory_id=$minv,inward=$minw,stock=$bisqty,req_by='$isno'   where issue_no=$isno";
echo $minw.'='.$minwd.'='.$minwd.'='.$mrecord['store_receipt_no'].'='.$mrecord['store_receipt_date'].'='.$bqty.'='.$isqty.'='.$issue_date."<br>";
//.
                                if ($bqty<$isqty) {
                                    $bisqty=$isqty-$bqty;     
                                    $isqty=$bqty;     
                                }

                                    $data = array(
                                    'inward' =>$minw,
                                    'sr_line_id' => $minwd,
                                    'issue_qty' => $isqty,
                                    'stock'=>$bqty
                                   );
                                   $this->db->where('issue_no', $isno);
                                   $this->db->update('scm_issue_hdr', $data);

                                if ($bisqty>0) {
/* start insert new record for balnace issue*/
                                    $sql1="select inward,inward_detail,tpmi.item,qty,round(balance_qty,3) balance_qty,
                                    tpi.store_receipt_no,tpi.store_receipt_date 
                                    from tbl_view_proc_material_inventory tpmi,tbl_proc_inward tpi 
                                    where tpmi.inward=tpi.inward_id and  tpmi.item=$im and tpmi.sr_status =3 and round(balance_qty,3) >0  
                                    and tpmi.company=$cmp order by store_receipt_date,inward_detail ASC 
                                    limit 1";
 //                             echo 'add-'.$sql1;
                                    $mrecords= $this->db->query($sql1)->result_array();
                                    $cnt=count($mrecords);
                                    if ($cnt>0) {
                                        foreach ($mrecords as $mrecord) {
                                            $minw=$mrecord['inward'];
                                            $minwd=$mrecord['inward_detail'];
                                            $bqty=round($mrecord['balance_qty'],3);
                                            if 	($minw>0) {	
                                                $data = array(
                                                    'company_id' =>$cmp,
                                                    'deptcost' => $deptcost,
                                                    'dept_id' => $dept_id,
                                                    'expcode' => $expcode,
                                                    'fin_year' => $fin_year,
                                                    'good_type' => $good_type,
                                                    'group_code' => $group_code,
                                                    'hdr_id' => $hdr_id,
                                                    'is_active' => $is_active,
                                                    'company_seq_no' => $company_seq_no,
                                                    'created_by' => $created_by,
                                                    'issue_date' => $issue_date,
                                                    'issue_srl_no' => $issue_srl_no,
                                                    'issue_value' => $issue_value,
                                                    'item_code' => $item_code,
                                                    'item_id' => $item_id,
                                                    'lot_no' => $lot_no,
                                                    'machine_id' => $machine_id,
                                                    'process_type_id' => $process_type_id,
                                                    'issue_qty' => $bisqty,
                                                    'sr_line_id' => $minwd,
                                                    'sr_no' => $minw,
                                                    'inward' => $minw,
                                                    'issue_status' => $issue_status,
                                                    'stock'=>$bqty,
                                                    'issue_type' => $issue_type,
                                                    'unit_id' => $unit_id,
                                                    'uom_code' => $uom_code,
                                                    'issued_to' => $issued_to,
                                                    'indent_type_id' => $indent_type_id,
                                                    'project_id' => $project_id,
                                                    'branch_id' => $branch_id,
                                                    'customer_id' => $customer_id,
                                                    'internal_note' => 'Add diff split',
                                                    'req_quantity' => $req_quantity,
                                                    'req_by' => $req_by,
                                                   );
                                                   $this->db->insert('scm_issue_hdr', $data);
    

                                            }
                                        }            
                                    }
                                }       
/* end */

                                   }



                                } 

                        }        
                    }    


                 }    
 
            
        
            $response = array(
                'success' => true,
                'frameNo' => $itemcode,
                'savedata'=> 'saved'
            );
            
                    echo json_encode($response);
         
        }
   
 


}