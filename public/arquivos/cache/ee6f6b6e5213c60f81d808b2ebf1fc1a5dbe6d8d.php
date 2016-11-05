

<?php $__env->startSection('titulo','Testes'); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="card" style="padding-top: 20px;">
	<div class="container">
		<div class="col-md-6 text-left">
				<label>Algorítmo</label>
				<select id="select_alg_busca">
					<option value="TODOS">TODOS</option>
				</select>
				<label>Tamanho</label>
				<select id="select_tamanho_busca">
					<option value="TODOS">TODOS</option>
					<option value="1mb">1mb</option>
					<option value="10mb">10mb</option>
					<option value="50mb">50mb</option>
					<option value="100mb">100mb</option>
					<option value="500mb">500mb</option>
					<option value="1gb">1gb</option>
				</select>
			<button id="btn_filtrar"  onclick="filtrar_ordenado();" class="btn btn-primary"> Filtrar 
				<img id="img_loading_filtrar" style="display: none;" src="<?php echo e(PASTA_PUBLIC.'/arquivos/img/loading.gif'); ?>" width="30">
			</button>
		</div>
		<div class="col-md-6 text-right">
			<button id="btn_loading" onclick="testar();" class="btn btn-primary"> Executar Teste 
				<img id="img_loading" style="display: none;" src="<?php echo e(PASTA_PUBLIC.'/arquivos/img/loading.gif'); ?>" width="30">
			</button>
		</div>
		<hr>
		<hr>
		<div class="row">
			<div class="col-md-5"  style="overflow-y: scroll;max-height: 1130px;">
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
			<div class="col-md-7">

				<div class="jumbotron" style="padding-top:0px">
				  	<div class="row" style="display: none;" id="faixas">
				  		<div class="text-center"><h3 class="text-center">Faixas</h3></div>
				  		<hr>
				  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>1 mb (melhor tempo : <span id="melhor_tempo_1mb">0</span> Seg.)</strong></div>
				  		<strong>Algoritmo :</strong><span id="alg_1_mb"> </span>
				  		<strong>tipo :</strong><span id="tipo_1mb"> </span>
				  		<hr>

				  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>10 mb (melhor tempo :  <span id="melhor_tempo_10mb">0</span> Seg.)</strong></div>
				  		<strong>Algoritmo :</strong><span id="alg_10_mb"> </span>
				  		<strong>tipo :</strong><span id="tipo_10mb"> </span>
				  		<hr>

				  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>20 mb (melhor tempo :  <span id="melhor_tempo_20mb">0</span> Seg.)</strong></div>
				  		<strong>Algoritmo :</strong><span id="alg_20_mb"> </span>
				  		<strong>tipo :</strong><span id="tipo_20mb"> </span>
				  		<hr>

				  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>50 mb (melhor tempo :  <span id="melhor_tempo_50mb">0</span> Seg.)</strong></div>
				  		<strong>Algoritmo :</strong><span id="alg_50_mb"> </span>
				  		<strong>tipo :</strong><span id="tipo_50mb"> </span>
				  		<hr>

				  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>100 mb (melhor tempo :  <span id="melhor_tempo_100mb">0</span> Seg.)</strong></div>
				  		<strong>Algoritmo :</strong><span id="alg_100_mb"> </span>
				  		<strong>tipo :</strong><span id="tipo_100mb"> </span>
				  		<hr>

				  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>500 mb (melhor tempo :  <span id="melhor_tempo_500mb">0</span> Seg.)</strong></div>
				  		<strong>Algoritmo :</strong><span id="alg_500_mb"> </span>
				  		<strong>tipo :</strong><span id="tipo_500mb"> </span>
				  		<hr>

				  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>1 gb (melhor tempo :  <span id="melhor_tempo_1gb">0</span> Seg.)</strong></div>
				  		<strong>Algoritmo :</strong><span id="alg_1_gb"> </span>
				  		<strong>tipo :</strong><span id="tipo_1gb"> </span>
				  		<hr>
				  	</div>
				</div>


				<div class="jumbotron" style="padding-top:0px">
					<div class="row" style="display: none;" id="tipos">
				  		<div class="text-center"><h3 class="text-center">Tipos</h3></div>
				  		<hr>

				  		<div class="col-md-6">
					  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>Assimétrica mais rápida</strong></div>
					  		<strong>Algoritmo :</strong><span id="tipo_assimetrica"> </span>
					  	</div>
					  	<div class="col-md-6"> 
					  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>Simétrica mais rápida</strong></div>
					  		<strong>Algoritmo :</strong><span id="tipo_simetrica"> </span>
					  	</div>
						<hr>

						<div class="col-md-6">
					  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>Bloco leves mais rápida</strong></div>
					  		<strong>Algoritmo :</strong><span id="tipo_blocos"> </span>
					  	</div>
					  	<div class="col-md-6">
					  		<div class="alert alert-info" role="alert" style="margin-bottom: 0px;"><strong>Hash mais rápido</strong></div>
					  		<strong>Algoritmo :</strong><span id="tipo_hash"> </span>
					  	</div>
						<hr>

				  	</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="card">
	<div class="container">
	<h3>Pesos</h3>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped" id="tabela_pesos">
				    <thead>
					    <tr>
						    <th class="text-center"></th>
						    <th class="text-center"><strong>1mb</strong></th>
						    <th class="text-center"><strong>10mb</strong></th>
						    <th class="text-center"><strong>20mb</strong></th>
						    <th class="text-center"><strong>50mb</strong></th>
						    <th class="text-center"><strong>100mb</strong></th>
						    <th class="text-center"><strong>500mb</strong></th>
						    <th class="text-center"><strong>1gb</strong></th>
					    </tr>
				    </thead>
				    <tbody>	
				    	<?php foreach($algoritmos as $alg): ?>
				    	<tr>
					        <td class="text-center"><strong><?php echo e($alg->nome_algoritmo); ?></strong></td>
					        <td class="text-center"><?php echo e($alg->_1mb); ?></td>
					        <td class="text-center"><?php echo e($alg->_10mb); ?></td>
					        <td class="text-center"><?php echo e($alg->_20mb); ?></td>
					        <td class="text-center"><?php echo e($alg->_50mb); ?></td>
					        <td class="text-center"><?php echo e($alg->_100mb); ?></td>
					        <td class="text-center"><?php echo e($alg->_500mb); ?></td>
					        <td class="text-center"><?php echo e($alg->_1gb); ?></td>
				      	</tr>
				    	<?php endforeach; ?>	      
				    </tbody>
				  </table>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		$( document ).ready(function()
		{
			carregar_dados();
			carregar_algoritmos();			
		});

		function testar(perguntar=true)
		{
			if(perguntar)
				msg_confirm('<strong>Confirmação</strong>','<p>Executar o Teste Novamente?</p><p>Este processo apagará os registros antigos para inserir novos.</p>',"testar(false)"); 
			else
			{
				$('#btn_loading').attr('disabled','disabled');
				$('#img_loading').toggle(250);

	 			$.post("<?php echo e(asset('testes/Testar')); ?>", { Algoritmo: $('#select_alg').val()})
				.done(function( data ) 
				{
				   $('#btn_loading').removeAttr('disabled');
				   $('#img_loading').toggle(250);
					carregar_dados();
					location.reload();
				});
			}
		}

	

		function carregar_algoritmos()
		{
			$.getJSON("<?php echo e(asset('testes/algoritmos')); ?>", function( data ) 
			{	
				$.each(data, function(index,d)
				{
					$('#select_alg_busca').append("<option value='"+d.nome+"'>"+d.nome+"</option>");
				});
			});	
		}

		function carregar_dados()
		{
			$('#tabela').hide();
			$('#corpo_tabela').html(null);
			$.getJSON("<?php echo e(asset('testes/DadosTestes')); ?>", function( data ) 
			{
 				$('#corpo_tabela').html(null);		
				$.each(data, function(index,d)
				{
					$('#corpo_tabela').append(
					"<tr>"+
				       "<td>"+d.algoritimo+"</td>"+
				       "<td>"+d.tempo+" Seg</td>"+
				       "<td>"+d.tamanho+"</td>"+
				    "</tr>");
				});
			});	
			$('#tabela').toggle(250);
			carregar_analise();		
		}

		function filtrar_ordenado(ordem='tempo')
		{
			algoritmo = $('#select_alg_busca').val();
			tamanho = $('#select_tamanho_busca').val();
			$('#tabela').hide();
			$('#corpo_tabela').html(null);
			$.getJSON("<?php echo e(asset('testes/DadosTestes')); ?>"+"/"+algoritmo+"/"+tamanho+"/"+ordem, function( data ) 
			{
 				$('#corpo_tabela').html(null);		
				$.each(data, function(index,d)
				{
					$('#corpo_tabela').append(
					"<tr>"+
				       "<td>"+d.algoritimo+"</td>"+		       
				       "<td>"+d.tempo+" Seg</td>"+
				       "<td>"+d.tamanho+"</td>"+
				    "</tr>");
				});
			});	
			$('#tabela').toggle(250);
		}

		function carregar_analise()
		{
			$('#faixas').hide();
			$('#tipos').hide();
			$.getJSON("<?php echo e(asset('testes/FaixasTestes')); ?>", function( data ) 
			{
				$.each(data.faixa_1mb, function(index,d)
				{
					$('#melhor_tempo_1mb').html(d.tempo);
					$('#alg_1_mb').html(d.algoritimo);
					$('#tipo_1mb').html(d.tipo);
				});

				$.each(data.faixa_10mb, function(index,d)
				{
					$('#melhor_tempo_10mb').html(d.tempo);
					$('#alg_10_mb').html(d.algoritimo);
					$('#tipo_10mb').html(d.tipo);
				});

				$.each(data.faixa_20mb, function(index,d)
				{
					$('#melhor_tempo_20mb').html(d.tempo);
					$('#alg_20_mb').html(d.algoritimo);
					$('#tipo_20mb').html(d.tipo);
				});

				$.each(data.faixa_50mb, function(index,d)
				{
					$('#melhor_tempo_50mb').html(d.tempo);
					$('#alg_50_mb').html(d.algoritimo);
					$('#tipo_50mb').html(d.tipo);
				});

				$.each(data.faixa_100mb, function(index,d)
				{
					$('#melhor_tempo_100mb').html(d.tempo);
					$('#alg_100_mb').html(d.algoritimo);
					$('#tipo_100mb').html(d.tipo);
				});

				$.each(data.faixa_500mb, function(index,d)
				{
					$('#melhor_tempo_500mb').html(d.tempo);
					$('#alg_500_mb').html(d.algoritimo);
					$('#tipo_500mb').html(d.tipo);
				});

				$.each(data.faixa_1gb, function(index,d)
				{
					$('#melhor_tempo_1gb').html(d.tempo);
					$('#alg_1_gb').html(d.algoritimo);
					$('#tipo_1gb').html(d.tipo);
				});

				$.each(data.tipo_assimetrica, function(index,d)
				{
					$('#tipo_assimetrica').html(d.algoritimo);
				});

				$.each(data.tipo_simetrica, function(index,d)
				{
					$('#tipo_simetrica').html(d.algoritimo);
				});

				$.each(data.tipo_hash, function(index,d)
				{
					$('#tipo_hash').html(d.algoritimo);
				});

				$.each(data.tipo_leve, function(index,d)
				{
					$('#tipo_blocos').html(d.algoritimo);
				});

				$('#faixas').toggle(200);
				$('#tipos').toggle(200);
			});	
		}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.principal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>