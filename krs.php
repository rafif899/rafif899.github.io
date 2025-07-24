<?php
include 'koneksi.php';
include 'cek_login.php';

$sql = "SELECT * FROM krs 
LEFT JOIN tahun_akademik ON thakdId=krsThakdId 
LEFT JOIN mahasiswa ON mhsNim=krsMhsNim
LEFT JOIN dosen ON dsnNidn=krsPADsnNidn ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu rencana Studi</title>
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
                <a href="#"><img src="images/nav.png">kartu Rencana Studi</a>
            </div>

            <div class="daftar_tabel">
                <h2>Kartu Rencana Studi</h2>
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa </th>
                        <th>NIM </th>
                        <th>Tahun Akademik</th>
                        <th>Pembimbing akademik </th>
                        <th>Tanggal Terdaftar </th>
                        <th>Semester</th>
                    </tr>
                    <?php
                    // Jika hasil query ada datanya
                    if ($result->num_rows > 0) {
                        // Menampilkan setiap data jurusan dalam tabel
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['krsId'] . "</td>";
                            echo "<td>" . $row['mhsNama'] . "</td>";
                            echo "<td>" . $row['krsMhsNim'] . "</td>";
                            echo "<td>" . $row['thakdTahun'] . "</td>";
                            echo "<td>" . $row['dsnNama'] . "</td>";
                            echo "<td>" . $row['krsTglTerdaftar'] . "</td>";
                            echo "<td>" . $row['krsSemester'] . "</td>";

                            // echo "<td>";
                            echo "</tr>";
                        }
                    } else {
                        // Jika tidak ada data
                        echo "<tr><td colspan='5'>Tidak ada data program studi</td></tr>";
                    }

                    // Tutup koneksi
                    $conn->close();
                    ?>

                </table>
            </div>
        </div>
    </div>
</body>

</html>