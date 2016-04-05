<?php

namespace Front\Presenters;

use Nette\Application\UI\Form,
	Grido\Grid,
	Grido\Components\Filters\Filter,
	Grido\Translations\FileTranslator,
	Nette\Application\Responses\JsonResponse,
	Nette\Application\Responses\TextResponse,
	Nette\Utils\Html,
	Nette\Mail\Message,
	IPub\VisualPaginator\Components as VisualPaginator,
	Nette\Diagnostics\Debugger;

class DefaultPresenter extends \Base\Presenters\BasePresenter
{
	public $quote;
	public $cart_id;
	public $cart;
	public $store_id;
	public $prev_main_product_id;
	
	public function startup() {
		parent::startup();
		\DependentSelectBox\JsonDependentSelectBox::register('addJSelect');
	}

	public function beforeRender() {
		parent::beforeRender();
		\DependentSelectBox\JsonDependentSelectBox::tryJsonResponse($this /*(presenter)*/);
	}
	
	public function actionViewSizeEstimator(){
	
	}
	
	public function handleShowBiggerSize($cart_id, $previousSize){
		$new_main_product_id = $this->backendModel->getBiggerSize($previousSize, $this->store_id);
		
		if($new_main_product_id)
			$this->redirect("Default:showPrices", $cart_id, $new_main_product_id);
	}
	
	public function handleShowSmallerSize($cart_id, $previousSize){
		$new_main_product_id = $this->backendModel->getSmallerSize($previousSize, $this->store_id);

		if($new_main_product_id)
			$this->redirect("Default:showPrices", $cart_id, $new_main_product_id);
	}

	public function distance($lat1, $lon1, $lat2, $lon2, $unit) {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
		  return ($miles * 1.609344);
		} else if ($unit == "N") {
		  return ($miles * 0.8684);
		} else {
		  return $miles;
		}
	}

	public function actionDefault($values = array()){
		if(isset($values['psc'])){
			//mame psc
			$url ="http://maps.googleapis.com/maps/api/geocode/xml?address=".$values['psc']."&sensor=false";
			$result = simplexml_load_file($url);
			$lat1 = $result->result->geometry->location->lat;
			$lon1 = $result->result->geometry->location->lng;
			
			$stores = $this->backendModel->getStores()->fetchAll();
			$distances = array();
			
			if(count($stores)>0){
				foreach($stores AS $store){
					$distances[$store->store_id] = $this->distance((string)$lat1, (string)$lon1, $store->lat, $store->lon, 'K');		
					//echo $this->distance($this->toFloat($lat1), $this->toFloat($lon1), $store->lat, $store->lon, 'K');
				}
			}
			
			//Debugger::dump($distances);
			
			if(count($distances)>0){
				//vybere pobocku nejblizeme a nastavime formular
				$chosenOne = array_keys($distances, min($distances));
				$this["quoteForm"]->setDefaults(array("store_id"=>end($chosenOne)));
			}
		}
		if(isset($values['store_id'])&&isset($values['main_product_id'])){
			$this->quote = $values;
			$this->template->step2 = true;
			$this->template->store = $this->backendModel->getStoreData($values['store_id']);
		}
	}
	
	public function handleOrder($cart_id, $product_id, $offer){
		//prvni zjistime ceny
		$pricesArray  = array();
		$this->cart = $this->backendModel->getCart($cart_id);
		$product = $this->backendModel->getProductData($product_id);
		
		$pricesArray = $this->countProductPrices($product, $this->cart->cartLeaseInMonths);
		
		//aktualizujeme kosik
		$cart = array(
			"cart_id" => $cart_id,
			"product_id" => $product_id
		);
		
		if($offer == 1){
			$cart["cartPrice"] = $pricesArray['cartPrice'];
			$cart["cartSale"] = $pricesArray['cartSale'];
			$cart["cartPriceTotal"] = $pricesArray['cartPriceTotal'];
		}
		elseif($offer == 2){
			$cart["cartPrice"] = $pricesArray['cartPrice'];
			$cart["cartSale"] = $pricesArray['cartSale'];
			$cart["cartPriceTotal"] = $pricesArray['cartPriceTotal2'];		
		}
		
		
		$this->backendModel->saveCart($cart);
		
		$order = array(
			"cart_id" => (INT)$cart_id,
			"order_state_id" => 3,
			"orderAdDate" => date("Y-m-d H:i:s")
		);
		
		$this->backendModel->saveOrder($order);
		
			/*//zasleme email
			$email = $this->cart->customerEmail;
				
			//mail pro zaslání dodatečných informací
			$mail = new Message;
			$mail->setFrom("noreply@titanstorage.co.uk");
			$mail->addTo($email);
			$mail->setSubject('Titan Storage');
			$mail->setHtmlBody("
				$values[templateHtml]
			"); 
                
			try{
				$this->mailer->send($mail);      
				$this->flashMessage('Email sent.', 'success');
                    
      		} catch (\Exception $e) {
				$this->flashMessage("ERROR: sending of email failed.", 'error');
			}*/
		
		$this->flashMessage("You have booked a ".$product->productName." unit from ".date("d/m/y", strtotime($this->cart->leaseFrom))." to ".date("d/m/y", strtotime($this->cart->leaseTo)).". You will shortly receive a confirmation email.", "success");
		$this->redirect(":Front:Default:default");
	}
	
	public function actionShowPrices($cart_id, $new_main_product_id = NULL){
		if(isset($cart_id)){
			$this->cart_id = $cart_id;
			$this->template->cart_id = $this->cart_id;		
			$this->cart = $this->backendModel->getCart($this->cart_id);
			$this->template->cart = $this->cart;
			$this->store_id = $this->cart->store_id;
			
			$new_main_product_size = 0;
			
			if($new_main_product_id){
				$new_main_product_size = $this->backendModel->getMainProductSize($new_main_product_id);
			}
			$this->template->prevSize = ($new_main_product_id)?$new_main_product_size:$this->cart->mainProductSize;
			
			$main_product_id = ($new_main_product_id)?$new_main_product_id:$this->cart->main_product_id;
			
			if($main_product_id){	
				//ziskame prvni prostredni produkt
				$products = array();
				$subProducts = array();
				$middle = $this->backendModel->getMiddleProductByMainProduct($main_product_id, $this->cart->cartLeaseInMonths);	
				$subProducts[] = $middle;
				//Debugger::dump($middle);
				
				$prev_main_product_id = $this->backendModel->getSmallerSize($middle->productSizeInSqFt, $this->store_id);
				$next_main_product_id = $this->backendModel->getBiggerSize($middle->productSizeInSqFt, $this->store_id);
				
				$prev = $this->backendModel->getMiddleProductByMainProduct($prev_main_product_id, $this->cart->cartLeaseInMonths);	
				array_unshift ($subProducts, $prev);
				
				$next = $this->backendModel->getMiddleProductByMainProduct($next_main_product_id, $this->cart->cartLeaseInMonths);	
				array_push ($subProducts, $next);
				//jak ted kurva ziskam vrchni a spodni produkt?
				
				//$subProducts = $this->backendModel->getProductsByMainProduct($main_product_id);
				
				if(count($subProducts)>0){
					$pricesArray = array();
					
					foreach($subProducts AS $key => $product){
						$pricesArray = $this->countProductPrices($product, $this->cart->cartLeaseInMonths);
						
						$products[] = array(
							"product_id" => $product->product_id,
							"productName" => $product->productName,
							"productDescription" => $product->productDescription,
							"productPricePerMonth" => $product->productPricePerMonth,
							"productStandartPricePerWeek" => round($product->productStandartPricePerWeek, 2),
							"productTotal" => $product->productTotal,
							"productOccupancy" => $product->productOccupancy,
							"productVacancy" => $product->productVacancy,
							"productUnitType" => $product->productUnitType,
							"promotionName" => $product->promotionName,
							"promotionActive" => $product->promotionActive,
							"productVacancy" => $product->productVacancy,
							"productPricePerMonthSale" => round($pricesArray['cartPriceTotal']/$this->cart->cartLeaseInMonths, 2),
							"productPricePerMonthSale2" => round($pricesArray['cartPriceTotal2']/$this->cart->cartLeaseInMonths, 2),
							"standartTotalPrice" => round($product->productPricePerMonth*$this->cart->cartLeaseInMonths, 2),
							"cartSaleActive" => $pricesArray['cartSaleActive'],
							"cartPrice" => round($pricesArray['cartPrice'], 2),
							"cartSale" => round($pricesArray['cartSale'], 2),
							"cartPriceTotal" => round($pricesArray['cartPriceTotal'], 2),
							"cartPriceTotal2" => round($pricesArray['cartPriceTotal2'], 2),
							"cartSaleActive2" => $pricesArray['cartSaleActive2']
						);
					}
				}
				
				$this->template->products = $products;
				//Debugger::dump($products); die();
			}
			
		}
	}
	
	public function getStoreProducts($form, $dependentSelectBoxName) {
		$select1 = $form["store_id"]->getValue();
		/*Debugger::log($this->backendModel->getProductsByStorePairs($select1));
		Debugger::log($select1);*/
		return $this->backendModel->getMainProductsByStorePairs($select1);
	}

	protected function createComponentQuoteForm($name){
        $form = new  Form($this, $name);
		$form->getElementPrototype()->class[] = "stdForm";
		
		$form->setMethod('get');
		$form->addText('postalCode', 'Postal code')
			->setAttribute('placeholder', 'Your postcode')
			->setAttribute('class', 'form-control');
		$store = $form->addSelect('store_id', 'Select your local store', $this->backendModel->getStorePairs());
		$store->setPrompt("select store");
		$store->addRule($form::FILLED, "Please select your local store.");
		$store->setAttribute('class', 'form-control');
			
		$form->addJSelect("main_product_id", "Select your size", $form["store_id"], array($this, "getStoreProducts"))
			->setPrompt("select size")
			->addRule($form::FILLED, "Please choose your size.")
			->setAttribute('class', 'form-control');

		if($this->isAjax()) {
			$form["main_product_id"]->addOnSubmitCallback(array($this, "invalidateControl"), "productsSnippet");
		}
		
		$form->addText('leaseFrom', 'Lease from')
			->addRule($form::FILLED, "Please select 'Lease from' field")
			->setAttribute('placeholder', 'from')
			->setAttribute('class', 'form-control');
			
		$form->addText('leaseTo', 'Lease to')
			->addRule($form::FILLED, "Please select 'Lease to' field")
			->setAttribute('placeholder', 'to')
			->setAttribute('class', 'form-control');
			
		/*$form->addSelect('product_id', 'Select your size', array(1 => "dummy product"))
			->setPrompt("Choose your size")
			->addRule($form::FILLED, "Please choose your size.")
			->setAttribute('class', 'form-control');*/
			
        $form->onSuccess[] = array($this, 'quoteFormSubmitted');
		$form->addSubmit('submit', 'Continue')
			->setAttribute('class', 'btn btn-primary quoteFormSubmit ajax'); //ajax!!
		
		return $form;
	}
	
	public function quoteFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			if($form['submit']->isSubmittedBy()){
				$values = $form->values;
				$this->redirect("this", $values);
			}
		}
	}
	
	protected function createComponentCustomerForm($name){
        $form = new  Form($this, $name);
		$form->getElementPrototype()->class[] = "stdForm";
		$form->addSelect('salutation_id', 'Title', $this->userModel->getSalutationPairs())
			->getControlPrototype()->class("form-control");
		$form->addText('customerFirstname', 'Firstname')
			->getControlPrototype()->class("form-control");
		$form->addText('customerSurname', 'Surname')
			->getControlPrototype()->class("form-control");
		$form->addText('customerEmail', 'Email')
			->addRule($form::EMAIL, "Please fill valid email address.")
			->addRule($form::FILLED, "Please fill your email.")
			->getControlPrototype()->class("form-control");
		$form->addText('customerPhone', 'Phone')
			->addRule($form::FILLED, "Please fill your phone.")
			->getControlPrototype()->class("form-control");
			
			
        $form->onSuccess[] = array($this, 'customerFormSubmitted');
		
		$form->addSubmit('submit', 'Show prices')
			->setAttribute('class', 'btn btn-primary customerFormSubmit');
		
		return $form;
	}
	
	public function nb_mois($date1, $date2)
	{
		$begin = new \DateTime( $date1 );
		$end = new \DateTime( $date2 );
		//$end = $end->modify( '+1 month' );

		$interval = \DateInterval::createFromDateString('1 day');

		$period = new \DatePeriod($begin, $interval, $end);
		$counter = 0;
		foreach($period as $dt) {
			$counter++;
		}

		return $counter/30;
	}
	
	public function countProductPrices($productData, $cartLeaseInMonths){
		$vals = array();
		$vals["cartPrice"] = 0;
		$vals["cartSale"] = 0;
		$vals["cartPriceTotal"] = 0;
		$vals["cartSaleActive"] = false;
		
		//second offer
		//$vals["cartSale2"] = 0;
		$vals["cartPriceTotal2"] = 0;
		$vals["cartSaleActive2"] = false;
		
		$months = $cartLeaseInMonths;
		
		if($months > 0){
			//doba zapujceni je nenulova, muzeme spocitat cenu
			$cartPrice = $months*$productData->productPricePerMonth;
			if($productData->promotionActive == '1'){
				//spocitame slevu
				$sale = 0;
				$salePerMonth = 0;
				
				//prvni ale zjistime zda jsme dodrzeli min dobu pro aktivaci slevy
				if($months >= $productData->promotionMinimalRentingPeriod){
					//sleva aktivovana
					
					//kolik bude sleva na jeden mesic
					$salePerMonth = ($productData->promotionPercentage/100)*$productData->productPricePerMonth;
					
					
					if($months >= $productData->promotionValidityPeriod){
						//sleva bude rovna max sleve
						$sale = $productData->promotionValidityPeriod*$salePerMonth;	
					}
					elseif($months < $productData->promotionValidityPeriod){
						//sleva bude podilove mensi
						$fullSale = $productData->promotionValidityPeriod*$salePerMonth;
						
						$sale = ($months/$productData->promotionValidityPeriod)*$fullSale;
					}
					
					$vals["cartSaleActive"] = true;
					$vals["cartPrice"] = $cartPrice;
					$vals["cartSale"] = $sale;
					$vals["cartPriceTotal"] = $cartPrice - $sale;
				}
				else{
					//cena je jiz konecna
					$vals["cartSaleActive"] = false;
					$vals["cartPrice"] = $cartPrice;
					$vals["cartSale"] = 0;
					$vals["cartPriceTotal"] = $cartPrice;								
				}
			}
			else{
				//cena je jiz konecna
				$vals["cartSaleActive"] = false;
				$vals["cartPrice"] = $cartPrice;
				$vals["cartSale"] = 0;
				$vals["cartPriceTotal"] = $cartPrice;
			}
			
			//spocitame jeste slevu pro move in
			if($months >= 2){
				$sale = $cartPrice - $productData->productPricePerMonth + 1;
				$vals["cartPriceTotal2"] = $sale;
				$vals["cartSaleActive2"] = true;
			}
			else{
				$vals["cartPriceTotal2"] = $cartPrice;
				$vals["cartSaleActive2"] = false;
			}
		}
		
		
		return $vals;
	}
	
	public function customerFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			if($form['submit']->isSubmittedBy()){
				$values = $form->values;
				$customer_id = $this->backendModel->saveCustomer($values);
				
				if($customer_id){
					//mame zakaznika, ulozime kosik ale prvni spocitame ceny
					$vals = $this->quote;
					unset($vals["postalCode"]);
					if(!isset($vals["leaseFrom"])||!isset($vals["leaseTo"])){
						$this->flashMessage("Error, lease from and lease to date must be filled, please return to step 1.", "warning");
						$this->redirect("this");
					}
					else{
						$months = $this->nb_mois($vals["leaseFrom"], $vals["leaseTo"]);
						if($months <= 0){
							$this->flashMessage("Error, lease period is smaller than one day, please check filled date range.", "warning");
							$this->redirect("this");
						}
						else{
							$vals["cartLeaseInMonths"] = $months;
						}
					}
										
					//ulozime kosik
					$vals["leaseFrom"] = date("Y-m-d H:i:s", strtotime($vals["leaseFrom"]));
					$vals["leaseTo"] = date("Y-m-d H:i:s", strtotime($vals["leaseTo"]));
					$vals["customer_id"] = $customer_id;
					$vals["cartAdDate"] = date ("Y-m-d H:i:s");
					$cart_id = $this->backendModel->saveCart($vals);
					
					
					$tpl = $this->createTemplate();
					$tpl->setFile(__DIR__ ."/templates/automaticEmail1.latte");
					$tpl->name =  $values["customerFirstname"];
					$tpl->surname = $values["customerSurname"];
					
					$email = $values["customerEmail"];
						
					//mail pro zaslání dodatečných informací
					$mail = new Message;
					$mail->setFrom("noreply@titanstorage.co.uk");
					$mail->addTo($email);
					$mail->setSubject('Titan Storage');
					$mail->setHtmlBody($tpl->__toString()); 
						
					try{
						$this->mailer->send($mail);      
							
					} catch (\Exception $e) {
					}
				}
				/*$this->backendModel->saveQuote($this->quote);
				$this->backendModel->saveCustomer($values);*/
				$this->redirect(":Front:Default:showPrices", $cart_id);
			}
		}
	}
}
