<?php
require_once "../models/Mapel.php";
require_once "../helpers/response.php";

class MapelController {
    private $model;

    public function __construct($db) {
        $this->model = new Mapel($db);
    }

    public function index() {
        jsonResponse($this->model->getAll());
    }

    public function show($id) {
        $data = $this->model->getById($id);
        $data ? jsonResponse($data) : jsonResponse(["message" => "Mapel not found"], 404);
    }

    public function store($data) {
        if (!$data['nama_mapel'] || !$data['kode_mapel'] || !$data['guru_id']) {
            jsonResponse(["message" => "Data tidak lengkap"], 422);
        }
        $this->model->create($data['nama_mapel'], $data['kode_mapel'], $data['guru_id']);
        jsonResponse(["message" => "Mapel berhasil ditambahkan"], 201);
    }

    public function update($id, $data) {
        $this->model->update($id, $data['nama_mapel'], $data['kode_mapel'], $data['guru_id']);
        jsonResponse(["message" => "Mapel berhasil diupdate"]);
    }

    public function destroy($id) {
        $this->model->delete($id);
        jsonResponse(["message" => "Mapel berhasil dihapus"]);
    }
}
