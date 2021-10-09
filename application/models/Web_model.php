<?php

class Web_model extends MY_Model {

    function filter_products($category_id, $warehouse_id, $prod_type, $limit = NULL, $search = NULL) {
        $query = "SELECT * FROM products INNER JOIN product_categories p_c on p_c.product_category_id=products.product_category_id INNER JOIN units ON products.unit_id = units.unit_id INNER JOIN warehouses ON warehouses.warehouse_id= products.warehouse_id where 1=1  ";

        if ($warehouse_id != NULL) {
            $query .= "  AND products.warehouse_id=$warehouse_id";
        }
        if ($category_id != NULL) {
            $query .= " AND  products.product_category_id=$category_id";
        }
        if ($prod_type != NULL) {
            $query .= " AND products.type = '$prod_type'";
        }
        if ($search != NULL) {
            $query .= " AND products.product_id LIKE '%{$search}%' OR products.product_name LIKE '%{$search}%' OR products.instock LIKE '%{$search}%' OR units.unit_symbol LIKE '%{$search}%' ";
        }
        if ($limit != NULL) {
            $query .= " limit $limit";
        }


//        die($query);
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function GetAllPurchases($limit = NULL) {
        $query = "SELECT invoice.*,invoice.date_created as invoice_date,accounts.* FROM invoice INNER JOIN accounts ON accounts.account_id = invoice.account_id WHERE type='Purchase' ORDER BY invoice_id DESC";
        if ($limit != NULL) {
            $query .= " limit $limit";
        }
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function GetAllAdjustment() {
        $query = "SELECT l.*,a.*,l.date as ledger_date from ledger l inner join accounts a on l.account_id=a.account_id where l.type='adjustment'";

        $query = $this->db->query($query);
        return $query->result();
    }

    function GetAllProductAdjustment() {
        $query = "SELECT pl.*,p.*,pl.date_ledger as date_ledger from product_ledger pl inner join products p on pl.product_id=p.product_id where pl.type='WAREHOUSE' AND pl.description LIKE '%adjustment%'";
        // die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

    function GetAllPurchases_filter($date_from, $date_to, $category, $product, $prod_type, $limit = NULL, $search = NULL) {
        // print_r($prod_type);die();
        $query = "SELECT invoice.*,invoice_items.*,invoice.date_created as invoice_date,accounts.* FROM invoice INNER JOIN invoice_items ON invoice_items.invoice_id = invoice.invoice_id INNER JOIN products ON invoice_items.product_id = products.product_id  INNER JOIN accounts ON accounts.account_id = invoice.account_id WHERE invoice.type='Purchase' ";
        if (!empty($date_from) && !empty($date_to)) {
            $query .= " and (DATE(invoice.date_created) between '$date_from' and '$date_to') ";
        }

        if (!empty($prod_type)) {
            $query .= " AND products.type = '$prod_type'";
        }
        if (!empty($category)) {
            $query .= " AND  products.product_category_id=$category";
        }
        if (!empty($product)) {
            $query .= "  AND products.product_id=$product ";
        }
        if (!empty($search)) {
            $query .= " AND (invoice.invoice_id LIKE '%{$search}%' OR invoice.date_created LIKE '%{$search}%' OR accounts.account_name LIKE '%{$search}%' OR invoice.payment_method LIKE '%{$search}%' )";
        }

        $query .= " GROUP BY invoice.invoice_id ";
        $query .= " ORDER BY invoice.invoice_id DESC ";
        if ($limit != NULL) {
            $query .= " limit $limit";
        }
//        die($query);
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function GetAllSales($limit = NULL) {
        $query = "SELECT invoice.*,invoice.date_created as invoice_date,accounts.* FROM invoice INNER JOIN accounts ON accounts.account_id = invoice.account_id WHERE type='sale' ORDER BY invoice_id DESC";
        if ($limit != NULL) {
            $query .= " limit $limit";
        }
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function GetAllSales_filter($date_from, $date_to, $category, $product, $prod_type, $limit = NULL, $search = NULL) {
        $query = "SELECT invoice.*,invoice_items.*,invoice.date_created as invoice_date,accounts.* FROM invoice INNER JOIN invoice_items ON invoice_items.invoice_id = invoice.invoice_id INNER JOIN products ON invoice_items.product_id = products.product_id  INNER JOIN accounts ON accounts.account_id = invoice.account_id WHERE invoice.type='Sale'  ";
        if (!empty($date_from) && !empty($date_to)) {
            $query .= " and (DATE(invoice.date_created) between '$date_from' and '$date_to') ";
        }
        if ($prod_type != NULL) {
            $query .= " AND products.type = '$prod_type'";
        }
        if ($category != NULL) {
            $query .= " AND  products.product_category_id=$category";
        }
        if ($product != NULL) {
            $query .= "  AND products.product_id=$product ";
        }
        if (!empty($search)) {
            $query .= " AND (invoice.invoice_id LIKE '%{$search}%' OR invoice.date_created LIKE '%{$search}%' OR accounts.account_name LIKE '%{$search}%' OR invoice.payment_method LIKE '%{$search}%' )";
        }


        $query .= " GROUP BY invoice.invoice_id ";
        $query .= " ORDER BY invoice.invoice_id DESC ";
        if ($limit != NULL) {
            $query .= " limit $limit";
        }
//        die($query);
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function GetAllSalesOrder($limit = NULL) {
        $query = "SELECT ordr.*,ordr.date_created as ordr_date,accounts.* FROM ordr INNER JOIN accounts ON accounts.account_id = ordr.account_id WHERE type='sale' ORDER BY ordr_id DESC";
        if ($limit != NULL) {
            $query .= " limit $limit";
        }
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function GetAllSalesOrder_filter($date_from, $date_to, $category, $product, $prod_type, $limit = NULL, $search = NULL) {
        $query = "SELECT ordr.*,ordr_items.*,ordr.date_created as ordr_date,accounts.* FROM ordr INNER JOIN ordr_items ON ordr_items.ordr_id = ordr.ordr_id INNER JOIN products ON ordr_items.product_id = products.product_id  INNER JOIN accounts ON accounts.account_id = ordr.account_id WHERE ordr.type='Sale'  ";
        if (!empty($date_from) && !empty($date_to)) {
            $query .= " and (DATE(ordr.date_created) between '$date_from' and '$date_to') ";
        }
        if ($prod_type != NULL) {
            $query .= " AND products.type = '$prod_type'";
        }
        if ($category != NULL) {
            $query .= " AND  products.product_category_id=$category";
        }
        if ($product != NULL) {
            $query .= "  AND products.product_id=$product ";
        }
        if (!empty($search)) {
            $query .= " AND (ordr.ordr_id LIKE '%{$search}%' OR ordr.date_created LIKE '%{$search}%' OR accounts.account_name LIKE '%{$search}%'  )";
        }


        $query .= " GROUP BY ordr.ordr_id ";
        $query .= " ORDER BY ordr.ordr_id DESC ";
        if ($limit != NULL) {
            $query .= " limit $limit";
        }
//        die($query);
        $query = $this->db->query($query);
        return $query->result_array();
    }

//Zohaib//


    function GetAllPurchaseOrder($limit = NULL) {
        $query = "SELECT ordr.*,ordr.date_created as ordr_date,accounts.* FROM ordr INNER JOIN accounts ON accounts.account_id = ordr.account_id WHERE type='Purchase' ORDER BY ordr_id DESC";
        if ($limit != NULL) {
            $query .= " limit $limit";
        }
        // die($query);
        $query = $this->db->query($query);

        return $query->result_array();
    }

    function GetAllPurchaseOrder_filter($date_from, $date_to, $category, $product, $prod_type, $limit = NULL, $search = NULL) {
        $query = "SELECT ordr.*,ordr_items.*,ordr.date_created as ordr_date,accounts.* FROM ordr INNER JOIN ordr_items ON ordr_items.ordr_id = ordr.ordr_id INNER JOIN products ON ordr_items.product_id = products.product_id  INNER JOIN accounts ON accounts.account_id = ordr.account_id WHERE ordr.type='Purchase'  ";
        if (!empty($date_from) && !empty($date_to)) {
            $query .= " and (DATE(ordr.date_created) between '$date_from' and '$date_to') ";
        }
        if ($prod_type != NULL) {
            $query .= " AND products.type = '$prod_type'";
        }
        if ($category != NULL) {
            $query .= " AND  products.product_category_id=$category";
        }
        if ($product != NULL) {
            $query .= "  AND products.product_id=$product ";
        }
        if (!empty($search)) {
            $query .= " AND (ordr.ordr_id LIKE '%{$search}%' OR ordr.date_created LIKE '%{$search}%' OR accounts.account_name LIKE '%{$search}%'  )";
        }


        $query .= " GROUP BY ordr.ordr_id ";
        $query .= " ORDER BY ordr.ordr_id DESC ";
        if ($limit != NULL) {
            $query .= " limit $limit";
        }
//        die($query);
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function GetTotalPurchaseOrder() {
        $query = "SELECT SUM(ordr.ordr_total) as total_balnc FROM ordr INNER JOIN accounts ON accounts.account_id = ordr.account_id WHERE type='Sale' ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetAllWarehouse() {
        $query = "SELECT * FROM warehouses where warehouse_id != 6 and warehouse_id != 9 ";
        // die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetOneWarehouse() {
        $query = "SELECT * FROM warehouses where warehouse_id = 6";
        // die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetTotalPurchaseOrder_filter($date_from, $date_to, $category, $product, $prod_type, $search = NULL) {
        // print_r($prod_type);die();
        $query = "SELECT ordr.ordr_total as total_balnc FROM ordr INNER JOIN ordr_items ON ordr_items.ordr_id = ordr.ordr_id INNER JOIN products ON ordr_items.product_id = products.product_id  INNER JOIN accounts ON accounts.account_id = ordr.account_id WHERE ordr.type='Purchase' ";
        if (!empty($date_from) && !empty($date_to)) {
            $query .= " and (DATE(ordr.date_created) between '$date_from' and '$date_to') ";
        }

        if (!empty($prod_type)) {
            $query .= " AND products.type = '$prod_type'";
        }
        if (!empty($category)) {
            $query .= " AND  products.product_category_id=$category";
        }
        if (!empty($product)) {
            $query .= "  AND products.product_id=$product ";
        }
        if (!empty($search)) {
            $query .= " AND (ordr.ordr_id LIKE '%{$search}%' OR ordr.date_created LIKE '%{$search}%' OR accounts.account_name LIKE '%{$search}%'  )";
        }

        $query .= " GROUP BY ordr.ordr_id ";
        $query .= " ORDER BY ordr.ordr_id DESC ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

//Zohaib
    function GetAllJournals($search = NULL, $limit = NULL) {
        $query = "SELECT j.*, a1.account_name as from_account, a2.account_name as to_account From journals j LEFT JOIN accounts a1 ON a1.account_id = j.from_account LEFT JOIN accounts a2 ON a2.account_id = j.to_account";
        if ($search != NULL && $search != "") {
            $query .= " WHERE a1.account_name LIKE '%$search%' OR a2.account_name LIKE '%$search%' OR j.journal_id LIKE '%$search%' OR j.date LIKE '%$search%' OR j.description LIKE '%$search%' OR j.amount LIKE '%$search%' ";
        }
        $query .= " ORDER BY j.journal_id DESC";
        if ($limit != NULL) {
            $query .= " limit $limit";
        }
        // die($query);
        $query = $this->db->query($query);

        return $query->result_array();
    }

    function GetAllJournals_filter($date_from, $date_to, $search = NULL, $limit = NULL) {
        $query = "SELECT j.*, a1.account_name as from_account, a2.account_name as to_account From journals j LEFT JOIN accounts a1 ON a1.account_id = j.from_account LEFT JOIN accounts a2 ON a2.account_id = j.to_account";
        $where = "";
        if (!empty($date_from) || !empty($date_to) || (!empty($search))) {
            $where .= " where ";
        }
        if (!empty($date_from) && !empty($date_to) && (!empty($search))) {
            $query .= $where . "(DATE(j.date) between '{$date_from}' and '{$date_to}')  ";
            $query .= $query .= "AND   from_account LIKE '%$search%' OR to_account LIKE '%$search%' OR j.journal_id LIKE '%$search%' OR j.date LIKE '%$search%' OR j.description LIKE '%$search%' OR j.amount LIKE '%$search%' ";
        } elseif (!empty($date_from) && !empty($date_to)) {
            $query .= $where . "(DATE(j.date) between '{$date_from}' and '{$date_to}')  ";
        } elseif (!empty($search)) {
            $query .= $where . "  from_account LIKE '%$search%' OR to_account LIKE '%$search%' OR j.journal_id LIKE '%$search%' OR j.date LIKE '%$search%' OR j.description LIKE '%$search%' OR j.amount LIKE '%$search%' ";
        }

        $query .= " ORDER BY j.journal_id DESC";
        if ($limit != NULL) {
            $query .= " limit $limit";
        }
//        die($query);
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function GetInvoiceItems($invoice_id) {
        $query = "SELECT invoice_items.*,products.product_name,units.unit_symbol as unit FROM invoice_items INNER JOIN products ON products.product_id = invoice_items.product_id INNER JOIN units ON units.unit_id = products.unit_id WHERE invoice_items.invoice_id = '" . $invoice_id . "' ORDER BY invoice_items.invoice_item_id ASC";
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetordrItems($invoice_id) {
        $query = "SELECT ordr_items.*,products.product_name,units.unit_symbol as unit FROM ordr_items INNER JOIN products ON products.product_id = ordr_items.product_id INNER JOIN units ON units.unit_id = products.unit_id WHERE ordr_items.ordr_id = '" . $invoice_id . "' ORDER BY ordr_items.ordr_item_id DESC";
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetAccountLedger($account_id, $from_date, $to_date) {
        //$query = "SELECT l.*,a.account_name,a.opening_balance,a.account_number,a.date as acc_open_date FROM ledger l INNER JOIN accounts a ON a.account_id = l.account_id  WHERE l.date BETWEEN '" . $from_date . "' AND '" . $to_date . "' AND (l.account_id = '" . $account_id . "') ORDER BY l.date ASC";
        $query = "SELECT l.*,a.account_name,a.opening_balance,a.account_number,a.date as acc_open_date FROM ledger l LEFT JOIN journals j on l.journal_ref=j.journal_id AND l.type='Journal' LEFT JOIN accounts a ON a.account_id = l.account_id WHERE l.date BETWEEN '{$from_date}' AND '{$to_date}' AND (IF(l.account_id!=0,a.account_id={$account_id},(j.from_account={$account_id} OR j.to_account={$account_id}))) ORDER BY l.date ASC
";
         //die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetAccountProductLedger($invoice_ref) {
        $query = "SELECT p_l.*,p.*,u.* FROM product_ledger p_l INNER JOIN products p ON p_l.product_id = p.product_id INNER JOIN units u ON p.unit_id = u.unit_id WHERE p_l.invoice_id={$invoice_ref}  ORDER BY p_l.date_ledger ASC";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetIssuedItems($issue_id) {
        $query = "SELECT product_ledger.*,products.product_name,units.unit_symbol as unit FROM product_ledger INNER JOIN products ON products.product_id = product_ledger.product_id INNER JOIN units ON units.unit_id = products.unit_id WHERE product_ledger.issue_id = '" . $issue_id . "' AND product_ledger.debit_qty IS NULL ORDER BY product_ledger.product_ledger_id DESC";
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetBalanceforAccount($to_date, $account_id) {
        $query = "SELECT (IFNULL(SUM(ledger.debit_amount),0)+a.opening_balance) - IFNULL(SUM(ledger.credit_amount),0) as balance,a.account_name FROM ledger  LEFT JOIN accounts a ON a.account_id = ledger.account_id AND ledger.date <= '" . $to_date . "' LEFT join journals j on ledger.journal_ref=j.journal_id  WHERE a.account_id = '" . $account_id . "'";
        // die($query);
        $query = $this->db->query($query);
        $result = $query->result();

        $query1 = "SELECT (IFNULL(SUM(ledger.debit_amount),0) - IFNULL(SUM(ledger.credit_amount),0)) as balance FROM ledger INNER join journals j on ledger.journal_ref=j.journal_id WHERE ledger.date <= '" . $to_date . "' AND (j.from_account = '" . $account_id . "' OR j.to_account='" . $account_id . "')";

        $query1 = $this->db->query($query1);
        $result1 = $query1->result();
        $result[0]->balance += $result1[0]->balance;

        return $result;

//        die();
    }

    function GetBalanceTotal($to_date) {
        $query = "SELECT (IFNULL(SUM(ledger.credit_amount),0) - IFNULL(SUM(ledger.debit_amount),0)) as balance FROM ledger WHERE ledger.date <= '" . $to_date . "' AND ledger.type='Journal'";
        //die($query);
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

    function GetstartBalncOfProduct($to_date, $account_id) {
        $query = "SELECT (IFNULL(SUM(ledger.debit_amount),0) - IFNULL(SUM(ledger.credit_amount),0)+a.opening_balance) as balance,a.account_name FROM accounts a LEFT JOIN ledger ON a.account_id = ledger.account_id AND ledger.date <= '" . $to_date . "' WHERE a.account_id = '" . $account_id . "'";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

//warehouse previous balance
    function GetWarehouseProductsLedger($to_date, $warehouse_id) {
        $query = "SELECT products.product_id,products.product_name,units.unit_symbol, warehouses.*,
(IFNULL(SUM(product_ledger.credit_qty),0)-IFNULL(SUM(product_ledger.debit_qty),0)+(products.instock-(product_balance.ledger_pro_credit-product_balance.ledger_pro_debit))) as product_balnc
FROM products
INNER JOIN
(SELECT product_ledger.product_id as ledger_product_id,SUM(IFNULL(product_ledger.credit_qty,0)) as ledger_pro_credit,SUM(IFNULL(product_ledger.debit_qty,0)) as ledger_pro_debit
FROM product_ledger
WHERE product_ledger.type = 'WAREHOUSE'
AND product_ledger.ref_id=" . $warehouse_id . " GROUP BY product_ledger.product_id) as product_balance ON product_balance.ledger_product_id = products.product_id
inner join warehouses on warehouses.warehouse_id=products.warehouse_id
inner join units on products.unit_id=units.unit_id
LEFT JOIN product_ledger ON product_ledger.product_id = products.product_id
AND product_ledger.type = 'WAREHOUSE' AND product_ledger.ref_id = " . $warehouse_id . "
AND product_ledger.date_ledger > '" . $to_date . "' GROUP BY product_ledger.product_id";
        // die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetReportforWarehouse($from_date, $to_date, $warehouse_id) {

        $query = "select p_l.*,p.*,u.* from product_ledger p_l inner join products p on p.product_id=p_l.product_id inner join units u on p.unit_id = u.unit_id where p_l.ref_id={$warehouse_id} and p_l.date_ledger between '$from_date' and '$to_date' and p_l.type='WAREHOUSE'   ";
//        die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

    function GetGeneralReport($from_date, $to_date) {
//        die($from_date . " " . $to_date);
        $query = "SELECT l.*,i.*,a.*,j.*,l.type as ledger_type,l.date as date,l.description as ledger_description FROM ledger l left join accounts a on l.account_id=a.account_id left join journals j on l.journal_ref=j.journal_id AND type='Journal' left join invoice i on l.invoice_ref=i.invoice_id AND l.type='Invoice' where l.date >=" . "'" . "$from_date" . "'" . " AND l.date<=" . "'" . $to_date . "' order by l.date asc ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetGeneralReport_cashmemo($from_date, $to_date) {
        $query = "SELECT l.*,a.*,j.*,e_l.*,e.emp_name,l.type as ledger_type,l.date as date,l.description as ledger_description FROM ledger l left join accounts a on l.account_id=a.account_id left join journals j on l.journal_ref=j.journal_id AND l.type='Journal' left join employee_ledger e_l on l.salary_ref=e_l.employee_ledger_id AND l.type='salary' left join employees e on e_l.employee_id=e.employee_id  where l.date >='{$from_date}' AND l.date<='{$to_date}' AND (l.type='Journal' OR l.type='salary') order by l.date asc";
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetOfficeAccountReport($from_date, $to_date) {
        $query = "SELECT l.*,j.*,l.type as ledger_type,l.date as date,l.description as ledger_description FROM ledger l  inner join journals j on l.journal_ref=j.journal_id AND type='Journal'  where l.date >=" . "'" . "$from_date" . "'" . " AND l.date<=" . "'" . $to_date . "' AND (j.from_account=0 OR j.to_account=0) ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetSectionsProductsLedger($to_date, $section_id) {
        $query = "SELECT products.product_id,units.unit_symbol,products.product_name,sections.*, (IFNULL(SUM(product_ledger.credit_qty),0)-IFNULL(SUM(product_ledger.debit_qty),0)) as product_balnc FROM product_ledger INNER JOIN products ON product_ledger.product_id = products.product_id INNER JOIN units ON units.unit_id = products.unit_id INNER JOIN sections ON sections.section_id = product_ledger.ref_id AND product_ledger.type = 'SECTION' WHERE product_ledger.ref_id = " . $section_id . " AND product_ledger.date_ledger < '" . $to_date . "' GROUP BY product_ledger.product_id";
//        die($query);
        $query = $this->db->query($query);
        if ($query->num_rows() < 1) {
            $query = "SELECT products.product_id,units.unit_symbol,products.product_name,sections.*, 0 as product_balnc FROM product_ledger INNER JOIN products ON product_ledger.product_id = products.product_id INNER JOIN units ON units.unit_id = products.unit_id INNER JOIN sections ON sections.section_id = product_ledger.ref_id AND product_ledger.type = 'SECTION' WHERE product_ledger.ref_id = " . $section_id . " GROUP BY product_ledger.product_id";
//            die($query);
            $query = $this->db->query($query);
        }
        return $query->result();
    }

    function GetReportforSection($from_date, $to_date, $section_id) {

        $query = "select p_l.*,p.*,u.* from product_ledger p_l inner join products p on p.product_id=p_l.product_id inner join units u on p.unit_id = u.unit_id where p_l.ref_id={$section_id} and p_l.date_ledger between '$from_date' and '$to_date' and p_l.type='SECTION'   ";
//        die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

//product ledger previous balance
    function GetProductsLedger($to_date, $product_id) {


        $query = "SELECT products.product_id,products.product_name, (IFNULL(SUM(product_ledger.credit_qty),0)-IFNULL(SUM(product_ledger.debit_qty),0)+(products.instock-IFNULL((SELECT SUM(IFNULL(product_ledger.credit_qty,0))-SUM(IFNULL(product_ledger.debit_qty,0)) FROM product_ledger WHERE  type='WAREHOUSE' AND product_ledger.product_id={$product_id}),0))) as product_balnc,u.* FROM products inner join units u on products.unit_id = u.unit_id LEFT JOIN product_ledger ON product_ledger.product_id = products.product_id AND product_ledger.date_ledger < '$to_date' AND product_ledger.product_id = $product_id AND product_ledger.type = 'WAREHOUSE' where products.product_id = $product_id  GROUP BY products.product_id";
//        die($query);
        // $query ="SELECT products.product_id,products.product_name, (IFNULL(SUM(product_ledger.credit_qty),0)-IFNULL(SUM(product_ledger.debit_qty),0)+
        //      (products.instock))
        //      as product_balnc,u.*
        //      FROM products
        //      inner join units u on products.unit_id = u.unit_id
        //      LEFT JOIN product_ledger ON product_ledger.product_id = products.product_id
        //      AND product_ledger.date_ledger < '$to_date' AND product_ledger.product_id = $product_id
        //      AND product_ledger.type = 'WAREHOUSE' where products.product_id = $product_id
        //      GROUP BY products.product_id";
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetProcessLedger($to_date, $product_id) {


        $query = "SELECT products.product_id,products.product_name, (IFNULL(SUM(product_ledger.credit_qty),0)-IFNULL(SUM(product_ledger.debit_qty),0)+(products.instock-IFNULL((SELECT SUM(IFNULL(product_ledger.credit_qty,0))-SUM(IFNULL(product_ledger.debit_qty,0)) FROM product_ledger WHERE  type='PROCESS' AND product_ledger.product_id={$product_id}),0))) as product_balnc,u.* FROM products inner join units u on products.unit_id = u.unit_id LEFT JOIN product_ledger ON product_ledger.product_id = products.product_id AND product_ledger.date_ledger < '$to_date' AND product_ledger.product_id = $product_id AND product_ledger.type = 'PROCESS' where products.product_id = $product_id  GROUP BY products.product_id";
        //die($query);
        // $query ="SELECT products.product_id,products.product_name, (IFNULL(SUM(product_ledger.credit_qty),0)-IFNULL(SUM(product_ledger.debit_qty),0)+
        //      (products.instock))
        //      as product_balnc,u.*
        //      FROM products
        //      inner join units u on products.unit_id = u.unit_id
        //      LEFT JOIN product_ledger ON product_ledger.product_id = products.product_id
        //      AND product_ledger.date_ledger < '$to_date' AND product_ledger.product_id = $product_id
        //      AND product_ledger.type = 'WAREHOUSE' where products.product_id = $product_id
        //      GROUP BY products.product_id";
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetFinalProductsLedger($to_date, $product_id) {

        $query = "SELECT products.product_id,products.product_name, (IFNULL(SUM(product_ledger.credit_qty),0)-IFNULL(SUM(product_ledger.debit_qty),0)+(products.instock-IFNULL((SELECT SUM(IFNULL(product_ledger.credit_qty,0))-SUM(IFNULL(product_ledger.debit_qty,0)) FROM product_ledger WHERE product_ledger.type = 'PRODUCTION'  AND product_ledger.product_id={$product_id}),0))) as product_balnc,u.* FROM products inner join units u on products.unit_id = u.unit_id LEFT JOIN product_ledger ON product_ledger.product_id = products.product_id AND product_ledger.date_ledger < '$to_date' AND product_ledger.product_id = $product_id AND product_ledger.type = 'PRODUCTION' where products.product_id = $product_id GROUP BY products.product_id order by product_ledger.date_ledger asc";
        //die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetReportforProducts($from_date, $to_date, $product_id) {

        $query = "select p_l.*,p.*,u.*,p_l.description as product_ledger_description from product_ledger p_l inner join products p on p.product_id=p_l.product_id inner join units u on p.unit_id = u.unit_id where p_l.product_id={$product_id} and p_l.date_ledger between '$from_date' and '$to_date'  and p.product_id = $product_id AND p_l.type='WAREHOUSE' order by p_l.date_ledger ASC";

        $query = $this->db->query($query);
        return $query->result();
    }

    function GetReportforProducts_general($from_date, $to_date, $product_id) {

        $query = "select p.product_id,p.product_name,u.unit_symbol as unit_symbol,p_l.description as description, p_l.date_ledger as date_ledger, SUM(p_l.credit_qty) as received,SUM(p_l.debit_qty) as issued,mytable.avg_purchase_price as purchase_price,mytable.avg_sale_price as sale_price from product_ledger p_l inner join products p on p.product_id=p_l.product_id inner join units u on p.unit_id = u.unit_id INNER JOIN (SELECT AVG(product_purchase_price) as avg_purchase_price,AVG(product_sale_price) as avg_sale_price,product_id FROM invoice_items WHERE product_id = {$product_id}) as mytable ON mytable.product_id = p_l.product_id where p_l.product_id={$product_id} and p_l.date_ledger between '{$from_date}' and '{$to_date}' and p.product_id = {$product_id} AND p_l.type='WAREHOUSE' order by p_l.date_ledger ASC";
        // $query = "select p.product_id,p.product_name,u.unit_symbol as unit_symbol,p_l.description as description, p_l.date_ledger as date_ledger, SUM(p_l.credit_qty) as received,SUM(p_l.debit_qty) as issued, i_i.product_purchase_price as purchase_price, i_i.product_sale_price as sale_price from product_ledger p_l inner join products p on p.product_id=p_l.product_id inner join units u on p.unit_id = u.unit_id left join invoice_items i_i on p_l.product_id=i_i.product_id where p_l.product_id={$product_id} and p_l.date_ledger between '$from_date' and '$to_date'  and p.product_id = $product_id AND p_l.type='WAREHOUSE' order by p_l.date_ledger ASC";

        $query = $this->db->query($query);


        return $query->result();
    }

    function GetRate($from_date, $to_date, $product_id) {


        $query = "select p.product_id,i_i.product_purchase_price as purchase_price, i_i.product_sale_price as sale_price from invoice i inner join invoice_items i_i ON i.invoice_id=i_i.invoice_id inner join products p on p.product_id=i_i.product_id inner join units u on p.unit_id = u.unit_id where i.date_created between '$from_date' and '$to_date'  and p.product_id = $product_id   order by i.date_created ASC";
// die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

////////////////////////////////////////////
    function GetReportforFinal($from_date, $to_date, $product_id) {
        $query = "select p_l.*,p.*,u.*,p_l.description as product_ledger_description from product_ledger p_l inner join products p on p.product_id=p_l.product_id inner join units u on p.unit_id = u.unit_id where p_l.product_id={$product_id} and p_l.date_ledger between '$from_date' and '$to_date'  and p.product_id = $product_id AND p_l.type='WARE
        ' order by p_l.date_ledger ASC";
        // die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

    function GetReportforFinal_general($from_date, $to_date, $product_id) {


        $query = "select p.product_id,p.product_name,u.unit_symbol as unit_symbol,p_l.description as description, p_l.date_ledger as date_ledger, SUM(p_l.credit_qty) as received,SUM(p_l.debit_qty) as issued, i_i.product_purchase_price as purchase_price, i_i.product_sale_price as sale_price from product_ledger p_l inner join products p on p.product_id=p_l.product_id inner join units u on p.unit_id = u.unit_id left join invoice_items i_i on p_l.product_id=i_i.product_id where p_l.product_id={$product_id} and p_l.date_ledger between '$from_date' and '$to_date'  and p.product_id = $product_id AND p_l.type='WAREHOUSE' order by p_l.date_ledger ASC";

        $query = $this->db->query($query);


        return $query->result();
    }

///////////////////////////////////////




    function GetReportforProcess($from_date, $to_date, $product_id) {

        $query = "select p_l.*,p.*,u.*,p_l.description as product_ledger_description from product_ledger p_l inner join products p on p.product_id=p_l.product_id inner join units u on p.unit_id = u.unit_id where p_l.product_id={$product_id} and p_l.date_ledger between '$from_date' and '$to_date'  and p.product_id = $product_id AND p_l.type='PROCESS' order by p_l.date_ledger ASC";
//        die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

    function GetReportforFinalProducts($from_date, $to_date, $product_id) {

        $query = "select p_l.*,p.*,u.*,p_l.description as description from product_ledger p_l inner join products p on p.product_id=p_l.product_id inner join units u on p.unit_id = u.unit_id where p_l.product_id={$product_id} and p_l.date_ledger between '$from_date' and '$to_date'  and p.product_id = $product_id AND p_l.type='PRODUCTION' order by p_l.date_ledger ASC";
//        die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

//    function GetSaleProductsLedger($to_date, $product_id, $account_id) {
//
//        $query = "SELECT products.product_id,products.product_name, (IFNULL(SUM(product_ledger.credit_qty),0)-IFNULL(SUM(product_ledger.debit_qty),0)+(products.instock-IFNULL((SELECT SUM(IFNULL(product_ledger.credit_qty,0))-SUM(IFNULL(product_ledger.debit_qty,0)) FROM product_ledger WHERE product_ledger.type = 'PRODUCTION'  AND product_ledger.product_id={$product_id}),0))) as product_balnc,u.* FROM products inner join units u on products.unit_id = u.unit_id LEFT JOIN product_ledger ON product_ledger.product_id = products.product_id AND product_ledger.date_ledger < '$to_date' AND product_ledger.product_id = $product_id AND product_ledger.type = 'PRODUCTION' where products.product_id = $product_id GROUP BY products.product_id";
//        //die($query);
//        $query = $this->db->query($query);
//        return $query->result();
//    }

    function GetReportforSaleProducts($from_date, $to_date, $product_id, $account_id) {


        $query = "SELECT products.*, units.*,ledger.description as description,i_i.*,accounts.*,invoice.* FROM invoice_items i_i INNER JOIN invoice ON invoice.invoice_id = i_i.invoice_id INNER JOIN ledger ON ledger.invoice_ref = invoice.invoice_id AND ledger.type = 'Invoice' INNER JOIN products ON products.product_id = i_i.product_id INNER JOIN units ON units.unit_id = products.sale_unit_id INNER JOIN accounts ON accounts.account_id = invoice.account_id WHERE ";
        if (!empty($product_id)) {
            $query .= "i_i.product_id = " . $product_id . " AND ";
        }
        if (!empty($account_id)) {
            $query .= "invoice.account_id = " . $account_id . " AND ";
        }
        $query .= "invoice.date_created BETWEEN '" . $from_date . "' AND '" . $to_date . "' AND invoice.type = 'Sale'";
        //$query = "select p_l.*,p.*,u.*,l.*,p_l.description as description,i_i.product_sale_price as product_sale_price,i_i.invoice_subtotal as invoice_subtotal,a.account_name as account_name  from product_ledger p_l inner join ledger l on p_l.invoice_id=l.invoice_ref AND l.type='Invoice'  inner join invoice_items i_i  on p_l.product_id=i_i.product_id  inner join accounts a on a.account_id=l.account_id inner join products p on p.product_id=p_l.product_id inner join units u on p.unit_id = u.unit_id where p_l.credit_qty is NULL ";
        //if (!empty($product_id)) {
        //    $query .= "AND p_l.product_id={$product_id} and p.product_id = $product_id and i_i.product_id = $product_id ";
        //}
        //if (!empty($account_id)) {
        //    $query .= "AND l.account_id={$account_id} ";
        //}
        //$query .= "and p_l.date_ledger between '$from_date' and '$to_date'   AND p_l.type='PRODUCTION' group by p_l.product_ledger_id order by p_l.date_ledger ASC";
        //die($query);
        $query .= " order by ledger.date asc";
        $query = $this->db->query($query);

        return $query->result();
    }

    function GetReportforPurchaseProducts($from_date, $to_date, $product_id, $account_id) {

        $query = "SELECT products.*, units.*,ledger.description as description,i_i.*,accounts.*,invoice.* FROM invoice_items i_i INNER JOIN invoice ON invoice.invoice_id = i_i.invoice_id INNER JOIN ledger ON ledger.invoice_ref = invoice.invoice_id AND ledger.type = 'Invoice' INNER JOIN products ON products.product_id = i_i.product_id INNER JOIN units ON units.unit_id = products.sale_unit_id INNER JOIN accounts ON accounts.account_id = invoice.account_id WHERE ";
        if (!empty($product_id)) {
            $query .= "i_i.product_id = " . $product_id . " AND ";
        }
        if (!empty($account_id)) {
            $query .= "invoice.account_id = " . $account_id . " AND ";
        }
        $query .= "invoice.date_created BETWEEN '" . $from_date . "' AND '" . $to_date . "' AND invoice.type = 'Purchase'";
        $query .= " order by ledger.date asc";
//        die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

    function GetOldRaw($issue_id) {
        $query = "Select product_ledger.product_id,SUM(IFNULL(product_ledger.credit_qty,0))-SUM(IFNULL(product_ledger.debit_qty,0)) as old_tot_issue from product_ledger where product_ledger.issue_id<{$issue_id} and type='SECTION' group by product_ledger.product_id";
//        die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

    function get_wharehouse_pro($id) {
        $query = "SELECT products.*, warehouses.warehouse_name FROM products
        INNER JOIN warehouses ON products.warehouse_id = warehouses.warehouse_id
         WHERE products.warehouse_id =" . $id;
        // echo $query;
        // die();
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function GetDistinctDate($QUERY, $TABLE, $inner = null, $CONDITION = NULL) {
        $query = "SELECT  {$QUERY} FROM {$TABLE} {$inner} WHERE {$CONDITION}";
        // echo $query; die();
        $query = $this->db->query($query);
        return $query->result_array();
    }

    function GetTotalPurchases() {
        $query = "SELECT SUM(invoice.invoice_total) as total_balnc FROM invoice INNER JOIN accounts ON accounts.account_id = invoice.account_id WHERE type='Purchase' ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetTotalPurchases_filter($date_from, $date_to, $category, $product, $prod_type, $search = NULL) {
        // print_r($prod_type);die();
        $query = "SELECT invoice.invoice_total as total_balnc FROM invoice INNER JOIN invoice_items ON invoice_items.invoice_id = invoice.invoice_id INNER JOIN products ON invoice_items.product_id = products.product_id  INNER JOIN accounts ON accounts.account_id = invoice.account_id WHERE invoice.type='Purchase' ";
        if (!empty($date_from) && !empty($date_to)) {
            $query .= " and (DATE(invoice.date_created) between '$date_from' and '$date_to') ";
        }

        if (!empty($prod_type)) {
            $query .= " AND products.type = '$prod_type'";
        }
        if (!empty($category)) {
            $query .= " AND  products.product_category_id=$category";
        }
        if (!empty($product)) {
            $query .= "  AND products.product_id=$product ";
        }
        if (!empty($search)) {
            $query .= " AND (invoice.invoice_id LIKE '%{$search}%' OR invoice.date_created LIKE '%{$search}%' OR accounts.account_name LIKE '%{$search}%' OR invoice.payment_method LIKE '%{$search}%' )";
        }

        $query .= " GROUP BY invoice.invoice_id ";
        $query .= " ORDER BY invoice.invoice_id DESC ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetTotalSales() {
        $query = "SELECT SUM(invoice.invoice_total) as total_balnc FROM invoice INNER JOIN accounts ON accounts.account_id = invoice.account_id WHERE type='Sale' ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetTotalSales_filter($date_from, $date_to, $category, $product, $prod_type, $search = NULL) {
        // print_r($prod_type);die();
        $query = "SELECT invoice.invoice_total as total_balnc FROM invoice INNER JOIN invoice_items ON invoice_items.invoice_id = invoice.invoice_id INNER JOIN products ON invoice_items.product_id = products.product_id  INNER JOIN accounts ON accounts.account_id = invoice.account_id WHERE invoice.type='Sale' ";
        if (!empty($date_from) && !empty($date_to)) {
            $query .= " and (DATE(invoice.date_created) between '$date_from' and '$date_to') ";
        }

        if (!empty($prod_type)) {
            $query .= " AND products.type = '$prod_type'";
        }
        if (!empty($category)) {
            $query .= " AND  products.product_category_id=$category";
        }
        if (!empty($product)) {
            $query .= "  AND products.product_id=$product ";
        }
        if (!empty($search)) {
            $query .= " AND (invoice.invoice_id LIKE '%{$search}%' OR invoice.date_created LIKE '%{$search}%' OR accounts.account_name LIKE '%{$search}%' OR invoice.payment_method LIKE '%{$search}%' )";
        }

        $query .= " GROUP BY invoice.invoice_id ";
        $query .= " ORDER BY invoice.invoice_id DESC ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetTotalSalesOrder() {
        $query = "SELECT SUM(ordr.ordr_total) as total_balnc FROM ordr INNER JOIN accounts ON accounts.account_id = ordr.account_id WHERE type='Sale' ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetTotalSalesOrder_filter($date_from, $date_to, $category, $product, $prod_type, $search = NULL) {
        // print_r($prod_type);die();
        $query = "SELECT ordr.ordr_total as total_balnc FROM ordr INNER JOIN ordr_items ON ordr_items.ordr_id = ordr.ordr_id INNER JOIN products ON ordr_items.product_id = products.product_id  INNER JOIN accounts ON accounts.account_id = ordr.account_id WHERE ordr.type='Sale' ";
        if (!empty($date_from) && !empty($date_to)) {
            $query .= " and (DATE(ordr.date_created) between '$date_from' and '$date_to') ";
        }

        if (!empty($prod_type)) {
            $query .= " AND products.type = '$prod_type'";
        }
        if (!empty($category)) {
            $query .= " AND  products.product_category_id=$category";
        }
        if (!empty($product)) {
            $query .= "  AND products.product_id=$product ";
        }
        if (!empty($search)) {
            $query .= " AND (ordr.ordr_id LIKE '%{$search}%' OR ordr.date_created LIKE '%{$search}%' OR accounts.account_name LIKE '%{$search}%'  )";
        }

        $query .= " GROUP BY ordr.ordr_id ";
        $query .= " ORDER BY ordr.ordr_id DESC ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetBatches($batch_id) {
        $query = "SELECT pr.*,ba.*,un.* FROM batches ba INNER JOIN products pr ON ba.product_id = pr.product_id INNER JOIN units un ON pr.unit_id = un.unit_id WHERE ba.batch_id ={$batch_id} ";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetBatchProCount($batch_no) {
        $query = "SELECT IFNULL(SUM(product_ledger.debit_qty),0) as total_sale_qty,batches.max_qty as max_qty FROM batches LEFT JOIN  invoice_items ON batches.batch_no = invoice_items.batch LEFT JOIN product_ledger ON product_ledger.invoice_id = invoice_items.invoice_id AND product_ledger.product_id = invoice_items.product_id AND product_ledger.debit_qty IS NOT NULL WHERE batches.batch_no = '" . $batch_no . "'";
//        die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

    function GetJournal($journal_id) {
        $query = "SELECT j.*,a1.account_name as from_account_name, a1.account_address as from_account_address, a1.ph_number as from_account_ph_number, a2.account_name as to_account_name,a2.account_address as to_account_address, a2.ph_number as to_account_ph_number FROM journals j LEFT JOIN accounts a1 ON a1.account_id = j.from_account LEFT JOIN accounts a2 ON a2.account_id = j.to_account WHERE j.journal_id = '" . $journal_id . "'";
        // die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

    function GetAllEmp($limit = NULL, $search_text = NULL) {
        $query = "SELECT   e.*,e_s.*,e.employee_id as employee_id  FROM employees e LEFT JOIN ( ";
        $query .= " SELECT * FROM employee_salary ";
        $query .= " WHERE employee_salary_id IN (SELECT MAX(employee_salary_id)FROM employee_salary GROUP BY employee_id) ";
        $query .= " )as e_s ON e_s.employee_id = e.employee_id ";

        if (!empty($search_text)) {
            $query .= " where e.emp_name LIKE '%{$search_text}%' OR e.emp_father_name LIKE '%{$search_text}%' OR e.emp_local_address LIKE '%{$search_text}%' OR e.emp_permanent_address LIKE '%{$search_text}%' OR e.emp_unique_id LIKE '%{$search_text}%' OR e_s.salary LIKE '%{$search_text}%' ";
        }

        $query .= " order by e.employee_id asc";
        if (!empty($limit)) {
            $query .= " limit $limit";
        }
//        die($query);
        $query = $this->db->query($query);

        return $query->result_array();
    }

    function GetEmployeeById($employee_id) {
        $query = "SELECT   e.*,e_s.*,e.employee_id as employee_id  FROM employees e LEFT JOIN ( ";
        $query .= " SELECT * FROM employee_salary ";
        $query .= " WHERE employee_salary_id IN (SELECT MAX(employee_salary_id)FROM employee_salary where employee_id={$employee_id} GROUP BY employee_id) ";
        $query .= " )as e_s ON e_s.employee_id = e.employee_id ";

        $query .= " where e.employee_id={$employee_id} ";
        $query .= " order by e.employee_id asc";

//        die($query);
        $query = $this->db->query($query);

        return $query->result();
    }

    function UpdateEmployeeUniqueID($employee_id, $unique_id) {
        $data = array(
            'emp_unique_id' => $unique_id
        );
        $this->db->where('employee_id', $employee_id);
        $this->db->update('employees', $data);
        return TRUE;
    }

    function GetAllAdvances() {
        $query = "select e_l.*,e.emp_name as emp_name from employee_ledger e_l left join employees e on e.employee_id=e_l.employee_id where e_l.type='Advance'";
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

    function GetAllpayslips() {
        $query = "select e_l.*,e.emp_name as emp_name from employee_ledger e_l left join employees e on e.employee_id=e_l.employee_id where e_l.type='Salary'";
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

    function GetAllIncrements() {
        $query = "SELECT   e.*,e_s.*,e.employee_id as employee_id  FROM employees e right JOIN ( ";
        $query .= " SELECT * FROM employee_salary ";
        $query .= " WHERE employee_salary_id IN (SELECT MAX(employee_salary_id)FROM employee_salary GROUP BY employee_id) ";
        $query .= " )as e_s ON e_s.employee_id = e.employee_id ";


        $query .= " order by e.employee_id asc";

        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

    function GetBasicSalary($employee_id) {
        $query = "select * from employee_salary where employee_id={$employee_id} order by employee_salary_id desc limit 1";
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

    function GetAdvance($employee_id, $month, $year) {
        $query = "select SUM(ledger_amount) as total_advance from employee_ledger where employee_id={$employee_id} and MONTH(ledger_date)='{$month}' and YEAR(ledger_date)='{$year}' AND type='Advance'";
//        die($query);
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

    function GetSalaryReport($month, $year, $employee_id) {
        $query = "select l.*,e.* ,l.type as ledger_type  from employee_ledger l inner join employees e on e.employee_id=l.employee_id  where   MONTH(l.ledger_date)='{$month}' and YEAR(l.ledger_date)='{$year}' AND type='Salary'";
        if (!empty($employee_id)) {
            $query .= " AND l.employee_id={$employee_id}";
        }
//        die($query);
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

    function GetSalaryReportDetail() {
        $query = "select  l_d.*,l_d.type as ledger_detail_type  from employee_ledger_detail l_d ";
//        die($query);
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

}
