<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Spining_daily_entry extends CI_Controller {

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
		
        $qualitydata=$this->Doffdata_Model->getspgQualitydata();
        $dataq['qualitydata']=$qualitydata;

    //    $data_to_pass['data'] = $data;
    //    $data_to_pass['datas'] = $datas;
       $data_to_pass['dataq'] = $dataq;


//	var_dump($dataq);

//		$this->load->view('admin/winding_doff/winding_doff_data',$data,$dataq);
//$this->load->view('admin/reports/Winding_data_reports', $data_to_pass);	

		$this->load->view('admin/doffdata/Spining_daily_entry',$data_to_pass);
		
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
			dftmx.frameno ='$frameNo' and company_id =$companyId and spell='$shiftName'		";
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
		echo $sql;
		$bwt=0;
		$query1=$this->db->query($sql);
		if ( $query1->num_rows()>0 ) {
			$row1 = $query1->row();
			$frm=$row1->mechine_name;
			$bwt=$row1->bobbin_weight;
			
 		}
		 $vdate = date('m/d/Y h:i:s a', time());
		echo $vdate;
		$sql="select ifnull(g.trollyno,' ') trollyno,ifnull(trolly_weight+basket_weight,0)  name from 
		(
		select trollyno,company_id from dofftable dft where  auto_id in 
		(select max(auto_id) auto_id from dofftable dftmx where dftmx.frameno ='$frameNo' and company_id =$companyId) 
		) g left join 
		 trollymst trmst on g.trollyno=trmst.trollyno and g.company_id=trmst.company_id 
		 where process_type=2";
		 echo $sql;
		 $query1=$this->db->query($sql);
		 $vdate = date('m/d/Y h:i:s a', time());
		echo $vdate;

		$sql="select count(*) noofdoff,ifnull(round(sum(netwt),2),0) tnetwt from dofftable dftmx where 
		doffdate ='$payrollstartdate' and
		dftmx.frameno ='$frameNo' and company_id =$companyId and spell='$shiftName'		";
		echo $sql;
		$query2=$this->db->query($sql);
		$vdate = date('m/d/Y h:i:s a', time());
		echo $vdate;

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
		$sql="select mechine_name,bobbin_weight from  mechine_master where frame_no='$frameNo' and company_id=".$companyId;	
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
$designations = array(50, 195, 213, 241, 242, 252);


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
    $filename="spg01_".$date.'.xlsx';
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