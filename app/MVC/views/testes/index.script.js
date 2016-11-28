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

		$.post("{{asset('testes/Testar')}}", { Algoritmo: $('#select_alg').val()})
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
	$.getJSON("{{asset('testes/algoritmos')}}", function( data ) 
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
	$.getJSON("{{asset('testes/DadosTestes')}}", function( data ) 
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
	$.getJSON("{{asset('testes/DadosTestes')}}"+"/"+algoritmo+"/"+tamanho+"/"+ordem, function( data ) 
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
