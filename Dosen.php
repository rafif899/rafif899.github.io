<?php
include 'koneksi.php';
include 'cek_login.php';

$sql = "SELECT *,jurNama,prodiNama FROM dosen left join jurusan on jurId=dsnJurId left join prodi on prodiId=dsnProdiId";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen</title>
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
                <a href="dosen.php"><img src="images/nav.png">Dosen</a>
            </div>

            <div class="daftar_tabel">
                <h3>Daftar Dosen</h3>
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr>

                        <th>No</th>
                        <th>Nama Dosen</th>
                        <th>Nidn</th>
                        <th>Jurusan</th>
                        <th>Program Studi </th>
                        <th>Jenis Kelamin</th>
                        <th>status</th>
                    </tr>
                    <?php
                    // Jika hasil query ada datanya
                    if ($result->num_rows > 0) {
                        // Menampilkan setiap data jurusan dalam tabel
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . $row['dsnGelarDepan'] . " " . $row['dsnNama'] . "," . $row['dsnGelarBelakang'] . "</td>";
                            echo "<td>" . $row['dsnNidn'] . "</td>";
                            echo "<td>" . $row['jurNama'] . "</td>";
                            echo "<td>" .$row['prodiJenjang']." ". $row['prodiNama'] . "</td>";
                            echo "<td>" . ($row['dsnJenisKelaminKode'] == 'L' ? 'Laki-laki' : 'Perempuan') . "</td>";
                            echo "<td>" . ($row['dsnIsAktif'] ? 'Aktif' : 'Tidak Aktif') . "</td>";
                            // echo "<td>";
                            echo "</tr>";
                            $no++;
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