<?php
session_start();
require ('link_db.php');

if (!isset($_SESSION['level'])) {
    header("location: login.php?pesan=gagal");
    exit();
}

if ($_SESSION['level'] == "kalab") {
    $headerFile = "inc_header_kalab.php"; 
} else if ($_SESSION['level'] == "asistenlab") {
    $headerFile = "inc_header_asist.php"; 
}

$tanggal_perbaikan       = "";
$no_barang               = "";
$keterangan_perbaikan    = "";
$status_perbaikan        = "";
$sukses                  = "";
$error                   = "";

if (isset($_POST['simpan'])) {
    // Perbaikan 
    $tanggal_perbaikan       = $_POST['tanggal_perbaikan'];
    $no_barang               = $_POST['no_barang'];
    $keterangan_perbaikan    = $_POST['keterangan_perbaikan'];
    $status_perbaikan        = $_POST['status_perbaikan'];

    if ( $tanggal_perbaikan && $no_barang && $keterangan_perbaikan && $status_perbaikan) {
        $sql1 = "INSERT INTO perbaikan ( tanggal_perbaikan, no_barang, keterangan_perbaikan, status_perbaikan) VALUES ( ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql1);
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'ssss', $tanggal_perbaikan, $no_barang, $keterangan_perbaikan, $status_perbaikan);
        
        // Execute statement
        $q1 = mysqli_stmt_execute($stmt);
        
        // Check for success or failure
        if ($q1) {
           $sukses = "Data berhasil ditambahkan";
           header("refresh:3;url=kelola_perbaikan.php");
        } else {
           $error = "Gagal mengirim formulir, harap isi semua baris. Error: " . mysqli_error($koneksi);
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
}


$currentPage = 'kelola_perbaikan';
include($headerFile);
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Tambah Perbaikan Barang</span>
    </div>
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    Formulir Perbaikan Barang
                </div>
                <?php if (!empty($sukses)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php elseif (!empty($error)):  ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo "Gagal menyimpan data, harap isi dengan semua baris!";?>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <form action="tambah_perbaikan.php" method="POST">
                        <div class="mb-3 row">
                            <label for="tanggal_perbaikan" class="col-sm-2 col-form-label">Tanggal Perbaikan</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="tanggal_perbaikan" name="tanggal_perbaikan" value="<?php echo $tanggal_perbaikan ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="no_barang" class="col-sm-2 col-form-label">No. Barang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="no_barang" name="no_barang" value="<?php echo $no_barang ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="keterangan_perbaikan" class="col-sm-2 col-form-label">Keterangan Perbaikan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="keterangan_perbaikan" name="keterangan_perbaikan" value="<?php echo $keterangan_perbaikan ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                        <label for="status_perbaikan" class="col-sm-2 col-form-label">Status Perbaikan</label>
                        <div class="col-sm-10">
                        <select class="form-control" name="status_perbaikan" id="status_perbaikan">
                            <option value="Dalam Perbaikan" selected>Dalam Perbaikan</option>
                        </select>
                        </div>
                    </div>
                        <div class="col-12">
                            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include("inc_footer.php");
?>
</body>
</html>
