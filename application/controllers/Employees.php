<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

////////////// index account controller  ///////////////////////////////////

    function index() {

        $totalRec = count($this->web->GetAllEmp());
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'employees/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $this->data['employees'] = $this->web->GetAllEmp($this->perPage);



// $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");

        $this->load->view("employees/all", $this->data);
    }

    function ajaxPaginationData() {

        $page = $this->input->post('page');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $search = $this->input->post('search');

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        //total rows count
        $totalRec = count($this->web->GetAllEmp(NULL, $search));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'employees/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['employees'] = $this->web->GetAllEmp("{$offset},{$this->perPage}", $search);

        //load the view
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['search'] = $search;
        $data['count'] = $offset + 1;


        $this->load->view('employees/ajax-pagination-data', $data, false);
    }

    function view_payslip() {
        $employee_ledger_id = $this->uri->segment(3);
        $this->data['employee_ledger'] = $this->web->GetOne('employee_ledger_id', 'employee_ledger', $employee_ledger_id);
        $this->data['employee_ledger_detail'] = $this->web->GetAll('employee_ledger_detail_id', 'employee_ledger_detail', " where employee_ledger_id={$employee_ledger_id}");
        $this->data['employees'] = $this->web->GetAll("employee_id", "employees");
        $this->data['unique_id'] = GetUniqueId(($this->data['employee_ledger'][0]->employee_id));
        $this->data['employee_id'] = ($this->data['employee_ledger'][0]->employee_id);
        $this->data['month'] = ($this->data['employee_ledger'][0]->month);
        $this->data['year'] = ($this->data['employee_ledger'][0]->year);
        $this->load->view("employees/edit_payslip", $this->data);
    }

    function view_payslip_print() {
        $employee_ledger_id = $this->uri->segment(3);
        $this->data['employee_ledger'] = $this->web->GetOne('employee_ledger_id', 'employee_ledger', $employee_ledger_id);
        $this->data['employee_ledger_detail'] = $this->web->GetAll('employee_ledger_detail_id', 'employee_ledger_detail', " where employee_ledger_id={$employee_ledger_id}");
        $this->data['employees'] = $this->web->GetAll("employee_id", "employees");
        $this->data['unique_id'] = GetUniqueId(($this->data['employee_ledger'][0]->employee_id));
        $this->data['employee_id'] = ($this->data['employee_ledger'][0]->employee_id);
        $this->data['month'] = ($this->data['employee_ledger'][0]->month);
        $this->data['year'] = ($this->data['employee_ledger'][0]->year);
        $this->load->view("employees/view_payslip", $this->data);
    }
    function view_advance_print() {
        $employee_ledger_id = $this->uri->segment(3);
        $this->data['employee_ledger'] = $this->web->GetOne('employee_ledger_id', 'employee_ledger', $employee_ledger_id);

        
        $this->data['employee_ledger_detail'] = $this->web->GetAll('employee_ledger_detail_id', 'employee_ledger_detail', " where employee_ledger_id={$employee_ledger_id}");
        $this->data['employees'] = $this->web->GetAll("employee_id", "employees");
        $this->data['unique_id'] = GetUniqueId(($this->data['employee_ledger'][0]->employee_id));
        $this->data['employee_id'] = ($this->data['employee_ledger'][0]->employee_id);
        $this->data['month'] = ($this->data['employee_ledger'][0]->month);
        $this->data['year'] = ($this->data['employee_ledger'][0]->year);
        $this->load->view("employees/view_advance", $this->data);
    }

    public function search() {
        $search_text = $this->input->post('id');
        $totalRec = count($this->web->GetAllEmp(NULL, $search_text));
//        $totalRec = 222;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'employees/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data

        $this->data['employees'] = $this->web->GetAllEmp($this->perPage, $search_text);
        $this->data['search'] = $search_text;

        $this->load->view("employees/all", $this->data);
    }

    function increment() {
        $this->data['increments'] = $this->web->GetAllIncrements();
        $this->load->view("employees/increment", $this->data);
    }

    function add_increment() {
        if ($this->input->post()) {
            $data = array();
            $data['employee_id'] = $this->db->escape_str($this->input->post("emp_name", true));
            $emp_basic_salary = $this->db->escape_str($this->input->post("emp_basic_salary", true));
            $data['salary'] = $this->db->escape_str($this->input->post("ledger_amount", true));
            $data['inc_amount'] = $data['salary'] - $emp_basic_salary;
            $data['date'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("ledger_date", true))));
            $data['inc_description'] = htmlentities($this->input->post("description", true));
//            print_r($data);
//            die();

            if ($this->web->Add("employee_salary", $data)) {
                redirect("employees/increment", "refresh");
            }
        } else {
            $this->data['employees'] = $this->web->GetAll("employee_id", "employees");
            $this->load->view("employees/add_increment", $this->data);
        }
    }

    function payslip() {
        $this->data['payslips'] = $this->web->GetAllpayslips();
        $this->load->view("employees/payslip", $this->data);
    }

    function add_payslip() {

        if ($this->input->post()) {
            $data = array();
            $data_detail = array();
            $data['employee_id'] = $this->db->escape_str($this->input->post("emp_name", true));
            $data['ledger_amount'] = $this->db->escape_str($this->input->post("ledger_amount", true));
            $data['ledger_date'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("ledger_date", true))));
            $data['description'] = htmlentities($this->input->post("description", true));
            $data['type'] = 'Salary';
            $data['month'] = $this->input->post("month", true);
            $data['year'] = $this->input->post("year", true);
            $data_detail['all_name'] = (array)$this->input->post("all_name", true);
            $data_detail['all_amount'] = $this->input->post("all_amount", true);
            $data_detail['ded_name'] = (array)$this->input->post("ded_name", true);
            $data_detail['ded_amount'] = $this->input->post("ded_amount", true);
            $already = $this->web->GetSalaryReport($data['month'], $data['year'], $data['employee_id']);
            if (!empty($already[0])) {
                $this->session->set_flashdata("already", "Pay slip is already created for <span style='font-size:20px;color:brown;'>" . ucfirst($already[0]->emp_name) . "</span> for month <span style='font-size:20px;color:brown;'>{$data['month']}</span> Year <span style='font-size:20px;color:brown;'>{$data['year']}</span>");
                redirect("employees/add_payslip", "refresh");
            }
            if ($this->web->Add("employee_ledger", $data)) {

                $employee_ledger = $this->web->GetLastInsertedRow("employee_ledger_id", "employee_ledger");
                $query_main_ledger = "INSERT INTO ledger (debit_amount,credit_amount,description,type,account_id,salary_ref,date) VALUES ";
                $query_main_ledger .= "('" . $data['ledger_amount'] . "',NULL,'" . $data['description'] . "','salary','0','" . $employee_ledger[0]->employee_ledger_id . "','" . $data['ledger_date'] . "')";
                $this->db->query($query_main_ledger);
               // var_dump($data_detail['all_name']);
               // die;
                $all_len = count($data_detail['all_name']);
                $ded_len = count($data_detail['ded_name']);
                if ($all_len > 0) {
                    $insert_all = "INSERT INTO employee_ledger_detail (employee_ledger_id, type, detail_name,detail_amount) VALUES ";
                    for ($i = 0; $i < $all_len; $i++) {
                        $insert_all .= "('" . $employee_ledger[0]->employee_ledger_id . "','Allowance','" . $data_detail['all_name'][$i] . "','" . $data_detail['all_amount'][$i] . "'),";
                    }
                    $insert_all = rtrim($insert_all, ",");
                    $this->db->query($insert_all);
                }
                if ($ded_len > 0) {
                    $insert_ded = "INSERT INTO employee_ledger_detail (employee_ledger_id, type, detail_name,detail_amount) VALUES ";
                    for ($i = 0; $i < $ded_len; $i++) {
                        $insert_ded .= "('" . $employee_ledger[0]->employee_ledger_id . "','Deduction','" . $data_detail['ded_name'][$i] . "','" . $data_detail['ded_amount'][$i] . "'),";
                    }
                    $insert_ded = rtrim($insert_ded, ",");
                    $this->db->query($insert_ded);
                }
               // die("we are here");
                redirect("employees/payslip", "refresh");
            }
        } else {
            $this->data['employees'] = $this->web->GetAll("employee_id", "employees");
            $this->load->view("employees/add_payslip", $this->data);
        }
    }

    function edit_payslip($employee_ledger_id) {

        if ($this->input->post()) {
            $data = array();
            $data_detail = array();
            $data['employee_id'] = $this->db->escape_str($this->input->post("emp_name", true));
            $data['ledger_amount'] = $this->db->escape_str($this->input->post("ledger_amount", true));
            $old_ledger_amount = $this->db->escape_str($this->input->post("old_ledger_amount", true));
            $data['ledger_date'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("ledger_date", true))));
            $data['description'] = htmlentities($this->input->post("description", true));
            $data['type'] = 'Salary';
            $data['month'] = $this->input->post("month", true);
            $data['year'] = $this->input->post("year", true);
            $data_detail['all_name'] = $this->input->post("all_name", true);
            $data_detail['all_amount'] = $this->input->post("all_amount", true);
            $data_detail['ded_name'] = $this->input->post("ded_name", true);
            $data_detail['ded_amount'] = $this->input->post("ded_amount", true);
            if ($this->web->Update("employee_ledger_id", "employee_ledger", $employee_ledger_id, $data)) {
                $query_main_ledger_revert = "INSERT INTO ledger (credit_amount,debit_amount,description,type,account_id,salary_ref,date) VALUES ";
                $query_main_ledger_revert .= "('" . $old_ledger_amount . "',NULL,'" . $data['description'] . "','salary','0','" . $employee_ledger_id . "','" . $data['ledger_date'] . "')";
                $this->db->query($query_main_ledger_revert);
                $query_main_ledger = "INSERT INTO ledger (debit_amount,credit_amount,description,type,account_id,salary_ref,date) VALUES ";
                $query_main_ledger .= "('" . $data['ledger_amount'] . "',NULL,'" . $data['description'] . "','salary','0','" . $employee_ledger_id . "','" . $data['ledger_date'] . "')";
                $this->db->query($query_main_ledger);

                $this->web->Delete("employee_ledger_id", "employee_ledger_detail", $employee_ledger_id);
                $all_len = sizeof($data_detail['all_name']);
                $ded_len = sizeof($data_detail['ded_name']);

                if ($all_len > 0) {
                    $insert_all = "INSERT INTO employee_ledger_detail (employee_ledger_id, type, detail_name,detail_amount) VALUES ";
                    for ($i = 0; $i < $all_len; $i++) {
                        $insert_all .= "('" . $employee_ledger_id . "','Allowance','" . $data_detail['all_name'][$i] . "','" . $data_detail['all_amount'][$i] . "'),";
                    }
                    $insert_all = rtrim($insert_all, ",");
                    $this->db->query($insert_all);
                }
                if ($ded_len > 0) {
                    $insert_ded = "INSERT INTO employee_ledger_detail (employee_ledger_id, type, detail_name,detail_amount) VALUES ";
                    for ($i = 0; $i < $ded_len; $i++) {
                        $insert_ded .= "('" . $employee_ledger_id . "','Deduction','" . $data_detail['ded_name'][$i] . "','" . $data_detail['ded_amount'][$i] . "'),";
                    }
                    $insert_ded = rtrim($insert_ded, ",");
                    $this->db->query($insert_ded);
                }
                redirect("employees/payslip", "refresh");
            }
        } else {
            $this->data['employees'] = $this->web->GetAll("employee_id", "employees");
            $this->load->view("employees/add_payslip", $this->data);
        }
    }

    function advance() {
        $this->data['advances'] = $this->web->GetAllAdvances();

        $this->load->view("employees/advance", $this->data);
    }

    function add_advance() {
        if ($this->input->post()) {
            $data = array();
            $data['employee_id'] = $this->db->escape_str($this->input->post("emp_name", true));
            $data['ledger_amount'] = $this->db->escape_str($this->input->post("ledger_amount", true));
            $data['ledger_date'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("ledger_date", true))));
            $data['description'] = htmlentities($this->input->post("description", true));
            $data['type'] = 'Advance';
            $data['month'] = $this->input->post("month", true);
            $data['year'] = $this->input->post("year", true);

            if ($this->web->Add("employee_ledger", $data)) {
                $employee_ledger = $this->web->GetLastInsertedRow("employee_ledger_id", "employee_ledger");
                $query_main_ledger = "INSERT INTO ledger (debit_amount,credit_amount,description,type,account_id,salary_ref,date) VALUES ";
                $query_main_ledger .= "('" . $data['ledger_amount'] . "',NULL,'" . $data['description'] . "','salary','0','" . $employee_ledger[0]->employee_ledger_id . "','" . $data['ledger_date'] . "')";
                $this->db->query($query_main_ledger);
                redirect("employees/advance", "refresh");
            }
        } else {
            $this->data['employees'] = $this->web->GetAll("employee_id", "employees");
            $this->load->view("employees/add_advance", $this->data);
        }
    }

    function GetBasicSalary() {
        $employee_id = $this->input->post("employee_id");
        $emp_rec = $this->web->GetBasicSalary($employee_id);
        echo $emp_rec[0]->salary;
        die();
    }

    function GetAdvance() {
        $employee_id = $this->input->post("employee_id");
        $month = $this->input->post("month");
        $year = $this->input->post("year");
        $emp_rec = $this->web->GetAdvance($employee_id, $month, $year);
        echo $emp_rec[0]->total_advance;
        die();
    }

    function view() {
        $account_id = $this->uri->segment(3);
        $this->data['employee'] = $this->web->GetEmployeeById($account_id);

        $this->load->view("employees/edit", $this->data);
    }

    function edit($employee_id) {
        $data = array();
        $data_salary = array();
        $data['emp_name'] = $this->db->escape_str($this->input->post("emp_name", true));
        $data['emp_father_name'] = $this->db->escape_str($this->input->post("emp_father_name", true));
        $data['emp_phone'] = $this->db->escape_str($this->input->post("emp_phone", true));
        $data['emp_marital_status'] = $this->db->escape_str($this->input->post("emp_marital_status", true));
        $data['emp_designation'] = $this->db->escape_str($this->input->post("emp_designation", true));
        $data['emp_local_address'] = $this->db->escape_str($this->input->post("emp_local_address", true));
        $data['emp_permanent_address'] = $this->db->escape_str($this->input->post("emp_permanent_address", true));
        $data['emp_dob'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("emp_dob", true))));
        $data['emp_doj'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("emp_doj", true))));
        $data['emp_desc'] = $this->db->escape_str($this->input->post("emp_desc", true));
        $data_salary['salary'] = $this->db->escape_str($this->input->post("salary", true));

        $data['emp_status'] = $this->db->escape_str($this->input->post("emp_status", true));
        if ($data['emp_status'] == "on") {
            $data['emp_status'] = 1;
        } else {
            $data['emp_status'] = 1;
        }

        if ($this->web->Update("employee_id", "employees", $employee_id, $data)) {
//            $GetLastEmployee = $this->web->GetLastInsertedRow("employee_id", "employees");
//            $employee_id = $GetLastEmployee[0]->employee_id;
            $employee_unique_id = $employee_id . substr(time(), 0, 2) . substr(time(), -2);
            if (!isset($_POST['employee_last_id'])) {
                $update_employee_unique_id = $this->web->UpdateEmployeeUniqueID($employee_id, $employee_unique_id);
                $data['employee_unique_id'] = $employee_unique_id;
            } else {

                $update_employee_unique_id = $this->web->UpdateEmployeeUniqueID($employee_id, $_POST['employee_last_id']);
                $data['employee_unique_id'] = $_POST['employee_last_id'];
            }
            $data_salary['employee_id'] = $employee_id;
            $data_salary['date'] = $data['emp_doj'];
            $prev_emp_sal = $this->web->GetAll("employee_salary_id", "employee_salary", " where employee_id={$employee_id}");
            if (!empty($prev_emp_sal[0])) {
                $this->web->Delete("employee_id", "employee_salary", $employee_id);
                $this->web->Add("employee_salary", $data_salary);
            }

            //image_upload
            $this->data['errors'] = "";
            if (!empty(($_FILES["emp_photo"]["name"]))) {
                //file uploading

                if (!file_exists("images/{$data['employee_unique_id']}")) {
                    mkdir("images/{$data['employee_unique_id']}");
                }
                $target_dir1 = $_SERVER["DOCUMENT_ROOT"] . "/facteezo/images/{$data['employee_unique_id']}/";
                //die($target_dir1);
                $target_file1 = $target_dir1 . basename($_FILES["emp_photo"]["name"]);
                $uploadOk1 = 1;
                $imageFileType1 = strtolower(pathinfo($target_file1, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

                $check1 = getimagesize($_FILES["emp_photo"]["tmp_name"]);
                if ($check1 !== false) {
                    $this->data['errors'] .= $_FILES["emp_photo"]["name"] . " is an image - " . $check1["mime"] . ".<br/>";
                    $uploadOk1 = 1;
                } else {
                    $this->data['errors'] .= $_FILES["emp_photo"]["name"] . " is not an image.<br/>";
                    $uploadOk1 = 0;
                }

// Check if file already exists
// Allow certain file formats
                if ($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif") {
                    $this->data['errors'] .= "Sorry, " . $_FILES["emp_photo"]["name"] . " is not JPG, JPEG, PNG or GIF .<br/>";
                    $uploadOk1 = 0;
                }
// Check if $uploadOk is set to 0 by an error
                if ($uploadOk1 == 0) {
                    $this->data['errors'] .= "Sorry, your file" . $_FILES["emp_photo"]["name"] . " was not uploaded.<br/>";
// if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["emp_photo"]["tmp_name"], $target_file1)) {
                        $query = "update employees set emp_photo = '{$_FILES["emp_photo"]["name"]}' where employee_id={$employee_id}";
                        $this->db->query($query);
                    } else {

                    }
                }
            }
            //image_upload
            //employee documents
            //$files = array_filter($_FILES['upload']['name']); something like that to be used before processing files.
// Count # of uploaded files in array
            $total = count($_FILES['emp_documents']['name']);

// Loop through each file
            $document_err_arr = array();
            $file_names = array();
            for ($i = 0; $i < $total; $i++) {
                //Get the temp file path
                $tmpFilePath = $_FILES['emp_documents']['tmp_name'][$i];

                //Make sure we have a filepath
                if ($tmpFilePath != "") {
                    //Setup our new file path
                    $newFilePath = $_SERVER["DOCUMENT_ROOT"] . "/facteezo/images/{$data['employee_unique_id']}/{$_FILES['emp_documents']['name'][$i]}";
                    //die($target_dir1);
                    //Upload the file into the temp dir
                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $file_names[] = $_FILES['emp_documents']['name'][$i];
                        //Handle other code here
                    } else {
                        $this->data['error'] .= "Document {$_FILES['emp_documents']['name'][$i]} was not uploaded <br>";
                        $document_err_arr[] = "yes";
                    }
                }
            }
            if (!empty($document_err_arr)) {
                $this->load->view("employees/add", $this->data);
            } else {
                if (!empty($file_names)) {
                    $filesss = implode(",", $file_names);
                    $query = "update employees set emp_documents= '$filesss' where employee_id={$employee_id}";
                    $this->db->query($query);
                }
            }

            //employee documents

            redirect("employees", "refresh");
        }


        redirect("employees", "refresh");
    }

    function delete() {
        $account_id = $this->input->post("id", true);
        if ($this->web->Delete("employee_id", "employees", $account_id)) {
            $this->web->Delete("employee_id", "employee_salary", $account_id);
            echo "done";
        }
    }

    function delete_payslip() {
         $account_id = $this->input->post("id", true);
        if ($this->web->Delete("employee_ledger_id", "employee_ledger", $account_id)) {
            $this->web->Delete("employee_ledger_id", "employee_ledger_detail", $account_id);
            $this->web->Delete("salary_ref", "ledger", $account_id);
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data_salary = array();
            $data['emp_name'] = $this->db->escape_str($this->input->post("emp_name", true));
            $data['emp_father_name'] = $this->db->escape_str($this->input->post("emp_father_name", true));
            $data['emp_phone'] = $this->db->escape_str($this->input->post("emp_phone", true));
            $data['emp_marital_status'] = $this->db->escape_str($this->input->post("emp_marital_status", true));
            $data['emp_designation'] = $this->db->escape_str($this->input->post("emp_designation", true));
            $data['emp_local_address'] = $this->db->escape_str($this->input->post("emp_local_address", true));
            $data['emp_permanent_address'] = $this->db->escape_str($this->input->post("emp_permanent_address", true));
            $data['emp_dob'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("emp_dob", true))));
            $data['emp_doj'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("emp_doj", true))));
            $data['emp_desc'] = $this->db->escape_str($this->input->post("emp_desc", true));
            $data_salary['salary'] = $this->db->escape_str($this->input->post("salary", true));

            $data['emp_status'] = $this->db->escape_str($this->input->post("emp_status", true));
            if ($data['emp_status'] == "on") {
                $data['emp_status'] = 1;
            } else {
                $data['emp_status'] = 1;
            }

            if ($this->web->Add("employees", $data)) {
                $GetLastEmployee = $this->web->GetLastInsertedRow("employee_id", "employees");
                $employee_id = $GetLastEmployee[0]->employee_id;
                $employee_unique_id = $employee_id . substr(time(), 0, 2) . substr(time(), -2);
                if (!isset($_POST['employee_last_id'])) {
                    $update_employee_unique_id = $this->web->UpdateEmployeeUniqueID($employee_id, $employee_unique_id);
                    $data['employee_unique_id'] = $employee_unique_id;
                } else {
                    $update_employee_unique_id = $this->web->UpdateEmployeeUniqueID($employee_id, $_POST['employee_last_id']);
                    $data['employee_unique_id'] = $employee_unique_id;
                }
                $data_salary['employee_id'] = $employee_id;
                $data_salary['date'] = $data['emp_doj'];
                $this->web->Add("employee_salary", $data_salary);
                //image_upload
                $this->data['errors'] = "";
                if (!empty(($_FILES["emp_photo"]["name"]))) {
                    //file uploading

                    if (!file_exists("images/{$data['employee_unique_id']}")) {
                        mkdir("images/{$data['employee_unique_id']}");
                    }
                    $target_dir1 = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR."factoerp".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.$data['employee_unique_id'].DIRECTORY_SEPARATOR;
                    //die($target_dir1);
                    $target_file1 = $target_dir1 . basename($_FILES["emp_photo"]["name"]);
                    $uploadOk1 = 1;
                    $imageFileType1 = strtolower(pathinfo($target_file1, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

                    $check1 = getimagesize($_FILES["emp_photo"]["tmp_name"]);
                    if ($check1 !== false) {
                        $this->data['errors'] .= $_FILES["emp_photo"]["name"] . " is an image - " . $check1["mime"] . ".<br/>";
                        $uploadOk1 = 1;
                    } else {
                        $this->data['errors'] .= $_FILES["emp_photo"]["name"] . " is not an image.<br/>";
                        $uploadOk1 = 0;
                    }

// Check if file already exists
// Allow certain file formats
                    if ($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif") {
                        $this->data['errors'] .= "Sorry, " . $_FILES["emp_photo"]["name"] . " is not JPG, JPEG, PNG or GIF .<br/>";
                        $uploadOk1 = 0;
                    }
// Check if $uploadOk is set to 0 by an error
                    if ($uploadOk1 == 0) {
                        $this->data['errors'] .= "Sorry, your file" . $_FILES["emp_photo"]["name"] . " was not uploaded.<br/>";
// if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["emp_photo"]["tmp_name"], $target_file1)) {
                            $query = "update employees set emp_photo = '{$_FILES["emp_photo"]["name"]}' where employee_id={$employee_id}";
                            $this->db->query($query);
                        } else {

                        }
                    }
                }
                //image_upload
                //employee documents
                //$files = array_filter($_FILES['upload']['name']); something like that to be used before processing files.
// Count # of uploaded files in array
                $total = count($_FILES['emp_documents']['name']);

// Loop through each file
                $document_err_arr = array();
                $file_names = array();
                for ($i = 0; $i < $total; $i++) {
                    //Get the temp file path
                    $tmpFilePath = $_FILES['emp_documents']['tmp_name'][$i];

                    //Make sure we have a filepath
                    if ($tmpFilePath != "") {
                        //Setup our new file path
                        $newFilePath = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR. "facteezo".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.$data['employee_unique_id'].DIRECTORY_SEPARATOR.$_FILES['emp_documents']['name'][$i];
                        //die($target_dir1);
                        //Upload the file into the temp dir
                        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $file_names[] = $_FILES['emp_documents']['name'][$i];
                            //Handle other code here
                        } else {
                            $this->data['error'] .= "Document {$_FILES['emp_documents']['name'][$i]} was not uploaded <br>";
                            $document_err_arr[] = "yes";
                        }
                    }
                }
                if (!empty($document_err_arr)) {
                    $this->load->view("employees/add", $this->data);
                } else {
                    $filesss = implode(",", $file_names);
                    $query = "update employees set emp_documents= '$filesss' where employee_id={$employee_id}";
                    $this->db->query($query);
                }
                //employee documents
                //die('we are here');
                redirect("employees", "refresh");
            }
        } else {
            $this->load->view("employees/add", $this->data);
        }
    }

}
