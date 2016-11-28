<?php

use Illuminate\Database\Capsule\Manager as Capsule;

define("DB_SERVIDOR",  "localhost");
define("DB_PORTA"   ,  "3306");
define("DB_NOME"    ,  "service");
define("DB_USUARIO" ,  "root");
define("DB_SENHA"   ,  "");


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



class Query
{
	public function exec($sql)
	{
		DB::beginTransaction();
		if($sql!=null)
		{
			DB::select(DB::raw($sql));
			DB::commit();
		}
	}

	public function get($sql,$campo=null)
	{
		DB::beginTransaction();
		if(is_null($campo))
			return  DB::select(DB::raw($sql));
		else
		{
			$query = DB::select(DB::raw($sql));
			return $query[0]->{$campo};
		}
		DB::rollBack();
	}
}