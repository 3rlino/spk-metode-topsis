<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Karyawan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<style>
    section{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-ontent:center;
        }
</style>
</head>
<body>
<section>
    <div class="container" style="width:700px;">
        <h3 align="center">Detail Data Karyawan</h3>
        <br />
        <div class="table-responsive">
            <table class="table table-bordered">
                <?php
                if(isset($_GET["employee_id"]))
                {
                    $employee_id = $_GET["employee_id"];
                    $connect = mysqli_connect("localhost", "root", "", "input_karyawan");
                    $query = "SELECT * FROM absen WHERE id = '$employee_id'";
                    $result = mysqli_query($connect, $query);
                    while($row = mysqli_fetch_array($result))
                    {
                        echo '
                        <tr>
                            <td width="30%"><label>Latitude</label></td>  
                            <td width="70%">'.$row["latitude"].'</td>  
                        </tr>
                        <tr>
                            <td width="30%"><label>Longitude</label></td>  
                            <td width="70%">'.$row["longitude"].'</td>  
                        </tr>
                        <tr>
                            <td width="30%"><label>User</label></td>  
                            <td width="70%">'.$row["user"].'</td>  
                        </tr>
                        <tr>
                            <td width="30%"><label>Jenis Absen</label></td>  
                            <td width="70%">'.$row["jenis_absen"].'</td>  
                        </tr>
                        <tr>
                            <td width="30%"><label>Keterangan</label></td>  
                            <td width="70%">'.$row["keterangan"].'</td>  
                        </tr>
                        <tr>
                            <td width="30%"><label>Foto/Surat</label></td>  
                            <td width="70%"><img src="'.$row['foto_surat'].'" width="200px" class="img-thumbnail"></td>  
                        </tr>
                        ';
                    }
                }
                ?>
            </table>
        </div>
        
        <div align="right">
            <a href="index.php" class="btn btn-warning">Kembali</a>
        </div>
        <br />
    </div>
</section>
</body>
</html>
