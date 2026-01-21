<?php
require_once "../models/User.php";
require_once "../helpers/response.php";

class UserController
{
    private $user;

    public function __construct($db)
    {
        $this->user = new User($db);
    }

    // GET semua user
    public function index()
    {
        jsonResponse($this->user->getAll());
    }

    // GET user by ID
    public function show($id)
    {
        $data = $this->user->getById($id);
        $data
            ? jsonResponse($data)
            : jsonResponse(["message" => "User not found"], 404);
    }

    // POST tambah user baru
    public function store($data)
    {
        if (empty($data['username']) || empty($data['password']) || empty($data['role_id'])) {
            jsonResponse(["message" => "Data tidak lengkap"], 422);
        }

        // Validasi role_id (hanya 1=admin, 2=guru, 3=siswa)
        if (!in_array($data['role_id'], [1, 2, 3])) {
            jsonResponse(["message" => "Role tidak valid"], 422);
        }

        $this->user->create(
            $data['username'],
            $data['password'],   // plain text sesuai DB
            $data['role_id']
        );

        jsonResponse([
            "message" => "User berhasil ditambahkan",
            "username" => $data['username'],
            "role_id" => $data['role_id']
        ], 201);
    }

    // PUT update user (username & role)
    public function update($id, $data)
    {
        if (empty($data['username']) || empty($data['role_id'])) {
            jsonResponse(["message" => "Data tidak lengkap"], 422);
        }

        $this->user->update($id, $data['username'], $data['role_id']);
        jsonResponse(["message" => "User berhasil diupdate"]);
    }

    // PUT update password
    public function updatePassword($id, $data)
    {
        if (empty($data['password'])) {
            jsonResponse(["message" => "Password tidak boleh kosong"], 422);
        }

        $this->user->updatePassword($id, $data['password']); // plain text
        jsonResponse(["message" => "Password berhasil diupdate"]);
    }

    // DELETE user
    public function destroy($id)
    {
        $this->user->delete($id);
        jsonResponse(["message" => "User berhasil dihapus"]);
    }
}
