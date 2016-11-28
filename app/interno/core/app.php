<?php
class app 
{	
	protected $request = null;
	public function __construct()
	{
		if(isset($_POST['REQUEST_METHOD']))
			$_SERVER['REQUEST_METHOD']=$_POST['REQUEST_METHOD'];


		$this->request = Route::getParametros(App::getUrl(),$_SERVER['REQUEST_METHOD']);
		if($this->request==404)
			Route::direcionar(asset('erros/NAO_EXISTE'));

		switch ($metodo = $_SERVER['REQUEST_METHOD'])
		{
			case 'POST':
				Request::set('POST',$_POST);
				break;
			case 'GET':
				Request::set('GET',$_GET);			
				break;			
			default:
				Request::set($metodo,$_POST);
				break;
		}
		unset($_POST,$_GET);
	}

	public function run()
	{
		if(middleware::liberado($this->request['NOME_CONTROLLER'],$this->request['METODO']))
			Route::executar($this->request['CONTROLLER'],$this->request['METODO'],$this->request['PARAMETROS']);
		else
		{
			Auth::LimpaUsuario();				
			Route::direcionar(asset('usuarios/login'));
		}
	}


	public function getUrl()
	{
		if(isset($_GET['url']))
			return $_GET['url'];
	}

}