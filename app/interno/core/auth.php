<?php
use Illuminate\Database\Capsule\Manager as DB;

class Auth 
{	
	public function CheckAuth()
	{
		if(isset($_SESSION['dados_usuario'])) 
		{
			return true;
		}
		else
		{
			Auth::LimpaUsuario();
			return false;
		}
	}
	public function LimpaUsuario()
	{
		unset($_SESSION['dados_usuario']);
		session_destroy();
	}

	public function Auth($variavel="id")
	{
		if(isset($_SESSION['dados_usuario']))
		{
			if($_SESSION['dados_usuario']->{$variavel}=="")
				return null;
			else
				return $_SESSION['dados_usuario']->{$variavel};
		}
		else
			return null;
	}

	public function validaRequest($request)
	{
		if(!isset($request['token']))
			return false;
		else
			return Auth::validaToken($request['token']);
	}

	public function validaToken($token)
	{
		if(Auth::getToken()==$token)
			return true;
		else
			return false;
	}

	private function getToken()
	{
		return md5('12345');
	}

	public function SetUsuario($usuario =  [])
	{
		$_SESSION['dados_usuario'] = (object) $usuario;
	}

}