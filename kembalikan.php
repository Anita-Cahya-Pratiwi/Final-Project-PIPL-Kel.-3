<?php
include 'link_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestId = $_POST['id'];


    $action = $_POST['action'];

    if ($action === 'approve') {
        $tanggal_pengembalian_biasa = $_POST['tanggal']; 
        $waktu_pengembalian_biasa = $_POST['waktu'];    
        $updateQuery = "UPDATE peminjaman_biasa SET status_peminjaman_biasa = 'Selesai', waktu_pengembalian_biasa = ?, tanggal_pengembalian_biasa = ? WHERE no_peminjaman_biasa = ?";

        $stmt = mysqli_prepare($koneksi, $updateQuery);

        mysqli_stmt_bind_param($stmt, "ssi", $waktu_pengembalian_biasa, $tanggal_pengembalian_biasa, $requestId);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error updating database: ' . mysqli_error($koneksi)]);
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($koneksi);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
