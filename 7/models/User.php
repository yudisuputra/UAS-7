<?php
class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByUsername($username) {
        $stmt = $this->conn->prepare("
            SELECT u.id,
                   u.username,
                   u.password_hash,
                   r.name AS role
            FROM {$this->table} u
            JOIN roles r ON u.role_id = r.id
            WHERE u.username = ?
            LIMIT 1
        ");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $passwordHash, $roleId) {
        $sql = "INSERT INTO {$this->table} (username, password_hash, role_id)
                VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$username, $passwordHash, $roleId]);
    }

    public function updatePassword($id, $passwordHash) {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET password_hash = ?
            WHERE id = ?
        ");
        return $stmt->execute([$passwordHash, $id]);
    }

    public function getAll() {
        $sql = "SELECT u.id, u.username, r.name AS role
                FROM {$this->table} u
                JOIN roles r ON u.role_id = r.id";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT u.id, u.username, r.name AS role
            FROM {$this->table} u
            JOIN roles r ON u.role_id = r.id
            WHERE u.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $username, $roleId) {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET username = ?, role_id = ?
            WHERE id = ?
        ");
        return $stmt->execute([$username, $roleId, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
