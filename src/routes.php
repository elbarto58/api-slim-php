<?php

use Slim\Http\Request;
use Slim\Http\Response;

//Rutas
//Ruta principal que muestra la página de inicio de nuestro servidor slim
$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

//nuestras rutas para la api, en este caso usamos el formato de grupo, que consta en agrupar nuestras rutas, cuando se trata de proyectos grandes serìa bueno ir agrupando las rutas, para diferenciarlos.
$app->group('/api', function() use ($app) {
	
	//acceso a los mètodos usando solo peticiones POST
	$app->group('/post', function() use ($app){
		$app->post('/CreateUser', 'UserPostController:CreateUser');//crea un usuario nuevo -POST-
		$app->post('/GetUsers', 'UserPostController:GetUsers');//obtiene el registro de todos los usuarios -POST-
		$app->post('/UpdateUser', 'UserPostController:UpdateUser');//actualiza a un usuario en especifico -POST-
		$app->post('/DeleteUser', 'UserPostController:DeleteUser');//elimina el registro de un usuario -POST-
	});

	//acceso a los mètodos usando peticiones: GET, POST, PUT y DELETE
	$app->get('/GetUsers', 'UserController:GetUsers');//crea un usuario nuevo -POST-
	$app->post('/CreateUser', 'UserController:CreateUser');//obtiene el registro de todos los usuarios -GET-
	$app->put('/UpdateUser/{id}', 'UserController:UpdateUser');//actualiza a un usuario en especifico -PUT-
	$app->delete('/DeleteUser/{id}', 'UserController:DeleteUser');//elimina el registro de un usuario -DELETE-
});

?>