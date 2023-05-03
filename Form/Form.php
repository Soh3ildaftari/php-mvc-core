<?php 
namespace app\core\form;
/**
 * Summary of Form
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) $CURRENT_YEAR
 */
use app\core\Model;
class Form
{
    public static function begin($action , $method)
    {
        echo sprintf("<form action='%s' method='%s'>", $action, $method);
        return new Form();
    }
    public static function end()
    {
        echo "</form>";
    }
    public function inputField(Model $model,$attribute)
    {
        return new InputField($model, $attribute);
    }
    public function textArea(Model $model,$attribute)
    {
        return new textArea($model, $attribute);
    }
}
?>