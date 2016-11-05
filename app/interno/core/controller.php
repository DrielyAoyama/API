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
        $this->blade = new Blade( __DIR__.'/../../MVC/views/', __DIR__.'/../../../public/arquivos/cache');
        return $output = $this->blade->make($view,$dados)->render();        
    }

    public function getModel()
    {
        return $this->model;
    }


}

