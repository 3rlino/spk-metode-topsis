<?php
// create_data.php

if(isset($_POST["insert"])) {
    $id_perhitungan = $_POST["id_perhitungan"];
    $nim = $_POST["nim"];
    $hasil_perhitungan = $_POST["hasil_perhitungan"];

    $connect = mysqli_connect("localhost", "root", "", "spk");
    $query = "INSERT INTO hasil_topsis (id_perhitungan, nim, hasil_perhitungan) 
              VALUES ('$id_perhitungan', '$nim', '$hasil_perhitungan')";

if (mysqli_query($connect, $query)) {
    header("Location: laporan.php");
    exit();
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($connect);
           // Redirect kembali ke create-data.php jika penambahan data gagal
           header("Location: create_laporan.php");
           exit();
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Hasil Topsis</title>
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
        <h3 align="center">Tambah Data Hasil Topsis</h3>
        <br />
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID Perhitungan</label>
                <select name="id_perhitungan" id="id_perhitungan" class="form-control" required>
                    <?php
                    $connect = mysqli_connect("localhost", "root", "", "spk");
                    $query = "SELECT id_perhitungan FROM perhitungan";
                    $result = mysqli_query($connect, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id_perhitungan']}'>{$row['id_perhitungan']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nim</label>
                <input type="text" name="nim" id="nim" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Keterangan Nilai Topsis</label>
                <input type="text" name="hasil_perhitungan" id="hasil_perhitungan" class="form-control" required>
            </div>
            
            <div class="form-group">
                <input id="insert" type="submit" name="insert" value="Tambah" class="btn btn-success" />
            </div>
        </form>

        <div align="right">
            <a href="laporan.php" class="btn btn-warning">Batal</a>
        </div>
        <br />
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#id_perhitungan').change(function() {
            var id_perhitungan = $(this).val();
            if (id_perhitungan !== '') {
                $.ajax({
                    url: 'hasil_data.php', // Ganti dengan URL yang sesuai
                    method: 'POST',
                    data: { id_perhitungan: id_perhitungan },
                    dataType: 'json',
                    success: function(data) {
                        $('#nim').val(data.nim);
                        $('#hasil_perhitungan').val(data.hasil_perhitungan);
                    }
                });
            }
        });
    });
</script>
</body>
</html>

