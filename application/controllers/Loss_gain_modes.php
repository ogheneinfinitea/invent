<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loss_gain_modes extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['loss_gain_modes'] = $this->web->GetAll("loss_gain_mode_id", "loss_gain_modes");
        // print_r($this->data['loss_gain_modes']); die();
        $this->load->view("loss_gain_modes/all", $this->data);
    }

    function view() {
        $loss_gain_mode_id = $this->uri->segment(3);
        $this->data['loss_gain_modes'] = $this->web->GetOne("loss_gain_mode_id", "loss_gain_modes", $loss_gain_mode_id);
        $this->load->view("loss_gain_modes/edit", $this->data);
    }

    function edit() {
        $data = array();
        $data['loss_gain_mode'] = $this->db->escape_str($this->input->post("loss_gain_mode", true));
        $id = $this->input->post("loss_gain_mode_id", true);
        $this->web->Update("loss_gain_mode_id", "loss_gain_modes", $id, $data);
        redirect("loss_gain_modes", "refresh");
    }

    function delete() {
        $loss_gain_mode_id = $this->input->post("id", true);
        if ($this->web->Delete("loss_gain_mode_id", "loss_gain_modes", $loss_gain_mode_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['loss_gain_mode'] = $this->db->escape_str($this->input->post("loss_gain_mode", true));
            if ($this->web->Add("loss_gain_modes", $data)) {
                redirect("loss_gain_modes", "refresh");
            }
        } else {
            $this->load->view("loss_gain_modes/add", $this->data);
        }
    }

}
