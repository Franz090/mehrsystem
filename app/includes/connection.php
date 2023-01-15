<?php 

Class Connection{
    private $DB_SERVER = "mysql:host=localhost;dbname=emr";
    private $DB_USERNAME = "root";
    private $DB_PASSWORD = "";
    private $DB_OPTIONS  = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    protected $conn;

    public function open(){
        try{
            $this->db = new PDO($this->DB_SERVER, $this->DB_USERNAME, $this->DB_PASSWORD, $this->DB_OPTIONS);
            return $this->db;
        }
        catch (PDOException $e){
            echo "There is some problem in connection: " . $e->getMessage();
        }
    }

    public function close(){
        $this->db = null;
    }
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>