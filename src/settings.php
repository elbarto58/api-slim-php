<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        
        //configuración para la base de datos de nuestro proyecto Slim
        'db' => [
            'driver' => 'mysql',
            'host' => 'nuestro_host',//para probar en nuestra maquina, es localhost
            'database' => 'nombre_de_la_base_de_datos',
            'username' => 'usuario',
            'password' => 'contraseña',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],
        
    ],
];

?>