<?php
include 'koneksi.php';
include 'cek_login.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prakuliah</title>
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
                    <a href="#"><img src="images/nav.png">Prakuliah</a>
                </div>

            <div class="menu_icon">
                <a href="daftar_kelas.php"><img src="images/kelas.png">Daftar kelas<br></a>
                <a href="daftar_mk_kelas.php"><img src="images/online-course.png">Daftar matakuliah kelas<br></a>
                <a href="daftar_dsn_kelas.php"><img src="images/dosen.png">Daftar Dosen kelas<br></a>
                <a href="daftar_mhs_kelas.php"><img src="images/mahasiswa.png">Daftar Mahasiswa kelas<br></a>
                <a href="krs.php"><img src="images/kartu.png">Kartu Rencana Studi<br></a>
            </div>
        </div>
    </div>
</body>
</html>