<?php
ini_set('error_reporting', 0);

use Nette\Application\Routers\Route,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\SimpleRouter;


// Load Nette Framework
require __DIR__ . '/../vendor/autoload.php';

// Configure application
$configurator = new Nette\Configurator;

// Enable Nette Debugger for error visualisation & logging
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__ . '/../vendor')
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon');
$container = $configurator->createContainer();


$router = $container->getService('router');
$router[] = new Route('index.php', 'Front:Default:default', Route::ONE_WAY);

$router[] = $adminRouter = new RouteList('Admin');
/*$adminRouter[] = new Route('admin/<presenter>/<action>?[<params>]', array(
'params' => array(
	Route::FILTER_IN => function ($value){ return Base64_encode($value);},
	Route::FILTER_OUT => function ($value){ return Base64_decode($value);}
)));*/
$adminRouter[] = new Route('admin/<presenter>/<action>', 'Default:default');

$router[] = $frontRouter = new RouteList('Front');
$frontRouter[] = new Route('<presenter>/<action>[/<id>]', 'Default:default');


$db = $container->isCreated('database.default.context') ? $container->getService('database.default.context') : $container->createService('database.default.context');


return $container;
