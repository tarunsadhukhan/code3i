<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

// application/models/ItemModel.php

// application/models/MenuModel.php
// application/models/MenuModel.php

class MenuModel extends CI_Model {

    public function getMenuData() {
        $this->db->select('mm.menu_id, mm.menu, mm.parent_id, mm2.menu_id pmenuid, mm2.menu parent_name, mm2.parent_id mastparentid');
        $this->db->from('menu_master mm');
        $this->db->join('menu_master mm2', 'mm.parent_id = mm2.menu_id', 'left');
        $this->db->where('mm2.parent_id', 68);
        $this->db->order_by('mm2.parent_id, mm.parent_id');
        $query = $this->db->get();
        $result=$query->result();
        $result = $query->result();
//echo '<pre>';
//print_r($result); // Display the data
//echo '</pre>';

        return $result;
    }
}




