<?php

function rotas_liberadas()
{
	 $rotas_liberadas = array
		(
			_route("usuariosController@getLogin"),
			_route("usuariosController@postLogar"),

			_route("principalController@getCodificarTeste"),
			_route("principalController@postCodificar"),

			_route("principalController@getDecodificarTeste"),
			_route("principalController@postDecodificar"),

			_route("principalController@getTestar"),
			_route("testesController@getTestar")

		);
	return $rotas_liberadas;
}
