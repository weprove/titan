<?php
namespace App\Model;

use Nette\Object,
	Nette\Database\SqlLiteral,
	Nette\Diagnostics\Debugger;
/**
 * user authenticator.
 */
class Backend extends Base
{ 
	// STORE
	public function getStoreData($store_id){
		return $this->db->table("store")->select("*")->where("store_id = ?", $store_id)->fetch();
	}
	
	public function updateStore($values){		
		$str = "";
		
		forEach($values as $key => $value){
			$str .= " $key = values($key),";
		}
		
		$str = substr($str, 0, -1);
		
		$r = $this->db->query("INSERT INTO store ", $values," ON DUPLICATE KEY UPDATE $str");
		
		return ($r)?true:false;
	}

	public function getStores(){
		return $this->db->table("store")->select("*");
	}

}
