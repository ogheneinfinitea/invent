<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);
class Script2 extends CI_Controller {
	public function index(){
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M');
		$query = "SELECT invoice_id,description FROM invoice WHERE description IS NOT NULL";
		$query = $this->db->query($query);
		$res = $query->result();
		// print_r($res);
		// die();
		$count = 1;
		foreach ($res as $each) {
			$re=explode('&lt;/p',$each->description);
			$desc1=substr($re[0],9);
		// 	// die();
			$update_query = "UPDATE invoice SET voucher_no = '{$desc1}' where invoice_id={$each->invoice_id}";
		
			$update_query = $this->db->query($update_query);
			$count++;
		}
		die("DONE");
	}
}