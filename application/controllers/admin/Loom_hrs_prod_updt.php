<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Loom_hrs_prod_updt extends CI_Controller {

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
		$this->load->model('Winding_doff_Model');
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
 
        $lmmcdata=$this->Weaving_daily_data_Model->getlmmcdata();
//        echo 'anana';
//        var_dump($lmmcdata)    ;
        $data['lmmcdata']=$lmmcdata;
 //       echo lamma;    
        		$wndmcdata=$this->Winding_doff_Model->getwndmcnodata();
		$data['wndmcdata']=$wndmcdata;
	$data_to_pass['data'] = $data;
	

 
		$this->load->view('admin/weaving/Loom_hrs_prod_updt', $data_to_pass);
		
	}

    public function get_loomhoursprodrecords() {

        $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $date = $this->input->post('date');
        $shiftName = $this->input->post('shiftName');
        $loomid = $this->input->post('loomid');
        
        //echo $date.'==='.$shiftName;
        $compid = $this->input->post('companyId');
        $date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
        $sql="select cjb.cj_buff1_id ,loom_date,'$shiftName' spell,mm.mech_code,cjb.ticket_no_$shiftName ebno,
        CONCAT(wm.worker_name, ' ', wm.worker_name, ' ', wm.last_name) AS emp_name,
        cjb.cuts_$shiftName cuts,cjb.jugar_$shiftName jugar,
        cjb.production_$shiftName prod,
        cjb.efficiency_$shiftName effc,ifnull(cjb.less_production_$shiftName,0) lessprod,da.working_hours-da.idle_hours whrs ,
        ifnull(dea.mc_stoppage_hours,0) mcstop,ifnull(dea.dtl_rec_id,0) dtl_rec_id   from cuts_jugar_buff_1 cjb 
        left join mechine_master mm on mm.mechine_id =cjb.loom_id
        left join daily_attendance da on da.eb_no =cjb.ticket_no_$shiftName and da.attendance_date =cjb.loom_date and da.spell ='$shiftName' and da.is_active =1
        left join daily_ebmc_attendance dea on dea.daily_atten_id =da.daily_atten_id and dea.is_active =1 and dea.mc_id =cjb.loom_id 
        left join worker_master wm on da.eb_no =wm.eb_no and da.company_id =wm.company_id 
        where cjb.loom_date ='$date' and cjb.company_id =$compid and cjb.loom_id=$loomid";

      //  echo $sql;
        $records = $this->db->query($sql)->result_array();
        $data = [];
        $cnt=count($records);
            foreach ($records as $record) {
                $data[] = [
                    $record['cj_buff1_id'],
                    $record['dtl_rec_id'],
                    $record['loom_date'],
                    $record['mech_code'],
                    $record['ebno'],
                    $record['ebno'],
                    $record['cuts'],
                    $record['jugar'],
                    $record['prod'],
                    $record['effc'],
                    $record['whrs'],
                    $record['mcstop'],
                    $record['lessprod'],
                    $record['spell'],

                ];

                    // Exclude 'id' and 'updated_by' fields
    
            }
        echo json_encode(['data' => $data]);
 

    }    




    public function get_spgdailydatarecords() {
        $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $date = $this->input->post('date');
        $shiftName = $this->input->post('shiftName');
//echo $date;
        $compid = $this->input->post('companyId');
        $date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
        $sql="select cjb.cj_buff1_id ,loom_date,'A1' spell,mm.mech_code,cjb.ticket_no_.$shiftName ebno,CONCAT(wm.worker_name, ' ', wm.worker_name, ' ', wm.last_name) AS emp_name,
        cjb.cuts_.$shiftName cuts,cjb.jugar_.$shiftName jugar,
        cjb.production_a1 prod,
        cjb.efficiency_a1 effc,ifnull(cjb.less_production_A1,0) lessprod,da.working_hours-da.idle_hours whrs ,
        ifnull(dea.mc_stoppage_hours,0) mcstop,dea.dtl_rec_id  from cuts_jugar_buff_1 cjb 
        left join mechine_master mm on mm.mechine_id =cjb.loom_id
        left join daily_attendance da on da.eb_no =cjb.ticket_no_a1 and da.attendance_date =cjb.loom_date and da.spell ='$shiftName' and da.is_active =1
        left join daily_ebmc_attendance dea on dea.daily_atten_id =da.daily_atten_id and dea.is_active =1 and dea.mc_id =cjb.loom_id 
        left join worker_master wm on da.eb_no =wm.eb_no and da.company_id =wm.company_id 
        where cjb.loom_date ='$date' and cjb.company_id =$compid";

        echo $sql;
        $records = $this->db->query($sql)->result_array();
        $cnt=count($records);
            foreach ($records as $record) {
                $data[] = [
                    $record['cj_buff1_id'],
                    $record['dtl_rec_id'],
                    $record['loom_date'],
                    $record['mech_code'],
                    $record['ebno'],
                    $record['ebno'],
                    $record['cuts'],
                    $record['jugar'],
                    $record['prod'],
                    $record['effc'],
                    $record['whrs'],
                    $record['mcstop'],
                    $record['lessprod'],

                ];

                    // Exclude 'id' and 'updated_by' fields
    
            }
//    var_dump($data);
    
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
    
       
        public function updateloomdata() {
            $bufferid = $this->input->post('bufferid');
            $record_id = $this->input->post('record_id');
            
            $mcstop = $this->input->post('mcstop');
            $lessprod = $this->input->post('lessprod');
            $shiftName = $this->input->post('shiftName');
            $lessProdCol = 'less_production_' . $shiftName;

            $this->db->trans_start();

            $bData = [];
            $bData[$lessProdCol] = $lessprod;

            $this->db->where('cj_buff1_id', $bufferid)
            ->update('cuts_jugar_buff_1', $bData);

//            echo $this->db->last_query();

            $aData = [];
            $aData['mc_stoppage_hours'] = $mcstop;

            $this->db->where('dtl_rec_id', $record_id)
            ->update('daily_ebmc_attendance', $aData);

        $this->db->trans_complete();


         
         $response = array(
            'success' => true,
            'mechcode' => 'mechcode',
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


	public function getmccode() {
        $mcshrcd = $this->input->post('mcshrcd');
        $companyId = $this->input->post('companyId');
		$records = $this->Weaving_daily_data_Model->getmccode($companyId,$mcshrcd);
     //   $cnt=count($records);
        $mcid=0;
           if (!empty($records)) {
 
            $mcid = $records['mechine_id']; 
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





}