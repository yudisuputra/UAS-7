<?php
class Nilai {
    private $conn;
    private $table = "nilai";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($siswaId, $mapelId, $tugas, $uts, $uas) {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (siswa_id, mapel_id, tugas, uts, uas) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$siswaId, $mapelId, $tugas, $uts, $uas]);
    }

    public function getAll() {
        $sql = "SELECT n.id, s.nama, m.nama_mapel, n.tugas, n.uts, n.uas
                FROM {$this->table} n
                JOIN siswa s ON n.siswa_id = s.id
                JOIN mata_pelajaran m ON n.mapel_id = m.id";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $tugas, $uts, $uas) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET tugas=?, uts=?, uas=? WHERE id=?");
        return $stmt->execute([$tugas, $uts, $uas, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
