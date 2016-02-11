<?php

namespace AclProj\Security;

use Nette\Security\Permission;

class Acl extends Permission
{
    public function __construct()
    {
        //role
        $this->addRole('guest');
        $this->addRole('user', 'guest');
		$this->addRole('salesman', 'user');
		$this->addRole('admin', 'salesman');
		$this->addRole('super_admin', 'admin');
        
        //resources - Homepage:default
        $this->addResource('Admin:Default');
		$this->addResource('Front:Default');
		$this->addResource('Admin:Sign');
        
        //User
        $this->allow('guest', 'Front:Default', Permission::ALL);
		$this->allow('guest', 'Admin:Sign', Permission::ALL);
		$this->allow('user', 'Admin:Default', Permission::ALL);
        
        //Admin
        $this->allow('admin', Permission::ALL, Permission::ALL);

    }
}