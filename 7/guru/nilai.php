<?php
require "../auth/middleware.php";
require "../config/database.php";
require "../controllers/NilaiController.php";

// GURU ONLY
if ($currentUser['role'] !== 'guru') {
    jsonResponse(["message" => "Access denied"], 403);
}

$db = (new Database())->connect();
$controller = new NilaiController($db);

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case "GET":
        // Guru bisa lihat semua nilai
        $id ? $controller->show($id) : $controller->index();
        break;
    case "POST":
        // Guru input nilai baru
        $controller->store($data);
        break;
    case "PUT":
        // Guru update nilai
        $controller->update($id, $data);
        break;
    case "DELETE":
        // Guru hapus nilai
        $controller->destroy($id);
        break;
    default:
        jsonResponse(["message" => "Method not allowed"], 405);
}