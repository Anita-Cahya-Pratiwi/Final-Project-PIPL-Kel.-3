<?php
include 'link_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID and perform necessary validations
    $requestId = $_POST['id'];

    // Perform the approval logic, e.g., update the status in the database using a prepared statement
    $updateQuery = "UPDATE peminjaman_biasa SET status_peminjaman_biasa = 'Dipinjam' WHERE no_peminjaman_biasa = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($koneksi, $updateQuery);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $requestId);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($koneksi)]);
    }

    // Close the statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>