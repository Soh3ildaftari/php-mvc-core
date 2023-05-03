<?php 
namespace app\core\exception;
/**
 * Summary of NotfoundException
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */

use app\core\Application;
class NotfoundException extends \Exception
{   
    public function __construct() {
        $this->code = 404 ;
        $this->message = 'Not Found';
        Application::$app->response->setStatusCode($this->code);
    }
}








?>