<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
	'driver'=>'mysql',
	'database'=>DB_NOME,
	'host'=>DB_SERVIDOR.':'.DB_PORTA,
	'username'=>DB_USUARIO,
	'password'=>DB_SENHA,
	'charset'=>'utf8',
	'collation'=>'utf8_unicode_ci',
	'prefix'=>''
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();