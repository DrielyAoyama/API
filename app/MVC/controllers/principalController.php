<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;
use Jenssegers\Blade\Blade;


use Mdanter\Ecc\Crypto\Signature\Signer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\Signature\DerSignatureSerializer;
require __DIR__."/usuariosController.php";
require __DIR__."/parametrosController.php";
require __DIR__."/algoritmosController.php";

class principalController extends controller
{

   protected $usuariosController;
   protected $parametrosController;
   protected $algoritmosController;

	public function __construct()
	{
      $this->usuariosController   = new usuariosController();
      $this->parametrosController = new parametrosController();
      $this->algoritmosController = new algoritmosController();


	}




   //temporário
   public function getGerarchave($id=0)
   {
      $model = $this->usuariosController->getModel();
   }

	public function getIndex()
	{
		echo $this->view('principal.index');
	}	


   public function getTestar()
   {
     echo  json_encode('testes');
   }
   
  

   public function getCodificar($JSON)
   {
      try
      {
         // recebe como parameto um JSON com todos os dados da requisicao
         // e o converte em um objeto para utiliza-lo
         $request = (object) json_decode($JSON);

         // verifica se a chave fornecida pelo cliente é valida, se sim ele guardará na sessão
         // os dados deste cliente para utiliza-las futuramente
         if($this->usuariosController->validaUsuario($request->client_id,$request->client_token))
         {
            // executa o metodo Configura Ambiente (parametros controller), que pega as configurações FIXAS 
            // do cliente e parametriza a ferramenta antes da processo de codificação
            //CLASSE D
            // $this->parametrosController->ConfiguracaoFixaAmbiente(Auth('id'));

            $this->parametrosController->ConfiguracaoDinamicaAmbiente($request);

            // Seleciona o algoritmo que será utilizado apartir da analise parametros enviados pelo cliente
            // e os parametros fixos

            $algoritmo="";  
            if(isset($request->algoritmo))
            {
               $autoselecao=false;
               $algoritmo=$request->algoritmo;
            }
            else
               $autoselecao=true; 

            $this->parametrosController->DefinePesoTamanho($request->texto); 

            $algoritmo_selecionado = $this->algoritmosController->SelecionarAlgoritmo($autoselecao,$algoritmo);
            
            //executa a codificação do texto de acordo com os parametros anteriormente calculados

            $criptografado = $this->algoritmosController->Criptografar($algoritmo_selecionado,$request->texto);

            try 
            {
               $app = new AppSec();
               $app->response()->header('Content-Type', 'application/json;charset=utf-8');
               // retornar chave do processamento
               $app->get("/",
                              function($criptografado)
                              {
                                 $REPOSTAS = [  "criptografado"=>utf8_encode($criptografado['codificado'])  ];
                                 return json_encode(["mensagem"=>utf8_encode($criptografado['codificado']),"protocolo"=>$criptografado['protocolo']  ]);
                              },
                              ['criptografado'=>$criptografado]
                        );
               // :apiresponse
               echo $app->run();
            } 
            catch (Exception $e) 
            {
                echo json_encode($e,JSON_UNESCAPED_UNICODE);
            }        
         }
         // $this->sair();
      }
      catch (Exception $erro) 
      {
         echo json_response(200, "ERRO - EXCEPTION ".$erro);
      }
   }

   private function sair()
   {
      LimpaUsuario();
   }

   private function GerarChaveAleatoria($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
   {
           // Caracteres de cada tipo
      $lmin = 'abcdefghijklmnopqrstuvwxyz';
      $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $num = '1234567890';
      $simb = '!@#$%*-';
      // Variáveis internas
      $retorno = '';
      $caracteres = '';
      // Agrupamos todos os caracteres que poderão ser utilizados
      $caracteres .= $lmin;
      if ($maiusculas) $caracteres .= $lmai;
      if ($numeros) $caracteres .= $num;
      if ($simbolos) $caracteres .= $simb;
      // Calculamos o total de caracteres possíveis
      $len = strlen($caracteres);
      for ($n = 1; $n <= $tamanho; $n++) {
      // Criamos um número aleatório de 1 até $len para pegar um dos caracteres
      $rand = mt_rand(1, $len);
      // Concatenamos um dos caracteres na variável $retorno
      $retorno .= $caracteres[$rand-1];
      }
      return $retorno;
   }



}