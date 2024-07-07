<?php
// delete_data.php

// Cek apakah parameter id_mahasiswa ada
if(isset($_GET["id_konver"])) {
    $id_konver = $_GET["id_konver"];

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
    $query = "DELETE FROM data_konversi WHERE id_konver='$id_konver'";
    mysqli_query($connect, $query);

    // Tutup koneksi ke database
    $connect->close();

    // Redirect ke halaman lain setelah data berhasil dihapus
    header("Location: konversi.php");
    exit();
}
?>
