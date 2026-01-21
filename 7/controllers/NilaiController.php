<?php
require_once "../models/Nilai.php";
require_once "../helpers/response.php";

class NilaiController {
    private $model;

    public function __construct($db) {
        $this->model = new Nilai($db);
    }

    public function index() {
        jsonResponse($this->model->getAll());
    }

    public function show($id) {
        $data = $this->model->getById($id);
        $data ? jsonResponse($data) : jsonResponse(["message" => "Nilai not found"], 404);
    }

    public function store($data) {
        if (!$data['siswa_id'] || !$data['mapel_id']) {
            jsonResponse(["message" => "Data tidak lengkap"], 422);
        }
        $this->model->create($data['siswa_id'], $data['mapel_id'], $data['tugas'], $data['uts'], $data['uas']);
        jsonResponse(["message" => "Nilai berhasil ditambahkan"], 201);
    }

    public function update($id, $data) {
        $this->model->update($id, $data['tugas'], $data['uts'], $data['uas']);
        jsonResponse(["message" => "Nilai berhasil diupdate"]);
    }

    public function destroy($id) {
        $this->model->delete($id);
        jsonResponse(["message" => "Nilai berhasil dihapus"]);
    }
}
