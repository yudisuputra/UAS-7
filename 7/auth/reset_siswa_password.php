<?php
require "../config/database.php";

// ===========================
// KONFIGURASI
// ===========================
$usernameSiswa = "siswa1";     // username siswa
$newPassword   = "siswa123";   // password baru siswa

// ===========================
// PROSES
// ===========================
$db = (new Database())->connect();

// generate hash bcrypt
$newHash = password_hash($newPassword, PASSWORD_BCRYPT);

// update password siswa
$stmt = $db->prepare("
    UPDATE users
    SET password_hash = ?
    WHERE username = ?
");

$result = $stmt->execute([$newHash, $usernameSiswa]);

if ($result && $stmt->rowCount() > 0) {
    echo "Password siswa berhasil direset\n";
    echo "Username : {$usernameSiswa}\n";
    echo "Password : {$newPassword}\n";
} else {
    echo "Gagal reset password (siswa tidak ditemukan)\n";
}
