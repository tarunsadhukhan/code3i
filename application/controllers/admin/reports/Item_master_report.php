

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Item_master_report extends CI_Controller {

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
		$this->load->model('Item_model');
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
     
		
 	

		$this->load->view('admin/reports/item_master_report' );	
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

	public function get_itemquality() {
        $uitemcode = $this->input->post('uitemcode');
        $companyId = $this->input->post('companyId');
		
		$sql="select item_desc,location from  itemmaster where concat(group_code,item_code)='".$uitemcode."' and 
		company_id=".$companyId;	
		//echo $sql;
				$bwt=0;
				$query1=$this->db->query($sql);
				if ( $query1->num_rows()>0 ) {
					$row1 = $query1->row();
					$frm=$row1->item_desc;
					$bwt=$row1->location;
	 			$response = array(
				'success' => true,
				'name' => $frm,
				'location' => $bwt
  			 
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

		public function save_itemdata() {

 
			$rec_time =  date('Y-m-d H:i:s');
			$uitemcode = $this->input->post('uitemcode');
			$ulocation = $this->input->post('ulocation');
			$companyId = $this->input->post('companyId');
			$itemimage = $this->input->post('itemimage');
			$fileChosen = $this->input->post('fileChosen');
			$ip = $_SERVER['REMOTE_ADDR'];
			
		

			$sql="update itemmaster set location='".$ulocation."' where company_id =".$companyId."
			 and concat(group_code,item_code)='".$uitemcode."'";
//		echo $sql;
		$this->db->query($sql);
//		echo $this->db->last_query();

//echo 'myfile '.$itemimage;

if ($fileChosen>0) {
if (!empty($_FILES['itemimage']['name'])) {
	$config['upload_path'] = './uploads/'; // Specify the folder where you want to save the image
	$config['allowed_types'] = 'gif|jpg|png|jpeg'; // Allowed file types
	$config['max_size'] = 1024 * 2; // Maximum file size (in kilobytes)
	$config['encrypt_name'] = TRUE; // Encrypts uploaded file name
	$this->load->library('upload', $config);

	if ($this->upload->do_upload('itemimage')) {
		$data = $this->upload->data();
		$image_path = $data['file_name']; // File name with extension

//		echo 'is it '.$image_path;
		// Do something with $image_path, like save it to the database or use it further
	} else {
		$error = array('error' => $this->upload->display_errors());
//		echo 'for error'.$error;
		// Handle upload error
	}
}



$imgfile='./uploads/'.$image_path;
//echo 'with folder '.$imgfile;
$image_data = file_get_contents($imgfile);
//echo $image_data;
$filename = $imgfile; 
//echo $filename;					
$width = 200; 
$height = 200; 







$img_to_resize = $this->Item_model->image_resize($filename, 250, 250, true);
$save_path = 'c:\aa\path-to-save-resized-image.jpg';

// Save the resized image to the specified path
imagejpeg($img_to_resize, $save_path);

// Free up memory by destroying the image resources
//imagedestroy($img_to_resize);

//echo 'Resized image saved successfully to: ' . $save_path;
$imgfile=$save_path;
$image_data = file_get_contents($imgfile);

$image_base64 = base64_encode($image_data);

// Generate the HTML code for the image
			$html_code = '<img src="data:image/png;base64,' . $image_base64 . '" />';
			$ln=strlen($html_code);
			$html_code=substr($html_code,10,$ln);
			$html_code=substr($html_code,0,-14);
			




			$sql="  select i.item_id,i.location,ifnull(item_image_id,0) item_image_id
			 from itemmaster i 
			left join EMPMILL12.tbl_item_image tii on i.item_id=tii.item_id 
			where  company_id =".$companyId."
			and concat(group_code,item_code)='".$uitemcode."'";
			$query1=$this->db->query($sql);
			if ( $query1->num_rows()>0 ) {
				$row1 = $query1->row();
				$itmid=$row1->item_id;
				$itmimg=$row1->item_image_id;
			}	
 
			if ($itmimg==0) {
				$sql="insert into EMPMILL12.tbl_item_image (item_image_name,image_html,item_id,itemcode,image_type )
				values ('".$itemimage."','".$html_code."',".$itmid.",'".$uitemcode."','I')";
				$this->db->query($sql);
				

			}
			if ($itmimg>0) {
				$sql="update EMPMILL12.tbl_item_image set image_html='".$html_code."' where item_image_id=".$itmimg;
				$this->db->query($sql);
				

			}
			unlink('./uploads/' . $image_path);
 		}


    	$data =[];
	  $response = array(
		'success' => true,
		'savedata'=> 'saved'
	);
	
	$frameNo='';        
	echo json_encode($response);
	
	
		}
	
				


		public function get_itemdatarecords() {
			$compid = $this->input->post('companyId');
            $groupcode = $this->input->post('groupcode');
            $itemcode = $this->input->post('itemcode');
            $itemdesc = $this->input->post('itemdesc');
            $location = $this->input->post('location');
            $stock = $this->input->post('stock');
            $ln=strlen($groupcode)+strlen($itemcode)+strlen($itemdesc)+strlen($location);
            if ($ln==0) { 
                $groupcode='116';
				$itemcode='0097';
				
            }    
            $sql="select i.item_id,i.group_code,i.item_code,i.item_desc,i.uom_code,i.location,
			ifnull(tpmm.minqty,0) minqty,
			ifnull(tpmm.maxqty,0) maxqty,ifnull(tpmm.min_order_qty,0) min_order_qty,
			round(ifnull(stockqty,0),3) stockqty,concat(group_code,item_code) itemcode,ifnull(tii.image_html,'') image_html,
			ifnull(tppd.outpoqty,0) outpoqty,ifnull(tpid.outindqty,0) outindqty,
			case when openindqty='OPENINDENT' then 'Yes' else 'No' end openind
			from itemmaster i
			left join tbl_proc_min_max tpmm on i.item_id =tpmm.item_id
			left join EMPMILL12.tbl_item_image tii on i.item_id=tii.item_id 
			left join (select item,sum(balance_qty) stockqty from tbl_view_proc_material_inventory tvpmi group by item ) tvpmi
			on i.item_id =tvpmi.item
			left join (
			select item,sum(qty-cancelled_qty-qty_recvd) outpoqty from tbl_proc_po_detail tppd 
			left join tbl_proc_po tpp on tppd.po=tpp.po_id 
			where tpp.status =3 and tppd.is_active =1 group by item
			)  tppd on tppd.item=i.item_id 
			left join (
			select item,sum(qty-cancelled_qty-qty_po) outindqty from tbl_proc_indent_detail tpid 
			left join tbl_proc_indent tpi on tpid.indent =tpi.indent_id 
			where tpi.indent_status =3 and tpid.is_active =1 and tpi.record_type not in ('OPENINDENT')
			group by item
			)  tpid on tpid.item=i.item_id 
            left join (
			select distinct(item) item,record_type openindqty from tbl_proc_indent_detail tpid 
			left join tbl_proc_indent tpi on tpid.indent =tpi.indent_id 
			where tpi.indent_status =3 and tpid.is_active =1 and tpi.record_type  in ('OPENINDENT') and item=133769
			)  tpod on tpod.item=i.item_id 
            where i.company_id=".$compid." and group_code not in ('999')";
            if (strlen($groupcode)>0) { 
                $sql=$sql." and group_code='".$groupcode."'";
            }    
            if (strlen($itemcode)>0) { 
                $sql=$sql." and item_code='".$itemcode."'";
            }    
            if (strlen($itemdesc)>0) { 
                $sql=$sql." and item_desc like '%".$itemdesc."%'";
            }    
            if (strlen($location)>0) { 
                $sql=$sql." and location like '%".$location."%'";
            }    
            if (strlen($stock)>0) { 
                $sql=$sql." and round(ifnull(stockqty,0),3)>0>".$stock;
            }    
                      
            $sql=$sql." order by group_code,item_code";
//echo $sql;
			$records= $this->db->query($sql)->result_array();
        	$cnt=count($records);
			$data=[];
			if ($cnt>0) {
				foreach ($records as $record) {
					$imgsrc =$record['image_html']; 
					$ln=strlen($imgsrc);
					if ($ln==0) {
						$imgsrc=base_url('storesphoto/imageNotAvailable.jpg');

					}
					//base_url('storesphoto/'.$compid."/" . $record['itemcode'].'.jpg');
                    $data[] = [
						$record['item_id'],       // Use array notation instead of object property
						$record['group_code'],          // Use array notation instead of object property
						$record['item_code'],   // Use array notation instead of object property
						$record['itemcode'],   // Use array notation instead of object property
						$record['item_desc'],   // Use array notation instead of object property
						$record['uom_code'], 
						$record['stockqty'],       // Use array notation instead of object property
						$record['minqty'], 
						$record['maxqty'],      // Use array notation instead of object property
						$record['min_order_qty'],      // Use array notation instead of object property
						$record['location'],       // Use array notation instead of object property
                        $imgsrc ,      // Use array notation instead of object property
						$record['outpoqty'],       // Use array notation instead of object property
						$record['outindqty'],       // Use array notation instead of object property
					 
					];
				}
		}
//		var_dump($data);
	
		// Return the response
			echo json_encode(['data' => $data]);
		}


		public function getMonthlyChartDataWithImage() {
			// Fetch month-wise data for a year including image URL from your MySQL database
			// Replace this with your actual database logic
			$year = date('Y'); // Get the current year
			$itemcode = $this->input->get('itemcode'); // Get the itemcode from the request

			$monthlyData = $this->Item_model->getMonthlyDataWithImage($year, $itemcode);
	
			// Format data for Chart.js
			$labels = [];
			$data = [];
			$imageUrls = [];
	
			foreach ($monthlyData as $monthData) {
				$labels[] = $monthData['month_name'];
				$data[] = $monthData['issqty']; // Replace with your actual data field
				$imageUrls[] = $monthData['item_image_name']; // Replace with your actual image URL field
			} 
	
			echo json_encode(array('labels' => $labels, 'data' => $data, 'imageUrls' => $imageUrls));
		}
 
 	
 		public function get_itemdataimg() {
			$company_id = $this->session->userdata('company_id');

			$itemid= $this->input->post('itemid');
			$itemcd= $this->input->post('itemcd');
			$itemds= $this->input->post('itemds');
			$stkqt= $this->input->post('stkqt');
			$mnqt= $this->input->post('mnqt');
			$mxqt= $this->input->post('mxqt');
			$mnrqt= $this->input->post('mnrqt');
			$loca= $this->input->post('loca');
			$itimg= $this->input->post('colimg');
			$colimg= $this->input->post('colimg');

			$rem='';
			if ($mnqt>0) {
				if ($stkqt ==0) { $rem='color : red;';}
				if ($stkqt <$mnqt & $stkqt>0) { $rem='color : orange;';}
				if ($stkqt >=$mnqt & $stkqt<=$mxqt) { $rem = 'color: green;';
				}
				if ($stkqt >$mxqt) { $rem='color : blue;';}
				

			}

			$output = '<p><img src="' . $itimg . '" class="img-fluid" style="max-width: 100%; height: auto;"></p>';
			$output .= '<span style="font-size: 18px;"><strong>item Code:</strong> ' . $itemcd . '</span><br>';
			$output .= '<span style="font-size: 18px;"><strong>Name:</strong> ' . $itemds . '</span><br>';
			$output .= '<span><strong>Stock:</strong> ' . $stkqt . '</span><br>';
			$output .= '<span><strong>Min Qty:</strong> ' . $mnqt . '</span><br>';
			$output .= '<span><strong>Max Qty:</strong> ' . $mxqt . '</span><br>';
			$output .= '<span><strong>LOcation:</strong> ' . $loca . '</span><br>';
					//		$output .= '<span><strong>LOcation:</strong> ' . $colimg . '</span><br>';
/*
		$output .= '<span><strong>cStock:</strong> <span style="' . $rem . '">' . $stkqt . '</span></span><br>';	
		if ($stkqt > 10) {
			$output .= '<span><strong>pStock:</strong> <span style="color: green;">' . $stkqt . '</span></span><br>';
		} else {
			$output .= '<span><strong>pStock:</strong> <span style="color: red;">' . $stkqt . '</span></span><br>';
		}
*/
		echo $output;



		}		



}