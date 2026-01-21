<?php
require_once "../models/Siswa.php";
require_once "../helpers/response.php";

class SiswaController {
    private $model;

    public function __construct($db) {
        $this->model = new Siswa($db);
    }

    public function index() {
        jsonResponse($this->model->getAll());
    }

    public function show($id) {
        $data = $this->model->getById($id);
        $data ? jsonResponse($data) : jsonResponse(["message" => "Siswa not found"], 404);
    }

    public function store($data) {
        if (!$data['nama'] || !$data['kelas'] || !$data['nis']) {
            jsonResponse(["message" => "Data tidak lengkap"], 422);
        }
        $this->model->create($data['nama'], $data['kelas'], $data['nis'], $data['user_id'] ?? null);
        jsonResponse(["message" => "Siswa berhasil ditambahkan"], 201);
    }

    public function update($id, $data) {
        $this->model->update($id, $data['nama'], $data['kelas'], $data['nis']);
        jsonResponse(["message" => "Siswa berhasil diupdate"]);
    }

    public function destroy($id) {
        $this->model->delete($id);
        jsonResponse(["message" => "Siswa berhasil dihapus"]);
    }
}
