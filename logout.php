<?php
session_start(); // Memulai sesi untuk mengakses data sesi
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Mengakhiri sesi

// Mengarahkan pengguna kembali ke halaman login
header("Location: index.php");
exit;
?>
