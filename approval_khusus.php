<?php
include 'link_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID and perform necessary validations
    $requestId = $_POST['id'];

    $updateQuery = "UPDATE peminjaman_khusus SET status_peminjaman_khusus = 'Dipinjam' WHERE no_peminjaman_khusus = ?";
    
    $stmt = mysqli_prepare($koneksi, $updateQuery);
    
    mysqli_stmt_bind_param($stmt, "i", $requestId);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($koneksi)]);
    }


    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>