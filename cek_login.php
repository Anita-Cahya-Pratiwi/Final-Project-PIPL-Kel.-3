<?php
session_start();

$koneksi = mysqli_connect("localhost", "root", "", "inventori_lab");//"3307");

// Check connection
if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    $query = "SELECT * FROM user WHERE username=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Verifikasi kata sandi
        if (md5($password_input) === $row['password']) {
            // Login berhasil
            $_SESSION['username'] = $username;
            $_SESSION['level'] = $row['level'];

            switch ($row['level']) {
                case "mahasiswa":
                    header("location:beranda_mahasiswa.php");
                    break;
                case "dosen":
                    header("location:beranda_dosen.php");
                    break;
                case "admin":
                    header("location:beranda_admin.php");
                    break;
                case "kalab":
                    header("location:beranda_kalab.php");
                    break;
                case "asistenlab":
                    header("location:beranda_asistenlab.php");
                    break;
                default:
                    header("location:login.php?pesan=gagal");
            }
        } else {
            // Password tidak sesuai
            header("location: login.php?pesan=gagal");
        }
    } else {
        // Pengguna tidak ditemukan atau ada kesalahan lain
        header("location: login.php?pesan=pengguna_tidak_ditemukan");
    }
}

?>
