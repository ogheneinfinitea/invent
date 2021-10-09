<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function account_statement() {
        if ($this->input->post()) {
            $this->data['account_id'] = $this->input->post("account", true);
            // $this->data['account_id'] = $this->web->GetJournal($this->data['journal_id'], $this->data['from_account'], $this->data['to_account']);
//            echo date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("from_date", true))));
//            die;
            $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
//            die($this->data['from_date']);
            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
            $open_balance = $this->web->GetBalanceforAccount($this->data['balance_to_date'], $this->data['account_id']);
            $this->data['account_name'] = $open_balance[0]->account_name;
            $this->data['open_balance'] = $open_balance[0]->balance;
            $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
            $this->data['account_report'] = $this->web->GetAccountLedger($this->data['account_id'], $this->data['from_date'], $this->data['to_date']);
            if (!empty($this->data['account_report'])) {
                $this->data['pro_report'] = array();
                foreach ($this->data['account_report'] as $ledger) {
                    if ($ledger->invoice_ref == NULL) {
                        $x = new stdClass();
                        $this->data['pro_report'][] = $x;
                    } else {
                        $this->data['pro_report'][] = $this->web->GetAccountProductLedger($ledger->invoice_ref);
                    }
                }
            }
//            print_r($this->data['account_report']);
//            die();
            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
            $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");
        }
        $this->load->view("reports/account_statement", $this->data);
    }

    function bank_statement() {
        if ($this->input->post()) {

            $this->data['account_id'] = $this->input->post("account", true);

            if (!empty($this->data['account_id'])) {
                $this->data['all_accounts'] = "no";
                $this->data['accounts_count'] = "";

                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
//            die($this->data['from_date']);
                $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
                $open_balance = $this->web->GetBalanceforAccount($this->data['balance_to_date'], $this->data['account_id']);
                $this->data['account_name'] = $open_balance[0]->account_name;
                $this->data['open_balance'] = $open_balance[0]->balance;
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
                $this->data['account_report'] = $this->web->GetAccountLedger($this->data['account_id'], $this->data['from_date'], $this->data['to_date']);
                if (!empty($this->data['account_report'])) {
                    $this->data['pro_report'] = array();
                    foreach ($this->data['account_report'] as $ledger) {
                        if ($ledger->invoice_ref == NULL) {
                            $x = new stdClass();
                            $this->data['pro_report'][] = $x;
                        } else {
                            $this->data['pro_report'][] = $this->web->GetAccountProductLedger($ledger->invoice_ref);
                        }
                    }
                }
            } else {


                $this->data['all_accounts'] = "yes";
                $accounts = $this->web->GetAll("account_id", "accounts", " where account_type=4");
                $this->data['accounts_count'] = sizeof($accounts);

                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));

                $this->data['account_name'] = array();
                $this->data['open_balance'] = array();

                $this->data['account_report'] = array();
                $this->data['pro_report_main'] = array();
                $count = 0;
                foreach ($accounts as $account) {
                    $open_balance = $this->web->GetBalanceforAccount($this->data['balance_to_date'], $account->account_id);
                    $this->data['account_name'][] = $open_balance[0]->account_name;
                    $this->data['open_balance'][] = $open_balance[0]->balance;

                    $this->data['account_report'][] = $this->web->GetAccountLedger($account->account_id, $this->data['from_date'], $this->data['to_date']);
                    if (!empty($this->data['account_report'][$count])) {
                        $this->data['pro_report'] = array();
                        foreach ($this->data['account_report'][$count] as $ledger) {
                            if ($ledger->invoice_ref == NULL) {
                                $x = new stdClass();
                                $this->data['pro_report'][] = $x;
                            } else {
                                $this->data['pro_report'][] = $this->web->GetAccountProductLedger($ledger->invoice_ref);
                            }
                        }
                        $this->data['pro_report_main'][] = $this->data['pro_report'];
                    }
                    $count++;
                }
            }

            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['all_accounts'] = "";
            $this->data['accounts_count'] = "";
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
            $this->data['accounts'] = $this->web->GetAll("account_id", "accounts", " where account_type=4");
        }
        $this->load->view("reports/bank_statement", $this->data);
    }



        function sale_closing_statement() {
        if ($this->input->post()) {

            $this->data['account_id'] = $this->input->post("account", true);

            if (!empty($this->data['account_id'])) {
                $this->data['all_accounts'] = "no";
                $this->data['accounts_count'] = "";

                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
//            die($this->data['from_date']);
                $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
                $open_balance = $this->web->GetBalanceforAccount($this->data['balance_to_date'], $this->data['account_id']);
                $this->data['account_name'] = $open_balance[0]->account_name;
                $this->data['open_balance'] = $open_balance[0]->balance;
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
                $this->data['account_report'] = $this->web->GetAccountLedger($this->data['account_id'], $this->data['from_date'], $this->data['to_date']);
                if (!empty($this->data['account_report'])) {
                    $this->data['pro_report'] = array();
                    foreach ($this->data['account_report'] as $ledger) {
                        if ($ledger->invoice_ref == NULL) {
                            $x = new stdClass();
                            $this->data['pro_report'][] = $x;
                        } else {
                            $this->data['pro_report'][] = $this->web->GetAccountProductLedger($ledger->invoice_ref);
                        }
                    }
                }
            } else {


                $this->data['all_accounts'] = "yes";
                $accounts = $this->web->GetAll("account_id", "accounts", " where account_type=1");
                $this->data['accounts_count'] = sizeof($accounts);

                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));

                $this->data['account_name'] = array();
                $this->data['open_balance'] = array();

                $this->data['account_report'] = array();
                $this->data['pro_report_main'] = array();
                $count = 0;
                foreach ($accounts as $account) {
                    $open_balance = $this->web->GetBalanceforAccount($this->data['balance_to_date'], $account->account_id);
                    $this->data['account_name'][] = $open_balance[0]->account_name;
                    $this->data['open_balance'][] = $open_balance[0]->balance;

                    $this->data['account_report'][] = $this->web->GetAccountLedger($account->account_id, $this->data['from_date'], $this->data['to_date']);
                    if (!empty($this->data['account_report'][$count])) {
                        $this->data['pro_report'] = array();
                        foreach ($this->data['account_report'][$count] as $ledger) {
                            if ($ledger->invoice_ref == NULL) {
                                $x = new stdClass();
                                $this->data['pro_report'][] = $x;
                            } else {
                                $this->data['pro_report'][] = $this->web->GetAccountProductLedger($ledger->invoice_ref);
                            }
                        }
                        $this->data['pro_report_main'][] = $this->data['pro_report'];
                    }
                    $count++;
                }
            }
// print_r($this->data['account_report']);
// die();
            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['all_accounts'] = "";
            $this->data['accounts_count'] = "";
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
            $this->data['accounts'] = $this->web->GetAll("account_id", "accounts", " where account_type=1");
        }
        $this->load->view("reports/sale_closing_statement", $this->data);
    }

     function purchase_closing_statement() {
        if ($this->input->post()) {

            $this->data['account_id'] = $this->input->post("account", true);

            if (!empty($this->data['account_id'])) {
                $this->data['all_accounts'] = "no";
                $this->data['accounts_count'] = "";

                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
//            die($this->data['from_date']);
                $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
                $open_balance = $this->web->GetBalanceforAccount($this->data['balance_to_date'], $this->data['account_id']);
                $this->data['account_name'] = $open_balance[0]->account_name;
                $this->data['open_balance'] = $open_balance[0]->balance;
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
                $this->data['account_report'] = $this->web->GetAccountLedger($this->data['account_id'], $this->data['from_date'], $this->data['to_date']);
                if (!empty($this->data['account_report'])) {
                    $this->data['pro_report'] = array();
                    foreach ($this->data['account_report'] as $ledger) {
                        if ($ledger->invoice_ref == NULL) {
                            $x = new stdClass();
                            $this->data['pro_report'][] = $x;
                        } else {
                            $this->data['pro_report'][] = $this->web->GetAccountProductLedger($ledger->invoice_ref);
                        }
                    }
                }
            } else {


                $this->data['all_accounts'] = "yes";
                $accounts = $this->web->GetAll("account_id", "accounts", " where account_type=2");
                $this->data['accounts_count'] = sizeof($accounts);

                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));

                $this->data['account_name'] = array();
                $this->data['open_balance'] = array();

                $this->data['account_report'] = array();
                $this->data['pro_report_main'] = array();
                $count = 0;
                foreach ($accounts as $account) {
                    $open_balance = $this->web->GetBalanceforAccount($this->data['balance_to_date'], $account->account_id);
                    $this->data['account_name'][] = $open_balance[0]->account_name;
                    $this->data['open_balance'][] = $open_balance[0]->balance;

                    $this->data['account_report'][] = $this->web->GetAccountLedger($account->account_id, $this->data['from_date'], $this->data['to_date']);
                    if (!empty($this->data['account_report'][$count])) {
                        $this->data['pro_report'] = array();
                        foreach ($this->data['account_report'][$count] as $ledger) {
                            if ($ledger->invoice_ref == NULL) {
                                $x = new stdClass();
                                $this->data['pro_report'][] = $x;
                            } else {
                                $this->data['pro_report'][] = $this->web->GetAccountProductLedger($ledger->invoice_ref);
                            }
                        }
                        $this->data['pro_report_main'][] = $this->data['pro_report'];
                    }
                    $count++;
                }
            }

            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['all_accounts'] = "";
            $this->data['accounts_count'] = "";
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
            $this->data['accounts'] = $this->web->GetAll("account_id", "accounts", " where account_type=2");
        }
        $this->load->view("reports/purchase_closing_statement", $this->data);
    }


    function general_expenses_statement() {
        if ($this->input->post()) {

            $this->data['account_id'] = $this->input->post("account", true);

            if (!empty($this->data['account_id'])) {
                $this->data['all_accounts'] = "no";
                $this->data['accounts_count'] = "";

                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
//            die($this->data['from_date']);
                $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
                $open_balance = $this->web->GetBalanceforAccount($this->data['balance_to_date'], $this->data['account_id']);
                $this->data['account_name'] = $open_balance[0]->account_name;
                $this->data['open_balance'] = $open_balance[0]->balance;
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
                $this->data['account_report'] = $this->web->GetAccountLedger($this->data['account_id'], $this->data['from_date'], $this->data['to_date']);
                if (!empty($this->data['account_report'])) {
                    $this->data['pro_report'] = array();
                    foreach ($this->data['account_report'] as $ledger) {
                        if ($ledger->invoice_ref == NULL) {
                            $x = new stdClass();
                            $this->data['pro_report'][] = $x;
                        } else {
                            $this->data['pro_report'][] = $this->web->GetAccountProductLedger($ledger->invoice_ref);
                        }
                    }
                }
            } else {


                $this->data['all_accounts'] = "yes";
                $accounts = $this->web->GetAll("account_id", "accounts", " where account_type=5");
                $this->data['accounts_count'] = sizeof($accounts);

                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));

                $this->data['account_name'] = array();
                $this->data['open_balance'] = array();

                $this->data['account_report'] = array();
                $this->data['pro_report_main'] = array();
                $count = 0;
                foreach ($accounts as $account) {
                    $open_balance = $this->web->GetBalanceforAccount($this->data['balance_to_date'], $account->account_id);
                    $this->data['account_name'][] = $open_balance[0]->account_name;
                    $this->data['open_balance'][] = $open_balance[0]->balance;

                    $this->data['account_report'][] = $this->web->GetAccountLedger($account->account_id, $this->data['from_date'], $this->data['to_date']);
                    if (!empty($this->data['account_report'][$count])) {
                        $this->data['pro_report'] = array();
                        foreach ($this->data['account_report'][$count] as $ledger) {
                            if ($ledger->invoice_ref == NULL) {
                                $x = new stdClass();
                                $this->data['pro_report'][] = $x;
                            } else {
                                $this->data['pro_report'][] = $this->web->GetAccountProductLedger($ledger->invoice_ref);
                            }
                        }
                        $this->data['pro_report_main'][] = $this->data['pro_report'];
                    }
                    $count++;
                }
            }

            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['all_accounts'] = "";
            $this->data['accounts_count'] = "";
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
            $this->data['accounts'] = $this->web->GetAll("account_id", "accounts", " where account_type=5");
        }
        $this->load->view("reports/general_expenses_statement", $this->data);
    }

    function general_statement() {
        if ($this->input->post()) {
//            print_r($_POST);
//            die();
            $this->data['today_hidden'] = $this->input->post("today_hidden", true);
            $this->data['month_hidden'] = $this->input->post("month_hidden", true);
            $this->data['week_hidden'] = $this->input->post("week_hidden", true);
            if ($this->data['today_hidden'] == 1) {
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
            }
            if ($this->data['month_hidden'] == 1) {
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(($this->data['from_date']) . "-30 days"));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
            }
            if ($this->data['week_hidden'] == 1) {
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(($this->data['from_date']) . "-6 days"));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
            }
            if ($this->data['week_hidden'] == 0 && $this->data['today_hidden'] == 0 && $this->data['month_hidden'] == 0) {
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
            }
//            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date']) . "-1 days"));
            $this->data['general_report'] = $open_balance = $this->web->GetGeneralReport($this->data['from_date'], $this->data['to_date']);
            $this->data['office_account'] = $this->web->GetOfficeAccountReport($this->data['from_date'], $this->data['to_date']);
//            print_r($this->data['office_account']);
//            die();
            foreach ($this->data['general_report'] as $g_r) {
                $account_name = $g_r->account_name;
                $ledger_type = $g_r->ledger_type;
                if ($ledger_type == 'Invoice') {
                    $type = $g_r->type;
                    if ($type == 'Sale') {
                        //$this->data['sales'][$account_name][] = $g_r->debit_amount != NULL ? $g_r->debit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%d" : $g_r->credit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%c";
                        if ($g_r->debit_amount != NULL) {
                            $this->data['sales'][$account_name][] = $g_r->debit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%d";
                        }
                    } else {
                        //$this->data['purchases'][$account_name][] = $g_r->credit_amount != NULL ? $g_r->credit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%c" : $g_r->debit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%d";
                        if ($g_r->credit_amount != NULL) {
                            $this->data['purchases'][$account_name][] = $g_r->credit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%c";
                        }
                    }
                } else {
//                    $account_name = $g_r->from_account != 0 ? $g_r->from_account : $g_r->to_account;
//                    $account_data = $this->web->GetOne("account_id", "accounts", $account_name);
//                    $account_name = $account_data[0]->account_name;
//                    $this->data['journals'][$account_name][] = $g_r->credit_amount != NULL ? $g_r->credit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%c" : $g_r->debit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%d";
                }
            }
//            print_r($this->data['journals']);
//            die();
            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
        }
        $this->load->view("reports/general_statement", $this->data);
    }

    function salary_statement() {

        if ($this->input->post()) {

            $this->data['month'] = $this->input->post('month');
            $this->data['year'] = $this->input->post('year');
            $this->data['emp_name'] = $this->input->post('emp_name');
            $this->data['salary_report'] = $this->web->GetSalaryReport($this->data['month'], $this->data['year'], $this->data['emp_name']);
            $this->data['salary_report_detail'] = $this->web->GetSalaryReportDetail();
            if (!empty($this->data['emp_name'])) {
                $employee_record = $this->web->GetAll("employee_id", "employees", " where employee_id={$this->data['emp_name']}");
                $this->data['employee_name'] = $employee_record[0]->emp_name;
            }

//            print_r($this->data['journals']);
//            die();
            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
        }
        $this->data['employees'] = $this->web->GetAll("employee_id", "employees");
        $this->load->view("reports/salary_statement", $this->data);
    }

    function Cash_memo() {
        if ($this->input->post()) {
//            print_r($_POST);
//            die();
            $this->data['today_hidden'] = $this->input->post("today_hidden", true);
            $this->data['month_hidden'] = $this->input->post("month_hidden", true);
            $this->data['week_hidden'] = $this->input->post("week_hidden", true);
            if ($this->data['today_hidden'] == 1) {
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
            }
            if ($this->data['month_hidden'] == 1) {
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(($this->data['from_date']) . "-30 days"));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
            }
            if ($this->data['week_hidden'] == 1) {
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(($this->data['from_date']) . "-6 days"));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
            }
            if ($this->data['week_hidden'] == 0 && $this->data['today_hidden'] == 0 && $this->data['month_hidden'] == 0) {
                $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
                $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));
            }
            $this->data['general_report'] = $open_balance = $this->web->GetGeneralReport_cashmemo($this->data['from_date'], $this->data['to_date']);
//            $this->data['office_account'] = $this->web->GetOfficeAccountReport($this->data['from_date'], $this->data['to_date']);
//            print_r($this->data['general_report']);
//            die();
            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
            $open_balance = $this->web->GetBalanceTotal($this->data['balance_to_date']);
            // print_r($open_balance); die();
            $this->data['opening_balance'] = $open_balance[0]->balance;
//            foreach ($this->data['general_report'] as $g_r) {
//                $account_name = $g_r->account_name;
//                $ledger_type = $g_r->ledger_type;
//                if ($ledger_type == 'Invoice') {
//                    $account_id = $g_r->account_id;
//                    $type = $g_r->type;
//                    if ($type == 'Sale') {
//                        $this->data['sales'][$account_name][] = $g_r->debit_amount != NULL ? $g_r->debit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%d" : $g_r->credit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%c";
//                    } else {
//                        $this->data['purchases'][$account_name][] = $g_r->credit_amount != NULL ? $g_r->credit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%c" : $g_r->debit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%d";
//                    }
//                } else {
//                    $account_id = $g_r->from_account != 0 ? $g_r->from_account : $g_r->to_account;
//                    $account_data = $this->web->GetOne("account_id", "accounts", $account_id);
//                    $account_name = $account_data[0]->account_name;
//                    $this->data['journals'][$account_name][] = $g_r->credit_amount != NULL ? $g_r->credit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%c" : $g_r->debit_amount . "%" . $g_r->date . "%" . $g_r->ledger_description . "%d";
//                }
//            }
//            print_r($this->data['opening_balance']);
//            die();
            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
        }
        $this->load->view("reports/cash_memo", $this->data);
    }

    function warehouse_statement() {
        if ($this->input->post()) {
            $this->data['warehouse_id'] = $this->input->post("warehouse", true);
            $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
            $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));

            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
            $this->data['get_wharehouse_pro'] = $this->web->get_wharehouse_pro($this->data['warehouse_id']);

            $counter = 0;

            foreach ($this->data['get_wharehouse_pro'] as $WP) {

                $this->data['prev_balnc'] = $this->web->GetProductsLedger($this->data['balance_to_date'], $WP ["product_id"]);
                $data[$counter] = array(
                    'product_id' => $this->data['prev_balnc'][0]->product_id,
                    'product_name' => $this->data['prev_balnc'][0]->product_name,
                    'product_balnc' => $this->data['prev_balnc'][0]->product_balnc,
                    'unit_id' => $this->data['prev_balnc'][0]->unit_id,
                    'unit_name' => $this->data['prev_balnc'][0]->unit_name,
                    'unit_symbol' => $this->data['prev_balnc'][0]->unit_symbol
                );
                $this->data['prev_balnc'] = $data;
                $counter ++;
            }

            $this->data['warhous'] = $this->data['get_wharehouse_pro'][0]["warehouse_name"];
            $this->data['products_report'] = $this->web->GetReportforProducts($this->data['from_date'], $this->data['to_date'], $this->data['warehouse_id']);

            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
            $this->data['warehouses'] = $this->web->GetAll("warehouse_id", "warehouses");
            $this->data['warhous'] = NULL;
        }

        $this->load->view("reports/warehouse_statement", $this->data);
    }

    function warehouse_general_statement() {
        if ($this->input->post()) {
            $this->data['warehouse_id'] = $this->input->post("warehouse", true);
            $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
            $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));

            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
            $this->data['get_wharehouse_pro'] = $this->web->get_wharehouse_pro($this->data['warehouse_id']);
            $this->data['products_report'] = array();
            $counter = 0;
            $this->data['product_avg_price'] = array();
            foreach ($this->data['get_wharehouse_pro'] as $WP) {

                $this->data['prev_balnc'] = $this->web->GetProductsLedger($this->data['balance_to_date'], $WP ["product_id"]);
                // $products_rate = $this->web->GetRate($this->data['from_date'], $this->data['to_date'], $WP ["product_id"]);
                $products_report = $this->web->GetReportforProducts_general($this->data['from_date'], $this->data['to_date'], $WP ["product_id"]);
                $counter_inner = 1;
                $total_avg = 0.00;
                // foreach ($products_rate as  $value) {
                //     $total_avg+=$value->purchase_price!=NULL?$value->purchase_price:$value->sale_price;
                //     $pro_id=$value->product_id;
                //     $counter_inner++;
                // }
                // $avg_rate=$total_avg/$counter_inner;


                $data[$counter] = array(
                    'product_id' => $this->data['prev_balnc'][0]->product_id,
                    'product_name' => $this->data['prev_balnc'][0]->product_name,
                    'product_balnc' => $this->data['prev_balnc'][0]->product_balnc,
                    'unit_id' => $this->data['prev_balnc'][0]->unit_id,
                    'unit_name' => $this->data['prev_balnc'][0]->unit_name,
                    'unit_symbol' => $this->data['prev_balnc'][0]->unit_symbol
                );
                $this->data['prev_balnc'] = $data;
                $this->data['products_report'][] = $products_report;
                // $this->data['product_avg_price'][$pro_id]=$avg_rate;
                $counter ++;
            }

            $this->data['warhous'] = $this->data['get_wharehouse_pro'][0]["warehouse_name"];

            // echo "<pre>";
            // print_r($this->data['product_avg_price']);
            // echo "</pre>";
            // die();
            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
            $this->data['warehouses'] = $this->web->GetAllWarehouse("warehouse_id", "warehouses");
            $this->data['warhous'] = NULL;
        }

        $this->load->view("reports/warehouse_general_statement", $this->data);
    }

    function finalgood_general_statement() {
        if ($this->input->post()) {
            $this->data['warehouse_id'] = $this->input->post("warehouse", true);
            $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
            $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));

            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
            $this->data['get_wharehouse_pro'] = $this->web->get_wharehouse_pro($this->data['warehouse_id']);
            $this->data['products_report'] = array();
            $counter = 0;

            foreach ($this->data['get_wharehouse_pro'] as $WP) {

                $this->data['prev_balnc'] = $this->web->GetReportforFinal($this->data['balance_to_date'], $WP ["product_id"]);
                $products_report = $this->web->GetReportforFinal_general($this->data['from_date'], $this->data['to_date'], $WP ["product_id"]);

                $data[$counter] = array(
                    'product_id' => $this->data['prev_balnc'][0]->product_id,
                    'product_name' => $this->data['prev_balnc'][0]->product_name,
                    'product_balnc' => $this->data['prev_balnc'][0]->product_balnc,
                    'unit_id' => $this->data['prev_balnc'][0]->unit_id,
                    'unit_name' => $this->data['prev_balnc'][0]->unit_name,
                    'unit_symbol' => $this->data['prev_balnc'][0]->unit_symbol
                );
                $this->data['prev_balnc'] = $data;
                $this->data['products_report'][] = $products_report;
                $counter ++;
            }

            $this->data['warhous'] = $this->data['get_wharehouse_pro'][0]["warehouse_name"];

//            echo "<pre>";
//            print_r($this->data['products_report']);
//            echo "</pre>";
//            die();
            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;

            $this->data['warehouses'] = $this->web->GetOneWarehouse("warehouse_id", "warehouses");
            $this->data['warhous'] = NULL;
        }

        $this->load->view("reports/finalgood_general_statement", $this->data);
    }

    function product_statement() {
        if ($this->input->post()) {
            $this->data['product_id'] = $this->input->post("product", true);
//            echo date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("from_date", true))));
//            die;

            $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
            $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));

            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
//            echo $this->data['balance_to_date'];
//            die();
            $this->data['prev_balnc'] = $this->web->GetProductsLedger($this->data['balance_to_date'], $this->data['product_id']);
            // print_r($this->data['prev_balnc']);
            // die;
            $this->data['products_report'] = $this->web->GetReportforProducts($this->data['from_date'], $this->data['to_date'], $this->data['product_id']);
            // print_r($this->data['products_report']);
            // die();
            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
            $this->data['products'] = $this->web->GetAll("product_id", "products", " WHERE products.type = 'raw'");
        }




        $this->load->view("reports/product_statement", $this->data);
    }

    function process_statement() {
        if ($this->input->post()) {
            $this->data['product_id'] = $this->input->post("product", true);
//            echo date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("from_date", true))));
//            die;

            $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
            $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));


            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
//            echo $this->data['balance_to_date'];
//            die();
            $this->data['prev_balnc'] = $this->web->GetProcessLedger($this->data['balance_to_date'], $this->data['product_id']);
            // print_r($this->data['prev_balnc']);
            // die;


            $this->data['products_report'] = $this->web->GetReportforProcess($this->data['from_date'], $this->data['to_date'], $this->data['product_id']);
            // print_r($this->data['products_report']);
            // die();


            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
            $this->data['products'] = $this->web->GetAll("product_id", "products", " WHERE products.type = 'process'");
        }





        $this->load->view("reports/process_statement", $this->data);
    }

    function final_statement() {
        if ($this->input->post()) {
            $this->data['product_id'] = $this->input->post("product", true);
//            echo date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("from_date", true))));
//            die;

            $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
            $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));


            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
//            echo $this->data['balance_to_date'];
//            die();
            $this->data['prev_balnc'] = $this->web->GetFinalProductsLedger($this->data['balance_to_date'], $this->data['product_id']);
            // print_r($this->data['prev_balnc']);
            //die;

            $this->data['products_report'] = $this->web->GetReportforFinalProducts($this->data['from_date'], $this->data['to_date'], $this->data['product_id']);
            // print_r($this->data['products_report']);
            // die();


            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
        }
        $this->data['products'] = $this->web->GetAll("product_id", "products", " WHERE products.type = 'production'");
        $this->load->view("reports/final_statement", $this->data);
    }

    function sale_statement() {
        if ($this->input->post()) {
            $this->data['product_id'] = $this->input->post("product", true);
            $this->data['account_id'] = $this->input->post("account", true);

            $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
            $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));


            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
//
//            $this->data['prev_balnc'] = $this->web->GetSaleProductsLedger($this->data['balance_to_date'], $this->data['product_id'], $this->data['account_id']);


            $this->data['products_report'] = $this->web->GetReportforSaleProducts($this->data['from_date'], $this->data['to_date'], $this->data['product_id'], $this->data['account_id']);
//            print_r($this->data['products_report']);
//            die();


            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
        }
        $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
        $this->data['products'] = $this->web->GetAll("product_id", "products");
        $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");
        $this->load->view("reports/sale_statement", $this->data);
    }

    function purchase_statement() {
        if ($this->input->post()) {
            $this->data['product_id'] = $this->input->post("product", true);
            $this->data['account_id'] = $this->input->post("account", true);

            $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
            $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));


            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
//
//            $this->data['prev_balnc'] = $this->web->GetSaleProductsLedger($this->data['balance_to_date'], $this->data['product_id'], $this->data['account_id']);


            $this->data['products_report'] = $this->web->GetReportforPurchaseProducts($this->data['from_date'], $this->data['to_date'], $this->data['product_id'], $this->data['account_id']);
//            print_r($this->data['products_report']);
//            die();


            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
        }
        $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
        $this->data['products'] = $this->web->GetAll("product_id", "products", " WHERE products.type = 'raw'");
        $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");
        $this->load->view("reports/purchase_statement", $this->data);
    }

    function section_statement() {
        if ($this->input->post()) {
            $this->data['section_id'] = $this->input->post("section", true);
//            echo date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("from_date", true))));
//            die;
            $this->data['from_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("from_date", true)) . " 00:00:00"));
            $this->data['to_date'] = date("Y-m-d H:i:s", strtotime(str_replace("-", "/", $this->input->post("to_date", true)) . " 23:59:59"));

//            die($this->data['from_date']);
            $this->data['balance_to_date'] = date('Y-m-d H:i:s', strtotime(($this->data['from_date'])));
            $this->data['prev_balnc'] = $this->web->GetSectionsProductsLedger($this->data['balance_to_date'], $this->data['section_id']);
//            print_r($this->data['prev_balnc']);
//
//              die;
            if (empty($this->data['prev_balnc'])) {
                $this->data['secn'] = NULL;
            } else {
                $this->data['secn'] = $this->data['prev_balnc'][0]->section_name;
            }
            $this->data['products_report'] = $this->web->GetReportforSection($this->data['from_date'], $this->data['to_date'], $this->data['section_id']);
//            print_r($this->data['products_report']);
//            die();


            $this->data['modal'] = FALSE;
        } else {
            $this->data['modal'] = TRUE;
            $this->data['account_report'] = $this->data['account_name'] = $this->data['open_balance'] = NULL;
            $this->data['sections'] = $this->web->GetAll("section_id", "sections");
            $this->data['secn'] = NULL;
        }
        $this->load->view("reports/section_statement", $this->data);
    }

}
