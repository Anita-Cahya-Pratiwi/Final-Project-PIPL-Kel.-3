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

$no_barang          = "";
$tanggal_pemindahan = "";
$no_ruang_asal      = "";
$no_ruang_tujuan    = "";
$sukses             = "";
$error              = "";

if (isset($_POST['simpan'])) {
    $no_barang        = $_POST['no_barang'];
    $tanggal_pemindahan = $_POST['tanggal_pemindahan'];
    $no_ruang_asal      = $_POST['no_ruang_asal'];
    $no_ruang_tujuan    = $_POST['no_ruang_tujuan'];
   

    if ( $no_barang && $tanggal_pemindahan && $no_ruang_asal && $no_ruang_tujuan) {

        $sql1 = "INSERT INTO pemindahan (no_barang, tanggal_pemindahan, no_ruang_asal, no_ruang_tujuan) VALUES ( ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql1);

        mysqli_stmt_bind_param($stmt, 'ssss',$no_barang , $tanggal_pemindahan , $no_ruang_asal , $no_ruang_tujuan);

        $q1 = mysqli_stmt_execute($stmt);

        if ($q1) {
            $sukses = "Data tersimpan";
            header("refresh:5;url=kelola_pindah_barang.php");
        } else {
            $error = "Gagal menyimpan data. Error: " . mysqli_error($koneksi);
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
        <span class="text">Pemindahan Barang</span>
    </div>
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    Formulir Pemindahan Barang
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
                    <form action="pindah_barang.php" method="POST">
                    <div class="mb-3 row">
                        <label for="no_barang" class="col-sm-2 col-form-label">No. Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_barang" name="no_barang" value="<?php echo $no_barang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_pemindahan" class="col-sm-2 col-form-label">Tanggal Pemindahan</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_pemindahan" name="tanggal_pemindahan" value="<?php echo $tanggal_pemindahan?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_ruang_asal" class="col-sm-2 col-form-label">Ruang Asal</label>
                        <div class="col-sm-10">
                        <select class="form-control" name="no_ruang_asal" id="no_ruang_asal">
                            <option value="">- Pilih Ruang Asal -</option>
                            <option value="17" <?php if ($no_ruang_asal == "17") echo "selected"?>><?php echo "Ruang Server"; ?></option>
                            <option value="10" <?php if ($no_ruang_asal == "10") echo "selected" ?>><?php echo "Ruang Lab. T.I. 1"; ?></option>
                            <option value="11" <?php if ($no_ruang_asal == "11") echo "selected" ?>><?php echo "Ruang Lab. T.I. 2"; ?></option>
                            <option value="12" <?php if ($no_ruang_asal == "12") echo "selected" ?>><?php echo "Ruang Lab. T.I. 3"; ?></option>
                        </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_ruang_tujuan" class="col-sm-2 col-form-label">Ruang Tujuan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="no_ruang_tujuan" id="no_ruang_tujuan">
                                <option value="">- Pilih Ruang Tujuan -</option>
                                <option value="17" <?php if ($no_ruang_tujuan == "17") echo "selected"?>><?php echo "Ruang Server"; ?></option>
                                <option value="10" <?php if ($no_ruang_tujuan == "10") echo "selected" ?>><?php echo "Ruang Lab. T.I. 1"; ?></option>
                                <option value="11" <?php if ($no_ruang_tujuan == "11") echo "selected" ?>><?php echo "Ruang Lab. T.I. 2"; ?></option>
                                <option value="12" <?php if ($no_ruang_tujuan == "12") echo "selected" ?>><?php echo "Ruang Lab. T.I. 3"; ?></option>
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
