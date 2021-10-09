<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['users'] = $this->web->GetAll("id", "users");
        // print_r($this->data['users']); die();
        $this->load->view("users/all", $this->data);
    }

    function view() {
        $user_id = $this->uri->segment(3);
        $this->data['user'] = $this->web->GetOne("id", "users", $user_id);
        $this->load->view("users/edit", $this->data);
    }

    function edit() {
        $data = array();
        $data['name'] = $this->db->escape_str($this->input->post("name", true));
        $data['email'] = $this->db->escape_str($this->input->post("email", true));
        $data['password'] = sha1($this->db->escape_str($this->input->post("password", true)));
        if ($data['password'] == "") {
            unset($data['password']);
        }
        $status = $this->input->post("checkbox-example-1", true);
        $data['status'] = ($status == "on" ? 1 : 0);
        $id = $this->input->post("user_id", true);
        $this->web->Update("id", "users", $id, $data);
        redirect("users", "refresh");
    }

    function delete() {
        $user_id = $this->input->post("id", true);
        if ($this->web->Delete("id", "users", $user_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['name'] = $this->db->escape_str($this->input->post("name", true));
            $data['email'] = $this->db->escape_str($this->input->post("email", true));
            $data['password'] = sha1($this->db->escape_str($this->input->post("password", true)));
            if ($data['password'] == "") {
                unset($data['password']);
            }
            $status = $this->input->post("checkbox-example-1", true);
            $data['status'] = ($status == "on" ? 1 : 0);
            $data['user_group_id'] = $this->input->post("user_group", true);
//            print_r($data);
//            die();
            if ($this->web->Add("users", $data)) {
                redirect("users", "refresh");
            }
        } else {
            $this->data['user_groups'] = $this->web->GetAll("user_group_id", "user_groups");
            $this->load->view("users/add", $this->data);
        }
    }

}
