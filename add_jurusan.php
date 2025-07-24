<?php
// Memanggil file koneksi
include 'koneksi.php';
include 'cek_login.php';

// Proses penambahan data jurusan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jurKode = $_POST["jurKode"];
    $jurNama = $_POST["jurNama"];
    $jurId = $_POST["jurId"];
    $jurNamaAsing = $_POST["jurNamaAsing"];
    $jurIsAktif = isset($_POST["jurIsAktif"]) ? 1 : 0; // 1 jika checkbox di centang, 0 jika tidak

    // Query untuk menambahkan data ke tabel jurusan
    $sql = "INSERT INTO jurusan (jurKode, jurNama, jurNamaAsing, jurIsAktif, jurId)
            VALUES ('$jurKode', '$jurNama', '$jurNamaAsing', $jurIsAktif, $jurId)";

    if ($conn->query($sql) === TRUE) {
        echo "Data jurusan berhasil ditambahkan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <title>Tambah Jurusan</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
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
                <a href="data master.php"><img src="images/nav.png">Data Master</a>
                <a href="jurusan.php"><img src="images/nav.png">Jurusan</a>
                <a href="#"><img src="images/nav.png">Tambah data Jurusan</a>
            </div>

            <div class="input_data">
                <form method="POST" action="add_jurusan.php">
                    <label>Jurusan Id:</label><input class="kotak"  type="text" name="jurId" required><br><br>
                    <label>Kode Jurusan: </label><input  class="kotak" type="text" name="jurKode" required><br><br>
                    <label>Nama Jurusan: </label><input class="kotak" type="text" name="jurNama" required><br><br>
                    <label>Nama Asing Jurusan: </label><input class="kotak"  type="text" name="jurNamaAsing"><br><br>
                    <label>Aktif: </label><input   type="checkbox" name="jurIsAktif" checked><br><br>
                    <label><input type="submit" value="Tambah Jurusan"></label><br><br>
                </form>
            </div>
        </div>
    </div>
</body>

</html>