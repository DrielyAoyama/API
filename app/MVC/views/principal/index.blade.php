@extends('templates.principal')
@section('titulo','Dashboard')


@section('conteudo')
	<!-- <h1>TEMPLATE PRINCIPAL</h1> -->
	<button onclick="fazer_request();"></button>
@stop

@section('scripts')
<script type="text/javascript">
	function fazer_request()
	{
		$url_request = '{{asset("codificar")}}';
		$.post($url_request, 
					{ 
						'JSON':'{'+
					                '"client_id":"e8dcdfd79e471bb794e80fcc056d876752fcc8c6",'+
					                '"client_token":"9fa41145a075ee591b8d07cafd0e9fac5384eb08",'+
					                '"texto":"Driely da Silva Aoyama",'+
					                '"tamanho":4,'+
					                '"nivel":3,'+
					                '"tempo_processamento":2'+
					            '}'
					})
		//em caso positivo escreve o JSON resposta na tela
		.done(function( JSON_RESPOSTA ) 
		{
			var string = json_to_string(JSON_RESPOSTA);
		    escrever(string);
		},'json');	
	}

	function json_to_string(json)
	{
		return JSON.stringify(json);
	}
	function escrever(texto)
	{
		alert(texto);
	}
</script>
@stop