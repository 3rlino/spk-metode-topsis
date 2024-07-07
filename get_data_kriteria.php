<?php
if (isset($_POST["id_mahasiswa"])) {
    $connect = mysqli_connect("localhost", "root", "", "spk");
    $id_mahasiswa = $_POST["id_mahasiswa"];
    
    $query_data_kriteria = "SELECT * FROM data_kriteria WHERE id_mahasiswa = '$id_mahasiswa'";
    $result_data_kriteria = mysqli_query($connect, $query_data_kriteria);
    $row_data_kriteria = mysqli_fetch_assoc($result_data_kriteria);
    
    echo json_encode($row_data_kriteria);
}
?>
