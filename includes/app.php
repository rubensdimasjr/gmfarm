<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;
use \App\Http\Middleware\Queue as MiddlewareQueue;

/* Carrega variaveis de ambiente */

Environment::load(__DIR__ . '/../');

/* Define as configurações de banco de dados */
Database::config(
  getenv('DB_HOST'),
  getenv('DB_NAME'),
  getenv('DB_USER'),
  getenv('DB_PASS'),
  getenv('DB_PORT')
);

/* Define a constante de URL */
define('URL', getenv('URL'));


/* Define o valor padrão das variaveis */
View::init([
  'URL' => URL
]);

/* Define o mapeamento de middlewares */
MiddlewareQueue::setMap([
  'maintenance' => \App\Http\Middleware\Maintenance::class,
  'required-admin-logout' => \App\Http\Middleware\RequireAdminLogout::class,
  'required-admin-login' => \App\Http\Middleware\RequireAdminLogin::class,
  'required-admin-type' => \App\Http\Middleware\RequireAdminType::class
]);

/* Define o mapeamento de middlewares padrões (executados em todas as rotas) */
MiddlewareQueue::setDefault([
  'maintenance'
]);
