<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
    function index() {
      $a_date = date("Y-m-d");
	  $TotalDayInMonth= date("t", strtotime($a_date));
	  $StartMonth = date("Y-m-01 00:00:00");
	  $EndDate = date("Y-m-t 23:59:59");
      $data  = array();
      $this->data['DISTPRO'] = NULL;
    	////////////////////////////////// SAlE DATA////////////////////////////////////////////////

    	$QUERY ="DISTINCT date_created";
    	$TABLE ="invoice";
    	$INNER = "";
    	$CONDITION ="type = 'Sale' AND date_created BETWEEN '".$StartMonth."' AND '". $EndDate."'";
    	$this->data['DistinctDate'] = $this->web->GetDistinctDate($QUERY,$TABLE,$INNER,$CONDITION);
    	$c = 1;
    	foreach ($this->data['DistinctDate'] as $DD) {
    	
			$DATEEX = (explode(" ",$DD["date_created"]));
			$StartMonth =  $DATEEX[0]." 00:00:00";
	 		$EndDate = $DATEEX[0]." 23:59:59";
    	
    	$QUERY ="SUM(invoice_total) AS TOTAL, date_created";
    	$TABLE ="invoice";
    	$INNER = "";
    	$CONDITION ="type = 'Sale' AND date_created BETWEEN '".$StartMonth."' AND '". $EndDate."'";
    	$this->data['DAYSALE'] = $this->web->GetDistinctDate($QUERY,$TABLE,$INNER,$CONDITION);
    	
    	$data[$c] = array(
                        'TOTAL' =>  $this->data['DAYSALE'][0]["TOTAL"],
                        'date_created' =>  $this->data['DAYSALE'][0]["date_created"]
                         );
       
                     $c ++;
    	}
    	 $this->data['SALEDATA']  = array_unique($data, SORT_REGULAR);

         if($this->data['SALEDATA'] == NULL){
            $this->data['SALEDATA'] = 0;
         }
         //var_dump($this->data['SALEDATA']); die();

    	////////////////////////////////// PURCHASE DATA ////////////////////////////////////////////////

        $StartMonth = date("Y-m-01 00:00:00");
	    $EndDate = date("Y-m-t 23:59:59");
    	$QUERY ="DISTINCT date_created";
    	$TABLE ="invoice";
        $INNER = "";
    	$CONDITION ="type = 'Purchase' AND date_created BETWEEN '".$StartMonth."' AND '". $EndDate."'";
    	$this->data['DistinctDate'] = $this->web->GetDistinctDate($QUERY,$TABLE,$INNER,$CONDITION);
    	// 	var_dump($this->data['DistinctDate'] );
    	$c = 1;
    	foreach ($this->data['DistinctDate'] as $DD) {
    	
			$DATEEX = (explode(" ",$DD["date_created"]));
			$StartMonth =  $DATEEX[0]." 00:00:00";
	 		$EndDate = $DATEEX[0]." 23:59:59";
    	
    	$QUERY ="SUM(invoice_total) AS TOTAL, date_created";
    	$TABLE ="invoice";
    	$INNER = "";
    	$CONDITION ="type = 'Purchase' AND date_created BETWEEN '".$StartMonth."' AND '". $EndDate."'";
    	$this->data['DAYSALE'] = $this->web->GetDistinctDate($QUERY,$TABLE,$INNER,$CONDITION);
    	
    	$data[$c] = array(
                        'TOTAL' =>  $this->data['DAYSALE'][0]["TOTAL"],
                        'date_created' =>  $this->data['DAYSALE'][0]["date_created"]
                         );
       
                     $c ++;
    	}
    	 $this->data['PURCHASEDATA']  = array_unique($data, SORT_REGULAR);
          if($this->data['PURCHASEDATA']==NULL){
            $this->data['PURCHASEDATA']=0;
         }

    	//var_dump($this->data['PURCHASEDATA'] );
    	
    	////////////////////////////////// PRODUCTION DATA ////////////////////////////////////////////////

        $StartMonth = date("Y-m-01 00:00:00");
	    $EndDate = date("Y-m-t 23:59:59");

    	$QUERY =" products.product_name AS NAME, SUM(product_ledger.credit_qty) AS QUANTITY";
    	$TABLE ="product_ledger";
    	$INNER = "INNER JOIN products ON product_ledger.product_id = products.product_id ";
    	$CONDITION =" product_ledger.ref_id= 1
						AND product_ledger.type='PRODUCTION'
						AND product_ledger.debit_qty IS NULL
						AND product_ledger.date_ledger BETWEEN '".$StartMonth."' AND '". $EndDate."' 
						GROUP BY product_ledger.product_id";
    	$this->data['DATA'] = $this->web->GetDistinctDate($QUERY,$TABLE,$INNER,$CONDITION);
    	// print_r($this->data['DATA']); die();
    	$this->data['PRODUCTIONDATA'] = $this->data['DATA'];
         if($this->data['PRODUCTIONDATA']==NULL){
            $this->data['PRODUCTIONDATA']=0;
         }

    	//var_dump($this->data['PRODUCTIONDATA'] ); die();

    	////////////////////////////////// TOP 5 SALE ////////////////////////////////////////////////

        $StartMonth = date("Y-m-01 00:00:00");
	    $EndDate = date("Y-m-t 23:59:59");
    	$QUERY ="invoice_id";
    	$TABLE ="invoice";
        $INNER = "";
    	$CONDITION ="type = 'Sale' AND date_created BETWEEN '".$StartMonth."' AND '". $EndDate."'";
    	$this->data['DistinctInvice'] = $this->web->GetDistinctDate($QUERY,$TABLE,$INNER,$CONDITION);
    	
    	//var_dump($this->data['DistinctInvice'] );
    	$SIZEA = sizeof($this->data['DistinctInvice']);
    	$SIZE = $SIZEA-1;
    	
    	if($this->data['DistinctInvice'] != NULL){
    	$QUERY ="  SUM(invoice_items.invoice_subtotal) AS subtotal, products.product_name ";
    	$TABLE ="invoice_items";
        $INNER = " INNER JOIN products ON invoice_items.product_id=products.product_id INNER JOIN invoice ON invoice.invoice_id = invoice_items.invoice_id AND invoice.type = 'Sale'";
    	$CONDITION ="invoice_items.invoice_id>= ".$this->data['DistinctInvice'][0]["invoice_id"]." AND invoice_items.invoice_id <= ".$this->data['DistinctInvice'][$SIZE]["invoice_id"]." GROUP BY invoice_items.product_id ORDER BY subtotal DESC LIMIT 5";
    	$this->data['DISTPRO'] = $this->web->GetDistinctDate($QUERY,$TABLE,$INNER,$CONDITION);
        // print_r($this->data['DISTPRO']); die();


 //    	$this->data['TOP5DETAIL'] = NULL;
 //    	$c = 1;
 //    	foreach ($this->data['DistinctInvice'] as $DD) {
 //    	$QUERY =" * ";
 //    	$TABLE ="invoice_items";
 //    	$INNER = "";
 //    	$CONDITION =" invoice_id =".$DD["invoice_id"];
 //    	$this->data['INVICEITEM'] = $this->web->GetDistinctDate($QUERY,$TABLE,$INNER,$CONDITION);
 //        // print_r($this->data['INVICEITEM'] ); die();
 //    	foreach ($this->data['INVICEITEM']  as $INVICEITEM) {

	// 	if($this->data['TOP5DETAIL'] != NULL){
	// 		$i = 0;
	// 		$j = 0;
	// 	    		foreach ($this->data['TOP5DETAIL'] as $key) {
	// 	    			if($key["product_id"] == $INVICEITEM["product_id"]){
	// 	    				//echo "string <br>";
	// 	    				$AMOUNT_PRE = $key["AMOUNT"];
	// 	    				$j = $i;
	// 	    				}
	// 	    		$i++;}
	// 	    	}
			
 //    		$c = 0 ;
	//     	foreach ($this->data['DISTPRO'] as $DISTPRO) {
	//     		if($INVICEITEM["product_id"] == $DISTPRO["pro"]){
	    		
	//     			//var_dump($DISTPRO["pro"]);
	//     			$amountSub = $INVICEITEM["qty"] * $INVICEITEM["product_sale_price"];
	//     			if(empty($AMOUNT_PRE)){
	    				
	//     				$amount = $amountSub;
	//     				$this->data['TOP5DETAIL'][$c] = array(
	//     				'product_id' =>  $INVICEITEM["product_id"],
	//     				'product_name' =>  $DISTPRO["product_name"],
 //                        'AMOUNT' =>  $amount
 //                         );
	//     			}
	//     		if(!empty($AMOUNT_PRE)){
	    		
	//     			$amount = $amountSub + $AMOUNT_PRE;
	//     			$this->data['TOP5DETAIL'][$j] = array(
	//     				'product_id' =>  $INVICEITEM["product_id"],
	//     				'product_name' =>  $DISTPRO["product_name"],
 //                        'AMOUNT' =>  $amount
 //                         );
	//     				}
	//     	}
	// $c++; }
 //    	}
    	
 //    		  }
 //    $items_thread = array_unique($this->data['TOP5DETAIL'], SORT_REGULAR);
	// function usort_callback($a, $b){
	//  if ( $a['AMOUNT'] == $b['AMOUNT'] )
	//     return 0;
 //   	  return ( $a['AMOUNT'] > $b['AMOUNT'] ) ? -1 : 1;
	// }
	// usort($items_thread, 'usort_callback');
	// $this->data['TOP5'] = array_slice($items_thread, 0, 5);

	// }
    }
    $this->data['TOP5'] = $this->data['DISTPRO'];
    // print_r($this->data['TOP5']); die();
    // print_r($this->data['SALEDATA']); die(); 
        $this->load->view("dashboard",$this->data);

    }

}
//SELECT DISTINCT date_created AS DATED FROM invoice WHERE type = 'Sale' AND date_created BETWEEN '2017-11-01 00:00:00' AND '2017-11-30 23:59:59'