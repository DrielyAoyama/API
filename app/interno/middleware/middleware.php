<?php
class middleware
{
	public function middleware_geral($controller, $metodo)
	{	
		$rota_requerida = _route($controller.'@'.$metodo);
		if ($this->RotaLiberada($rota_requerida))
		  	return true;
		else
		{
			if(CheckAuth())
					return true;
			else
				redirecionar(asset('usuarios/login'));
		}
	}

	private function RotaLiberada($rota_requerida)
	{
		$rotas_liberadas = rotas_liberadas();
		if(in_array($rota_requerida,$rotas_liberadas))
			return true;
		else
			return false;
	}


}