<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $perdoruesi;
    public $email;
    public $fjalekalimi;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // per te krijuar user të ri
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET perdoruesi=:perdoruesi, email=:email, fjalekalimi=:fjalekalimi, role=:role";
        
        $stmt = $this->conn->prepare($query);
        
        $this->fjalekalimi = password_hash($this->fjalekalimi, PASSWORD_DEFAULT);
        
        $stmt->bindParam(":perdoruesi", $this->perdoruesi);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":fjalekalimi", $this->fjalekalimi);
        $stmt->bindParam(":role", $this->role);
        
        return $stmt->execute();
    }

    public function login() {
        $query = "SELECT id, perdoruesi, fjalekalimi, role FROM " . $this->table_name . " 
                  WHERE email = ? OR perdoruesi = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, $this->email);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($this->fjalekalimi, $row['fjalekalimi'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['perdoruesi'];
            $_SESSION['role'] = $row['role'];
            $this->id = $row['id'];
            return true;
        }
        return false;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
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
            $this->perdoruesi = $row['perdoruesi'];
            $this->email = $row['email'];
            $this->role = $row['role'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET perdoruesi = :perdoruesi, email = :email, role = :role
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':perdoruesi', $this->perdoruesi);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}
?>
