<?php
namespace Admin\Presenters;

use Nette\Application\UI\Form,
	Grido\Grid,
	Grido\Components\Filters\Filter,
	Grido\Translations\FileTranslator,
	Nette\Mail\Message,
	Nette\Utils\Html,
	Leon\Emails\EmailFactory;

class OrderPresenter extends SecuredPresenter
{
	public $order_id;
	public $cart;
	public $cart_id;
	
	public function actionShowOrder($cart_id){
		$this->template->order = $this->backendModel->getFullCart($cart_id);
	}
	
	public function actionShowCart($cart_id){
		$this->template->order = $this->backendModel->getFullCart($cart_id);
	}
	
	public function actionShowLeftCart($cart_id){
		$this->template->order = $this->backendModel->getFullCart($cart_id);
	}
	
	public function actionAddOrderNote($order_id){
		$this->order_id = $order_id;
	}
	
	public function actionEditOrder($cart_id){
		$this->cart = $this->backendModel->getFullCart($cart_id);
		$this->cart_id = $cart_id;
	}
	
	public function handleDeleteOrder($order_id){
		$this->backendModel->deleteOrder($order_id);
		$this->flashMessage("Order deleted.", "warning");
		$this->redirect("this");
	}
	
	protected function createComponentTodayOrdersGrid($name) {
		$grid = new Grid($this, $name);
		$that = $this;
		
		$operations = $this->backendModel->getOrderStatePairs();
			
		$grid->setOperation($operations, function($operation, $ids){	
			$this->backendModel->changeOrdersState($operation, $ids);
			$this->flashMessage("Order states changed.", "warning");
			
			$this->redirect("this#today");
		});
		
		$grid->model = $this->backendModel->getOrdersSelection()->where("order.order_state_id != 5 AND DATE(orderAdDate) = CURDATE()");
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('order_id');
		
		$grid->addColumnText('customerFirstname', 'Name')
			->setSortable()
            ->setFilterText();
		$grid->addColumnText('customerSurname', 'Surname')
			->setSortable()
            ->setFilterText();
		$grid->addColumnText('productUnitType', 'Unit')
			->setSortable()
            ->setFilterText();
		$grid->addColumnDate('leaseFrom', 'From')
			->setDateFormat("d/m/y")
			->setSortable()
            ->setFilterDate();
		$grid->addColumnDate('leaseTo', 'To')
			->setDateFormat("d/m/y")
			->setSortable()
            ->setFilterDate();
		$grid->addColumnText('cartPriceTotal', 'Price')
			->setCustomRender(function($item){
				$el = "£".round($item->cartPriceTotal, 2);
				return $el;
			})
			->setSortable()
            ->setFilterText();
			
		/*$grid->addColumnText('orderId', 'Order id')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('orderAdDate', 'Created')
			->setSortable()
            ->setFilterText();*/
			
		$grid->addColumnText('orderStateName', 'Status')
			->setSortable()
            ->setFilterText();
			
		/*$grid->addActionHref('editStore', 'Edit', 'editStore')
            ->setIcon('pencil');*/
		$grid->addActionHref('viewOrder', 'Edit', 'viewOrder')
            //->setIcon('file-text-o');
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link(":Admin:Order:showOrder", $item->cart_id))->class("btn btn-primary viewOrderDialogTrigger")->setHtml("<i class='fa fa-file-text-o'></i>");
				return $el;
			});
		$grid->addActionHref('addOrderNote', 'Add a note', 'addOrderNote')
            ->setIcon('paperclip');
		$grid->addActionHref('editOrder', 'Edit order', 'editOrder')
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link(":Admin:Order:editOrder", $item->cart_id))->class("btn btn-primary editOrder")->setHtml("<i class='fa fa-edit'></i>");
				return $el;
			});
		$grid->addActionHref('deleteOrder', 'delete order', 'deleteOrder!')
            ->setIcon('remove');

		$fName = "orders";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}
	
	protected function createComponentYesterdayOrdersGrid($name) {
		$grid = new Grid($this, $name);
		$that = $this;
			
		$operations = $this->backendModel->getOrderStatePairs();
			
		$grid->setOperation($operations, function($operation, $ids){	
			$this->backendModel->changeOrdersState($operation, $ids);
			$this->flashMessage("Order states changed.", "warning");
			
			$this->redirect("this#yesterday");
		});
		
		$grid->model = $this->backendModel->getOrdersSelection()->where("order.order_state_id != 5 AND SUBDATE(DATE(orderAdDate),1)");
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('order_id');
		
		$grid->addColumnText('customerFirstname', 'Name')
			->setSortable()
            ->setFilterText();
		$grid->addColumnText('customerSurname', 'Surname')
			->setSortable()
            ->setFilterText();
		$grid->addColumnText('productUnitType', 'Unit')
			->setSortable()
            ->setFilterText();
		$grid->addColumnDate('leaseFrom', 'From')
			->setDateFormat("d/m/y")
			->setSortable()
            ->setFilterDate();
		$grid->addColumnDate('leaseTo', 'To')
			->setDateFormat("d/m/y")
			->setSortable()
            ->setFilterDate();
		$grid->addColumnText('cartPriceTotal', 'Price')
			->setCustomRender(function($item){
				$el = "£".round($item->cartPriceTotal, 2);
				return $el;
			})
			->setSortable()
            ->setFilterText();
			
		/*$grid->addColumnText('orderId', 'Order id')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('orderAdDate', 'Created')
			->setSortable()
            ->setFilterText();*/
			
		$grid->addColumnText('orderStateName', 'Status')
			->setSortable()
            ->setFilterText();
			
		/*$grid->addActionHref('editStore', 'Edit', 'editStore')
            ->setIcon('pencil');*/
		$grid->addActionHref('viewOrder', 'Edit', 'viewOrder')
            //->setIcon('file-text-o');
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link(":Admin:Order:showOrder", $item->cart_id))->class("btn btn-primary viewOrderDialogTrigger")->setHtml("<i class='fa fa-file-text-o'></i>");
				return $el;
			});
		$grid->addActionHref('addOrderNote', 'Add a note', 'addOrderNote')
            ->setIcon('paperclip');
		$grid->addActionHref('editOrder', 'Edit order', 'editOrder')
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link(":Admin:Order:editOrder", $item->cart_id))->class("btn btn-primary editOrder")->setHtml("<i class='fa fa-edit'></i>");
				return $el;
			});
		$grid->addActionHref('deleteOrder', 'delete order', 'deleteOrder!')
            ->setIcon('remove');

		$fName = "orders";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}
	
	protected function createComponentRecentOrdersGrid($name) {
		$grid = new Grid($this, $name);
		$that = $this;
		
		$operations = $this->backendModel->getOrderStatePairs();
			
		$grid->setOperation($operations, function($operation, $ids){	
			$this->backendModel->changeOrdersState($operation, $ids);
			$this->flashMessage("Order states changed.", "warning");
			
			$this->redirect("this#recent");
		});
		
		$grid->model = $this->backendModel->getOrdersSelection()->where("order.order_state_id != 5 AND orderAdDate <= DATE_ADD(DATE(orderAdDate), INTERVAL -1 DAY)");
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('order_id');
		
		$grid->addColumnText('customerFirstname', 'Name')
			->setSortable()
            ->setFilterText();
		$grid->addColumnText('customerSurname', 'Surname')
			->setSortable()
            ->setFilterText();
		$grid->addColumnText('productUnitType', 'Unit')
			->setSortable()
            ->setFilterText();
		$grid->addColumnDate('leaseFrom', 'From')
			->setDateFormat("d/m/y")
			->setSortable()
            ->setFilterDate();
		$grid->addColumnDate('leaseTo', 'To')
			->setDateFormat("d/m/y")
			->setSortable()
            ->setFilterDate();
		$grid->addColumnText('cartPriceTotal', 'Price')
			->setCustomRender(function($item){
				$el = "£".round($item->cartPriceTotal, 2);
				return $el;
			})
			->setSortable()
            ->setFilterText();
			
		/*$grid->addColumnText('orderId', 'Order id')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('orderAdDate', 'Created')
			->setSortable()
            ->setFilterText();*/
			
		$grid->addColumnText('orderStateName', 'Status')
			->setSortable()
            ->setFilterText();
			
		/*$grid->addActionHref('editStore', 'Edit', 'editStore')
            ->setIcon('pencil');*/
		$grid->addActionHref('viewOrder', 'Edit', 'viewOrder')
            //->setIcon('file-text-o');
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link(":Admin:Order:showOrder", $item->cart_id))->class("btn btn-primary viewOrderDialogTrigger")->setHtml("<i class='fa fa-file-text-o'></i>");
				return $el;
			});
		$grid->addActionHref('addOrderNote', 'Add a note', 'addOrderNote')
            ->setIcon('paperclip');
		$grid->addActionHref('editOrder', 'Edit order', 'editOrder')
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link(":Admin:Order:editOrder", $item->cart_id))->class("btn btn-primary editOrder")->setHtml("<i class='fa fa-edit'></i>");
				return $el;
			});
		$grid->addActionHref('deleteOrder', 'delete order', 'deleteOrder!')
            ->setIcon('remove');

		$fName = "orders";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}
	
	protected function createComponentCompletedOrdersGrid($name) {
		$grid = new Grid($this, $name);
		$that = $this;
		
		$operations = $this->backendModel->getOrderStatePairs();
			
		$grid->setOperation($operations, function($operation, $ids){	
			$this->backendModel->changeOrdersState($operation, $ids);
			$this->flashMessage("Order states changed.", "warning");
			
			$this->redirect("this#completed");
		});
		
		$grid->model = $this->backendModel->getOrdersSelection()->where("order.order_state_id = 5");
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('order_id');
		
		$grid->addColumnText('customerFirstname', 'Name')
			->setSortable()
            ->setFilterText();
		$grid->addColumnText('customerSurname', 'Surname')
			->setSortable()
            ->setFilterText();
		$grid->addColumnText('productUnitType', 'Unit')
			->setSortable()
            ->setFilterText();
		$grid->addColumnDate('leaseFrom', 'From')
			->setDateFormat("d/m/y")
			->setSortable()
            ->setFilterDate();
		$grid->addColumnDate('leaseTo', 'To')
			->setDateFormat("d/m/y")
			->setSortable()
            ->setFilterDate();
		$grid->addColumnText('cartPriceTotal', 'Price')
			->setCustomRender(function($item){
				$el = "£".round($item->cartPriceTotal, 2);
				return $el;
			})
			->setSortable()
            ->setFilterText();
			
		/*$grid->addColumnText('orderId', 'Order id')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('orderAdDate', 'Created')
			->setSortable()
            ->setFilterText();*/
			
		$grid->addColumnText('orderStateName', 'Status')
			->setSortable()
            ->setFilterText();
			
		/*$grid->addActionHref('editStore', 'Edit', 'editStore')
            ->setIcon('pencil');*/
		$grid->addActionHref('viewOrder', 'Edit', 'viewOrder')
            //->setIcon('file-text-o');
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link(":Admin:Order:showOrder", $item->cart_id))->class("btn btn-primary viewOrderDialogTrigger")->setHtml("<i class='fa fa-file-text-o'></i>");
				return $el;
			});
		$grid->addActionHref('addOrderNote', 'Add a note', 'addOrderNote')
            ->setIcon('paperclip');
		$grid->addActionHref('editOrder', 'Edit order', 'editOrder')
			->setCustomRender(function($item) use ($that){
				$el = Html::el('a')->href($that->link(":Admin:Order:editOrder", $item->cart_id))->class("btn btn-primary editOrder")->setHtml("<i class='fa fa-edit'></i>");
				return $el;
			});
		$grid->addActionHref('deleteOrder', 'delete order', 'deleteOrder!')
            ->setIcon('remove');

		$fName = "orders";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}

	protected function createComponentEditOrderForm($name){
        $form = new  Form($this, $name);

		$form->addHidden("cart_id");
		$form->addSelect('product_id', 'Product', $this->backendModel->getProductsByStorePairs($this->cart->store_id));
        $form->addText('cartPrice', 'Price before sale');
        $form->addText('cartSale', 'Sale (£)');
		$form->addText('cartPriceTotal', 'Price total');
		$form->addText('leaseFrom', 'From')
			->getControlPrototype()->class("systemDate");
		$form->addText('leaseTo', 'To')
			->getControlPrototype()->class("systemDate");
			
		if(isset($this->cart_id))
			$form->setDefaults($this->cart);
		
        $form->addSubmit('submit', 'Save')
			->setAttribute('class', 'btn btn-primary');
		$form->onSuccess[] = array($this, 'editOrderFormSubmitted');
        
        return $form;
    }
	
    public function editOrderFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			$values = $form->values;		
        }
    }
	
	protected function createComponentAddOrderNoteForm($name){
        $form = new  Form($this, $name);
		$form->addHidden("order_id");
        $form->addTextArea('orderInternalNote', 'Internal note:')
            ->setRequired('Please fill note content.')
			->setAttribute('placeholder', 'Note content')
			->setAttribute('class', 'form-control');
			
		if(isset($this->order_id))
			$form->setDefaults($this->backendModel->getOrder($this->order_id));

        $form->addSubmit('login', 'Save')
			->setAttribute('class', 'btn btn-primary');
		$form->onSuccess[] = array($this, 'addOrderNoteFormSubmitted');
        
        return $form;
    }
	
    public function addOrderNoteFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
			$values = $form->values;	
			$this->backendModel->saveOrder($values);
			
			$this->redirect("this");
        }
    }
}
