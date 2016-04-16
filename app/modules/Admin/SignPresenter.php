<?php
namespace Admin\Presenters;

use Nette\Application\UI\Form,
    Nette\Application\UI\Presenter,
    Nette\Security as NS,
    Nette\Diagnostics\Debugger,
    Nette\Utils\Html,
    Models\User,
    Nette\Mail\Message;
    
class SignPresenter extends \Base\Presenters\BasePresenter
{
	protected $user_id;
	/** @persistent */
    public $backlink = '';
	
	protected $emailConstants;
	private $salt;
	
	public function __construct($emailConstants, $security){
		$this->emailConstants = $emailConstants;
		$this->salt = $security['salt'];
	}
	
	//Activate user by email hash
	public function handleActivateUser($hash){
		//nejprve odhlasime stavajiciho prihlaseneho uzivatele (pokud by nahodou byl prihlasen)
		$this->getUser()->logout();
		//$this->user->identity->id = NULL;
		
		$activation = $this->userModel->activateUser($hash);
		
		if($activation){
			$this->flashMessage('Your account has been successfully activated. Please sign in to complete your registration', 'success');
		}
		else{
			$this->flashMessage('Account activation failed. The activation link is invalid or has already expired.', 'error');		
		}
		
		$this->redirect("Sign:in");
	}
	
	public function resendActivationEmail(){
	
	}
	
	//Register
	public function actionRegister(){
		if($this->user->isLoggedIn()){
            $this->redirect("Default:default");
        }
	}
	
	//Lost PW
	public function actionLostPassword(){
	
	}
	
    //Login
    public function actionIn(){
		if($this->user->isLoggedIn()){
			$this->redirect("Default:default");
		}
    }
  
    // Logout
    public function actionOut($fbLogoutUrl){
        $oauth_provider = $this->user->identity->oauth_provider;
		//$this->userModel->setLogoutFlag($this->user->identity->id);
        $this->getUser()->logout();
        $this->user->identity->id = NULL;
        $this->flashMessage('You have successfully logged out.', 'success');

        if($oauth_provider == 'facebook'){                 
            //doladit, po delsim sezeni pouze presmeruje na facebook (nezadouci) => udelat presmerovani v pozadi!!    
            header("location:$fbLogoutUrl");
            $this->terminate();
        }

        $this->redirect('Default:default');
    }
    
    // Login form
    protected function createComponentLoginForm($name){
        $form = new  Form($this, $name);
        $form->addHidden('backlink');
        $form->addText('username', 'Email:')
            ->setRequired('Please fill your email')
			->setAttribute('placeholder', 'Email address')
			->setAttribute('class', 'form-control');
        $form->addPassword('password', 'Password:')
            ->setRequired('Please fill your password')
			->setAttribute('placeholder', 'Password')
			->setAttribute('class', 'form-control');
        $form->addCheckbox('remember', 'Remember me');	
        $form->addSubmit('login', 'Sign in')
			->setAttribute('class', 'btn btn-lg btn-primary btn-block');
		$form->onSuccess[] = array($this, 'loginFormSubmitted');
        
        return $form;
    }
	
    public function loginFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
            try {
                $values = $form->values;
				
				$this->user->login($values['username'], $values['password']);
				/*$this->sendResponse(new \Nette\Application\JsonResponse(array(
						'ok' => 'Nepovedlo se',
				)));*/
				if ($values['remember'])
					$this->user->setExpiration('+ 14 days', FALSE);
				else
					$this->user->setExpiration('+ 20 minutes', TRUE);
					
				$this->redirect(':Admin:Default:');

            } catch (NS\AuthenticationException $e) {
                    $form->addError($e->getMessage());
            }
        }
    }
    
    //Register form
    protected function createComponentRegisterForm($name){       
        $linkTo = $this->link('Sign:lostPassword');
        //$linkTermsOfUse = $this->link('Default:termsOfUse');
        
        $form = new  Form($this, $name);
        $form->addHidden('backlink');
        $form->addText('name', 'First name:')
            ->addRule($form::FILLED, 'Please fill in your first name')
			->setAttribute('placeholder', 'First name')
			->setAttribute('class', 'form-control');
        $form->addText('surname', 'Last name:')
            ->addRule($form::FILLED, 'Please fill in your last name')
			->setAttribute('placeholder', 'Last name')
			->setAttribute('class', 'form-control');
        $form->addText('email', 'Email:')
            ->addRule($form::FILLED, 'Please fill in your email address')
            ->addRule($form::EMAIL, 'Please fill in your correct email address')
            ->addRule($this->userModel->isEmailAvailable, "This email is already registered, did you forgot your password?")
			->setAttribute('placeholder', 'Email address')
			->setAttribute('class', 'form-control');

        $form->addPassword('password', 'Password')
            ->addRule($form::FILLED, 'Please fill in your password')
            ->addRule($form::MIN_LENGTH, 'Password must be between 6-12 characters', 6)
			->setAttribute('placeholder', 'Choose a password')
			->setAttribute('class', 'form-control');
			
        $form->addPassword('passwordCheck', 'Retype password')
            ->addRule($form::EQUAL, 'The passwords do not match', $form['password'])
			->setAttribute('placeholder', 'Please enter your password again')
			->setAttribute('class', 'form-control');	//ověřovací heslo musí být shodné
			
        $form->addSubmit('submitter', 'Register')
			->setAttribute('class', 'btn btn-primary');

		$form->onSuccess[] = array($this, 'registerFormSubmitted');

        return $form;
    }
    
    //Register form submitted
    public function registerFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
            $values = $form->values;
			$email = $values->email;
			$backlink = $values["backlink"];
			unset($values["backlink"]);   
			
            $clearPass = $values['password'];
            $values['password'] =  sha1($values['password'].$this->salt);
			$register = $this->userModel->registerUser($values);
			
			if($register){
				$hash = $this->userModel->addHash($email, $register);
				
				$activationLink = $this->context->getService('httpRequest')->url->baseUrl."sign/in/?do=activateUser&hash=$hash";
				//$activationLink = $this->link('activateUser!', $hash);
				
				$from = $this->emailConstants['noreplyEmail'];
				$emailSignature = $this->emailConstants['emailSignature'];
				
				//mail pro zaslání dodatečných informací
				$mail = new Message;
				$mail->setFrom($from);
				$mail->addTo($email);
				$mail->setSubject('New registration');
				$mail->setHtmlBody("Thank you for registering.\n
					Here are your login credentials:\n
					Login email: $email\n
					Password: $clearPass\n
	 
					$emailSignature
				");    
				
				if($this->emailConstants['disableEmails'] !=='true') $this->mailer->send($mail);
				
				//$this->user->login($email, $clearPass);
					
				//$this->flashMessage('Registration was successful, you were automatically signed in.', 'success');
				/*if($backlink)
					$this->getApplication()->restoreRequest($backlink);
				else
					$this->redirect('Default:default');*/
				$this->flashMessage('Your registration was successful, please check your email for the activation link to complete your registration.', 'success');
				$this->redirect('this');
			}
			
		   else{
				$form->setDefaults($form->values);
				$this->flashMessage('Unfortunately your registration was not successful, please try again later or notify support@medicalnetworking.co.uk.', 'error');
				$this->redirect('this');
		   }
        }
    }	
    
	//Lost PW Form
    protected function createComponentLostPasswordForm(){
        $form = new Form();
        $form->addText('email', 'Login email: ')
            ->addRule($form::FILLED, 'Please fill your login email')
            ->addRule($form::EMAIL, 'Please fill valid email adress')
			->setAttribute('placeholder', 'Email address')
			->setAttribute('class', 'form-control');
        $form->addSubmit('submitter', 'Continue')
			->setAttribute('class', 'btn btn-primary');
		$form->onSuccess[] = array($this, 'lostPasswordFormSubmitted');
		
        return $form;
    }
    
    public function lostPasswordFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
            $values = $form->values;
			$email = $values->email;
            if($this->userModel->emailExists($values->email)){
                $helpers =  new \Helpers\Helpers;
                $clearPass = $helpers->generatePassword();
                $password =  sha1($clearPass.$this->salt);
                
				$from = $this->emailConstants['noreplyEmail'];
				$emailSignature = $this->emailConstants['emailSignature'];
					
					//mail pro zaslání dodatečných informací
					$mail = new Message;
					$mail->setFrom($from);
					$mail->addTo($email);
					$mail->setSubject('Password change');
					$mail->setBody("Hello, here are your new login credentials: \n
						Email: $email\n
						Password: $clearPass\n
		 
						$emailSignature
					"); 
                
                try{
                    $this->userModel->changePassword($password, $values->email);
                    if($this->emailConstants['disableEmails'] !=='true') $this->mailer->send($mail);
                    
                    $this->flashMessage('A new password has been sent to your registered email address.', 'success');
                    
      		} catch (\Exception $e) {
                    $this->flashMessage("ERROR: sending of new password failed, please try again later.", 'error');
                }
                
                $this->redirect("this");
            }
            else{
                $this->flashMessage("Email address is not valid.","warning");
                $this->redirect('this');
            }
        }
    }

	protected function createComponentResendActivationLinkForm(){
        $form = new Form();
        $form->addText('email', 'Login email: ')
            ->addRule($form::FILLED, 'Please fill your login email')
            ->addRule($form::EMAIL, 'Please fill valid email adress')
			->setAttribute('placeholder', 'Your login email')
			->setAttribute('class', 'form-control');
        $form->addSubmit('submitter', 'Resend activation link')
			->setAttribute('class', 'btn btn-primary');
		$form->onSuccess[] = array($this, 'resendActivationLinkFormSubmitted');
		
        return $form;
    }
	
    public function resendActivationLinkFormSubmitted($form){
        if($form->isSubmitted() && $form->isValid()){
            $values = $form->values;
			$email = $values->email;
            if($this->userModel->emailExists($values->email)){
                
				$hash = $this->userModel->selectHash($email);
				
				$activationLink = $this->context->getService('httpRequest')->url->baseUrl."sign/in/?do=activateUser&hash=$hash";
				//$activationLink = $this->link('activateUser!', $hash);
				
				$from = $this->emailConstants['noreplyEmail'];
				$emailSignature = $this->emailConstants['emailSignature'];
					
					//mail pro zaslání dodatečných informací
					$mail = new Message;
					$mail->setFrom($from);
					$mail->addTo($email);
					$mail->setSubject('Resending of activation link');
					$mail->setHtmlBody("Hello, here is your new activation link: \n
					
						Please activate your account by clicking this link: <a href='$activationLink'>activate your account</a> and
						continuing the registration process.
		 
						$emailSignature
					"); 

                    if($this->emailConstants['disableEmails'] !=='true') $this->mailer->send($mail);
					
					$this->flashMessage("New activation link sent to your email address.","success");
					$this->redirect("Sign:in");
            }
            else{
                $this->flashMessage("Email address is not valid.","warning");
                $this->redirect('this');
            }
        }
    }
}
  