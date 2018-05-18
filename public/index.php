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
/**
	* CARGAMOS TODO LO QUE USAREMOS PARA ECHAR A ANDAR ESE PROYECTO, COMO VEMOS SOLO IMPORTA ARCHIVOS QUE SE REQUIEREN Y NO SE HACE MAS COSAS, SOLO LOS REQUIRES.
*/
require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instaciamos nuestra app obteniendo los ajustes: para los loggers, la base de datos, etc.
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// configurar dependencias
require __DIR__ . '/../src/dependencies.php';

// registramos nuestros middleware
require __DIR__ . '/../src/middleware.php';

// Registramos nuestras rutas
require __DIR__ . '/../src/routes.php';

// y corremos nuestra app
$app->run();

?>