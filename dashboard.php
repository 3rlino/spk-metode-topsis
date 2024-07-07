<?php
// Langkah 1: Buat koneksi ke database (Contoh koneksi dengan MySQLi)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spk";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Langkah 2: Ambil data mahasiswa dari database
$sql = "SELECT * FROM mahasiswa";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>SPK | UKT</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-ycbim"></span><span>SPK TOPSIS</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
            <li>
                <a href="index.php" class="active"><span class="las la-home"></span><span>Beranda</span></a>
            </li>
            <li>
                <a href="master.php"> <span class="las la-database"></span><span>Master Data</span></a>
            </li>
            <li>
                <a href="keputusan.php" ><span class="las la-chart-bar"></span><span>Matriks Keputusan</span></a>
            </li>
            <li>
                <a href="perhitungan.php"><span class="las la-calculator"></span><span>Perhitungan TOPSIS</span></a>
            </li>
            <li>
                <a href="laporan.php"><span class="las la-file-alt"></span><span>Hasil Topsis</span></a>
            </li>
            </ul>
        </div>
    </div>
    <div class="main-content">
        <header>
        <h2>
          
          <label for="nav-toggle">
              <span class="las la-bars">
                  
              </span>
          </label>
          Beranda
     </h2>
     <div class="search-wrapper">
      <span class="las la-search">
      </span>
      <input type="search" placeholder="search here..."/>
     </div>
     <div class="user-wrapper">
      <img src="img/5.jpg" height="40px" width="40px" alt="">
      <div>
          <h4>Bungsu</h4>
          <small>Super admin</small>
      </div>
     </div>
        </header>
        <main>
            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>Daftar Mahasiswa</h3>
                            <!-- <button>sea all <span class="las la-arrow-right"></span></button> -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>
                                            Nim
                                        </td>
                                        <td>
                                            Nama Mahasiswa
                                        </td>
                                        <td>
                                            Prodi
                                        </td>
                                        <td>
                                            Semester
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['nim']; ?></td>
                                        <td><?php echo $row['nama_mahasiswa']; ?></td>
                                        <td><?php echo $row['prodi']; ?></td>
                                        <td><?php echo $row['semester']; ?></td>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>Tidak ada data mahasiswa.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
