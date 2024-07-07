<?php
if (isset($_POST["id_matrix"])) {
    $connect = mysqli_connect("localhost", "root", "", "spk");
    $id_matrix = $_POST["id_matrix"];  // Menggunakan variabel $id_matrix
    
    $query_data_kriteria = "SELECT * FROM matriks_keputusan WHERE id_matrix = '$id_matrix'";
    $result_data_kriteria = mysqli_query($connect, $query_data_kriteria);
    $row_data_kriteria = mysqli_fetch_assoc($result_data_kriteria);
    
    echo json_encode($row_data_kriteria);
}
?>