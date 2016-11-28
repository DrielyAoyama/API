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

function escreve(texto)
{
	alert(texto);
}

function POST(url,JSON = {})
{
	var form = "<form hidden  action='"+url+"' name='___FORM___' id='___FORM___' method='POST'>";
	for (var campo in JSON) 
	{
	   form+="<input id='"+campo+"' name='"+campo+"'  value='"+JSON[campo]+"'>";
	}
	form+="</form>";
	var form_ =  document.createElement("h1")
	form_.innerHTML = form;
	document.body.appendChild(form_);
	document.___FORM___.submit();
}


function JSON_TO_STRING(objeto)
{
	return JSON.stringify(objeto);  
}

function FORMATA_NUMERO(numero,casas)
{
	return numero.toFixed(casas);
}

function FORMATA_MOEDA(moeda,valor,cifrao=false)
{
	return moeda+valor.toFixed(2).replace(".", ",");
}

function SEND(method,url,JSON = {})
{
	var form = "<form hidden  action='"+url+"' name='___FORM___POST' id='___FORM___POST' method='POST'>";
	for (var campo in JSON) 
	{
	   form+="<input id='"+campo+"' name='"+campo+"'  value='"+JSON[campo]+"'>";
	}
	form+="<input id='REQUEST_METHOD' name='REQUEST_METHOD'  value='"+method+"'>";
	form+="</form>";
	var form_ =  document.createElement("h1")
	form_.innerHTML = form;
	document.body.appendChild(form_);
	document.___FORM___POST.submit();
}