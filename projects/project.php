<?php
    class Project{
        //database connection and table name
        private $conn;
        private $table_name = "projects";

        //project properties
        public $contract_id;
        public $title;
        public $details;
        public $date_created;
        public $start_date;
        public $end_date;
        public $contractor;
        public $contractor_email;
        public $contractor_phone_number;
        public $last_modified;
        public $user_id;
        public $last_modified_by;
        

        public function __construct($db){
            $this->conn = $db;
        }

        public function add(){
            //form query to insert into table
            $query = "INSERT INTO ".$this->table_name." 
            SET 
                contract_id=:contract_id, title=:title, details=:details, 
                date_created=:date_created, start_date=:start_date,
                end_date=:end_date, contractor=:contractor, contractor_email=:contractor_email, 
                contractor_phone_number=:contractor_phone_number,
                last_modified=:last_modified, user_id=:user_id, last_modified_by=:last_modified_by
            ";

            //prepare query
            $stmt = $this->conn->prepare($query);

            //sanitize variables
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->details=htmlspecialchars(strip_tags($this->details));
            $this->contractor=htmlspecialchars(strip_tags($this->contractor));
            $this->contractor_email=htmlspecialchars(strip_tags($this->contractor_email));
            
            //bind parameters
            $stmt->bindParam(":contract_id", $this->contract_id);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":details", $this->details);
            $stmt->bindParam(":date_created", $this->date_created);
            $stmt->bindParam(":start_date", $this->start_date);
            $stmt->bindParam(":end_date", $this->end_date);
            $stmt->bindParam(":contractor", $this->contractor);
            $stmt->bindParam(":contractor_email", $this->contractor_email);
            $stmt->bindParam(":contractor_phone_number", $this->contractor_phone_number);
            $stmt->bindParam(":last_modified", $this->last_modified);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":last_modified_by", $this->last_modified_by);

            //execute query
            if($stmt->execute()){
                $query_id = $this->conn->lastInsertId();
                $this->contract_id = substr($this->contract_id,0,3).$query_id.substr($this->contract_id,3,5);
                $query = "UPDATE ".$this->table_name." 
                SET
                    contract_id=:new_contract_id
                WHERE
                    contract_id=:contract_id
                ";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(":new_contract_id", $this->contract_id);
                $stmt->bindParam(":contract_id", $this->contract_id);

                if($stmt->execute()){
                    return True;
                }
                
            }

            return $stmt->errorInfo();
            
        }

        public function view_all(){
            
            $query = "SELECT * FROM ".$this->table_name;
            
            $stmt = $this->conn->prepare($query);
            
            if($stmt->execute()){
                return $stmt;
            }

        }

        public function view_one(){

            $query = "SELECT * FROM ".$this->table_name." WHERE contract_id = ? LIMIT 0,1";

            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $this->contract_id);

            if($stmt->execute()){
                return $stmt;
            }

        }

        public function extend(){
            $query = "UPDATE ".$this->table_name." 
            SET
                end_date=:end_date,
                last_modified=:last_modified,
                last_modified_by=:last_modified_by
            WHERE
                contract_id=:contract_id
            ";

            $stmt = $this->conn->prepare($query);

            $this->last_modified = date("y-m-d h:i:s");

            $stmt->bindParam(":end_date", $this->end_date);
            $stmt->bindParam(":last_modified", $this->last_modified);
            $stmt->bindParam(":last_modified_by", $this->last_modified_by);
            $stmt->bindParam(":contract_id", $this->contract_id);

            if($stmt->execute()){
                return True;
            }

            return False;

        }

        public function delete(){

            $query = "DELETE FROM ".$this->table_name." WHERE contractor_id=?";
            
            $stmt = $this->conn->prepare($query);

            $stmt->bindParm(1, $this->contractor_id);

            if($stmt->execute()){
                return True;
            }

            return False;
        }
    }
?>