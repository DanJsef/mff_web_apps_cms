<?php 
define('ROOT', __DIR__);
if (gethostname() == "local_env") {
    define('BASE', '/');
} else {
    define('BASE', '/~11238123/cms/');
}

require_once ROOT . '/loader.php';

try {
    $router = new Router;
    $router->dispatch();

} catch (Exception $e) {
    echo 'Errro 500';
}
