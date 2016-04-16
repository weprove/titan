<?php
namespace Admin\Presenters;

use	Nette\Security\User,
	Nette\Diagnostics\Debugger;

abstract class SecuredPresenter extends \Base\Presenters\BasePresenter
{
	public function startup()
	{
		$that = $this;
		$this->user->onLoggedOut[] = function ($user) use ($that) {
			$that->userModel->setLogoutFlag($user->identity->id);
		};
		
		parent::startup();

		$user = $this->getUser();
		if (!$user->isLoggedIn()) {
			if ($user->getLogoutReason() === User::INACTIVITY) {
				$this->flashMessage('Due to inactivity, the system has signed you out for security reasons.', 'warning');
                
			}
			$this->redirect('Sign:in', array('backlink' => $this->storeRequest()));
		} else {
			//$privileges = $this->userModel->getPrivileges();
			$action = $this->action;
			$resource = $this->name;
			
			if (!$user->isAllowed($this->name, $this->action)) {
				$this->flashMessage("[$this->name:$this->action] You don't have permission rights for this page!", 'warning');

				$this->redirect(':Front:Default:default');
			}
		
		}
	}
}
