<?php
namespace app\core\form;
/**
 * Summary of InputField
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
use app\core\Model;
class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASS = 'password';
    public const TYPE_NUMBER = 'number';
    public string $type;
    public function __construct(Model $model, $attribute)
    {
        parent::__construct($model , $attribute);
        $this->type = self::TYPE_TEXT;
    }
    public function renderInput(): string
    {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control%s">',
        $this->type
        ,$this->attribute
        ,$this->model->{$this->attribute}
        ,$this->model->hasError($this->attribute) ? ' is-invalid':'');
    }
    public function passField()
    {
        $this->type = self::TYPE_PASS;
        return $this;        
    }
    public function numField()
    {
        $this->type = self::TYPE_NUMBER;
        return $this;        
    }
}






?>