<?php
// DIC configuration
$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//Agregamos e inicilizamos Eloquent en nuestro contenedor de inyección de dependencias -CID-
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container['db'] = function($c) use ($capsule){
	return $capsule;
};

//Controladores
//De igual manera agregamos nuestros controladores al CID para utilizarlo
$container['UserController'] = function($c){
	$logger = $c->get('logger');
	return new \app\controllers\UserController($logger);
};

$container['UserPostController'] = function($c){
	$logger = $c->get('logger');
	return new \app\controllers\UserPostController($logger);
};

?>