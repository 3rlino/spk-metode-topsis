<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Absensi Karyawan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <style>
        .img-preview {
            max-width: 200px;
            max-height: 200px;
        }
        .disable-input {
    pointer-events: none;
         }
    section{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-ontent:center;
        }

    </style>
</head>
<body>
<section>
    <div class="container" style="width:500px;">
        <h3 align="center">Tambah Data Mahasiswa</h3>
        <br />
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nim</label>
                <input type="text" id="nim" name="nim" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Prodi</label>
                <input type="text" id="prodi" name="prodi" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Semester</label>
                <input type="text" id="semester" name="semester" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea type="text" name="alamat" id="alamat" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Pekerjaan Orangtua</label>
                <input type="text" name="pekerjaan_orangtua" id="pekerjaan_orangtua" class="form-control" required>
            </div>
            <div class="form-group">
                <input id="insert" type="submit" name="insert" value="Tambah" class="btn btn-success" />
            </div>
        </form>

        <div align="right">
            <a href="mahasiswa.php" class="btn btn-warning">Batal</a>
        </div>
        <br />
    </div>
</section>
</body>
</html>
<?php
// create_data.php

// Cek apakah form telah disubmit
if(isset($_POST["insert"])) {
    $nim = $_POST["nim"];
    $nama_mahasiswa = $_POST["nama_mahasiswa"];
    $prodi = $_POST["prodi"];
    $semester = $_POST["semester"];
    $alamat = $_POST["alamat"];
    $pekerjaan_orangtua = $_POST["pekerjaan_orangtua"];

    // Simpan data ke database
    $connect = mysqli_connect("localhost", "root", "", "spk");
    $query = "INSERT INTO mahasiswa (nim, nama_mahasiswa, prodi, semester, alamat, pekerjaan_orangtua) 
              VALUES ('$nim', '$nama_mahasiswa', '$prodi', '$semester', '$alamat', '$pekerjaan_orangtua')";

    if (mysqli_query($connect, $query)) {
        // Redirect ke halaman index.php jika penambahan data berhasil
        header("Location: mahasiswa.php");
        exit();
    } else {
        // Redirect kembali ke create-data.php jika penambahan data gagal
        header("Location: create_data.php");
        exit();
    }
}
?>