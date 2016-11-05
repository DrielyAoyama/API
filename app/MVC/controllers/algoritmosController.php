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

use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Crypto\Signature\Signer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\Signature\DerSignatureSerializer;
//classes de seleção de algoritimo (E)

class algoritmosController extends controller
{
   protected $tempo_inicio;
   protected $chave;

   public function __construct()
   {
      $this->model = $this->model('algoritmos');
   }


   public function Criptografar($id_alg,$texto)
   {
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
         registralog('Codificação',$algoritmo,$id_alg,$tempo);
         $this->CalcularMediaTempo($id_alg);
         $this->IncrementarQtdeExecucoes($id_alg);
         return ['codificado'=>$criptografado,'algoritmo'=>$algoritmo,'tempo_processamento'=>$tempo];
      }
   }


   public function SelecionarAlgoritmo($auto_selecao=true,$nome_algoritmo="")
   {
      ini_set("max_execution_time", 0);
      $sql = "";
      $achou = true;
      $array_algoritmos_encontrados = array();
      // echo DINAMICO__PESO_TAMANHO;exit();
      if($auto_selecao)
      {
         //parametros fixos

         $pesos = query("select nome_algoritmo from pesos where _".DINAMICO__PESO_TAMANHO."=".DINAMICO__PESO);
         if(count($pesos)<=0)
            $achou=false;
         else
            $achou=true;


         $contador = 1;
         while (!$achou) 
         {
            $pesos = query("select nome_algoritmo from pesos where _".DINAMICO__PESO_TAMANHO."=".(DINAMICO__PESO-$contador));
            if(count($pesos)<=0)
               $achou=false;
            else
               $achou=true;
            $contador++;            
         }




         foreach ($pesos as $alg):
            array_push($array_algoritmos_encontrados, $alg->nome_algoritmo);
         endforeach;



         $algoritmos = $this->model->join('niveis','niveis.id_algoritmo','=','algoritmos.id')
               ->select('algoritmos.*')
                  // ->where('algoritmos.decodificavel','=',DINAMICO__DECODIFICAVEL)
                     ->whereIn('algoritmos.nome',$array_algoritmos_encontrados)
                        ->where('niveis.nivel','=',DINAMICO__NIVEL)
                           ->orderby('niveis.nivel')
                              ->get();

         if(count($algoritmos)<=0)
            $achou=false;
         else
            $achou=true;

         $contador = 1;
         while (!$achou) 
         {
            $algoritmos = $this->model->join('niveis','niveis.id_algoritmo','=','algoritmos.id')
               ->select('algoritmos.*')
                  // ->where('algoritmos.decodificavel','=',DINAMICO__DECODIFICAVEL)
                     ->whereIn('algoritmos.nome',$array_algoritmos_encontrados)
                        ->where('niveis.nivel','=',(DINAMICO__NIVEL+$contador))
                           ->orderby('niveis.nivel')
                              ->get();

            if(count($algoritmos)<=0)
               $achou=false;
            else
               $achou=true;
            $contador++;            
         }

         // print_r($algoritmos);exit();

      }
      else
         $algoritmos = $this->model->where('nome','=',trim($nome_algoritmo))->get();

      // retorna o maior nivel
      if(count($algoritmos)>0)    
         return $algoritmos[0]->id;
      else
         return 0;
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


   // public function AtualizarNivel($alg_id,$nivel)
   // {
   //    $algoritmo = $this->model->findOrFail($alg_id);
   //    $algoritmo->nivel = $nivel;
   //    $algoritmo->save();
   // }


   public function IncrementarQtdeExecucoes($id_alg)
   {
      $algoritmo = $this->model->findOrFail($id_alg);
      $algoritmo->qtde_execucoes = $algoritmo->qtde_execucoes+1;
      $algoritmo->save();
   }
  



   public function CRIPTOGRAFAR_AES_128_BITS($texto,$id_alg=0)
   {
      $chave = AES::keygen( AES::KEYGEN_128_BITS,$texto);
      $aes   = new AES( $chave );
      return $aes->encrypt( $texto );
   }

   public function CRIPTOGRAFAR_AES_192_BITS($texto,$id_alg=0)
   {
      $chave = AES::keygen( AES::KEYGEN_192_BITS,$texto);
      $aes   = new AES( $chave );
      return $aes->encrypt( $texto );
   }

   public function CRIPTOGRAFAR_AES_256_BITS($texto,$id_alg=0)
   {
      $tempo_inicio = microtime(true);
      $chave = AES::keygen( AES::KEYGEN_256_BITS,$texto);
      $aes   = new AES( $chave );
      return $aes->encrypt( $texto );
   }



   public function CRIPTOGRAFAR_REVERSE($texto,$id_alg=0)
   {
      $reverse = new Reverse();
      $reverse->chave = rand();
      $reverse->add_text = md5(sha1($chave));
      return  $reverse->enc($texto);
   }

   public function DECODIFICAR_REVERSE($texto_codificado,$chave,$id_alg=0)
   {
      $reverse = new Reverse();
      return  md5(sha1($chave));
   }

   public function CRIPTOGRAFAR_CRYPT_ONE_WAY($texto,$id_alg=0)
   {
      $chave = GerarChaveAleatoria(56,false,false,false);  
      return crypt($texto, $chave = GerarChaveAleatoria(100, false, true, true));
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
      $rsa->loadKey($publickey);
      $codificado = $rsa->encrypt($texto);
      $rsa->loadKey($publickey);
      return ($codificado);
   } 

   public function CRIPTOGRAFAR_3DES($texto,$id_alg=0)
   {
      $cipher = new Crypt_TripleDES(); // could use CRYPT_DES_MODE_CBC or CRYPT_DES_MODE_CBC3
      $cipher->setKey($chave = GerarChaveAleatoria(24,false,false,false));
      // the IV defaults to all-NULLs if not explicitly defined
      $cipher->setIV(crypt_random_string($cipher->getBlockLength() >> 3));
      $plaintext = $texto;
      $codificado = $cipher->encrypt($plaintext);
      return ($codificado);
   } 

   public function CRIPTOGRAFAR_DES($texto,$id_alg=0)
   {
      $cipher = new Crypt_DES();
      $cipher->setKey($chave = GerarChaveAleatoria(24,false,false,false));
      $cipher->setIV(crypt_random_string($cipher->getBlockLength() >> 3));
      $plaintext = $texto;
      $codificado = $cipher->encrypt($plaintext);
      return  ($codificado);
   }    

   public function CRIPTOGRAFAR_ECC($texto,$id_alg=0)
   {     
      $adapter = EccFactory::getAdapter();
      $generator = EccFactory::getNistCurves()->generator384();
      $useDerandomizedSignatures = true;
      $algorithm = 'sha256';
      $pemSerializer = new PemPrivateKeySerializer(new DerPrivateKeySerializer($adapter));
      $keyData = file_get_contents(PASTA_VENDOR.'/mdanter/ecc/tests/data/openssl-priv.pem');
      $key = $pemSerializer->parse($keyData);
      $document = $texto;
      $signer = new Signer($adapter);
      $hash = $signer->hashData($generator, $algorithm, $document);
      if ($useDerandomizedSignatures) {
          $random = \Mdanter\Ecc\Random\RandomGeneratorFactory::getHmacRandomGenerator($key, $hash, $algorithm);
      } else {
          $random = \Mdanter\Ecc\Random\RandomGeneratorFactory::getRandomGenerator();
      }

      $randomK = $random->generate($generator->getOrder());
      $signature = $signer->sign($key, $hash, $randomK);

      $serializer = new DerSignatureSerializer();
      $serializedSig = $serializer->serialize($signature);
      return  base64_encode($serializedSig) . PHP_EOL;
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