<?php
class Medikamentet {
    private $conn;
    private $table_name = "medikamentet";

    public $id;
    public $emri;
    public $doza;
    public $cmimi;
    public $pershkrimi;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY emri";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id = $row['id'];
            $this->emri = $row['emri'];
            $this->doza = $row['doza'];
            $this->cmimi = $row['cmimi'];
            $this->pershkrimi = $row['pershkrimi'];
            return true;
        }
        return false;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET emri=:emri, doza=:doza, cmimi=:cmimi, pershkrimi=:pershkrimi";
        
        $stmt = $this->conn->prepare($query);
        $this->emri = htmlspecialchars(strip_tags($this->emri));
        $this->doza = htmlspecialchars(strip_tags($this->doza));
        $this->cmimi = htmlspecialchars(strip_tags($this->cmimi));
        $this->pershkrimi = htmlspecialchars(strip_tags($this->pershkrimi));
        
        $stmt->bindParam(":emri", $this->emri);
        $stmt->bindParam(":doza", $this->doza);
        $stmt->bindParam(":cmimi", $this->cmimi);
        $stmt->bindParam(":pershkrimi", $this->pershkrimi);
        
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET emri=:emri, doza=:doza, cmimi=:cmimi, pershkrimi=:pershkrimi 
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        $this->emri = htmlspecialchars(strip_tags($this->emri));
        $this->doza = htmlspecialchars(strip_tags($this->doza));
        $this->cmimi = htmlspecialchars(strip_tags($this->cmimi));
        $this->pershkrimi = htmlspecialchars(strip_tags($this->pershkrimi));
        
        $stmt->bindParam(":emri", $this->emri);
        $stmt->bindParam(":doza", $this->doza);
        $stmt->bindParam(":cmimi", $this->cmimi);
        $stmt->bindParam(":pershkrimi", $this->pershkrimi);
        $stmt->bindParam(":id", $this->id);
        
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }
}
?>