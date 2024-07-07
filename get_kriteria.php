<?php
// get_kriteria.php

if (isset($_POST["id_kriteria"])) {
    $id_kriteria = $_POST["id_kriteria"];

    // Lakukan koneksi ke database
    $connect = mysqli_connect("localhost", "root", "", "spk");
    if ($connect === false) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Ambil nim berdasarkan id_kriteria dari data_kriteria
    $query = "SELECT nim FROM data_kriteria WHERE id_kriteria = '$id_kriteria'";
    $result = mysqli_query($connect, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $nim = $row['nim'];

        // Ambil data mahasiswa berdasarkan Nim
        $query_mahasiswa = "SELECT nama_mahasiswa, prodi FROM mahasiswa WHERE nim = '$nim'";
        $result_mahasiswa = mysqli_query($connect, $query_mahasiswa);

        if (mysqli_num_rows($result_mahasiswa) > 0) {
            $row_mahasiswa = mysqli_fetch_assoc($result_mahasiswa);
            $response = array(
                'nama_mahasiswa' => $row_mahasiswa['nama_mahasiswa'],
                'prodi' => $row_mahasiswa['prodi']
            );
            echo json_encode($response);
        } else {
            echo json_encode(array('error' => 'Mahasiswa tidak ditemukan'));
        }
    } else {
        echo json_encode(array('error' => 'Data kriteria tidak ditemukan'));
    }

    // Tutup koneksi ke database
    mysqli_close($connect);
}
?>
