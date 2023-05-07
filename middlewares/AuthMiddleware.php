<?php
namespace mute\mvc\middlewares;
/**
 * Summary of AuthMiddleware
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
use mute\mvc\Application;
use mute\mvc\exception\ForbiddenException;
class AuthMiddleware extends BaseMiddleware 
{
    public array $actions;
    public function __construct($actions = []) {
        $this->actions = $actions;
    }
    public function execute(){
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action,$this->actions)) {
                throw new ForbiddenException();               
            }
        }
    }   
}












?>