<?php
namespace app\core\db;
/**
 * Summary of Database
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
use app\core\Application;
use PDO;
class Database
{
    public PDO $pdo;
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new PDO($dsn , $username , $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );
        
    }
    public function prepare($sql)
    {
      return $this->pdo->prepare($sql);
    }
    public function applyMigration()
    {
        $this->createMigrationsTable();
        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR.'/migrations');
        $appliedMigrations = $this->getAppliedMigrations();
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === "." || $migration === ".." ) {continue;}
            require_once Application::$ROOT_DIR . '/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $mInstance = new $className;
            $this->log("Applying $className");
            $mInstance->up();
            $this->log("$className Applied");
            $newMigrations[] = $migration;
        }
        if (!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }else {
            $this->log("All Migrations Applied");
        }
    
    }
    public function createMigrationsTable()
    {
       $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations ( id INT AUTO_INCREMENT PRIMARY KEY , 
       migration VARCHAR(255),
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
       ) ENGINE=INNODB ;");
    }
    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN); 
    }
    public function saveMigrations($newMigrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $newMigrations));
        $statement = $this->pdo->prepare("INSERT migrations (migration) VALUES $str");
        $statement->execute();
    }
    public function log($massage)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $massage . PHP_EOL;
    }
}




?>