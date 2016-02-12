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
	
	public function renderViewStores(){
		
	}
	
	public function renderAddStore(){
		
	}
	
	public function renderEditStore($store_id){
		$this->store_id = $store_id;
	}
	
	public function renderViewProducts($store_id){
	
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
					$this->flashMessage('Store succesfully created, now you can fill additional information.', 'success');
				else
					$this->flashMessage('Saving of the data failed.', 'error');	
					
				$this->redirect("this");
			}
		}
	}
	
	protected function createComponentStoresGrid($name) {
		$grid = new Grid($this, $name);
		$grid->model = $this->backendModel->getStores();
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
			
		$grid->addActionHref('editProducts', 'Edit products', 'editProducts')
			->setClass('marginLeft15')
            ->setIcon('fa-th-large');

        /*$grid->addActionHref('delete', 'Smazat', 'deleteCadastralOwner!')
            ->setIcon('trash')
            ->setConfirm(function($item) {
                return "Opravdu chcete smazat položku: {$item->owner_id}?";
			});*/
			
		$fName = "stores";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
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
