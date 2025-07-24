<?php
include 'cek_login.php';
include 'koneksi.php';

// Ambil data program studi untuk dropdown
$sql_prodi = "SELECT DISTINCT CONCAT(prodiJenjang, ' ', prodiNama) AS prodiLengkap, prodiId FROM prodi";
$result_prodi = $conn->query($sql_prodi);

// Ambil data kelas untuk dropdown
$sql_kelas = "SELECT DISTINCT klsId, klsNama FROM kelas";
$result_kelas = $conn->query($sql_kelas);

// Variabel untuk menyimpan mata kuliah berdasarkan kelas
$matakuliah = [];
$message = "";
if (isset($_POST['cari']) && isset($_POST['prodiId']) && isset($_POST['klsId'])) {
    $prodiId = $conn->real_escape_string($_POST['prodiId']);
    $klsId = $conn->real_escape_string($_POST['klsId']);

    // Query untuk mendapatkan mata kuliah berdasarkan kelas dan program studi
    $sql_matkul = "
        SELECT matakuliah.mkId, matakuliah.mkNama, matakuliah.mkSks, matakuliah.mkSemester, 
               kelas.klsNama, prodi.prodiJenjang, prodi.prodiNama, thakd.thakdTahun
        FROM kelas_matakuliah
        LEFT JOIN matakuliah ON kelas_matakuliah.klsmkMkId = matakuliah.mkId
        LEFT JOIN kelas ON kelas_matakuliah.klsmkKlsId = kelas.klsId
        LEFT JOIN prodi ON kelas.klsProdiId = prodi.prodiId
        LEFT JOIN tahun_akademik thakd ON kelas.klsThakdId = thakd.thakdId
        WHERE kelas.klsId = '$klsId' AND prodi.prodiId = '$prodiId';
    ";
    $matkul_result = $conn->query($sql_matkul);

    if ($matkul_result->num_rows > 0) {
        while ($row = $matkul_result->fetch_assoc()) {
            $matakuliah[] = $row;
        }
    } else {
        $message = "Tidak ada mata kuliah untuk program studi dan kelas tersebut.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mata Kuliah Kelas</title>
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
                <a href="#"><img src="images/nav.png">Daftar Matakuliah Kelas</a>
            </div>


            <div class="opsi">

                <form method="POST">
                    Program Studi:
                    <select name="prodiId" required>
                        <option value="" disabled selected>Pilih Program Studi</option>
                        <?php
                        if ($result_prodi->num_rows > 0) {
                            while ($row = $result_prodi->fetch_assoc()) {
                                $selected = (isset($_POST['prodiId']) && $_POST['prodiId'] === $row['prodiId']) ? 'selected' : '';
                                echo "<option value='" . $row['prodiId'] . "' $selected>" . $row['prodiLengkap'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada program studi tersedia</option>";
                        }
                        ?>

                    </select>

                    Nama Kelas:
                    <select name="klsId" required>
                        <option value="" disabled selected>Pilih Nama Kelas</option>
                        <?php
                        if ($result_kelas->num_rows > 0) {
                            while ($row = $result_kelas->fetch_assoc()) {
                                $selected = (isset($_POST['klsId']) && $_POST['klsId'] === $row['klsId']) ? 'selected' : '';
                                echo "<option value='" . $row['klsId'] . "' $selected>" . $row['klsNama'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada kelas tersedia</option>";
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
                <?php if (isset($_POST['cari']) && !empty($matakuliah)) { ?>
                    <h3>Mata Kuliah Program Studi dan Kelas</h3>
                    <table border="1">
                        <tr>
                            <th>No</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Nama Kelas</th>
                            <th>Program Studi</th>
                            <th>Tahun Akademik</th>
                        </tr>
                        <?php
                        foreach ($matakuliah as $index => $mk) {
                            echo "<tr>";
                            echo "<td>" . ($index + 1) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['mkNama']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['mkSks']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['mkSemester']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['klsNama']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['prodiJenjang'] . " " . $mk['prodiNama']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['thakdTahun']) . "</td>";
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