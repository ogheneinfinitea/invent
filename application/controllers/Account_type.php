<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class account_type extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['account_type'] = $this->web->GetAll("account_type_id", "account_type");
        // print_r($this->data['account_type']); die();
        $this->load->view("account_type/all", $this->data);
    }

    function view() {
        $account_type_id = $this->uri->segment(3);
        $this->data['account_type'] = $this->web->GetOne("account_type_id", "account_type", $account_type_id);
        $this->load->view("account_type/edit", $this->data);
    }

    function edit() {
        $data = array();
        $data['account_type'] = $this->db->escape_str($this->input->post("account_type", true));
        $id = $this->input->post("account_type_id", true);
        $this->web->Update("account_type_id", "account_type", $id, $data);
        redirect("account_type", "refresh");
    }

    function delete() {
        $account_type_id = $this->input->post("id", true);
        if ($this->web->Delete("account_type_id", "account_type", $account_type_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['account_type'] = $this->db->escape_str($this->input->post("account_type", true));
            if ($this->web->Add("account_type", $data)) {
                redirect("account_type", "refresh");
            }
        } else {
            $this->load->view("account_type/add", $this->data);
        }
    }

}
