<?php

class Terminet {
    private $conn;
    private $table_name = "terminet"; 

    public $fullname;
    public $email;
    public $phone;
    public $doctor;
    public $appointment_date;
    public $appointment_time;
    public $symptoms;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET fullname=:fullname, email=:email, phone=:phone, 
                      doctor=:doctor, appointment_date=:appointment_date, 
                      appointment_time=:appointment_time, symptoms=:symptoms";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":doctor", $this->doctor);
        $stmt->bindParam(":appointment_date", $this->appointment_date);
        $stmt->bindParam(":appointment_time", $this->appointment_time);
        $stmt->bindParam(":symptoms", $this->symptoms);
        
        return $stmt->execute();
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY appointment_date DESC, appointment_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->fullname = $row['fullname'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->doctor = $row['doctor'];
            $this->appointment_date = $row['appointment_date'];
            $this->appointment_time = $row['appointment_time'];
            $this->symptoms = $row['symptoms'];
            return true;
        }
        return false;
    }

    public function readFilteredByDate($date) {
        $query = "SELECT * FROM " . $this->table_name . " 
              WHERE DATE(appointment_date) = :date 
              ORDER BY appointment_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET fullname=:fullname, email=:email, phone=:phone,
                      doctor=:doctor, appointment_date=:appointment_date,
                      appointment_time=:appointment_time
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":doctor", $this->doctor);
        $stmt->bindParam(":appointment_date", $this->appointment_date);
        $stmt->bindParam(":appointment_time", $this->appointment_time);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
}
?>