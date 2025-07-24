<?php
// Memanggil file koneksi
include 'koneksi.php';
include 'cek_login.php';
// Ambil prodiId dari URL
// $kurId = $_GET['kurId'];

// Query untuk mengambil data berdasarkan prodiId
$sql = "SELECT * FROM kurikulum ";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kurId = $_POST['kurId'];
    $kurProdiId = $_POST['kurProdiId'];
    $kurTahun = $_POST['kurTahun'];
    $kurNama = $_POST['kurNama'];
    $kurIsAktif = isset($_POST['kurIsAktif']) ? 1 : 0;

    $sql_update = "UPDATE kurikulum SET 
                   
                   kurProdiId = '$kurProdiId', 
                   kurNama = '$kurNama',  
                   kurIsAktif = $kurIsAktif 
                   WHERE kurId = $kurId";

    if ($conn->query($sql_update) === TRUE) {
        echo "Data prodi berhasil diupdate!";
        header("Location:kurikulum.php"); // Redirect setelah update
        exit;
    } else {
        echo "Error saat mengupdate data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit kurikulum</title>
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
                <a href="#"><img src="images/nav.png">Edit data Kurikulum</a>
            </div>

            <div class="input_data">
                <form method="POST" action="">
                    <label>No: </label><input class="kotak" type="text" name="kurId"
                        value="<?php echo $data['kurId']; ?>" required><br><br>
                    <label>No Program Studi: </label><input class="kotak" type="text" name="kurProdiId"
                        value="<?php echo $data['kurProdiId']; ?>" required><br><br>
                    <label>Tahun: </label><input class="kotak" type="text" name="kurTahun"
                        value="<?php echo $data['kurTahun']; ?>"><br><br>
                    <label>Nama Kurikulum: </label><input class="kotak" type="text" name="kurNama"
                        value="<?php echo $data['kurNama']; ?>"><br><br>
                    <label>Aktif: </label><input type="checkbox" name="kurIsAktif" <?php echo $data['kurIsAktif'] ? 'checked' : ''; ?>><br><br>
                    <label><input type="submit" value="Update Kurikulum"><br><br></label>
                </form>
            </div>
        </div>
    </div>
</body>

</html>