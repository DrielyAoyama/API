<?php

function rotas_liberadas()
{
	 $rotas_liberadas = array
		(
			_route("usuariosController@getLogin"),
			_route("usuariosController@postLogar"),

			_route("principalController@getCodificar")

		);
	return $rotas_liberadas;
}
