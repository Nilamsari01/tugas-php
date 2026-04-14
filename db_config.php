<?php
// Pengaturan Database sesuai file cli kamu
$host = 'localhost';
$db   = 'pbp2026'; // Nama database yang ada di file cli_create_user.php
$user = 'root';
$pass = ''; // Sesuaikan jika password MySQL kamu kosong "" atau "root"

$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    // Membuat koneksi menggunakan PDO agar seragam dengan file lainnya
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // Jika gagal, tampilkan pesan error
    die("Koneksi DB gagal: " . $e->getMessage());
}

// Untuk mendukung skrip yang masih menggunakan variabel $conn
$conn = new mysqli($host, $user, $pass, $db);
?>