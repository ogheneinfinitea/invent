<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        if (isset($_POST['filter'])) {
            $date_from = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("from_date", true))));
            $date_to = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("to_date", true))));

            $this->data['processes'] = $this->web->GetAllWithInner("issue_id", "issue", "sections", "section_id", NULL, NULL, " WHERE issue.production IS NULL AND issue.warehouse_id IS NULL  AND  (DATE(issue.date) between {$date_from} and {$date_to})");
            $this->load->view("process/all", $this->data);
        } else {
            $this->data['processes'] = $this->web->GetAllWithInner("issue_id", "issue", "sections", "section_id", NULL, NULL, " WHERE issue.production IS NULL AND issue.warehouse_id IS NULL");
//        print_r($this->data['issues']);
//        die();
            $this->load->view("process/all", $this->data);
        }
    }

    public function GetTotalIssue() {
        $product_id = $this->input->post("product_id");
        $instock = GetTotalIssueProcess($product_id);
        print_r(json_encode($instock));
    }

    function view() {
        $issue_id = $this->uri->segment(3);
        $this->data['issue'] = $this->web->GetOne('issue_id', 'issue', $issue_id);
        $this->data['pro_items'] = $this->web->GetOne('issue_id', 'product_ledger', $issue_id, " AND debit_qty IS NULL");
        $this->data['raw_items'] = $this->web->GetOne('issue_id', 'product_ledger', $issue_id, " AND credit_qty IS NULL");
        $this->data['raw_items_old'] = $this->web->GetOldRaw($issue_id);


//this is process suggestions
        $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id", " where products.type='raw'");
        $this->data['products_suggestions'] = "<option value=''>Select or Type Product</option>";
        foreach ($this->data['products'] as $product) {
            $this->data['product_suggestions'][$product->product_category_name][] = $product;
//                $this->data['products_suggestions'] .= "'" . $product->product_id . " - " . $product->product_name . "',";
        }
        foreach ($this->data['product_suggestions'] as $key => $value) {
            $this->data['products_suggestions'] .= "<optgroup label='" . $key . "'>";
//                echo $key . "<br>";
            foreach ($this->data['product_suggestions'][$key] as $value) {
                $this->data['products_suggestions'] .= "<option unit_symbol='" . $value->unit_symbol . "' value='" . $value->product_id . "'>" . $value->product_name . "</option>";
            }
            $this->data['products_suggestions'] .= "</optgroup>";
        }
        //this is production suggestions
        //this is raw product suggestions
        $qu = "SELECT * FROM products INNER JOIN product_ledger ON products.product_id = product_ledger.product_id
            INNER JOIN product_categories ON products.product_category_id = product_categories.product_category_id INNER JOIN units ON
            products.unit_id = units.unit_id WHERE products.type = 'raw' and product_ledger.type='SECTION'";
        $qu .= "group by product_ledger.product_id";
        $res = $this->db->query($qu);
        $res = $res->result();
        $this->data['products_raw'] = $res;
        $this->data['products_suggestions_raw'] = "<option value=''>Select or Type Product</option>";
        foreach ($this->data['products_raw'] as $product_raw) {
            $this->data['product_suggestions_raw'][$product->product_category_name][] = $product_raw;
//                $this->data['products_suggestions'] .= "'" . $product->product_id . " - " . $product->product_name . "',";
        }
        foreach ($this->data['product_suggestions_raw'] as $key => $value) {
            $this->data['products_suggestions_raw'] .= "<optgroup label='" . $key . "'>";
//                echo $key . "<br>";
            foreach ($this->data['product_suggestions_raw'][$key] as $value) {
                $this->data['products_suggestions_raw'] .= "<option unit_symbol='" . $value->unit_symbol . "' value='" . $value->product_id . "'>" . $value->product_name . "</option>";
            }
            $this->data['products_suggestions_raw'] .= "</optgroup>";
        }
        //this is raw product suggestions
        $this->data['warehouses'] = $this->web->GetAll("warehouse_id", "warehouses");
        $this->data['sections'] = $this->web->GetAll("section_id", "sections");

        $this->load->view("process/edit", $this->data);
    }


    function view_slip() {
        $issue_id = $this->uri->segment(3);
        $this->data['issue'] = $this->web->GetOne('issue_id', 'issue', $issue_id);
        $this->data['pro_items'] = $this->web->GetOne('issue_id', 'product_ledger', $issue_id, " AND debit_qty IS NULL");

        $this->data['raw_items'] = $this->web->GetOne('issue_id', 'product_ledger', $issue_id, " AND credit_qty IS NULL");
        $this->data['raw_items_old'] = $this->web->GetOldRaw($issue_id);

        $this->load->view("process/view_slip", $this->data);
    }

    function print_slip() {
        $issue_id = $this->uri->segment(3);
        $this->data['issue'] = $this->web->GetOne('issue_id', 'issue', $issue_id);
        $this->data['pro_items'] = $this->web->GetOne('issue_id', 'product_ledger', $issue_id, " AND debit_qty IS NULL");
        $this->data['raw_items'] = $this->web->GetOne('issue_id', 'product_ledger', $issue_id, " AND credit_qty IS NULL");
        $this->data['raw_items_old'] = $this->web->GetOldRaw($issue_id);
        $this->load->view("process/print_slip", $this->data);
    }



    function edit() {
        $data = array();
        $data_items = array();
        $data['issue_id'] = $this->db->escape_str($this->input->post("issue_id", true));
        $data['date'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date", true)))) . " " . date("H:i:s");
        $data_items['product_id'] = $this->input->post("product_name", true);
        $data_items['qty'] = $this->input->post("qty", true);
        $data_items['product_id_raw'] = $this->input->post("product_name_raw", true);
        $data_items['qty_raw'] = $this->input->post("qty_raw", true);
//            $type = "Added";
        $data['section_id'] = $this->db->escape_str($this->input->post("section", true));

        $data['description'] = htmlentities($this->input->post("desc", true));

        if ($this->web->Update("issue_id", "issue", $data['issue_id'], $data)) {
            $before_items = $this->web->GetAll('issue_id', 'product_ledger', " where issue_id={$data['issue_id']}");
            $this->web->Delete("issue_id", "product_ledger", $data['issue_id']);
//            $issue = $this->web->GetLastInsertedRow("issue_id", "issue");
            $product_count_raw = sizeof($data_items['product_id_raw']);
            $product_count = sizeof($data_items['product_id']);
            $insert_items_debit = "INSERT INTO product_ledger (issue_id, product_id, debit_qty, type, description ,ref_id, date_ledger) VALUES ";
            for ($i = 0; $i < $product_count_raw; $i++) {
                $insert_items_debit .= "('" . $data['issue_id'] . "','" . $data_items['product_id_raw'][$i] . "','" . $data_items['qty_raw'][$i] . "','SECTION','" . 'PROCESS-' . $data['description'] . "','" . $data['section_id'] . "','" . $data['date'] . "'),";
                // $update_stock = "update products set instock=(instock-{$before_items[$i]->debit_qty})-{$data_items['qty_raw'][$i]} where product_id={$data_items['product_id_raw'][$i]}";
                // $this->db->query($update_stock);
            }
            $insert_items_credit = "INSERT INTO product_ledger (issue_id, product_id, credit_qty, type, description ,ref_id, date_ledger) VALUES ";
            for ($j = 0; $j < $product_count; $j++) {
                $insert_items_credit .= "('" . $data['issue_id'] . "','" . $data_items['product_id'][$j] . "','" . $data_items['qty'][$j] . "','SECTION','" . 'PROCESS-' . $data['description'] . "','1','" . $data['date'] . "'),";
            }
            $insert_items_debit = rtrim($insert_items_debit, ",");
            $insert_items_credit = rtrim($insert_items_credit, ",");
//                echo $insert_items_credit . "<br>";
//                echo $insert_items_debit;
            if (($this->db->query($insert_items_debit)) && ($this->db->query($insert_items_credit))) {
                redirect("process", "refresh");
            }
        }
    }

    function delete() {
        $issue_id = $this->input->post("id", true);
        // if ($this->web->Delete("issue_id", "issue", $issue_id)) {
        //     $this->web->Delete("issue_id", "product_ledger", $issue_id);
        //     echo "done";
        // }


        if ($this->web->Delete("issue_id", "issue", $issue_id)) {
            $before_items = $this->web->GetAll('product_ledger_id', 'product_ledger', " where issue_id={$issue_id} and type='SECTION' and credit_qty!=NULL");

            foreach ($before_items as $b_f) {
                $qty = $b_f->credit_qty;
                $update_stock = "update products set instock=(instock-{$qty}) where product_id={$b_f->product_id}";

                $this->db->query($update_stock);
            }
            $this->web->Delete("issue_id", "product_ledger", $issue_id);
            echo "done";
        }
    }

    public function GetProductsWithSection() {
        $section_id = $this->input->post("section_id");
        $options = GetProductsWithSection($section_id);
        echo $options;
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data_items = array();
            $data['date'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date", true)))) . " " . date("H:i:s");
            $data_items['product_id'] = $this->input->post("product_name", true);
            $data_items['qty'] = $this->input->post("qty", true);
            $data_items['product_id_raw'] = $this->input->post("product_name_raw", true);
            $data_items['qty_raw'] = $this->input->post("qty_raw", true);
//            $type = "Added";
            $data['section_id'] = $this->db->escape_str($this->input->post("section", true));
            $data['description'] = htmlentities($this->input->post("desc", true));
            $update_stock = "";
            if ($this->web->Add("issue", $data)) {
                $issue = $this->web->GetLastInsertedRow("issue_id", "issue");
                $product_count_raw = sizeof($data_items['product_id_raw']);
                $product_count = sizeof($data_items['product_id']);
                $insert_items_debit = "INSERT INTO product_ledger (issue_id, product_id, debit_qty, type, description ,ref_id, date_ledger) VALUES ";
                for ($i = 0; $i < $product_count_raw; $i++) {
                    $insert_items_debit .= "('" . $issue[0]->issue_id . "','" . $data_items['product_id_raw'][$i] . "','" . $data_items['qty_raw'][$i] . "','SECTION','" . 'PROCESS-' . $data['description'] . "','" . $data['section_id'] . "','" . $data['date'] . "'),";
                }
                $insert_items_credit = "INSERT INTO product_ledger (issue_id, product_id, credit_qty, type, description ,ref_id, date_ledger) VALUES ";
                for ($j = 0; $j < $product_count; $j++) {
                    $insert_items_credit .= "('" . $issue[0]->issue_id . "','" . $data_items['product_id'][$j] . "','" . $data_items['qty'][$j] . "','SECTION','" . 'PROCESS-' . $data['description'] . "','1','" . $data['date'] . "'),";

                    $update_stock = "update products set instock=instock+{$data_items['qty'][$j]} where product_id={$data_items['product_id'][$j]}";
                    $this->db->query($update_stock);
                }
                //print_r($insert_items_credit);
//                print_r($update_stock);
//                die();

                $insert_items_debit = rtrim($insert_items_debit, ",");
                $insert_items_credit = rtrim($insert_items_credit, ",");
//                echo $insert_items_credit . "<br>";
//                echo $insert_items_debit;
                if (($this->db->query($insert_items_debit)) && ($this->db->query($insert_items_credit))) {
                    redirect("process", "refresh");
                }
            }
        } else {
            //this is production suggestions
            $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id", " where products.type='raw'");
            $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id", " where products.type='raw'");
            $this->data['products_suggestions'] = "<option value=''>Select or Type Product</option>";
            if ($this->data['products']) {
                foreach ($this->data['products'] as $product) {
                    $product_suggestions[$product->product_category_name][] = $product;
                }
                foreach ($product_suggestions as $key => $value) {
                    $this->data['products_suggestions'] .= "<optgroup label='" . $key . "'>";
                    foreach ($product_suggestions[$key] as $value) {
                        $this->data['products_suggestions'] .= "<option unit_symbol='" . $value->unit_symbol . "' value='" . $value->product_id . "'>" . $value->product_name . "</option>";
                    }
                    $this->data['products_suggestions'] .= "</optgroup>";
                }
            }
            //this is production suggestions
            //this is raw product suggestions
            $qu = "SELECT * FROM products INNER JOIN product_ledger ON products.product_id = product_ledger.product_id
            INNER JOIN product_categories ON products.product_category_id = product_categories.product_category_id INNER JOIN units ON
            products.unit_id = units.unit_id WHERE products.type = 'raw' and product_ledger.type='SECTION'";
            $qu .= "group by product_ledger.product_id";
            $res = $this->db->query($qu);
            $res = $res->result();
            $this->data['products_raw'] = $res;

            $this->data['products_suggestions_raw'] = "<option value=''>Select or Type Raw Material</option>";
            if ($this->data['products_raw']) {
                foreach ($this->data['products_raw'] as $product_raw) {
                    $product_suggestions_raw[$product_raw->product_category_name][] = $product_raw;
                }
                foreach ($product_suggestions_raw as $key => $value) {
                    $this->data['products_suggestions_raw'] .= "<optgroup label='" . $key . "'>";
                    foreach ($product_suggestions_raw[$key] as $value) {
                        $this->data['products_suggestions_raw'] .= "<option unit_symbol='" . $value->unit_symbol . "' value='" . $value->product_id . "'>" . $value->product_name . "</option>";
                    }
                    $this->data['products_suggestions_raw'] .= "</optgroup>";
                }
            }
            //this is raw product suggestions
            $this->data['sections'] = $this->web->GetAll("section_id", "sections");
            $this->load->view("process/add", $this->data);
        }
    }

}
