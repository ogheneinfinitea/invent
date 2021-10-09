<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_category extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['product_categories'] = $this->web->GetAll("product_category_id", "product_categories");
        // print_r($this->data['product_categories']); die();
        $this->load->view("product_categories/all", $this->data);
    }

    function view() {
        $product_category_id = $this->uri->segment(3);
        $this->data['product_category'] = $this->web->GetOne("product_category_id", "product_categories", $product_category_id);
        $this->load->view("product_categories/edit", $this->data);
    }

    function edit() {
        $data = array();
        $data['product_category_name'] = $this->db->escape_str($this->input->post("name", true));
        $data['symbol'] = $this->db->escape_str($this->input->post("symbol", true));
        $id = $this->input->post("product_category_id", true);
        $this->web->Update("product_category_id", "product_categories", $id, $data);
        redirect("product_category", "refresh");
    }

    function delete() {
        $product_category_id = $this->input->post("id", true);
        if ($this->web->Delete("product_category_id", "product_categories", $product_category_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['product_category_name'] = $this->db->escape_str($this->input->post("name", true));
            $data['symbol'] = $this->db->escape_str($this->input->post("symbol", true));
            if ($this->web->Add("product_categories", $data)) {
                redirect("product_category", "refresh");
            }
        } else {
            $this->load->view("product_categories/add", $this->data);
        }
    }

}
