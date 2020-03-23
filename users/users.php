<?php 
    class User{
        //database connection and table
        private $conn;
        private $table_name="users";

        //user properties
        public $user_id;
        public $first_name;
        public $middle_name;
        public $surname;
        public $department;
        public $phone_num;
        public $email;
        public $password;
        public $status;
        public $verification_code;

        public function __construct($db){
            $this->conn = $db;
        }

        public function get_user(){
            $query = "SELECT * FROM ".$this->table_name." WHERE user_id = ? LIMIT 0,1";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->user_id);

            if($stmt->execute()){
                return $stmt;
            }
        }


    }
?>