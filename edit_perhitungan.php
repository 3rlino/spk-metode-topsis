<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Perhitungan Topsis</title>
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
            <h3 align="center">Edit Data Perhitungan Topsis</h3>
            <br />
            <?php
            $connect = mysqli_connect("localhost", "root", "", "spk");

            $id_perhitungan = '';
            $id_matrix = '';
            $nim = '';
            $jumlah_pendapatan_orangtua = '';
            $nilai_ipk = '';
            $jumlah_tanggungan = '';
            $keaktifan_kuliah = '';
            $hasil_perhitungan = '';

            if (isset($_GET["id_perhitungan"])) {
                $id_perhitungan = $_GET["id_perhitungan"];
                $query_perhitungan = "SELECT * FROM perhitungan WHERE id_perhitungan = '$id_perhitungan'";
                $result_perhitungan = mysqli_query($connect, $query_perhitungan);

                if ($row_perhitungan = mysqli_fetch_assoc($result_perhitungan)) {
                    $id_matrix = $row_perhitungan['id_matrix'];
                    $nim = $row_perhitungan['nim'];
                    $jumlah_pendapatan_orangtua = $row_perhitungan['jumlah_pendapatan_orangtua'];
                    $nilai_ipk = $row_perhitungan['nilai_ipk'];
                    $jumlah_tanggungan = $row_perhitungan['jumlah_tanggungan'];
                    $keaktifan_kuliah = $row_perhitungan['keaktifan_kuliah'];
                    $hasil_perhitungan = $row_perhitungan['hasil_perhitungan'];
                }
            }

            if (isset($_POST["update"])) {
                $id_matrix = $_POST["id_matrix"];
                $nim = $_POST["nim"];
                $jumlah_pendapatan_orangtua = $_POST["jumlah_pendapatan_orangtua"];
                $nilai_ipk = $_POST["nilai_ipk"];
                $jumlah_tanggungan = $_POST["jumlah_tanggungan"];
                $keaktifan_kuliah = $_POST["keaktifan_kuliah"];
                $hasil_perhitungan = calculateResult($jumlah_pendapatan_orangtua, $nilai_ipk, $jumlah_tanggungan, $keaktifan_kuliah);

                $query_update = "UPDATE perhitungan SET id_matrix='$id_matrix', jumlah_pendapatan_orangtua='$jumlah_pendapatan_orangtua', nilai_ipk='$nilai_ipk', jumlah_tanggungan='$jumlah_tanggungan', keaktifan_kuliah='$keaktifan_kuliah', hasil_perhitungan='$hasil_perhitungan' WHERE id_perhitungan='$id_perhitungan'";

                if (mysqli_query($connect, $query_update)) {
                    header("Location: perhitungan.php");
                    exit();
                } else {
                    echo "Error updating record: " . mysqli_error($connect);
                }
            }

            
            // Fungsi calculateResult
            function calculateResult($pendapatan, $ipk, $tanggungan, $keaktifan) {
                // Parameter bobot sesuai kebutuhan Anda
                $bobot_pendapatan = 0.3;
                $bobot_ipk = 0.3;
                $bobot_tanggungan = 0.2;
                $bobot_keaktifan = 0.2;

                // Ganti dengan rumus Topsis sesuai kebutuhan Anda
                $normalisasi_pendapatan = $pendapatan / sqrt(pow($pendapatan, 2) + pow($ipk, 2) + pow($tanggungan, 2) + pow($keaktifan, 2));
                $normalisasi_ipk = $ipk / sqrt(pow($pendapatan, 2) + pow($ipk, 2) + pow($tanggungan, 2) + pow($keaktifan, 2));
                $normalisasi_tanggungan = $tanggungan / sqrt(pow($pendapatan, 2) + pow($ipk, 2) + pow($tanggungan, 2) + pow($keaktifan, 2));
                $normalisasi_keaktifan = $keaktifan / sqrt(pow($pendapatan, 2) + pow($ipk, 2) + pow($tanggungan, 2) + pow($keaktifan, 2));

                // Bobot dan normalisasi
                $hasil_pendapatan = $normalisasi_pendapatan * $bobot_pendapatan;
                $hasil_ipk = $normalisasi_ipk * $bobot_ipk;
                $hasil_tanggungan = $normalisasi_tanggungan * $bobot_tanggungan;
                $hasil_keaktifan = $normalisasi_keaktifan * $bobot_keaktifan;

                // Hitung nilai topsis
                $hasil = sqrt(pow($hasil_pendapatan, 2) + pow($hasil_ipk, 2) + pow($hasil_tanggungan, 2) + pow($hasil_keaktifan, 2));

                return $hasil;
            }
            ?>
            
            <form method="post">
                <input type="hidden" name="id_perhitungan" value="<?php echo $id_perhitungan; ?>">
                <div class="form-group">
                    <label>Id Matriks</label>
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
                    <label>Jumlah Pendapatan Orangtua</label>
                    <input type="text" name="nim" class="form-control" value="<?php echo $nim; ?>" required>
                </div>
                <div class="form-group">
                    <label>Jumlah Pendapatan Orangtua</label>
                    <input type="text" name="jumlah_pendapatan_orangtua" class="form-control" value="<?php echo $jumlah_pendapatan_orangtua; ?>" required>
                </div>
                <div class="form-group">
                    <label>Nilai Ipk</label>
                    <input type="text" name="nilai_ipk" class="form-control" value="<?php echo $nilai_ipk; ?>"  required>
                </div>
                <div class="form-group">
                    <label>Jumlah Tanggungan</label>
                    <input type="text" name="jumlah_tanggungan" class="form-control" value="<?php echo $jumlah_tanggungan; ?>" required>
                </div>
                <div class="form-group">
                    <label>Keaktifan Kuliah</label>
                    <input type="text" name="keaktifan_kuliah" class="form-control" value="<?php echo $keaktifan_kuliah; ?>" required>
                </div>
                <div class="form-group">
                    <label>Hasil Perhitungan</label>
                    <input type="text" name="hasil_perhitungan" class="form-control" value="<?php echo $hasil_perhitungan; ?>" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="update" value="Update" class="btn btn-success" />
                </div>
            </form>
            <div align="right">
                <a href="perhitungan.php" class="btn btn-warning">Batal</a>
            </div>
            <br />
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#id_matrix").on("change", function () {
                var idMatrix = $(this).val();
                $.ajax({
                    url: "data_kriteria.php",
                    method: "POST",
                    data: { id_matrix: idMatrix },
                    dataType: "json",
                    success: function (data) {
                        $("input[name='nim']").val(data.nim);
                        $("input[name='jumlah_pendapatan_orangtua']").val(data.jumlah_pendapatan_orangtua);
                        $("input[name='nilai_ipk']").val(data.nilai_ipk);
                        $("input[name='jumlah_tanggungan']").val(data.jumlah_tanggungan);
                        $("input[name='keaktifan_kuliah']").val(data.keaktifan_kuliah);
                        $("input[name='hasil_perhitungan']").val(data.hasil_perhitungan);
                    }
                });
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
