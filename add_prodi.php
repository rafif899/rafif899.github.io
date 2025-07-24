<?php
// Memanggil file koneksi
include 'koneksi.php';
include 'cek_login.php';

// Proses penambahan data prodi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prodiKode = $_POST["prodiKode"];
    $prodiJurId = $_POST["prodiJurId"];
    $prodiNama = $_POST["prodiNama"];
    $prodiId = $_POST["prodiId"];
    $prodiNamaAsing = $_POST["prodiNamaAsing"];
    $prodiIsAktif = isset($_POST["prodiIsAktif"]) ? 1 : 0; // 1 jika checkbox di centang, 0 jika tidak

    // Query untuk menambahkan data ke tabel prodi
    $sql = "INSERT INTO prodi (prodiKode,prodiJurId, prodiNama, prodiNamaAsing, prodiIsAktif, prodiId)
            VALUES ('$prodiKode','$prodiJurId', '$prodiNama', '$prodiNamaAsing', $prodiIsAktif, $prodiId)";

    if ($conn->query($sql) === TRUE) {
        echo "Data prodi berhasil ditambahkan!";
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
    <title>Tambah Program Studi</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>

    <div class="container">
        <div class="header">
            <div class="header_text">
                <a href="dashboard.php">Beranda</a>
                <a href="logout.php">Logout</a>
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
                <a href="prodi.php"><img src="images/nav.png">Program Studi</a>
                <a href="#"><img src="images/nav.png">Tambah data Program Studi</a>
            </div>

            <div class="input_data">


                <form method="POST" action="add_prodi.php">
                    <label>Program Studi Id: </label><input class="kotak" type="text" name="prodiId" required><br><br>
                    <label>Kode Program Studi: </label><input class="kotak" type="text" name="prodiKode"
                        required><br><br>
                    <label>kode jurusan:</label><input class="kotak" type="text" name="prodiJurId" required><br><br>
                    <label>Nama Program Studi: </label><input class="kotak" type="text" name="prodiNama"
                        required><br><br>
                    <label>Nama Asing Program Studi: </label><input class="kotak" type="text"
                        name="prodiNamaAsing"><br><br>
                    <label>Aktif: </label><input type="checkbox" name="prodiIsAktif" checked><br><br>
                    <label><input type="submit" value="Tambah Program studi"><br><br></label>
                </form>
            </div>
        </div>
    </div>
</body>

</html>