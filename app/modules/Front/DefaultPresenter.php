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
	
	public function startup() {
		parent::startup();
		\DependentSelectBox\JsonDependentSelectBox::register('addJSelect');
	}

	public function beforeRender() {
		parent::beforeRender();
		\DependentSelectBox\JsonDependentSelectBox::tryJsonResponse($this /*(presenter)*/);
	}

	public function actionDefault($values = array()){
		if(isset($values['store_id'])&&isset($values['product_id'])){
			$this->quote = $values;
			$this->template->step2 = true;
			$this->template->store = $this->backendModel->getStoreData($values['store_id']);
		}
	}
	
	public function handleOrder($cart_id){
		$this->flashMessage("Your order was successfull. Thank you for trusting us.", "success");
		$this->redirect(":Front:Default:default");
	}
	
	public function actionShowPrices($cart_id){
		if(isset($cart_id)){
			$this->cart_id = $cart_id;
			$this->template->cart_id = $this->cart_id;
			$this->template->cart = $this->backendModel->getCart($this->cart_id);
		}
	}
	
	public function getStoreProducts($form, $dependentSelectBoxName) {
		$select1 = $form["store_id"]->getValue();
		/*Debugger::log($this->backendModel->getProductsByStorePairs($select1));
		Debugger::log($select1);*/
		return $this->backendModel->getProductsByStorePairs($select1);
	}

	protected function createComponentQuoteForm($name){
        $form = new  Form($this, $name);
		$form->getElementPrototype()->class[] = "stdForm";
		
		$form->setMethod('get');
		$store = $form->addSelect('store_id', 'Select your local store', $this->backendModel->getStorePairs());
		$store->setPrompt("select store");
		$store->addRule($form::FILLED, "Please select your local store.");
		$store->setAttribute('class', 'form-control');
			
		$form->addJSelect("product_id", "Select your size", $form["store_id"], array($this, "getStoreProducts"))
			->setPrompt("select size")
			->addRule($form::FILLED, "Please choose your size.")
			->setAttribute('class', 'form-control');

		if($this->isAjax()) {
			$form["product_id"]->addOnSubmitCallback(array($this, "invalidateControl"), "productsSnippet");
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
			->setAttribute('class', 'btn btn-primary quoteFormSubmit ajax');
		
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
	
	public function customerFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			if($form['submit']->isSubmittedBy()){
				$values = $form->values;
				$customer_id = $this->backendModel->saveCustomer($values);
				
				if($customer_id){
					//mame zakaznika, ulozime kosik ale prvni spocitame ceny
					$vals = $this->quote;
					$productData = $this->backendModel->getProductData($vals["product_id"]);
					
					if(isset($vals["leaseFrom"])&&isset($vals["leaseTo"])){
						$months = $this->nb_mois($vals["leaseFrom"], $vals["leaseTo"]);
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
									
									$vals["cartPrice"] = $cartPrice;
									$vals["cartSale"] = $sale;
									$vals["cartPriceTotal"] = $cartPrice - $sale;
								}
								else{
									//cena je jiz konecna
									$vals["cartPrice"] = $cartPrice;
									$vals["cartPriceTotal"] = $cartPrice;								
								}
							}
							else{
								//cena je jiz konecna
								$vals["cartPrice"] = $cartPrice;
								$vals["cartPriceTotal"] = $cartPrice;
							}
						}
						else{
							$this->flashMessage("Error, lease period is smaller than one day, please check filled date range.", "warning");
							$this->redirect("this");
						}
					}
					else{
						$this->flashMessage("Error, lease from and lease to date must be filled, please return to step 1.", "warning");
						$this->redirect("this");
					}
										
					//ulozime kosik
					$vals["customer_id"] = $customer_id;
					$vals["cartAdDate"] = date ("Y-m-d H:i:s");
					$cart_id = $this->backendModel->saveCart($vals);
				}
				/*$this->backendModel->saveQuote($this->quote);
				$this->backendModel->saveCustomer($values);*/
				$this->redirect(":Front:Default:showPrices", $cart_id);
			}
		}
	}
}
