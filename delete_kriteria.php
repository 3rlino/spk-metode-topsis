<?php
// delete_data.php

// Cek apakah parameter id_mahasiswa ada
if(isset($_GET["id_kriteria"])) {
    $id_kriteria = $_GET["id_kriteria"];

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
    $query = "DELETE FROM data_kriteria WHERE id_kriteria='$id_kriteria'";
    mysqli_query($connect, $query);

    // Tutup koneksi ke database
    $connect->close();

    // Redirect ke halaman lain setelah data berhasil dihapus
    header("Location: kriteria.php");
    exit();
}
?>
