<?php
include 'db_config.php';
?>

<h2>=== OPERASI UPDATE DATA USER ===</h2>

<form method="POST">
    ID User: <br>
    <input type="text" name="id" required><br><br>

    Nama Baru: <br>
    <input type="text" name="username"><br><br>

    Email Baru: <br>
    <input type="email" name="email"><br><br>

    <button type="submit" name="update">Update</button>
</form>

<hr>

<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_baru = $_POST['username'];
    $email_baru = $_POST['email'];

    // cek data berdasarkan ID
    $sql_cek = "SELECT * FROM user WHERE id = '$id'";
    $result = $conn->query($sql_cek);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // kalau kosong, pakai data lama
        $nama_final = ($nama_baru == "") ? $data['username'] : $nama_baru;
        $email_final = ($email_baru == "") ? $data['email'] : $email_baru;

        $sql_update = "UPDATE user SET username='$nama_final', email='$email_final' WHERE id='$id'";

        if ($conn->query($sql_update) === TRUE) {
            echo "<p style='color:green;'>Sukses: Data berhasil diperbarui!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }

    } else {
        echo "<p style='color:red;'>Error: ID tidak ditemukan!</p>";
    }
}

$conn->close();
?>