<?php $__env->startSection('titulo','Testes'); ?>

<?php $__env->startSection('conteudo'); ?>
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
				    	<?php foreach($algoritmos as $alg): ?>
				    	<tr>
					        <td class="text-center"><strong><?php echo e($alg->nome_algoritmo); ?></strong></td>
					        <td class="text-center"><?php echo e($alg->_1); ?></td>
					        <td class="text-center"><?php echo e($alg->_2); ?></td>
					        <td class="text-center"><?php echo e($alg->_3); ?></td>
					        <td class="text-center"><?php echo e($alg->_4); ?></td>
					        <td class="text-center"><?php echo e($alg->_5); ?></td>
					        <td class="text-center"><?php echo e($alg->_6); ?></td>
					        <td class="text-center"><?php echo e($alg->_7); ?></td>
				      	</tr>
				    	<?php endforeach; ?>	      
				    </tbody>
				  </table>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.principal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script>
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

</script>