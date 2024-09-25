<?php
namespace Connection;
require '../vendor/autoload.php';
use PDO;
use PDOException;
class Connection {
   private $host;
   private $dbname;
   private $username;
   private $password;
   private $charset;
   private $port;
   private static $instance;
   protected $pdo;

    public function __construct() {
        $this->setConnect();
        $this->connect();
    }
    

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function setConnect(){
        require_once 'conf.php';

        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
        $this->port = $port;
    }

    private function connect() {
        $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            require_once 'conf.php';
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    public function getPdo() {
        return $this->pdo;
    }
    public function close() {
        $this->pdo = null;
    }
}

