<?php
// delete_data.php

// Cek apakah parameter id_mahasiswa ada
if(isset($_GET["id_hasil_topsis"])) {
    $id_hasil_topsis = $_GET["id_hasil_topsis"];

    // Lakukan koneksi ke database
    $servername = "localhost";
    $username = "root"; // Ganti dengan username database Anda
    $password = ""; // Ganti dengan password database Anda
    $dbname = "spk";

    $connect = new mysqli($servername, $username, $password, $dbname);

    // Periksa apakah koneksi berhasil didirikan
    if ($connect->connect_error) {
        die("Koneksi gagal: " . $connect->connect_error);
    }

    // Hapus data dari database
    $query = "DELETE FROM hasil_topsis WHERE id_hasil_topsis='$id_hasil_topsis'";
    mysqli_query($connect, $query);

    // Tutup koneksi ke database
    $connect->close();

    // Redirect ke halaman lain setelah data berhasil dihapus
    header("Location: laporan.php");
    exit();
}
?>
