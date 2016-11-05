<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;
use Jenssegers\Blade\Blade;

class usuariosController extends controller
{

	public function __construct()
	{
		$this->model = $this->model('usuarios');
	}

   public function getLogin()
   {
      echo $this->view('usuarios.login');
   }

   public function postLogar()
   {

      $senha = md5($_POST['senha']);
      $email = $_POST['email'];
      $usuario = query("select * from usuarios where email = '{$email}' and senha='{$senha}'");
      if(count($usuario)<=0)
         echo json_encode("NAO");
      else
      {
         SalvaUsuario(array('id'=>$usuario[0]->id));
         echo json_encode("SIM");
      }
   }
   
   public function getSair()
   {
      LimpaUsuario();
      redirecionar(asset(''));
   }

   //temporário
   public function getGerarchave($id)
   {
      $u = $this->model->where('id','=',$id)->get();
      echo md5(base64_encode($u[0]->nome)).md5(base64_encode($u[0]->email)); 
   }


   public function validaUsuario($client_id,$client_token)
   {
      if(count($usuario = query("select * from usuarios where client_id='{$client_id}' and client_token='{$client_token}'"))>0)
      {
         SalvaUsuario(array('client_id'=>$usuario[0]->client_id,'client_token'=>$usuario[0]->client_token,'id'=>$usuario[0]->id,'nome'=>$usuario[0]->nome,'email'=>$usuario[0]->email,'client_id'=>$usuario[0]->client_id,'client_token'=>$usuario[0]->client_token));
         return true;
      }
      else
      {
         return false;
      }
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

   private function criar_token()
   {
      $novo = false;
      while(!$novo):
         $client_id = $this->GerarChaveAleatoria(30,true,true,true);          
         $client_id = sha1(md5($client_id));

         $client_token = $this->GerarChaveAleatoria(30,true,true,true);          
         $client_token = sha1(md5($client_token));

         $result = query("select * from usuarios where client_id='{$client_id}' and client_token='{$client_token}'");
         if(count($result)<=0)
            $novo=true;
      endwhile;

      return ['client_id'=>$client_id,'client_token'=>$client_token];
   }

	
}