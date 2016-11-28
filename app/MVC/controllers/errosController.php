<?php
use Jenssegers\Blade\Blade;


class errosController extends controller
{
	
	public function getNAO_EXISTE()
	{
		echo "Página não existe";
	}

	public function getSEM_PERMISSAO()
	{
		echo "Sem permissão de acesso a está rota";
	}

	
}