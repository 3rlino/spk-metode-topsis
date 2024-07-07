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
</head>
<body>
<section>
    <div class="container" style="width:500px;">
        <h3 align="center">Edit Data Hasil Topsis</h3>
        <br />
        <?php
        $connect = mysqli_connect("localhost", "root", "", "spk");

        $id_hasil_topsis = '';
        $id_perhitungan = '';
        $nim = '';
        $hasil_perhitungan = '';

        if (isset($_GET["id_hasil_topsis"])) {
            $id_hasil_topsis = $_GET["id_hasil_topsis"];
            $query_hasil = "SELECT * FROM hasil_topsis WHERE id_hasil_topsis = '$id_hasil_topsis'";
            $result_hasil = mysqli_query($connect, $query_hasil);

            if ($row_hasil = mysqli_fetch_assoc($result_hasil)) {
                $id_perhitungan = $row_hasil['id_perhitungan'];
                $nim = $row_hasil['nim'];
                $hasil_perhitungan = $row_hasil['hasil_perhitungan'];
            }
        }

        if (isset($_POST["update"])) {
            $id_perhitungan = $_POST["id_perhitungan"];
            $nim = $_POST["nim"];
            $hasil_perhitungan = $_POST["hasil_perhitungan"];

            $query_update = "UPDATE hasil_topsis SET id_perhitungan='$id_perhitungan', nim='$nim', hasil_perhitungan='$hasil_perhitungan' WHERE id_hasil_topsis='$id_hasil_topsis'";

            if (mysqli_query($connect, $query_update)) {
                header("Location: laporan.php");
                exit();
            } else {
                echo "Error updating record: " . mysqli_error($connect);
            }
        }
        ?>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_hasil_perhitungan" value="<?php echo $id_hasil_perhitungan; ?>">
            <div class="form-group">
                <label>ID Perhitungan</label>
                <select name="id_perhitungan" id="id_perhitungan" class="form-control" required>
                    <?php
                    $query = "SELECT id_perhitungan FROM perhitungan";
                    $result = mysqli_query($connect, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($row['id_perhitungan'] == $id_perhitungan) ? "selected" : "";
                        echo "<option value='{$row['id_perhitungan']}' $selected>{$row['id_perhitungan']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nim</label>
                <input type="text" name="nim" id="nim" class="form-control" value="<?php echo $nim; ?>" required>
            </div>
            <div class="form-group">
                <label>Keterangan Nilai Topsis</label>
                <input type="text" name="hasil_perhitungan" id="hasil_perhitungan" class="form-control" value="<?php echo $hasil_perhitungan; ?>" required>
            </div>
            
            <div class="form-group">
                <input id="update" type="submit" name="update" value="Update" class="btn btn-success" />
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

