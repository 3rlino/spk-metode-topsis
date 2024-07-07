<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Matriks Keputusan</title>
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
            $('#id_kriteria').change(function() {
                var id_kriteria = $(this).val();
                if (id_kriteria !== '') {
                    $.ajax({
                        url: 'get_data_kriteria.php',
                        method: 'POST',
                        data: { id_kriteria: id_kriteria },
                        dataType: 'json',
                        success: function(data) {
                            $('#nim').val(data.nim);
                            $('#jumlah_pendapatan_orangtua').val(data.jumlah_pendapatan_orangtua);
                            $('#nilai_ipk').val(data.nilai_ipk);
                            $('#jumlah_tanggungan').val(data.jumlah_tanggungan);
                            $('#keaktifan_kuliah').val(data.keaktifan_kuliah);
                        }
                    });
                }
            });

            // Triggers initial change event when the page loads
            $('#id_kriteria').trigger('change');
        });
    </script>
</head>
<body>
    <section>
        <div class="container" style="width:500px;">
            <h3 align="center">Edit Data Matriks Keputusan</h3>
            <br />
            <?php
            if (isset($_GET["id_matrix"])) {
                $id_matrix = $_GET["id_matrix"];
                $connect = mysqli_connect("localhost", "root", "", "spk");
                if ($connect === false) {
                    die("Koneksi gagal: " . mysqli_connect_error());
                }

                $query = "SELECT * FROM matriks_keputusan WHERE id_matrix = '$id_matrix'";
                $result = mysqli_query($connect, $query);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
            ?>
            <form method="post">
                <input type="hidden" name="id_matrix" value="<?php echo $row['id_matrix']; ?>">
                <div class="form-group">
                    <label>Id Kriteria</label>
                    <select name="id_kriteria" id="id_kriteria" class="form-control" required>
                        <?php
                        $query_kriteria = "SELECT id_kriteria FROM data_kriteria";
                        $result_kriteria = mysqli_query($connect, $query_kriteria);

                        while ($row_kriteria = mysqli_fetch_assoc($result_kriteria)) {
                            $selected = ($row_kriteria['id_kriteria'] == $row['id_kriteria']) ? "selected" : "";
                            echo "<option value='{$row_kriteria['id_kriteria']}' $selected>{$row_kriteria['id_kriteria']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                <label>Nim</label>
                <input type="text" id="nim" name="nim" class="form-control" required value="<?php echo $row['nim']; ?>">
                </div>
            
                <div class="form-group">
                    <label>Jumlah Pendapatan Orangtua</label>
                    <input type="text" name="jumlah_pendapatan_orangtua" id="jumlah_pendapatan_orangtua" class="form-control" required value="<?php echo $row['jumlah_pendapatan_orangtua']; ?>">
                </div>
                <div class="form-group">
                    <label>Nilai Ipk</label>
                    <input type="text" name="nilai_ipk" id="nilai_ipk" class="form-control" required value="<?php echo $row['nilai_ipk']; ?>">
                </div>
                <div class="form-group">
                    <label>Jumlah Tanggungan</label>
                    <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="form-control" required value="<?php echo $row['jumlah_tanggungan']; ?>">
                </div>
                <div class="form-group">
                    <label>Keaktifan Kuliah</label>
                    <input type="text" name="keaktifan_kuliah" id="keaktifan_kuliah" class="form-control" required value="<?php echo $row['keaktifan_kuliah']; ?>">
                </div>
                <div class="form-group">
                    <input type="submit" name="update" value="Update" class="btn btn-success" />
                </div>
            </form>
            <div align="right">
                            <a href="keputusan.php" class="btn btn-warning">Batal</a>
                        </div>
            <?php
                } else {
                    echo "<p>Tidak ada data matriks keputusan dengan ID tersebut.</p>";
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
   
    $id_kriteria = $_POST["id_kriteria"];
    $jumlah_pendapatan_orangtua = $_POST["jumlah_pendapatan_orangtua"];
    $nilai_ipk = $_POST["nilai_ipk"];
    $jumlah_tanggungan = $_POST["jumlah_tanggungan"];
    $keaktifan_kuliah = $_POST["keaktifan_kuliah"];

    // Lakukan koneksi ke database
    $connect = mysqli_connect("localhost", "root", "", "spk");
    if ($connect === false) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Update data di database termasuk pembaruan gambar
    $query = "UPDATE matriks_keputusan SET id_kriteria='$id_kriteria', jumlah_pendapatan_orangtua='$jumlah_pendapatan_orangtua', nilai_ipk='$nilai_ipk', jumlah_tanggungan='$jumlah_tanggungan', keaktifan_kuliah='$keaktifan_kuliah' WHERE id_matrix='$id_matrix'";
    mysqli_query($connect, $query);

    // Tutup koneksi ke database
    mysqli_close($connect);

    // Redirect ke halaman lain setelah data berhasil diupdate
    header("Location: keputusan.php");
    exit();
}
?>
