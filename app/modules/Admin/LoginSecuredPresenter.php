<?php
namespace Admin\Presenters;

use	Nette\Security\IUserStorage;

abstract class LoginSecuredPresenter extends \Base\Presenters\BasePresenter
{
	public function startup()
	{
		parent::startup();

		$user = $this->getUser();

		if (!$user->isLoggedIn()) {
		  
			if ($user->getLogoutReason() === IUserStorage::INACTIVITY) {
				$this->flashMessage('Due to inactivity, the system has signed you out for security reasons.', 'warning');
			}
            
            $this->redirect(':Admin:Sign:in', array('backlink' => $this->storeRequest()));

		} 
	}
}
