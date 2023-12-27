<?php
include 'link_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestId = $_POST['id'];

    $action = $_POST['action'];

    if ($action === 'approve') {
        $tanggal_pengembalian_khusus = $_POST['tanggal'];  
        $updateQuery = "UPDATE peminjaman_khusus SET status_peminjaman_khusus = 'Selesai', tanggal_pengembalian_khusus = ? WHERE no_peminjaman_khusus = ?";

        $stmt = mysqli_prepare($koneksi, $updateQuery);

        mysqli_stmt_bind_param($stmt, "si", $tanggal_pengembalian_khusus, $requestId);


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
