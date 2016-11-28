<?php
use Illuminate\Database\Capsule\Manager as DB;


function json_response($code = 200, $message = null)
{
	// clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
        );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    return json_encode(array(
        'status' => $code < 300, // success or not?
        'resposta' => $message
        ));
}

function array_upper_case($array)
{
	return array_change_key_case(array_flip($array), CASE_UPPER);
} 

function strToBin($input)
{
    if (!is_string($input))
        return false;
    $ret = '';
    for ($i = 0; $i < strlen($input); $i++)
    {
        $temp = decbin(ord($input{$i}));
        $ret .= str_repeat("0", 8 - strlen($temp)) . $temp;
    }
    return $ret;
}


function getInfo($valor,$tabela,$campo=1,$operador='=',$comparador=1)
{
	foreach(DB::table($tabela)->where($campo,$operador,$comparador)->get() as $row)
		return $row->{$valor};
}

function registralog($log = "",$algoritmo_desc,$algoritmo_id,$tempo_processamento=0,$protocolo)
{
	DB::table('log')->insert(['descricao' =>$log,'algoritmo_id'=>$algoritmo_id,'algoritmo_desc'=>$algoritmo_desc,'tempo_processamento'=>$tempo_processamento, 'protocolo' => $protocolo,'created_at'=>date("Y-m-d H:i:s")]);
}

function asset($diretorio = "",$url = "")
{
	return $url = 'http://'.$_SERVER['SERVER_NAME'].'/'.PASTA_PROJETO.'/'.$diretorio;
}

function gerarpdf($html ="",$arq= "PDF_TEMPORARIO",$donwload = false, $tamanho='A4',$formato="portrait")
{
	if(isset($dompdf))
		unset($dompdf);
	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);
	$dompdf->setPaper($tamanho, $formato);
	$dompdf->render();
	$dompdf->stream($arq, array("Attachment" => $donwload));
	unset($dompdf);
}

function redirecionar($caminho)
{
    header("location:$caminho");
}

function voltar()
{
	echo '<script>window.history.back();</script>';
}

function limitarTexto($texto, $limite, $adicao =""){
  $contador = strlen($texto);
  if ( $contador >= $limite ) {      
      $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . $adicao;
      return $texto;
  }
  else{
    return $texto;
  }
} 

function criardiretorio($diretorio ="")
{
	if (!is_dir($diretorio))
		mkdir($diretorio);
}

function enviarEmail($para,$assunto,$texto,$anexo="")
{	
	$configuracoes_gerais = getConfiguracoesGerais(1);
	$mail = new PHPMailer;
	// $mail->SMTPDebug  = 2; 
	$mail->isSMTP();    
	$mail->CharSet = 'UTF-8';                               
	$mail->Host = $configuracoes_gerais['smtp_email_adm'];
	if($configuracoes_gerais['autentica_email_adm']=="S")
		$mail->SMTPAuth = true;  
	else 
		$mail->SMTPAuth = false;  
	$mail->Username = $configuracoes_gerais['email_adm'];            
	$mail->Password = $configuracoes_gerais['senha_email_adm'];                     
	$mail->Port = $configuracoes_gerais['porta_email_adm'];                                    

	$mail->setFrom($configuracoes_gerais['email_adm'],APP_NOME);
	$mail->addAddress($para);    

	if(!$anexo=="")
		$mail->addAttachment($anexo);       

	$mail->isHTML(true);                                

	$mail->Subject = $assunto;
	$mail->Body    = $texto;

	if(!$mail->send()) {
	    return false;
	} else {
	    return true;
	}
}

function vazio($variavel)
{
	if ((isset($variavel)) && ($variavel!="") && (trim($variavel)!="") && (!is_null($variavel)))
		return false;
	else
		return true;
}


function query($sql,$campo=null)
{
	if(is_null($campo))
	{
		$resultado = DB::select(DB::raw($sql));
		return $resultado;
	}
	else
	{
		if($campo==false)
		{
			$query = DB::select(DB::raw($sql));
			return $query[0];
		}
		else
		{
			$query = DB::select(DB::raw($sql));
			return $query[0]->{$campo};
		}
	}
}

function _route($string)
{
	return strtoupper($string);
}

function POST($info=[],$redirecionar = true)
{
	if($redirecionar)
	{
		$form = "<form hidden action='{$info['URL']}' name='___FORM___' id='___FORM___' method='POST'>";
		foreach ($info['DADOS'] as $campo => $valor):
			$form.="<input id='{$campo}' name='{$campo}' value='$valor'>";
		endforeach;		
		$form.="</form>
		<script type=\"text/javascript\"> 
                window.onload=function()
                {
                    document.forms['___FORM___'].submit();
                }
       </script>";
       echo $form;
	}
	else
	{
		$url= $info['URL'];
		$request = array('http' =>
						          array(
						              'method'  => $info['METODO'],
						              'header'  => 'Content-type: application/x-www-form-urlencoded',
						              'content' => $info['DADOS'],
						          )
		      			);
		$contexto  = stream_context_create($request);
		return file_get_contents($url, false, $contexto);
	}	
}