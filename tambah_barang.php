<?php
session_start();
require ('link_db.php');

$no_surat_pengadaan = "";
$tanggal_pengadaan  = "";
$tahun_pengadaan    = "";
$jumlah_barang      = "";
$satuan             = "";
$keterangan_pengadaan = "";
$dokumen_scan       = "";
$sukses             = "";
$error              = "";

if (isset($_POST['simpan'])) {
    // Pengadaan 
    $no_surat_pengadaan = $_POST['no_surat_pengadaan'];
    $tanggal_pengadaan  = $_POST['tanggal_pengadaan'];
    $tahun_pengadaan    = $_POST['tahun_pengadaan'];
    $jumlah_barang      = $_POST['jumlah_barang'];
    $satuan             = $_POST['satuan'];
    $keterangan_pengadaan = $_POST['keterangan_pengadaan'];
    $dokumen_scan       = $_POST['dokumen_scan'];

    if ($no_surat_pengadaan && $tanggal_pengadaan && $tahun_pengadaan && $jumlah_barang && $satuan && $keterangan_pengadaan && $dokumen_scan) {
        $sql1 = "INSERT INTO pengadaan (no_surat_pengadaan, tanggal_pengadaan, tahun_pengadaan, jumlah_barang, satuan, keterangan_pengadaan, dokumen_scan) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql1);
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'sssssss', $no_surat_pengadaan, $tanggal_pengadaan, $tahun_pengadaan, $jumlah_barang, $satuan, $keterangan_pengadaan, $dokumen_scan);
        
        // Execute statement
        $q1 = mysqli_stmt_execute($stmt);
        
        // Check for success or failure
        if ($q1) {
           $sukses = "Data tersimpan, menunggu formulir berikutnya...";
           header("refresh:5;url=tambah_barang2.php");
        } else {
           $error = "Gagal mengirim formulir, harap isi semua baris. Error: " . mysqli_error($koneksi);
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
}
$currentPage = 'kelola_data_barang';
include ('inc_header_admin.php');
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Tambah Data Barang</span>
    </div>
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    Formulir Pengadaan Barang
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
                    <form action="tambah_barang.php" method="POST">
                        <div class="mb-3 row">
                            <label for="no_surat_pengadaan" class="col-sm-2 col-form-label">No. Surat Pengadaan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="no_surat_pengadaan" name="no_surat_pengadaan" value="<?php echo $no_surat_pengadaan ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tanggal_pengadaan" class="col-sm-2 col-form-label">Tanggal Pengadaan</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="tanggal_pengadaan" name="tanggal_pengadaan" placeholder="tahun-bulan-tanggal">
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
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Hanya menambah data barang?</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                        <a href="tambah_barang2.php" class="btn btn-dark">Selanjutnya</a>
                        </div>
                    </div>
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
