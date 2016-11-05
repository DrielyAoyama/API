<?php
class app 
{	
	//definição padrão	
	protected $controller = 'principal';
	protected $metodo     = 'index';
	protected $parametros = [];
	protected $middleware = "";
	protected $posicao    = 0;
	public function __construct()
	{
		$this->middleware = new middleware();
		$this->controller.='Controller';
		$url = $this->parseUrl();
	
	    //define o controller
	    if(isset($url[$this->posicao]))
		{
			if(file_exists(__DIR__.'/../../MVC/controllers/'.$url[$this->posicao].'Controller'.'.php'))
			{
				$this->controller = $url[$this->posicao].'Controller';
				unset($url[$this->posicao]);
				$this->posicao ++;
			}
		}
		$nome_controller = $this->controller;
		require __DIR__.'/../../MVC/controllers/'.$nome_controller.'.php';
		$this->controller = new $this->controller;
		//define o metodo
		if(isset($url[$this->posicao]))
		{
			if(method_exists($this->controller, strtolower($_SERVER['REQUEST_METHOD']).ucfirst($url[$this->posicao])))
			{
				$this->metodo = $url[$this->posicao];
				unset($url[$this->posicao]); 
			}
		}
		$this->metodo = strtolower($_SERVER['REQUEST_METHOD']).ucfirst($this->metodo);  
		//mantedo assim getMetodo postMetodo
		//define parametros
		$this->parametros = $url ? array_values($url) : [];
		if($this->middleware->middleware_geral($nome_controller,$this->metodo))
		{
			call_user_func_array([$this->controller,$this->metodo],$this->parametros);
		}
	}
	public function parseUrl()
	{
		if(isset($_GET['url']))
		{
			return $url = explode('/' , filter_var(rtrim($_GET['url'], '/'),FILTER_SANITIZE_URL));
		}
	}
}