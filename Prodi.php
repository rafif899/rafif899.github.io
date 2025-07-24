<?php
// Memanggil file koneksi
include 'koneksi.php';
include 'cek_login.php'; // Cek apakah sudah login

if (isset($_GET['hapus_id'])) {
    $hapus_id = $_GET['hapus_id'];
    $sql_hapus = "DELETE FROM prodi WHERE prodiId = $hapus_id";
    if ($conn->query($sql_hapus)) {
        echo "<script>alert('Data program studi berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Error saat menghapus data: " . $conn->error . "');</script>";
    }
    echo "<script>window.location='Prodi.php';</script>";
}

// Query untuk mengambil data dari tabel prodi
$sql = "SELECT prodiId,prodiKode,prodiNama,jurNama,prodiIsAktif,prodiJenjang FROM prodi LEFT JOIN jurusan ON jurId =prodiJurId ";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Studi</title>
    <script>
        function confirmDelete(prodiId) {
            if (confirm("Apakah Anda yakin ingin menghapus data program studi ini?")) {
                window.location.href = "Prodi.php?hapus_id=" + prodiId;
            }
        }
    </script>
    <link rel="stylesheet" type="text/css" href="styles.css"
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
                <a href="prodi.php"><img src="images/nav.png">Program Studi</a>
            </div>

            <div class="menu_daftar">
                <a href="add_prodi.php">Tambah Data</a>
            </div>
            
            <div class="daftar_tabel">    
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr>
                        <th>No.</th>
                        <th>Kode </th>
                        <th>Nama Program Studi</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    // Jika hasil query ada datanya
                    if ($result->num_rows > 0) {
                        // Menampilkan setiap data program studi dalam tabel
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['prodiId'] . "</td>";
                            echo "<td>" . $row['prodiKode'] . "</td>";
                            echo "<td>" .$row['prodiJenjang'].' '. $row['prodiNama'] . "</td>";
                            echo "<td>" . $row['jurNama'] . "</td>";
                            echo "<td>" . ($row['prodiIsAktif'] ? 'Aktif' : 'Tidak Aktif') . "</td>";
                            echo "<td>";
                            echo "<a href='edit_prodi.php?prodiId=" . $row['prodiId'] . "'>Edit</a> | ";
                            echo "<a href='#' onclick='confirmDelete(" . $row['prodiId'] . ")'>Hapus</a>";
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
