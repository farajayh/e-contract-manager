<?php
    class Database{

        //database parameters
        private $db_host = "localhost";
        private $db_name = "e-projects";
        private $username = "root";
        private $password = "";
        public $db_conn;

        //get database connection
        public function get_conn(){

            $this->db_conn = null;

            try{
                $this->db_conn = new PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name, $this->username, $this->password);
            }catch(PDOException $exception){
                echo "Connection Error: ".$exception->getMessage();
            }

            return $this->db_conn;

        }
    }
?>