<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;
use Jenssegers\Blade\Blade;

class parametrosController extends controller
{

	public function __construct()
	{
		$this->model = $this->model('parametros');
	}


 

   //temporário, apagar depois
   public function getGerarchave($id)
   {
      $u = $this->usuarios->where('id','=',$id)
         ->get();
      echo md5(base64_encode($u[0]->nome)).md5(base64_encode($u[0]->email)); 
   }


   public function validaUsuario($chave)
   {
      if(count($this->model->where('chave','=',$chave)->get())>0)
         return true;
      else
         {
            reponderJSON('Erro ao validar usuario !!!');
            exit();
         }
   }

   // public function ConfiguracaoFixaAmbiente($usuario_id)
   // {
   //    $parametros = $this->model->where('usuario','=',$usuario_id)->get();

   //    //define o tempo limite de acordo com a parametrização
   //    if(count($parametros)>0)
   //    {
   //       define("FIXO__TEMPO_LIMITE_DE_EXECUCAO"    ,  $parametros[0]->tempo_limite);
   //       define("FIXO__NIVEL_MINIMO_DE_SEGURANCA"   ,  $parametros[0]->nivel_minimo );
   //       define("FIXO__NIVEL_MAXIMO_DE_SEGURANCA"   ,  $parametros[0]->nivel_maximo );
   //    }
   //    else
   //    {
   //       reponderJSON('Erro ao configurar ambiente !!!');
   //       exit();
   //    }
   // }

   public function ConfiguracaoDinamicaAmbiente($request)
   {
      if(isset($request->tempo_processamento))
         define("DINAMICO__PESO_TEMPO",$request->tempo_processamento);
      else
         define("DINAMICO__PESO_TEMPO",null);
         
      if(isset($request->nivel))
         define("DINAMICO__NIVEL",$request->nivel);
      else
         define("DINAMICO__NIVEL",null);
      // if(isset($request->decodificavel))
      //    define("DINAMICO__DECODIFICAVEL",$request->decodificavel);
      // else
      //    define("DINAMICO__DECODIFICAVEL",null);

      if(isset($request->tamanho))
         define("DINAMICO__PESO",$request->tamanho);
      else
         define("DINAMICO__PESO",null);


      // definir tamanho medio do arquivo
   }

   public function DefinePesoTamanho($texto)
   {
      //tamanho em mb
      $tamanho_texto = strlen($texto)/1048576;
      $peso = query("select peso from faixas_tamanho where {$tamanho_texto} between de and ate","peso");
      define("DINAMICO__PESO_TAMANHO",$peso);
   }

	
}