<?php
$conn = new mysqli("localhost", "root", "", "db_latihan");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>