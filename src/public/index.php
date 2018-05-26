<?php declare(strict_types=1);

define('APP_ENV', getenv('APP_ENV') ?: 'production');
define('SRC_ROOT', dirname(__DIR__));
define('APP_DIR', SRC_ROOT . '/app');
define('LIB_DIR', SRC_ROOT . '/lib');

require SRC_ROOT . '/vendor/autoload.php';

app\App::bootstrap();
