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
	protected function createComponentChaseGrid($name) {
		$grid = new Grid($this, $name);
		$grid->model = $this->backendModel->getLeftCarts();
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('cart_id');
		
		$grid->addColumnText('cart_id', 'Cart id')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('cartAdDate', 'Created')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('mainProductName', 'Main product name')
			->setSortable()
            ->setFilterText();
			
		/*$grid->addActionHref('editStore', 'Edit', 'editStore')
            ->setIcon('pencil');*/

		$fName = "stores";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}
}
