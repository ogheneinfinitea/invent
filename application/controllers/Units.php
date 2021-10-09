<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Units extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['units'] = $this->web->GetAll("unit_id", "units");
        // print_r($this->data['units']); die();
        $this->load->view("units/all", $this->data);
    }

    function view() {
        $unit_id = $this->uri->segment(3);
        $this->data['unit'] = $this->web->GetOne("unit_id", "units", $unit_id);
        $this->load->view("units/edit", $this->data);
    }

    function edit() {
        $data = array();
        $data['unit_name'] = $this->db->escape_str($this->input->post("name", true));
        $data['unit_symbol'] = $this->db->escape_str($this->input->post("symbol", true));
        $id = $this->input->post("unit_id", true);
        $this->web->Update("unit_id", "units", $id, $data);
        redirect("units", "refresh");
    }

    function delete() {
        $unit_id = $this->input->post("id", true);
        if ($this->web->Delete("unit_id", "units", $unit_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['unit_name'] = $this->db->escape_str($this->input->post("name", true));
            $data['unit_symbol'] = $this->db->escape_str($this->input->post("symbol", true));
            if ($this->web->Add("units", $data)) {
                redirect("units", "refresh");
            }
        } else {
            $this->load->view("units/add", $this->data);
        }
    }

}
