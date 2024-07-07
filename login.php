<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan koneksi ke database (ganti dengan informasi Anda)
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'spk';

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mencari user berdasarkan username
    $query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    
        if ($password === $user['password']) {
            // Login berhasil, set sesi user_id
            $_SESSION['id_user'] = $user['id_user'];
            header("Location: index.php"); // Ganti dengan halaman setelah login
            exit();
        } else {
            $_SESSION['error'] = 'Username atau password salah';
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = 'Username atau password salah';
        header("Location: index.php");
        exit();
    }

    $conn->close();
}
?>
