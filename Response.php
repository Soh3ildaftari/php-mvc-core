<?php
namespace mute\mvc;
/**
 * Summary of Response
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
class Response{
public function setStatusCode(int $code)
{
    http_response_code($code);
}
public function redirect(string $uri)
{
        header('Location: ' . $uri); 
}

}