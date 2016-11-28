<?php
use Jenssegers\Blade\Blade;
class controller
{
    private $blade;
    
	public function model($model)
    {
    	$model.='Model';
        require_once  __DIR__.'/../../MVC/models/' . $model . '.php';
        return new $model();
    }

    public function view($view,array $dados = [])
    {
        Controller::limpar_cache();        
        $this->blade = new Blade( __DIR__.'/../../MVC/views/', __DIR__.'/../../../public/arquivos/cache');
        return $output = $this->blade->make($view,$dados)->render();        
    }

    public function getModel()
    {
        return $this->model;
    }

    public function limpar_cache()
    {
        if(LIMPAR_CACHE)
        {   
            $diretorio = scandir(__DIR__.'/../../../public/arquivos/cache');
            foreach ($diretorio as $arquivo) 
            {
                if(($arquivo!='..')&&($arquivo!='.'))
                    unlink(__DIR__.'/../../../public/arquivos/cache/'.$arquivo);
            }
        }
    }
  


}


