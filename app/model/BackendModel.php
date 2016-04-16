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
	/*public function getStoreData($store_id){
		return $this->db->table("store")->select("*")->where("store_id = ?", $store_id)->fetch();
	}*/
	public function assignStores($stores, $user_id){
		$this->db->query("DELETE FROM assigned_store WHERE user_id = ?", $user_id);
		
		if(count($stores)>0)
			return $this->db->query("INSERT INTO assigned_store", $stores);
	}

	public function getAssignedStores($user_id){	
		return $this->db->table("assigned_store")->select("store_id")->where("user_id = ?", $user_id)->fetchAll();
	}
	
	public function getAssignedStorePairs($user_id){	
		return $this->db->table("assigned_store")->select("assigned_store_id, store_id")->where("user_id = ?", $user_id)->fetchPairs("assigned_store_id", "store_id");
	}
	
	public function getUsers(){
		return $this->db->table("user")->select("user.*, role_id.roleName");
	}
	
	public function getProductCategoryPairs($store_id){
		return $this->db->table("main_product")->select("main_product_id, mainProductName")->where("main_product.store_id = ?", $store_id)->fetchPairs("main_product_id", "mainProductName");		
	}
	
	public function getProductCategoryData($main_product_id){
		return $this->db->table("main_product")->select("main_product.*")->where("main_product_id = ?", $main_product_id)->fetch();
	}
	
	public function getSentEmail($sent_email_id){
		$r = $this->db->table("sent_email")->select("sent_email_id, sent_email_content")->fetch("sent_email_content");
		return (isset($r['sent_email_content']))? $r['sent_email_content']:"";
	}
	
	public function saveSentEmail($arr){
		return $this->db->query("INSERT INTO sent_email", $arr);
	}
	
	public function getTemplate($template_id){
		return $this->db->table("template")->select("template.*")->where("template_id = ?", $template_id)->fetch();
	}
	
	public function getTemplates(){
		return $this->db->table("template")->select("template.*")->fetchAll();
	}
	
	public function saveTemplate($values){
		$str = "";
		
		forEach($values as $key => $value){
			$str .= " $key = VALUES($key),";
		}
		
		$str = substr($str, 0, -1);
		
		
		$r = $this->db->query("INSERT INTO template ", $values, " ON DUPLICATE KEY UPDATE $str");
		$insId =  $this->db->getInsertId();
		
		return ($insId)?$insId:false;
	}
	
	public function changeOrdersState($state, $ids){
		return $this->db->query("UPDATE `order` SET order_state_id = ? WHERE order_id IN(?)", $state, $ids);
	}
	
	public function getMiddleProductByMainProduct($main_product_id, $months = NULL){
		//if months < minreting pro slevu tak NESPLNENO
		return $this->db->table("product")->select("((7/30)*product.productPricePerMonth) AS productStandartPricePerWeek, (promotion_id.promotionPercentage*promotion_id.promotionValidityPeriod) AS promoIndex, product.*, promotion_id.promotionName, promotion_id.promotionPercentage, promotion_id.promotionMinimalRentingPeriod, promotion_id.promotionValidityPeriod, promotion_id.promotionActive, main_product_id.mainProductSize")
		->order("promoIndex DESC, product.productPricePerMonth ASC")->limit(1)->where("(promotion_id.promotionMinimalRentingPeriod <= ? OR product.productPricePerMonth =  ( SELECT MIN(productPricePerMonth) FROM product WHERE main_product_id = ?)) AND main_product_id = ?", $months, $main_product_id, $main_product_id)->fetch();
	}
	
	public function getFullCart($cart_id){
		return $this->db->table("cart")->select("cart.*, customer_id.*, product_id.*, product_id.promotion_id.promotionName,  main_product_id.mainProductName")->where("cart.cart_id = ?", $cart_id)->fetch();
	}
	
	public function getLeftCarts($assigned_stores = NULL){
		$r = $this->db->table("cart");
		$r->select("cart.*, main_product_id.mainProductName, customer_id.*");
		$r->where(":order(cart_id).order_id IS NULL");
		
		if($assigned_stores){
			$r->where("cart.store_id IN(?)", $assigned_stores);
		}
		
		return $r->fetchAll();
	}
	
	public function getSentEmails($assigned_stores = NULL){
		$selection = $this->db->table("sent_email");
		$selection->select("sent_email.sent_email_id, cart_id.*, cart_id.main_product_id.mainProductName, cart_id.customer_id.*");
		
		if($assigned_stores)
			$selection->where("cart_id.store_id IN(?)", $assigned_stores);
		return $selection;
	}
	
	public function deleteUser($user_id){
		return $this->db->query("DELETE FROM `user` WHERE user_id = ?", $user_id);
	}
	
	public function deleteOrder($order_id){
		return $this->db->query("DELETE FROM `order` WHERE order_id = ?", $order_id);
	}
	
	public function deleteCart($cart_id){
		return $this->db->query("DELETE FROM cart WHERE cart_id = ?", $cart_id);
	}
	
	public function getOrder($order_id){
		return $this->db->table("order")->select("order.order_id AS orderId, order.orderAdDate, order.order_state_id, order_state_id.orderStateName, cart_id.*, cart_id.customer_id.*, cart_id.product_id.*, cart_id.product_id.promotion_id.promotionName, order.orderInternalNote, order.order_id")->where("order.order_id = ?", $order_id)->fetch();
	}
	
	public function getOrders(){
		return $this->db->table("order")->select("order.order_id AS orderId, order.orderAdDate, order.order_state_id, order_state_id.orderStateName, cart_id.*, cart_id.customer_id.*, cart_id.product_id.*, order.order_id")->fetchAll();
	}
	
	public function getOrdersSelection($assigned_stores = NULL){
		$selection = $this->db->table("order");
		$selection->select("order.order_id AS orderId, order.orderAdDate, order.order_state_id, order_state_id.orderStateName, cart_id.*, cart_id.customer_id.*, cart_id.product_id.*, order.order_id");
		if($assigned_stores){
			$selection->where("cart_id.store_id IN(?)", $assigned_stores);
		}
		return $selection;
	}
	
	public function getBiggerSize($prevSize, $store_id){
		$r = $this->db->table("main_product")->select("main_product.main_product_id")->where("main_product.mainProductSize > ? AND main_product.store_id = ?", $prevSize, $store_id)->order("mainProductSize ASC")->limit(1)->fetch();	
		return  (isset($r["main_product_id"]))?$r["main_product_id"]:false;
	}
	
	public function getSmallerSize($prevSize, $store_id){
		$r = $this->db->table("main_product")->select("main_product.main_product_id")->where("main_product.mainProductSize < ? AND main_product.store_id = ?", $prevSize, $store_id)->order("mainProductSize DESC")->limit(1)->fetch();	
		return  (isset($r["main_product_id"]))?$r["main_product_id"]:false;	
	}
	
	public function getCart($cart_id){
		return $this->db->table("cart")->select("cart.*, main_product_id.mainProductSize")->where("cart_id = ?", $cart_id)->fetch();
	}
	
	public function getCartWDetails($cart_id){
		return $this->db->table("cart")->select("cart.cart_id, cart.cartLeaseInMonths, cart.cartPriceTotal, cart.leaseFrom, cart.leaseTo, main_product_id.mainProductSize, product_id.productName, product_id.productDescription, customer_id.customerEmail")->where("cart_id = ?", $cart_id)->fetch();
	}
	
	public function saveCart($values){
		$str = "";
		
		forEach($values as $key => $value){
			$str .= " $key = VALUES($key),";
		}
		
		$str = substr($str, 0, -1);
		
		
		$r = $this->db->query("INSERT INTO cart ", $values, " ON DUPLICATE KEY UPDATE $str");
		$insId =  $this->db->getInsertId();
		
		return ($insId)?$insId:false;
	}
	
	public function saveOrder($values){
		$str = "";
		
		forEach($values as $key => $value){
			$str .= " $key = VALUES($key),";
		}
		
		$str = substr($str, 0, -1);
		
		
		$r = $this->db->query("INSERT INTO `order` ", $values, " ON DUPLICATE KEY UPDATE $str");
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
	
	public function getOrderStatePairs(){
		return $this->db->table("order_state")->select("order_state_id, orderStateName")->fetchPairs("order_state_id", "orderStateName");		
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
		return $this->db->table("product")->select("*, store_id.storeName, product.promotion_id, promotion_id.promotionPercentage, promotion_id.promotionMinimalRentingPeriod, promotion_id.promotionValidityPeriod, promotion_id.promotionActive")->where("product_id = ?", $product_id)->fetch();
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
	
	public function getProductCategories($store_id){
		$selection = $this->db->table("main_product")->select("main_product.*")->where("main_product.store_id = ?", $store_id);	
		return $selection;
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
	
	public function updateProductCategory($values){		
		$str = "";
		
		forEach($values as $key => $value){
			$str .= " $key = values($key),";
		}
		
		$str = substr($str, 0, -1);
		
		$r = $this->db->query("INSERT INTO main_product ", $values," ON DUPLICATE KEY UPDATE $str");
		
		return ($r)?true:false;
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

	public function getStores($assigned_stores = NULL){
		$r = $this->db->table("store");
		$r->select("*");
		
		if($assigned_stores){
			$r->where("store_id IN(?)", $assigned_stores);
		}
		
		return $r;
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
