<?php
class Mapel {
    private $conn;
    private $table = "mata_pelajaran";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($namaMapel, $kodeMapel, $guruId) {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (nama_mapel, kode_mapel, guru_id) VALUES (?, ?, ?)");
        return $stmt->execute([$namaMapel, $kodeMapel, $guruId]);
    }

    public function getAll() {
        $sql = "SELECT m.id, m.nama_mapel, m.kode_mapel, u.username AS guru 
                FROM {$this->table} m 
                JOIN users u ON m.guru_id = u.id";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $namaMapel, $kodeMapel, $guruId) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET nama_mapel=?, kode_mapel=?, guru_id=? WHERE id=?");
        return $stmt->execute([$namaMapel, $kodeMapel, $guruId, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}
