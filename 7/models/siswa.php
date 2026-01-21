<?php
class Siswa {
    private $conn;
    private $table = "siswa";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($nama, $kelas, $nis, $userId) {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (nama, kelas, nis, user_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nama, $kelas, $nis, $userId]);
    }

    public function getAll() {
        $sql = "SELECT s.id, s.nama, s.kelas, s.nis, u.username 
                FROM {$this->table} s 
                LEFT JOIN users u ON s.user_id = u.id";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nama, $kelas, $nis) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET nama=?, kelas=?, nis=? WHERE id=?");
        return $stmt->execute([$nama, $kelas, $nis, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
