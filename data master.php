<?php
include 'cek_login.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Data Master</title>
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
                    <a href="datamaster.php"><img src="images/nav.png">Data Master</a>
                </div>
                <div class="menu_icon">
                    <a href="Jurusan.php"><img src="images/blackboard.png"><br>Jurusan </a>
                    <a href="Prodi.php"><img src="images/study-time.png"> Program Studi  </a>
                    <a href="Kurikulum.php"><img src="images/Kurikulum.png"> Kurikulum </a>
                    <a href="Mata Kuliah.php"><img src="images/pasca_kuliah.png"> Mata Kuliah  </a>
                    <a href="Dosen.php"><img src="images/dosen.png"> Dosen  </a>
                </div>
            </div>
        </div>
    </body>
</html>