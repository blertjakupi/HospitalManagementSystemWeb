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
}
?>