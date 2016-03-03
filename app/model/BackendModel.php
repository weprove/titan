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
	public function getPromotionData($promotion_id){
		$selection = $this->db->table("promotion")->select("*")->where("promotion_id = ?", $promotion_id)->fetch();	
		return $selection;			
	}
	
	public function updateSpecialOffer($values){
		$str = "";
		
		forEach($values as $key => $value){
			$str .= " $key = values($key),";
		}
		
		$str = substr($str, 0, -1);
		
		$r = $this->db->query("INSERT INTO promotion ", $values," ON DUPLICATE KEY UPDATE $str");
		
		return ($r)?true:false;	
	}
	
	public function getSpecialOffers($store_id){
		$selection = $this->db->table("promotion")->select("*")->where("store_id = ?", $store_id)->fetchAll();	
		return $selection;		
	}
	
	// STORE
	public function getProductData($product_id){
		return $this->db->table("product")->select("*")->where("product_id = ?", $product_id)->fetch();
	}
	
	public function updateProduct($values){		
		$str = "";
		
		forEach($values as $key => $value){
			$str .= " $key = values($key),";
		}
		
		$str = substr($str, 0, -1);
		
		$r = $this->db->query("INSERT INTO product ", $values," ON DUPLICATE KEY UPDATE $str");
		
		return ($r)?true:false;
	}
	
	public function getProducts($store_id = NULL){
		$selection = $this->db->table("product")->select("*")->where("store_id = ?", $store_id);	
		if(!$store_id)
			$selection->where("1=2");
		return $selection;
	}
	
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
	
	public function getStorePairs(){
		return $this->db->table("store")->select("store_id, storeName")->fetchPairs("store_id", "storeName");
	}
	
	public function getProductsByStorePairs($store_id){
		return $this->db->table("product")->select("product_id, productName")->where("store_id = ?", $store_id)->fetchPairs("product_id", "productName");
	}

}
