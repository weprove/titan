<?php
namespace Admin\Presenters;

use Nette\Application\UI\Form,
	Grido\Grid,
	Grido\Components\Filters\Filter,
	Grido\Translations\FileTranslator,
	Nette\Mail\Message,
	Nette\Utils\Html,
	Leon\Emails\EmailFactory;

class ChasePresenter extends SecuredPresenter
{
	public $template_id;
	
	public function actionViewEmailTemplates(){
	
	}
	
	public function actionChaseClient($cart_id){
		
	}
	
	public function actionEditTemplate($template_id = NULL){
		$this->template_id = $template_id;
	}
	
	public function handleDeleteCart($cart_id){
		$this->backendModel->deleteCart($cart_id);
		$this->flashMessage("Cart deleted.", "warning");
		$this->redirect("this");
	}
	
	protected function createComponentChaseGrid($name) {
		$that = $this;
		$grid = new Grid($this, $name);
		$grid->model = $this->backendModel->getLeftCarts();
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('cart_id');
		
		/*$grid->addColumnText('cart_id', 'Cart id')
			->setSortable()
            ->setFilterText();*/
			
		$grid->addColumnText('customerEmail', 'Email')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('customerFirstname', 'Name')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('customerSurname', 'Surname')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnDate('cartAdDate', 'Date added')
			->setDateFormat("d/m/y")
			->setSortable()
            ->setFilterDate();
			
		/*$grid->addActionHref('editStore', 'Edit', 'editStore')
            ->setIcon('pencil');*/
		$grid->addActionHref('viewOrder', 'Edit', 'viewOrder')
            //->setIcon('file-text-o');
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link(":Admin:Order:showCart", $item->cart_id))->class("btn btn-primary viewCartDialogTrigger")->setHtml("<i class='fa fa-file-text-o'></i>");
				return $el;
			});
		$grid->addActionHref('chaseClient', 'Chase client', 'Chase')
            //->setIcon('file-text-o');
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link(":Admin:Chase:chaseClient", $item->cart_id))->class("btn btn-primary viewCartDialogTrigger")->setHtml("<i class='fa fa-envelope-o'></i>");
				return $el;
			});
		$grid->addActionHref('deleteCart', 'delete cart', 'deleteCart!')
            ->setIcon('remove');

		$fName = "stores";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}
	
	protected function createComponentEditTemplateForm($name){
        $form = new  Form($this, $name);
		$form->addHidden("template_id");
		$form->addText('templateName', 'Název:')
            ->setRequired('Please fill template name.');
        $form->addTextArea('templateHtml', 'Content:')
			->getControlPrototype()->class("mceEditor emailTemplateBody")
            ->setRequired('Please fill template content.');
			
		if(isset($this->template_id))
			$form->setDefaults($this->backendModel->getTemplate($this->template_id));

        $form->addSubmit('login', 'Save')
			->setAttribute('class', 'btn btn-primary');
		$form->onSuccess[] = array($this, 'editTemplateFormSubmitted');
        
        return $form;
    }
	
    public function editTemplateFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			$values = $form->values;	
			$this->backendModel->saveTemplate($values);
			
			$this->redirect("this");
        }
    }
}
