<?php
class Abonimet {
    private $conn;
    private $table_name = "abonimet";

    public $id;
    public $user_id;
    public $pako;
    public $cmimi;
    public $data_fillimit;
    public $data_mbarimit;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET user_id = :user_id,
                      pako = :pako,
                      cmimi = :cmimi,
                      data_fillimit = CURDATE(),
                      data_mbarimit = DATE_ADD(CURDATE(), INTERVAL 3 MONTH),
                      status = :status";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":pako", $this->pako);
        $stmt->bindParam(":cmimi", $this->cmimi);
        $stmt->bindParam(":status", $this->status);

        return $stmt->execute();
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readByUser() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->user_id = $row['user_id'];
            $this->pako = $row['pako'];
            $this->cmimi = $row['cmimi'];
            $this->data_fillimit = $row['data_fillimit'];
            $this->data_mbarimit = $row['data_mbarimit'];
            $this->status = $row['status'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET pako = :pako,
                      cmimi = :cmimi,
                      status = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":pako", $this->pako);
        $stmt->bindParam(":cmimi", $this->cmimi);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function hasActiveSubscription() {
    $query = "SELECT id FROM " . $this->table_name . "
              WHERE user_id = ? AND status = 'aktiv'
              LIMIT 1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->user_id);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}

}
?>