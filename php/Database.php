<?php

include_once 'define.php';

class Database {
 
    
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
 		
    private $dbh;
    public $error;
 
    private $stmt;
   
    public function __construct() {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => false,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        
        // Create a new PDO instanace
        try {   
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            $this->dbh->exec("SET NAMES 'utf8'");
        }
        // Catch any errors
        catch(PDOException $e) {
            $this->error = $e->getMessage();
        }   
    }

    public function close() {
        $this->dbh = null;
        return true;
    }
    
    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
    }
    
    public function bind($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    
    public function bindParam($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindParam($param, $value, $type);
    }
    
    public function execute($nameValuePairArray = NULL) {
        try {   
            if (is_array($nameValuePairArray) && !empty($nameValuePairArray)) 
                return $this->stmt->execute($nameValuePairArray);
            else
                return $this->stmt->execute();
        } 
        catch(PDOException $e) {
            $this->error = $e->getMessage();
        }   
        return FALSE;
    }

    public function resultset($nameValuePairArray = NULL, $FETCH_ASSOC = FALSE) {
        try {   
            $this->execute($nameValuePairArray);
            if (isset($FETCH_ASSOC) && $FETCH_ASSOC == PDO::FETCH_ASSOC)
                return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            else
                return $this->stmt->fetchAll();
        } 
        catch(PDOException $e) {
            $this->error = $e->getMessage();
        }   
        return FALSE;
    }    

    public function single($nameValuePairArray = NULL, $FETCH_ASSOC = FALSE) {
        try {
            $this->execute($nameValuePairArray);
            if (isset($FETCH_ASSOC) && $FETCH_ASSOC == PDO::FETCH_ASSOC)
                return $this->stmt->fetch(PDO::FETCH_ASSOC);
            else
                return $this->stmt->fetch();
        }
        catch(PDOException $e) {
            $this->error = $e->getMessage();
        }   
        return FALSE;
    }    

    public function rowCount() {
        return $this->stmt->rowCount();
    }    

    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }    
    
    public function beginTransaction(){
        return $this->dbh->beginTransaction();
    }    
    
    public function endTransaction(){
        return $this->dbh->commit();
    }    
    
    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }    

}

?>
