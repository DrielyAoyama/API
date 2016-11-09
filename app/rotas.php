<?php

function rotas_liberadas()
{
	 $rotas_liberadas = array
		(
			_route("usuariosController@getLogin"),
			_route("usuariosController@postLogar"),

			_route("principalController@getCodificar"),
			_route("principalController@getTestar"),
			_route("testesController@getTestar")

		);
	return $rotas_liberadas;
}
