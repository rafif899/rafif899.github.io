<?php
// Memanggil file koneksi
include 'koneksi.php';
include 'cek_login.php';
if (isset($_GET['hapus_id'])) {
    $hapus_id = $_GET['hapus_id'];
    $sql_hapus = "DELETE FROM jurusan WHERE jurId = $hapus_id";
    if ($conn->query($sql_hapus)) {
        echo "<script>alert('Data jurusan berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Error saat menghapus data: " . $conn->error . "');</script>";
    }
    echo "<script>window.location='jurusan.php';</script>";
}

// Query untuk mengambil data dari tabel jurusan
$sql = "SELECT * FROM jurusan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jurusan</title>
    <script>
        function confirmDelete(jurId) {
            if (confirm("Apakah Anda yakin ingin menghapus data jurusan ini?")) {
                window.location.href = "jurusan.php?hapus_id=" + jurId;
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
                <a href="jurusan.php"><img src="images/nav.png">Jurusan</a>
            </div>
            
            <div class="menu_daftar">
                <a href="add_jurusan.php">Tambah Data</a>
            </div>

            <div class="daftar_tabel">
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr>
                        <th>No</th>
                        <th>Kode Jurusan</th>
                        <th>Nama Jurusan</th>
                        <th>Nama Asing</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                // Jika hasil query ada datanya
                if ($result->num_rows > 0) {
                    // Menampilkan setiap data jurusan dalam tabel
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['jurId'] . "</td>";
                        echo "<td>" . $row['jurKode'] . "</td>";
                        echo "<td>" . $row['jurNama'] . "</td>";
                        echo "<td>" . $row['jurNamaAsing'] . "</td>";
                        echo "<td>" . ($row['jurIsAktif'] ? 'Aktif' : 'Tidak Aktif') . "</td>";
                        echo "<td>";
                        echo "<a href='edit_jurusan.php?jurId=" . $row['jurId']. "'>Edit</a> | ";
                        echo "<a href='#' onclick='confirmDelete(" . $row['jurId'] . ")'>Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Jika tidak ada data
                    echo "<tr><td colspan='6'>Tidak ada data jurusan</td></tr>";
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
