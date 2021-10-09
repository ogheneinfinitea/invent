<?php

function CheckSess() {
    $CI = & get_instance();  //get instance, access the CI superobject
    $isLoggedIn = $CI->session->userdata('logged_in');
    if ($isLoggedIn) {
        return TRUE;
    }
    return FALSE;
}

function fail() {
    $CI = & get_instance();  //get instance, access the CI superobject
    $isLoggedIn = $CI->session->userdata('failed');
    if ($isLoggedIn) {
        return TRUE;
    }
    return FALSE;
}

function GetInstock($product_id) {
    $CI = & get_instance();
    $CI->load->database();
    $query = "SELECT instock from products where product_id={$product_id}";
//    return $query;
    $result = $CI->db->query($query);
    return $result->result()[0];
}

function GetTotalIssue($product_id) {
    $CI = & get_instance();
    $CI->load->database();
    $query_process_check = "select * from product_ledger where product_id={$product_id} AND description LIKE '%PROCESS-%'";
    $result1 = $CI->db->query($query_process_check);
    $result1 = $result1->result();
    if (!empty($result1[0])) {
        $query = "SELECT SUM(IFNULL(credit_qty,0))-SUM(IFNULL(debit_qty,0)) as total_issue from product_ledger where  product_id={$product_id} AND (type='SECTION'  )";
    } else {
        $query = "SELECT SUM(IFNULL(credit_qty,0))-SUM(IFNULL(debit_qty,0)) as total_issue from product_ledger where type='SECTION'  AND product_id={$product_id}";
    }

// return $query;
//    return $query;
    $result = $CI->db->query($query);
    return $result->result()[0];
}

function GetTotalIssueProcess($product_id) {
    $CI = & get_instance();
    $CI->load->database();

    $query = "SELECT SUM(IFNULL(credit_qty,0))-SUM(IFNULL(debit_qty,0)) as total_issue from product_ledger where type='SECTION'  AND product_id={$product_id}";




//    return $query;
    $result = $CI->db->query($query);
    return $result->result()[0];
}

function GetProductsByWarehouse($warehouse_id) {
    $CI = & get_instance();
    $CI->load->database();
    $query = "SELECT p.*,p_c.*,u.* FROM products p inner join units u on p.unit_id =u.unit_id inner join product_categories p_c on p_c.product_category_id =p.product_category_id  WHERE p.warehouse_id= '" . $warehouse_id . "' ORDER BY p.product_id";

//    return $query;
    $result = $CI->db->query($query);
    $result = $result->result();
    $options = "<option value=''>Select Product</option>";
    $options .= "<optgroup label='" . $result[0]->product_category_name . "'>";
    foreach ($result as $res) {


        $options .= "<option value='" . $res->product_id . "' unit_symbol='" . $res->unit_symbol . "'>" . $res->product_name . "</option>";
    }
    $options .= "</optgroup>";
    return $options;
}

function GetProductsWithSection($section_id) {
    $CI = & get_instance();
    $CI->load->database();
    $qu = "SELECT products.*,product_categories.*,units.*,product_ledger.*,sum(IFNULL(product_ledger.credit_qty,0))-sum(IFNULL(product_ledger.debit_qty,0)) as max_qty FROM products INNER JOIN product_ledger ON products.product_id = product_ledger.product_id
INNER JOIN product_categories ON products.product_category_id = product_categories.product_category_id INNER JOIN units ON
products.unit_id = units.unit_id WHERE products.type = 'raw' and product_ledger.type='SECTION'  and product_ledger.ref_id=" . $section_id . " group by products.product_id";
    // return $qu;
    $result = $CI->db->query($qu);
    $result = $result->result();

    $options = "<option value=''>Select or Type Raw Material</option>";
    $options .= "<optgroup label='" . $result[0]->product_category_name . "'>";
    foreach ($result as $res) {

        // if ($res->max_qty < 0 || $res->max_qty == null) {
        //     continue;
        // }
        $options .= "<option max_qty='" . $res->max_qty . "' unit_symbol='" . $res->unit_symbol . "'  value='" . $res->product_id . "'>" . $res->product_name . "</option>";
    }
    $options .= "</optgroup>";
    return $options;
}

//<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
//                        <ul class="nav child_menu">
//                            <li><a href="index.html">Dashboard</a></li>
//                            <li><a href="index2.html">Dashboard2</a></li>
//                            <li><a href="index3.html">Dashboard3</a></li>
//                        </ul>
//                    </li>
function GenerateMenu($modules) {
    $my_menu = "";
    $test_menu = "";
    $my_modules = array();
    foreach ($modules as $module) {
        $my_modules[$module->parent_id][] = $module;
    }
//    print_r($my_modules);
//    die();
    $my_menu .= "<ul id='sidebar-menu'>";
    foreach ($my_modules[0] as $parent_modules) {
        $my_menu .= "<li><a href='" . get_instance()->config->base_url() . $parent_modules->module_path . "'><i class='glyph-icon " . $parent_modules->icon . "'></i><span>" . $parent_modules->module_name . "</span></a>";
        $count_child = 1;
        if (key_exists($parent_modules->module_id, $my_modules)) {
            foreach ($my_modules[$parent_modules->module_id] as $child_modules) {
                if ($count_child == 1) {
                    $my_menu .= " <div class='sidebar-submenu'><ul>";
                }
                $my_menu .= "<li><a href='" . get_instance()->config->base_url() . $child_modules->module_path . "'><span>" . $child_modules->module_name . "</span></a></li>";
//                $test_menu.=$count_child . " " . count($my_modules[$parent_modules->module_id]) . "<br>";
                if ($count_child == count($my_modules[$parent_modules->module_id])) {
                    $my_menu .= "</ul></div>";
                }
                $count_child++;
            }
        }
        $my_menu .= "</li>";
        $my_menu .= "<li class='divider'></li>";
    }
    $my_menu .= "</ul>";
    return $my_menu;
}

function GetDoctorById($doctor_id) {
    $CI = & get_instance();
    $CI->load->database();
    $query = "SELECT * FROM users WHERE user_group_id = 2 AND id = " . $doctor_id;
    $result = $CI->db->query($query);
    return $result->result();
}

function GetNewPatientID($patient_id) {
    $CI = & get_instance();
    $CI->load->database();
    $query = "SELECT id FROM patients WHERE unique_id = '" . $patient_id . "' ORDER BY id DESC LIMIT 1";
    //die($query);
    $result = $CI->db->query($query);
    $result = $result->result();
//    print_r($result);
//    die();
    return $result[0]->id;
}

function GetUniqueId($employee_id) {
    $CI = & get_instance();
    $CI->load->database();
    $query = "SELECT emp_unique_id FROM employees WHERE employee_id = '" . $employee_id . "' ORDER BY employee_id DESC LIMIT 1";
    //die($query);
    $result = $CI->db->query($query);
    $result = $result->result();
//    print_r($result);
//    die();
    return $result[0]->emp_unique_id;
}

function GetSalt($s_id) {
    $CI = & get_instance();
    $CI->load->database();
    $posdb = $CI->load->database('pos', TRUE);
    $query = "SELECT * FROM sma_categories WHERE id = '" . $s_id . "'";
    //die($query);
    $result = $posdb->query($query);
    return $result->result();
}

function getPakistaniCurrency($number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else
            $str[] = null;
    }
    $Rupees = ucwords(implode('', array_reverse($str)));
    $paise = ucwords(($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '');
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}
