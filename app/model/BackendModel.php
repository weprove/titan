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
	public function getBiggerSize($prevSize, $store_id){
		$r = $this->db->table("main_product")->select("main_product_id")->where("mainProductSize > ? AND store_id = ?", $prevSize, $store_id)->order("mainProductSize")->limit(1)->fetch();	
		return  (isset($r["main_product_id"]))?$r["main_product_id"]:false;
	}
	
	public function getSmallerSize($prevSize, $store_id){
		$r = $this->db->table("main_product")->select("main_product_id")->where("mainProductSize < ? AND store_id = ?", $prevSize, $store_id)->order("mainProductSize")->limit(1)->fetch();	
		return  (isset($r["main_product_id"]))?$r["main_product_id"]:false;	
	}
	
	public function getCart($cart_id){
		return $this->db->table("cart")->select("*, main_product_id.mainProductSize")->where("cart_id = ?", $cart_id)->fetch();
	}
	
	public function saveCart($values){
		$r = $this->db->query("INSERT INTO cart ", $values);
		$insId =  $this->db->getInsertId();
		
		return ($insId)?$insId:false;
	}
	
	public function saveCustomer($values){
		$r = $this->db->query("INSERT INTO customer ", $values);
		$insId =  $this->db->getInsertId();
		
		return ($insId)?$insId:false;
	}
	
	public function updateProductSpecialOffer($values, $product_id){
		return $this->db->query("UPDATE product SET", $values, "WHERE product_id = ?", $product_id);
	}
	
	public function getStoreSpecialOffers($store_id){
		return $this->db->table("promotion")->select("promotion_id, promotionName")->where("store_id = ?", $store_id)->fetchPairs("promotion_id", "promotionName");	
	}
	
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
		return $this->db->table("product")->select("*, promotion_id.promotionPercentage, promotion_id.promotionMinimalRentingPeriod, promotion_id.promotionValidityPeriod, promotion_id.promotionActive")->where("product_id = ?", $product_id)->fetch();
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
		$selection = $this->db->table("product")->select("*, promotion_id.promotionName")->where("product.store_id = ?", $store_id);	
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
	
	public function getProductsByMainProduct($main_product_id){
		return $this->db->table("product")->select("product.*, promotion_id.promotionName, promotion_id.promotionPercentage, promotion_id.promotionMinimalRentingPeriod, promotion_id.promotionValidityPeriod, promotion_id.promotionActive")->where("main_product_id = ?", $main_product_id)->fetchAll();
	}
	
	public function getMainProductsByStorePairs($store_id){
		return $this->db->table("main_product")->select("main_product_id, mainProductName")->where("store_id = ?", $store_id)->fetchPairs("main_product_id", "mainProductName");
	}
	
	public function getProductsByStorePairs($store_id){
		return $this->db->table("product")->select("product_id, productName")->where("store_id = ?", $store_id)->fetchPairs("product_id", "productName");
	}
	
	public function getMainProductSize($main_product_id){
		$r = $this->db->table("main_product")->select("mainProductSize")->where("main_product_id = ?", $main_product_id)->fetch("mainProductSize");	
		return (isset($r["mainProductSize"]))?$r["mainProductSize"]:false;	
	}

}
