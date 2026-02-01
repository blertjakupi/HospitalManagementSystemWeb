<?php
class Doktoret {
    private $conn;
    private $table_name = "doktoret";

    public $id;
    public $emri;
    public $mbiemri;
    public $specializimi;
    public $email;
    public $telefoni;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table_name} 
                  SET emri=:emri, mbiemri=:mbiemri, specializimi=:specializimi, 
                      email=:email, telefoni=:telefoni";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':emri', $this->emri);
        $stmt->bindParam(':mbiemri', $this->mbiemri);
        $stmt->bindParam(':specializimi', $this->specializimi);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefoni', $this->telefoni);
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT id, emri, mbiemri, specializimi, email, telefoni, created_at 
                  FROM {$this->table_name} ORDER BY emri ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM {$this->table_name} WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->emri = $row['emri'];
            $this->mbiemri = $row['mbiemri'];
            $this->specializimi = $row['specializimi'];
            $this->email = $row['email'];
            $this->telefoni = $row['telefoni'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE {$this->table_name} SET emri=:emri, mbiemri=:mbiemri, 
                  specializimi=:specializimi, email=:email, telefoni=:telefoni 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':emri', $this->emri);
        $stmt->bindParam(':mbiemri', $this->mbiemri);
        $stmt->bindParam(':specializimi', $this->specializimi);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefoni', $this->telefoni);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM {$this->table_name} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }

    public function createFromDashboard() {
    $query = "INSERT INTO {$this->table_name} 
              SET emri=:emri, mbiemri=:mbiemri, specializimi=:specializimi, 
                  email=:email, telefoni=:telefoni";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':emri', $this->emri);
    $stmt->bindParam(':mbiemri', $this->mbiemri);
    $stmt->bindParam(':specializimi', $this->specializimi);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':telefoni', $this->telefoni);
    return $stmt->execute();
}
}
?>
