 <?php
class Item extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('item_model');
    }

    public function index() {
        $data['products'] = $this->item_model->get_products();
        $this->load->view('admin/1products/itemadd');
    }
}
?>
