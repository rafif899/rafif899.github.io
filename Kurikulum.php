<?php
// Memanggil file koneksi
include 'koneksi.php';
include 'cek_login.php'; // Cek apakah sudah login

// Proses penghapusan data
if (isset($_GET['hapus_id'])) {
    $hapus_id = intval($_GET['hapus_id']); // Konversi menjadi integer untuk keamanan
    $sql_hapus = "DELETE FROM kurikulum WHERE kurId = $hapus_id";
    if ($conn->query($sql_hapus) === TRUE) {
        echo "Data Kurikulum berhasil dihapus!";
    } else {
        echo "Error saat menghapus data: " . $conn->error;
    }
}

// Query untuk menampilkan data kurikulum
$sql = "SELECT kurId, prodiNama, prodiJenjang, kurTahun, kurNama, kurIsAktif 
        FROM kurikulum 
        LEFT JOIN prodi ON prodiId = kurProdiId";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurikulum</title>
    <script>
        function confirmDelete(kurId) {
            if (confirm("Apakah Anda yakin ingin menghapus data kurikulum ini?")) {
                window.location.href = "kurikulum.php?hapus_id=" + kurId;
            }
        }
    </script>

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
                <a href="#"><img src="images/nav.png">Kurikulum</a>
            </div>

            <div class="menu_daftar">
                <a href="add_kurikulum.php">Tambah Data</a>
            </div>

            
            <div class="daftar_tabel">
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr>
                        <th>No.</th>
                        <th>Program Studi</th>
                        <th>Tahun</th>
                        <th>Nama Kurikulum</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    // Jika hasil query ada data
                    if ($result->num_rows > 0) {
                        // Menampilkan setiap data jurusan dalam tabel
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['kurId'] . "</td>";
                            echo "<td>" . $row['prodiJenjang'] . ' ' . $row['prodiNama'] . "</td>";
                            echo "<td>" . $row['kurTahun'] . "</td>";
                            echo "<td>" . $row['kurNama'] . "</td>";
                            echo "<td>" . ($row['kurIsAktif'] ? 'Aktif' : 'Tidak Aktif') . "</td>";
                            echo "<td>";
                            echo "<a href='edit_kur.php?kurId=" . $row['kurId'] . "'>Edit</a> | ";
                            echo "<a href='#' onclick='confirmDelete(" . $row['kurId'] . ")'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Jika tidak ada data
                        echo "<tr><td colspan='6'>Tidak ada data program studi</td></tr>";
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
