<?php
namespace mute\mvc\form;
/**
 * Summary of BaseField
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
use mute\mvc\Model;
abstract class BaseField
{
    public Model $model;
    public string $attribute; 
    public function __construct(Model $model, $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    public function __toString()
    {
        return sprintf('<div class="mb-3">
            <label class="form-label">%s</label>
                        %s
        <div class="invalid-feedback">%s</div>
      </div>'
       ,$this->model->label()[$this->attribute] ?? $this->attribute
       ,$this->renderInput()
       ,$this->model->getFirstError($this->attribute)
);
    }
    abstract public function renderInput(): string ;
}














?>
