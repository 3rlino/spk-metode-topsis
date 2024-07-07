<?php
session_start();
session_destroy(); // Hapus semua sesi

// Redirect kembali ke halaman login atau halaman lain yang sesuai
header("Location: index.php"); // Ganti dengan halaman yang sesuai
exit();
?>