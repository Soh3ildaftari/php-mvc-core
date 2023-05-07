<?php
namespace mute\mvc;
/**
 * Summary of Router
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
class Router
{
    //set path's of request and their Method by a nasted array
    protected array $routes= [ [ 'get' => [     ] , 'post' => [    ] ] ] ;
    //Create prop request and assign it inside contractor
    public Request $request; 
    // create constructor that passes Request as arg
    public Response $response;
    //
    public View $view;
    public function __construct(Request $request){
        $this->request = $request;
        $this->response = new Response();
        $this->view = new View();
    }
    //set func get to save callback funcs for get method on path
    public function get($path,$callback){
        $this -> routes ['get'] [$path] = $callback ;
    }   
    //
    public function post($path,$callback){
        $this -> routes ['post'] [$path] = $callback ;
    }   
    //

    //create func to render view for given path 

    //resolve
    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;   
        if ($callback === false) {
            Application::$app->response->setStatusCode(404);
            $this->response->setStatusCode(404);
            $e = new exception\NotfoundException();
            return $this->view->renderView('_error',['exception'=> $e ]);
            }

        if (is_string($callback)) {
            return $this->view->renderView($callback);
            }
        if (is_array($callback)){
            /** @var $controller mute\mvc\Controller */
            $controller =& Application::$app->controller;
            $callback[0] = new $callback[0](); 
            $controller = $callback[0];
            $controller->action = $callback[1];
            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
            
        }
        
        return call_user_func($callback, $this->request);
    }
}