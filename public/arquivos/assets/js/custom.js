function msg_confirm(titulo,texto,onclick)
{
	$('#titulo_msg1').html(titulo);
  	$('#msg_msg1').html(texto);
  	$('#btn_confirmar_mensagem1').attr("onclick",onclick);   
 	$('#mensagem1').modal('show'); 
}

function msg(titulo,texto) 
{
    $('#titulo_msg2').html(titulo);
    $('#msg_msg2').html(texto);
    $('#mensagem2').modal('show'); 
}

// msg('TITULO','Mensagem');
// msg_confirm('<strong>Titulo</strong>','Mensagem',"metodo()"); 