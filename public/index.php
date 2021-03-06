<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require dirname(__DIR__) . '/cli-autoload.php';

session_start();

// Instantiate the app
$settings = require CHRONICLE_APP_ROOT . '/src/settings.php';
\ParagonIE\Chronicle\Chronicle::storeSettings($settings);
$app = new \Slim\App($settings);

// Set up dependencies
require CHRONICLE_APP_ROOT . '/src/dependencies.php';
require CHRONICLE_APP_ROOT . '/src/database.php';

// Register middleware
require CHRONICLE_APP_ROOT . '/src/middleware.php';

// Register routes
require CHRONICLE_APP_ROOT . '/src/routes.php';

// Run app
$app->run();
