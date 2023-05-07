<?php
namespace mute\mvc\db;
/**
 * Summary of Dbmodel
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
use mute\mvc\Application;
use mute\mvc\Model;
abstract class Dbmodel extends Model
{
    //Declare The table u want work on it  
    abstract public static function tableName(): string;
    //    Example: 
    // {
    //     return 'users';
    // }
    //.....................
    //Declare columns of table
    abstract public function attributes (): array ;
    //      Example:
    // {
    //     return ['email', 'password','status'];
    // }
    //....................
    //Declare Primary Key For save in session
    abstract public static function primaryKey(): string ;
    //An Internal Function to access the pdo prepare
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
    //Save Record into DataBase 
    public function save()
    {
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn($attr) => ":$attr", $attributes);
            $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUE (" . implode(',', $params) . ")");
            foreach ($attributes as $attr) {
                $statement->bindValue(":$attr", $this->{$attr});
            }
            $statement->execute();
            return true;
        
    }
    //Search and Find single record in DataBase
    abstract public static function findOne(array $where);
    //      Example:
    // {
    //     $tableName = self::tableName();
    //     $attributes = array_keys($where);
    //     $sql = implode("AND ",array_map(fn($attr) => "$attr = :$attr ", $attributes));
    //     $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
    //     foreach ($where as $key => $item) {
    //         $statement->bindValue(":$key",$item);
    //     }
    //     $statement->execute();
    //     return $statement->fetchObject(self::class);
    // }
}







?>