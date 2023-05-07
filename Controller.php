<?php
namespace mute\mvc;
/**
 * Summary of Router
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
class Controller{
    public $layout = 'main';
    /**
     * Summary of middlewares
     * @var array mute\mvc\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [] ;
    public string $action = '';
    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }
    public function render($view,$params = [])
    {
       return Application::$app->router->view->renderView($view,$params,$this->layout);
    }
    public function registerMiddleware(middlewares\BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }
    public function getMiddlewares(){
        return $this->middlewares;
    }
}
