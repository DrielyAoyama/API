<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;


require __DIR__."/../../algoritmos/nsa/simon/simon.php";    
require __DIR__."/../../algoritmos/nsa/speck/speck.php";    
require __DIR__."/../../algoritmos/nsa/simeck/simeck.php";    
require __DIR__."/../../algoritmos/aes.class.php";
require __DIR__."/../../algoritmos/phpseclib/Crypt/TripleDES.php";
require __DIR__."/../../algoritmos/phpseclib/Crypt/Random.php";
require __DIR__."/../../algoritmos/phpseclib/Crypt/RSA.php";
require __DIR__."/../../algoritmos/ascii85.php";
require __DIR__."/../../algoritmos/rc4.php";
require __DIR__."/../../algoritmos/reverse.php";
use \Mdanter\Ecc\EccFactory;
use \Mdanter\Ecc\Message\MessageFactory;
//classes de seleção de algoritimo (E)

class algoritmosController extends controller
{
   protected $tempo_inicio;
   protected $chave_privada;
   protected $chave_publica;

   public function __construct()
   {
      $this->model = $this->model('algoritmos');
      $chave_chave_privada = "";
      $chave_publica = "";
   }

   public function desCriptografar($protocolo,$mensagem)
   {
      $row_protocolo = query("select * from protocolos where protocolo='{$protocolo}'",false);
      $privada       = pack('H*', $this->pad_string($row_protocolo->chave_privada,32));
      $publica       = pack('H*', $this->pad_string($protocolo,32));
      $privada2      = pack('H*', $this->pad_string($mensagem,32));

      return (openssl_decrypt(base64_decode($row_protocolo->origem), 'aes-256-cbc', $publica.$privada2.PHP_EOL, OPENSSL_RAW_DATA, $privada));
   }


   public function Criptografar($id_alg,$texto,$id_usuario)
   {
      $chave_publica = "";
      $chave_chave_privada = "";
      ini_set("max_execution_time", 0);
      if($id_alg==0)
         return ['codificado'=>$texto,'algoritmo'=>"NENHUM",'tempo_processamento'=>0];

      $algoritmo_escolhido = $this->model->findOrFail($id_alg);     

      // busca neste arquivo se existe um metodo com o nome CRIPTOGRAFAR_NOME_DO_ALGORITIMO_ESCOLHIDO()
      if(method_exists('algoritmosController', "CRIPTOGRAFAR_".$algoritmo_escolhido->nome ))
      {
         // executa  o metodo escolhido passando seus parametros 
         startExec();
         $criptografado = call_user_func_array(array("algoritmosController","CRIPTOGRAFAR_".$algoritmo_escolhido->nome), array($texto,$id_alg));
         $tempo = endExec();
         $algoritmo = DB::table('algoritmos')->find($id_alg)->nome; 
         $criptografado = $this->registraprotocolo($texto,$criptografado,$protocolo=$this->criar_protocolo(),endExec(),$id_alg,$id_usuario);
         $this->IncrementarQtdeExecucoes($id_alg);
         return ['codificado'=>$criptografado,'protocolo'=>$protocolo];
      }
   }

   private function criar_protocolo()
   {
      $novo = false;
      while(!$novo):
         $protocolo = GerarChaveAleatoria(30,true,true,true);          
         $protocolo = sha1(md5($protocolo));
         $result = query("select * from protocolos where protocolo='{$protocolo}'");
         if(count($result)<=0)
            $novo=true;
      endwhile;

      return  $protocolo;
   }

   private function registraprotocolo($texto,$criptografado,$protocolo,$tempo,$id_alg,$id_usuario)
   {
      $novo = false;
      while(!$novo):
         $chave_privada = GerarChaveAleatoria(30,true,true,true);          
         $chave_privada = sha1(md5($protocolo));
         $result = query("select * from protocolos where protocolo='{$chave_privada}'");
         if(count($result)<=0)
            $novo=true;
      endwhile;

      $privada     = pack('H*', $this->pad_string($chave_privada,32));
      $publica     = pack('H*', $this->pad_string($protocolo,32));
      $privada2    = pack('H*', $this->pad_string($criptografado = bin2hex($criptografado),32));

      $origem = base64_encode(openssl_encrypt($texto, 'aes-256-cbc', $publica.$privada2.PHP_EOL, OPENSSL_RAW_DATA, $privada));
      DB::table('protocolos')->insert(['protocolo' =>$protocolo,
                                       'chave_privada'=>$chave_privada,
                                       'tempo_processamento' => $tempo,
                                       'algoritmo' => $id_alg,
                                       'client_id' => $id_usuario,
                                       "origem"=>$origem]);
      return $criptografado;
   }

   public function SelecionarAlgoritmo($auto_selecao=true,$nome_algoritmo="")
   {
      ini_set("max_execution_time", 0);
      $sql = "";
      $achou = true;
      $array_algoritmos_encontrados = array();
      if($auto_selecao)
      {
         $resultado = query("select id_algoritmo from pesos where _".TAMANHO."=".TEMPO_PROCESSAMENTO);
         $algoritmos_selecionados = $this->getSelecionados($resultado,'id_algoritmo');
       
         $resultado = DB::table('niveis')
            ->wherein('id_algoritmo',$algoritmos_selecionados)
               ->where('nivel','=',NIVEL)
                  ->get();

         $algoritmos_selecionados = $this->getSelecionados($resultado,'id_algoritmo');

      }
      else
      {
         $resultado = $this->model->where('nome','=',trim($nome_algoritmo))->get();
         $algoritmos_selecionados = $this->getSelecionados($resultado,'id');
      }
      
      if(count($algoritmos_selecionados)>0)    
         return $algoritmos_selecionados[0];
      else
         return 0;
   }

   private function getSelecionados($resultado,$campo)
   {
      $array= array();
      foreach ($resultado as $linha):
         array_push($array,$linha->{$campo});
      endforeach;
      return $array;
   }

   public function CalcularMediaTempo($id_alg)
   {
      $algoritmos = DB::table('log')->where('algoritmo_id','=',$id_alg)->get();
      $media = 0;
      $soma  = 0;
      if (count($algoritmos)>0) :
         foreach ($algoritmos as $algoritmo) :
            $soma += $algoritmo->tempo_processamento;
         endforeach;
         $media = $soma/(count($algoritmos));
      endif;      
      $algoritmo = $this->model->findOrFail($id_alg);
      $algoritmo->media_tempo_processamento = $media;
      $algoritmo->save();
   }


   public function IncrementarQtdeExecucoes($id_alg)
   {
      $algoritmo = $this->model->findOrFail($id_alg);
      $algoritmo->qtde_execucoes = $algoritmo->qtde_execucoes+1;
      $algoritmo->save();
   }
  

   public function CRIPTOGRAFAR_AES_128_BITS($texto,$id_alg=0)
   {
      $chave_publica = AES::keygen( AES::KEYGEN_128_BITS,$texto);
      $aes   = new AES($chave_publica);
      return $aes->encrypt( $texto );
   }

   public function CRIPTOGRAFAR_AES_192_BITS($texto,$id_alg=0)
   {
      $chave_publica = AES::keygen( AES::KEYGEN_192_BITS,$texto);
      $aes   = new AES( $chave_publica );
      return $aes->encrypt( $texto );
   }

   public function CRIPTOGRAFAR_AES_256_BITS($texto,$id_alg=0)
   {
      $tempo_inicio = microtime(true);
      $chave_publica = AES::keygen( AES::KEYGEN_256_BITS,$texto);
      $aes   = new AES( $chave_publica );
      return $aes->encrypt( $texto );
   }



   public function CRIPTOGRAFAR_REVERSE($texto,$id_alg=0)
   {
      $reverse = new Reverse();
      $reverse->chave = rand();
      $chave_publica =  $reverse->chave;
      $reverse->add_text = md5(sha1($texto));
      return  $reverse->enc($texto);
   }

   public function DECODIFICAR_REVERSE($texto_codificado,$chave,$id_alg=0)
   {
      $reverse = new Reverse();
      return  md5(sha1($chave));
   }

   public function CRIPTOGRAFAR_CRYPT_ONE_WAY($texto,$id_alg=0)
   {
      return crypt($texto, $chave_publica = GerarChaveAleatoria(100, false, true, true));
      return $criptografado;
   }

   public function CRIPTOGRAFAR_MD5($texto,$id_alg=0)
   {
      return md5($texto);
   } 

   public function CRIPTOGRAFAR_RSA($texto,$id_alg=0)
   {
      $rsa = new Crypt_RSA();
      extract($rsa->createKey()); 
      $chave_publica = $publickey;
      $rsa->loadKey($publickey);
      $codificado = $rsa->encrypt($texto);
      // $rsa->loadKey($private);
      // $chave_chave_privada = $private;
      return ($codificado);
   } 

   public function CRIPTOGRAFAR_3DES($texto,$id_alg=0)
   {
      $cipher = new Crypt_TripleDES(); // could use CRYPT_DES_MODE_CBC or CRYPT_DES_MODE_CBC3
      $cipher->setKey($chave_publica = GerarChaveAleatoria(24,false,false,false));
      // the IV defaults to all-NULLs if not explicitly defined
      $cipher->setIV(crypt_random_string($cipher->getBlockLength() >> 3));
      $codificado = $cipher->encrypt($texto);
      return ($codificado);
   } 

   public function CRIPTOGRAFAR_DES($texto,$id_alg=0)
   {
      $cipher = new Crypt_DES();
      $cipher->setKey($chave_publica = GerarChaveAleatoria(24,false,false,false));
      $cipher->setIV(crypt_random_string($cipher->getBlockLength() >> 3));
      $codificado = utf8_encode($cipher->encrypt($texto));
      return  ($codificado);
   }    

   public function CRIPTOGRAFAR_ECC($texto,$id_alg=0)
   {           
      $math = EccFactory::getAdapter();
      $generator = EccFactory::getNistCurves()->generator256();
      $alice = $generator->createPrivateKey();
      $messages = new MessageFactory($math);
      $message = $messages->plaintext($texto, 'sha256');
      $aliceDh = $alice->createExchange($messages, $chave_publica = $alice->getPublicKey());
      return $aliceDh->encrypt($message)->getContent() . PHP_EOL;;
   }

   public function CRIPTOGRAFAR_SHA1($texto,$id_alg=0)
   {
      return sha1($texto);
   }

   public function CRIPTOGRAFAR_SHA256($texto,$id_alg=0)
   {
      return hash('sha256', $texto);
   }

   public function CRIPTOGRAFAR_SHA512($texto,$id_alg=0)
   {
      return hash('sha512', $texto);
   }

   public function CRIPTOGRAFAR_SIMON($texto,$id_alg=0)
   {
      $simon = new Simon($texto);  
      return $simon->criptografar(); 
   }

   public function CRIPTOGRAFAR_SPECK($texto,$id_alg=0)
   {
      $speck = new speck($texto);
      return $speck->criptografar();
   }

   public function CRIPTOGRAFAR_SIMECK($texto,$id_alg=0)
   {
      $speck = new simeck($texto);
      return $speck->criptografar();
   }

   private function pad_string($string,$len)
   {
      $string = substr($string, 1,32);
      if(strlen($string)<$len)
      {
         $faltantes = ($len - strlen($string));
         for ($i=0; $i < $faltantes ; $i++): 
            $string.="0";
         endfor;
      }
      return $string;
   }
}

function GerarChaveAleatoria($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
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



