<?php
include 'cek_login.php';
include 'koneksi.php';

// Ambil data program studi untuk dropdown
$sql_prodi = "SELECT DISTINCT CONCAT(prodiJenjang, ' ', prodiNama) AS prodiLengkap, prodiId FROM prodi";
$result_prodi = $conn->query($sql_prodi);

// Ambil data kelas untuk dropdown
$sql_kelas = "SELECT DISTINCT klsId, klsNama FROM kelas";
$result_kelas = $conn->query($sql_kelas);

// Variabel untuk menyimpan data mahasiswa berdasarkan kelas
$mahasiswa_kelas = [];
$message = "";
if (isset($_POST['cari']) && isset($_POST['prodiId']) && isset($_POST['klsId'])) {
    $prodiId = $conn->real_escape_string($_POST['prodiId']);
    $klsId = $conn->real_escape_string($_POST['klsId']);

    // Query untuk mendapatkan data mahasiswa berdasarkan kelas dan program studi
    $sql_mahasiswa = "
        SELECT mahasiswa.mhsNim, mahasiswa.mhsNama, kelas.klsNama, prodi.prodiJenjang, prodi.prodiNama, kelas_mahasiswa.klsmhsIsAktif
        FROM kelas_mahasiswa
        LEFT JOIN mahasiswa ON kelas_mahasiswa.klsmhsMhsNim = mahasiswa.mhsNim
        LEFT JOIN kelas ON kelas_mahasiswa.klsmhsKlsId = kelas.klsId
        LEFT JOIN prodi ON kelas.klsProdiId = prodi.prodiId
        WHERE kelas.klsId = '$klsId' AND prodi.prodiId = '$prodiId';
    ";
    $mahasiswa_result = $conn->query($sql_mahasiswa);

    if ($mahasiswa_result->num_rows > 0) {
        while ($row = $mahasiswa_result->fetch_assoc()) {
            $mahasiswa_kelas[] = $row;
        }
    } else {
        $message = "Tidak ada mahasiswa untuk program studi dan kelas tersebut.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa Kelas</title>
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
                <a href="#"><img src="images/nav.png">Daftar Mahasiswa Kelas</a>
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
                <?php echo $message; ?>
            </div>
            <div class="daftar_tabel">
                <?php if (isset($_POST['cari']) && !empty($mahasiswa_kelas)) { ?>
                    <table border="1">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM </th>
                            <th>Nama Kelas</th>
                            <th>Program Studi</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        foreach ($mahasiswa_kelas as $index => $mk) {
                            echo "<tr>";
                            echo "<td>" . ($index + 1) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['mhsNama']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['mhsNim']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['klsNama']) . "</td>";
                            echo "<td>" . htmlspecialchars($mk['prodiJenjang'] . " " . $mk['prodiNama']) . "</td>";
                            echo "<td>" . ($mk['klsmhsIsAktif'] == 1 ? "Aktif" : "Non-Aktif") . "</td>";
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