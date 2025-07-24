<?php

// Memanggil file koneksi
include 'koneksi.php';
include 'cek_login.php';

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];

    // Validasi data input
    if (empty($userId) || empty($oldPassword) || empty($newPassword)) {
        $message = "Semua kolom harus diisi.";
    } else {
        // Cek apakah userId dan password lama cocok
        $sql = "SELECT * FROM user WHERE userId = ? AND userPassword = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userId, $oldPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update password
            $updateSql = "UPDATE user SET userPassword = ? WHERE userId = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ss", $newPassword, $userId);

            if ($updateStmt->execute()) {
                $message = "Password berhasil diubah.";
            } else {
                $message = "Gagal mengubah password.";
            }
        } else {
            $message = "User ID atau password lama salah.";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ganti Password</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function confirmEdit() {
            return confirm("Apakah Anda yakin ingin mengganti password ini?");
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header_text">
                <a href="dashboard.php">Beranda</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="left">
            <h2>Menu Utama:</h2>
            <ul>
                <li><a href="data master.php">Data Master<br></a></li>
                <li><a href="Prakuliah.php"> Prakuliah <br> </a></li>
                <li><a href="pascakuliah.php">Pascakuliah<br> </a></li>
                <li><a href="user.php"> Data user<br> </a></li>
            </ul>
        </div>

        <div class="right">
            <div class="judul_page">
                <a href="dashboard.php"><img src="images/nav.png">Beranda</a>
                <a href="user.php"><img src="images/nav.png">Data User</a>
                <a href="#"><img src="images/nav.png">Ganti Password</a>
            </div>

            <div class="input_data">
                <form method="POST" action="" onsubmit="return confirmEdit()">
                    <label for="userId">User ID:</label><input class="kotak" type="text" id="userId" name="userId"><br><br>
                    <label for="oldPassword">Password Lama:</label><input class="kotak" type="password" id="oldPassword" name="oldPassword"><br><br>
                    <label for="newPassword">Password Baru:</label><input class="kotak" type="password" id="newPassword" name="newPassword"><br><br>
                    <button type="submit">Ganti Password</button>
                    <p><?php echo $message; ?></p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
