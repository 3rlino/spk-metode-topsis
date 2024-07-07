
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit();
}
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
                <a href="index.php" ><span class="las la-home"></span><span>Beranda</span></a>
            </li>
            <li>
                <a href="master.php" class="active"> <span class="las la-database"></span><span>Master Data</span></a>
            </li>
            <li>
                <a href="keputusan.php"><span class="las la-chart-bar"></span><span>Matriks Keputusan</span></a>
            </li>
            <li>
                <a href="perhitungan.php"> <span class="las la-calculator"></span><span>Perhitungan TOPSIS</span></a>
            </li>
            <li>
                <a href="laporan.php"><span class="las la-file-alt"></span></span><span>Hasil Topsis</span></a>
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
                Master Data
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
            <div class="cards">
                <div class="card-single">
                    <div>
                        <a href="mahasiswa.php" class="custom-btn">Lihat</a> 
                        <span>Data Mahasiswa</span>
                    </div>
                    <div>
                    <span class="las la-graduation-cap"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <a href="kriteria.php" class="custom-btn">Lihat</a> 
                        <span>Data Kriteria</span>
                    </div>
                    <div>
                    <span class="las la-list"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <a href="konversi.php"  class="custom-btn">Lihat</a> 
                        <span>Data Alternatif</span>
                    </div>
                    <div>
                    <span class="las la-exchange-alt"></span>
                    </div>
                </div>
            </div>
            <!-- <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>recent projects</h3>
                            <button>sea all <span class="las la-arrow-right"></span></button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>
                                            Project title
                                        </td>
                                        <td>
                                            Departement
                                        </td>
                                        <td>
                                            Status
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Fullstack web developer</td>
                                        <td>Frontend developer</td>
                                        <td>
                                            <span class="status purple"></span>
                                            in progress
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fullstack web developer</td>
                                        <td>Backend developer</td>
                                        <td>
                                            <span class="status pink"></span>
                                            pending
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fullstack web developer</td>
                                        <td>Frontend developer</td>
                                        <td>
                                            <span class="status orange"></span>
                                            in progress
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fullstack web developer</td>
                                        <td>Backend developer</td>
                                        <td>
                                            <span class="status purple"></span>
                                            pending
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fullstack web developer</td>
                                        <td>Frontend developer</td>
                                        <td>
                                            <span class="status pink"></span>
                                            in progress
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fullstack web developer</td>
                                        <td>Backend developer</td>
                                        <td>
                                            <span class="status orange"></span>
                                            pending
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="customers">
                    <div class="card">
                        <div class="card-header">
                            <h3>new customer</h3>
                            <button>sea all <span class="las la-arrow-right">

                                            </span>
                            </button>
                        </div>
                        <div class="card-body">
                        <div class="customer">
                           <div class="info">
                           <img src="img/5.jpg" width="40px" height="40px" alt="">
                            <div>
                                <h4>Robertus Ama Ritan</h4>
                                <small>Programmer</small>
                            </div>
                           </div>
                           <div class="contact">
                            <span class="las la-user-circle"></span>
                            <span class="las la-comment"></span>
                            <span class="las la-phone"></span>
                           </div>
                        </div>
                        <div class="customer">
                           <div class="info">
                           <img src="img/5.jpg" width="40px" height="40px" alt="">
                            <div>
                                <h4>Robertus Ama Ritan</h4>
                                <small>Programmer</small>
                            </div>
                           </div>
                           <div class="contact">
                            <span class="las la-user-circle"></span>
                            <span class="las la-comment"></span>
                            <span class="las la-phone"></span>
                           </div>
                        </div>
                        <div class="customer">
                           <div class="info">
                           <img src="img/5.jpg" width="40px" height="40px" alt="">
                            <div>
                                <h4>Robertus Ama Ritan</h4>
                                <small>Programmer</small>
                            </div>
                           </div>
                           <div class="contact">
                            <span class="las la-user-circle"></span>
                            <span class="las la-comment"></span>
                            <span class="las la-phone"></span>
                           </div>
                        </div>
                        <div class="customer">
                           <div class="info">
                           <img src="img/5.jpg" width="40px" height="40px" alt="">
                            <div>
                                <h4>Robertus Ama Ritan</h4>
                                <small>Programmer</small>
                            </div>
                           </div>
                           <div class="contact">
                            <span class="las la-user-circle"></span>
                            <span class="las la-comment"></span>
                            <span class="las la-phone"></span>
                           </div>
                        </div>
                        <div class="customer">
                           <div class="info">
                           <img src="img/5.jpg" width="40px" height="40px" alt="">
                            <div>
                                <h4>Robertus Ama Ritan</h4>
                                <small>Programmer</small>
                            </div>
                           </div>
                           <div class="contact">
                            <span class="las la-user-circle"></span>
                            <span class="las la-comment"></span>
                            <span class="las la-phone"></span>
                           </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </main>
    </div>
</body>
</html>