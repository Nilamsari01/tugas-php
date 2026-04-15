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

$fakultas = ['Fakultas_Teknik', 'Fakultas_MIPA'];

$seeding_output = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'seed') {
        $seeding_output = seed_accounts();
    } elseif ($_POST['action'] === 'update') {
        $seeding_output = update_username();
    }
}

// ambil data terbaru
$users = $pdo->query("SELECT * FROM user")->fetchAll();

function seed_accounts() {
    global $pdo, $fakultas;

    $output = "";

    $stmt = $pdo->prepare("
        INSERT INTO user (username,email,password_hash,auth_key,status,created_at,updated_at)
        VALUES (:username,:email,:password_hash,:auth_key,:status,:created_at,:updated_at)
    ");

    foreach ($fakultas as $row) {
        $kode = strtolower(trim($row));
        $username = "user_$kode";

        $plain = $kode . bin2hex(random_bytes(3));
        $hash  = password_hash($plain, PASSWORD_BCRYPT);

        $stmt->execute([
            ':username' => $username,
            ':email' => $username . '@uho.ac.id',
            ':password_hash' => $hash,
            ':auth_key' => bin2hex(random_bytes(16)),
            ':status' => 10,
            ':created_at' => time(),
            ':updated_at' => time()
        ]);

        $output .= "✔ $username | pass: $plain <br>";
    }

    return $output;
}

function update_username() {
    global $pdo, $fakultas;

    $output = "";

    $stmt = $pdo->prepare("
        UPDATE user 
        SET username = :baru,
            email = :email,
            updated_at = :updated_at
        WHERE username = :lama
    ");

    foreach ($fakultas as $row) {
        $kode = strtolower(trim($row));

        $lama = "user_$kode";
        $baru = "admin_$kode";

        $stmt->execute([
            ':lama' => $lama,
            ':baru' => $baru,
            ':email' => $baru . '@uho.ac.id',
            ':updated_at' => time()
        ]);

        if ($stmt->rowCount() > 0) {
            $output .= "🔁 $lama → $baru <br>";
        } else {
            $output .= "⚠ $lama tidak ditemukan <br>";
        }
    }

    return $output;
}
?>

<html>
<head>
    <title>Manajemen User</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f6fa;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        h1 {
            text-align: center;
        }
        button {
            padding: 10px 15px;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .seed { background: #4CAF50; }
        .update { background: #2196F3; }
        .refresh { background: #f44336; }

        .box {
            background: white;
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #4CAF50;
            color: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .result {
            background: #e8f5e9;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Manajemen User</h1>

    <form method="POST">
        <button class="seed" name="action" value="seed">Seed User</button>
        <button class="update" name="action" value="update">Update Username</button>
        <a href=""><button type="button" class="refresh">Refresh</button></a>
    </form>

    <?php if ($seeding_output): ?>
        <div class="result">
            <?php echo $seeding_output; ?>
        </div>
    <?php endif; ?>

    <div class="box">
        <h3>Data User</h3>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
            </tr>

            <?php foreach ($users as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>
</div>
</body>
</html>
?>