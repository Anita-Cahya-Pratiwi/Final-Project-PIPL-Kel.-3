<?php
session_start();
$no_ruang_kib_session = isset($_GET['no_ruang_kib']) ? $_GET['no_ruang_kib'] : '';
$_SESSION['no_ruang_kib'] = $no_ruang_kib_session;
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
$no_ruang_kib       = "";
$unit_kelola        = "";
$sukses             = "";
$error              = "";

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'edit') {
    $no_ruang_kib = $no_ruang_kib_session;

    if ($no_ruang_kib == '') {
        $error = "Data tidak ditemukan";
    } else {
        $sql1 = "SELECT * FROM ruang_lab WHERE no_ruang_kib = '$no_ruang_kib'";
        $q1   = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $r1            = mysqli_fetch_array($q1);
            $no_ruang_kib    = $r1['no_ruang_kib'];
            $unit_kelola        = $r1['unit_kelola'];
        } else {
            $error = "Gagal mengambil data dari database";
        }
    }
}

if (isset($_POST['simpan'])) {
    $no_ruang_kib      = $_POST['no_ruang_kib'];
    $unit_kelola       = $_POST['unit_kelola'];

    if ($no_ruang_kib && $unit_kelola) {
        $sql1 = "UPDATE ruang_lab SET no_ruang_kib ='$no_ruang_kib', unit_kelola ='$unit_kelola' WHERE no_ruang_kib='$no_ruang_kib'";
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
        <span class="text">Edit Data Unit Kelola</span>
    </div>
<div class="main-content">
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Edit Data Unit Kelola
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
                    <form action="edit_ruang.php" method="POST">
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
