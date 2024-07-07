
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit();
}
?>

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
$sql = "SELECT * FROM matriks_keputusan";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>SPK | UKT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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
                <a href="index.php"><span class="las la-home"></span><span>Beranda</span></a>
            </li>
            <li>
                <a href="master.php"> <span class="las la-database"></span><span>Master Data</span></a>
            </li>
            <li>
                <a href="keputusan.php" class="active"><span class="las la-chart-bar"></span><span>Matriks Keputusan</span></a>
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
                Matriks Keputusan
           </h2>
           <div class="search-wrapper">
            <span class="las la-search">
            </span>
            <input type="search" placeholder="search here..."/>
           </div>
           <div class="user-wrapper">
            <?php
            if (isset($_SESSION['id_user'])) {
                echo '<img src="img/5.jpg" height="40px" width="40px" alt="">
                    <div>
                        <h4>Hi, Bungsu</h4>
                        <a href="logout.php" style="cursor: pointer;"><small>Logout</small></a>
                    </div>';
            }
            ?>
            </div>
        </header>
        <main>
            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                        <h3>Matriks Keputusan</h3>
                        <button onclick="location.href='create_keputusan.php'"  style="cursor: pointer;">Tambah</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                         <td>
                                           Id kriteria
                                        </td>
                                        <td>
                                           Nim
                                        </td>
                                        <td>
                                            Jmlh Pendapatan Ortu
                                        </td>
                                        <td>
                                            Nilai Ipk
                                        </td>
                                        <td>
                                            Jumlah Tanggungan
                                        </td>
                                        <td>
                                            Keaktifan Kuliah
                                        </td>
                                        <td>
                                            Aksi
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row["id_kriteria"]; ?></td>
                                            <td><?php echo $row["nim"]; ?></td>
                                            <td><?php echo $row["jumlah_pendapatan_orangtua"]; ?></td>
                                            <td><?php echo $row["nilai_ipk"]; ?></td>
                                            <td><?php echo $row["jumlah_tanggungan"]; ?></td>
                                            <td><?php echo $row["keaktifan_kuliah"]; ?></td>
                                            <td>
                                                <!-- Tambahkan aksi sesuai kebutuhan, misalnya tombol edit, hapus, dll -->
                                                <a href="edit_keputusan.php?id_matrix=<?php echo $row["id_matrix"]; ?>"><span title="Edit" style="font-size: 24px; color: orange;">
                                                                                                                <i class="fas fa-edit"></i>
                                                                                                            </span></a> &nbsp; &nbsp;
                                                <a href="delete_keputusan.php?id_matrix=<?php echo $row["id_matrix"]; ?>"><span title="Hapus" style="font-size: 24px; color: red;">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Tidak ada data mahasiswa.</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>

                            <?php
                            // Tutup koneksi ke database
                            $conn->close();
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>