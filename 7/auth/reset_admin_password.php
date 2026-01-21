<?php
require "../config/database.php";

// ===========================
// KONFIGURASI
// ===========================
$usernameAdmin = "admin1";    // username admin
$newPassword   = "admin123";  // password baru admin

// ===========================
// PROSES
// ===========================
$db = (new Database())->connect();

// generate hash bcrypt
$newHash = password_hash($newPassword, PASSWORD_BCRYPT);

// update password admin
$stmt = $db->prepare("
    UPDATE users
    SET password_hash = ?
    WHERE username = ?
");

$result = $stmt->execute([$newHash, $usernameAdmin]);

if ($result && $stmt->rowCount() > 0) {
    echo "Password admin berhasil direset\n";
    echo "Username : {$usernameAdmin}\n";
    echo "Password : {$newPassword}\n";
} else {
    echo "Gagal reset password (admin tidak ditemukan)\n";
}
