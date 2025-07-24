<?php
// Memanggil file koneksi
include 'koneksi.php';
include 'cek_login.php';
// Ambil prodiId dari URL
$prodiId = $_GET['prodiId'];

// Query untuk mengambil data berdasarkan prodiId
$sql = "SELECT *,jurNama FROM prodi LEFT JOIN jurusan ON jurId =prodiJurId WHERE prodiId = $prodiId";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prodiKode = $_POST['prodiKode'];
    $prodiNama = $_POST['prodiNama'];
    $prodiNamaAsing = $_POST['prodiNamaAsing'];
    $prodiIsAktif = isset($_POST['prodiIsAktif']) ? 1 : 0;

    $sql_update = "UPDATE prodi SET 
                   prodiKode = '$prodiKode', 
                   prodiNama = '$prodiNama', 
                   prodiNamaAsing = '$prodiNamaAsing', 
                   prodiIsAktif = $prodiIsAktif 
                   WHERE prodiId = $prodiId";

    if ($conn->query($sql_update) === TRUE) {
        echo "Data prodi berhasil diupdate!";
        header("Location:prodi.php"); // Redirect setelah update
        exit;
    } else {
        echo "Error saat mengupdate data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Program Studi</title>
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
                <a href="prodi.php"><img src="images/nav.png">Program Studi</a>
                <a href="#"><img src="images/nav.png">Edit data Program Studi</a>
            </div>

            <div class="input_data">
                <h2>Form Edit Program Studi</h2>
                <form method="POST" action="">
                    <label>Kode Program Studi: </label><input class="kotak" type="text" name="prodiKode"
                        value="<?php echo $data['prodiKode']; ?>" required><br><br>
                    <label>Nama Program Studi:</label> <input class="kotak" type="text" name="prodiNama"
                        value="<?php echo $data['prodiNama']; ?>" required><br><br>
                    <label>Nama Asing Program Studi:</label> <input class="kotak" type="text" name="prodiNamaAsing"
                        value="<?php echo $data['prodiNamaAsing']; ?>"><br><br>
                    <label>Aktif: </label><input type="checkbox" name="prodiIsAktif" <?php echo $data['prodiIsAktif'] ? 'checked' : ''; ?>><br><br>
                    <label><input type="submit" value="Update Prodi"></label><br><br>
                </form>

            </div>
        </div>
    </div>
</body>

</html>