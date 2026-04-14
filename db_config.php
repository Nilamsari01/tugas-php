<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Coba kosongkan dulu, kalau gagal ganti jadi 'root'
$db   = 'db_latihan'; // Sesuaikan dengan nama database di phpMyAdmin kamu

// Koneksi MySQLi
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika PDO MySQL tersedia, siapkan objek PDO.
// Jika tidak, fallback ke mysqli agar skrip CLI tetap berjalan.
if (extension_loaded('pdo_mysql')) {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        die("Koneksi DB gagal: " . $e->getMessage());
    }
} else {
    $pdo = $conn;
}
?>
