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
        $this->addRole('student', 'user');
        $this->addRole('college_admin', 'student');
        $this->addRole('doctor', 'college_admin');
		$this->addRole('coach', 'doctor');
		$this->addRole('admin', 'coach');
		$this->addRole('super_admin', 'admin');
		$this->addRole('event_organizer', 'user');
        
        //resources - Homepage:default
        $this->addResource('Default');
		$this->addResource('MyProfile');
		$this->addResource('Profile');
		$this->addResource('Event');
		$this->addResource('Message');
		$this->addResource('Notification');
		$this->addResource('Chat');
		$this->addResource('MyCoaches');
		$this->addResource('Backend');
        
        //User
        $this->allow('user', 'Default', Permission::ALL);
        $this->allow('user', 'MyProfile', Permission::ALL);
		$this->allow('user', 'Profile', Permission::ALL);
		$this->allow('user', 'Event', Permission::ALL);
		$this->allow('user', 'Message', Permission::ALL);
		$this->allow('user', 'Notification', Permission::ALL);
		$this->allow('user', 'Chat', Permission::ALL);
		$this->allow('user', 'MyCoaches', Permission::ALL);
        
        //Admin
        $this->allow('admin', Permission::ALL, Permission::ALL);

    }
}