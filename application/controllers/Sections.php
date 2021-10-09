<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sections extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['sections'] = $this->web->GetAll("section_id", "sections");
        // print_r($this->data['sections']); die();
        $this->load->view("sections/all", $this->data);
    }

    function view() {
        $section_id = $this->uri->segment(3);
        $this->data['section'] = $this->web->GetOne("section_id", "sections", $section_id);
        $this->load->view("sections/edit", $this->data);
    }

    function edit() {
        $data = array();
        $data['section_name'] = $this->db->escape_str($this->input->post("name", true));
        $data['section_address'] = $this->db->escape_str($this->input->post("address", true));
        $id = $this->input->post("section_id", true);
        $this->web->Update("section_id", "sections", $id, $data);
        redirect("sections", "refresh");
    }

    function delete() {
        $section_id = $this->input->post("id", true);
        if ($this->web->Delete("section_id", "sections", $section_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['section_name'] = $this->db->escape_str($this->input->post("name", true));
            $data['section_address'] = $this->db->escape_str($this->input->post("address", true));
            if ($this->web->Add("sections", $data)) {
                redirect("sections", "refresh");
            }
        } else {
            $this->load->view("sections/add", $this->data);
        }
    }

}
