<?php 
namespace app\core\form;
/**
 * Summary of textArea
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
class textArea extends BaseField
{
    public function renderInput():string
    {
        return sprintf(
            '<textarea name="%s" class="form-control%s">%s</textarea>'
            , $this->attribute
            , $this->model->hasError($this->attribute) ? ' is-invalid' : ''
            , $this->model->{$this->attribute}
        );  
    }
}





?>