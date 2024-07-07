
<?php
// edit_data.php

// Cek apakah form telah disubmit
if (isset($_POST["update"])) {
    $id_kriteria = $_POST["id_kriteria"];
    $id_mahasiswa = $_POST["id_mahasiswa"];
    $nim = $_POST["nim"];
    $prodi = $_POST["prodi"];
    $jumlah_pendapatan_orangtua = $_POST["jumlah_pendapatan_orangtua"];
    $nilai_ipk = $_POST["nilai_ipk"];
    $jumlah_tanggungan = $_POST["jumlah_tanggungan"];
    $keaktifan_kuliah = $_POST["keaktifan_kuliah"];

    // Lakukan koneksi ke database
    $connect = mysqli_connect("localhost", "root", "", "spk");
    if ($connect === false) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Update data di database
    $query = "UPDATE data_kriteria SET id_mahasiswa='$id_mahasiswa', nim='$nim', prodi='$prodi', jumlah_pendapatan_orangtua='$jumlah_pendapatan_orangtua', nilai_ipk='$nilai_ipk', jumlah_tanggungan='$jumlah_tanggungan', keaktifan_kuliah='$keaktifan_kuliah' WHERE id_kriteria='$id_kriteria'";
    mysqli_query($connect, $query);

    // Tutup koneksi ke database
    mysqli_close($connect);

    // Redirect ke halaman lain setelah data berhasil diupdate
    header("Location: kriteria.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kriteria</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
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
                        $('#nim').val(data.nim);
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
            <h3 align="center">Edit Data Kriteria</h3>
            <br />
            <?php
            if (isset($_GET["id_kriteria"])) {
                $id_kriteria = $_GET["id_kriteria"];
                $connect = mysqli_connect("localhost", "root", "", "spk");
                if ($connect === false) {
                    die("Koneksi gagal: " . mysqli_connect_error());
                }

                $query = "SELECT * FROM data_kriteria WHERE id_kriteria = '$id_kriteria'";
                $result = mysqli_query($connect, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <form method="post">
                            <input type="hidden" name="id_kriteria" value="<?php echo $row['id_kriteria']; ?>">
                            <div class="form-group">
                                <label>Nama Mahasiswa</label>
                                <select name="id_mahasiswa" id="id_mahasiswa" class="form-control" required>
                                    <?php
                                    $query_mahasiswa = "SELECT id_mahasiswa, nama_mahasiswa FROM mahasiswa";
                                    $result_mahasiswa = mysqli_query($connect, $query_mahasiswa);
                                    while ($row_mahasiswa = mysqli_fetch_assoc($result_mahasiswa)) {
                                        $selected = ($row_mahasiswa['id_mahasiswa'] == $row['id_mahasiswa']) ? "selected" : "";
                                        echo "<option value='{$row_mahasiswa['id_mahasiswa']}' $selected>{$row_mahasiswa['nama_mahasiswa']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nim</label>
                                <input type="text" name="nim" id="nim" class="form-control" value="<?php echo $row['nim']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Prodi</label>
                                <input type="text" name="prodi" id="prodi" class="form-control" value="<?php echo $row['prodi']; ?>" required>
                            </div>
                            <div class="form-group">
                            <label>Jumlah Pendapatan Orangtua</label>
                        <select name="jumlah_pendapatan_orangtua" class="form-control" required>
                            <option value="1" <?php if ($row['jumlah_pendapatan_orangtua'] == 1) echo 'selected'; ?>>Rp. 550.000 > x ≤ Rp. 1.000.000</option>
                            <option value="2" <?php if ($row['jumlah_pendapatan_orangtua'] == 2) echo 'selected'; ?>>Rp. 1.000.000 > x ≤ Rp. 1.500.000</option>
                            <option value="3" <?php if ($row['jumlah_pendapatan_orangtua'] == 3) echo 'selected'; ?>>Rp. 1.500.000 > x ≤ Rp. 2.000.000</option>
                            <option value="4" <?php if ($row['jumlah_pendapatan_orangtua'] == 4) echo 'selected'; ?>>Rp. 2.000.000 > x ≤ Rp. 2.500.000</option>
                            <option value="5" <?php if ($row['jumlah_pendapatan_orangtua'] == 5) echo 'selected'; ?>>Rp. > 2.500.000</option>
                        </select>
                            </div>
                            <div class="form-group">
                                <label>Nilai IPK</label>
                                <select name="nilai_ipk" class="form-control" required>
                                    <option value="1" <?php if ($row['nilai_ipk'] == 1) echo 'selected'; ?>>Memuaskan (2,76 - 3,00)</option>
                                    <option value="2" <?php if ($row['nilai_ipk'] == 2) echo 'selected'; ?>>Sangat Memuaskan (3,01 - 3,50)</option>
                                    <option value="3" <?php if ($row['nilai_ipk'] == 3) echo 'selected'; ?>>Pujian (> 3,50)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Tanggungan</label>
                                <input type="text" name="jumlah_tanggungan" class="form-control" value="<?php echo $row['jumlah_tanggungan']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Keaktifan Kuliah</label>
                                <select name="keaktifan_kuliah" class="form-control" required>
                                    <option value="5" <?php if ($row['keaktifan_kuliah'] == 5) echo 'selected'; ?>>Aktif</option>
                                    <option value="4" <?php if ($row['keaktifan_kuliah'] == 4) echo 'selected'; ?>>Cukup</option>
                                    <option value="3" <?php if ($row['keaktifan_kuliah'] == 3) echo 'selected'; ?>>Jarang</option>
                                    <option value="2" <?php if ($row['keaktifan_kuliah'] == 2) echo 'selected'; ?>>Kurang</option>
                                    <option value="1" <?php if ($row['keaktifan_kuliah'] == 1) echo 'selected'; ?>>Tidak Berpartisipasi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="update" value="Update" class="btn btn-success" />
                            </div>
                        </form>
                        <div align="right">
                            <a href="kriteria.php" class="btn btn-warning">Batal</a>
                        </div>
                        <br />
                        <?php
                    }
                } else {
                    echo "<p>Tidak ada data mahasiswa dengan ID tersebut.</p>";
                }

                // Tutup koneksi ke database
                mysqli_close($connect);
            }

            // edit_data.php

        ?>
        </div>
    </section>
</body>
</html>
    <?php// Cek apakah form telah disubmit
    if (isset($_POST["update"])) {
        $id_kriteria = $_POST["id_kriteria"];
        $id_mahasiswa = $_POST["id_mahasiswa"];
        $nim = $_POST["nim"];
        $prodi = $_POST["prodi"];
        $jumlah_pendapatan_orangtua = $_POST["jumlah_pendapatan_orangtua"];
        $nilai_ipk = $_POST["nilai_ipk"];
        $jumlah_tanggungan = $_POST["jumlah_tanggungan"];
        $keaktifan_kuliah = $_POST["keaktifan_kuliah"];

        // Lakukan koneksi ke database
        $connect = mysqli_connect("localhost", "root", "", "spk");
        if ($connect === false) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }

        // Update data di database
        $query = "UPDATE data_kriteria SET id_mahasiswa='$id_mahasiswa', nim='$nim', prodi='$prodi', jumlah_pendapatan_orangtua='$jumlah_pendapatan_orangtua', nilai_ipk='$nilai_ipk', jumlah_tanggungan='$jumlah_tanggungan', keaktifan_kuliah='$keaktifan_kuliah' WHERE id_kriteria='$id_kriteria'";
        mysqli_query($connect, $query);

        // Tutup koneksi ke database
        mysqli_close($connect);

        // Redirect ke halaman lain setelah data berhasil diupdate
        header("Location: kriteria.php");
        exit();
    }
    ?>