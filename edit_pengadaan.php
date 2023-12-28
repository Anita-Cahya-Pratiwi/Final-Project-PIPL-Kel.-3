<?php
session_start();
include('link_db.php');

$no_pengadaan_session = isset($_GET['no_pengadaan']) ? $_GET['no_pengadaan'] : '';

$no_pengadaan = "";
$no_surat_pengadaan = "";
$tanggal_pengadaan = "";
$tahun_pengadaan = "";
$jumlah_barang = "";
$satuan = "";
$keterangan_pengadaan = "";
$dokumen_scan = "";
$sukses = "";
$error = "";

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'edit1' && !empty($no_pengadaan_session)) {
    $no_pengadaan = $no_pengadaan_session;

    $sql1 = "SELECT * FROM pengadaan WHERE no_pengadaan = '$no_pengadaan'";
    $q1 = mysqli_query($koneksi, $sql1);

    if ($q1) {
        $r1 = mysqli_fetch_array($q1);
        $no_pengadaan = $r1['no_pengadaan'];
        $no_surat_pengadaan = $r1['no_surat_pengadaan'];
        $tanggal_pengadaan = $r1['tanggal_pengadaan'];
        $tahun_pengadaan = $r1['tahun_pengadaan'];
        $jumlah_barang = $r1['jumlah_barang'];
        $satuan = $r1['satuan'];
        $keterangan_pengadaan = $r1['keterangan_pengadaan'];
        $dokumen_scan = $r1['dokumen_scan'];
    } else {
        $error = "Gagal mengambil data dari database";
    }
}

if (isset($_POST['simpan'])) {
    $no_surat_pengadaan = $_POST['no_surat_pengadaan'];
    $tanggal_pengadaan = $_POST['tanggal_pengadaan'];
    $tahun_pengadaan = $_POST['tahun_pengadaan'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $satuan = $_POST['satuan'];
    $keterangan_pengadaan = $_POST['keterangan_pengadaan'];
    $dokumen_scan = $_POST['dokumen_scan'];

    if ( $no_surat_pengadaan && $tanggal_pengadaan && $tahun_pengadaan && $jumlah_barang && $satuan && $keterangan_pengadaan && $dokumen_scan) {
        $sql1 = "UPDATE pengadaan SET
                no_surat_pengadaan ='$no_surat_pengadaan',
                tanggal_pengadaan ='$tanggal_pengadaan',
                tahun_pengadaan ='$tahun_pengadaan',
                jumlah_barang ='$jumlah_barang',
                satuan ='$satuan',
                keterangan_pengadaan ='$keterangan_pengadaan',
                dokumen_scan ='$dokumen_scan'
                WHERE no_pengadaan='$no_pengadaan'";
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
include('inc_header_admin.php');
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Edit Data Pengadaan</span>
    </div>
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    Formulir Edit Pengadaan
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
                        <form action="" method="POST">
                            <div class="mb-3 row">
                                <label for="no_surat_pengadaan" class="col-sm-2 col-form-label">No. Surat Pengadaan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="no_surat_pengadaan" name="no_surat_pengadaan" value="<?php echo $no_surat_pengadaan ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tanggal_pengadaan" class="col-sm-2 col-form-label">Tanggal Pengadaan</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="tanggal_pengadaan" name="tanggal_pengadaan" value="<?php echo $tanggal_pengadaan ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tahun_pengadaan" class="col-sm-2 col-form-label">Tahun Pengadaan</label>
                                <div class="col-sm-10">
                                    <input type="year" class="form-control" id="tahun_pengadaan" name="tahun_pengadaan" value="<?php echo $tahun_pengadaan ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="jumlah_barang" class="col-sm-2 col-form-label">Jumlah Barang</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="jumlah_barang" name="jumlah_barang" value="<?php echo $jumlah_barang ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="satuan" name="satuan" value="<?php echo $satuan ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="keterangan_pengadaan" class="col-sm-2 col-form-label">Keterangan Pengadaan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="keterangan_pengadaan" name="keterangan_pengadaan" value="<?php echo $keterangan_pengadaan ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="dokumen_scan" class="col-sm-2 col-form-label">Dokumen Scan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="dokumen_scan" name="dokumen_scan" value="<?php echo $dokumen_scan ?>">
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
