<?php
session_start();
include("link_db.php");

// Check if the user is logged in
if (!isset($_SESSION['level'])) {
    header("location: login.php?pesan=gagal");
    exit();
}

// Determine the header file based on the user's level
if ($_SESSION['level'] == "admin") {
    $headerFile = "inc_header_admin.php";
} else if ($_SESSION['level'] == "kalab") {
    $headerFile = "inc_header_kalab.php";
} else if ($_SESSION['level'] == "asistenlab") {
    $headerFile = "inc_header_asist.php";
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape user inputs to prevent SQL injection
    $no_internal = mysqli_real_escape_string($koneksi, $_POST['no_internal']);
    $tanggal_mutasi = mysqli_real_escape_string($koneksi, $_POST['tanggal_mutasi']);
    $jumlah_barang =  mysqli_real_escape_string($koneksi, $_POST['jumlah_barang']);
    $unit_mutasi = mysqli_real_escape_string($koneksi, $_POST['unit_mutasi']);
    $selectedAssets = isset($_POST['pilih']) ? $_POST['pilih'] : array();
    $id_pengelola = mysqli_real_escape_string($koneksi, $_POST['id_pengelola']);
    $id_penerima = mysqli_real_escape_string($koneksi, $_POST['id_penerima']);

    // Initialize an array to store insert queries
    $insertQuery = array(); 

    // Loop through selected assets and construct insert queries
    foreach ($selectedAssets as $selectedAsset) {
        $no_barang = mysqli_real_escape_string($koneksi, $selectedAsset);
        $query = "INSERT INTO mutasi_aset (no_internal, tanggal_mutasi, jumlah_barang, unit_mutasi, no_barang, id_pengelola, id_penerima)
                  VALUES ('$no_internal', '$tanggal_mutasi', '$jumlah_barang', '$unit_mutasi', '$no_barang', '$id_pengelola', '$id_penerima')";
        
        $insertQuery[] = $query; 
    }
    
    // Execute insert queries
    foreach ($insertQuery as $query) {
        if (!mysqli_query($koneksi, $query)) {
            die(mysqli_error($koneksi));
        }
    }
    
    // Output for debugging
    var_dump($_POST);
    var_dump($insertQuery);
    var_dump($selectedAssets);
}

$currentPage = 'kelola_mutasi';
include($headerFile);
//include('css.php');
?>
<?php
include("inc_footer.php");
?>
</body>
</html>
