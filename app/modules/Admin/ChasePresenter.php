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
	public $cart;
	
	public function actionViewEmailTemplates(){
		$this->template->templates = $this->backendModel->getTemplates();
	}
	
	public function actionChaseClient($cart_id, $template_id = NULL){
		$this->template->templates = $this->backendModel->getTemplates();
		$this->template->cart_id = $cart_id;
		
		if($template_id){
			$template = $this->backendModel->getTemplate($template_id);
			$this->template_id = $template_id;
		}
		$this->cart = $this->backendModel->getFullCart($cart_id);
			
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
				$el = Html::el('a')->href($that->link(":Admin:Chase:chaseClient", $item->cart_id))->class("btn btn-primary chaseClientEmail")->setHtml("<i class='fa fa-envelope-o'></i>");
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
        $html = $form->addTextArea('templateHtml', 'Content:');
		$html->getControlPrototype()->class("mceEditor2 emailTemplateBody");
        $html->setRequired('Please fill template content.');
		
		$htmlTemplate = file_get_contents(__DIR__ ."/templates/emailTemplate.latte");
			
		if(isset($this->template_id))
			$form->setDefaults($this->backendModel->getTemplate($this->template_id));
		else
			$form->setDefaults(array("templateHtml"=>$htmlTemplate));

        $form->addSubmit('login', 'Save')
			->setAttribute('class', 'btn btn-primary');
		$form->onSuccess[] = array($this, 'editTemplateFormSubmitted');
        
        return $form;
    }
	
    public function editTemplateFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			$values = $form->values;	
			$this->backendModel->saveTemplate($values);
			
			$this->redirect(":Admin:Chase:viewEmailTemplates");
        }
    }
	
	protected function createComponentFullFilledTemplateForm($name){
        $form = new  Form($this, $name);
        $html = $form->addTextArea('templateHtml', 'Content:');
		$html->getControlPrototype()->class("mceEditor2 emailTemplateBody");
        $html->setRequired('Please fill template content.');
		
		//$htmlTemplate = file_get_contents(__DIR__ ."/templates/emailTemplate.latte");
			
		if(isset($this->template_id)){
			$fullTemplate = $this->backendModel->getTemplate($this->template_id);
			$s = $fullTemplate->templateHtml;
			
			$tpl = $this->templateFactory->createTemplate($this);
			$tpl->data = $this->cart;
			$latte = $tpl->getLatte();
			$latte->setLoader(new \Latte\Loaders\StringLoader);
			$html1 = $latte->renderToString($s, $tpl->getParameters());
			
			$form->setDefaults(array("templateHtml"=>$html1));
		
		}
		else{
			$tpl = $this->createTemplate();
			$tpl->setFile(__DIR__ ."/templates/emailTemplate.latte");
			$tpl->data = $this->cart;
			$form->setDefaults(array("templateHtml"=>$tpl->__toString()));
		}

        $form->addSubmit('login', 'Save')
			->setAttribute('class', 'btn btn-primary');
		$form->onSuccess[] = array($this, 'fullfilledTemplateFormSubmitted');
        
        return $form;
    }
	
    public function fullfilledTemplateFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			$values = $form->values;	
			
			//zasleme email
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
			}
			
			$this->redirect(":Admin:Chase:");
        }
    }
}
