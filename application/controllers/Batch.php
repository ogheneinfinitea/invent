<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Batch extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['batches'] = $this->web->GetAllWithInner("batch_id", "batches", "products", "product_id", NULL, NULL);
        // print_r($this->data['batches']); die();
        $this->load->view("batch/all", $this->data);
    }

    function view() {
        $batch_id = $this->uri->segment(3);
//        $this->data['batch'] = $this->web->GetOneWithInner("product_id", "products", "batches", "product_id", "units", "unit_id", $batch_id);
        $this->data['batch'] = $this->web->GetBatches($batch_id);
        $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id");
        $this->load->view("batch/edit", $this->data);
    }

    function edit($id) {
        $data = array();
        $data['batch_no'] = $this->db->escape_str($this->input->post("number", true));
        $data['product_id'] = $this->db->escape_str($this->input->post("product", true));
        $data['max_qty'] = $this->db->escape_str($this->input->post("qty", true));
//        $id = $this->input->post("batch_id", true);
        $this->web->Update("batch_id", "batches", $id, $data);
        redirect("batch", "refresh");
    }

    function delete() {
        $batch_id = $this->input->post("id", true);
        if ($this->web->Delete("batch_id", "batches", $batch_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['batch_no'] = $this->db->escape_str($this->input->post("number", true));
            $data['product_id'] = $this->db->escape_str($this->input->post("product", true));
            $data['max_qty'] = $this->db->escape_str($this->input->post("qty", true));
            if ($this->web->Add("batches", $data)) {
                redirect("batch", "refresh");
            }
        } else {
            $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id");
            $this->load->view("batch/add", $this->data);
        }
    }

}
