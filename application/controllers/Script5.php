<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);
class Script5 extends CI_Controller {
	public function index(){
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M');
		$query = "SELECT ledger.*, journals.* FROM ledger INNER JOIN journals ON ledger.journal_ref=journals.journal_id WHERE ledger.type='Journal' and ledger.account_id=0 ";
		$query = $this->db->query($query);
		$res = $query->result();
		
		// print_r($res);
		// die();


		$CPV_Count=1;
		$CRV_Count=1;

	 	foreach ($res as $r) {
	
		if ( $r->from_account==0){
		$update_query = "UPDATE journals SET CPV = 'CPV#".sprintf('%05d', $CPV_Count)."' where journals.journal_id={$r->journal_id}" ;
		$CPV_Count ++;
		// die($update_query);
		}

		if ( $r->to_account==0){
		$update_query = "UPDATE journals SET CRV = 'CRV#".sprintf('%05d', $CRV_Count)."' where journals.journal_id={$r->journal_id}" ;
		$CRV_Count ++;
		// die($update_query);
		}

		
	 	
		
	 	$this->db->query($update_query);

	 	
	 		

	 	}
		die("DONE");
	 
	}
}
