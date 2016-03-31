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
			
		/*$grid->addActionHref('editStore', 'Edit', 'editStore')
            ->setIcon('pencil');*/

		$fName = "stores";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}
}
