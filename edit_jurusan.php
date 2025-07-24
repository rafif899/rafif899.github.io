<?php
// Memanggil file koneksi
include 'koneksi.php';
include 'cek_login.php';
// Ambil jurId dari URL
$jurId = $_GET['jurId'];

// Query untuk mengambil data berdasarkan jurId
$sql = "SELECT * FROM jurusan WHERE jurId = $jurId";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jurKode = $_POST['jurKode'];
    $jurNama = $_POST['jurNama'];
    $jurNamaAsing = $_POST['jurNamaAsing'];
    $jurIsAktif = isset($_POST['jurIsAktif']) ? 1 : 0;

    $sql_update = "UPDATE jurusan SET 
                   jurKode = '$jurKode', 
                   jurNama = '$jurNama', 
                   jurNamaAsing = '$jurNamaAsing', 
                   jurIsAktif = $jurIsAktif 
                   WHERE jurId = $jurId";

    if ($conn->query($sql_update) === TRUE) {
        echo "Data jurusan berhasil diupdate!";
        header("Location:jurusan.php"); // Redirect setelah update
        exit;
    } else {
        echo "Error saat mengupdate data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Jurusan</title>
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
                <a href="#"><img src="images/nav.png">Edit data Jurusan</a>
            </div>

            <div class="input_data">
                <h2>Form Edit Jurusan</h2>
                <form method="POST" action="">
                    <label>Kode Jurusan: </label><input class="kotak" type="text" name="jurKode"
                        value="<?php echo $data['jurKode']; ?>" required><br><br>
                    <label>Nama Jurusan: </label><input class="kotak" type="text" name="jurNama"
                        value="<?php echo $data['jurNama']; ?>" required><br><br>
                    <label>Nama Asing Jurusan: </label><input class="kotak" type="text" name="jurNamaAsing"
                        value="<?php echo $data['jurNamaAsing']; ?>"><br><br>
                    <label>Aktif: </label><input type="checkbox" name="jurIsAktif" <?php echo $data['jurIsAktif'] ? 'checked' : ''; ?>><br><br>
                    <label><input type="submit" value="Update Jurusan"></label><br><br>
                </form>
            </div>
        </div>
    </div>
</body>

</html>