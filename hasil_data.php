<?php
$connect = mysqli_connect("localhost", "root", "", "spk");

if (isset($_POST["id_perhitungan"])) {
    $id_perhitungan = $_POST["id_perhitungan"];

    $query = "SELECT nim, hasil_perhitungan FROM perhitungan WHERE id_perhitungan = '$id_perhitungan'";
    $result = mysqli_query($connect, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $data = array(
            "nim" => $row["nim"],
            "hasil_perhitungan" => $row["hasil_perhitungan"]
        );
        echo json_encode($data);
    } else {
        echo json_encode(array("error" => "Hasil not found"));
    }
} else {
    echo json_encode(array("error" => "Invalid request"));
}
?>