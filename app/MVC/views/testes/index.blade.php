@extends('templates.principal')

@section('titulo','Testes')

@section('conteudo')
<div class="card" style="padding-top: 20px;">
	<div style="padding-right: 10px;padding-left: 10px;">
		<div class="col-md-6 text-left">
				<label>Algorítmo</label>
				<select id="select_alg_busca">
					<option value="TODOS">TODOS</option>
				</select>
				<label>Tamanho</label>
				<select id="select_tamanho_busca">
					<option value="TODOS">TODOS</option>
					<option value="1">1mb</option>
					<option value="10">10mb</option>
					<option value="50">50mb</option>
					<option value="100">100mb</option>
					<option value="500">500mb</option>
					<option value="1000">1gb</option>
				</select>
			<button id="btn_filtrar"  onclick="filtrar_ordenado();" class="btn btn-primary"> Filtrar 
				<img id="img_loading_filtrar" style="display: none;" src="{{PASTA_PUBLIC.'/arquivos/img/loading.gif'}}" width="30">
			</button>
		</div>
		<div class="col-md-6 text-right">
			<button id="btn_loading" onclick="testar();" class="btn btn-primary"> Executar Teste 
				<img id="img_loading" style="display: none;" src="{{PASTA_PUBLIC.'/arquivos/img/loading.gif'}}" width="30">
			</button>
		</div>
		<hr>
		<hr>
		<div class="row">
			<div class="col-md-12"  style="overflow-y: scroll;max-height: 1130px;">
				<table class="table table-striped" id="tabela" style="display: none;">
				    <thead>
				      <tr>
				        <th onclick="filtrar_ordenado('algoritimo');">Algoritmo</th>
				        <th onclick="filtrar_ordenado('tempo');">Tempo</th>
				        <th>Tamanho</th>
				      </tr>
				    </thead>
				    <tbody id="corpo_tabela">		      
				    </tbody>
				  </table>
			</div>


		</div>
	</div>
</div>

<div class="card">
	<div style="padding-right: 10px;padding-left: 10px;">
	<h3>Pesos</h3>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped" id="tabela_pesos">
				    <thead>
					    <tr>
						    <th class="text-center"></th>
						    <th class="text-center"><strong>Peso 1</strong></th>
						    <th class="text-center"><strong>Peso 2</strong></th>
						    <th class="text-center"><strong>Peso 3</strong></th>
						    <th class="text-center"><strong>Peso 4</strong></th>
						    <th class="text-center"><strong>Peso 5</strong></th>
						    <th class="text-center"><strong>Peso 6</strong></th>
						    <th class="text-center"><strong>Peso 7</strong></th>
					    </tr>
				    </thead>
				    <tbody>	
				    	@foreach($algoritmos as $alg)
				    	<tr>
					        <td class="text-center"><strong>{{$alg->nome_algoritmo}}</strong></td>
					        <td class="text-center">{{$alg->_1}}</td>
					        <td class="text-center">{{$alg->_2}}</td>
					        <td class="text-center">{{$alg->_3}}</td>
					        <td class="text-center">{{$alg->_4}}</td>
					        <td class="text-center">{{$alg->_5}}</td>
					        <td class="text-center">{{$alg->_6}}</td>
					        <td class="text-center">{{$alg->_7}}</td>
				      	</tr>
				    	@endforeach	      
				    </tbody>
				  </table>
			</div>
		</div>
	</div>
</div>
@stop
