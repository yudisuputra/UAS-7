<?php
require "../config/database.php";

// ===========================
// KONFIGURASI
// ===========================
$usernameGuru = "guru1";     // username guru
$newPassword  = "guru123";   // password baru guru

// ===========================
// PROSES
// ===========================
$db = (new Database())->connect();

// generate hash bcrypt
$newHash = password_hash($newPassword, PASSWORD_BCRYPT);

// update password guru
$stmt = $db->prepare("
    UPDATE users
    SET password_hash = ?
    WHERE username = ?
");

$result = $stmt->execute([$newHash, $usernameGuru]);

if ($result && $stmt->rowCount() > 0) {
    echo "Password guru berhasil direset\n";
    echo "Username : {$usernameGuru}\n";
    echo "Password : {$newPassword}\n";
} else {
    echo "Gagal reset password (guru tidak ditemukan)\n";
}
