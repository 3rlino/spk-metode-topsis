<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
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
</head>
<body>
    <section>
        <div class="container" style="width:500px;">
            <h3 align="center">Edit Data Mahasiswa</h3>
            <br />
            <?php
            if (isset($_GET["id_mahasiswa"])) {
                $id_mahasiswa = $_GET["id_mahasiswa"];
                $connect = mysqli_connect("localhost", "root", "", "spk");
                if ($connect === false) {
                    die("Koneksi gagal: " . mysqli_connect_error());
                }

                $query = "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'";
                $result = mysqli_query($connect, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <form method="post">
                            <input type="hidden" name="id_mahasiswa" value="<?php echo $row['id_mahasiswa']; ?>">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama_mahasiswa" class="form-control" value="<?php echo $row['nama_mahasiswa']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Nim</label>
                                <input type="text" name="nim" class="form-control" value="<?php echo $row['nim']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Prodi</label>
                                <input type="text" name="prodi" class="form-control" value="<?php echo $row['prodi']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Semester</label>
                                <input type="text" name="semester" class="form-control" value="<?php echo $row['semester']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea type="text" name="alamat" class="form-control" required><?php echo $row['alamat']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan Orangtua</label>
                                <input type="text" name="pekerjaan_orangtua" class="form-control" value="<?php echo $row['pekerjaan_orangtua']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="update" value="Update" class="btn btn-success" />
                            </div>
                        </form>
                        <div align="right">
                            <a href="mahasiswa.php" class="btn btn-warning">Batal</a>
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
            ?>
        </div>
    </section>
</body>
</html>

<?php
// edit_data.php

// Cek apakah form telah disubmit
if (isset($_POST["update"])) {
    $id_mahasiswa = $_POST["id_mahasiswa"];
    $nama_mahasiswa = $_POST["nama_mahasiswa"];
    $nim = $_POST["nim"];
    $prodi = $_POST["prodi"];
    $semester = $_POST["semester"];
    $alamat = $_POST["alamat"];
    $pekerjaan_orangtua = $_POST["pekerjaan_orangtua"];

    // Lakukan koneksi ke database
    $connect = mysqli_connect("localhost", "root", "", "spk");
    if ($connect === false) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Update data di database termasuk pembaruan gambar
    $query = "UPDATE mahasiswa SET nama_mahasiswa='$nama_mahasiswa', nim='$nim', prodi='$prodi', semester='$semester', alamat='$alamat', pekerjaan_orangtua='$pekerjaan_orangtua' WHERE id_mahasiswa='$id_mahasiswa'";
    mysqli_query($connect, $query);

    // Tutup koneksi ke database
    mysqli_close($connect);

    // Redirect ke halaman lain setelah data berhasil diupdate
    header("Location: mahasiswa.php");
    exit();
}
?>
