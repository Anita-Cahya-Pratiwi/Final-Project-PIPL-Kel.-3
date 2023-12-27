<?php
session_start();

$currentPage = 'daftar_barang1';

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
include($headerFile);

$itemId = isset($_GET['id']) ? $_GET['id'] : 0;

$sql1 = "SELECT * FROM barang 
INNER JOIN ruang_lab ON barang.no_ruang_kib = ruang_lab.no_ruang_kib
INNER JOIN pengadaan ON barang.no_pengadaan = pengadaan.no_pengadaan 
WHERE no_barang = $itemId";
$result1 = mysqli_query($koneksi, $sql1);
$item1 = mysqli_fetch_assoc($result1);

$sql2 = "SELECT p.*, r_asal.unit_kelola AS ruang_asal, r_tujuan.unit_kelola AS ruang_tujuan
FROM pemindahan p
INNER JOIN ruang_lab r_asal ON p.no_ruang_asal = r_asal.no_ruang_kib
INNER JOIN ruang_lab r_tujuan ON p.no_ruang_tujuan = r_tujuan.no_ruang_kib
WHERE p.no_barang = $itemId
ORDER BY no_pemindahan ASC";
$result2 = mysqli_query($koneksi, $sql2);
$item2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);

$sql3 = "SELECT * FROM perbaikan WHERE no_barang = $itemId ORDER BY no_perbaikan ASC";
$result3 = mysqli_query($koneksi, $sql3);
$item3 = mysqli_fetch_all($result3);

?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Informasi Barang</span>
    </div>
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Informasi Barang</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?php echo $item1['gambar']; ?>" alt="Item Image" class="img-fluid">
                        </div>
                        <div class="col-md-4">
                            <h4><?php echo $item1['uraian_barang']; ?></h4>
                            <p><strong>Nomor:</strong> <?php echo $item1['no_barang']; ?></p>
                            <p><strong>Kode BMN:</strong> <?php echo $item1['kode_bmn']; ?></p>
                            <p><strong>NUP:</strong> <?php echo $item1['nup']; ?></p>
                            <p><strong>Kode Internal:</strong> <?php echo $item1['kode_internal']; ?></p>
                            <p><strong>Fisik Barang:</strong> <?php echo $item1['fisik_barang']; ?></p>
                            <p><strong>Spesifikasi:</strong> <?php echo $item1['spesifikasi']; ?></p>
                            <p><strong>Unit Kelola:</strong> <?php echo $item1['unit_kelola']; ?></p>
                        </div>
                        <div class="col-md-4">
                            <h5>Rincian</h5>
                            <p><strong>Sumber Anggaran:</strong> <?php echo $item1['sumber_anggaran']; ?></p>
                            <p><strong>Satuan:</strong> <?php echo $item1['sat']; ?></p>
                            <p><strong>Nilai:</strong> <?php echo $item1['nilai']; ?></p>           
                            <p><strong>Kondisi:</strong> <?php echo $item1['kondisi']; ?></p>
                            <p><strong>Tercatat:</strong> <?php echo $item1['tercatat']; ?></p>
                            <p><strong>Keterangan:</strong> <?php echo $item1['keterangan_barang']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Riwayat Barang</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Pengadaan</h5>
                            <p><strong>Nomor Pengadaan:</strong> <?php echo ($item1['no_pengadaan']!= '0') ? $item1['no_pengadaan'] : '-'; ?></p>
                            <p><strong>No Surat Pengadaan:</strong> <?php echo $item1['no_surat_pengadaan']; ?></p>
                            <p><strong>Tanggal Pengadaan:</strong>  <?php echo ($item1['tanggal_pengadaan'] != '0000-00-00') ? $item1['tanggal_pengadaan'] : '-'; ?>
                            <p><strong>Tahun Pengadaan:</strong> <?php echo ($item1['tahun_pengadaan'] != '0000') ? $item1['tahun_pengadaan'] : '-'; ?>
                            <p><strong>Jumlah Barang:</strong> <?php echo $item1['jumlah_barang']; ?></p>
                            <p><strong>Satuan:</strong> <?php echo $item1['satuan']; ?></p>
                            <p><strong>Keterangan:</strong> <?php echo $item1['keterangan_pengadaan']; ?></p>
                        </div>
                        <div class="col-md-4">
                            <h5>Pemindahan</h5>
                                <?php if (!empty($item2)) : ?>
                                    <?php foreach ($item2 as $row_pemindahan) : ?>
                                        <p><strong>Nomor Pemindahan:</strong> <?php echo $row_pemindahan['no_pemindahan']; ?></p>
                                        <p><strong>Tanggal Pemindahan:</strong> <?php echo $row_pemindahan['tanggal_pemindahan']; ?></p>
                                        <p><strong>Ruang Asal:</strong> <?php echo $row_pemindahan['ruang_asal']; ?></p>
                                        <p><strong>Ruang Pemindahan:</strong> <?php echo $row_pemindahan['ruang_tujuan']; ?></p>
                                        <hr>    
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p>Belum ada data pemindahan untuk barang ini.</p>
                                <?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <h5>Perbaikan</h5>
                            <?php if ($result3 && mysqli_num_rows($result3) > 0) : ?>
                                <?php foreach ($result3 as $row_perbaikan) : ?>
                                    <p><strong>Nomor Perbaikan:</strong> <?php echo $row_perbaikan['no_perbaikan']; ?></p>
                                    <p><strong>Tanggal Perbaikan:</strong> <?php echo $row_perbaikan['tanggal_perbaikan']; ?></p>
                                    <p><strong>Keterangan Perbaikan:</strong> <?php echo $row_perbaikan['keterangan_perbaikan']; ?></p>
                                    <p><strong>Status Perbaikan:</strong> <?php echo $row_perbaikan['status_perbaikan']; ?></p>
                                    <p><strong>Tanggal Selesai:</strong> <?php echo ($row_perbaikan['tanggal_perbaikan_selesai'] != '0000-00-00') ? $row_perbaikan['tanggal_perbaikan_selesai'] : ' '; ?>
                                    <hr>
                                    <?php endforeach; ?>              
                            <?php else : ?>
                                <p>Belum ada data perbaikan untuk barang ini.</p>
                            <?php endif; ?>
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
