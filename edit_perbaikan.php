<?php
session_start();
$no_perbaikan_session = isset($_GET['no_perbaikan']) ? $_GET['no_perbaikan'] : '';
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

// Edit
$no_perbaikan = "";
$tanggal_perbaikan = "";
$no_barang = "";
$keterangan_perbaikan = "";
$status_perbaikan = "";
$tanggal_perbaikan_selesai = "";
$sukses = "";
$error = "";

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'edit' && !empty($no_perbaikan_session)) {
    $no_perbaikan = $no_perbaikan_session;

    $sql1 = "SELECT * FROM perbaikan WHERE no_perbaikan = '$no_perbaikan'";
    $q1 = mysqli_query($koneksi, $sql1);

    if ($q1) {
        $r1 = mysqli_fetch_array($q1);
        $no_perbaikan = $r1['no_perbaikan'];
        $tanggal_perbaikan = $r1['tanggal_perbaikan'];
        $no_barang = $r1['no_barang'];
        $keterangan_perbaikan = $r1['keterangan_perbaikan'];
        $status_perbaikan = $r1['status_perbaikan'];
        $tanggal_perbaikan_selesai = $r1['tanggal_perbaikan_selesai'];
    } else {
        $error = "Gagal mengambil data dari database";
    }
}

if (isset($_POST['simpan'])) {
    $tanggal_perbaikan = $_POST['tanggal_perbaikan'];
    $no_barang = $_POST['no_barang'];
    $keterangan_perbaikan = $_POST['keterangan_perbaikan'];
    $status_perbaikan = $_POST['status_perbaikan'];
    $tanggal_perbaikan_selesai = $_POST['tanggal_perbaikan_selesai'];

    if ($tanggal_perbaikan && $no_barang && $keterangan_perbaikan && $status_perbaikan && $tanggal_perbaikan_selesai) {
        $sql1 = "UPDATE perbaikan SET
                tanggal_perbaikan ='$tanggal_perbaikan',
                no_barang ='$no_barang',
                keterangan_perbaikan ='$keterangan_perbaikan',
                status_perbaikan ='$status_perbaikan',
                tanggal_perbaikan_selesai ='$tanggal_perbaikan_selesai'
                WHERE no_perbaikan='$no_perbaikan'";
        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $sukses = "Data berhasil diupdate";
            header("refresh:3;url=kelola_perbaikan.php");
        } else {
            $error = "Data gagal diupdate. Error: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Silakan masukkan semua data yang diperlukan";
    }
}

$currentPage = 'kelola_perbaikan';
include($headerFile);
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Edit Pemindahan Ruang</span>
    </div>
<div class="main-content">
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Edit Pemindahan Ruang
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
                            <option value="">- Keterangan -</option>
                            <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                            <option value="Selesai">Selesai</option>
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
