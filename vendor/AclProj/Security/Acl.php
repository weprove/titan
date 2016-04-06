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
		$this->addRole('store_manager', 'salesman');
		$this->addRole('admin', 'store_manager');
		$this->addRole('super_admin', 'admin');
        
        //resources - Homepage:default
        $this->addResource('Admin:Default');
		$this->addResource('Front:Default');
		$this->addResource('Admin:Sign');
		$this->addResource('Admin:Store');
		$this->addResource('Admin:Discount');
		$this->addResource('Admin:Order');
		$this->addResource('Admin:Chase');
        
		/*
		Admin: Steve, Niamh, James
		can: create/delete offers, create/delete products, create/delete stores, create/delete email templates

		Shop Manager
		can: create/delete products for his store, view bookings, chase clients

		Salesman
		can: view bookings, chase clients
		*/

        //User
        $this->allow('guest', 'Front:Default', Permission::ALL);
		$this->allow('guest', 'Admin:Sign', Permission::ALL);
		
		//salesman
		$this->allow('salesman', 'Admin:Order', array('showOrder', 'addOrderNote', 'editOrder'));
		$this->allow('salesman', 'Admin:Chase', array('showLeftCart', 'chaseClient', 'viewSentEmail'));
		
		//store_manager
		$this->allow('store_manager', 'Admin:Store', array('viewStores', 'viewProducts', 'addProduct', 'editProduct', 'addProductSpecialOffer'));
		$this->allow('store_manager', 'Admin:Order', array('showOrder', 'addOrderNote', 'editOrder'));
		$this->allow('store_manager', 'Admin:Chase', array('showLeftCart', 'chaseClient', 'viewSentEmail'));
        
        //Admin
        $this->allow('admin', Permission::ALL, Permission::ALL);

    }
}