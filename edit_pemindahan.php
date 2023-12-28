<?php
session_start();
$no_pemindahan_session = isset($_GET['no_pemindahan']) ? $_GET['no_pemindahan'] : '';
$_SESSION['no_pemindahan'] = $no_pemindahan_session;
require ('link_db.php');

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

//edit
$no_pemindahan      = "";
$no_barang          = "";
$tanggal_pemindahan = "";
$no_ruang_asal      = "";
$no_ruang_tujuan    = "";
$sukses             = "";
$error              = "";

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'edit') {
    $no_pemindahan = $no_pemindahan_session;

    if ($no_pemindahan == '') {
        $error = "Data tidak ditemukan";
    } else {
        $sql1 = "SELECT * FROM pemindahan WHERE no_pemindahan = '$no_pemindahan'";
        $q1   = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $r1            = mysqli_fetch_array($q1);
            $no_pemindahan    = $r1['no_pemindahan'];
            $no_barang        = $r1['no_barang'];
            $tanggal_pemindahan = $r1['tanggal_pemindahan'];
            $no_ruang_asal      = $r1['no_ruang_asal'];
            $no_ruang_tujuan    = $r1['no_ruang_tujuan'];
        } else {
            $error = "Gagal mengambil data dari database";
        }
    }
}

if (isset($_POST['simpan'])) {
    $no_pemindahan    = $_POST['no_pemindahan'];
    $no_barang        = $_POST['no_barang'];
    $tanggal_pemindahan = $_POST['tanggal_pemindahan'];
    $no_ruang_asal      = $_POST['no_ruang_asal'];
    $no_ruang_tujuan    = $_POST['no_ruang_tujuan'];

    if ($no_pemindahan && $no_barang && $tanggal_pemindahan && $no_ruang_asal && $no_ruang_tujuan) {
        $sql1 = "UPDATE pemindahan SET no_pemindahan ='$no_pemindahan', no_barang ='$no_barang', tanggal_pemindahan='$tanggal_pemindahan', no_ruang_asal ='$no_ruang_asal', no_ruang_tujuan='$no_ruang_tujuan' WHERE no_pemindahan='$no_pemindahan'";
        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $sukses = "Data berhasil diupdate";
            header("refresh:3;url=kelola_pindah_barang.php");
        } else {
            $error = "Data gagal diupdate. Error: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Silakan masukkan semua data yang diperlukan";
    }
}         

$currentPage = 'kelola_pindah_barang';
include($headerFile);
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Edit Pemindahan Barang</span>
    </div>
<div class="main-content">
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Edit Pemindahan Barang
            </div>
            <?php if ($sukses): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $sukses; ?>
            </div>
            <?php elseif ($error): ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <div class="card-body">
                    <form action="edit_pemindahan.php" method="POST">
                    <div class="mb-3 row">
                        <label for="no_pemindahan" class="col-sm-2 col-form-label">No Pemindahan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_pemindahan" name="no_pemindahan" value="<?php echo $no_pemindahan ?>">
                        </div>
                    </div>
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
