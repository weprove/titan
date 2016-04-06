<?php

namespace Admin\Presenters;

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

class StorePresenter extends \Base\Presenters\BasePresenter
{
	private $store_id;
	private $product_id;
	private $promotion_id;
	public	$main_product_id;
	
	public function actionViewStores(){
		
	}
	
	public function actionAddStore(){
		
	}
	
	public function actionEditStore($store_id){
		$this->store_id = $store_id;
	}
	
	public function actionViewProducts($store_id){
		$this->store_id = $store_id;
		$this->template->store_id = $store_id;
	}
	
	public function actionViewProductCategories($store_id){
		$this->store_id = $store_id;
		$this->template->store_id = $store_id;
	}
	
	public function actionViewSpecialOffers($store_id){
		$this->store_id = $store_id;
		$this->template->store_id = $store_id;
	}
	
	public function actionAddSpecialOffer($store_id){
		$this->store_id = $store_id;
		$this->template->store_id = $store_id;
	}
	
	public function actionEditPromotion($promotion_id){
		$this->promotion_id = $promotion_id;
	}
	
	public function actionAddProduct($store_id){
		$this->store_id = $store_id;
	}
	
	public function actionEditProduct($product_id){
		$this->product_id = $product_id;
	}
	
	protected function createComponentAddSpecialOfferForm($name){
        $form = new  Form($this, $name);
		$form->getElementPrototype()->class[] = "stdForm";
		
		$form->addHidden("promotion_id");
		$form->addHidden("store_id");
		$form->addText('promotionName', 'Special offer name')
			->addRule($form::FILLED, "Please fill special offer name.")
			->setAttribute('class', 'form-control');
			
		$form->addTextarea('promotionDescription', 'Description')
			->addRule($form::FILLED, "Please fill special offer description.")
			->setAttribute('class', 'mceEditor');
			
		$form->addText('promotionPercentage', '% off')
			->addRule($form::FILLED, "Please fill % off.")
			->setAttribute('class', 'form-control');
			
		$form->addText('promotionMinimalRentingPeriod', 'Min. renting period (months)')
			->addRule($form::FILLED, "Please fill Min. renting period (months).")
			->setAttribute('class', 'form-control');
			
		$form->addText('promotionValidityPeriod', 'Validity period (months)')
			->addRule($form::FILLED, "Please fill Min. renting period (months).")
			->setAttribute('class', 'form-control');
			
        $form->onSuccess[] = array($this, 'addSpecialOfferFormSubmitted');
		
		$form->addSubmit('submit', 'Save')
			->setAttribute('class', 'btn btn-primary addSpecialOfferFormSubmit');
			
		if(isset($this->product_id))
			$form->setDefaults($this->backendModel->getProductData($this->product_id));
			
		if(isset($this->promotion_id))
			$form->setDefaults($this->backendModel->getPromotionData($this->promotion_id));
		
		return $form;
	}
	
	public function addSpecialOfferFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			if($form['submit']->isSubmittedBy()){
				$values = $form->values;
				
				if(isset($this->store_id)){
					$values['store_id'] = $this->store_id;
				}

				$r = $this->backendModel->updateSpecialOffer($values);
				
				if($r)
					$this->flashMessage('Special offer succesfully created/updated.', 'success');
				else
					$this->flashMessage('Saving of the data failed.', 'error');	
					
				$this->redirect("this");
			}
		}
	}
	
	protected function createComponentAddProductForm($name){
        $form = new  Form($this, $name);
		$form->getElementPrototype()->class[] = "stdForm";
		
		if(isset($this->product_id))
			$productData = $this->backendModel->getProductData($this->product_id);
			
		$form->addHidden("store_id");
		$form->addHidden("product_id");
		$form->addText('productName', 'Product name')
			->addRule($form::FILLED, "Please fill product name.")
			->setAttribute('class', 'form-control');
			
		$form->addTextarea('productDescription', 'Description')
			->addRule($form::FILLED, "Please fill product description.")
			->setAttribute('class', 'mceEditor');
			
		$form->addText('productSize', 'Size')
			->setAttribute('class', 'form-control');
			
		$form->addText('productPricePerMonth', 'Price per month')
			->addRule($form::FILLED, "Please fill product price per month.")
			->setAttribute('class', 'form-control');
			
		$store_id = (isset($productData->store_id))?$productData->store_id:$this->store_id;
		$form->addSelect('main_product_id', 'Product category', $this->backendModel->getProductCategoryPairs($store_id))
			->setPrompt('Please select product category')
			->addRule($form::FILLED, "Please select product category (will display in quote form).")
			->setAttribute('class', 'form-control');
			
		$form->addSelect('promotion_id', 'Select special offer', $this->backendModel->getStoreSpecialOffers($store_id))
			->setPrompt('Select special offer')
			->setAttribute('class', 'form-control');
			
        $form->onSuccess[] = array($this, 'addProductFormSubmitted');
		
		$form->addSubmit('submit', 'Save')
			->setAttribute('class', 'btn btn-primary addProductFormSubmit');
			
		if(isset($this->product_id))
			$form->setDefaults($productData);
		
		return $form;
	}
	
	public function addProductFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			if($form['submit']->isSubmittedBy()){
				$values = $form->values;
				
				if(isset($this->store_id)){
					$values['store_id'] = $this->store_id;
				}

				$r = $this->backendModel->updateProduct($values);
				
				if($r)
					$this->flashMessage('Product succesfully created/updated.', 'success');
				else
					$this->flashMessage('Saving of the data failed.', 'error');	
					
				$this->redirect("this");
			}
		}
	}
	
	protected function createComponentAddStoreForm($name){
        $form = new  Form($this, $name);
		$form->getElementPrototype()->class[] = "stdForm";
		
		$form->addHidden("store_id");
		
		$form->addText('storeName', 'Store name')
			->addRule($form::FILLED, "Please fill store name.")
			->setAttribute('class', 'form-control');
			
		$form->addTextarea('storeDescription', 'Description')
			->addRule($form::FILLED, "Please fill store description.")
			->setAttribute('class', 'mceEditor');
			
		$form->addText('storePhone', 'Phone')
			->addRule($form::FILLED, "Please fill phone.")
			->setAttribute('class', 'form-control');
			
		$form->addText('storeEmail', 'Email')
			->addRule($form::FILLED, "Please fill store email.")
			->setAttribute('class', 'form-control');
			
		$form->addTextarea('storeAddress', 'Address')
			->addRule($form::FILLED, "Please fill store address.")
			->setAttribute('class', 'mceEditor');
			
		$form->addTextarea('storeOpenHours', 'Open hours')
			->addRule($form::FILLED, "Please fill store open hours.")
			->setAttribute('class', 'mceEditor');
			
        $form->onSuccess[] = array($this, 'addStoreFormSubmitted');
		
		$form->addSubmit('submit', 'Save')
			->setAttribute('class', 'btn btn-primary addStoreFormSubmit');
			
		if(isset($this->store_id)){
			$form->setDefaults($this->backendModel->getStoreData($this->store_id));
		}
		
		return $form;
	}
	
	public function addStoreFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			if($form['submit']->isSubmittedBy()){
				$values = $form->values;
				
				$r = $this->backendModel->updateStore($values);
				
				if($r)
					$this->flashMessage('Store succesfully created/updated.', 'success');
				else
					$this->flashMessage('Saving of the data failed.', 'error');	
					
				$this->redirect("this");
			}
		}
	}
	
	protected function createComponentStoresGrid($name) {
		$grid = new Grid($this, $name);
		
		$grid->model = ($this->user->isInRole("admin"))?$this->backendModel->getStores():$this->backendModel->getStores($this->assignedStores);
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('store_id');
		
		$grid->addColumnText('storeName', 'Store name')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('storePhone', 'Phone')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('storeEmail', 'Email')
			->setSortable()
            ->setFilterText();
			
		$grid->addActionHref('editStore', 'Edit', 'editStore')
            ->setIcon('pencil');
			
		$grid->addActionHref('editProducts', 'View products', 'viewProducts')
            ->setIcon('th-large');
			
		$grid->addActionHref('editSpecialOffers', 'Manage special offers', 'viewSpecialOffers')
            ->setIcon('tags');
			
		$grid->addActionHref('viewCategories', 'Edit product categories', 'viewProductCategories')
            ->setIcon('check');

        /*$grid->addActionHref('delete', 'Smazat', 'deleteCadastralOwner!')
            ->setIcon('trash')
            ->setConfirm(function($item) {
                return "Opravdu chcete smazat položku: {$item->owner_id}?";
			});*/
			
		$fName = "stores";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}
	
	protected function createComponentSpecialOffersGrid($name) {
		$grid = new Grid($this, $name);
		$grid->model = $this->backendModel->getSpecialOffers($this->store_id);
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('promotion_id');
		
		$grid->addColumnText('promotionName', 'Special offer name')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('promotionDescription', 'Description')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('promotionPercentage', '% off')
			->setSortable()
            ->setFilterText();
		
		$grid->addColumnText('promotionMinimalRentingPeriod', 'Min. renting period (months)')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('promotionValidityPeriod', 'Validity period (months)')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('promotionActive', 'Active')
			->setSortable()
            ->setFilterText();
			
		$grid->addActionHref('editPromotion', 'Edit', 'editPromotion')
            ->setIcon('pencil');
			
		/*$grid->addActionHref('editProducts', 'View products', 'viewProducts')
            ->setIcon('th-large');*/

        /*$grid->addActionHref('delete', 'Smazat', 'deleteCadastralOwner!')
            ->setIcon('trash')
            ->setConfirm(function($item) {
                return "Opravdu chcete smazat položku: {$item->owner_id}?";
			});*/
			
		$fName = "stores";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}
	
	public function actionAddProductCategory($store_id){
		$this->store_id = $store_id;
	}
	
	public function actionEditProductCategory($main_product_id){
		$this->main_product_id = $main_product_id;
	}
	
	protected function createComponentAddProductCategoryForm($name){
        $form = new  Form($this, $name);
		$form->addHidden("main_product_id");
		$form->getElementPrototype()->class[] = "stdForm";
		$form->addText('mainProductName', 'Category name (300 sq. ft. etc)');
		$form->addText('mainProductSize', 'Size (in ft, only number allowed!)');
		
		if(isset($this->main_product_id)){
			$form->setDefaults($this->backendModel->getProductCategoryData($this->main_product_id));
		}
	
        $form->onSuccess[] = array($this, 'addProductCategoryFormSubmitted');
		
		$form->addSubmit('submit', 'Save')
			->setAttribute('class', 'btn btn-primary addProductCategoryFormSubmitted');
		
		return $form;
	}
	
	public function addProductCategoryFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			if($form['submit']->isSubmittedBy()){
				$values = $form->values;
				$values['user_id'] = $this->user->identity->id;
				if(isset($this->store_id)) $values['store_id'] = $this->store_id;
				
				$r = $this->backendModel->updateProductCategory($values);
				
				if($r)
					$this->flashMessage('Product category succesfully updated.', 'success');
				else
					$this->flashMessage('Saving of the data failed.', 'error');	
					
				$this->redirect("this");
			}
		}
	}
	
	protected function createComponentProductCategoriesGrid($name) {
		$grid = new Grid($this, $name);
		$grid->model = $this->backendModel->getProductCategories($this->store_id);
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('main_product_id');
		
		$grid->addColumnText('mainProductName', 'Name')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('mainProductSize', 'Size (ft)')
			->setSortable()
            ->setFilterText();
			
		$grid->addActionHref('editProductCategory', 'Edit', 'editProductCategory')
            ->setIcon('pencil');
			
		$fName = "categories_grid";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}

	public function actionAddProductSpecialOffer($store_id, $product_id){
		$this->store_id = $store_id;
		$this->product_id = $product_id;
		$this->template->product_id = $this->product_id;
	}
	
	protected function createComponentProductsGrid($name) {
		$that = $this;
		$grid = new Grid($this, $name);
		$grid->model = $this->backendModel->getProducts($this->store_id);
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('product_id');
		
		//add store?
		
		$grid->addColumnText('productName', 'Product name')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('productDescription', 'Description')
			->setSortable()
            ->setFilterText();
			
		/*$grid->addColumnText('productVat', 'VAT')
			->setSortable()
            ->setFilterText();*/
			
		$grid->addColumnText('productPricePerMonth', 'Price per month')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('promotionName', 'Special offer')
			->setSortable()
            ->setFilterText();
			
		$grid->addActionHref('editProduct', 'Edit product', 'editProduct')
            ->setIcon('pencil');
			
		/*$grid->addActionHref('addPromotion', 'Add special offer', 'addProductSpecialOffer')
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link("addProductSpecialOffer", $that->store_id, $item->product_id))->class("btn btn-primary")->setHtml("<i class='fa fa-tag'></i>");
				return $el;
			});*/
			
		$fName = "stores";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}
	
	protected function createComponentAddProductSpecialOfferForm($name){
        $form = new  Form($this, $name);
		$form->getElementPrototype()->class[] = "stdForm";
		
		$form->addSelect('promotion_id', 'Select special offer', $this->backendModel->getStoreSpecialOffers($this->store_id))
			->addRule($form::FILLED, "Please select special offer.")
			->setAttribute('class', 'form-control');
			
        $form->onSuccess[] = array($this, 'addProductSpecialOfferFormSubmitted');
		
		$form->addSubmit('submit', 'Save')
			->setAttribute('class', 'btn btn-primary addProductSpecialOfferFormSubmit');
		
		return $form;
	}
	
	public function addProductSpecialOfferFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			if($form['submit']->isSubmittedBy()){
				$values = $form->values;
				
				$r = $this->backendModel->updateProductSpecialOffer($values, $this->product_id);
				
				if($r)
					$this->flashMessage('Product succesfully updated.', 'success');
				else
					$this->flashMessage('Saving of the data failed.', 'error');	
					
				$this->redirect("this");
			}
		}
	}
	
	/*public function actionDefault($values = array()){
		if(isset($values['store_id'])&&isset($values['product_id'])){
			$this->template->step2 = true;
		}
	}
	
	protected function createComponentQuoteForm($name){
        $form = new  Form($this, $name);
		$form->getElementPrototype()->class[] = "stdForm";
		
		$form->setMethod('get');
		$form->addSelect('store_id', 'Select your local store', array(1 => "dummy store"))
			->setPrompt("Choose your local store")
			->addRule($form::FILLED, "Please select your local store.")
			->setAttribute('class', 'form-control');
			
		$form->addSelect('product_id', 'Select your size', array(1 => "dummy product"))
			->setPrompt("Choose your size")
			->addRule($form::FILLED, "Please choose your size.")
			->setAttribute('class', 'form-control');
			
        $form->onSuccess[] = array($this, 'quoteFormSubmitted');
		
		$form->addSubmit('submit', 'Continue')
			->setAttribute('class', 'btn btn-primary quoteFormSubmit');
		
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
		$form->addSelect('salutation_id', '', $this->userModel->getSalutationPairs());
		$form->addText('customerFirstname', 'Firstname');
		$form->addText('customerSurname', 'Surname');
		$form->addText('customerEmail', 'Email')
			->addRule($form::EMAIL, "Please fill valid email address.")
			->addRule($form::FILLED, "Please fill your email.");
		$form->addText('customerPhone', 'Phone')
			->addRule($form::FILLED, "Please fill your phone.");
			
			
        $form->onSuccess[] = array($this, 'customerFormSubmitted');
		
		$form->addSubmit('submit', 'Show prices')
			->setAttribute('class', 'btn btn-primary customerFormSubmit');
		
		return $form;
	}
	
	public function customerFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			if($form['submit']->isSubmittedBy()){
				$values = $form->values;
				$this->redirect("this");
			}
		}
	}*/
}
