<?php

namespace AclProj\Security;

use Nette\Object,
    Nette\Environment, 
    Nette\Security\Identity,
    Nette\Security\IAuthenticator,
    Nette\Security\AuthenticationException,
    Nette\Diagnostics\Debugger;

class Authenticator extends \Nette\Object implements IAuthenticator
{
	private $userModel;
	private $salt;
 /*   public function checkCredentials($username, $password)
  	{
  		try {
  			$this->authenticate(array($username, $password));
  			return true;
  		} catch (AuthenticationException $e) {
  			return false;
  		}
  	}*/
	public function __construct($security, \App\Model\User $userModel)
    {
        $this->userModel = $userModel;
		$this->salt = $security['salt'];
    }
  	
    public function authenticate(array $credentials)
    {   
        if(array_key_exists(2, $credentials) && !empty($credentials[2])){
        
            //budeme prihlasovat pomoci facebooku
            $email = (isset($credentials[0])) ? $credentials[0]:'';
            $oauth_uid = isset($credentials[1]) ? $credentials[1]:'';
            $oauth_provider = isset($credentials[2]) ? $credentials[2]:'';
            
            $row = $this->userModel->findByOauth($oauth_uid,  $oauth_provider, $email);
            
            if (!$row)
                throw new AuthenticationException("This user is not registered in our system.", self::IDENTITY_NOT_FOUND);
            else
                $this->userModel->setActiveFlag($row->id);
            
            $identity = new Identity($row->id, $row->role);
            $identity->name = $row->name;
            $identity->surname = $row->surname;
            $identity->username = $row->username;
            $identity->email = $row->email;
            $identity->oauth_provider = $oauth_provider;
           

            return $identity;
        }
        else{
            //klasicke prihlaseni
            $email = $credentials[self::USERNAME];
            $row = $this->userModel->findByEmail($email);
            
            if (!$row) { 
                /*$r = (isset($credentials[3])) ? true:false;
                if($r){
                  return false;
                }*/
                throw new AuthenticationException("Email or password is invalid.", self::IDENTITY_NOT_FOUND);
            }
    
            $password =  sha1($credentials[self::PASSWORD].$this->salt);

            if ($row->password !== $password) 
                throw new AuthenticationException('Email or password is invalid.', self::INVALID_CREDENTIAL);
            else
                $this->userModel->setActiveFlag($row->id);
            
            $identity = new Identity($row->id, $row->role);
            $identity->name = $row->name;
            $identity->surname = $row->surname;
            $identity->username = $row->username;
            $identity->email = $row->email;
            $identity->oauth_provider = NULL;
            
            return $identity;
        }
            
    }
}