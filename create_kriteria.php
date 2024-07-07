<?php
// create_data.php

if(isset($_POST["insert"])) {
    $id_mahasiswa = $_POST["id_mahasiswa"];
    $nim = $_POST["nim"];
    $prodi = $_POST["prodi"];
    $jumlah_pendapatan_orangtua_input = $_POST["jumlah_pendapatan_orangtua"];

    $nilai_pendapatan = $jumlah_pendapatan_orangtua_input; // Menggunakan nilai yang dipilih langsung

    $nilai_ipk_option = $_POST["nilai_ipk"];
    $jumlah_tanggungan = $_POST["jumlah_tanggungan"];
    $keaktifan_kuliah_option = $_POST["keaktifan_kuliah"];

    $nilai_ipk = $nilai_ipk_option; // Menggunakan nilai yang dipilih langsung

    $keaktifan_kuliah = $keaktifan_kuliah_option; // Menggunakan nilai yang dipilih langsung

    $connect = mysqli_connect("localhost", "root", "", "spk");
    $query = "INSERT INTO data_kriteria (id_mahasiswa, nim, prodi, jumlah_pendapatan_orangtua, nilai_ipk, jumlah_tanggungan, keaktifan_kuliah) 
              VALUES ('$id_mahasiswa', '$nim', '$prodi', '$nilai_pendapatan', '$nilai_ipk', '$jumlah_tanggungan', '$keaktifan_kuliah')";

if (mysqli_query($connect, $query)) {
    header("Location: kriteria.php");
    exit();
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($connect);
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Kriteria</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <style>
        .img-preview {
            max-width: 200px;
            max-height: 200px;
        }
        .disable-input {
            pointer-events: none;
        }
        section {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
<section>
    <div class="container" style="width:500px;">
        <h3 align="center">Tambah Data Kriteria</h3>
        <br />
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Mahasiswa</label>
                <select name="id_mahasiswa" id="id_mahasiswa" class="form-control" required>
                    <?php
                    $connect = mysqli_connect("localhost", "root", "", "spk");
                    $query = "SELECT id_mahasiswa, nama_mahasiswa FROM mahasiswa";
                    $result = mysqli_query($connect, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id_mahasiswa']}'>{$row['nama_mahasiswa']} </option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nim</label>
                <input type="text" name="nim" id="nim" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Prodi</label>
                <input type="text" name="prodi" id="prodi" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Jumlah Pendapatan Orangtua</label>
                <select name="jumlah_pendapatan_orangtua" id="jumlah_pendapatan_orangtua" class="form-control" required>
                    <option value="1">Rp. 550.000 > x ≤ Rp. 1.000.000</option>
                    <option value="2">Rp. 1.000.000 > x ≤ Rp. 1.500.000</option>
                    <option value="3">Rp. 1.500.000 > x ≤ Rp. 2.000.000</option>
                    <option value="4">Rp. 2.000.000 > x ≤ Rp. 2.500.000</option>
                    <option value="5">Rp. 2.500.000 > x ≤ Rp. 3.000.000</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nilai IPK</label>
                <select name="nilai_ipk" id="nilai_ipk" class="form-control" required>
                    <option value="1">Memuaskan (2,76 - 3,00)</option>
                    <option value="2">Sangat Memuaskan (3,01 - 3,50)</option>
                    <option value="3">Pujian (> 3,50)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Tanggungan</label>
                <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Keaktifan Kuliah</label>
                <select name="keaktifan_kuliah" id="keaktifan_kuliah" class="form-control" required>
                    <option value="5">Aktif</option>
                    <option value="4">Cukup</option>
                    <option value="3">Jarang</option>
                    <option value="2">Kurang</option>
                    <option value="1">Tidak Berpartisipasi</option>
                </select>
            </div>
            <div class="form-group">
                <input id="insert" type="submit" name="insert" value="Tambah" class="btn btn-success" />
            </div>
        </form>

        <div align="right">
            <a href="kriteria.php" class="btn btn-warning">Batal</a>
        </div>
        <br />
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#id_mahasiswa').change(function() {
            var id_mahasiswa = $(this).val();
            if (id_mahasiswa !== '') {
                $.ajax({
                    url: 'get_mahasiswa_data.php', // Ganti dengan URL yang sesuai
                    method: 'POST',
                    data: { id_mahasiswa: id_mahasiswa },
                    dataType: 'json',
                    success: function(data) {
    console.log(data); // Melihat data yang dikembalikan
    $('#nim').val(data.nim);
    $('#prodi').val(data.prodi);
}
                });
            }
        });
    });
</script>
</body>
</html>
