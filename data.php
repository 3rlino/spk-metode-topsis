<?php
// get_mahasiswa_data.php

if(isset($_POST["nim"])) {
    $nim = $_POST["nim"];

    // Lakukan koneksi ke database
    $connect = mysqli_connect("localhost", "root", "", "spk");
    if ($connect === false) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Ambil data mahasiswa berdasarkan Nim
    $query = "SELECT nama_mahasiswa, prodi FROM mahasiswa WHERE nim = '$nim'";
    $result = mysqli_query($connect, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response = array(
            'nama_mahasiswa' => $row['nama_mahasiswa'],
            'prodi' => $row['prodi']
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Mahasiswa tidak ditemukan'));
    }

    // Tutup koneksi ke database
    mysqli_close($connect);
}
?>
