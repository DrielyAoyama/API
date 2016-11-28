<?php
	class Session
	{		
		public function set($campo,$valor)
		{
			unset($_SESSION['GLOBAL'][$campo]);
			$_SESSION['GLOBAL']=[$campo=>$valor];
		}

		public function get($campo)
		{
			if(isset($_SESSION['GLOBAL'][$campo]))
				return $_SESSION['GLOBAL'][$campo];
			else
				return null;
		}
	}

	class Request
	{		
		public function set($metodo,$valor)
		{
			unset($valor['REQUEST_METHOD']);
			$metodo = strtoupper($metodo);
			unset($_REQUEST['REQUEST'][$metodo]);
			$_REQUEST['REQUEST']=[$metodo=>$valor];
		}

		public function get($metodo)
		{
			if(isset($_REQUEST['REQUEST'][$metodo]))
				return $_REQUEST['REQUEST'][$metodo];
			else
				return null;
		}
	}