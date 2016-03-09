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
	protected function createComponentOrdersGrid($name) {
		$grid = new Grid($this, $name);
		$grid->model = $this->backendModel->getOrders();
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('order_id');
		
		$grid->addColumnText('orderId', 'Order id')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('orderAdDate', 'Created')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('orderStateName', 'Status')
			->setSortable()
            ->setFilterText();
			
		/*$grid->addActionHref('editStore', 'Edit', 'editStore')
            ->setIcon('pencil');*/

		$fName = "stores";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}

}
