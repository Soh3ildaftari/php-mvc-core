<?php
namespace mute\mvc;
/**
 * Summary of View
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
class View
{
    public function renderView($view,$params =[],$layout = 'main'){
      
        $layoutContact = $this->layoutContent($layout);
        $viewContent = $this->renderOnlyView($view,$params);
        return str_replace('{{content}}', $viewContent, $layoutContact);
    }


    protected function layoutContent($layout){
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";   
        return ob_get_clean();
    }
    public function renderOnlyView($view,$params = []){
        foreach ($params as $key => $value) {
            $$key = $value;
        }   
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}








?>