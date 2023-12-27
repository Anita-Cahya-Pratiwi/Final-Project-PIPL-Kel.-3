<?php
session_start();
$no_barang_session = isset($_GET['no_barang']) ? $_GET['no_barang'] : '';
$_SESSION['no_barang'] = $no_barang_session;
require ('link_db.php');

//edit
$no_barang          = "";
$kode_bmn           = "";
$uraian_barang      = "";
$nup                = "";
$kode_internal      = "";
$fisik_barang       = "";
$spesifikasi        = "";
$sumber_anggaran    = "";
$sat                = "";
$nilai              = "";
$kondisi            = "";
$tercatat           = "";
$keterangan_barang  = "";
$no_ruang_kib       = "";
$gambar             = "";
$sukses             = "";
$error              = "";

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'edit') {
    $no_barang = $no_barang_session;

    if ($no_barang == '') {
        $error = "Data tidak ditemukan";
    } else {
        $sql1 = "SELECT * FROM barang WHERE no_barang = '$no_barang'";
        $q1   = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $r1            = mysqli_fetch_array($q1);
            $no_barang     = $r1['no_barang'];
            $kode_bmn      = $r1['kode_bmn'];
            $uraian_barang = $r1['uraian_barang'];
            $nup           = $r1['nup'];
            $kode_internal = $r1['kode_internal'];
            $fisik_barang  = $r1['fisik_barang'];
            $spesifikasi   = $r1['spesifikasi'];
            $sumber_anggaran = $r1['sumber_anggaran'];
            $sat           = $r1['sat'];
            $nilai         = $r1['nilai'];
            $kondisi       = $r1['kondisi'];
            $tercatat      = $r1['tercatat'];
            $keterangan_barang = $r1['keterangan_barang'];
            $no_ruang_kib = $r1['no_ruang_kib'];
            $gambar        = $r1['gambar'];
        } else {
            $error = "Gagal mengambil data dari database";
        }
    }
}

if (isset($_POST['simpan'])) {
    $no_barang = isset($_POST['no_barang']) ? $_POST['no_barang'] : '';
    $kode_bmn      = $_POST['kode_bmn'];
    $uraian_barang = $_POST['uraian_barang'];
    $nup           = $_POST['nup'];
    $kode_internal = $_POST['kode_internal'];
    $fisik_barang  = $_POST['fisik_barang'];
    $spesifikasi   = $_POST['spesifikasi'];
    $sumber_anggaran = $_POST['sumber_anggaran'];
    $sat           = $_POST['sat'];
    $nilai         = $_POST['nilai'];
    $kondisi       = $_POST['kondisi'];
    $tercatat      = $_POST['tercatat'];
    $keterangan_barang = $_POST['keterangan_barang'];
    $no_ruang_kib = $_POST['no_ruang_kib'] ;
    $gambar        = $_POST['gambar'];

    if ($no_barang && $kode_bmn && $uraian_barang && $nup && $kode_internal && $fisik_barang && $spesifikasi && $sumber_anggaran && $sat && $nilai && $kondisi && $tercatat && $keterangan_barang && $no_ruang_kib && $gambar) {
        $sql1 = "UPDATE barang SET no_barang ='$no_barang', kode_bmn='$kode_bmn', uraian_barang='$uraian_barang', nup='$nup', kode_internal='$kode_internal', fisik_barang='$fisik_barang', spesifikasi='$spesifikasi', sumber_anggaran='$sumber_anggaran', sat='$sat', nilai='$nilai', kondisi='$kondisi', tercatat='$tercatat', keterangan_barang='$keterangan_barang', no_ruang_kib='$no_ruang_kib', gambar='$gambar' WHERE no_barang='$no_barang'";
        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $sukses = "Data berhasil diupdate";
            header("refresh:3;url=kelola_data_barang.php");
        } else {
            $error = "Data gagal diupdate. Error: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Silakan masukkan semua data yang diperlukan";
    }
}         

$currentPage = 'kelola_data_barang';
include ('inc_header_admin.php');
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Edit Data Barang</span>
    </div>
<div class="main-content">
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Edit Data Barang
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
                <form action="edit_barang.php" method="POST">
                    <div class="mb-3 row">
                        <label for="no_barang" class="col-sm-2 col-form-label">No. Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_barang" name="no_barang" value="<?php echo $no_barang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kode_bmn" class="col-sm-2 col-form-label">Kode BMN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kode_bmn" name="kode_bmn" value="<?php echo htmlspecialchars($kode_bmn); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="uraian_barang" class="col-sm-2 col-form-label">Uraian Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="uraian_barang" name="uraian_barang" value="<?php echo $uraian_barang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nup" class="col-sm-2 col-form-label">NUP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nup" name="nup" value="<?php echo $nup ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kode_internal" class="col-sm-2 col-form-label">Kode Internal</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kode_internal" name="kode_internal" value="<?php echo $kode_internal ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fisik_barang" class="col-sm-2 col-form-label">Fisik Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fisik_barang" name="fisik_barang" value="<?php echo $fisik_barang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="spesifikasi" class="col-sm-2 col-form-label">Spesifikasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="spesifikasi" name="spesifikasi" value="<?php echo $spesifikasi ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="sumber_anggaran" class="col-sm-2 col-form-label">Sumber Anggaran</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="sumber_anggaran" name="sumber_anggaran" value="<?php echo $sumber_anggaran ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="sat" class="col-sm-2 col-form-label">SAT</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="sat" name="sat" value="<?php echo $sat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nilai" class="col-sm-2 col-form-label">Nilai</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nilai" name="nilai" value="<?php echo $nilai ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kondisi" class="col-sm-2 col-form-label">Kondisi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kondisi" name="kondisi" value="<?php echo $kondisi ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tercatat" class="col-sm-2 col-form-label">Tercatat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tercatat" name="tercatat" value="<?php echo $tercatat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="keterangan_barang" class="col-sm-2 col-form-label">Keterangan Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan_barang" name="keterangan_barang" value="<?php echo $keterangan_barang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_ruang_kib" class="col-sm-2 col-form-label">Unit Kelola</label>
                        <div class="col-sm-10">
                        <select class="form-control" name="no_ruang_kib" id="no_ruang_kib">
                            <option value="">- Pilih Unit Kelola -</option>
                            <option value="17" <?php if ($no_ruang_kib == "17") echo "selected"?>><?php echo "Ruang Server"; ?></option>
                            <option value="10" <?php if ($no_ruang_kib == "10") echo "selected" ?>><?php echo "Ruang Lab. T.I. 1"; ?></option>
                            <option value="11" <?php if ($no_ruang_kib == "11") echo "selected" ?>><?php echo "Ruang Lab. T.I. 2"; ?></option>
                            <option value="12" <?php if ($no_ruang_kib == "12") echo "selected" ?>><?php echo "Ruang Lab. T.I. 3"; ?></option>
                        </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="gambar" name="gambar" value="<?php echo $gambar ?>">
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
