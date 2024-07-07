<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Konversi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
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
   <script>
    $(document).ready(function() {
        $('#nim').change(function() {
            var id_kriteria = $(this).val();
            if (id_kriteria !== '') {
                $.ajax({
                    url: 'get_kriteria.php',
                    method: 'POST',
                    data: { id_kriteria: id_kriteria },
                    dataType: 'json',
                    success: function(data) {
                        $('#nama_alternatif').val(data.nama_mahasiswa);
                        $('#prodi').val(data.prodi);
                    }
                });
            }
        });
    });
</script>
</head>
<body>
    <section>
        <div class="container" style="width:500px;">
            <h3 align="center">Edit Data Alternatif</h3>
            <br />
            <?php
            if (isset($_GET["id_konver"])) {
                $id_konver = $_GET["id_konver"];
                $connect = mysqli_connect("localhost", "root", "", "spk");
                if ($connect === false) {
                    die("Koneksi gagal: " . mysqli_connect_error());
                }

                $query = "SELECT * FROM data_konversi WHERE id_konver = '$id_konver'";
                $result = mysqli_query($connect, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <form method="post">
                            <input type="hidden" name="id_konver" value="<?php echo $row['id_konver']; ?>">
                           
                            <div class="form-group">
                                <label>ID Kriteria</label>
                                <select name="nim" id="nim" class="form-control" required>
                                    <option value="">Pilih Nim</option>
                                    <?php
                                    $queryKriteria = "SELECT id_kriteria, nim FROM data_kriteria";
                                    $resultKriteria = mysqli_query($connect, $queryKriteria);
                                    while ($rowKriteria = mysqli_fetch_assoc($resultKriteria)) {
                                        $selected = ($rowKriteria['id_kriteria'] == $selected_kriteria) ? 'selected' : '';
                                        echo "<option value='{$rowKriteria['id_kriteria']}' $selected>{$rowKriteria['nim']}</option>";
                                    }
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
                                <input type="text" name="nilai_alternatif" class="form-control" value="<?php echo $row['nilai_alternatif']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Bobot</label>
                                <input type="text" name="bobot" class="form-control" value="<?php echo $row['bobot']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="update" value="Update" class="btn btn-success" />
                            </div>
                        </form>
                        <div align="right">
                            <a href="konversi.php" class="btn btn-warning">Batal</a>
                        </div>
                        <br />
                        <?php
                    }
                } else {
                    echo "<p>Tidak ada data konversi dengan ID tersebut.</p>";
                }

                // Tutup koneksi ke database
                mysqli_close($connect);
            }
            ?>
        </div>
    </section>
</body>
</html>
<?php
// Cek apakah form telah disubmit
if (isset($_POST["update"])) {
    $id_konver = $_POST["id_konver"];
    $id_kriteria = $_POST["nim"]; // Perubahan disini, gunakan "nim" sebagai ID Kriteria
    $nama_alternatif = $_POST["nama_alternatif"];
    $prodi = $_POST["prodi"];
    $nilai_alternatif = $_POST["nilai_alternatif"];
    $bobot = $_POST["bobot"];

    // Lakukan koneksi ke database
    $connect = mysqli_connect("localhost", "root", "", "spk");
    if ($connect === false) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Update data di database
    $query = "UPDATE data_konversi SET id_kriteria='$id_kriteria', nama_alternatif='$nama_alternatif', prodi='$prodi', nilai_alternatif='$nilai_alternatif', bobot='$bobot' WHERE id_konver='$id_konver'";
    
    if (mysqli_query($connect, $query)) {
        // Jika update berhasil, redirect ke halaman lain
        mysqli_close($connect);
        header("Location: konversi.php");
        exit();
    } else {
        // Jika terjadi error pada query
        echo "Error: " . mysqli_error($connect);
    }

    // Tutup koneksi ke database
    mysqli_close($connect);
}
?>