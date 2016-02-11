<?php

// Uncomment this line if you must temporarily take down your site for maintenance.
// require __DIR__ . '/.maintenance.php';

define('WWW_DIR', dirname(__FILE__)); // path to the web root
define('APP_DIR', WWW_DIR . '/../app'); // path to the application root
define('LIBS_DIR', WWW_DIR . '/../vendor'); // path to the libraries
define('TEMP_DIR', WWW_DIR . '/../temp');

$container = require __DIR__ . '/../app/bootstrap.php';

$container->getService('application')->run();
