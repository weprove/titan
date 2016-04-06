<?php
namespace Admin\Presenters;

use Nette\Application\UI\Form,
	Grido\Grid,
	Grido\Components\Filters\Filter,
	Grido\Translations\FileTranslator,
	Nette\Mail\Message,
	Nette\Utils\Html,
	Nette\Environment;

class DefaultPresenter extends SecuredPresenter
{
	private $user_id;
	private $userData = array();
	
	public function actionDefault(){
		$this->redirect(":Admin:Order:");
	}
	
	public function actionViewUsers(){
	
	}
	
	public function actionEditUser($user_id){
		$this->user_id = $user_id;
		$this->userData = $this->userModel->getAccountData($user_id);
	}
	
	public function actionAssUser(){
	
	}
	
	protected function createComponentUsersGrid($name) {
		$grid = new Grid($this, $name);
		$grid->model = $this->backendModel->getUsers();
		$grid->setfilterRenderType(Filter::RENDER_INNER);
		$grid->setPrimaryKey('user_id');
		
		$grid->addColumnText('name', 'Name')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('surname', 'Surname')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('email', 'Email')
			->setSortable()
            ->setFilterText();
			
		$grid->addColumnText('roleName', 'Role')
			->setSortable()
            ->setFilterText()
			->setColumn("role_id.roleName");
			
		$grid->addActionHref('editUser', 'edit', 'editUser')
            ->setIcon('pencil');
			
			
		$fName = "users";
		new \Helpers\GridoExport($grid, $fName);
	 
		return $grid;
	}
	
	protected function createComponentAddUserForm($name){ 
	
        $form = new Form($this, $name);
		$form->getElementPrototype()->class[] = "stdFrm";	
		$form->addText('name', 'Firstname')
			->addRule($form::FILLED, 'Please fill user firstname.')
			->setAttribute('class', 'form-control');
        $form->addText('surname', 'Surname')
			->addRule($form::FILLED, 'Please fill user surname.')
			->setAttribute('class', 'form-control');
			
		$form->addText('email', 'Email (used also as username)')
			->addRule(array($this->userModel, 'isEmailAvailable'), "This email address is already registered.")
			->addRule($form::FILLED, 'Fill email field.')
			->addRule($form::EMAIL, 'Email address is in bad format.')
			->setAttribute('class', 'form-control');
			
        $roles = $this->userModel->getRoles();
        $prompt = Html::el('option')->setText("Choose role")->class('prompt');
        $form->addSelect('role_id', 'Role', $roles)
			->addRule(Form::FILLED, 'Please select role')
            ->setPrompt($prompt)
			->setAttribute('class', 'form-control');
        
        $form->addSubmit('submitter', 'Invite')->setAttribute('class', 'btn btn-primary btn_margin');
        $form->onSuccess[] = callback($this, 'addUserFormSubmitted');
      
        return $form;
    }
	
	protected function registerContactPerson($values, $loginUser = false){
		$config = Environment::getConfig('security');
		$clearPass = $values['password'];
		$values['password'] =  sha1($values['password'].$config->salt);
		$email = $values['email'];
		
		$register = $this->userModel->registerUser($values);
		
		if($register){			
			//mail pro zaslání dodatečných informací
			$mail = new Message;
			$mail->setFrom("noreply@titanstorage.co.uk");
			$mail->addTo($email);
			$mail->setSubject('Titan storage CRM credentials');
			$mail->setHtmlBody("
				Here are your login credentials:\n
				Login email: $email\n
				Password: $clearPass\n
 
				titanstorage.co.uk
			"); 
			
			$this->mailer->send($mail);
			
			if($loginUser)
				$this->user->login($email, $clearPass);
			
			return $register;
		}
		
	   else{
			return false;
	   }
	}
	
	public function addUserFormSubmitted($form){
		if($form->isSubmitted() && $form->isValid()){	
			$values = $form->values; 
	
			$helpers =  new \Helpers\Helpers;
			$hash = $helpers->generatePassword();
			$values['password'] = $hash;
			
			$user_id = $this->registerContactPerson($values);

			if($user_id) $this->flashMessage('User has been invited.', 'success');
			$this->redirect(':Admin:Default:viewUsers'); 
		}
    }
	
	protected function createComponentEditUserForm($name){ 
	
        $form = new Form($this, $name);
		$form->getElementPrototype()->class[] = "stdFrm";
		$form->addHidden('user_id');
		
		$form->addText('name', 'Firstname')
			->addRule($form::FILLED, 'Please fill user firstname.')
			->setAttribute('class', 'form-control');
        $form->addText('surname', 'Surname')
			->addRule($form::FILLED, 'Please fill user surname.')
			->setAttribute('class', 'form-control');
        $form->addText('email', 'Login E-mail')
			->addCondition(~$form::EQUAL, $this->userData['email'])
			->addRule($form::EMAIL, 'Email address is in bad format.')
			->addRule(callback($this->userModel, 'isEmailAvailable'), 'This email address is already registered.')
			->setAttribute('class', 'form-control');
        $form->addPassword('password', 'Password')
			->addCondition($form::FILLED)
				->addRule($form::MIN_LENGTH, '"Password should be between 6-12 chars', 6)
				->setAttribute('class', 'form-control');
        $form->addPassword('passwordCheck', 'Password again')
			->addRule($form::EQUAL, 'Both passwords must be equal', $form['password'])
			->setAttribute('class', 'form-control');
			
        $roles = $this->userModel->getRoles();
        $prompt = Html::el('option')->setText("Choose role")->class('prompt');
        $form->addSelect('role_id', 'Role', $roles)
			->addRule(Form::FILLED, 'Please select role')
            ->setPrompt($prompt)
			->setAttribute('class', 'form-control');
			
        $form->addCheckboxList('stores', 'Assigned stores', $this->backendModel->getStorePairs());
	
        $form->addSubmit('submitter', 'Save')->setAttribute('class', 'btn btn-primary btn_margin');
        $form->onSuccess[] = callback($this, 'editUserFormSubmitted');
		
		if($this->user_id){
			$form->setDefaults($this->userData);
		}
      
        return $form;
    }
	
	public function editUserFormSubmitted($form){
		if($form->isSubmitted() && $form->isValid()){	
			$values = $form->values; 
	
			$passChanged = false;
			
            $values = $form->values;
			$email = $values->email;
			
			$stores = $values['stores'];
			$pArr = array();
			foreach($stores AS $key=>$store){
				$pArr[] = array("user_id" => $this->user_id, "store_id" => $store) ;
			}
			
			$this->backendModel->assignStores($pArr, $this->user_id);
			
			unset($values['stores']);
			
            $config = Environment::getConfig('security');
            $clearPass = $values['password'];

            unset($values['passwordCheck']);

            if (!empty($values['password'])){
                $values['password'] = sha1($values['password'] . $config->salt);
				$passChanged = true;
			}
            else
                unset($values['password']);

            if ($this->userModel->updateUserAccount($values, $this->user_id)) {
			
				if($passChanged){
					$mail = new Message;
					$mail->setFrom("noreply@titanstorage.co.uk");
					$mail->addTo($email);
					$mail->setSubject('Titan storage CRM credentials');
					$mail->setHtmlBody("
						Here are your new login credentials:\n
						Login email: $email\n
						Password: $clearPass\n
		 
						titanstorage.co.uk
					"); 
					
					$this->mailer->send($mail);
				}
				
                $this->flashMessage('Successfully updated.', 'success');
            } 
			$this->redirect('this');
		}
    }
}
