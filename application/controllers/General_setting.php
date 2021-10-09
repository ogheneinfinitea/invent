<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class General_setting extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['errors'] = "";



        if ($this->input->post()) {
            if (!empty(($_FILES["company_logo"]["name"]))) {
                //file uploading
                $target_dir1 = $_SERVER["DOCUMENT_ROOT"] . "/facteezo/images/";
                //die($target_dir1);
                $target_file1 = $target_dir1 . basename($_FILES["company_logo"]["name"]);
                $uploadOk1 = 1;
                $imageFileType1 = strtolower(pathinfo($target_file1, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

                $check1 = getimagesize($_FILES["company_logo"]["tmp_name"]);
                if ($check1 !== false) {
                    $this->data['errors'] .= $_FILES["company_logo"]["name"] . " is an image - " . $check1["mime"] . ".<br/>";
                    $uploadOk1 = 1;
                } else {
                    $this->data['errors'] .= $_FILES["company_logo"]["name"] . " is not an image.<br/>";
                    $uploadOk1 = 0;
                }

// Check if file already exists
// Allow certain file formats
                if ($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif") {
                    $this->data['errors'] .= "Sorry, " . $_FILES["company_logo"]["name"] . " is not JPG, JPEG, PNG or GIF .<br/>";
                    $uploadOk1 = 0;
                }
// Check if $uploadOk is set to 0 by an error
                if ($uploadOk1 == 0) {
                    $this->data['errors'] .= "Sorry, your file" . $_FILES["company_logo"]["name"] . " was not uploaded.<br/>";
// if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file1)) {
//file uploading
                        $data = array();
                        $data['company_logo'] = $_FILES["company_logo"]["name"];
                        $data['company_name'] = $this->db->escape_str($this->input->post("company_name", true));
                        $data['company_address'] = $this->db->escape_str($this->input->post("company_address", true));
                        $data['currency_symbol'] = $this->db->escape_str($this->input->post("currency", true));
                        if ($this->web->Update("g_s_id", "general_setting", 1, $data)) {
                            $session_data = array('company_logo' => "{$data['company_logo']}", 'company_name' => "{$data['company_name']}", 'currency_symbol' => "{$data['currency_symbol']}");
                            $this->session->set_userdata($session_data);

//                            redirect("General_setting", "refresh");
                        }
                    } else {
                        $this->data['general_setting'] = $this->web->GetAll("g_s_id", "general_setting", $g_s_id);
                        $this->load->view("general_setting/add", $this->data);
                    }
                }
            }













            if (!empty(($_FILES["company_view_logo"]["name"]))) {
//file uploading
                $target_dir2 = $_SERVER["DOCUMENT_ROOT"] . "/facteezo/images/";
//            die($target_dir);
                $target_file2 = $target_dir2 . basename($_FILES["company_view_logo"]["name"]);
                $uploadOk2 = 1;
                $imageFileType2 = strtolower(pathinfo($target_file2, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

                $check2 = getimagesize($_FILES["company_view_logo"]["tmp_name"]);
                if ($check2 !== false) {
                    $this->data['errors'] .= $_FILES["company_view_logo"]["name"] . " is an image - " . $check2["mime"] . ".<br/>";
                    $uploadOk2 = 1;
                } else {
                    $this->data['errors'] .= $_FILES["company_view_logo"]["name"] . " is not an image.<br/>";
                    $uploadOk2 = 0;
                }

// Check if file already exists
// Allow certain file formats
                if ($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg" && $imageFileType2 != "gif") {
                    $this->data['errors'] .= "Sorry, " . $_FILES["company_view_logo"]["name"] . " is not JPG, JPEG, PNG or GIF <br/>";
                    $uploadOk2 = 0;
                }
// Check if $uploadOk is set to 0 by an error
                if ($uploadOk2 == 0) {
                    $this->data['errors'] .= "Sorry, your file " . $_FILES["company_view_logo"]["name"] . " was not uploaded.<br/>";
// if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["company_view_logo"]["tmp_name"], $target_file2)) {
//file uploading
                        $data = array();
                        $data['company_view_logo'] = $_FILES["company_view_logo"]["name"];
                        $data['company_name'] = $this->db->escape_str($this->input->post("company_name", true));
                        $data['company_address'] = $this->db->escape_str($this->input->post("company_address", true));
                        $data['currency_symbol'] = $this->db->escape_str($this->input->post("currency", true));
                        if ($this->web->Update("g_s_id", "general_setting", 1, $data)) {
                            $session_data = array('company_view_logo' => "{$data['company_view_logo']}", 'company_name' => "{$data['company_name']}", 'currency_symbol' => "{$data['currency_symbol']}");
                            $this->session->set_userdata($session_data);

//                            redirect("General_setting", "refresh");
                        }
                    } else {
                        $this->data['general_setting'] = $this->web->GetAll("g_s_id", "general_setting", $g_s_id);
                        $this->load->view("general_setting/add", $this->data);
                    }
                }
            }












            if (!empty(($_FILES["company_invoice_logo"]["name"]))) {
//file uploading
                $target_dir3 = $_SERVER["DOCUMENT_ROOT"] . "/facteezo/images/";
//            die($target_dir);
                $target_file3 = $target_dir3 . basename($_FILES["company_invoice_logo"]["name"]);
                $uploadOk3 = 1;
                $imageFileType3 = strtolower(pathinfo($target_file3, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

                $check3 = getimagesize($_FILES["company_invoice_logo"]["tmp_name"]);
                if ($check3 !== false) {
                    $this->data['errors'] .= $_FILES["company_invoice_logo"]["name"] . " is an image - " . $check3["mime"] . ".<br/>";
                    $uploadOk3 = 1;
                } else {
                    $this->data['errors'] .= $_FILES["company_invoice_logo"]["name"] . " is not an image.<br/>";
                    $uploadOk3 = 0;
                }

// Check if file already exists
// Allow certain file formats
                if ($imageFileType3 != "jpg" && $imageFileType3 != "png" && $imageFileType3 != "jpeg" && $imageFileType3 != "gif") {
                    $this->data['errors'] .= "Sorry, " . $_FILES["company_invoice_logo"]["name"] . " is not JPG, JPEG, PNG or GIF .<br/>";
                    $uploadOk3 = 0;
                }
// Check if $uploadOk is set to 0 by an error
                if ($uploadOk3 == 0) {
                    $this->data['errors'] .= "Sorry, your file " . $_FILES["company_invoice_logo"]["name"] . " was not uploaded.<br/>";
// if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["company_invoice_logo"]["tmp_name"], $target_file3)) {
                        //file uploading
                        $data = array();
                        $data['company_invoice_logo'] = $_FILES["company_invoice_logo"]["name"];
                        $data['company_name'] = $this->db->escape_str($this->input->post("company_name", true));
                        $data['company_address'] = $this->db->escape_str($this->input->post("company_address", true));
                        $data['currency_symbol'] = $this->db->escape_str($this->input->post("currency", true));
                        if ($this->web->Update("g_s_id", "general_setting", 1, $data)) {
                            $session_data = array('company_invoice_logo' => "{$data['company_invoice_logo']}", 'company_name' => "{$data['company_name']}", 'currency_symbol' => "{$data['currency_symbol']}");
                            $this->session->set_userdata($session_data);

//                            redirect("General_setting", "refresh");
                        }
                    } else {
                        $this->data['general_setting'] = $this->web->GetAll("g_s_id", "general_setting", $g_s_id);
                        $this->load->view("general_setting/add", $this->data);
                    }
                }
            } else {
                $data = array();
                $data['company_name'] = $this->db->escape_str($this->input->post("company_name", true));
                $data['company_address'] = $this->db->escape_str($this->input->post("company_address", true));
                $data['currency_symbol'] = $this->db->escape_str($this->input->post("currency", true));
                if ($this->web->Update("g_s_id", "general_setting", 1, $data)) {
                    $session_data = array('company_name' => "{$data['company_name']}", 'currency_symbol' => "{$data['currency_symbol']}");
                    $this->session->set_userdata($session_data);
//                    redirect("General_setting", "refresh");
                }
            }
//            die();
            redirect("General_setting", "refresh");
        }

        $this->data['general_setting'] = $this->web->GetAll("g_s_id", "general_setting");

        $this->load->view("general_setting/add", $this->data);
    }

}
