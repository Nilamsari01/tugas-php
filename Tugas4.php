<?php

include 'db_config.php';

echo "=== OPERASI UPDATE DATA VIA CLI ===\n";

// 1. Ambil ID sebagai acuan data mana yang mau diupdate
echo "Masukkan ID User yang ingin diupdate: ";
$id = trim(fgets(STDIN));

// 2. Cek apakah ID tersebut ada di database
$sql_cek = "SELECT * FROM user WHERE id = '$id'";
$result = $conn->query($sql_cek);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo "\nData Ditemukan!\n";
    echo "Nama saat ini: " . $data['username'] . "\n";
    echo "Email saat ini: " . $data['email'] . "\n";
    echo "-----------------------------------\n";

    // 3. Input data baru
    echo "Masukkan Nama Baru (kosongkan jika tidak ingin diubah): ";
    $nama_baru = trim(fgets(STDIN));
    $nama_final = ($nama_baru == "") ? $data['username'] : $nama_baru;

    echo "Masukkan Email Baru (kosongkan jika tidak ingin diubah): ";
    $email_baru = trim(fgets(STDIN));
    $email_final = ($email_baru == "") ? $data['email'] : $email_baru;

    // 4. Eksekusi perintah UPDATE ke database
    $sql_update = "UPDATE user SET username = '$nama_final', email = '$email_final' WHERE id = '$id'";

    if ($conn->query($sql_update) === TRUE) {
        echo "\nSukses: Data berhasil diperbarui!\n";
    } else {
        echo "\nError: " . $conn->error . "\n";
    }
} else {
    echo "\nError: Data dengan ID tersebut tidak ditemukan.\n";
}

$conn->close();
?>