<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Doffdata extends CI_Controller {

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

		$company_id = $this->session->userdata('company_id');

			if (strlen($company_id)==0) { 
				redirect('admin/login/logout');
			}


		//$this->load->view('welcome_message');
	//	$data['records'] = $this->Doffdata_Model->get_all_records();
     //   $this->load->view('record_form', $data);
		
		$this->load->library('form_validation');
		$this->load->model('Doffdata_Model');
//        $categories=$this->Doffdata_Model->getCategories();
//		$data['categories']=$categories;
		
		$this->load->view('admin/doffdata/create');
		
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
	//	$frm=$frameNo;

		$response = array(
			'success' => false,
			'trollyNo' => '',
			'trollyWt' => 0,
			'doffNo' => 0,
			'tnetWt' => 0,
			'mcno' => ''	
			);
	
 		$frm='';
		$sql="select mechine_name,bobbin_weight from  mechine_master where frame_no='".$frameNo."' and company_id=".$companyId;	
		$bwt=0;
		$query1=$this->db->query($sql);
		$mno=$query1->num_rows();
		if ($mno>0) { 
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


			$sql="select ifnull(g.trollyno,' ') trollyno,ifnull(trolly_weight+basket_weight,0)  name from 
			(
			select trollyno,company_id from dofftable dftmx where 
			dftmx.frameno ='$frameNo' and company_id =$companyId and dftmx.is_active =1
			order by auto_id desc limit 1
			) g 		
			left join 
			trollymst trmst on g.trollyno=trmst.trollyno and g.company_id=trmst.company_id 
			where process_type=2";
			$query1=$this->db->query($sql);
 

			$sql="select count(*) noofdoff,ifnull(round(sum(netwt),2),0) tnetwt from dofftable dftmx where 
			doffdate ='$payrollstartdate' and
			dftmx.frameno ='$frameNo' and company_id =$companyId and spell='$shiftName'	and is_active=1 	";
		//	echo $sql;
			$query2=$this->db->query($sql);
				$q1=$query1->num_rows();
				$q2=$query2->num_rows();
 
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


}  	


        echo json_encode($response);
   }
	public function fetch_datan() {
        $frameNo = $this->input->post('frameNo');
        $payrollstartdate = $this->input->post('payrollstartdate');
        $shiftName = $this->input->post('shiftName');
        $companyId = $this->input->post('companyId');
		$payrollstartdate=substr($payrollstartdate,6,4).'-'.substr($payrollstartdate,3,2).'-'.substr($payrollstartdate,0,2);

 		$frm='';
		$sql="select mechine_name,bobbin_weight from  mechine_master where frame_no='".$frameNo."' and company_id=".$companyId;	
//		echo $sql;
		$bwt=0;
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()>0 ) {
			$row1 = $query1->row();
			$frm=$row1->mechine_name;
			$bwt=$row1->bobbin_weight;
			
 		}
		 $vdate = date('m/d/Y h:i:s a', time());
//		echo $vdate;
		$sql="select ifnull(g.trollyno,' ') trollyno,ifnull(trolly_weight+basket_weight,0)  name from 
		(
		select trollyno,company_id from dofftable dft where  auto_id in 
		(select max(auto_id) auto_id from dofftable dftmx where dftmx.frameno ='$frameNo' and company_id =$companyId) 
		) g left join 
		 trollymst trmst on g.trollyno=trmst.trollyno and g.company_id=trmst.company_id 
		 where process_type=2";
//		 echo $sql;
		 $query1=$this->db->query($sql);
		 $vdate = date('m/d/Y h:i:s a', time());
//		echo $vdate;

		$sql="select count(*) noofdoff,ifnull(round(sum(netwt),2),0) tnetwt from dofftable dftmx where 
		doffdate ='$payrollstartdate' and
		dftmx.frameno ='$frameNo' and company_id =$companyId and spell='$shiftName'		";
//		echo $sql;
		$query2=$this->db->query($sql);
		$vdate = date('m/d/Y h:i:s a', time());
//		echo $vdate;

			$q1=$query1->num_rows();
			$q2=$query2->num_rows();

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
		$sql="select mechine_name,bobbin_weight from  mechine_master where frame_no='$frameNo' 
		and company_id=".$companyId;	
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
 		$sql="select * from trollymst where company_id =$companyId and trollyno='".$trollyNo."' and process_type=2";
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

	//	$this->load->library('input');
//		$clientIP = $this->input->ip_address();
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
		$ip = $_SERVER['REMOTE_ADDR'];

		 
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
		'user_ip' => $ip,
		'entrytime' => $rec_time


		// Exclude 'id' and 'updated_by' fields
	);
	$this->db->insert('dofftable', $data);
	$data =[];

  $response = array(
	'success' => true,
	'frameNo' => $frameNo,
	'savedata'=> 'saved'
);

$frameNo='';        
echo json_encode($response);


    }


	public function dofmodupdate_data() {
        $frameNo = $this->input->post('frameNo');
        $doffmodexpdate = $this->input->post('doffmodexpdate');
        $companyId = $this->input->post('companyId');
		$doffmodexpdate=substr($doffmodexpdate,6,4).'-'.substr($doffmodexpdate,3,2).'-'.substr($doffmodexpdate,0,2);
		$trollyNo = $this->input->post('trollyNo');
		$tareWt = $this->input->post('tareWt');
		$grossWt = $this->input->post('grossWt');
		$netWt = $this->input->post('netWt');
		$record_id= $this->input->post('record_id');
		$active=1;
		$entryMode='M';


		 
 	$data = array(
		'company_id' => $companyId,
		'doffdate' => $doffmodexpdate,
		'entry_mode' => $entryMode,
		'frameno' => $frameNo,
		'grosswt' => $grossWt,
		'is_active' => $active,
		'netwt' => $netWt,
		'tarewt' => $tareWt,		
		'trollyno' => $trollyNo,
 		'record_id' => $record_id

		// Exclude 'id' and 'updated_by' fields
	);


	$data = array(
        'trollyno' => $trollyNo,
		'grosswt' => $grossWt,
		'tarewt' => $tareWt,
		'netwt' => $netWt
		);

//var dump($data);

$this->db->where('auto_id', $record_id);
$this->db->update('dofftable', $data);


  $response = array(
	'success' => true,
	'frameNo' => $frameNo,
	'savedata'=> 'saved'
);

        echo json_encode($response);

    }

	public function dofmoddel_data() {
        $frameNo = $this->input->post('frameNo');
        $doffmodexpdate = $this->input->post('doffmodexpdate');
        $companyId = $this->input->post('companyId');
		$doffmodexpdate=substr($doffmodexpdate,6,4).'-'.substr($doffmodexpdate,3,2).'-'.substr($doffmodexpdate,0,2);
		$trollyNo = $this->input->post('trollyNo');
		$tareWt = $this->input->post('tareWt');
		$grossWt = $this->input->post('grossWt');
		$netWt = $this->input->post('netWt');
		$record_id= $this->input->post('record_id');
		$active=1;
		$entryMode='M';


		 
 	$data = array(
		'company_id' => $companyId,
		'doffdate' => $doffmodexpdate,
		'entry_mode' => $entryMode,
		'frameno' => $frameNo,
		'grosswt' => $grossWt,
		'is_active' => $active,
		'netwt' => $netWt,
		'tarewt' => $tareWt,		
		'trollyno' => $trollyNo,
 		'record_id' => $record_id

		// Exclude 'id' and 'updated_by' fields
	);

$isact=0;
	$data = array(
        'is_active' => $isact
 		);

//var dump($data);

$this->db->where('auto_id', $record_id);
$this->db->update('dofftable', $data);

//var dump($data);

//$this->db->where('auto_id', $record_id);
//$whereCondition = array('auto_id' => $record_id);
//$this->db->delete('dofftable', $whereCondition);


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
		
		$sql="UPDATE dofftable AS d1
		JOIN (
			SELECT d.company_id, d.doffdate, d.spell, d.entrydate, d.frameno, d.is_active, MAX(d.auto_id) AS mxid, COUNT(*) AS cnt
			FROM dofftable AS d
			WHERE d.doffdate = '".$date."' and company_id=".$compid." and is_active=1
			GROUP BY d.company_id, d.doffdate, d.spell, d.entrydate, d.frameno, d.is_active
			HAVING COUNT(*) > 1
		) AS g ON d1.entrydate = g.entrydate AND d1.auto_id = g.mxid
		SET d1.is_active = 0
		WHERE d1.is_active = 1";
		$this->db->query($sql);


        // Get the records for the specified date and shift
    //    $records = $this->Doffdata_Model->get_records($date, $shift,$compid);
		$sql="select auto_id,DATE_FORMAT(doffdate, '%d-%m-%Y') doffdate,spell,frameno,trollyno,grosswt,tarewt,netwt from dofftable where doffdate='$date' and 
		spell='$shift' and company_id=$compid and is_active=1 order by auto_id desc";
		
		$sql = "SELECT auto_id, DATE_FORMAT(doffdate, '%d-%m-%Y') doffdate, spell, frameno, trollyno, 
		grosswt, tarewt, netwt ,entrytime,entry_mode
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
                $record->entrytime,
				$record->entry_mode
                
            ];
        }

        // Return the response
        echo json_encode(['data' => $data]);
    }

	public function doffmodexpget_records() {
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
	$sql = "select id,mapping_date,tpwqm.quality_id,wqm.quality_code ,wqm.quality_name,tpwqm.spg_actual_count  from 
	tbl_prod_weaving_quality_mapping tpwqm 
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

public function get_doffreprecords() {
	$date = $this->input->post('date');
	$shift = $this->input->post('shift');
	$frameno = $this->input->post('doffrepframeNo');
	$compid = $this->input->post('compId');
	$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
	$sql = "select auto_id, DATE_FORMAT(doffdate , '%d-%m-%Y') doffdate,spell,frameno,ebno,q_code,trollyno,grosswt ,tarewt ,netwt,
	DATE_FORMAT(entrydate , '%H:%i') dofftime, concat(d.ebno,'-',thepd.first_name,' ',ifnull(thepd.middle_name,''),' ',thepd.last_name)  empname,  
	concat(ifnull(d.q_code,''),'-',ifnull(wqm.quality_name,'')) quality
	from dofftable d 
	left join weaving_quality_master wqm on wqm.quality_code =d.q_code and wqm.quality_type =2 and d.company_id =wqm.company_id 
	left join tbl_hrms_ed_official_details theod on theod.emp_code =d.ebno 
	left join tbl_hrms_ed_personal_details thepd on thepd.eb_id =theod.eb_id and d.company_id =thepd.company_id 
	where ifnull(theod.is_active,1) = 1 and  d.company_id =? and d.is_active =1  AND d.doffdate =? ";
    if (strlen($shift)>0 ) {
			$sql=$sql." and spell='".$shift."' ";
	}
	if (strlen($frameno)>0 ) {
		$sql=$sql." and frameno='".$frameno."' ";
	}
	$sql=$sql." order by auto_id desc
	";
//echo $sql;

$query = $this->db->query($sql, array($compid,$date ));
$records = $query->result();
$sln=$query->num_rows();
$data = [];
	foreach ($records as $record) {
		$data[] = [
			$sln,
			$record->doffdate,
			$record->spell,
			$record->frameno,
			$record->empname,
			$record->quality,
			$record->trollyno,
			$record->grosswt,
			$record->tarewt,
			$record->netwt,
			$record->dofftime,

		];
		$sln=$sln-1;
	}

	// Return the response
	echo json_encode(['data' => $data]);
}


public function get_doffreprecordschk() {
	$date = $this->input->post('date');
	$shift = $this->input->post('shift');
	$frameno = $this->input->post('doffrepframeNo');
	$compid = $this->input->post('compId');
	$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
	$sql = "select auto_id, DATE_FORMAT(doffdate , '%d-%m-%Y') doffdate,spell,frameno,ebno,q_code,trollyno,grosswt ,tarewt ,netwt,
	DATE_FORMAT(entrydate , '%H:%i') dofftime, concat(d.ebno,'-',thepd.first_name,' ',ifnull(thepd.middle_name,''),' ',thepd.last_name)  empname,  
	concat(ifnull(d.q_code,''),'-',ifnull(wqm.quality_name,'')) quality
	from dofftable d 
	left join weaving_quality_master wqm on wqm.quality_code =d.q_code and wqm.quality_type =2 and d.company_id =wqm.company_id 
	left join tbl_hrms_ed_official_details theod on theod.emp_code =d.ebno 
	left join tbl_hrms_ed_personal_details thepd on thepd.eb_id =theod.eb_id and d.company_id =thepd.company_id 
	where ifnull(theod.is_active,1) = 1 and  d.company_id =? and d.is_active =1  AND d.doffdate =? ";
    if (strlen($shift)>0 ) {
			$sql=$sql." and spell='".$shift."' ";
	}
 	$sql=$sql." and  ( length(IFNULL(d.ebno,''))=0 or length(IFNULL(d.q_code,''))=0)     order by auto_id desc
	";
//echo $sql;

$query = $this->db->query($sql, array($compid,$date ));
$records = $query->result();
$sln=$query->num_rows();
$data = [];
	foreach ($records as $record) {
		$data[] = [
			$sln,
			$record->doffdate,
			$record->spell,
			$record->frameno,
			$record->empname,
			$record->quality,
			$record->trollyno,
			$record->grosswt,
			$record->tarewt,
			$record->netwt,
			$record->dofftime,

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



if ($companyId==2) {
$designations = array(50, 195, 213, 241, 242, 252);
}
if ($companyId==1) {
	$designations = array(1143,1308,1309,928,929,1132);
}
$query = $this->db->select('dea.attendace_date,dea.spell,dea.eb_no,dea.mc_id,mm.frame_no')
                  ->from('daily_ebmc_attendance dea')
                  ->join('mechine_master mm', 'mm.mechine_id = dea.mc_id', 'left')
                  ->where('dea.company_id', $companyId)
                  ->where('dea.attendace_date', $doffdate)
                   ->where_in('designation_id', $designations)
                  ->where('dea.is_active', 1)
                 ->get();

//50.195,213,241,242,252

				  $records = $query->result_array();
				  $this->db->last_query();

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
$sq="UPDATE dofftable SET ebno = {$case_expression} WHERE company_id = {$companyId}";
//echo $sq;
$this->db->query("UPDATE dofftable SET ebno = {$case_expression} WHERE company_id = {$companyId}");

$this->db->last_query();
// Commit the transaction
$this->db->trans_complete();
$this->db->last_query();

if ($this->db->trans_status() === FALSE) {
    // Handle transaction error if needed.
}

$spell=$doffshift;

$sql="delete from EMPMILL12.tbl_emp_working_hours where atten_date='".$doffdate."' and att_spell='".$spell."'
and company_id=".$companyId;
$this->db->query($sql);


$sql="insert into EMPMILL12.tbl_emp_working_hours (atten_date,att_spell,att_working_hours,att_idle_hours,
att_mc_id,att_mc_stoppage_hours,
att_desig_id,eb_no,eb_id,company_id,att_type) SELECT da.attendance_date,da.spell,da.working_hours, 
ifnull(da.idle_hours,0) 
idle_hours,
dea.mc_id,IFNULL(dea.mc_stoppage_hours, 0) AS mcwhrs,da.worked_designation_id,da.eb_no,
da.eb_id,da.company_id,da.attendance_type 
FROM 
daily_attendance da 
LEFT JOIN 
daily_ebmc_attendance dea ON da.daily_atten_id = dea.daily_atten_id 
WHERE 
da.attendance_date BETWEEN '".$doffdate."' AND '".$doffdate."'
and da.spell='".$spell."' 
AND da.is_active = 1
AND dea.is_active = 1 
AND da.company_id = ".$companyId;
$this->db->query($sql);
 

$sql="
SELECT g.*
FROM EMPMILL12.tbl_emp_working_hours g
JOIN (
    SELECT atten_date, att_spell, att_mc_id
    FROM EMPMILL12.tbl_emp_working_hours
    WHERE atten_date = '".$doffdate."'  AND att_desig_id IN (252, 213,242,195,928,929,1132,1143,1308,1309,50)
    GROUP BY atten_date, att_spell, att_mc_id
    HAVING COUNT(*) > 1
) tewh
ON tewh.atten_date = g.atten_date 
    AND tewh.att_spell = g.att_spell 
    AND tewh.att_mc_id = g.att_mc_id and att_desig_id  in (252,242,928,929)";
	 
	$query = $this->db->query($sql);
	$records = $query->result();
	$sln=$query->num_rows();
		foreach ($records as $record) {
			$dsl=$record->emp_working_hoours_id;
			$sqld="delete from EMPMILL12.tbl_emp_working_hours where emp_working_hoours_id=".$dsl;
			$this->db->query($sqld);

	
		}	


		$sql="delete from EMPMILL12.tbl_doffdata_all_calc where doffdate='".$doffdate."' 
		and company_id=".$companyId;
		$this->db->query($sql);

$sql="insert into EMPMILL12.tbl_doffdata_all_calc ( 
	doffdate,
mc_id,
no_of_doff,
net_weight,
spell,
quality_id,
eb_id,
std_no_of_doff,
std_weight_per_doff,
mchours,
company_id,
frameno,
prod100,
working_hours
)
select
		doff.doffdate AS doffdate,
		mechine_id AS mc_id,
		doff.no_of_doff AS no_of_doff,
		doff.prod AS prod,
		doff.spell AS spell,
		wqm.quality_id,
		  wm.eb_id,
		round( ( round((((((wqm.speed * 60) * att.mcwhrs) * tpwqm.spg_actual_count) * wqm.spindle_count) / (((wqm.tpi * 14400) * 2.2046) * 36)), 3)  ) /wqm.std_doff_wt,2) std_no_of_doff,
		wqm.std_doff_wt AS std_doff_wt,
		att.mcwhrs AS mcwhrs,
		 doff.compid AS compid,
		 doff.frameno AS frameno,
		round((((((wqm.speed * 60) * att.mcwhrs) * tpwqm.spg_actual_count) * wqm.spindle_count) / (((wqm.tpi * 14400) * 2.2046) * 36)), 3) AS prod100,
		(attd.working_hours-idle_hours) working_hours
		from
		(
				select
			dftbl.doffdate AS doffdate,
			dftbl.company_id AS compid,
			mm.mechine_id AS mechine_id,
			dftbl.frameno AS frameno,
			dftbl.ebno AS ebno,
			dftbl.spell AS spell,
			substr(dftbl.spell, 1, 1) AS Shift,
			dftbl.q_code AS qcode,
			round(sum(dftbl.netwt), 3) AS prod,
			count(0) AS no_of_doff
		from
			vowsls.dofftable dftbl
		left join vowsls.mechine_master mm on
			dftbl.frameno = mm.frame_no
				and dftbl.company_id = mm.company_id
			where
			dftbl.netwt > 0
					and dftbl.is_active = 1 and dftbl.doffdate='".$doffdate."' and dftbl.company_id=".$companyId."

		group by
			dftbl.doffdate,
			dftbl.company_id,
			mm.mechine_id,
			dftbl.frameno,
			dftbl.ebno,
			dftbl.spell,
			substr(dftbl.spell, 1, 1),
			dftbl.q_code
			) doff
	left join (
		select
			tewh.atten_date AS attendance_date,
			tewh.att_spell AS attspell,
			tewh.att_mc_id AS mc_id,
			((tewh.att_working_hours - tewh.att_idle_hours) - ifnull(tewh.att_mc_stoppage_hours, 0)) AS mcwhrs
		from
			EMPMILL12.tbl_emp_working_hours tewh
		where
			tewh.att_desig_id in (50, 195, 213, 241, 242, 252, 928, 929, 1132, 1143, 1308, 1309) ) att on
			doff.doffdate = att.attendance_date
			and doff.spell = att.attspell
			and doff.mechine_id = att.mc_id
		left join vowsls.weaving_quality_master wqm on
		doff.qcode = wqm.quality_code
			and doff.compid = wqm.company_id
		left join vowsls.tbl_prod_weaving_quality_mapping tpwqm on
		wqm.quality_id = tpwqm.quality_id
			and tpwqm.mapping_date = doff.doffdate 
		left join worker_master wm on doff.ebno=wm.eb_no and wm.company_id=doff.compid   
		left join (
		select * from daily_attendance da where da.is_active=1 and company_id =".$companyId." and worked_designation_id in 
		(50, 195, 213, 241, 242, 252, 928, 929, 1132, 1143, 1308, 1309) and attendance_date ='".$doffdate."'
		) attd on doff.ebno=attd.eb_no and doff.spell=attd.spell and doff.doffdate=attd.attendance_date";

				$this->db->query($sql);



 //	$this->db->insert('spinning_yarn_type_daily', $data);

$response = array(
'success' => true,
'doffdate' => $doffdate,
'savedata'=> 'saved'
);

	echo json_encode($response);


}

public function updateiss() {
	ini_set('max_execution_time', 0);

	$sql = "
	select sih.*,tpmi.inward minward,tpmi.inward_detail  from
	(
	select sih.issue_no,sih.material_inventory_id , sih.inward,tpmi.inward_detail,sih.sr_line_id , is_active  from scm_issue_hdr sih 
	left join tbl_proc_material_inventory tpmi on sih.material_inventory_id =tpmi.material_inventory_id 
	where sih.is_active =1 and issue_status not in (4,6)
	) sih
	left join (select * from tbl_proc_material_inventory tpmi where tpmi.status not in (4,6)) tpmi
	on sih.material_inventory_id=tpmi.material_inventory_id 
	order by sih.issue_no desc 
	"; // Only select records with non-null inward_detail
	echo $sql;
	
	$query = $this->db->query($sql);
	$records = $query->result_array();
	foreach ($records as $updateData) {
		$inwardDetail = $updateData['inward_detail'];
		$issueNo = $updateData['issue_no'];
	
		$data = array(
			'sr_line_id' => $inwardDetail,
			);
	
	//var dump($data);
	
	$this->db->where('issue_no', $issueNo);
	$this->db->update('scm_issue_hdr', $data);

}		

	$response = array(
		'success' => true,
		'doffdate' => 1,
		'savedata'=> 'saved'
		);
		
			echo json_encode($response);
		
		
		}
		

public function updateissue_data() {
	ini_set('max_execution_time', 0);
	$db['default']['db_debug'] = TRUE;
	$this->load->database();
	$config['log_threshold'] = 4;

	$doffdate = $this->input->post('spgdailyDate');
	$companyId = $this->input->post('companyId');
	$created_by=26577;
	$active=1;
	$doffdate=substr($doffdate,6,4).'-'.substr($doffdate,3,2).'-'.substr($doffdate,0,2);
//	exit();


 
// Start the transaction to ensure data for update qcode in dofftable
$this->db->trans_start();

$limit=10;

echo 'upadte issue data';

$sql="select tpi.inward_id ,tpid.inward,tpid.indent_details_id,tpid.item,tpid.approved_qty,
tpmi.material_inventory_id,tpmi.inward minward,tpmi.inward_detail,tpmi.qty,tpmi.balanace_qty  from tbl_proc_inward tpi 
left join (select * from tbl_proc_inward_detail tpid where is_active=1) tpid
on tpi.inward_id =tpid.inward
left join (select * from tbl_proc_material_inventory tpmi where qty is not null ) tpmi on tpi.inward_id =tpmi.inward and tpid.indent_details_id=tpmi.inward_detail 
where tpi.sr_status =3 and tpmi.qty is not null
order by inward_id desc ";


// Define the batch size
$batchSize = 1;

// Query to retrieve records in batches
$sql = "
select sih.*,tpmi.inward minward,tpmi.inward_detail  from
(
select sih.issue_no,sih.material_inventory_id , sih.inward,tpmi.inward_detail,sih.sr_line_id , is_active  from scm_issue_hdr sih 
left join tbl_proc_material_inventory tpmi on sih.material_inventory_id =tpmi.material_inventory_id 
where sih.is_active =1 and issue_status not in (4,6)
) sih
left join (select * from tbl_proc_material_inventory tpmi where tpmi.status not in (4,6)) tpmi
on sih.material_inventory_id=tpmi.material_inventory_id 
order by sih.issue_no desc limit 1
"; // Only select records with non-null inward_detail
echo $sql;

$query = $this->db->query($sql);
$records = $query->result_array();

/*
// Count the total number of records
$totalRecords = count($records);

// Initialize a variable to keep track of the current batch start index
$currentBatchStart = 0;

// Begin a database transaction
$this->db->trans_start();

while ($currentBatchStart < $totalRecords) {
    // Extract a batch of records based on the batch size
    $currentBatch = array_slice($records, $currentBatchStart, $batchSize);

    // Build the CASE expression for the current batch
    $caseExpression = 'CASE ';
    foreach ($currentBatch as $updateData) {
        $inwardDetail = $updateData['inward_detail'];
        $issueNo = $updateData['issue_no'];
        $caseExpression .= "WHEN issue_no = '{$issueNo}' THEN '{$inwardDetail}' ";
    }
    $caseExpression .= 'ELSE sr_line_id END';
	$companyId=2;
	$sqlt="UPDATE scm_issue_hdr SET sr_line_id = {$caseExpression} WHERE company_id =2";
//	echo "<br>".'12345='.$sqlt."<br>";
    // Update the scm_issue_table for the current batch
	try {
		$this->db->query("UPDATE scm_issue_hdr SET sr_line_id = {$caseExpression} WHERE company_id = {$companyId}");

//		$this->db->query($sqlt);
	} catch (Exception $e) {
		echo 'Database error: ' . $e->getMessage();
	}
	
	echo  $currentBatchStart;
//	echo $caseExpression;
	$this->db->last_query();
//	$this->db->last_query();
    // Increment the batch start index
    $currentBatchStart += $batchSize;
}

// Commit the database transaction
$this->db->trans_complete();



if ($this->db->trans_status() === FALSE) {
    // Handle transaction error if needed.
}


//$this->db->query($sqlt);
echo $this->db->last_query(); // Output the last executed query
*/
foreach ($records as $updateData) {
	$inwardDetail = $updateData['inward_detail'];
	$issueNo = $updateData['issue_no'];
//	$caseExpression .= "WHEN issue_no = '{$issueNo}' THEN '{$inwardDetail}' ";

	$data = array(
        'sr_line_id' => $inwardDetail,
		);

//var dump($data);

$this->db->where('issue_no', $issueNo);
$this->db->update('scm_issue_hdr', $data);

}





$response = array(
	'success' => true,
	'frameNo' => 1,
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
	
		$sql = "select substr(spell,1,1) shift,spell,grosswt,DATE_FORMAT(doffdate,'%d-%m-%y') doffdate,DATE_FORMAT(entrydate , '%H:%i') dofftime,
		frameno ,tarewt ,netwt 
		from dofftable where doffdate='".$sdate."'  and company_id=".$compid." and is_active=1   ";
	
		$query = $this->db->query($sql);
		$data = $query->result_array();
	
		$fileContainer = "data.txt";
		$filePointer = fopen($fileContainer,"w+");
	
		$logMsg='';
		$rowIndex = 4;
		foreach ($data as $row) {
			$logMsg.= $row['shift'].",".$row['spell'].",,".$row['grosswt'].",,".$row['doffdate'].",".$row['dofftime'].",,".$row['frameno'].",".$row['tarewt'].",".$row['netwt']."\r\n";
	
		}	
	
		fputs($filePointer,$logMsg);
		fclose($filePointer);

					$sql="select DATE_FORMAT(doffdate,'%d-%m-%Y') doffdate,shift,mm.mech_code  frameno,ebspell1,ebqcode1,ebspell2,ebqcode2 from 
					(
					select doffdate,shift,frameno dframeno, 
					max(case when (substr(spell,2,1)<>'2') then ebno else ' ' end) ebspell1, 
					max(case when substr(spell,2,1)<>'2' then q_code else ' ' end) ebqcode1,
					max(case when substr(spell,2,1)='2' then ebno else ' ' end) ebspell2 ,
					max(case when substr(spell,2,1)='2' then q_code else ' ' end) ebqcode2
					from ( 
					select distinct(doffdate) doffdate, substr(spell,1,1) shift,spell, frameno, ebno,q_code from dofftable d 
					where d.company_id =".$compid." and doffdate ='".$sdate."' and is_active =1 
					) g group by doffdate,shift,dframeno
					) k left join mechine_master mm on k.dframeno=mm.frame_no 
					where mm.company_id =".$compid ;
 	
		$query = $this->db->query($sql);
		$data = $query->result_array();
	
		$fileContainer1 = "data2.ebq";
		$filePointer1 = fopen($fileContainer1,"w+");
	
//		26-07-2023,A,33001,19121,111189,19121,111189

		$logMsg='';
		$rowIndex = 4;
		foreach ($data as $row) {
			$logMsg.=$row['doffdate'].",".$row['shift'].",".$row['frameno'].",".$row['ebspell1'].",".$row['ebqcode1'].",".$row['ebspell2'].",".$row['ebqcode2']."\r\n";
	
		}	
	
		fputs($filePointer1,$logMsg);
		fclose($filePointer1);
	 

		$sql="select da.eb_no,mm.mech_code,da.spell,DATE_FORMAT(da.attendance_date,'%d/%m/%Y') att_date,(da.working_hours -ifnull(da.idle_hours,0)) whrs   from daily_ebmc_attendance dea 
		left join mechine_master mm on dea.mc_id =mm.mechine_id and dea.company_id =mm.company_id 
		left join daily_attendance da on dea.daily_atten_id =da.daily_atten_id
		where attendace_date ='".$sdate."' and designation_id in (51,196) and dea.is_active =1 
		and da.is_active =1 and da.company_id=".$compid."  
		order by mm.mech_code ,spell"
		 ;

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$fileContainer2 = "PICmc.mcd";
		$filePointer2 = fopen($fileContainer2,"w+");

		//		26-07-2023,A,33001,19121,111189,19121,111189

		$logMsg='';
		$rowIndex = 4;
		foreach ($data as $row) {
		$logMsg.=$row['eb_no'].",".$row['mech_code'].",".$row['spell'].",".$row['att_date'].",".$row['whrs']."\r\n";

		}	

		fputs($filePointer2,$logMsg);
		fclose($filePointer2);


		$sql="select da.eb_no,mm.mech_code,da.spell,DATE_FORMAT(da.attendance_date,'%d/%m/%Y') att_date,(da.working_hours -ifnull(da.idle_hours,0)) whrs   from daily_ebmc_attendance dea 
		left join mechine_master mm on dea.mc_id =mm.mechine_id and dea.company_id =mm.company_id 
		left join daily_attendance da on dea.daily_atten_id =da.daily_atten_id
		where attendace_date ='".$sdate."' and designation_id in (53,198,57) and dea.is_active =1 
		and da.is_active =1 and da.company_id=".$compid."  
		order by mm.mech_code ,spell"
		 ;

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$fileContainer3 = "DOFmc.mcd";
		$filePointer3 = fopen($fileContainer3,"w+");

		//		26-07-2023,A,33001,19121,111189,19121,111189

		$logMsg='';
		$rowIndex = 4;
		foreach ($data as $row) {
		$logMsg.=$row['eb_no'].",".$row['mech_code'].",".$row['spell'].",".$row['att_date'].",".$row['whrs']."\r\n";

		}	

		fputs($filePointer3,$logMsg);
		fclose($filePointer3);

		$sql="select da.eb_no,mm.mech_code,da.spell,DATE_FORMAT(da.attendance_date,'%d/%m/%Y') att_date,(da.working_hours -ifnull(da.idle_hours,0)) whrs   from daily_ebmc_attendance dea 
		left join mechine_master mm on dea.mc_id =mm.mechine_id and dea.company_id =mm.company_id 
		left join daily_attendance da on dea.daily_atten_id =da.daily_atten_id
		where attendace_date ='".$sdate."' and designation_id in (52,507,197) and dea.is_active =1 
		and da.is_active =1 and da.company_id=".$compid."  
		order by mm.mech_code ,spell"
		 ;

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$fileContainer4 = "SLVmc.mcd";
		$filePointer4 = fopen($fileContainer4,"w+");

		//		26-07-2023,A,33001,19121,111189,19121,111189

		$logMsg='';
		$rowIndex = 4;
		foreach ($data as $row) {
		$logMsg.=$row['eb_no'].",".$row['mech_code'].",".$row['spell'].",".$row['att_date'].",".$row['whrs']."\r\n";

		}	

		fputs($filePointer4,$logMsg);
		fclose($filePointer4);

		
		$sql="select da.eb_no,mm.mech_code,da.spell,DATE_FORMAT(da.attendance_date,'%d/%m/%Y') att_date,(da.working_hours -ifnull(da.idle_hours,0)) whrs   from daily_ebmc_attendance dea 
		left join mechine_master mm on dea.mc_id =mm.mechine_id and dea.company_id =mm.company_id 
		left join daily_attendance da on dea.daily_atten_id =da.daily_atten_id
		where attendace_date ='".$sdate."' and designation_id in (213,50,55,241,252,195,242) and dea.is_active =1 
		and da.is_active =1 and da.company_id=".$compid."  
		order by mm.mech_code ,spell"
		 ;

		$query = $this->db->query($sql);
		$data = $query->result_array();

		$fileContainer5 = "spgmc.mcd";
		$filePointer5 = fopen($fileContainer5,"w+");

		//		26-07-2023,A,33001,19121,111189,19121,111189

		$logMsg='';
		$rowIndex = 4;
		foreach ($data as $row) {
		$logMsg.=$row['eb_no'].",".$row['mech_code'].",".$row['spell'].",".$row['att_date']."\r\n";

		}	

		fputs($filePointer5,$logMsg);
		fclose($filePointer5);



/*
		header('Content-Type: application/x-www-form-urlencoded');
		header('Content-Transfer-Encoding: Binary');
		header("Content-disposition: attachment; filename=\"".$fileContainer."\"");
		readfile($fileContainer);
		unlink($fileContainer);
*/
$txt1="data.txt";
$txt2="data2.ebq";
$txt3=$fileContainer2;
$txt4=$fileContainer3;
$txt5=$fileContainer4;
$txt6=$fileContainer5;

$files = array($txt1,$txt2,$txt3,$txt4,$txt5,$txt6);
$zipname = 'doffdata.zip';
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
		unlink($fileContainer1);
		unlink($zipname);



	}
	
/*
*/

public function get_doff10_records() {
	$date = $this->input->post('date');
	$compid = $this->input->post('compId');
	$frameNo = $this->input->post('doffrepframeNo');
	
// echo 'frame--'.$frameNo;
	$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
	
	$this->load->model('Doffdata_Model');
	$records = $this->Doffdata_Model->getDoff10Data($date, $compid,$frameNo);

//	echo $sql;
//	$records=$this->db->query($sql);
//	echo $sql;
	// Prepare the response
	$data = [];
	foreach ($records as $record) {
		$data[] = [
			$record->mech_code,
			$record->bobbin_count,
			$record->stddoffwt,
			$record->a1quality,
			$record->a1empname,
			$record->a1stddoff,
			$record->a1doff,
			$record->a1netwt,
			$record->a1avgwtdoff,
			$record->a2quality,
			$record->a2empname,
			$record->a2stddoff,
			$record->a2doff,
			$record->a2netwt,
			$record->a2avgwtdoff,
			$record->adoff,
			$record->anetwt,
			$record->aavgwt,
			$record->aeff,
			$record->b1quality,
			$record->b1empname,
			$record->b1stddoff,
			$record->b1doff,
			$record->b1netwt,
			$record->b1avgwtdoff,
			$record->b2quality,
			$record->b2empname,
			$record->b2stddoff,
			$record->b2doff,
			$record->b2netwt,
			$record->b2avgwtdoff,
			$record->bdoff,
			$record->bnetwt,
			$record->bavgwt,
			$record->beff,
			$record->cquality,
			$record->cempname,
			$record->cstddoff,
			$record->cdoff,
			$record->cnetwt,
			$record->cavgwt,
			$record->ceff,
			$record->odoff,
			$record->onetwt,
			$record->oavgwt,
			$record->oeff
 			
		];

		
	}
$a1='';
	$records = $this->Doffdata_Model->getDoff10sumData($date, $compid,$frameNo);
	foreach ($records as $record) {
		$data[] = [
			$record->mech_code,
			$record->bobbin_count,
			$record->stddoffwt,
			$a1,
			$a1,
			$record->a1stddoff,
			$record->a1doff,
			$record->a1netwt,
			$record->a1avgwtdoff,
			$a1,
			$a1,
			$record->a2stddoff,
			$record->a2doff,
			$record->a2netwt,
			$record->a2avgwtdoff,
			$record->adoff,
			$record->anetwt,
			$record->aavgwt,
			$record->aeff,
			$a1,
			$a1,
			$record->b1stddoff,
			$record->b1doff,
			$record->b1netwt,
			$record->b1avgwtdoff,
			$a1,
			$a1,
			$record->b2stddoff,
			$record->b2doff,
			$record->b2netwt,
			$record->b2avgwtdoff,
			$record->bdoff,
			$record->bnetwt,
			$record->bavgwt,
			$record->beff,
			$a1,
			$a1,
			$record->cstddoff,
			$record->cdoff,
			$record->cnetwt,
			$record->cavgwt,
			$record->ceff,
			$record->odoff,
			$record->onetwt,
			$record->oavgwt,
			$record->oeff
 			
		];

		
	}

	



	// Return the response
	echo json_encode(['data' => $data]);
}


public function get_doffqcsum_records() {
	$date = $this->input->post('date');
	$compid = $this->input->post('compId');
	$frameNo = $this->input->post('doffrepframeNo');
	
// echo 'frame--'.$frameNo;
	$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
	
	$this->load->model('Doffdata_Model');
	$records = $this->Doffdata_Model->getDoffqcsummData($date, $compid,$frameNo);

//	echo $sql;
//	$records=$this->db->query($sql);
//	echo $sql;
	// Prepare the response
	$data = [];
	foreach ($records as $record) {
		$data[] = [
			$record->q_code,
			$record->quality_name,
			$record->afrm,
			$record->bfrm,
			$record->cfrm,
			$record->tnofrm,
			$record->awt,
			$record->bwt,
			$record->cwt,
			$record->tnetwt,
  			
		];

		
 
		
	}

	



	// Return the response
	echo json_encode(['data' => $data]);
}


public function spgquality_data() {
	$date = $this->input->post('spgdailyDate');
	$compid = $this->input->post('compId');
	$spgquality_id = $this->input->post('spgquality_id');
	
// echo 'frame--'.$frameNo;
	$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
	
	$this->load->model('Doffdata_Model');
	$records = $this->Doffdata_Model->getspgqualityselData($date, $compid,$spgquality_id);

//	echo $sql;
//	$records=$this->db->query($sql);
//	echo $sql;
	// Prepare the response
	$data = [];
	foreach ($records as $record) {
		$data[] = [
			$record->q_code,
			$record->quality_name,
			$record->afrm,
			$record->bfrm,
			$record->cfrm,
			$record->tnofrm,
			$record->awt,
			$record->bwt,
			$record->cwt,
			$record->tnetwt,
  			
		];

		
 
		
	}

	



	// Return the response
	echo json_encode(['data' => $data]);
}

public function get_spgdailydatarecords() {
	$date = $this->input->post('date');
	$compid = $this->input->post('companyId');
	$date=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
	$sql="select tpwqm.*,wqm.quality_code,wqm.speed ,wqm.tpi ,
	wqm.tar_eff,wqm.yarn_count,'g' rem    from tbl_prod_weaving_quality_mapping tpwqm 
	left join weaving_quality_master wqm on tpwqm.quality_id  =wqm.quality_id 
	where mapping_date ='".$date."' and tpwqm.quality_type =2 and tpwqm.is_active =1
	and tpwqm.company_id =".$compid." order by quality_code";
	$records = $this->db->query($sql)->result_array();
	$cnt=count($records);
	foreach ($records as $record) {
		$qc=	$record['quality_code']	;
		$sqlq="select * from EMPMILL12.spining_daily_transaction where tran_date ='".$date."' and company_id=".$compid."
		and q_code='".$qc."'";
		$recs = $this->db->query($sqlq)->result_array();
		$cntq=count($recs);
		if ($cntq==0) {

			$data = array(
				'company_id' => $compid,
				'tran_date' => $date,
				'q_code' =>$record['quality_code'],
				'act_count' =>$record['spg_actual_count'],
				'speed' =>$record['speed'],
				'twist_per_inch' =>$record['tpi'],
				'tar_eff' =>$record['tar_eff'],
				'mc_a' =>0,
				'mc_b' =>0,
				'mc_c' =>0,
				'winder' =>0,
				'prd_a' =>0,
				'prd_b' =>0,
				'tar_prd' =>0,
				'hunprod' =>0,
				'act_eff' =>0,
				'std_count' =>$record['yarn_count'],
				'tot_hrs' =>23.50,
				'hrs_a' =>8.00,
				'hrs_b' =>8.00,
				'hrs_c' =>7.50,
				'eff_a' =>0,
				'eff_b' =>0,
				'eff_c' =>0,
				'tarprda' =>0,
				'tarprdb' =>0,
				'tarprdc' =>0,


				// Exclude 'id' and 'updated_by' fields
			);
			$this->db->insert('EMPMILL12.spining_daily_transaction', $data);
					

		}

	}

	$sql="   select DATE_FORMAT(tran_date,'%d-%m-%Y') trandate,sdt.q_code,concat(sdt.std_count,' Lbs ',sm.subgroup_type,'/',sm.frame_type,' / ',sm.spindle) quality,
	sdt.act_count ,winder ,hrs_a ,hrs_b ,hrs_c,(hrs_a+hrs_b+hrs_c) tothrs,  mc_a,mc_b ,mc_c,(mc_a+mc_b+mc_c) totmc,
	prd_a,prd_b,prd_c,(prd_a+prd_b+prd_c) totprd,tar_prd ,round(tar_prd /(mc_a+mc_b+mc_c),0) tarprd_frm,act_eff ,
	round((prd_a+prd_b+prd_c)/(mc_a+mc_b+mc_c),0) prd_frm,sdt.twist_per_inch,sdt.std_count ,sm.speed ,sm.spindle ,sm.frame_type ,
	sm.e_type ,sm.subgroup_type, round((prd_a+prd_b+prd_c)/(winder),0) prd_wnd
	from EMPMILL12.spining_daily_transaction sdt 
	left join EMPMILL12.spining_master sm on sdt.q_code = sm.q_code 
	where tran_date ='".$date."' and sdt.company_id=".$compid." order by sdt.q_code";
	$records = $this->db->query($sql)->result_array();
	$data = [];
	$cnt=count($records);
	if ($cnt>0) {
		foreach ($records as $record) {
			$data[] = [
				$record['trandate'],
				$record['q_code'],
				$record['quality'],
				$record['speed'],
				$record['twist_per_inch'],
				$record['act_count'],
				$record['winder'],
				$record['mc_a'],
				$record['mc_b'],
				$record['mc_c'],
				$record['totmc'],
				$record['hrs_a'],
				$record['hrs_b'],
				$record['hrs_c'],
				$record['tothrs'],
				$record['prd_a'],
				$record['prd_b'],
				$record['prd_c'],
				$record['totprd'],
				$record['tar_prd'],
				$record['tarprd_frm'],
				$record['act_eff'],
				$record['prd_frm'],
				$record['prd_wnd'],
				$record['e_type'],
				$record['frame_type'],
				$record['spindle'],
				$record['std_count']
			];
		}
	}

 

	// Return the response
	echo json_encode(['data' => $data]);
}

public function dof10ana() {
	// Get the parameters from the URL query string
//	$postData = json_decode(file_get_contents('php://input'), true);
// $this->load->view('admin/reports/pfesidata');


$sdate = $this->input->post('doff10repdate');
$compid = $this->input->post('companyId');

$sdate = $this->input->get('doff10repdate');
$compid = $this->input->get('companyId');
$frameNo=1;
//$this->load->view('admin/doffdata/doff10analysis');
 $data = array(
        'sdate' => $sdate,
        'compid' => $compid,
        'frameNo' => 1
    );

    $this->load->view('admin/doffdata/doff10analysis', $data);


}






public function dof10exportToExcel() {
	// Get the parameters from the URL query string
//	$postData = json_decode(file_get_contents('php://input'), true);
// $this->load->view('admin/reports/pfesidata');


$sdate = $this->input->post('doff10repdate');
$compid = $this->input->post('companyId');

$sdate = $this->input->get('doff10repdate');
$compid = $this->input->get('companyId');
$frameNo=1;

echo 'aha-'.$sdate;

//$sdate='01-06-2023';
//$edate='30-06-2023';
//$compid=2;
//$payScheme = $this->input->GET('payScheme');

//echo 'date-'.$sdate;
 	$date=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
  
 
    $sql="select * from company_master where comp_id=".$compid;
	$query = $this->db->query($sql);
	$records = $query->result();
//	$query1=$this->db->query($sql);
	$name='';
	if ( $query->num_rows()>0 ) {
 		$row1 = $query->row();
		$name=$row1->company_name;
 	}	
	 $this->load->model('Doffdata_Model');
	 $records = $this->Doffdata_Model->getDoff10Data($date, $compid,$frameNo);

//	$query = $this->db->query($sql);
//	$data = $query->result_array();

	// Create a new Spreadsheet object
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

    
    $cmpn=$name;
	$sheet->setCellValue('A1', $cmpn);
	$sheet->setCellValue('A2', "Doff 10 Reports for Dated : ".$sdate);
	$rowIndex = 3;

	$columnIndex = 1;

	$value='Frame Details';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Shift A1';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Shift A2';	
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Shift A';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Shift B1';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Shift B2';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Shift B';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Shift C';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Overall';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;

	$sheet->mergeCells('A3:C3');
	$cellStyleA1C3 = $sheet->getStyle('A1:C3');
	$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$value='Frame Details';	
	$columnIndex=1;
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	
	$sheet->mergeCells('D3:I3');
	$cellStyleA1C3 = $sheet->getStyle('D3:I3');
	$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$value='Spell A1';	
	$columnIndex=4;
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);

	$sheet->mergeCells('J3:O3');
	$cellStyleA1C3 = $sheet->getStyle('J3:O3');
	$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$value='Spell A2';	
	$columnIndex=10;
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	
	$sheet->mergeCells('P3:S3');
	$cellStyleA1C3 = $sheet->getStyle('P3:S3');
	$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$value='Shift A';	
	$columnIndex=16;
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);

	$sheet->mergeCells('T3:Y3');
	$cellStyleA1C3 = $sheet->getStyle('T3:Y3');
	$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$value='Spell B1';	
	$columnIndex=20;
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);

	$sheet->mergeCells('Z3:AE3');
	$cellStyleA1C3 = $sheet->getStyle('Z3:AE3');
	$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$value='Spell B2';	
	$columnIndex=26;
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	
	$sheet->mergeCells('AF3:AI3');
	$cellStyleA1C3 = $sheet->getStyle('AF3:AI3');
	$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$value='Shift B';	
	$columnIndex=32;
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);


	$sheet->mergeCells('AJ3:AP3');
	$cellStyleA1C3 = $sheet->getStyle('AJ3:AP3');
	$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$value='Shift C';	
	$columnIndex=36;
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);

	$sheet->mergeCells('AQ3:AT3');
	$cellStyleA1C3 = $sheet->getStyle('AQ3:AT3');
	$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$value='OVERALL';	
	$columnIndex=43;
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$sheet->mergeCells('P3:S3');

 
 

	$rowIndex ++;;
	$columnIndex = 1;

	$value='Frame No';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='No of Spindle';	
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Std Avg Wt/doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Quality';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Employee';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Std Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='No of Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Prod';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Avg Doff Wt';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Quality';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Employee';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Std Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='No of Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Prod';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Avg Doff Wt';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='No of Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Prod';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Avg Doff Wt';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Eff(%)';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Quality';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Employee';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Std Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='No of Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Prod';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Avg Doff Wt';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Quality';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Employee';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Std Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='No of Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Prod';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Avg Doff Wt';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='No of Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Prod';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Avg Doff Wt';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Eff(%)';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Quality';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Employee';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Std Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='No of Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Prod';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Avg Doff Wt';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Eff%';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='No of Doff';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Prod';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Avg Doff Wt';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
	$value='Eff%';
	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
	$columnIndex++;
 
 

 	
	// Set company name
	$companyName = $cmpn;
	$rowIndex ++;;
	$columnIndex = 1;    
	foreach ($records as $record) {
		$columnIndex = 1;
		$value=$record->mech_code;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->bobbin_count;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->stddoffwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a1quality;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a1empname;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a1stddoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a1doff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a1netwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a1avgwtdoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a2quality;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a2empname;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a2stddoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a2doff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a2netwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->a2avgwtdoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->adoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->anetwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->aavgwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->aeff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b1quality;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b1empname;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b1stddoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b1doff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b1netwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b1avgwtdoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b2quality;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b2empname;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b2stddoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b2doff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b2netwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->b2avgwtdoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->bdoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->bnetwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->bavgwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->beff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->cquality;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->cempname;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->cstddoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->cdoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->cnetwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->cavgwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->ceff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->odoff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->onetwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->oavgwt;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value=$record->oeff;
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
	/*
		foreach ($record as $value) {
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
		}
*/
		$rowIndex++;
	}	



	$sheet->mergeCells('A1:E1');
	$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
	$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $filename="doff10_".$date.'.xlsx';
	// Set headers for Excel file download
//	ob_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//	header('Content-Disposition: attachment;filename="your_excel_file.xlsx"');

//		header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename='.$filename);
	header('Cache-Control: max-age=0');
	ob_clean();

	// Save the Excel file to output stream
	$writer = new Xlsx($spreadsheet);
	$writer->save('php://output');
	// Save the Excel file to output stream
//	$writer = new Xlsx($spreadsheet);
//	$writer->save('php://output');
 


}






public function dofonlineexportToExcel() {
	// Get the parameters from the URL query string
//	$postData = json_decode(file_get_contents('php://input'), true);
// $this->load->view('admin/reports/pfesidata');


$sdate = $this->input->post('doffrepdate');
$compid = $this->input->post('companyId');

$sdate = $this->input->get('doffrepdate');
$compid = $this->input->get('companyId');
$frameNo = $this->input->get('doffrepframeNo');
$shiftName = $this->input->get('doffrepshiftName');



echo 'aha-'.$sdate;

//$sdate='01-06-2023';
//$edate='30-06-2023';
//$compid=2;
//$payScheme = $this->input->GET('payScheme');

//echo 'date-'.$sdate;
 	$date=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
  
	 $this->load->model('Doffdata_Model');
	 $records = $this->Doffdata_Model->getDoffrepData($date, $compid,$frameNo,$shiftName);
 


//	$query = $this->db->query($sql);
//	$data = $query->result_array();

	// Create a new Spreadsheet object
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

    $cmpn="company";
   
    $cmpn="your company";
//	$active_sheet->setCellValue('A1', $cmpn);
//	$active_sheet->setCellValue('A2', "Reports for Dated : ");
	// Set company name
	$companyName = "Your Company Name";
	$rowIndex = 4;
	foreach ($records as $record) {
		$columnIndex = 1;
		foreach ($record as $value) {
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
		}
		$rowIndex++;
	}	



	$sheet->mergeCells('A1:E1');
	$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
	$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $filename="doffonline_".$date.'.xlsx';
	// Set headers for Excel file download
//	ob_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//	header('Content-Disposition: attachment;filename="your_excel_file.xlsx"');

//		header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename='.$filename);
	header('Cache-Control: max-age=0');
	ob_clean();

	// Save the Excel file to output stream
	$writer = new Xlsx($spreadsheet);
	$writer->save('php://output');
	// Save the Excel file to output stream
//	$writer = new Xlsx($spreadsheet);
//	$writer->save('php://output');
 


}

public function lomdataexportToExcel() {
	// Get the parameters from the URL query string
//	$postData = json_decode(file_get_contents('php://input'), true);
// $this->load->view('admin/reports/pfesidata');


$sdate = $this->input->post('doffrepdate');
$edate = $this->input->post('doffrepdateto');
$compid = $this->input->post('companyId');

$sdate = $this->input->get('doffrepdate');
$edate = $this->input->get('doffrepdateto');
$compid = $this->input->get('companyId');
 


echo 'aha-'.$sdate;

 	$date=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
 	$endate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
  
	 $this->load->model('Doffdata_Model');
	 $records = $this->Doffdata_Model->getloomrepData($date,$endate, $compid);
//	 $records = $this->Winding_data_reports_Model->getspginputexl($date, $compid);




	// Create a new Spreadsheet object
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

    $cmpn="company";
   
    $cmpn="your company";
	$companyName = "Your Company Name";
	
	
	$rowIndex = 2;


	foreach ($records as $record) {
		$columnIndex = 1;
		foreach ($record as $value) {
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
		}
		$rowIndex++;
	}	



	$sheet->mergeCells('A1:E1');
	$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
	$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $filename="doffonline_".$date.'.xlsx';
	// Set headers for Excel file download
//	ob_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//	header('Content-Disposition: attachment;filename="your_excel_file.xlsx"');

//		header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename='.$filename);
	header('Cache-Control: max-age=0');
	ob_clean();

	// Save the Excel file to output stream
	$writer = new Xlsx($spreadsheet);
	$writer->save('php://output');
	// Save the Excel file to output stream
//	$writer = new Xlsx($spreadsheet);
//	$writer->save('php://output');
 


}

public function loomdataexportToExcel() {
	
	
	$sdate = $this->input->get('doffrepdate');
	$edate = $this->input->get('doffrepdateto');
	$compid = $this->input->get('companyId');
	echo 'aha-'.$sdate;
		 $date=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
		 $endate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
	  
		 $this->load->model('Doffdata_Model');
		 $records = $this->Doffdata_Model->getloomrepData($date,$endate, $compid);
//		 $records = $this->Winding_data_reports_Model->getspginputexl($date, $compid);
		 $cnt=count($records);


		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
	
		
		$rowIndex = 1;
	
		$columnIndex = 1;
 
		$value='LOOMDET';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Date';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Loom No';	
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Spell';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Production';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Hours';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='Std Prod';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='EBNO';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='QCode';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='EFFICIENCY';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$value='AShots';
		$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
		$columnIndex++;
		$nn=1;


		$columnIndex++;
		$columnIndex = 1;    
		$mcc="";
		$mcnum="";
	   $sp=""; 
	   $cn=0;
	   $tprd=0;
	   $spprd=0;
	   $totprd=0;
	   $totspprd=0;

	   $nn=1;
	//   $records = $this->Doffdata_Model->getloomrepData($date,$endate, $compid);
	   foreach ($records as $record) {
			$lmdet=$record->mech_code.$record->loomdate.$record->spell;
			$mcnum=$record->mech_code;
			$lmdate=$record->loomdate;
			$spl=$record->spell;
			$prod=$record->prod;
			$whrs=$record->whrs;
			$stdprod=$record->stdprod;
			$ebno=$record->ebno;
			$qcode=$record->qcode;
			$eff=$record->eff;
			$ashots=$record->ashots;
		
			$rowIndex++;
				$columnIndex=1;
				$value=$lmdet;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$mcnum;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$lmdate;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$spl;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$prod;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$whrs;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$stdprod;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$ebno;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$qcode;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$eff;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$ashots;
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
		
		
  			$cn++;			
}


 
$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('E')->setWidth(20);
$nn=71;	
while ($nn<=82) { 
	$r1=chr($nn);

	$sheet->getColumnDimension($r1)->setWidth(4);
	$nn++;
}
		$filename="vwloomdata_".$date.'.xlsx';
		// Set headers for Excel file download
	//	ob_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	//	header('Content-Disposition: attachment;filename="your_excel_file.xlsx"');
	
	//		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename='.$filename);
		header('Cache-Control: max-age=0');
		ob_clean();
	
		// Save the Excel file to output stream
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		// Save the Excel file to output stream
	//	$writer = new Xlsx($spreadsheet);
	//	$writer->save('php://output');
	 
	
	
	}
		



public function savespgdaily_data() {

 
	$companyId=$this->input->post('companyId');
	$spgdailyDate=$this->input->post('spgdailyDate');
	$spgquality_id=$this->input->post('spgquality_id');
	$spgactcount=$this->input->post('spgactcount');
	$spgdailyahrs=$this->input->post('spgdailyahrs');
	$spgdailybhrs=$this->input->post('spgdailybhrs');
	$spgdailychrs=$this->input->post('spgdailychrs');
	$spgnowinder=$this->input->post('spgnowinder');
	$spgnofrma=$this->input->post('spgnofrma');
	$spgnofrmb=$this->input->post('spgnofrmb');
	$spgnofrmc=$this->input->post('spgnofrmc');
	$spgnofrmtot=$this->input->post('spgnofrmtot');
	$spgproda=$this->input->post('spgproda');
	$spgprodb=$this->input->post('spgprodb');
	$spgprodc=$this->input->post('spgprodc');
	$spgspeed=$this->input->post('spgspeed');
	$spgspindle=$this->input->post('spgspindle');
	$spgtpi=$this->input->post('spgtpi');
	$spgdailyDate=substr($spgdailyDate,6,4).'-'.substr($spgdailyDate,3,2).'-'.substr($spgdailyDate,0,2);
   	$active=1;
	   $sql="select tar_eff from EMPMILL12.spining_master where company_id=".$companyId." and q_code='".$spgquality_id."'"  ;
	   $query = $this->db->query($sql);
	// 	echo $this->db->last_query();  
	   $records = $query->result();
	   $name='';
	   if ( $query->num_rows()>0 ) {
			$row1 = $query->row();
	  	   $tef=$row1->tar_eff;
		}	
 //echo $sql;  

	   $pmc=0;
	   if ($spgnofrma>0) { 
		   $pmc++;
	   }
	   if ($spgnofrmb>0) { 
	   $pmc++;
	   }
	   if ($spgnofrmc>0) { 
	   $pmc++;
	   }
	   $tfrm=$spgnofrma+$spgnofrmb+$spgnofrmc;
	   $tfrmv=$tfrm/$pmc;
	   $thrs=$spgdailyahrs+$spgdailybhrs+$spgdailychrs;
	   
//		   $p100=ROUND(($spgspeed*$thrs*60*$spgactcount*$spgspindle*$tfrm)/($spgtpi*14400*2.2046*36),2);
		   
//		   $p100a=ROUND(($spgspeed*$spgdailyahrs*60*$spgactcount*$spgspindle*$spgnofrma)/($spgtpi*14400*2.2046*36),2);
//		   $p100b=ROUND(($spgspeed*$spgdailybhrs*60*$spgactcount*$spgspindle*$spgnofrma)/($spgtpi*14400*2.2046*36),2);
//		   $p100c=ROUND(($spgspeed*$spgdailychrs*60*$spgactcount*$spgspindle*$spgnofrma)/($spgtpi*14400*2.2046*36),2);
			
		   
		   $p100a=0;
		   $p100b=0;
		   $p100c=0;
			if ($spgnofrma>0) {
				$p100a=ROUND(($spgspeed*$spgdailyahrs*60*$spgactcount*$spgspindle*$spgnofrma)/($spgtpi*14400*2.2046*36),2);
			}	
			if ($spgnofrmb>0) {
				$p100b=ROUND(($spgspeed*$spgdailybhrs*60*$spgactcount*$spgspindle*$spgnofrmb)/($spgtpi*14400*2.2046*36),2);
			}	
			if ($spgnofrmc>0) {
		           $p100c=ROUND(($spgspeed*$spgdailychrs*60*$spgactcount*$spgspindle*$spgnofrmc)/($spgtpi*14400*2.2046*36),2);
			}	
			$p100=$p100a+$p100b+$p100c;
			$tprd=round($p100*$tef/10000,0)*100;
//echo $p100."=".$tprd."=".$tef."=".$spgquality_id;
			if   ($spgproda+$spgprodb+$spgprodc>0) {
				$acef=round(($spgproda+$spgprodb+$spgprodc)/$p100*100,2);
			 }
			 $efa=0;
		 $efb=0;
	     $efc=0;
		   if ($spgproda>0) {
		   		$efa=round(($spgproda)/$p100a*100,2);
			}
			if ($spgprodb>0) {
				$efb=round(($spgprodb)/$p100b*100,2);
			}	
			if ($spgprodc>0) {

		   $efc=round(($spgprodc)/$p100c*100,2);
			}
		 /*  
		   'company_id' => $companyId,
		   'tran_date' => $spgdailyDate,
		   'q_code' =>$spgquality_id,
		   'twist_per_inch' =>$record['tpi'],
		   'tar_eff' =>$record['tar_eff'],
		   'std_count' =>$record['yarn_count'],
		 */
		 
	   $data = array(
		'act_count' =>$spgactcount,
		'speed' =>$spgspeed,
		'mc_a' =>$spgnofrma,
		'mc_b' =>$spgnofrmb,
		'mc_c' =>$spgnofrmc,
		'winder' =>$spgnowinder,
		'prd_a' =>$spgproda,
		'prd_b' =>$spgprodb,
		'prd_c' =>$spgprodc,
		'tar_prd' =>$p100,
		'hunprod' =>$tprd,
		'act_eff' =>$acef,
		'tot_hrs' =>$thrs,
		'hrs_a' =>$spgdailyahrs,
		'hrs_b' =>$spgdailybhrs,
		'hrs_c' =>$spgdailychrs,
		'eff_a' =>$efa,
		'eff_b' =>$efb,
		'eff_c' =>$efc,
		'tarprda' =>$p100a,
		'tarprdb' =>$p100b,
		'tarprdc' =>$p100c


		// Exclude 'id' and 'updated_by' fields
	);
//	$otherdb->insert('spining_daily_transaction', $data);

		 $this->db->where('q_code', $spgquality_id)
        ->where('company_id', $companyId)
        ->where('tran_date', $spgdailyDate) // Replace 'date_column' with the actual name of your date column
        ->update('EMPMILL12.spining_daily_transaction', $data);

 		$data =[];

  $response = array(
	'success' => true,
	'frameNo' => $spgdailyDate,
	'savedata'=> 'saved'
);

$frameNo='';        
echo json_encode($response);


    }

/*
	$hrs_a=oci_result($stid, "HRS_A");
	$hrs_b=oci_result($stid, "HRS_B");
	$hrs_c=oci_result($stid, "HRS_C");
	$quality_code=oci_result($stid, "Q_CODE");
	$act_grist=oci_result($stid, "ACT_COUNT");
	$no_of_winder=oci_result($stid, "WINDER");
	$frame_a=oci_result($stid, "MC_A");
	$frame_b=oci_result($stid, "MC_B");
	$frame_c=oci_result($stid, "MC_C");
 	$total_frame=0;
	$prod_a=oci_result($stid, "PRD_A");
	$prod_b=oci_result($stid, "PRD_B");
	$prod_c=oci_result($stid, "PRD_C");
	$total_prod=0;
	$speed=oci_result($stid, "SPEED");
	$tpi=oci_result($stid, "TWIST_PER_INCH");
	$tar_eff=oci_result($stid, "TAR_EFF");
	$stype=oci_result($stid, "STYPE");
	$w_type=oci_result($stid, "W_TYPE");
	$stype=oci_result($stid, "STYPE");
	$std_count=oci_result($stid, "STD_COUNT");
	$tprd=oci_result($stid, "TAR_PRD");
	$hprd=oci_result($stid, "HUNPROD");
	$acef=oci_result($stid, "ACT_EFF");
	$scnt=oci_result($stid, "STD_COUNT");
	$efa=oci_result($stid, "EFF_A");
	$efb=oci_result($stid, "EFF_B");
	$efc=oci_result($stid, "EFF_C");
	$tprod_a=oci_result($stid, "TARPRDA");
	$tprod_b=oci_result($stid, "TARPRDB");
	$tprod_c=oci_result($stid, "TARPRDC");
	
	
	$tot_hurs=$hrs_a+$hrs_b+$hrs_c;
	
	$logMsg.= $issue_date.",0,".$quality_code.",".$act_grist.",".$speed.",".$tpi.",".$tar_eff.",".$frame_a.
	",".$frame_b.",".$frame_c.",".$no_of_winder.",".$prod_a.",".$prod_b.",".$prod_c.
	",".$tprd.",".$hprd.",".$acef.",".$std_count.",0,".$tot_hurs.","
	.'FALSE'.",0,0,".
	$hrs_a.",".$hrs_b.",".$hrs_c.",".$efa.",".$efb.",".$efc.",".$tprod_a.",".$tprod_b.",".$tprod_c.","
	.$stype.",'','.',".$issue_date.",".' '.",".$w_type."\r\n";
*/

public function exportspgdailydata() {
	$sdate = $this->input->post('spgdailyDate');
	$compid = $this->input->post('companyId');
	$sdate = $this->input->get('spgdailyDate');
	$compid = $this->input->get('companyId');
    $sdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);

		$sql = "select DATE_FORMAT( tran_date,'%d-%m-%Y') trandate,sdt.*
		from EMPMILL12.spining_daily_transaction sdt left join EMPMILL12.spining_master sm on sdt.q_code = sm.q_code where 
		tran_date ='".$sdate."' and sdt.company_id=".$compid ;
 
		$query = $this->db->query($sql);
		$data = $query->result_array();
	
		$fileContainer = "data.ebq";
		$filePointer = fopen($fileContainer,"w+");

	 	$logMsg='';

		foreach ($data as $row) {
	
		
			$issue_date=$row['trandate'];
			$hrs_a=$row['hrs_a'];
			$hrs_b=$row['hrs_b'];
			$hrs_c=$row['hrs_c'];
 			$quality_code=$row['q_code'];
			$act_grist=$row['act_count'];
			$no_of_winder=$row['winder'];
			$frame_a=$row['mc_a'];
			$frame_b=$row['mc_b'];
			$frame_c=$row['mc_c'];
			 $total_frame=0;
			$prod_a=$row['prd_a'];
			$prod_b=$row['prd_b'];
			$prod_c=$row['prd_c'];
			$total_prod=0;
			$speed=$row['speed'];
			$tpi=$row['twist_per_inch'];
			$tar_eff=$row['tar_eff'];
			$stype=$row['stype'];
			$w_type=$row['wtype'];
			$std_count=$row['std_count'];
			$tprd=$row['tar_prd'];
			$hprd=$row['hunprod'];
			$acef=$row['act_eff'];
			$efa=$row['eff_a'];
			$efb=$row['eff_b'];
			$efc=$row['eff_c'];
			$tprod_a=$row['tarprda'];
			$tprod_b=$row['tarprdb'];
			$tprod_c=$row['tarprdc'];
				
		$tot_hurs=$hrs_a+$hrs_b+$hrs_c;
	
			

		$logMsg.= $issue_date.",0,".$quality_code.",".$act_grist.",".$speed.",".$tpi.",".$tar_eff.",".$frame_a.
		",".$frame_b.",".$frame_c.",".$no_of_winder.",".$prod_a.",".$prod_b.",".$prod_c.
		",".$tprd.",".$hprd.",".$acef.",".$std_count.",0,".$tot_hurs.","
		.'FALSE'.",0,0,".
		$hrs_a.",".$hrs_b.",".$hrs_c.",".$efa.",".$efb.",".$efc.",".$tprod_a.",".$tprod_b.",".$tprod_c.","
		.$stype.",'','.',".$issue_date.",".' '.",".$w_type."\r\n";
		
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
$zipname = 'spgdata.zip';
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


	public function exlspgreport() {
		$sdate = $this->input->post('spgdailyDate');
		$compid = $this->input->post('companyId');
		$spdate = $this->input->get('spgdailyDate');
		$fpdate = $this->input->get('spgfdailyDate');
		$compid = $this->input->get('companyId');
		$sdate=substr($spdate,6,4).'-'.substr($spdate,3,2).'-'.substr($spdate,0,2);
		$fdate=substr($fpdate,6,4).'-'.substr($fpdate,3,2).'-'.substr($fpdate,0,2);
			$sql = "select * from (
				select substr(sdt.q_code,1,1) as gcode,1 rem, sdt.q_code,sm.std_count,sm.subgroup_type,sdt.twist_per_inch,sdt.speed,sm.spindle, 
				round( sum(tar_prd*sdt.tar_eff)/sum(tar_prd),0)   tar_eff,
				round((sum(hunprod*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0) prdmctgncnt,
				round(sum(hunprod)/sum(mc_a+mc_b+mc_c),0) prdmcacnt,sum(sdt.hunprod)/1000 hunprod,
				round(sum(((prd_a+prd_b+prd_c)*sdt.act_count))/sum(prd_a+prd_b+prd_c),2)  act_count,
				sum(mc_a+mc_b+mc_c) totmc,sum(sdt.prd_a +sdt.prd_b+prd_c)/1000 totprd,
				round(sum(sdt.prd_a +sdt.prd_b+prd_c)/sum(mc_a+mc_b+mc_c),0) avgprd,
				round(sum(sdt.prd_a +sdt.prd_b+prd_c)/sum(sdt.winder ),0) avgwndprd,
				round((sum((sdt.prd_a +sdt.prd_b+prd_c)*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0) prdmcnnt,
				round((sum(hunprod*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0)-
				round((sum((sdt.prd_a +sdt.prd_b+prd_c)*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0) varmcprd,
				round(sum(prd_a+prd_b+prd_c)/sum(tar_prd)*100,2) act_eff ,sum(sdt.tot_hrs) tot_hrs 
				from EMPMILL12.spining_daily_transaction sdt 
				left join EMPMILL12.spining_master sm on sdt.q_code=sm.q_code and sdt.company_id=sm.company_id
				where sdt.tran_date between '$fdate' and '$sdate'  and sdt.company_id =$compid
				group by substr(q_code,1,1), sdt.q_code,sm.std_count,sm.subgroup_type,sdt.twist_per_inch,sdt.speed,
				sm.spindle
				union all
				select substr(q_code,1,1) as gcode,2 rem,'' q_code,round(sum(std_count*(prd_a+prd_b+Prd_c))/sum(prd_a+prd_b+Prd_c) ,2) avgstdcnt,
				' ' subgroup_type,' ' twist_per_inch ,' 'speed,' ' spindle, 
				round( sum(tar_prd*tar_eff)/sum(tar_prd),0)   tar_eff,
				round((sum(hunprod*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0) prdmctgncnt,
				round(sum(hunprod)/sum(mc_a+mc_b+mc_c),0) prdmcacnt,sum(sdt.hunprod)/1000 hunprod,
				round(sum(((prd_a+prd_b+prd_c)*sdt.act_count))/sum(prd_a+prd_b+prd_c),2)  act_count,
				sum(mc_a+mc_b+mc_c) totmc,sum(sdt.prd_a +sdt.prd_b+prd_c)/1000 totprd,
				round(sum(sdt.prd_a +sdt.prd_b+prd_c)/sum(mc_a+mc_b+mc_c),0) avgprd,
				round(sum(sdt.prd_a +sdt.prd_b+prd_c)/sum(sdt.winder ),0) avgwndprd,
				round((sum((sdt.prd_a +sdt.prd_b+prd_c)*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0),
				round((sum(hunprod*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0)-
				round((sum((sdt.prd_a +sdt.prd_b+prd_c)*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0) varmcprd,
				round(sum(prd_a+prd_b+prd_c)/sum(tar_prd)*100,2) act_eff ,' ' tot_hrs 
				from EMPMILL12.spining_daily_transaction sdt 
				where sdt.tran_date between '$fdate' and '$sdate'  and sdt.company_id =$compid
				group by substr(q_code,1,1)
				union all
				select '5' as gcode,2 rem,'Grand_Total' q_code,round(sum(std_count*(prd_a+prd_b+Prd_c))/sum(prd_a+prd_b+Prd_c) ,2) avgstdcnt,
				' ' subgroup_type,' ' twist_per_inch ,' 'speed,' ' spindle, 
				round( sum(tar_prd*tar_eff)/sum(tar_prd),0)   tar_eff,
				round((sum(hunprod*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0) prdmctgncnt,
				round(sum(hunprod)/sum(mc_a+mc_b+mc_c),0) prdmcacnt,sum(sdt.hunprod)/1000 hunprod,
				round(sum(((prd_a+prd_b+prd_c)*sdt.act_count))/sum(prd_a+prd_b+prd_c),2)  act_count,
				sum(mc_a+mc_b+mc_c) totmc,sum(sdt.prd_a +sdt.prd_b+prd_c)/1000 totprd,
				round(sum(sdt.prd_a +sdt.prd_b+prd_c)/sum(mc_a+mc_b+mc_c),0) avgprd,
				round(sum(sdt.prd_a +sdt.prd_b+prd_c)/sum(sdt.winder ),0) avgwndprd,
				round((sum((sdt.prd_a +sdt.prd_b+prd_c)*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0),
				round((sum(hunprod*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0)-
				round((sum((sdt.prd_a +sdt.prd_b+prd_c)*sdt.std_count/sdt.act_count))/sum(mc_a+mc_b+mc_c),0) varmcprd,
				round(sum(prd_a+prd_b+prd_c)/sum(tar_prd)*100,2) act_eff ,' ' tot_hrs 
				from EMPMILL12.spining_daily_transaction sdt 
				where sdt.tran_date between '$fdate' and '$sdate'  and sdt.company_id =$compid
						   ) g order by gcode,rem"
				;
	 //echo $sql;
			$query = $this->db->query($sql);
			$data = $query->result_array();
		
			$fileContainer = "data.ebq";
			$filePointer = fopen($fileContainer,"w+");
	
			 $logMsg='';
			 $spreadsheet = new Spreadsheet();
			 $sheet = $spreadsheet->getActiveSheet();
		 
			 
			 $cmpn='The Empire Jute Co. Ltd';
			 $sheet->setCellValue('A1', $cmpn);
			 $sheet->setCellValue('A2', "Daily Spining Report from : ".$fpdate. ' To '.$spdate);
			 $rowIndex = 3;
			 $borderStyle = [
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
				],
			];

			 
			 $columnIndex = 1;
		 
//Quality Code 	Count 	Type 	TPI 	Speed 	Spindle 	Target Eff% 	Prd/Mc/N.Cnt 	Prd/Mc/A.Cnt 	
//Production (M.T.) 	Actual Count 	No of Frames 	Production (M.T.) 	Prd / Frm 	Prd / Wnd 	Conv.on Std Cnt/ Prd/ Frm 	Var Prd/Frm 	Act Eff% 	Working Hrs 

			$sheet->mergeCells('a3:f3');
			$cellStyleA1C3 = $sheet->getStyle('a3:f3');
			$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$value='Quality';	
			$columnIndex=1;
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$sheet->mergeCells('g3:j3');
			$cellStyleA1C3 = $sheet->getStyle('g3:j3');
			$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$value='Target';	
			$columnIndex=7;
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$sheet->mergeCells('k3:r3');
			$cellStyleA1C3 = $sheet->getStyle('g3:j3');
			$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$cellStyleA1C3->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$value='Actual';	
			$columnIndex=11;
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);



			$rowIndex++;		
			$columnIndex = 1;
			 $value='Quality Code';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Count';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Type';	
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='TPI';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Speed';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Spindle';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Target Eff%';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Prd/Mc/N.Cnt';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Prd/Mc/A.Cnt';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Production';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Actual Count';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='No of Frames';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
//			 Production (M.T.) 	Prd / Frm 	Prd / Wnd 	Conv.on Std Cnt/ Prd/ Frm 	Var Prd/Frm 	Act Eff% 	Working Hrs
			 $value='Production (M.T.)';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Prd / Frm';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Prd / Wnd';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Conv.on Std Cnt/ Prd/ Frm';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Var Prd/Frm';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Act Eff%';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
			 $value='Working Hrs';
			 $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			 $columnIndex++;
 		 
//			 q_code	std_count	subgroup_type	twist_per_inch	speed	spindle	tar_eff	prdmctgncnt	prdmcacnt	
			$sheet->getStyle('A3:s40')->getAlignment()->setWrapText(true);
			$cellStyleA1C3 = $sheet->getStyle('a3:s4');
			$cellStyleA1C3->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$rowIndex ++;

			foreach ($data as $row) {
				$columnIndex=1;
				if ($row['rem']=='2' & $row['gcode']=='1') {
					$value='Fine Side';
				}
				if ($row['rem']=='2' & $row['gcode']=='2') {
					$value='Hy Fine Side';
				}
				if ($row['rem']=='2' & $row['gcode']=='3') {
					$value='Coarse Side';
				}
				if ($row['rem']=='2' & $row['gcode']=='5') {
					$value='Grand Total';
				}
				if ($row['rem']=='1' ) {
					$value=$row['q_code'];
				}

				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['std_count'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['subgroup_type'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['twist_per_inch'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['speed'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['spindle'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['tar_eff'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['prdmctgncnt'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['prdmcacnt'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
	//			hunprod		act_count		totmc	totprd	avgprd	avgwndprd	prdmcnnt	varmcprd	act_eff	tot_hrs
				$value=$row['hunprod'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['act_count'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['totmc'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['totprd'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
			   $value=$row['avgprd'];
   				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['avgwndprd'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['prdmcnnt'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['varmcprd'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['act_eff'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;
				$value=$row['tot_hrs'];
				$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
				$columnIndex++;

				if ($row['rem']=='2' ) {
					$rng='A'.$rowIndex.':S'.$rowIndex;
					$sheet->getStyle($rng)->getFont()->setSize(10)->setBold(true);

				}	
				$rowIndex ++;


			}

			$sheet->getStyle('A3:s20')->applyFromArray($borderStyle);


			$filename="spgrepo".$sdate.'.xlsx';
			// Set headers for Excel file download
		//	ob_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//	header('Content-Disposition: attachment;filename="your_excel_file.xlsx"');
		
		//		header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename='.$filename);
			header('Cache-Control: max-age=0');
			ob_clean();
		
			// Save the Excel file to output stream
			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
			// Save the Excel file to output stream
		//	$writer = new Xlsx($spreadsheet);
		//	$writer->save('php://output');
		


		}	



}
 