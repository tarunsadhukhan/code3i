<?php
class Item_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

    }

    public function get_products() {
        $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        return $otherdb->get('products')->result();
        $otherdb->close();
    }

    public function getMonthlyDataWithImage($year, $itemcode) {
        $company_id = $this->session->userdata('company_id');
        $sql="	select k.*,tii.image_html,tii.item_image_name  FROM (
            select item,MONTHNAME(tran_date) month_name, round(sum(issued_qty),0) issqty from 
            view_proc_store_receipt_transfer_issue vpsrti 
               where tran_date> now() - INTERVAL 12 month and tran_status not in (4,6) 
               and concat(group_code,item_code)='".$itemcode."'
               and company_id =".$company_id."
               group by item,MONTHNAME(tran_date)
            ) k left join EMPMILL12.tbl_item_image tii ON k.item=tii.item_id ";
            
            $result = $this->db->query($sql)->result_array();
//echo var_dump($result);
            return $result;
	

    }

	public function image_resize($file_name, $width, $height, $crop = false) {
        list($wid, $ht) = getimagesize($file_name);
        $r = $wid / $ht;
    
        if ($crop) {
            if ($wid > $ht) {
                $wid = ceil($wid - ($width * abs($r - $width / $height)));
            } else {
                $ht = ceil($ht - ($ht * abs($r - $width / $height)));
            }
            $new_width = $width;
            $new_height = $height;
        } else {
            if ($width / $height > $r) {
                $new_width = $height * $r;
                $new_height = $height;
            } else {
                $new_height = $width / $r;
                $new_width = $width;
            }
        }
    
        $source = imagecreatefromjpeg($file_name);
        $dst = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($dst, $source, 0, 0, 0, 0, $new_width, $new_height, $wid, $ht);
    
        return $dst;
    }


}
?>
