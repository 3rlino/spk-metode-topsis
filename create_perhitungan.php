<?php
$connect = mysqli_connect("localhost", "root", "", "spk");

$id_matrix = '';
$nim = '';
$jumlah_pendapatan_orangtua = '';
$nilai_ipk = '';
$jumlah_tanggungan = '';
$keaktifan_kuliah = '';
$hasil_perhitungan = '';

if (isset($_POST["id_matrix"])) {
    $id_matrix = $_POST["id_matrix"];

    $query_matrix = "SELECT * FROM matriks_keputusan WHERE id_matrix = '$id_matrix'";
    $result_matriks_keputusan = mysqli_query($connect, $query_matrix);

    if ($row_matriks_keputusan = mysqli_fetch_assoc($result_matriks_keputusan)) {
        $nim = $row_matriks_keputusan['nim'];
        $jumlah_pendapatan_orangtua = $row_matriks_keputusan['jumlah_pendapatan_orangtua'];
        $nilai_ipk = $row_matriks_keputusan['nilai_ipk'];
        $jumlah_tanggungan = $row_matriks_keputusan['jumlah_tanggungan'];
        $keaktifan_kuliah = $row_matriks_keputusan['keaktifan_kuliah'];
    }
}

if (isset($_POST["insert"])) {
    $id_matrix = $_POST["id_matrix"];
    $nim = $_POST["nim"];
    $jumlah_pendapatan_orangtua = $_POST["jumlah_pendapatan_orangtua"];
    $nilai_ipk = $_POST["nilai_ipk"];
    $jumlah_tanggungan = $_POST["jumlah_tanggungan"];
    $keaktifan_kuliah = $_POST["keaktifan_kuliah"];

    // Mengambil data kriteria dari database (misalnya, tabel kriteria)
    $query_kriteria = "SELECT * FROM data_kriteria";
    $result_kriteria = mysqli_query($connect, $query_kriteria);
    $kriteria = array();

    while ($row_kriteria = mysqli_fetch_assoc($result_kriteria)) {
        $kriteria[] = $row_kriteria;
    }

    $matriks_ternormalisasi_terbobot = array(
        array($jumlah_pendapatan_orangtua, $nilai_ipk, $jumlah_tanggungan, $keaktifan_kuliah),
    );

    // Menentukan solusi ideal positif dan negatif
    $solusi_ideal_positif = array();
    $solusi_ideal_negatif = array();

    for ($i = 0; $i < count($kriteria); $i++) {
        $kriteria_name = $kriteria[$i]['id_kriteria'];

        // Inisialisasi nilai solusi ideal positif dan negatif dengan nilai yang sesuai
        $solusi_ideal_positif[$i] = isset($matriks_ternormalisasi_terbobot[0][$kriteria_name])
            ? $matriks_ternormalisasi_terbobot[0][$kriteria_name]
            : 0;
        $solusi_ideal_negatif[$i] = isset($matriks_ternormalisasi_terbobot[0][$kriteria_name])
            ? $matriks_ternormalisasi_terbobot[0][$kriteria_name]
            : 0;

        // Cek dan perbarui nilai solusi ideal positif dan negatif
        for ($j = 0; $j < count($matriks_ternormalisasi_terbobot); $j++) {
            if (isset($matriks_ternormalisasi_terbobot[$j][$kriteria_name])) {
                $solusi_ideal_positif[$i] = max($solusi_ideal_positif[$i], $matriks_ternormalisasi_terbobot[$j][$kriteria_name]);
                $solusi_ideal_negatif[$i] = min($solusi_ideal_negatif[$i], $matriks_ternormalisasi_terbobot[$j][$kriteria_name]);
            }
        }
    }

    // Menghitung jarak antara nilai alternatif dengan solusi ideal positif dan negatif
    $jarak_positif = array();
    $jarak_negatif = array();

    for ($i = 0; $i < count($matriks_ternormalisasi_terbobot); $i++) {
        $jarak_positif[$i] = 0;
        $jarak_negatif[$i] = 0;

        for ($j = 0; $j < count($kriteria); $j++) {
            $kriteria_name = $kriteria[$j]['id_kriteria'];
            $jarak_positif[$i] += pow($matriks_ternormalisasi_terbobot[$i][$j] - $solusi_ideal_positif[$j], 2);
            $jarak_negatif[$i] += pow($matriks_ternormalisasi_terbobot[$i][$j] - $solusi_ideal_negatif[$j], 2);
        }

        $jarak_positif[$i] = sqrt($jarak_positif[$i]);
        $jarak_negatif[$i] = sqrt($jarak_negatif[$i]);
    }

    // Menentukan nilai preferensi untuk setiap alternatif
    $nilai_preferensi = array();

    for ($i = 0; $i < count($matriks_ternormalisasi_terbobot); $i++) {
        $nilai_preferensi[$i] = $jarak_negatif[$i] / ($jarak_positif[$i] + $jarak_negatif[$i]);
    }

    // Hitung hasil perhitungan berdasarkan perbandingan preferensi terhadap alternatif terbaik
    if (!empty($nilai_preferensi)) {
        $alternatif_terbaik = array_search(max($nilai_preferensi), $nilai_preferensi);

        $hasil_perhitungan = calculateResult($matriks_ternormalisasi_terbobot, $solusi_ideal_positif, $kriteria);

        // Masukkan data perhitungan ke database
        $query_insert = "INSERT INTO perhitungan (id_matrix, nim, jumlah_pendapatan_orangtua, nilai_ipk, jumlah_tanggungan, keaktifan_kuliah, hasil_perhitungan) 
        VALUES ('$id_matrix', '$nim', '$jumlah_pendapatan_orangtua', '$nilai_ipk', '$jumlah_tanggungan', '$keaktifan_kuliah', '$hasil_perhitungan')";

        echo "Query: $query_insert"; // Cetak query untuk tujuan debugging

        if (mysqli_query($connect, $query_insert)) {
            // Redirect ke halaman index.php jika penambahan data berhasil
            header("Location: perhitungan.php");
            exit();
        } else {
            // Redirect kembali ke halaman ini jika penambahan data gagal
            $error_message = "Error while inserting data: " . mysqli_error($connect);
            header("Location: create_perhitungan.php?error=" . urlencode($error_message));
            exit();
        }
    }
}

// Fungsi calculateResult
function calculateResult($matriks, $solusi_ideal_positif, $kriteria) {
    $hasil = 0;

    for ($j = 0; $j < count($kriteria); $j++) {
        $kriteria_name = $kriteria[$j]['id_kriteria'];
        $hasil += pow($matriks[0][$j] - $solusi_ideal_positif[$j], 2);
    }

    $hasil = sqrt($hasil);

    return $hasil;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Perhitungan Topsis</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<body>
    <div class="container" style="width:500px;">
        <h3 align="center">Tambah Data Perhitungan Topsis</h3>
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
                <label>Id Matrix</label>
                <select name="id_matrix" id="id_matrix" class="form-control" required>
                    <option value="">Pilih ID Matrix</option>
                    <?php
                    $query_matrix = "SELECT id_matrix FROM matriks_keputusan";
                    $result_matrix = mysqli_query($connect, $query_matrix);

                    while ($row_matrix = mysqli_fetch_assoc($result_matrix)) {
                        $selected = ($row_matrix['id_matrix'] == $id_matrix) ? "selected" : "";
                        echo "<option value='{$row_matrix['id_matrix']}' $selected>{$row_matrix['id_matrix']}</option>";
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
    <label>Hasil Perhitungan</label>
    <input type="text" name="hasil_perhitungan" id="hasil_perhitungan" class="form-control" required value="<?php echo $hasil_perhitungan; ?>">
</div>
<div class="form-group">
    <input id="insert" type="submit" name="insert" value="Tambah" class="btn btn-success" />
</div>
        </form>

        <div align="right">
            <a href="perhitungan.php" class="btn btn-warning">Batal</a>
        </div>
        <br />
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#id_matrix').change(function() {
            var id_matrix = $(this).val();
            if (id_matrix !== '') {
                $.ajax({
                    url: 'data_kriteria.php',
                    method: 'POST',
                    data: { id_matrix: id_matrix },
                    dataType: 'json',
                    success: function(data) {
                        $('#nim').val(data.nim);
                        $('#jumlah_pendapatan_orangtua').val(data.jumlah_pendapatan_orangtua);
                        $('#nilai_ipk').val(data.nilai_ipk);
                        $('#jumlah_tanggungan').val(data.jumlah_tanggungan);
                        $('#keaktifan_kuliah').val(data.keaktifan_kuliah);

                        // Hitung hasil perhitungan dan isi ke input
                        var hasil_perhitungan = calculateResult(data); // Ganti dengan fungsi perhitungan sesuai dengan kebutuhan Anda
                        $('#hasil_perhitungan').val(hasil_perhitungan);
                    }
                });
            }
        });
        function calculateResult(data) {
            var total = parseFloat(data.nim) +
                        parseFloat(data.jumlah_pendapatan_orangtua) +
                        parseFloat(data.nilai_ipk) +
                        parseFloat(data.jumlah_tanggungan) +
                        parseFloat(data.keaktifan_kuliah);

            return total.toFixed(2);
        }
    });
</script>
</body>
</html>


