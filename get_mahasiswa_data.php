<?php
$connect = mysqli_connect("localhost", "root", "", "spk");

if (isset($_POST["id_mahasiswa"])) {
    $id_mahasiswa = $_POST["id_mahasiswa"];

    $query = "SELECT nim, prodi FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'";
    $result = mysqli_query($connect, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $data = array(
            "nim" => $row["nim"],
            "prodi" => $row["prodi"]
        );
        echo json_encode($data);
    } else {
        echo json_encode(array("error" => "Mahasiswa not found"));
    }
} else {
    echo json_encode(array("error" => "Invalid request"));
}
?>