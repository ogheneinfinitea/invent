<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouses extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['warehouses'] = $this->web->GetAll("warehouse_id", "warehouses");
        // print_r($this->data['warehouses']); die();
        $this->load->view("warehouses/all", $this->data);
    }

    function view() {
        $warehouse_id = $this->uri->segment(3);
        $this->data['warehouse'] = $this->web->GetOne("warehouse_id", "warehouses", $warehouse_id);
        $this->load->view("warehouses/edit", $this->data);
    }

    function edit() {
        $data = array();
        $data['warehouse_name'] = $this->db->escape_str($this->input->post("name", true));
        $data['warehouse_address'] = $this->db->escape_str($this->input->post("address", true));
        $id = $this->input->post("warehouse_id", true);
        $this->web->Update("warehouse_id", "warehouses", $id, $data);
        redirect("warehouses", "refresh");
    }

    function delete() {
        $warehouse_id = $this->input->post("id", true);
        if ($this->web->Delete("warehouse_id", "warehouses", $warehouse_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['warehouse_name'] = $this->db->escape_str($this->input->post("name", true));
            $data['warehouse_address'] = $this->db->escape_str($this->input->post("address", true));
            if ($this->web->Add("warehouses", $data)) {
                redirect("warehouses", "refresh");
            }
        } else {
            $this->load->view("warehouses/add", $this->data);
        }
    }

}
