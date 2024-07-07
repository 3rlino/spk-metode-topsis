<?php
$connect = mysqli_connect("localhost", "root", "", "spk");

$id_mahasiswa = '';
$nim = '';
$jumlah_pendapatan_orangtua = '';
$nilai_ipk = '';
$jumlah_tanggungan = '';
$keaktifan_kuliah = '';

if (isset($_POST["id_mahasiswa"])) {
    $id_mahasiswa = $_POST["id_mahasiswa"];
    
    $query_data_kriteria = "SELECT * FROM data_kriteria WHERE id_mahasiswa = '$id_mahasiswa'";
    $result_data_kriteria = mysqli_query($connect, $query_data_kriteria);
    
    if ($row_data_kriteria = mysqli_fetch_assoc($result_data_kriteria)) {
        $nim = $row_data_kriteria['nim'];
        $jumlah_pendapatan_orangtua = $row_data_kriteria['jumlah_pendapatan_orangtua'];
        $nilai_ipk = $row_data_kriteria['nilai_ipk'];
        $jumlah_tanggungan = $row_data_kriteria['jumlah_tanggungan'];
        $keaktifan_kuliah = $row_data_kriteria['keaktifan_kuliah'];
    }
}

if (isset($_POST["insert"])) {
    $id_mahasiswa = $_POST["id_mahasiswa"];
    $nim = $_POST["nim"];
    $jumlah_pendapatan_orangtua = $_POST["jumlah_pendapatan_orangtua"];
    $nilai_ipk = $_POST["nilai_ipk"];
    $jumlah_tanggungan = $_POST["jumlah_tanggungan"];
    $keaktifan_kuliah = $_POST["keaktifan_kuliah"];

    // Mengambil id_kriteria dari data_kriteria berdasarkan id_mahasiswa
    $query_get_id_kriteria = "SELECT id_kriteria FROM data_kriteria WHERE id_mahasiswa = '$id_mahasiswa'";
    $result_get_id_kriteria = mysqli_query($connect, $query_get_id_kriteria);

    if ($row_get_id_kriteria = mysqli_fetch_assoc($result_get_id_kriteria)) {
        $id_kriteria = $row_get_id_kriteria['id_kriteria'];
        
        // Simpan data ke database
        $query_insert = "INSERT INTO matriks_keputusan (id_kriteria, nim, jumlah_pendapatan_orangtua, nilai_ipk, jumlah_tanggungan, keaktifan_kuliah) 
                  VALUES ('$id_kriteria', '$nim', '$jumlah_pendapatan_orangtua', '$nilai_ipk', '$jumlah_tanggungan', '$keaktifan_kuliah')";

        if (mysqli_query($connect, $query_insert)) {
            // Redirect ke halaman index.php jika penambahan data berhasil
            header("Location: keputusan.php");
            exit();
        } else {
            // Redirect kembali ke halaman ini jika penambahan data gagal
            header("Location: create_keputusan.php?error=Error while inserting data");
            exit();
        }
    } else {
        // Redirect kembali ke halaman ini jika tidak ditemukan id_kriteria yang cocok
        header("Location: create_keputusan.php?error=Invalid id_mahasiswa");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Matriks Keputusan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<body>
    <div class="container" style="width:500px;">
        <h3 align="center">Tambah Data Matriks Keputusan</h3>
        <br />
         <!-- Tambahkan kode untuk menampilkan pesan error di sini -->
         <?php
        if (isset($_GET["error"])) {
            $error_message = urldecode($_GET["error"]);
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>
        <form id="form-matriks" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID Kriteria</label>
                <select name="id_mahasiswa" id="id_mahasiswa" class="form-control" required>
                    <option value="">Pilih ID Mahasiswa</option>
                    <?php
                    $query_mahasiswa = "SELECT id_mahasiswa FROM data_kriteria";
                    $result_mahasiswa = mysqli_query($connect, $query_mahasiswa);

                    while ($row_mahasiswa = mysqli_fetch_assoc($result_mahasiswa)) {
                        $selected = ($row_mahasiswa['nim'] == $id_mahasiswa) ? "selected" : "";
                        echo "<option value='{$row_mahasiswa['id_mahasiswa']}' $selected>{$row_mahasiswa['id_mahasiswa']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nim</label>
                <input type="text" id="nim" name="nim" class="form-control" required value="<?php echo $nim; ?>">
            </div>
            
            <div class="form-group">
                <label>Jumlah Pendapatan Orangtua</label>
                <input type="text" id="jumlah_pendapatan_orangtua" name="jumlah_pendapatan_orangtua" class="form-control" required value="<?php echo $jumlah_pendapatan_orangtua; ?>">
            </div>
            <div class="form-group">
                <label>Nilai Ipk</label>
                <input type="text" name="nilai_ipk" id="nilai_ipk" class="form-control" required value="<?php echo $nilai_ipk; ?>">
            </div>
            <div class="form-group">
                <label>Jumlah Tanggungan</label>
                <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="form-control" required value="<?php echo $jumlah_tanggungan; ?>">
            </div>
            <div class="form-group">
                <label>Keaktifan Kuliah</label>
                <input type="text" name="keaktifan_kuliah" id="keaktifan_kuliah" class="form-control" required value="<?php echo $keaktifan_kuliah; ?>">
            </div>
            <div class="form-group">
                <input id="insert" type="submit" name="insert" value="Tambah" class="btn btn-success" />
            </div>
        </form>

        <div align="right">
            <a href="keputusan.php" class="btn btn-warning">Batal</a>
        </div>
        <br />
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#id_mahasiswa').change(function() {
                var id_mahasiswa = $(this).val();
                if (id_mahasiswa !== '') {
                    $.ajax({
                        url: 'get_data_kriteria.php',
                        method: 'POST',
                        data: { id_mahasiswa: id_mahasiswa },
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
        });
    </script>
</body>
</html>
