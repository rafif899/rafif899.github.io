<?php
include 'cek_login.php';
include 'koneksi.php';

// Ambil data program studi untuk dropdown
$sql_prodi = "SELECT DISTINCT CONCAT(prodiJenjang, ' ', prodiNama) AS prodiLengkap, prodiId FROM prodi";
$result_prodi = $conn->query($sql_prodi);

// Ambil data kelas untuk dropdown
$sql_kelas = "SELECT DISTINCT klsId, klsNama FROM kelas";
$result_kelas = $conn->query($sql_kelas);

// Variabel untuk menyimpan data dosen berdasarkan kelas
$message = "";
$dosen_kelas = [];
if (isset($_POST['cari']) && isset($_POST['prodiId']) && isset($_POST['klsId'])) {
    $prodiId = $conn->real_escape_string($_POST['prodiId']);
    $klsId = $conn->real_escape_string($_POST['klsId']);

    // Query untuk mendapatkan data dosen dan matakuliah berdasarkan kelas dan program studi
    $sql_dosen = "
        SELECT dosen.dsnNama, matakuliah.mkNama, kelas.klsNama, prodi.prodiJenjang, prodi.prodiNama, kelas_dosen.klsdsnIsAktif
        FROM kelas_dosen
        LEFT JOIN dosen ON kelas_dosen.klsdsnDsnNidn = dosen.dsnNidn
        LEFT JOIN matakuliah ON kelas_dosen.klsdsnMkId = matakuliah.mkId
        LEFT JOIN kelas ON kelas_dosen.klsdsnKlsId = kelas.klsId
        LEFT JOIN prodi ON kelas.klsProdiId = prodi.prodiId
        WHERE kelas.klsId = '$klsId' AND prodi.prodiId = '$prodiId';
    ";
    $dosen_result = $conn->query($sql_dosen);

    if ($dosen_result->num_rows > 0) {
        while ($row = $dosen_result->fetch_assoc()) {
            $dosen_kelas[] = $row;
        }
    } else {
        $message = "Tidak ada data dosen untuk program studi dan kelas tersebut.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dosen Kelas</title>
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
                <a href="#"><img src="images/nav.png">Daftar Dosen Kelas</a>
            </div>

            <div class="opsi">

                <form method="POST">
                    <div>
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
                    </div>

                    <div>
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
                        <div>

                            <button type="submit" name="cari">Cari</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="warning_opsi">
                <?php
                echo $message;
                ?>
            </div>

            <div class="daftar_tabel">
                <?php if (isset($_POST['cari']) && !empty($dosen_kelas)) { ?>
                    <table border="1">
                        <tr>
                            <th>No</th>
                            <th>Nama Dosen</th>
                            <th>Nama Matakuliah</th>
                            <th>Nama Kelas</th>
                            <th>Program Studi</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        foreach ($dosen_kelas as $index => $dk) {
                            echo "<tr>";
                            echo "<td>" . ($index + 1) . "</td>";
                            echo "<td>" . htmlspecialchars($dk['dsnNama']) . "</td>";
                            echo "<td>" . htmlspecialchars($dk['mkNama']) . "</td>";
                            echo "<td>" . htmlspecialchars($dk['klsNama']) . "</td>";
                            echo "<td>" . htmlspecialchars($dk['prodiJenjang'] . " " . $dk['prodiNama']) . "</td>";
                            echo "<td>" . ($dk['klsdsnIsAktif'] == 1 ? "Aktif" : "Non-Aktif") . "</td>";
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