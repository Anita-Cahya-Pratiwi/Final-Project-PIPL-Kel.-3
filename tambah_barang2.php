<?php
session_start();
require ('link_db.php');

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
$unit_kelola        = "";
$no_surat_pengadaan = "";
$gambar             = "";
$sukses             = "";
$error              = "";

if (isset($_POST['simpan'])) {
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

    $unit_kelola = $_POST['unit_kelola'];
    $queryNoRuangKIB = mysqli_query($koneksi, "SELECT no_ruang_kib FROM ruang_lab WHERE unit_kelola = '$unit_kelola'");
    $rowNoRuangKIB = mysqli_fetch_assoc($queryNoRuangKIB);

    $no_ruang_kib = ($rowNoRuangKIB) ? $rowNoRuangKIB['no_ruang_kib'] : null;

    $no_surat_pengadaan = $_POST['no_surat_pengadaan'];
    $queryNoPengadaan = mysqli_query($koneksi, "SELECT no_pengadaan FROM pengadaan WHERE no_surat_pengadaan = '$no_surat_pengadaan'");
    $rowNoPengadaan = mysqli_fetch_assoc($queryNoPengadaan);

    $no_pengadaan = ($rowNoPengadaan) ? $rowNoPengadaan['no_pengadaan'] : null;
    $gambar        = $_POST['gambar'];


    if ($kode_bmn && $uraian_barang && $nup && $kode_internal && $fisik_barang && $spesifikasi && $sumber_anggaran && $sat && $nilai && $kondisi && $tercatat && $keterangan_barang && $no_ruang_kib && $no_pengadaan && $gambar) {
        $sql1 = "INSERT INTO barang (kode_bmn, uraian_barang, nup, kode_internal, fisik_barang, spesifikasi, sumber_anggaran, sat, nilai, kondisi, tercatat, keterangan_barang, no_ruang_kib, no_pengadaan, gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql1);
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'sssssssssssssss',$kode_bmn, $uraian_barang ,$nup, $kode_internal, $fisik_barang, $spesifikasi, $sumber_anggaran, $sat, $nilai, $kondisi, $tercatat, $keterangan_barang, $no_ruang_kib, $no_pengadaan, $gambar);
        
        // Execute statement
        $q1 = mysqli_stmt_execute($stmt);
        
        // Check for success or failure
        if ($q1) {
           $sukses = "Data tersimpan, input barang berikutnya jika ada!";
           header("refresh:5;url=tambah_barang2.php");
        } else {
           $error = "Gagal menyimpan data. Error: " . mysqli_error($koneksi);
           header("refresh:2;url=tambah_barang2.php");
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
                    Formulir Data Barang
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
                    <form action="tambah_barang2.php" method="POST">
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
                                <input type="text" class="form-control" id="spesifikasi" name="spesifikasi" value="<?php echo htmlspecialchars($spesifikasi); ?>">
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
                            <select class="form-control" name="unit_kelola" id="unit_kelola">
                                <option value="">- Pilih Unit Kelola -</option>
                                <option value="Ruang Server" <?php if ($unit_kelola == "Ruang Server") echo "selected" ?>>Ruang Server</option>
                                <option value="Ruang Lab. T.I. 1" <?php if ($unit_kelola == "Ruang Lab. T.I. 1") echo "selected" ?>>Ruang Lab. T.I. 1</option>
                                <option value="Ruang Lab. T.I. 2" <?php if ($unit_kelola == "Ruang Lab. T.I. 2") echo "selected" ?>>Ruang Lab. T.I. 2</option>
                                <option value="Ruang Lab. T.I. 3" <?php if ($unit_kelola == "Ruang Lab. T.I. 3") echo "selected" ?>>Ruang Lab. T.I. 3</option>
                            </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="no_surat_pengadaan" class="col-sm-2 col-form-label">No. Surat Pengadaan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="no_surat_pengadaan" name="no_surat_pengadaan">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="gambar" name="gambar">
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
