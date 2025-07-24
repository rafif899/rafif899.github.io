<?php
// Memanggil file koneksi
include 'koneksi.php';
include 'cek_login.php';

// Proses penambahan data prodi
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $kurProdiId = $_POST["kurProdiId"];
    $kurNama = $_POST["kurNama"];
    $kurTahun = $_POST["kurTahun"];
    $kurIsAktif = isset($_POST["kurIsAktif"]) ? 1 : 0; // 1 jika checkbox di centang, 0 jika tidak

    // Query untuk menambahkan data ke tabel kurikulum
    $sql = "INSERT INTO kurikulum(kurProdiId, kurTahun, kurNama, kurIsAktif)
            VALUES ('$kurProdiId', '$kurTahun', '$kurNama', $kurIsAktif)";

    if ($conn->query($sql) === TRUE) {
        echo "Data kurilulum berhasil ditambahkan!";
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
    <title>Tambah kurikulum</title>
    <link rel="stylesheet" href="styles.css">

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
                <a href="kurikulum.php"><img src="images/nav.png">Kurikulum</a>
                <a href="#"><img src="images/nav.png">Tambah data Kurikulum</a>
            </div>

            <div class="input_data">
                <form method="POST" action="add_kurikulum.php">
                    <label>Nomor: </label><input class="kotak" type="text" name="kurId" required><br><br>
                    <label>Program Studi: </label><input class="kotak" type="text" name="kurProdiId" required><br><br>
                    <label>tahun: </label><input class="kotak" type="text" name="kurTahun" required><br><br>
                    <label>Nama Kurikulum: </label><input class="kotak" type="text" name="kurNama"><br><br>
                    <label>status: </label><input  type="checkbox" name="kurIsAktif" checked><br><br>
                    <label><input  type="submit" value="Tambah kurikulum"><br><br></label>
                </form>
            </div>
        </div>
    </div>
</body>

</html>