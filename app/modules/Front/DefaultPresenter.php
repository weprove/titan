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
	public function actionDefault($values = array()){
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
		$form->addSelect('salutation_id', '', $this->userModel->getSalutationPairs())
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
	
	public function customerFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			if($form['submit']->isSubmittedBy()){
				$values = $form->values;
				$this->redirect("this");
			}
		}
	}
}
