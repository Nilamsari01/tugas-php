<?php
$host = 'localhost';
$db   = 'pbp2026';
$user = 'root';
$pass = '';

$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Koneksi DB gagal: " . $e->getMessage());
}

$fakultas = ['Fakultas_TEKNIK', 'fakultas_mipa','fkm'];

function update_username() {
    global $pdo, $fakultas;

    $stmt = $pdo->prepare("
        UPDATE user 
        SET username = :username_baru,
            email = :email,
            updated_at = :updated_at
        WHERE username = :username_lama
    ");

    foreach ($fakultas as $row) {

        $namaFakultas = strtolower(trim($row));

        $username_lama = "user_$namaFakultas";
        $username_baru = "admin_$namaFakultas"; // 🔥 DIUBAH DI SINI

        $stmt->execute([
            ':username_lama' => $username_lama,
            ':username_baru' => $username_baru,
            ':email'         => $username_baru . '@uho.ac.id',
            ':updated_at'    => time()
        ]);

        if ($stmt->rowCount() > 0) {
            echo "BERHASIL: $username_lama → $username_baru\n";
        } else {
            echo "GAGAL / TIDAK ADA: $username_lama\n";
        }
    }
}

update_username();
?>