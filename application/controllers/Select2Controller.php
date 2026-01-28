<?php
// application/controllers/Select2Controller.php

class Select2Controller extends CI_Controller {

    public function index() {
        $this->load->model('MenuModel');
//        $data['menu_data'] = $this->buildMenuStructure($this->MenuModel->getMenuData());
        $data['menu_data'] = $this->MenuModel->getMenuData();

    //    var_dump($data);
        $this->load->view('menu_view', $data);
    }

    private function buildMenuStructure($menuData, $parentId = null) {
        $menuStructure = array();
       // var_dump($menuData);
        $parentId=68;
        foreach ($menuData as $menu_item) {
            if ($menu_item->mastparentid == $parentId) {
                $menuStructure[] = array(
                    'menu_id' => $menu_item->menu_id,
                    'menu' => $menu_item->menu,
                    'submenu' => $this->buildMenuStructure($menuData, $menu_item->menu_id)
                );
            }
        }
echo '<pre>';
print_r($menuStructure); // Display the data
echo '</pre>';

   
        return $menuStructure;
    }
}
