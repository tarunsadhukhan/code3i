<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Weaving_daily_entry extends CI_Controller {

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
        $this->load->model('Weaving_daily_data_Model'); // Load the model
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
		$this->load->model('Weaving_daily_data_Model');
 

 
		$this->load->view('admin/weaving/weaving_daily_entry');
		
	}

    public function get_spgdailydatarecords() {
        $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $date = $this->input->post('date');
        $compid = $this->input->post('companyId');
        $date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
        $sql="select tpwqm.*,wqm.quality_code,wqm.speed ,wqm.tpi  ,wqm.std_ozs_yds prd_std_ozs,
        wqm.finished_length fin_len,
        tpwqm.actual_shot ashots,
        wqm.tar_eff,wqm.yarn_count,'g' rem    from tbl_prod_weaving_quality_mapping tpwqm 
        left join weaving_quality_master wqm on tpwqm.quality_id  =wqm.quality_id 
        where mapping_date ='".$date."' and tpwqm.quality_type =1 and tpwqm.is_active =1
        and tpwqm.company_id =".$compid." order by quality_code";
        $records = $this->db->query($sql)->result_array();
        $cnt=count($records);
        foreach ($records as $record) {
            $qc=	$record['quality_code']	;
            $sqlq="select * from EMPMILL12.weaving_daily_transaction where tran_date ='".$date."' and company_id=".$compid."
            and q_code='".$qc."'";
            $recs = $this->db->query($sqlq)->result_array();
            $cntq=count($recs);
            if ($cntq==0) {
    
 

                $data = array(
                    'company_id' => $compid,
                    'tran_date' => $date,
                    'q_code' =>$record['quality_code'],
                    'ashots' =>$record['ashots'],
                     'tar_eff' =>$record['tar_eff'],
                    'mc_a' =>0,
                    'mc_b' =>0,
                    'mc_c' =>0,
                    'prd_a' =>0,
                    'prd_b' =>0,
                    'prd_c' =>0,
                    'actual_eff'=>0,
                    'actyds' =>0,
                    'taryds' =>0,
                    'actkgs' =>0,
                    'tarkgs' =>0,
                    'yds100' =>0,
                    'hrs_a' =>8.00,
                    'hrs_b' =>8.00,
                    'hrs_c' =>7.50,
                    'prd_std_ozs' =>0,
                     'aports' =>0,
                    'a_eff' =>0,
                    'actyds_ashots' =>0,
                    'fin_len' =>$record['fin_len'],
                    'yds_a' =>0,
                    'yds_b' =>0,
                    'yds_c' =>0,
                    'tar_eff' =>$record['fin_len'],
                    'tarprda' =>0,
                    'tarprdb' =>0,
                    'tarprdc' =>0,
     
                    // Exclude 'id' and 'updated_by' fields
                );
                $this->db->insert('EMPMILL12.weaving_daily_transaction', $data);
                        
    
            }
    
        }
    

        $sql="select wdt.company_id,  DATE_FORMAT(tran_date,'%d-%m-%Y') trandate,wdt.tran_date,wdt.q_code, 
        concat(wm.q_width,'-',wm.q_ports,'x',wm.q_shots,'/',wm.jbo_rbo ) quality,wdt.aports, wm.q_reed_space ,
        wm.q_speed ,wm.std_ozs_yds ,wdt.ashots , wdt.tar_eff ,wm.q_width ,wm.jbo_rbo,wdt.aports,
        wm.q_shots ,wm.q_ports,wm.q_shots,wdt.tar_eff, mc_a+mc_b+mc_c totloom,actkgs,
        case when (wdt.tarkgs>0) then (wdt.tarkgs /(wdt.mc_a+wdt.mc_b+wdt.mc_c)) else 0 end tarkglm ,
        case when (wdt.actkgs>0) then (wdt.actkgs /(wdt.mc_a+wdt.mc_b+wdt.mc_c)) else 0 end actkglm,a_eff, 
        hrs_a+hrs_b+hrs_c tothrs,hrs_a,hrs_b,hrs_c,mc_a,mc_b,mc_c,prd_a,prd_b,prd_c
         from EMPMILL12.weaving_daily_transaction wdt
        left join EMPMILL12.weaving_master wm on wdt.q_code =wm.q_code and wm.comp_id =wdt.company_id 
        where wdt.tran_date ='".$date."'  and wdt.company_id =".$compid." order by q_code";
        
        $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $records = $this->db->query($sql)->result_array();
     //	$query = $this->db->query($sql);
    //	$records= $query->result_array();
        $data = [];
        $cnt=count($records);
    //	echo $cnt;
    //	echo $sql;
        if ($cnt>0) {
            foreach ($records as $record) {
                $data[] = [
    //				$row['eb_no']	
                    $record['company_id'],
                    $record['trandate'],
                    $record['q_code'],
                    $record['quality'],
                    $record['std_ozs_yds'],
                    $record['q_ports'],
                    $record['q_reed_space'],
                    $record['q_width'],
                    $record['q_speed'],
                    $record['q_shots'],
                    $record['ashots'],
                    $record['tar_eff'],
                    $record['tarkglm'],
                    $record['totloom'],
                    $record['actkgs'],
                    $record['actkglm'],
                    $record['tothrs'],
                    $record['a_eff'],
                    $record['jbo_rbo'],
                    $record['hrs_a'],
                    $record['hrs_b'],
                    $record['hrs_c'],
                    $record['mc_a'],
                    $record['mc_b'],
                    $record['mc_c'],
                    $record['prd_a'],
                    $record['prd_b'],
                    $record['prd_c'],
                     $record['aports'],
  
                 ];
            }
        }
    
        
    //	$this->load->model('Doffdata_Model');
    //	$records = $this->Doffdata_Model->getspgqualityselData($date, $compid,$spgquality_id);
    //	$data = [];
    
        
    
    
    
        // Return the response
        echo json_encode(['data' => $data]);
    }
    
    public function savespgdaily_data() {

        $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
 
         

       $companyId=$this->input->post('companyId');
       $spgdailyDate=$this->input->post('spgdailyDate');
       $spgquality_id=$this->input->post('spgquality_id');
       $wvgwidth=$this->input->post('wvgwidth');
       $wvgport=$this->input->post('wvgport');
       $spgdailyahrs=$this->input->post('spgdailyahrs');
       $spgdailybhrs=$this->input->post('spgdailybhrs');
       $spgdailychrs=$this->input->post('spgdailychrs');
       $wvgshots=$this->input->post('wvgshots');
       $wvgrs=$this->input->post('wvgrs');
       $wvgozsyds=$this->input->post('wvgozsyds');
       $wvgjborbo=$this->input->post('wvgjborbo');
       $wvgashots=$this->input->post('wvgashots');
       $spgproda=$this->input->post('spgproda');
       $spgprodb=$this->input->post('spgprodb');
       $spgprodc=$this->input->post('spgprodc');
       $wvgfrma=$this->input->post('wvgfrma');
       $wvgfrmb=$this->input->post('wvgfrmb');
       $wvgfrmc=$this->input->post('wvgfrmc');
       $wvgaports=$this->input->post('wvgaports');
       $spgdailyDate=substr($spgdailyDate,6,4).'-'.substr($spgdailyDate,3,2).'-'.substr($spgdailyDate,0,2);
          $active=1;
  
          $sql="  SELECT * FROM EMPMILL12.weaving_master WHERE q_code='".$spgquality_id."'";
          $query = $this->db->query($sql);
          $records = $query->result();
          $name='';
          if ( $query->num_rows()>0 ) {
               $row1 = $query->row();
               $tef=$row1->target_eff;
               $flen= $row1->q_finish_length;
               $spd=$row1->q_speed;
               $mshots=$row1->q_shots;  
               $ozsyds=$row1->q_ozs_yds;
               $stdozsyds=$row1->std_ozs_yds;
            }	
/*  
              $flen=oci_result($s,"q_finish_length");
              $tef=oci_result($s,"TARGET_EFF");
              $spd=oci_result($s,"Q_SPEED");
              $mshots=oci_result($s,"Q_SHOTS");
                
               $ozsyds=oci_result($s,"Q_OZS_YDS");
              $sozsyds=oci_result($s,"STD_OZS_YDS");
 */         
  
    $tsft=0;
          $pmc=0;
          if ($wvgfrma>0) { 
              $pmc++;
              $tsft++;

          }
          if ($wvgfrmb>0) { 
          $pmc++;
          $tsft++;
        }
          if ($wvgfrmc>0) { 
          $pmc++;
          $tsft++;
        }
          $tfrm=$wvgfrma+$wvgfrmb+$wvgfrmc;
          $tfrmv=$tfrm/$pmc;
          $thrs=$spgdailyahrs+$spgdailybhrs+$spgdailychrs;
      
          $yds_a=$spgproda*$flen;
          $yds_b=$spgprodb*$flen;
          $yds_c=$spgprodc*$flen;
          
          //echo "Yards ".$yds_a." Fin Ln ".$flen." Cuts ".oci_result($s,"PRD_A");
          
         $tar_a =0;
         $tar_b =0;
         $tar_c =0;
         
          $actyds=$yds_a+$yds_b+$yds_c;
        if ($yds_a>0) {
          $tar_a=round(($spd*$spgdailyahrs*60*$wvgfrma*$tef)/(36*$wvgashots*100),0);
        }  
        if ($yds_b>0) {
            $tar_b=round(($spd*$spgdailybhrs*60*$wvgfrmb*$tef)/(36*$wvgashots*100),0);
        }    
        if ($yds_c>0) {
            $tar_c=round(($spd*$spgdailychrs*60*$wvgfrmc*$tef)/(36*$wvgashots*100),0);
        }    
          $taryds=$tar_a+$tar_b+$tar_c;
          $actkgs=round( ($ozsyds*$actyds*28.35)/1000,3);
          $sactkgs=round( ($ozsyds*$actyds*28.35)/1000,0);
      
          $yds100a=0;
          $yds100b=0;
          $yds100c=0;
          $actyds_as_a=0;
          $actyds_as_b=0;
          $actyds_as_c=0;
          if ($yds_a>0) {
            $yds100a=round(($spd*60*$spgdailyahrs*$wvgfrma)/(36*$wvgashots),0);
            $actyds_as_a=round(($spd*$spgdailyahrs*$wvgfrma*60)/(36*$wvgashots),0);
        } 
          if ($yds_b>0) {
            $yds100b=round(($spd*60*$spgdailybhrs*$wvgfrmb)/(36*$wvgashots),0);
            $actyds_as_b=round(($spd*$spgdailybhrs*$wvgfrmc*60)/(36*$wvgashots),0);
        }
          if ($yds_c>0) {
                $yds100c=round(($spd*60*$spgdailychrs*$wvgfrmc)/(36*$wvgashots),0);
                $actyds_as_c=round(($spd*$spgdailychrs*$wvgfrmc*60)/(36*$wvgashots),0);
            }
          $yds100=$yds100a+$yds100b+$yds100c;
          $tarkgs=round( ($taryds*$ozsyds) / (4408/125) ,3);
          $actyds_as=$actyds_as_a+$actyds_as_b+$actyds_as_c;
          $thrs=$spgdailyahrs+$spgdailybhrs+$spgdailychrs;
          
          $tmc=$wvgfrma+$wvgfrmb+$wvgfrmc;
          $yds100avg=round(($spd*60*$thrs*$tmc)/(36*$mshots*$tsft),0); 
       
          $acteff=round($actyds/$yds100avg*100,2);
          $a_eff=round($actyds/$yds100*100,2);
          $prdstdyds=0;
          if ($actyds_as >0 ) {
            $prdstdyds=round(($yds_a+$yds_b+$yds_c)*$stdozsyds*28.35/1000,0); 
          }    
          $tarkgs=round($taryds*$ozsyds/(4408/125),0); 

          $data = array(
           'mc_a' =>$wvgfrma,
           'mc_b' =>$wvgfrmb,
           'mc_c' =>$wvgfrmc,
           'prd_a' =>$spgproda,
           'prd_b' =>$spgprodb,
           'prd_c' =>$spgprodc,
           'actual_eff' =>$acteff,
           'actyds' =>$actyds,
           'taryds' =>$taryds,
           'actkgs' =>$actkgs,
           'tarkgs' =>$tarkgs,
           'yds100' =>$yds100,
           'hrs_a' =>$spgdailyahrs,
           'hrs_b' =>$spgdailybhrs,
           'hrs_c' =>$spgdailychrs,
           'prd_std_ozs' =>$prdstdyds,
           'ashots' =>$wvgashots,
           'aports' =>$wvgaports,
           'a_eff' =>$a_eff,
           'fin_len' =>$flen,
           'yds_a' =>$yds_a,
           'yds_b' =>$yds_b,
           'yds_c' =>$yds_c,
           'actyds_ashots' =>$actyds_as,
           'tar_eff' =>$tef,
           'tarprda' =>$yds100a,
           'tarprdb' =>$yds100b,
           'tarprdc' =>$yds100c
   
   
           // Exclude 'id' and 'updated_by' fields
       );
   //	$otherdb->insert('spining_daily_transaction', $data);
   
            $this->db->where('q_code', $spgquality_id)
           ->where('company_id', $companyId)
           ->where('tran_date', $spgdailyDate) // Replace 'date_column' with the actual name of your date column
           ->update('EMPMILL12.weaving_daily_transaction', $data);
   
            $data =[];
   
     $response = array(
       'success' => true,
       'frameNo' => $spgdailyDate,
       'savedata'=> 'saved'
   );
   
   $frameNo='';        
   echo json_encode($response);
   
   
      }
   
       public function exportspgdailydata() {
        $sdate = $this->input->post('spgdailyDate');
        $compid = $this->input->post('companyId');
        $sdate = $this->input->get('spgdailyDate');
        $compid = $this->input->get('companyId');
        $sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
        $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
	
        $sql="SELECT a.*,b.*,date_format(a.tran_date,'%d-%m-%Y') trandate FROM EMPMILL12.weaving_daily_transaction a LEFT JOIN EMPMILL12.weaving_master 
        b ON a.q_code=b.q_code WHERE a.tran_date='".$sdate."' and company_id=".$compid." ORDER BY a.q_code ASC";
		$query = $this->db->query($sql);
		$data = $query->result_array();

$tot_hurs=0;
$fileContainer = "data.ebq";
$filePointer = fopen($fileContainer,"w+");

 $logMsg='';

foreach ($data as $row) {
        $issue_date=$row['trandate'];
        $quality_code=$row['q_code'];
        $frame_a=$row['mc_a'];
        $frame_b=$row['mc_b'];
        $frame_c=$row['mc_c'];
        $prod_a=$row['prd_a'];
        $prod_b=$row['prd_b'];
        $prod_c=$row['prd_c'];
        $acef=$row['actual_eff'];
        $actyds=$row['actyds'];
        $taryds=$row['taryds'];
        $actkgs=$row['actkgs'];
        $tarkgs=$row['tarkgs'];
        $yds100=$row['yds100'];
        $hrs_a=$row['hrs_a'];
        $hrs_b=$row['hrs_b'];
        $hrs_c=$row['hrs_c'];
        $prdstdozs=$row['prd_std_ozs'];
        $ashots=$row['ashots'];
        $aports=$row['aports'];
        $aef=$row['a_eff']; 
        $acshots=$row['actyds_ashots'];
        $finlen=$row['fin_len'];
        $yds_a=$row['yds_a'];
        $yds_b=$row['yds_b'];
        $yds_c=$row['yds_c'];
        $tar_eff=$row['tar_eff'];
        $tprod_a=$row['tarprda'];
        $tprod_b=$row['tarprdb'];
        $tprod_c=$row['tarprdc'];
        
        $tot_hrs=$hrs_a+$hrs_b+$hrs_c;
        
        
        
        
        $logMsg.= $issue_date.",0,".$quality_code.",".$frame_a.",".$frame_b.",".$frame_c.",".$prod_a.",".$prod_b.",".$prod_c
        .",".$tar_eff.",".$acef.",".$actyds.",".$taryds.",".$actkgs.",".$tarkgs.",".$yds100.",".$tot_hrs
        .",".$prdstdozs.",".$hrs_a.",".$hrs_b.",".$hrs_c.",".$ashots.",".$aef.",".$acshots.",".$finlen.",".$yds_a
        .",".$yds_b.",".$yds_c.","."123,,".",".$aports."\r\n";
        
        
        
    
        $tot_hurs=0;
}
        
            fputs($filePointer,$logMsg);
            fclose($filePointer);
    
         
    /*
            header('Content-Type: application/x-www-form-urlencoded');
            header('Content-Transfer-Encoding: Binary');
            header("Content-disposition: attachment; filename=\"".$fileContainer."\"");
            readfile($fileContainer);
            unlink($fileContainer);
    */
    $txt1="data.ebq";
    $txt2="data2.ebq";
     
    $files = array($txt1);
    $zipname = 'wvgdata.zip';
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    foreach ($files as $file) {
      $zip->addFile($file);
    }
    $zip->close();
    
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$zipname);
    header('Content-Length: ' . filesize($zipname));
    readfile($zipname);
    
            unlink($fileContainer);
            unlink($zipname);
    
    
    
        }
    
       
        public function updatelmebqc_data() {
            $doffdate = $this->input->post('spgdailyDate');
            $companyId = $this->input->post('companyId');
            $created_by=26577;
            $active=1;
            $doffdate=substr($doffdate,6,4).'-'.substr($doffdate,3,2).'-'.substr($doffdate,0,2);
            $qcstarttime=date("h:i:s");
            $this->db->trans_start();
          
//A1        
        $this->db->select('da.attendance_date, d.spell, d.eb_id, d.eb_no, d.mc_id, (da.working_hours - da.idle_hours) AS whrs');
        $this->db->from('daily_ebmc_attendance d');
        $this->db->join('daily_attendance da', 'd.daily_atten_id = da.daily_atten_id', 'LEFT');
        $this->db->join('mechine_master mm', 'd.mc_id = mm.mechine_id AND mm.type_of_mechine = 7', 'LEFT');
        $this->db->where('d.is_active', 1);
        $this->db->where('da.is_active', 1);
        $this->db->where('d.attendace_date', $doffdate);
        $this->db->where('da.attendance_date', $doffdate);
        $this->db->where('d.company_id', 2);
        $this->db->where('da.company_id', 2);
        $this->db->where('da.spell', 'A1');
        $this->db->where('d.spell', 'A1');
        $query = $this->db->get();
        $records = $query->result();
        $cnt=count($records);
    //    echo 'a1'.$cnt;
    if ($cnt>0) {  
        $case_expression = 'CASE ';
        $case_expressionw = 'CASE ';
        foreach ($records as $update_data) {
            $doffdate = $doffdate;
            $spell = $update_data->spell;
            $frameno = $update_data->mc_id;
            //$update_data['mc_id'];
     //       $q_code =$update_data->quality_code; 
     //       $ashots=$update_data->actual_shot; 
            $eb_no = $update_data->eb_no;
            $whrs= $update_data->whrs;
            $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$eb_no}' ";
            $case_expressionw .= "WHEN loom_date = '{$doffdate}' AND loom_id = '{$frameno}' THEN '{$whrs}' ";
        }
            $case_expression .= 'ELSE ticket_no_a1 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET ticket_no_a1 = {$case_expression} WHERE company_id = {$companyId}");
            $case_expressionw .= 'ELSE working_hrs_a1 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET working_hrs_a1 = {$case_expressionw} WHERE company_id = {$companyId}");
    }
//A2
$this->db->select('da.attendance_date, d.spell, d.eb_id, d.eb_no, d.mc_id, (da.working_hours - da.idle_hours) AS whrs');
$this->db->from('daily_ebmc_attendance d');
$this->db->join('daily_attendance da', 'd.daily_atten_id = da.daily_atten_id', 'LEFT');
$this->db->join('mechine_master mm', 'd.mc_id = mm.mechine_id AND mm.type_of_mechine = 7', 'LEFT');
$this->db->where('d.is_active', 1);
$this->db->where('da.is_active', 1);
$this->db->where('d.attendace_date', $doffdate);
$this->db->where('da.attendance_date', $doffdate);
$this->db->where('d.company_id', 2);
$this->db->where('da.company_id', 2);
$this->db->where('da.spell', 'A2');
$this->db->where('d.spell', 'A2');
$query = $this->db->get();
$records = $query->result();
$cnt=count($records);
//echo 'a1'.$cnt;
if ($cnt>0) {  
$case_expression = 'CASE ';
$case_expressionw = 'CASE ';
foreach ($records as $update_data) {
    $doffdate = $doffdate;
    $spell = $update_data->spell;
    $frameno = $update_data->mc_id;
    //$update_data['mc_id'];
//       $q_code =$update_data->quality_code; 
//       $ashots=$update_data->actual_shot; 
    $eb_no = $update_data->eb_no;
    $whrs= $update_data->whrs;
    $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$eb_no}' ";
    $case_expressionw .= "WHEN loom_date = '{$doffdate}' AND loom_id = '{$frameno}' THEN '{$whrs}' ";
}
            $case_expression .= 'ELSE ticket_no_a2 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET ticket_no_a2 = {$case_expression} WHERE company_id = {$companyId}");
            $case_expressionw .= 'ELSE working_hrs_a2 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET working_hrs_a2 = {$case_expressionw} WHERE company_id = {$companyId}");
}
//B1
$this->db->select('da.attendance_date, d.spell, d.eb_id, d.eb_no, d.mc_id, (da.working_hours - da.idle_hours) AS whrs');
$this->db->from('daily_ebmc_attendance d');
$this->db->join('daily_attendance da', 'd.daily_atten_id = da.daily_atten_id', 'LEFT');
$this->db->join('mechine_master mm', 'd.mc_id = mm.mechine_id AND mm.type_of_mechine = 7', 'LEFT');
$this->db->where('d.is_active', 1);
$this->db->where('da.is_active', 1);
$this->db->where('d.attendace_date', $doffdate);
$this->db->where('da.attendance_date', $doffdate);
$this->db->where('d.company_id', 2);
$this->db->where('da.company_id', 2);
$this->db->where('da.spell', 'B1');
$this->db->where('d.spell', 'B1');
$query = $this->db->get();
$records = $query->result();
$cnt=count($records);
//echo 'a1'.$cnt;
if ($cnt>0) {  
$case_expression = 'CASE ';
$case_expressionw = 'CASE ';
foreach ($records as $update_data) {
    $doffdate = $doffdate;
    $spell = $update_data->spell;
    $frameno = $update_data->mc_id;
    //$update_data['mc_id'];
//       $q_code =$update_data->quality_code; 
//       $ashots=$update_data->actual_shot; 
    $eb_no = $update_data->eb_no;
    $whrs= $update_data->whrs;
    $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$eb_no}' ";
    $case_expressionw .= "WHEN loom_date = '{$doffdate}' AND loom_id = '{$frameno}' THEN '{$whrs}' ";
}
            $case_expression .= 'ELSE ticket_no_b1 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET ticket_no_b1 = {$case_expression} WHERE company_id = {$companyId}");
            $case_expressionw .= 'ELSE working_hrs_b1 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET working_hrs_b1 = {$case_expressionw} WHERE company_id = {$companyId}");
}
//B2
$this->db->select('da.attendance_date, d.spell, d.eb_id, d.eb_no, d.mc_id, (da.working_hours - da.idle_hours) AS whrs');
$this->db->from('daily_ebmc_attendance d');
$this->db->join('daily_attendance da', 'd.daily_atten_id = da.daily_atten_id', 'LEFT');
$this->db->join('mechine_master mm', 'd.mc_id = mm.mechine_id AND mm.type_of_mechine = 7', 'LEFT');
$this->db->where('d.is_active', 1);
$this->db->where('da.is_active', 1);
$this->db->where('d.attendace_date', $doffdate);
$this->db->where('da.attendance_date', $doffdate);
$this->db->where('d.company_id', 2);
$this->db->where('da.company_id', 2);
$this->db->where('da.spell', 'B2');
$this->db->where('d.spell', 'B2');
$query = $this->db->get();
$records = $query->result();
$cnt=count($records);
//echo 'a1'.$cnt;
if ($cnt>0) {  
$case_expression = 'CASE ';
$case_expressionw = 'CASE ';
foreach ($records as $update_data) {
    $doffdate = $doffdate;
    $spell = $update_data->spell;
    $frameno = $update_data->mc_id;
    //$update_data['mc_id'];
//       $q_code =$update_data->quality_code; 
//       $ashots=$update_data->actual_shot; 
    $eb_no = $update_data->eb_no;
    $whrs= $update_data->whrs;
    $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$eb_no}' ";
    $case_expressionw .= "WHEN loom_date = '{$doffdate}' AND loom_id = '{$frameno}' THEN '{$whrs}' ";
}
            $case_expression .= 'ELSE ticket_no_b2 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET ticket_no_b2 = {$case_expression} WHERE company_id = {$companyId}");
            $case_expressionw .= 'ELSE working_hrs_b2 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET working_hrs_b2 = {$case_expressionw} WHERE company_id = {$companyId}");
}
//C
$this->db->select('da.attendance_date, d.spell, d.eb_id, d.eb_no, d.mc_id, (da.working_hours - da.idle_hours) AS whrs');
$this->db->from('daily_ebmc_attendance d');
$this->db->join('daily_attendance da', 'd.daily_atten_id = da.daily_atten_id', 'LEFT');
$this->db->join('mechine_master mm', 'd.mc_id = mm.mechine_id AND mm.type_of_mechine = 7', 'LEFT');
$this->db->where('d.is_active', 1);
$this->db->where('da.is_active', 1);
$this->db->where('d.attendace_date', $doffdate);
$this->db->where('da.attendance_date', $doffdate);
$this->db->where('d.company_id', 2);
$this->db->where('da.company_id', 2);
$this->db->where('da.spell', 'C');
$this->db->where('d.spell', 'C');
$query = $this->db->get();
$records = $query->result();
$cnt=count($records);
//echo 'a1'.$cnt;
if ($cnt>0) {  
$case_expression = 'CASE ';
$case_expressionw = 'CASE ';
foreach ($records as $update_data) {
    $doffdate = $doffdate;
    $spell = $update_data->spell;
    $frameno = $update_data->mc_id;
    //$update_data['mc_id'];
//       $q_code =$update_data->quality_code; 
//       $ashots=$update_data->actual_shot; 
    $eb_no = $update_data->eb_no;
    $whrs= $update_data->whrs;
    $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$eb_no}' ";
    $case_expressionw .= "WHEN loom_date = '{$doffdate}' AND loom_id = '{$frameno}' THEN '{$whrs}' ";
}
    $case_expression .= 'ELSE ticket_no_c END';
    $this->db->query("UPDATE cuts_jugar_buff_1 SET ticket_no_c = {$case_expression} WHERE company_id = {$companyId}");
    $case_expressionw .= 'ELSE working_hrs_c END';
    $this->db->query("UPDATE cuts_jugar_buff_1 SET working_hrs_c = {$case_expressionw} WHERE company_id = {$companyId}");
}
        // Commit the transaction
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            // Handle transaction error if needed.
        }
         
         
         
        $qcendtime=date("h:i:s");
          
        
        
         //	$this->db->insert('spinning_yarn_type_daily', $data);
        
         $response = array(
            'success' => true,
            'doffdate' => $doffdate,
            'qcstarttime' => $qcstarttime,
            'qcendtime' => $qcendtime,
            'savedata'=> 'saved'
            );
            
            echo json_encode($response);
        
        
        }
        public function updatelmqc_data() {
            $doffdate = $this->input->post('spgdailyDate');
            $companyId = $this->input->post('companyId');
            $created_by=26577;
            $active=1;
            $doffdate=substr($doffdate,6,4).'-'.substr($doffdate,3,2).'-'.substr($doffdate,0,2);
            $qcstarttime=date("h:i:s");
            $this->db->trans_start();
            
//A1
        $this->db->select('wqm.quality_code, dwq.mc_id, actual_shot, dwq.wv_qual_date, dwq.spell,wqm.finished_length');
        $this->db->from('daily_weaving_qualities dwq');
        $this->db->join('weaving_quality_master wqm', 'dwq.quality_code = wqm.quality_code and dwq.company_id = wqm.company_id', 'left');
        $this->db->join('(select * from tbl_prod_weaving_quality_mapping tpwqm where mapping_date = "'.$doffdate.'" 
        and quality_type = 1 and is_active = 1) tpwqm', 'wqm.quality_id = tpwqm.quality_id and dwq.wv_qual_date = tpwqm.mapping_date', 'left');
        $this->db->where('dwq.is_active', 1);
        $this->db->where('dwq.wv_qual_date', $doffdate);
        $this->db->where('dwq.company_id', 2);
        $this->db->where('dwq.spell', 'A1');
        $query = $this->db->get();
    //    echo $this->db->last_query();
        $records = $query->result();
        $cnt=count($records);
    //    echo 'a1'.$cnt;
    if ($cnt>0) {  
        $case_expression = 'CASE ';
        $case_expressionw = 'CASE ';
        $case_expressionf = 'CASE ';
        foreach ($records as $update_data) {
            $doffdate = $doffdate;
            $spell = $update_data->spell;
            $frameno = $update_data->mc_id;
            $q_code =$update_data->quality_code; 
            $ashots=$update_data->actual_shot; 
            $flen=$update_data->finished_length; 
            //  echo $frameno.'-'.$spell.'-'.$q_code.'-'.$ashots;
            $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$q_code}' ";
            $case_expressionw .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$ashots}' ";
            $case_expressionf .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$flen}' ";
        }
        // Update the dofftable using the CASE expression
            $case_expression .= 'ELSE quality_code_a1 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET quality_code_a1 = {$case_expression} WHERE company_id = {$companyId}");
            $case_expressionw .= 'ELSE actual_shots_a1 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET actual_shots_a1 = {$case_expressionw} WHERE company_id = {$companyId}");
    }
            //B1
        $this->db->select('wqm.quality_code, dwq.mc_id, actual_shot, dwq.wv_qual_date, dwq.spell');
        $this->db->from('daily_weaving_qualities dwq');
        $this->db->join('weaving_quality_master wqm', 'dwq.quality_code = wqm.quality_code and dwq.company_id = wqm.company_id', 'left');
        $this->db->join('(select * from tbl_prod_weaving_quality_mapping tpwqm where mapping_date = "'.$doffdate.'" 
        and quality_type = 1 and is_active = 1) tpwqm', 'wqm.quality_id = tpwqm.quality_id and dwq.wv_qual_date = tpwqm.mapping_date', 'left');
        $this->db->where('dwq.is_active', 1);
        $this->db->where('dwq.wv_qual_date', $doffdate);
        $this->db->where('dwq.company_id', 2);
        $this->db->where('dwq.spell', 'B1');
        $query = $this->db->get();
        
        $records = $query->result();
        $cnt=count($records);
    //    echo 'b1'.$cnt;
        if ($cnt>0) {  
        
        $case_expression = 'CASE ';
        $case_expressionw = 'CASE ';
        foreach ($records as $update_data) {
            $doffdate = $doffdate;
            $spell = $update_data->spell;
            $frameno = $update_data->mc_id;
            $q_code =$update_data->quality_code; 
            $ashots=$update_data->actual_shot; 
          //  echo $frameno.'-'.$spell.'-'.$q_code.'-'.$ashots;
            $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$q_code}' ";
            $case_expressionw .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$ashots}' ";
        }
        // Update the dofftable using the CASE expression
        $case_expression .= 'ELSE quality_code_b1 END';
        $this->db->query("UPDATE cuts_jugar_buff_1 SET quality_code_b1 = {$case_expression} WHERE company_id = {$companyId}");
        $case_expressionw .= 'ELSE actual_shots_b1 END';
        $this->db->query("UPDATE cuts_jugar_buff_1 SET actual_shots_b1 = {$case_expressionw} WHERE company_id = {$companyId}");
        }    
        //A2
        $this->db->select('wqm.quality_code, dwq.mc_id, actual_shot, dwq.wv_qual_date, dwq.spell');
        $this->db->from('daily_weaving_qualities dwq');
        $this->db->join('weaving_quality_master wqm', 'dwq.quality_code = wqm.quality_code and dwq.company_id = wqm.company_id', 'left');
        $this->db->join('(select * from tbl_prod_weaving_quality_mapping tpwqm where mapping_date = "'.$doffdate.'" 
        and quality_type = 1 and is_active = 1) tpwqm', 'wqm.quality_id = tpwqm.quality_id and dwq.wv_qual_date = tpwqm.mapping_date', 'left');
        $this->db->where('dwq.is_active', 1);
        $this->db->where('dwq.wv_qual_date', $doffdate);
        $this->db->where('dwq.company_id', 2);
        $this->db->where('dwq.spell', 'A2');
        $query = $this->db->get();
        $records = $query->result();
        $cnt=count($records);
        //echo 'a2'.$cnt;
if ($cnt>0) {  

        $case_expression = 'CASE ';
        $case_expressionw = 'CASE ';
        foreach ($records as $update_data) {
            $doffdate = $doffdate;
            $spell = $update_data->spell;
            $frameno = $update_data->mc_id;
            $q_code =$update_data->quality_code; 
            $ashots=$update_data->actual_shot; 
          //  echo $frameno.'-'.$spell.'-'.$q_code.'-'.$ashots;
            $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$q_code}' ";
            $case_expressionw .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$ashots}' ";
        }
        $case_expression .= 'ELSE quality_code_a2 END';
        $this->db->query("UPDATE cuts_jugar_buff_1 SET quality_code_a2 = {$case_expression} WHERE company_id = {$companyId}");
        $case_expressionw .= 'ELSE actual_shots_a2 END';
        $this->db->query("UPDATE cuts_jugar_buff_1 SET actual_shots_a2 = {$case_expressionw} WHERE company_id = {$companyId}");
    }
    //B2
    $this->db->select('wqm.quality_code, dwq.mc_id, actual_shot, dwq.wv_qual_date, dwq.spell');
    $this->db->from('daily_weaving_qualities dwq');
    $this->db->join('weaving_quality_master wqm', 'dwq.quality_code = wqm.quality_code and dwq.company_id = wqm.company_id', 'left');
    $this->db->join('(select * from tbl_prod_weaving_quality_mapping tpwqm where mapping_date = "'.$doffdate.'" 
    and quality_type = 1 and is_active = 1) tpwqm', 'wqm.quality_id = tpwqm.quality_id and dwq.wv_qual_date = tpwqm.mapping_date', 'left');
    $this->db->where('dwq.is_active', 1);
    $this->db->where('dwq.wv_qual_date', $doffdate);
    $this->db->where('dwq.company_id', 2);
    $this->db->where('dwq.spell', 'B2');
    $query = $this->db->get();
    $records = $query->result();
    $cnt=count($records);
//echo 'b2'.$cnt;
if ($cnt>0) {  
    $case_expression = 'CASE ';
        $case_expressionw = 'CASE ';
        foreach ($records as $update_data) {
            $doffdate = $doffdate;
            $spell = $update_data->spell;
            $frameno = $update_data->mc_id;
            $q_code =$update_data->quality_code; 
            $ashots=$update_data->actual_shot; 
          //  echo $frameno.'-'.$spell.'-'.$q_code.'-'.$ashots;
            $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$q_code}' ";
            $case_expressionw .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$ashots}' ";
        }
            $case_expression .= 'ELSE quality_code_b2 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET quality_code_b2 = {$case_expression} WHERE company_id = {$companyId}");
            $case_expressionw .= 'ELSE actual_shots_b2 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET actual_shots_b2 = {$case_expressionw} WHERE company_id = {$companyId}");
    }
    //C
        $this->db->select('wqm.quality_code, dwq.mc_id, actual_shot, dwq.wv_qual_date, dwq.spell');
        $this->db->from('daily_weaving_qualities dwq');
        $this->db->join('weaving_quality_master wqm', 'dwq.quality_code = wqm.quality_code and dwq.company_id = wqm.company_id', 'left');
        $this->db->join('(select * from tbl_prod_weaving_quality_mapping tpwqm where mapping_date = "'.$doffdate.'" 
        and quality_type = 1 and is_active = 1) tpwqm', 'wqm.quality_id = tpwqm.quality_id and dwq.wv_qual_date = tpwqm.mapping_date', 'left');
        $this->db->where('dwq.is_active', 1);
        $this->db->where('dwq.wv_qual_date', $doffdate);
            $this->db->where('dwq.company_id', 2);
        $this->db->where('dwq.spell', 'C');
        $query = $this->db->get();
        $records = $query->result();
        $cnt=count($records);
    //    echo 'c'.$cnt;
        if ($cnt>0) {  
            $case_expression = 'CASE ';
        $case_expressionw = 'CASE ';
        foreach ($records as $update_data) {
            $doffdate = $doffdate;
            $spell = $update_data->spell;
            $frameno = $update_data->mc_id;
            $q_code =$update_data->quality_code; 
            $ashots=$update_data->actual_shot; 
          //  echo $frameno.'-'.$spell.'-'.$q_code.'-'.$ashots;
            $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$q_code}' ";
            $case_expressionw .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$ashots}' ";
        }
            $case_expression .= 'ELSE quality_code_c END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET quality_code_c = {$case_expression} WHERE company_id = {$companyId}");
            $case_expressionw .= 'ELSE actual_shots_c END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET actual_shots_c = {$case_expressionw} WHERE company_id = {$companyId}");
        }
                    // Commit the transaction
   //     echo $this->db->last_query();
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            // Handle transaction error if needed.
        }
 
          
          
         
         
        $qcendtime=date("h:i:s");
          
        
        
         //	$this->db->insert('spinning_yarn_type_daily', $data);
        
        $response = array(
        'success' => true,
        'doffdate' => $doffdate,
        'qcstarttime' => $qcstarttime,
        'qcendtime' => $qcendtime,
        'savedata'=> 'saved'
        );
        
            echo json_encode($response);
        
        
        }
        
        public function updatelmopen_data() {
            $doffdate = $this->input->post('spgdailyDate');
            $companyId = $this->input->post('companyId');
            $created_by=26577;
            $active=1;
            $doffdate=substr($doffdate,6,4).'-'.substr($doffdate,3,2).'-'.substr($doffdate,0,2);
            $qcstarttime=date("h:i:s");
            $this->db->trans_start();
        
        $sql="select loom_date,loom_id,ifnull(close_c,0) clc  from  cuts_jugar_buff_1 cjb 
        where loom_date = (select max(loom_date) lmdate from cuts_jugar_buff_1 where loom_date<'".$doffdate."')  and company_id=".$companyId;

        //  echo $sql;
//        $query = $this->db->get($sql);
        $query = $this->db->query($sql);
        $records = $query->result();
        $cnt=count($records);
    if ($cnt>0) { 
        $case_expression = 'CASE ';
        foreach ($records as $update_data) {
            $doffdate = $doffdate;
            $frameno = $update_data->loom_id;
            $closqty =$update_data->clc; 
          //  echo $frameno.'-'.$spell.'-'.$q_code.'-'.$ashots;
            $case_expression .= "WHEN loom_date = '{$doffdate}'  AND loom_id = '{$frameno}' THEN '{$closqty}' ";
        }
        // Update the dofftable using the CASE expression
            $case_expression .= 'ELSE open_a1 END';
            $this->db->query("UPDATE cuts_jugar_buff_1 SET open_a1 = {$case_expression} WHERE company_id = {$companyId}");
    }
        // Commit the transaction
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            // Handle transaction error if needed.
        }
        $sql="update cuts_jugar_buff_1 set 
        close_a1=(case when jugar_a1>0 then jugar_a1 else open_a1 end) ,
        close_b1=(case when jugar_b1>0 then jugar_b1 else open_b1 end) ,
        close_a2=(case when jugar_a2>0 then jugar_a2 else open_a2 end) ,
        close_b2=(case when jugar_b2>0 then jugar_b2 else open_b2 end) ,
        close_c=(case when jugar_c>0 then jugar_c else open_c end) 
        where loom_date='".$doffdate."' and company_id=".$companyId;
        $this->db->query($sql);
        
        $qcendtime=date("h:i:s");
 
        
        $response = array(
            'success' => true,
            'doffdate' => $doffdate,
            'qcstarttime' => $qcstarttime,
            'qcendtime' => $qcendtime,
            'savedata'=> 'saved'
            );
            
            echo json_encode($response);
        
        
        }



}