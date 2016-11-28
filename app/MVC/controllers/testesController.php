<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;
use Jenssegers\Blade\Blade;
require __DIR__."/algoritmosController.php";

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class testesController extends controller
{

   protected $algoritmosController;

   public function __construct()
   {
      $this->algoritmosController   =  new algoritmosController();
   }

   public function getIndex()
   {
      $algoritmos = DB::table('pesos')->get();
      echo $this->view('testes.index',compact('algoritmos'));
   }

 

   public function postTestar()
   {
      query('truncate testes_velocidade');
      query('truncate pesos');
      $algoritmos = DB::table('algoritmos')
         // ->where('id','=',14)
            ->get();
      ini_set("max_execution_time", 0);
      $texto = '';  
      $texto = "0"; 
      foreach ($algoritmos as $alg):
         $resultado = $this->testar($alg->nome,$texto);  
         DB::table('testes_velocidade')->insert($resultado);
         DB::table('pesos')->insert(array('nome_algoritmo'=>$alg->nome,'id_algoritmo'=>$alg->id ));    
         $algoritmos = DB::table('testes_velocidade')->get();
         foreach ($algoritmos as $alg):
            DB::table('pesos')->where('nome_algoritmo','=',$alg->algoritimo)->update(  array("_".$alg->peso_tamanho => $alg->peso_tempo)   );
         endforeach;   
      endforeach;      
   }

   private function calcularpesos()
   {
      $testes = query('select * from testes_velocidade');
      foreach ($testes as $teste):
         $this->define_peso_teste($teste->algoritimo,$teste->tamanho,$teste->tempo);
      endforeach;
   }

   private function define_peso_teste($alg,$tamanho,$tempo)
   {
      $tamanho = round($tamanho,2);
      DB::table('pesos')->where('nome_algoritmo','=',$alg)->update(array("_".$tamanho=>$peso));
   }

  

   public function testar($algoritimo,$texto)
   {
      ini_set("max_execution_time", 0);
      set_time_limit(0);
      startExec();

      call_user_func_array(array("algoritmosController","CRIPTOGRAFAR_".$algoritimo), array($texto));
      unset($texto);

      return $this->Processar($algoritimo,endExec());
   }

   public function getTestar()
   {
      POST(['url'=>asset('testes/testar')]);
   }

   public function gerarArquivo($tamanho)
   {
      return (bin2hex(random_bytes(512000 * $tamanho)));
   }


   private function Processar($algoritimo,$T)
   {
      $resultados = array();
      $cont = 0;
      $tempo = 0;
      $tamanho = null;
      $_1_mb    = 1024;
      $_10_mb   = $_1_mb*10;
      $_20_mb   = $_1_mb*20;
      $_30_mb   = $_1_mb*30;
      $_40_mb   = $_1_mb*40;
      $_50_mb   = $_1_mb*50;
      $_60_mb   = $_1_mb*60;


      for ($i=$_1_mb; $i < $_60_mb;):

         switch ($i):
            case $_1_mb:
               $tempo = $T*$i; 
               $tamanho=1;
               $i = $_10_mb;
               break;
            case $_10_mb:
               $tempo = $T*$i; 
               $tamanho=10;
               $i=$_20_mb;               
               break;
            case $_20_mb:
               $tempo = $T*$i;            
               $tamanho=20;
               $i=$_30_mb;               
               break;
            case $_30_mb:
               $tempo = $T*$i;            
               $tamanho=30;
               $i=$_40_mb;               
               break;
            case $_40_mb:  
               $tempo = $T*$i;            
               $tamanho=40;
               $i=$_50_mb;
               break;
            case $_50_mb:
               $tempo = $T*$i;            
               $tamanho=50;
               $i=$_60_mb;               
               break;                        
         endswitch;
         $resultados[$cont]=['algoritimo'=>$algoritimo,'tempo_seg'=>$tempo,'peso_tempo'=>$this->getFaixa_tempo($tempo),'peso_tamanho'=>$this->getFaixa_tamanho($tamanho),'tamanho'=>$tamanho];         
         $cont++;
      endfor;
      $resultados[$cont]=['algoritimo'=>$algoritimo,'tempo_seg'=>$tempo,'peso_tempo'=>$this->getFaixa_tempo($tempo),'peso_tamanho'=>$this->getFaixa_tamanho($tamanho*60),'tamanho'=>1000]; 
      return $resultados;
   }

   private function getFaixa_tempo($tempo)
   {
      $tempo = round($tempo,2);
      return query("select * from faixas_tempo where {$tempo} between de and ate","peso");
   }

   private function getFaixa_tamanho($tamanho)
   {
      $tamanho = round($tamanho,2);
      return query("select * from faixas_tamanho where {$tamanho} between de and ate","peso");
   }

   public function getDadosTestes($algoritmo="",$tamanho="",$ordem="tempo")
   {
      $sql = "select t.id, t.algoritimo, t.tempo_seg as tempo, t.tamanho, a.tipo_cifra as tipo from testes_velocidade t join algoritmos a on t.algoritimo=a.nome where 1=1 ";
      if(($algoritmo!="")&&($algoritmo!='TODOS'))
         $sql.=" and t.algoritimo='{$algoritmo}'";
       if(($tamanho!="")&&($tamanho!='TODOS'))
         $sql.=" and t.tamanho='{$tamanho}'";
      $testes = query($sql." order by {$ordem}");   
      echo json_encode($testes);
   }


   public function getAlgoritmos()
   {
      echo json_encode(query('select * from algoritmos'));
   }
}






