<?php
session_start();
require('link_db.php');
if (!isset($_SESSION['level'])) {
    header("location: login.php?pesan=gagal");
    exit();
}

if ($_SESSION['level'] == "admin") {
    $headerFile = "inc_header_admin.php";
} else if ($_SESSION['level'] == "kalab") {
    $headerFile = "inc_header_kalab.php"; 
} else if ($_SESSION['level'] == "asistenlab") {
    $headerFile = "inc_header_asist.php"; 
}

$no_ruang_kib       = "";
$unit_kelola        = "";
$sukses             = "";
$error              = "";

if (isset($_POST['simpan'])) {

   
    if ( $no_ruang_kib && $unit_kelola) {
        $sql1 = "INSERT INTO ruang_lab (no_ruang_kib, unit_kelola) VALUES ( ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql1);
        mysqli_stmt_bind_param($stmt, 'ss',  $no_ruang_kib, $unit_kelola);
        $q1 = mysqli_stmt_execute($stmt);

        if ($q1) {
            $sukses = "Data unit kelola tersimpan";
            header("refresh:5;url=kelola_pindah_barang.php");
        } else {
            $error = "Gagal menyimpan data. Error: " . mysqli_error($koneksi);
            header("refresh:2;url=tambah_ruang.php");
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Harap isi semua data yang diperlukan.";
    }
}

$currentPage = 'kelola_pindah_barang';
include($headerFile);
?>
<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Tambah Data Ruang</span>
    </div>
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    Formulir Penambahan Unit Kelola
                </div>
                <?php if (!empty($sukses)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php elseif (!empty($error)):  ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo "Gagal menyimpan data, harap isi semua baris!"; ?>
                    </div>
                <?php endif; ?>

                <div class="card-body">
                    <form action="tambah_ruang.php" method="POST">
                        <div class="mb-3 row">
                            <label for="no_ruang_kib" class="col-sm-2 col-form-label">No. Ruang KIB</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="no_ruang_kib" name="no_ruang_kib" value="<?php echo $no_ruang_kib ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="unit_kelola" class="col-sm-2 col-form-label">Unit Kelola</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="unit_kelola" name="unit_kelola" value="<?php echo $unit_kelola ?>">
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
