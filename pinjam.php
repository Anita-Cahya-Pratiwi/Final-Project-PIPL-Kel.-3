<?php
session_start();
include 'link_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hariPeminjaman = $_POST['hari'];
    $tanggalPeminjaman = $_POST['tanggal'];
    $waktuPeminjaman = $_POST['waktu'];
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $noBarang = $_POST['barang'];
    $status_peminjaman_biasa = 'Dalam proses peminjaman'; 

    $action = $_POST['action'];

    if ($action === 'approve') {
        $insertQuery = "INSERT INTO peminjaman_biasa (hari, tanggal_peminjaman_biasa, waktu_peminjaman_biasa, id_penerima, no_barang, status_peminjaman_biasa) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($koneksi, $insertQuery);

        mysqli_stmt_bind_param($stmt, "ssssss", $hariPeminjaman, $tanggalPeminjaman, $waktuPeminjaman, $username, $noBarang ,$status_peminjaman_biasa);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error inserting into the database: ' . mysqli_error($koneksi)]);
        }

        mysqli_stmt_close($stmt);
    }

} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
