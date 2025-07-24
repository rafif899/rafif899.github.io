<?php
include 'cek_login.php';
include 'koneksi.php';

// Ambil data program studi untuk dropdown
$sql_prodi = "SELECT DISTINCT prodiId, prodiNama, prodiJenjang FROM prodi";
$result_prodi = $conn->query($sql_prodi);

// Variabel untuk menyimpan mata kuliah berdasarkan prodi
$message="";
$matakuliah = [];
if (isset($_POST['cari']) && isset($_POST['prodiId'])) {
    $prodiId = $conn->real_escape_string($_POST['prodiId']);

    // Query untuk mendapatkan mata kuliah berdasarkan prodiId
    $sql_matkul = "
        SELECT matakuliah.*, kurikulum.kurNama, prodi.prodiNama, prodi.prodiJenjang 
        FROM matakuliah
        LEFT JOIN kurikulum ON matakuliah.mkKurId = kurikulum.kurId
        LEFT JOIN prodi ON kurikulum.kurProdiId = prodi.prodiId
        WHERE prodi.prodiId = '$prodiId'
    ";
    $matkul_result = $conn->query($sql_matkul);

    if ($matkul_result->num_rows > 0) {
        while ($row = $matkul_result->fetch_assoc()) {
            $matakuliah[] = $row;
        }
    } else {
        $message="Tidak ada mata kuliah untuk program studi tersebut!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mata Kuliah</title>
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
                <a href="Mata Kuliah.php"><img src="images/nav.png">Mata Kuliah</a>
            </div>

            <div class="opsi">
                <form method="POST">
                    Program Studi: 
                    <select name="prodiId">
                    <option value="" disabled selected></option>
                        <?php
                        if ($result_prodi->num_rows > 0) {
                            while ($row = $result_prodi->fetch_assoc()) {
                                $optionText = $row['prodiJenjang'] . " " . $row['prodiNama'];
                                $selected = (isset($_POST['prodiId']) && $_POST['prodiId'] === $row['prodiId']) ? 'selected' : '';
                                echo "<option value='" . $row['prodiId'] . "' $selected>" . $optionText . "</option>";
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
                <?php if (isset($_POST['cari']) && !empty($matakuliah)) { 
                    $prodiTerpilih = $conn->query("SELECT prodiNama, prodiJenjang FROM prodi WHERE prodiId = '$prodiId'")->fetch_assoc();
                ?>
                    <h3>Mata Kuliah Program Studi: <?php echo htmlspecialchars($prodiTerpilih['prodiJenjang'] . " " . $prodiTerpilih['prodiNama']); ?></h3>
                    <table border="1">
                        <tr>
                            <th>No</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Kurikulum</th>
                            <th>Semester</th>
                            <th>Sks</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        foreach ($matakuliah as $index => $mk) {
                            echo "<tr>";
                            echo "<td>" . ($index + 1) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['mkNama']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['kurNama']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['mkSemester']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['mkSks']) . "</td>";
                            echo "<td>" . ($mk['mkIsAktif'] ? 'Aktif' : 'Tidak Aktif') . "</td>";
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
