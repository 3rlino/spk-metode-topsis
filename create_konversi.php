<?php
if (isset($_POST["insert"])) {
    $nim = $_POST["nim"];
    $nama_alternatif = $_POST["nama_alternatif"];
    $prodi = $_POST["prodi"];
    $nilai_alternatif = $_POST["nilai_alternatif"];
    $bobot = $_POST["bobot"];

    $connect = mysqli_connect("localhost", "root", "", "spk");
    if (!$connect) {
        die(header("Location: create_konversi.php?error=connection"));
    }

    // Query untuk mendapatkan id_kriteria berdasarkan nim
    $queryGetId = "SELECT id_kriteria FROM data_kriteria WHERE nim = '$nim'";
    $resultGetId = mysqli_query($connect, $queryGetId);

    if (!$resultGetId) {
        die(header("Location: create_konversi.php?error=query&message=" . urlencode("Error: " . mysqli_error($connect))));
    }

    $row = mysqli_fetch_assoc($resultGetId);
    $id_kriteria = $row['id_kriteria'];

    // Query untuk memasukkan data ke tabel data_konversi
    $queryInsert = "INSERT INTO data_konversi (id_kriteria, nama_alternatif, prodi, nilai_alternatif, bobot) 
                    VALUES ('$id_kriteria', '$nama_alternatif', '$prodi', '$nilai_alternatif', '$bobot')";

    if (!mysqli_query($connect, $queryInsert)) {
        // Redirect back to the form page with detailed error message
        header("Location: create_konversi.php?error=insertion&message=" . urlencode("Terjadi kesalahan saat menyimpan data: " . mysqli_error($connect)));
        exit();
    }

    // Jika berhasil, redirect ke halaman konversi.php
    header("Location: konversi.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Konversi</title>
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
        <h3 align="center">Tambah Data Alternatif</h3>
        <br />
        <?php
        if (isset($_GET['error']) && $_GET['error'] === 'insertion') {
            echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menyimpan data. Silakan coba lagi.</div>';
        }
        ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nim</label>
                <select name="nim" id="nim" class="form-control" required>
                    <option value="">Pilih Nim</option>
                    <?php
                    $connect = mysqli_connect("localhost", "root", "", "spk");
                    if (!$connect) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $query = "SELECT id_kriteria, nim FROM data_kriteria";
                    $result = mysqli_query($connect, $query);
                    if (!$result) {
                        die("Query failed: " . mysqli_error($connect));
                    }
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['nim']}'>{$row['nim']}</option>";
                    }
                    mysqli_close($connect);
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Alternatif</label>
                <input type="text" id="nama_alternatif" name="nama_alternatif" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Prodi</label>
                <input type="text" id="prodi" name="prodi" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nilai Alternatif</label>
                <input type="text" id="nilai_alternatif" name="nilai_alternatif" class="form-control" value="1" required readonly>
            </div>
            <div class="form-group">
                <label>Bobot</label>
                <input type="text" name="bobot" id="bobot" class="form-control" value="1" required readonly>
            </div>
            <div class="form-group">
                <input id="insert" type="submit" name="insert" value="Tambah" class="btn btn-success" />
            </div>
        </form>

        <div align="right">
            <a href="konversi.php" class="btn btn-warning">Batal</a>
        </div>
        <br />
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nim').change(function() {
            var nim = $(this).val();
            if (nim !== '') {
                $.ajax({
                    url: 'data.php', // Ganti dengan URL yang sesuai
                    method: 'POST',
                    data: { nim: nim },
                    dataType: 'json',
                    success: function(data) {
                        $('#nama_alternatif').val(data.nama_mahasiswa);
                        $('#prodi').val(data.prodi);
                        // Perform TOPSIS calculations and populate Nilai Alternatif and Bobot fields
                        // var nilaiKriteria = parseFloat(data.nilai_kriteria);
                        // var bobotKriteria = parseFloat(data.bobot_kriteria);
                        // var hasilTopsis = nilaiKriteria * bobotKriteria;
                        // $('#nilai_alternatif').val(hasilTopsis.toFixed(2));
                        // $('#bobot').val(bobotKriteria.toFixed(2));
                    }
                });
            }
        });
    });
</script>
</body>
</html>
