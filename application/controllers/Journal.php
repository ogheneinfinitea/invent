<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Journal extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        if (isset($_POST['filter'])) {
            $date_from = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("from_date", true))));
            $date_to = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("to_date", true))));

            $totalRec = count($this->web->GetAllJournals_filter($date_from, $date_to));

            //pagination configuration
            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'journal/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $this->ajax_pagination->initialize($config);

            //get the posts data
            $this->data['journals'] = $this->web->GetAllJournals_filter($date_from, $date_to, NULL, "{$this->perPage}");
//            $this->data['issues'] = $this->web->GetAllWithInner("issue_id", "issue", "warehouses", "warehouse_id", "sections", "section_id", " WHERE issue.warehouse_id IS NOT NULL AND  (DATE(issue.date) between {$date_from} and {$date_to})");
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;





//            $this->data['journals'] = $this->web->GetAllJournals_filter($date_from, $date_to);
            $this->load->view("journal/all", $this->data);
        } else {
            $totalRec = count($this->web->GetAllJournals());

            //pagination configuration
            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'journal/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $this->ajax_pagination->initialize($config);

            $this->data['journals'] = $this->web->GetAllJournals(NULL, "{$this->perPage}");
            $this->load->view("journal/all", $this->data);
        }
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
        $totalRec = count($this->web->GetAllJournals_filter($date_from, $date_to, $search));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'journal/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['journals'] = $this->web->GetAllJournals_filter($date_from, $date_to, $search, "  {$offset},{$this->perPage}");

        //load the view
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['search'] = $search;
        $data['count'] = $offset + 1;


//        print_r($data['date_from']);
//        print_r($data['date_to']);
//        print_r($data['search']);
//        die();
        $this->load->view('journal/ajax-pagination-data', $data, false);
    }

    public function search() {
        $search_text = $this->input->post('id');

        $totalRec = count($this->web->GetAllJournals($search_text));

//        $totalRec = 222;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'journal/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $this->data['journals'] = $this->web->GetAllJournals($search_text, " {$this->perPage}");
        $this->data['search'] = $search_text;

        $this->load->view("journal/all", $this->data);
    }

    function view() {
        $journal_id = $this->uri->segment(3);
        $this->data['journal'] = $this->web->GetOne("journal_id", "journals", $journal_id);
        $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");
        $this->load->view("journal/edit", $this->data);
    }

    function edit() {
        $data = array();
        $data['date'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date", true)))) . " " . date("H:i:s");
        $data['from_account'] = $this->db->escape_str($this->input->post("from_account", true));
        $data['journal_id'] = $this->db->escape_str($this->input->post("journal_id", true));
        $data['to_account'] = $this->db->escape_str($this->input->post("to_account", true));
        $data['amount'] = $this->db->escape_str($this->input->post("amount", true));
        $data['description'] = htmlentities($this->input->post("desc", true));
       
        
        if ($data['from_account'] == "0") {
             $data['CPV'] = $this->input->post("CPV", true);
            if (empty($data['CPV'])) {
                $old_cpv = $this->web->GetLastInsertedRow("journal_id", "journals", " where journals.CPV IS NOT NULL");
                if (!empty($old_cpv)) {
                    $old_cpv_arr = explode("#", $old_cpv[0]->CPV);
                    $CPV = $old_cpv_arr[1] + 1;
                    $data['CPV'] = $CPV;
                } else {
                    $data['CPV'] = 'CPV#00001';
                }
            }
        } elseif ($data['to_account'] == "0") {
            $data['CRV'] = $this->input->post("CRV", true);
            if (empty($data['CRV'])) {
                $old_crv = $this->web->GetLastInsertedRow("journal_id", "journals", " where journals.CRV IS NOT NULL");
                if (!empty($old_crv)) {
                    $old_crv_arr = explode("#", $old_crv[0]->CRV);
                    $CRV = $old_crv_arr[1] + 1;
                    $data['CRV'] = $CRV;
                } else {
                    $data['CRV'] = 'CRV#00001';
                }
            }
        }
        if ($this->web->Update("journal_id", "journals", $data['journal_id'], $data)) {
            $this->web->Delete("journal_ref", "ledger", $data['journal_id']);
            if ($data['from_account'] == "0" && $data['to_account'] !== "0") {
                $query = "INSERT INTO ledger (debit_amount,credit_amount,description,type,account_id,journal_ref,date) VALUES ";
                $query .= "('" . $data['amount'] . "',NULL,'" . $data['description'] . "','Journal','" . $data['from_account'] . "','" . $data['journal_id'] . "','" . $data['date'] . "')";
            } elseif ($data['to_account'] == "0" && $data['from_account'] !== "0") {
                $query = "INSERT INTO ledger (debit_amount,credit_amount,description,type,account_id,journal_ref,date) VALUES ";
                $query .= "(NULL,'" . $data['amount'] . "','" . $data['description'] . "','Journal','" . $data['to_account'] . "','" . $data['journal_id'] . "','" . $data['date'] . "')";
            } else {
                $query = "INSERT INTO ledger (debit_amount,credit_amount,description,type,account_id,journal_ref,date) VALUES ";
                $query .= "('" . $data['amount'] . "',NULL,'" . $data['description'] . "','Journal','" . $data['to_account'] . "','" . $data['journal_id'] . "','" . $data['date'] . "'),";
                $query .= "(NULL,'" . $data['amount'] . "','" . $data['description'] . "','Journal','" . $data['from_account'] . "','" . $data['journal_id'] . "','" . $data['date'] . "')";
            }

            if ($this->db->query($query)) {
                // die();
                redirect("journal", "refresh");
            }
        }
    }
    function view_journal() {
        $journal_id = $this->uri->segment(3);
        $this->data['journal'] = $this->web->GetJournal($journal_id);
        $data = array();
        $this->load->view("journal/view_journal", $this->data);
    }

    function print_journal() {
        $journal_id = $this->uri->segment(3);
        $this->data['journal'] = $this->web->GetJournal($journal_id);
    
        $data = array();
        $this->load->view("journal/print_journal", $this->data);
    }

    function delete() {
        $journal_id = $this->input->post("id", true);
        if ($this->web->Delete("journal_id", "journals", $journal_id)) {
            if ($this->web->Delete("journal_ref", "ledger", $journal_id)) {
                echo "done";
            }
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['date'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date", true)))) . " " . date("H:i:s");
            $data['from_account'] = $this->db->escape_str($this->input->post("from_account", true));
            $data['to_account'] = $this->db->escape_str($this->input->post("to_account", true));
            $data['amount'] = $this->db->escape_str($this->input->post("amount", true));
            $data['voucher_no'] = $this->db->escape_str($this->input->post("jv_no", true));
            $data['description'] = htmlentities($this->input->post("desc", true));
            if ($data['from_account'] == "0") {
                $old_cpv = $this->web->GetLastInsertedRow("journal_id", "journals", " where journals.CPV IS NOT NULL");
                if (!empty($old_cpv)) {
                    $old_cpv_arr = explode("#", $old_cpv[0]->CPV);
                    $CPV = $old_cpv_arr[1] + 1;
                    $data['CPV'] = 'CPV#' . sprintf('%05d', $CPV);
                } else {
                    $data['CPV'] = 'CPV#00001';
                }
            } elseif ($data['to_account'] == "0") {
                $old_crv = $this->web->GetLastInsertedRow("journal_id", "journals", " where journals.CRV IS NOT NULL");
                if (!empty($old_crv)) {
                    $old_crv_arr = explode("#", $old_crv[0]->CRV);
                    $CRV = $old_crv_arr[1] + 1;
                    $data['CRV'] = 'CRV#'.sprintf('%05d', $CRV);
                } else {
                    $data['CRV'] = 'CRV#00001';
                }
            }
            if ($this->web->Add("journals", $data)) {
                $journal_id = $this->web->GetLastInsertedRow("journal_id", "journals");
                if ($data['from_account'] == "0" && $data['to_account'] !== "0") {
                    $query = "INSERT INTO ledger (debit_amount,credit_amount,description,type,account_id,journal_ref,date) VALUES ";
                    $query .= "('" . $data['amount'] . "',NULL,'" . $data['description'] .$data['voucher_no']. "','Journal','" . $data['from_account'] . "','" . $journal_id[0]->journal_id . "','" . $data['date'] . "')";
                } elseif ($data['to_account'] == "0" && $data['from_account'] !== "0") {
                    $query = "INSERT INTO ledger (debit_amount,credit_amount,description,type,account_id,journal_ref,date) VALUES ";
                    $query .= "(NULL,'" . $data['amount'] . "','" . $data['description'] .$data['voucher_no']. "','Journal','" . $data['to_account'] . "','" . $journal_id[0]->journal_id . "','" . $data['date'] . "')";
                } else {
                    $query = "INSERT INTO ledger (debit_amount,credit_amount,description,type,account_id,journal_ref,date) VALUES ";
                    $query .= "('" . $data['amount'] . "',NULL,'" . $data['description'].$data['voucher_no'] . "','Journal','" . $data['to_account'] . "','" . $journal_id[0]->journal_id . "','" . $data['date'] . "'),";
                    $query .= "(NULL,'" . $data['amount'] . "','" . $data['description'].$data['voucher_no'] . "','Journal','" . $data['from_account'] . "','" . $journal_id[0]->journal_id . "','" . $data['date'] . "')";
                }
                ////
//            $data['type'] = "Journal";
                if ($this->db->query($query)) {
                    //die();
                    redirect("journal", "refresh");
                }
            }
        } else {
            $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");
            $last_invoice = $this->web->GetLastInsertedRow("journal_id", "journals");
            if (!empty($last_invoice)) {
                $p_no = explode("\n", $last_invoice[0]->voucher_no);

                $inc = explode("#", $p_no[0]);
                $no = $inc[1] + 1;
                $no = sprintf('%05d', $no);
                $p_no = str_replace(' ','',$inc[0]) . " # " . $no;
                $this->data['last_journal_no'] = $p_no;
                // print_r($this->data['last_journal_no']);
                // die();
            } else {
                $this->data['last_journal_no'] = 'J-V # 00001';
            }
            $this->load->view("journal/add", $this->data);
        }
    }

}
