<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	

class Beaming_data_export extends CI_Controller {

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
        $this->load->model('Doffdata_Model'); // Load the model
    } 

	  public function index()
	{
		//$this->load->view('welcome_message');
	//	$data['records'] = $this->Doffdata_Model->get_all_records();
     //   $this->load->view('record_form', $data);
		
		$this->load->library('form_validation');
		$this->load->model('Doffdata_Model');
//        $categories=$this->Doffdata_Model->getCategories();
//		$data['categories']=$categories;
		
		$this->load->view('admin/reports/Beaming_data_export');
		
	}
    public function create()
	{
		//$this->load->view('welcome_message');

				$config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);	


		$this->load->model('Category_model');
		$this->form_validation->set_error_delimiters('<p class="invalid-feedback">','</p>');
		$this->form_validation->set_rules('name','Name','trim|required');
		if ($this->form_validation->run()== true) {

			$formArray['name']=$this->input->post('name');
			$formArray['status']=$this->input->post('status');
			$formArray['created_by']=date('Y-m-d H:i:s');	

			$this->Category_model->create($formArray);
			$this->session->set_flashdata('success', 'Category Added Successfully');
			redirect(base_url('admin/category'));


			//echo 'sucess';
		} else {
			echo 'error';
			$this->load->view('admin/category/create');
		}		
       
	}
    
	public function frame_qc_entry()
	{
		
        $this->load->view('admin/doffdata/frame_qc_entry');


	}
   
	public function edit()
	{
		//$this->load->view('welcome_message');
	
        $this->load->view('admin/category/edit');
	}
    public function delete()
	{
		//$this->load->view('welcome_message');
	
        $this->load->view('admin/category/delete');
	}


	public function fetch_data() {
        $frameNo = $this->input->post('frameNo');
        $payrollstartdate = $this->input->post('payrollstartdate');
        $shiftName = $this->input->post('shiftName');
        $companyId = $this->input->post('companyId');
		$payrollstartdate=substr($payrollstartdate,6,4).'-'.substr($payrollstartdate,3,2).'-'.substr($payrollstartdate,0,2);

        // Perform necessary database operations to retrieve data based on the parameters
        // Replace the following code with your own logic

        // Example queries using CodeIgniter's Active Record
      /*
		$this->db->select('name');
        $this->db->from('your_table');
        $this->db->where('mcno', $mcno);
        $query1 = $this->db->get();
	*/	
		$frm='';
		$sql="select mechine_name,bobbin_weight from  mechine_master where frame_no='$frameNo'";	
//echo $sql;
		$bwt=0;
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()>0 ) {
			 

			$row1 = $query1->row();
			$frm=$row1->mechine_name;
			$bwt=$row1->bobbin_weight;
			
 		}

		$sql="select ifnull(g.trollyno,' ') trollyno,ifnull(trolly_weight+basket_weight,0)  name from 
		(
		select trollyno,company_id from dofftable dft where  auto_id in 
		(select max(auto_id) auto_id from dofftable dftmx where dftmx.frameno ='$frameNo' and company_id =$companyId) 
		) g left join 
		 trollymst trmst on g.trollyno=trmst.trollyno and g.company_id=trmst.company_id 
		 where process_type=2";
		$query1=$this->db->query($sql);
//echo $sql."<br>";

		$sql="select count(*) noofdoff,ifnull(round(sum(netwt),2),0) tnetwt from dofftable dftmx where 
		doffdate ='$payrollstartdate' and
		dftmx.frameno ='$frameNo' and company_id =$companyId and spell='$shiftName'		";
		$query2=$this->db->query($sql);
//echo $sql;

/*
        $this->db->select_sum('weight');
        $this->db->from('your_table');
        $this->db->where('mcno', $mcno);
        $this->db->where('rundate', $rundate);
        $this->db->where('runshift', $runshift);
        $this->db->where('company_id', $company_id);
        $query2 = $this->db->get();
*/
			$q1=$query1->num_rows();
			$q2=$query2->num_rows();
//			echo 'result='.$q1.'-'.$q2;

$trlno='';
$trlwt=0;
$dfno=0;
$twt=0;


if ( $query1->num_rows()>0 ) {
	$row1 = $query1->row();
	$trlno=$row1->trollyno;
	$trlwt=$row1->name+$bwt;	
}
if ( $query2->num_rows()>0 ) {
	$row2 = $query2->row();
	$dfno=$row2->noofdoff+1;
	$twt=$row2->tnetwt;	
}

$response = array(
	'success' => true,
	'trollyNo' => $trlno,
	'trollyWt' => $trlwt,
	'doffNo' => $dfno,
	'tnetWt' => $twt,
	'mcno' => $frm	

);


        echo json_encode($response);
    }


	public function fetch_qc_data() {
        $frameNo = $this->input->post('frameNo');
        $doffqcdate = $this->input->post('doffqcdate');
        $shiftName = $this->input->post('shiftName');
        $companyId = $this->input->post('companyId');
		$doffqcdate=substr($doffqcdate,6,4).'-'.substr($doffqcdate,3,2).'-'.substr($doffqcdate,0,2);

        // Perform necessary database operations to retrieve data based on the parameters
        // Replace the following code with your own logic

        // Example queries using CodeIgniter's Active Record
      /*
		$this->db->select('name');
        $this->db->from('your_table');
        $this->db->where('mcno', $mcno);
        $query1 = $this->db->get();
	*/	
		$frm='';
		$sql="select mechine_name,bobbin_weight from  mechine_master where frame_no='$frameNo'";	
//echo $sql;
		$bwt=0;
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()>0 ) {
			 

			$row1 = $query1->row();
			$frm=$row1->mechine_name;
			$bwt=$row1->bobbin_weight;
			
 		}

		$sql="select ifnull(g.trollyno,' ') trollyno,ifnull(trolly_weight+basket_weight,0)  name from 
		(
		select trollyno,company_id from dofftable dft where  auto_id in 
		(select max(auto_id) auto_id from dofftable dftmx where dftmx.frameno ='$frameNo' and company_id =$companyId) 
		) g left join 
		 trollymst trmst on g.trollyno=trmst.trollyno and g.company_id=trmst.company_id 
		 where process_type=2";
		$query1=$this->db->query($sql);
//echo $sql."<br>";

		$sql="select count(*) noofdoff,ifnull(round(sum(netwt),2),0) tnetwt from dofftable dftmx where 
		doffdate ='$payrollstartdate' and
		dftmx.frameno ='$frameNo' and company_id =$companyId and spell='$shiftName'		";
		$query2=$this->db->query($sql);
//echo $sql;

/*
        $this->db->select_sum('weight');
        $this->db->from('your_table');
        $this->db->where('mcno', $mcno);
        $this->db->where('rundate', $rundate);
        $this->db->where('runshift', $runshift);
        $this->db->where('company_id', $company_id);
        $query2 = $this->db->get();
*/
			$q1=$query1->num_rows();
			$q2=$query2->num_rows();
//			echo 'result='.$q1.'-'.$q2;

$trlno='';
$trlwt=0;
$dfno=0;
$twt=0;


if ( $query1->num_rows()>0 ) {
	$row1 = $query1->row();
	$trlno=$row1->trollyno;
	$trlwt=$row1->name+$bwt;	
}
if ( $query2->num_rows()>0 ) {
	$row2 = $query2->row();
	$dfno=$row2->noofdoff+1;
	$twt=$row2->tnetwt;	
}

$response = array(
	'success' => true,
	'trollyNo' => $trlno,
	'trollyWt' => $trlwt,
	'doffNo' => $dfno,
	'tnetWt' => $twt,
	'mcno' => $frm	

);


        echo json_encode($response);
    }



	public function trolly_data() {
        $trollyNo = $this->input->post('trollyNo');
        $companyId = $this->input->post('companyId');
		$frameNo = $this->input->post('frameNo');
		

		$frm='';
		$sql="select mechine_name,bobbin_weight from  mechine_master where frame_no='$frameNo'";	
//echo $sql;
		$bwt=0;
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()>0 ) {
			 

			$row1 = $query1->row();
			$frm=$row1->mechine_name;
			$bwt=$row1->bobbin_weight;
			
 		}

 
        // Perform necessary database operations to retrieve data based on the parameters
        // Replace the following code with your own logic

        // Example queries using CodeIgniter's Active Record
 		$sql="select * from trollymst where company_id =$companyId and trollyno=$trollyNo and process_type=2";
		$query1=$this->db->query($sql);
 
 
 			$q1=$query1->num_rows();
 
$trlwt=0;
 

if ( $query1->num_rows()>0 ) {
	$row1 = $query1->row();
	$trlwt=$row1->trolly_weight+$row1->basket_weight+$bwt;	
//echo $row1->trolly_weight.'+'.$row1->basket_weight.'+'.$bwt.'='.$trlwt;
}
 

$response = array(
	'success' => true,
	
	'trollyWt' => $trlwt
	 	

);


        echo json_encode($response);
    }





	public function get_name() {
		$this->load->model('Doffdata_Model');
        $frameNo = $this->input->post('frameNo');
	//	echo 'frameno'.$frameNo;

        // Perform necessary database operations to retrieve the name based on the empCode
        // Replace the following code with your own logic
        $name = $this->Doffdata_Model->get_name_by_empCode($frameNo);
		
        if ($name) {
            $response = array(
                'success' => true,
                'name' => $name
            );
        } else {
            $response = array(
                'success' => false
            );
        }

        echo json_encode($response);
    }

	public function save_data() {
        $frameNo = $this->input->post('frameNo');
        $payrollstartdate = $this->input->post('payrollstartdate');
        $rec_time =  date('Y-m-d H:i:s');
        $shiftName = $this->input->post('shiftName');
        $companyId = $this->input->post('companyId');
		$payrollstartdate=substr($payrollstartdate,6,4).'-'.substr($payrollstartdate,3,2).'-'.substr($payrollstartdate,0,2);
		$trollyNo = $this->input->post('trollyNo');
		$tareWt = $this->input->post('tareWt');
		$grossWt = $this->input->post('grossWt');
		$netWt = $this->input->post('netWt');
      	$active=1;
		$entryMode='M';


		 
 	$data = array(
		'company_id' => $companyId,
		'doffdate' => $payrollstartdate,
		'entrydate' => $rec_time,
		'entry_mode' => $entryMode,
		'frameno' => $frameNo,
		'grosswt' => $grossWt,
		'is_active' => $active,
		'netwt' => $netWt,
		'spell' => $shiftName,
		'tarewt' => $tareWt,		
		'trollyno' => $trollyNo,
		'entrytime' => $rec_time

		// Exclude 'id' and 'updated_by' fields
	);
	$this->db->insert('dofftable', $data);


  $response = array(
	'success' => true,
	'frameNo' => $frameNo,
	'savedata'=> 'saved'
);

        echo json_encode($response);

    }


	public function get_records() {
        $date = $this->input->post('date');
        $shift = $this->input->post('shift');
		$compid = $this->input->post('companyId');
		$frameNo = $this->input->post('frameNo');
		
   // echo 'frame--'.$frameNo;
		$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
		

        // Get the records for the specified date and shift
    //    $records = $this->Doffdata_Model->get_records($date, $shift,$compid);
		$sql="select auto_id,DATE_FORMAT(doffdate, '%d-%m-%Y') doffdate,spell,frameno,trollyno,grosswt,tarewt,netwt from dofftable where doffdate='$date' and 
		spell='$shift' and company_id=$compid and is_active=1 order by auto_id desc";
		
		$sql = "SELECT auto_id, DATE_FORMAT(doffdate, '%d-%m-%Y') doffdate, spell, frameno, trollyno, grosswt, tarewt, netwt ,entrytime
            FROM dofftable 
            WHERE doffdate = ? AND spell = ? AND company_id = ? "; 
			if (strlen($frameNo)>0) {
				$sql=$sql."and frameno = $frameNo ";
			}
		$sql=$sql." 
			AND is_active = 1 
            ORDER BY auto_id DESC";
    $query = $this->db->query($sql, array($date, $shift, $compid));
    $records = $query->result();
		
	//	echo $sql;
	//	$records=$this->db->query($sql);
	//	echo $sql;
		// Prepare the response
        $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->auto_id,
                $record->doffdate,
                $record->spell,
                $record->frameno,
                $record->trollyno,
                $record->grosswt,
                $record->tarewt,
                $record->netwt,
                $record->entrytime
                
            ];
        }

        // Return the response
        echo json_encode(['data' => $data]);
    }

	public function get_frmqcrecords() {
        $date = $this->input->post('date');
        $shift = $this->input->post('shift');
		$compid = $this->input->post('compId');
		$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
		$sql = "select sytd.hdrid,DATE_FORMAT(entry_date , '%d-%m-%Y') doffdate ,spell ,spinning_mc_id,frame_no,mm.mechine_name ,
		 yarn_id,ifnull(quality_code,' ') quality_code,ifnull(quality_name,' ') quality_name,concat(quality_code,'=>',quality_name) quality 
		from spinning_yarn_type_daily sytd 
		left join mechine_master mm on sytd.spinning_mc_id =mm.mechine_id and mm.company_id =sytd.company_id 
		left join weaving_quality_master wqm on wqm.quality_id =sytd.yarn_id and wqm.quality_code >0 and wqm.company_id =sytd.company_id 
		where sytd.company_id =? and sytd.entry_date =? and sytd.spell= ?
		and sytd.is_active =1
		order by CAST(mm.frame_no as SIGNED INTEGER)";
    $query = $this->db->query($sql, array($compid,$date, $shift ));
    $records = $query->result();
         $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->hdrid,
                $record->doffdate,
                $record->spell,
                $record->frame_no,
                $record->mechine_name,
                $record->quality_code,
                $record->quality_name,
            ];
        }

        // Return the response
        echo json_encode(['data' => $data]);
    }

	public function savepfrmqcode_data() {
        $doffdate = $this->input->post('doffdate');
        $doffshift = $this->input->post('doffshift');
        $companyId = $this->input->post('companyId');
		$created_by=26577;
		$active=1;
		$doffdate=substr($doffdate,6,4).'-'.substr($doffdate,3,2).'-'.substr($doffdate,0,2);
 
		$sql = "select sytd.hdrid,DATE_FORMAT(entry_date , '%d-%m-%Y') doffdate ,spell ,spinning_mc_id,frame_no,mm.mechine_name ,
		yarn_id,quality_name,concat(quality_code,'=>',quality_name) quality 
		from spinning_yarn_type_daily sytd 
		left join mechine_master mm on sytd.spinning_mc_id =mm.mechine_id and mm.company_id =sytd.company_id 
		left join weaving_quality_master wqm on wqm.quality_code =sytd.yarn_id and wqm.quality_code >0 and 
		wqm.company_id =sytd.company_id 
		where sytd.company_id =".$companyId." and sytd.entry_date ='".$doffdate."' and sytd.spell='".$doffshift."' 
		 and sytd.is_active =1
		order by CAST(mm.frame_no as SIGNED INTEGER)";
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()==0 ) {

		$sql="select max(entry_date) mxdate from  spinning_yarn_type_daily sytd 
		where company_id =? and entry_date<=?"; 
		$query = $this->db->query($sql, array($companyId,$doffdate ));
    	$records = $query->result();
	//	$query1=$this->db->query($sql);
		$row1 = $query->row();
		$mxdate=$row1->mxdate;
   
		$sql="select max(spellno) mxspellno from (
			select sytd.*,case 
			when spell='A1' then 1 
			when spell='B1' then 2 
			when spell='A2' then 3 
			when spell='B2' then 4 
			when spell='C' then 5 END spellno 
			from spinning_yarn_type_daily sytd 
			where company_id =? and entry_date=?
			) g ";
			$query = $this->db->query($sql, array($companyId,$mxdate ));
			$records = $query->result();
		//	$query1=$this->db->query($sql);
			$row1 = $query->row();
			$mxspell=$row1->mxspellno;
				
			$sql="insert into spinning_yarn_type_daily (company_id,created_by,entry_date,is_active,spell,spinning_mc_id,yarn_id )  
			select ".$companyId.",".$created_by.",'".$doffdate."',".$active.",'".$doffshift."',mechine_id,yarn_id from 
			(
			select mm.mechine_id,mm.frame_no,mm.mechine_name,ifnull(yarn_id,0) yarn_id  from mechine_master mm 
			left join
			(
			select sytd.company_id,sytd.hdrid,entry_date,spell,spinning_mc_id,frame_no,mm.mechine_name,sytd.yarn_id,wqm.quality_name  from (
			select sytd.*,case 
			when spell='A1' then 1 
			when spell='B1' then 2 
			when spell='A2' then 3 
			when spell='B2' then 4 
			when spell='C' then 5 END spellno 
			from spinning_yarn_type_daily sytd 
			where company_id =".$companyId." and entry_date='".$mxdate."'  
			) sytd
			left join mechine_master mm on sytd.spinning_mc_id =mm.mechine_id and mm.company_id =sytd.company_id 
			left join weaving_quality_master wqm on wqm.quality_code =sytd.yarn_id and wqm.quality_code >0 and wqm.company_id =sytd.company_id 
			where  spellno=".$mxspell." 
			) g on g.spinning_mc_id =mm.mechine_id 
			where mm.company_id =".$companyId." and mm.type_of_mechine =36
			) k  ";
//			 echo $sql;
//			$query = $this->db->query($sql);
			$this->db->query($sql);
//			$records = $query->result();
		   // $query1=$this->db->query($sql);
//			$row1 = $query->row();
//			$spgmcid=$row1->mechine_id;
//			$yarnid=$row1->yarn_id;	

/*
company_id
created_by
entry_date
is_active
spell
spinning_mc_id
yarn_id
*/	
 
//	$this->db->insert('spinning_yarn_type_daily', $data);

$response = array(
	'success' => true,
	'doffdate' => $doffdate,
	'savedata'=> 'saved'
);

        echo json_encode($response);


}


}


//
public function updatefrmqcode_data() {
	$qcframeNo = $this->input->post('qcframeNo');
	$doffqcdate = $this->input->post('doffqcdate');
	$rec_time =  date('Y-m-d H:i:s');
	$doffqcshiftName = $this->input->post('doffqcshiftName');
	$companyId = $this->input->post('companyId');
	$doffqcdate=substr($doffqcdate,6,4).'-'.substr($doffqcdate,3,2).'-'.substr($doffqcdate,0,2);
	$qcode_1 = $this->input->post('qcode_1');
	$record_id = $this->input->post('record_id');
    $active=1;
	$entryMode='M';

	//	echo 'frame -'.$qcframeNo;
	$sql="select quality_id from  weaving_quality_master 
	where company_id =? and quality_code=?"; 
	$query = $this->db->query($sql, array($companyId,$qcode_1 ));
	$records = $query->result();
//	$query1=$this->db->query($sql);
	$row1 = $query->row();
	$qcodeid=$row1->quality_id;

	$sql="select mechine_id from  mechine_master mm 
	where company_id =? and frame_no=?"; 
	$query = $this->db->query($sql, array($companyId,$qcframeNo ));
	$records = $query->result();
//	$query1=$this->db->query($sql);
	$row1 = $query->row();
	$mechine_id=$row1->mechine_id;
//echo $qcodeid;
 	
	$data = array(
        'spinning_mc_id' => $mechine_id,
        'yarn_id' => $qcodeid
);

//var dump($data);

$this->db->where('hdrid', $record_id);
$this->db->update('spinning_yarn_type_daily', $data);
 

$response = array(
'success' => true,
'frameNo' => $mechine_id,
'savedata'=> 'Updated'
);

	echo json_encode($response);

}




public function frmqcget_quality() {
	$qcode_1 = $this->input->post('qcode_1');
	$companyId = $this->input->post('companyId');
	$sql="select ifnull(quality_name,'') quality_name from  weaving_quality_master
	where quality_type=2 and  company_id =? and quality_code=?"; 
	$query = $this->db->query($sql, array($companyId,$qcode_1 ));
	$records = $query->result();
//	$query1=$this->db->query($sql);
	$name='';
	if ( $query->num_rows()>0 ) {
 		$row1 = $query->row();
		$name=$row1->quality_name;
	}	
	

	if ($name) {
		$response = array(
			'success' => true,
			'name' => $name
		);
	} else {
		$response = array(
			'success' => false
		);
	}

	echo json_encode($response);
}

public function qacntcget_quality() {
	$qcode_1 = $this->input->post('qcode_1');
	$companyId = $this->input->post('companyId');
	$date= $this->input->post('qcacntdate');
	$qcacntdate=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
	$record_id = $this->input->post('record_id');
 		$sql="select wqm.quality_id,quality_code ,quality_name,ifnull(tpwqm.id,0) id  from weaving_quality_master wqm 
		left join tbl_prod_weaving_quality_mapping tpwqm on tpwqm.quality_id = wqm.quality_id 
		and tpwqm.quality_type =wqm.quality_type and tpwqm.company_id =wqm.company_id 
		and tpwqm.mapping_date =? and tpwqm.is_active=1
		where wqm.company_id=?  and wqm.quality_type =2 and quality_code =?
		"; 
 	$dupl=0;
	$query = $this->db->query($sql, array($qcacntdate,$companyId,$qcode_1 ));
	$records = $query->result();
//	$query1=$this->db->query($sql);
	$name='';
	if ( $query->num_rows()>0 ) {
 		$row1 = $query->row();
		$name=$row1->quality_name;
		$dupl=$row1->id;
	}	

//	echo 'rec-'.$record_id.' data-'.$dupl;
	if ($record_id==0)  {
			$duplicate=$dupl;	
	}
	if ($record_id>0)  {
		if ($dupl<>$record_id) {
			$duplicate=$dupl;	
		} else 
		 {
			$duplicate=0;	
		}

	}

	if ($name) {
		$response = array(
			'success' => true,
			'name' => $name,
			'duplicate' => $duplicate
		);
	} else {
		$response = array(
			'success' => false
		);
	}

	echo json_encode($response);
}



public function get_qacntrecords() {
	$date = $this->input->post('date');
	$compid = $this->input->post('compId');
	$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
	$sql = "select id,mapping_date,tpwqm.quality_id,wqm.quality_code ,wqm.quality_name,tpwqm.spg_actual_count  from tbl_prod_weaving_quality_mapping tpwqm 
	left join weaving_quality_master wqm ON wqm.quality_id =tpwqm.quality_id  
	where tpwqm.quality_type =2 and tpwqm.company_id =? and mapping_date =? order by id desc
	";
$query = $this->db->query($sql, array($compid,$date ));
$records = $query->result();
	 $data = [];
	foreach ($records as $record) {
		$data[] = [
			$record->id,
			$record->mapping_date,
			$record->quality_code,
			$record->quality_name,
			$record->spg_actual_count
		];
	}

	// Return the response
	echo json_encode(['data' => $data]);
}

 
public function saveqacnt_data() {
	$qcacntdate = $this->input->post('qcacntdate');
	$act_count = $this->input->post('act_count');
	$rec_time =  date('Y-m-d H:i:s');
	$qcode_1 = $this->input->post('qcode_1');
	$companyId = $this->input->post('companyId');
	$qcacntdate=substr($qcacntdate,6,4).'-'.substr($qcacntdate,3,2).'-'.substr($qcacntdate,0,2);
 	$active=1;
	$qtype=2;
	$entryMode='M';

	$sql="select quality_id from  weaving_quality_master
	where quality_type=2 and  company_id =? and quality_code=?"; 
	$query = $this->db->query($sql, array($companyId,$qcode_1 ));
	$records = $query->result();
//	$query1=$this->db->query($sql);
	$qcid='';
	if ( $query->num_rows()>0 ) {
 		$row1 = $query->row();
		$qcid=$row1->quality_id;
	}	
/*	
	quality_id
	actual_shot
	spg_actual_count
	company_id
	quality_type
	mapping_date
	is_active
	created_date_time
	speed
	finished_length
*/
	 
 $data = array(
	'company_id' => $companyId,
	'quality_id' => $qcid,
	'spg_actual_count' => $act_count,
	'quality_type' => $qtype,
	'mapping_date' => $qcacntdate,
	'is_active' => $active,
	'created_date_time' => $rec_time
 
	// Exclude 'id' and 'updated_by' fields
);
$this->db->insert('tbl_prod_weaving_quality_mapping', $data);


$response = array(
'success' => true,
'frameNo' => $qcid,
'savedata'=> 'saved'
);

	echo json_encode($response);

}



public function updateqacnt_data() {
	$qcacntdate = $this->input->post('qcacntdate');
	$act_count = $this->input->post('act_count');
	$rec_time =  date('Y-m-d H:i:s');
	$qcode_1 = $this->input->post('qcode_1');
	$companyId = $this->input->post('companyId');
	$qcacntdate=substr($qcacntdate,6,4).'-'.substr($qcacntdate,3,2).'-'.substr($qcacntdate,0,2);
	$record_id = $this->input->post('record_id');
 	$active=1;
	$qtype=2;
	$entryMode='M';

	$sql="select quality_id from  weaving_quality_master
	where quality_type=2 and  company_id =? and quality_code=?"; 
	$query = $this->db->query($sql, array($companyId,$qcode_1 ));
	$records = $query->result();
//	$query1=$this->db->query($sql);
	$qcid='';
	if ( $query->num_rows()>0 ) {
 		$row1 = $query->row();
		$qcid=$row1->quality_id;
	}	
/*	
	quality_id
	actual_shot
	spg_actual_count
	company_id
	quality_type
	mapping_date
	is_active
	created_date_time
	speed
	finished_length
*/
	 
 $data = array(
	'quality_id' => $qcid,
	'spg_actual_count' => $act_count,
 
);

$this->db->where('id', $record_id);
$this->db->update('tbl_prod_weaving_quality_mapping', $data);





$response = array(
'success' => true,
'frameNo' => $qcid,
'savedata'=> 'Updated'
);

	echo json_encode($response);

}

public function loomchecklist() {
	$date = $this->input->post('date');
	$compid = $this->input->post('companyId');
	$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
	$sql = "select g.*,length(ebno) ln from (
		select mech_code,date_format(loom_date,'%d-%m-%Y') loom_date ,'A1' spell, quality_code_a1 qcode,ifnull(ticket_no_a1,'') ebno,ifnull(working_hrs_a1,0) whrs, 
		cuts_a1 cuts,jugar_a1 jugar,ifnull((production_a1/finished_length_a1*16),0) prod ,ifnull(efficiency_a1,0) eff from cuts_jugar_buff_1 cjb 
		left join mechine_master mm on cjb.loom_id =mm.mechine_id 
		where loom_date ='".$date."' and cjb.company_id =".$compid." 
		and cjb.is_active =1 and length(mm.mech_code)=6 
		UNION ALL 
		select mech_code, date_format(loom_date,'%d-%m-%Y') loom_date ,'A2' spell, quality_code_a2 qcode,ifnull(ticket_no_a2,'') ebno,ifnull(working_hrs_a2,0) whrs, 
		cuts_a2 cuts,jugar_a2 jugar,ifnull((production_a2/finished_length_a2*16),0) prod ,ifnull(efficiency_a2,0) eff from cuts_jugar_buff_1 cjb left join mechine_master mm on cjb.loom_id =mm.mechine_id 
		where loom_date ='".$date."' and cjb.company_id =".$compid." 
		and cjb.is_active =1 and length(mm.mech_code)=6 
		UNION ALL 
		select mech_code, date_format(loom_date,'%d-%m-%Y') loom_date ,'B1' spell, quality_code_b1 qcode,ifnull(ticket_no_b1,'') ebno,ifnull(working_hrs_b1,0) whrs, 
		cuts_b1 cuts,jugar_b1 jugar,ifnull((production_b1/finished_length_b1*16),0) prod ,ifnull(efficiency_b1,0) eff from cuts_jugar_buff_1 cjb left join mechine_master mm on cjb.loom_id =mm.mechine_id 
		where loom_date ='".$date."' and cjb.company_id =".$compid." 
		and cjb.is_active =1 and length(mm.mech_code)=6 
		UNION ALL 
		select mech_code, date_format(loom_date,'%d-%m-%Y') loom_date ,'B2' spell, quality_code_b2 qcode,ifnull(ticket_no_b2,'') ebno,ifnull(working_hrs_b2,0) whrs, 
		cuts_b2 cuts,jugar_b2 jugar,ifnull((production_b2/finished_length_b2*16),0) prod ,ifnull(efficiency_b2,0) eff from cuts_jugar_buff_1 cjb left join mechine_master mm on cjb.loom_id =mm.mechine_id 
		where loom_date ='".$date."' and cjb.company_id =".$compid." 
		and cjb.is_active =1 and length(mm.mech_code)=6 
		UNION ALL 
		select mech_code,date_format(loom_date,'%d-%m-%Y') loom_date ,'C' spell, quality_code_c qcode,ifnull(ticket_no_c,'') ebno,ifnull(working_hrs_c,0) whrs, 
		cuts_c cuts,jugar_c jugar,ifnull((production_c/finished_length_c*16),0) prod ,ifnull(efficiency_c,0) eff  from cuts_jugar_buff_1 cjb left join mechine_master mm on cjb.loom_id =mm.mechine_id 
		where loom_date ='".$date."' and cjb.company_id =".$compid." 
		and cjb.is_active =1 and length(mm.mech_code)=6 
		) g where (prod>0 and length(ebno)=0 ) or (prod=0 and length(ebno)>0 ) 
		or (prod>0 and eff=0) or (eff>90)
		order by mech_code 
	";
$query = $this->db->query($sql, array($compid,$date ));
$records = $query->result();
$sln=$query->num_rows();
$data = [];
	foreach ($records as $record) {
		$data[] = [
			$record->mech_code,
			$record->loom_date,
			$record->spell,
			$record->qcode,
			$record->ebno,
			$record->whrs,
			$record->cuts,
			$record->jugar,
			$record->prod,
			$record->eff,

		];
		$sln=$sln-1;
	}

	// Return the response
	echo json_encode(['data' => $data]);
}


public function updateebqc_data() {
	$doffdate = $this->input->post('doffdate');
	$doffshift = $this->input->post('doffshift');
	$companyId = $this->input->post('companyId');
	$created_by=26577;
	$active=1;
	$doffdate=substr($doffdate,6,4).'-'.substr($doffdate,3,2).'-'.substr($doffdate,0,2);
//	exit();


 
// Start the transaction to ensure data for update qcode in dofftable
$this->db->trans_start();

$limit=10;
$query = $this->db->select('sytd.spell, sytd.entry_date, sytd.yarn_id, mm.frame_no, wqm.quality_code')
                  ->from('spinning_yarn_type_daily sytd')
                  ->join('mechine_master mm', 'mm.mechine_id = sytd.spinning_mc_id', 'left')
                  ->join('weaving_quality_master wqm', 'wqm.quality_id = sytd.yarn_id', 'left')
                  ->where('sytd.company_id', $companyId)
                  ->where('sytd.entry_date', $doffdate)
                  ->where('sytd.yarn_id >', 0)
                  ->where('sytd.is_active', 1)
                  ->get();
				  $records = $query->result_array();

// Build the CASE expression for the q_code update
$case_expression = 'CASE ';
foreach ($records as $update_data) {
    $doffdate = $doffdate;
    $spell = $update_data['spell'];
    $frameno = $update_data['frame_no'];
    $q_code = $update_data['quality_code'];

    $case_expression .= "WHEN doffdate = '{$doffdate}' AND spell = '{$spell}' AND frameno = '{$frameno}' THEN '{$q_code}' ";
}

$case_expression .= 'ELSE q_code END';

// Update the dofftable using the CASE expression
$this->db->query("UPDATE dofftable SET q_code = {$case_expression} WHERE company_id = {$companyId}");

// Commit the transaction
$this->db->trans_complete();

if ($this->db->trans_status() === FALSE) {
    // Handle transaction error if needed.
}

 
// Start the transaction to ensure data for update ebno in dofftable
$this->db->trans_start();
/*
select attendace_date,spell,eb_no,mc_id  from daily_ebmc_attendance dea 
left join mechine_master mm on dea.mc_id =mm.mechine_id and dea.company_id =mm.company_id 
where attendace_date ='2023-07-24' and dea.company_id =2 and mm.type_of_mechine =36
*/

$limit=10;
$query = $this->db->select('dea.attendace_date,dea.spell,dea.eb_no,dea.mc_id,mm.frame_no')
                  ->from('daily_ebmc_attendance dea')
                  ->join('mechine_master mm', 'mm.mechine_id = dea.mc_id', 'left')
                  ->where('dea.company_id', $companyId)
                  ->where('dea.attendace_date', $doffdate)
                  ->where('dea.is_active', 1)
                  ->get();
				  $records = $query->result_array();

// Build the CASE expression for the q_code update
$case_expression = 'CASE ';
foreach ($records as $update_data) {
    $doffdate = $doffdate;
    $spell = $update_data['spell'];
    $frameno = $update_data['frame_no'];
    $eb_no = $update_data['eb_no'];

    $case_expression .= "WHEN doffdate = '{$doffdate}' AND spell = '{$spell}' AND frameno = '{$frameno}' THEN '{$eb_no}' ";
}

$case_expression .= 'ELSE ebno END';

// Update the dofftable using the CASE expression
$this->db->query("UPDATE dofftable SET ebno = {$case_expression} WHERE company_id = {$companyId}");

// Commit the transaction
$this->db->trans_complete();

if ($this->db->trans_status() === FALSE) {
    // Handle transaction error if needed.
}
 
 
 
  


 //	$this->db->insert('spinning_yarn_type_daily', $data);

$response = array(
'success' => true,
'doffdate' => $doffdate,
'savedata'=> 'saved'
);

	echo json_encode($response);


}


public function exportdbfdata() {
	$sdate = $this->input->post('payrollstartdate');
	$compid = $this->input->post('companyId');
	$sdate = $this->input->get('payrollstartdate');
	$compid = $this->input->get('companyId');
	
	
		 $sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
	
		$sql = "select DATE_FORMAT(tran_date,'%d-%m-%Y') tran_date ,quality_code ,substr(mech_code,4,2) beammcno ,spell,0 idlehrs,mechine_name,
		case when substr(spell,1,1) ='A' then 8
		when substr(spell,1,1) ='B' then 8
		when substr(spell,1,1) ='C' then 7.5 end whrs,no_of_beams,no_of_cuts
		from beaming_daily_production bdp 
		left join mechine_master mm on mm.mc_posting_code =bdp.beam_mc_no and mm.company_id =bdp.company_id  
		where   mm.type_of_mechine =5
		and tran_date ='".$sdate."' and bdp.company_id =".$compid." and bdp.is_active=1";
		 
	
		$query = $this->db->query($sql);
		$data = $query->result_array();
	
		$fileContainer = "beamdata.csv";
		$filePointer = fopen($fileContainer,"w+");
	
		$logMsg='';
		$rowIndex = 4;
		foreach ($data as $row) {
			$logMsg.= $row['tran_date'].",".$row['quality_code'].",".$row['beammcno'].",".$row['spell'].
			",".$row['idlehrs'].",".$row['whrs'].",".$row['no_of_beams'].
			",".$row['no_of_cuts']."\r\n";
	
		}	
	
		fputs($filePointer,$logMsg);
		fclose($filePointer);
	 
		$txt2=$fileContainer;
		$files = array($txt2);
		$zipname = 'beamdata.zip';
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
		
	
	   exit();
	 
	}
	
public function exportToCsv() {
    $postData = json_decode(file_get_contents('php://input'), true);
    $sdate = $postData['payrollstartdate'];
    $edate = $postData['payrollenddate'];
    $compid = $postData['companyId'];
    $payScheme = $postData['payScheme'];		
    $sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
    $edate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
    $sql = 'SELECT * FROM tbl_pay_scheme'; // Your lengthy query here
    $sql="select PAYPERIOD_ID,eb_no,wname,ifnull(pf_no,' ') pf_no ,IFNULL(fpf_no,' ') fpf_no,ifnull(esi_no,' ') esi_no,
    max( case when COMPONENT_ID=6 then amount else 0 end ) Days,
    max( case when COMPONENT_ID=7 then amount else 0 end ) Basic,
    max( case when COMPONENT_ID=18 then amount else 0 end ) PF,
    max( case when COMPONENT_ID=66 then amount else 0 end ) Gross1,
    max( case when COMPONENT_ID=19 then amount else 0 end ) esi
    from (
    select tpep.PAYPERIOD_ID,tpp.FROM_DATE,tpp.TO_DATE, tpep.EMPLOYEEID,theod.emp_code eb_no, 
    concat(thepd.first_name ,' ',IFNULL(thepd.middle_name,' ')  ,' ',ifnull(thepd.last_name,' ')) wname,
    COMPONENT_ID,tpc.NAME,thee.esi_no,thep.pf_no ,thep.pf_uan_no fpf_no, AMOUNT,tpep.PAYSCHEME_ID  from 
    tbl_pay_employee_payroll tpep
    left join tbl_pay_period tpp on tpep.PAYPERIOD_ID =tpp.ID 
    left join tbl_pay_components tpc on tpep.COMPONENT_ID =tpc.ID 
    left join tbl_hrms_ed_official_details theod on tpep.EMPLOYEEID =theod.eb_id  and theod.is_active =1
    left join tbl_hrms_ed_personal_details thepd on tpep.EMPLOYEEID =thepd.eb_id 
    left join tbl_hrms_ed_esi thee on tpep.EMPLOYEEID =thee.eb_id  and thee.is_active =1
    left join tbl_hrms_ed_pf thep on tpep.EMPLOYEEID =thep.eb_id   and thep.is_active =1
    where  tpep.COMPONENT_ID in (66,7,6,19,18,62) 
    and tpp.FROM_DATE ='".$sdate."' AND tpp.TO_DATE ='".$edate."' and tpep.PAYSCHEME_ID=".$payScheme." 
    and tpep.BUSINESSUNIT_ID =".$compid." and tpp.STATUS =3
    ) g  group by PAYPERIOD_ID,eb_no,wname,fpf_no,pf_no,esi_no
    order by eb_no 	";
    //echo $sql;
    $query = $this->db->query($sql);
    $data = $query->result_array();


      $filename = 'custom_name_' . date('YmdHis') . '.csv';

      // Set the response headers to trigger the file download with the specific filename
//		  header('Content-Type: text/csv');
      header('Content-Type: text/plain');
      header('Content-Disposition: attachment; filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
  
      // Open a memory stream to write CSV data
      $stream = fopen('php://memory', 'w');
      
      // Write the CSV header row (if needed)
      $headers = array_keys($data[0]);
      fputcsv($stream, $headers);
      
      // Write each row of data into the CSV
//	  foreach ($data as $row) {
//			  fputcsv($stream, $row);
//		  }
/*		 
      foreach ($data as &$row) {
        // For example, remove quotes for the "name" field
        $row['PAYPERIOD_ID'] = $row['PAYPERIOD_ID'];
        $row['eb_no'] = $row['eb_no'];
        $nm= trim(str_replace('"', '', $row['wname']));
//			echo $nm;
        $row['name'] =$nm; 
        //str_replace('"', '', $row['wname']);
//		echo $row['wname'];
        $row['pf_no'] = $row['pf_no'];
        $row['fpf_no'] = $row['fpf_no'];
        $row['esi_no'] = $row['esi_no'];
        $row['Basic'] = $row['Basic'];
        $row['PF'] = $row['PF'];
        $row['Gross1'] = $row['Gross1'];
        $row['esi'] = $row['esi'];
    //	fputcsv($stream, $row);
      
      }



foreach ($data as $row) {
        $csvRow = [];
        foreach ($row as $field) {
            $csvRow[] = str_replace('"', '', $field);
        }
        fputcsv($stream, $csvRow, ',');
    }
    


foreach ($data as $row) {
$textRow = implode("\t,",$row) . "\n"; // Use tab as a delimiter between fields
fwrite($stream, $textRow);
}
*/
foreach ($data as $row) {
// Apply trim to each value in the row
$trimmedRow = array_map('trim', $row);

// Join the trimmed values with a tab delimiter and add a new line at the end
$textRow = implode("\t,", $trimmedRow) . "\n";

// Write the row to the text file
fwrite($stream, $textRow);
}


      // Reset the stream pointer to the beginning
      rewind($stream);
      
      // Output the CSV data to the browser
      echo stream_get_contents($stream);
      exit;
  }
   

/*		
    // Set the desired filename for the CSV file
    $filenam = 'pf_esi_data' . '.csv';

    // Set the response headers to trigger the file download with the specific filename
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filenam . '"');
    header('Cache-Control: max-age=0');

    // Open a memory stream to write CSV data
    $stream = fopen('php://memory', 'w');
    
    // Write the CSV header row (if needed)
    $headers = array_keys($data[0]);
    fputcsv($stream, $headers);
    
    // Write each row of data into the CSV
//		foreach ($data as $row) {
//			fputcsv($stream, $row);
//		}
    


    
    // Reset the stream pointer to the beginning
    rewind($stream);
    
    // Output the CSV data to the browser
    echo stream_get_contents($stream);
    exit;
}
*/ 	




}
 