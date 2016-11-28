<?php

class Route 
{
	public function direcionar($caminho)
	{
	    header("location:$caminho");
	}

	public function voltar()
	{
		echo '<script>window.history.back();</script>';
	}

	public function executar($controller,$metodo,$parametros=[])
	{
		call_user_func_array([$controller,$metodo],$parametros);
	}

	public function getParametros($url,$request_method='GET')
	{
		$controller = 'principalController';
		$metodo     = 'index';
		$parametros = [];
		$posicao    = 0;
		$app = "";
		$url = Route::parseUrl($url);
		if(isset($url[$posicao]))
		{
			if(is_dir('../../'.$url[$posicao]))
			{
				$app = $url[$posicao];
				unset($url[$posicao]);
				$posicao ++;
			}
		}
		if(isset($url[$posicao]))
		{
			if(file_exists(__DIR__.'/../../mvc/controllers/'.$url[$posicao].'Controller'.'.php'))
			{
				$controller = $url[$posicao].'Controller';
				unset($url[$posicao]);
				$posicao ++;
			}
		}
		$nome_controller = $controller;	

		require __DIR__.'/../../mvc/controllers/'.$nome_controller.'.php';
		$controller = new $controller;

		if(isset($url[$posicao]))
		{
			if(method_exists($controller, strtolower($request_method.ucfirst($url[$posicao]))))
			{
				$metodo = $url[$posicao];
				unset($url[$posicao]); 
			}
			else
				return 404;
		}
		$metodo = strtolower($request_method).ucfirst($metodo);	
		return ['APP'=> $app,'NOME_CONTROLLER'=>$nome_controller,'CONTROLLER'=>$controller,'METODO'=>$metodo,'PARAMETROS'=> $parametros = $url ? array_values($url) : []];
	}

	public function parseUrl($url)
	{
		if(isset($url))
			return explode('/' , filter_var(rtrim($_GET['url'], '/'),FILTER_SANITIZE_URL));
	}

}