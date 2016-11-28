<?php
class middleware
{
	public function liberado($controller, $metodo)
	{	
		$rota_requerida = _route($controller.'@'.$metodo);
		if (middleware::RotaLiberada($rota_requerida))
		  	return true;
		else
			return Auth::CheckAuth();
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