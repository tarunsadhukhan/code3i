<?php
class Product_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_products() {
        return $this->db->get('products')->result();
    }

    public function add_product() {
        $data = array(
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price')
        );

        return $this->db->insert('products', $data);
    }

    public function update_product() {
        $data = array(
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price')
        );

        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('products', $data);
    }

    public function delete_product($id) {
        $this->db->where('id', $id);
        return $this->db->delete('products');
    }
}
