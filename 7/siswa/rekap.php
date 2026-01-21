<?php
require "../auth/middleware.php";
require "../config/database.php";
require "../controllers/NilaiController.php";

// SISWA ONLY
if ($currentUser['role'] !== 'siswa') {
    jsonResponse(["message" => "Access denied"], 403);
}

$db = (new Database())->connect();
$controller = new NilaiController($db);

$method = $_SERVER['REQUEST_METHOD'];

// ambil ID siswa dari JSON body
$data = json_decode(file_get_contents("php://input"), true);
$siswaId = $data['id'] ?? null;

switch ($method) {
    case "GET":
        if (!$siswaId) {
            jsonResponse(["message" => "ID siswa diperlukan"], 422);
        }

        // siswa hanya boleh lihat nilainya sendiri
        $controller->show($siswaId);
        break;

    default:
        jsonResponse(["message" => "Method not allowed"], 405);
}
