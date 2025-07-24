<?php
include 'koneksi.php';
include 'cek_login.php';

// Inisialisasi variabel
$nim = isset($_GET['nim']) ? $_GET['nim'] : '';
$result = null;
$message="";
// Hanya jalankan query jika NIM tersedia
if (!empty($nim)) {
    $sql = "SELECT * FROM krs_khs
            LEFT JOIN krs ON krsId=khsKrsId 
            LEFT JOIN matakuliah ON MkId=khsMkId 
            LEFT JOIN mahasiswa ON MhsNim=krsMhsNim
            WHERE MhsNim = '$nim'";
    $result = $conn->query($sql);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Hasil Studi</title>
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
                <a href="pascakuliah.php"><img src="images/nav.png">Pascakuliah</a>
                <a href="#"><img src="images/nav.png">kartu Hasil Studi</a>
            </div>

            <div class="opsi">
                <h2>Kartu Hasil Studi</h2>
                <form method="get" action="">
                    <label for="nim">Masukkan NIM:</label>
                    <input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($nim); ?>" required>
                    <button type="submit">Cari</button>
                </form>
            </div>



            <div class="daftar_tabel">
                <?php if (!empty($nim)): ?>
                    <h3>Hasil pencarian untuk NIM: <?php echo htmlspecialchars($nim); ?></h3>
                    <table border="1" cellpadding="10" cellspacing="0">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Matakuliah</th>
                            <th>Kode Nilai</th>
                            <th>Bobot Nilai</th>
                        </tr>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row['mhsNama'] . "</td>";
                                echo "<td>" . $row['mkNama'] . "</td>";
                                echo "<td>" . $row['khsKodeNilai'] . "</td>";
                                echo "<td>" . $row['khsBobotNilai'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Data tidak ditemukan</td></tr>";
                        }
                        ?>
                    </table>
                <?php else: ?>
                    <p>Masukkan NIM untuk menampilkan data.</p>
                <?php endif; ?>
                <?php $conn->close(); ?>
            </div>
        </div>
    </div>
</body>

</html>