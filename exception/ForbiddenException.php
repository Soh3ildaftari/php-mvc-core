<?php
namespace mute\mvc\exception;
 /**
 * Summary of ForbiddenException
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
use mute\mvc\Application;
class ForbiddenException extends \Exception
{
    public function __construct() {
        $this->code = 403;
        $this->message = 'You don\'t have permission to access this page';
        Application::$app->response->setStatusCode($this->code);
    }
}







?>