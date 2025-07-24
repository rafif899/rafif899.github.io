<a?php
include 'cek_login.php'; // Cek apakah sudah login
?>



<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>


<body>
    
        <div class="container">
            <div class="header">
                <div class="header_text">
                    <a href="#">Beranda</a>
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
                </div>
                <div class="menu_icon">
                    <a href="data master.php"><img src="images/database.png"><br>Data Master </a>
                    <a href="Prakuliah.php"><img src="images/pra_kuliah.png"> PraKuliah <br> </a>
                    <a href="pascakuliah.php"><img src="images/pasca_kuliah.png">Pascakuliah<br> </a>
                    <a href="user.php"><img src="images/user.png"> Data user<br> </a>
                </div>
            </div>
        </div>
    
</body>
</html>