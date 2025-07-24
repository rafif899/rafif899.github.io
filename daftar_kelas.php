<?php
include 'cek_login.php';
include 'koneksi.php';

// Ambil data program studi untuk dropdown
$sql_prodi = "SELECT DISTINCT CONCAT(prodiJenjang, ' ', prodiNama) AS prodiLengkap FROM prodi";
$result_prodi = $conn->query($sql_prodi);

// Variabel untuk menyimpan kelas berdasarkan prodi
$message ="";
$kelas = [];
if (isset($_POST['cari']) && isset($_POST['prodiLengkap'])) {
    $prodiLengkap = $conn->real_escape_string($_POST['prodiLengkap']);

    // Query untuk mendapatkan kelas berdasarkan prodiNama dan prodiJenjang
    $sql_kelas = "
        SELECT kelas.*, CONCAT(prodi.prodiJenjang, ' ', prodi.prodiNama) AS prodiLengkap, thakd.thakdTahun
        FROM kelas
        LEFT JOIN prodi ON kelas.klsProdiId = prodi.prodiId
        LEFT JOIN tahun_akademik thakd ON kelas.klsThakdid = thakd.thakdId
        WHERE CONCAT(prodi.prodiJenjang, ' ', prodi.prodiNama) = '$prodiLengkap'
    ";
    $kelas_result = $conn->query($sql_kelas);

    if ($kelas_result->num_rows > 0) {
        while ($row = $kelas_result->fetch_assoc()) {
            $kelas[] = $row;
        }
    } else {
       $message="Tidak ada kelas untuk program studi tersebut.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kelas</title>
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
                <a href="prakuliah.php"><img src="images/nav.png">Prakuliah</a>
                <a href="daftar_kelas.php"><img src="images/nav.png">Daftar Kelas</a>
            </div>

            <div class="opsi">

                <form method="POST">
                    Program Studi:
                    <select name="prodiLengkap">
                        <option value="" disabled selected>Pilih Program Studi</option>
                        <?php
                        if ($result_prodi->num_rows > 0) {
                            while ($row = $result_prodi->fetch_assoc()) {
                                $selected = (isset($_POST['prodiLengkap']) && $_POST['prodiLengkap'] === $row['prodiLengkap']) ? 'selected' : '';
                                echo "<option value='" . $row['prodiLengkap'] . "' $selected>" . $row['prodiLengkap'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada program studi tersedia</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" name="cari">Cari</button>
                </form>
            </div>

            <div class="warning_opsi">
                <?php
                    echo $message;
                ?>
            </div>


            <div class="daftar_tabel">
                <?php if (isset($_POST['cari']) && !empty($kelas)) { ?>
                    <h3>Kelas Program Studi: <?php echo htmlspecialchars($_POST['prodiLengkap']); ?></h3>
                    <table border="1">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Tahun Akademik</th>
                            <th>Program Studi</th>
                        </tr>
                        <?php
                        foreach ($kelas as $kls) {
                            echo "<tr>";
                            echo "<td>" . $kls['klsId'] . "</td>";
                            echo "<td>" . $kls['klsNama'] . "</td>";
                            echo "<td>" . $kls['thakdTahun'] . "</td>";
                            echo "<td>" . $kls['prodiLengkap'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>