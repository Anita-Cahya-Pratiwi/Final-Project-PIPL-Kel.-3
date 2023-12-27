<?php
session_start();

$currentPage = 'daftar_barang2';

if (!isset($_SESSION['level'])) {
    header("location: login.php?pesan=gagal");
    exit();
} else if ($_SESSION['level'] == "dosen") {
    $headerFile = "inc_header_dosen.php";
} else if ($_SESSION['level'] == "mahasiswa") {
    $headerFile = "inc_header_mahasiswa.php";
}
include($headerFile);


$itemId = isset($_GET['id']) ? $_GET['id'] : 0;

$sql1 = "SELECT * FROM barang 
INNER JOIN ruang_lab ON barang.no_ruang_kib = ruang_lab.no_ruang_kib
WHERE no_barang = $itemId";
$result1 = mysqli_query($koneksi, $sql1);
$item1 = mysqli_fetch_assoc($result1);

$sql2 = "SELECT p.*, r_asal.unit_kelola AS ruang_asal, r_tujuan.unit_kelola AS ruang_tujuan
FROM pemindahan p
INNER JOIN ruang_lab r_asal ON p.no_ruang_asal = r_asal.no_ruang_kib
INNER JOIN ruang_lab r_tujuan ON p.no_ruang_tujuan = r_tujuan.no_ruang_kib
WHERE p.no_barang = $itemId";
$result2 = mysqli_query($koneksi, $sql2);
$item2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);

$sql3 = "SELECT * FROM perbaikan WHERE no_barang = $itemId";
$result3 = mysqli_query($koneksi, $sql3);
$item3 = mysqli_fetch_assoc($result3);

$sql4 = "SELECT * FROM peminjaman_biasa WHERE no_barang = $itemId";
$result4 = mysqli_query($koneksi, $sql4);
$item4 = mysqli_fetch_assoc($result4);

$sql5 = "SELECT * FROM peminjaman_khusus WHERE no_barang = $itemId";
$result5 = mysqli_query($koneksi, $sql5);
$item5 = mysqli_fetch_assoc($result5);

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
                            <p><strong>NUP:</strong> <?php echo $item1['nup']; ?></p>
                            <p><strong>Fisik Barang:</strong> <?php echo $item1['fisik_barang']; ?></p>
                            <p><strong>Spesifikasi:</strong> <?php echo $item1['spesifikasi']; ?></p>
                            <p><strong>Unit Kelola:</strong> <?php echo $item1['unit_kelola']; ?></p>
                        </div>
                        <div class="col-md-4">
                            <h5>Riwayat Pemindahan</h5>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
if ($_SESSION['level'] == "mahasiswa") {
?>
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Status Barang</h5>
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <?php
                        $status = "Tersedia";

                        $sqlPeminjaman = "SELECT status_peminjaman_biasa FROM peminjaman_biasa WHERE no_barang = $itemId ORDER BY tanggal_peminjaman_biasa DESC LIMIT 1";
                        $resultPeminjaman = mysqli_query($koneksi, $sqlPeminjaman);
                        $lastPeminjaman = mysqli_fetch_assoc($resultPeminjaman);

                        $sqlPeminjamank = "SELECT status_peminjaman_khusus FROM peminjaman_khusus WHERE no_barang = $itemId ORDER BY tanggal_peminjaman_khusus DESC LIMIT 1";
                        $resultPeminjamank = mysqli_query($koneksi, $sqlPeminjamank);
                        $lastPeminjamank = mysqli_fetch_assoc($resultPeminjamank);

                        $sqlPerbaikan = "SELECT status_perbaikan FROM perbaikan WHERE no_barang = $itemId ORDER BY tanggal_perbaikan DESC LIMIT 1";
                        $resultPerbaikan = mysqli_query($koneksi, $sqlPerbaikan);
                        $lastPerbaikan = mysqli_fetch_assoc($resultPerbaikan);

                        if ($lastPeminjaman && $lastPeminjaman['status_peminjaman_biasa'] == 'Dipinjam') {
                            $status = "Sedang dipinjam";
                        }   elseif ($lastPeminjaman && $lastPeminjaman['status_peminjaman_biasa'] == 'Dalam proses peminjaman') {
                            $status = "Sedang dipinjam"; //untuk mencegah barang yang dipinjam terlebih dahulu, tidak dipinjam juga oleh user lain
                        }   elseif ($lastPeminjamank && $lastPeminjamank['status_peminjaman_khusus'] == 'Dipinjam') {
                            $status = "Sedang dipinjam";
                        }   elseif ($lastPeminjamank && $lastPeminjamank['status_peminjaman_khusus'] == 'Dalam proses peminjaman') {
                            $status = "Sedang dipinjam";
                        }  elseif ($lastPerbaikan && $lastPerbaikan['status_perbaikan'] == 'Dalam perbaikan') {
                            $status = "Dalam Perbaikan";
                        } 
                        echo "<p><strong>Status:</strong> $status</p>";
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php
                        if ($status =="Tersedia"){
                        ?>
                        <td scope="row">
                        <?php
                            $englishDay = date('D');
                            $dayMappings = array(
                                'Mon' => 'Senin',
                                'Tue' => 'Selasa',
                                'Wed' => 'Rabu',
                                'Thu' => 'Kamis',
                                'Fri' => 'Jumat',
                                'Sat' => 'Sabtu',
                                'Sun' => 'Minggu'
                            );
                            
                            $hari = isset($dayMappings[$englishDay]) ? $dayMappings[$englishDay] : $englishDay;
                            date_default_timezone_set('Asia/Jakarta'); 
                        ?>
                            <button type="button" class="btn btn-primary approval-btn-p" 
                                data-tanggal="<?php echo date('Y-m-d'); ?>" 
                                data-waktu="<?php echo date('H:i:s');?>"
                                data-hari="<?php echo $hari; ?>">
                                Pinjam Barang
                            </button>
                        </td>
                        <?php
                        }
                        ?>
                        <?php
                        if ($status !="Tersedia"){
                        ?>
                        <td scope="row">
                            <button type="button" class="btn btn-secondary">Pinjam Barang</button>
                        </td>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
</section>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(".approval-btn-p").click(function () {
    var hariPeminjaman = $(this).data("hari");
    var tanggalPeminjaman = $(this).data("tanggal");
    var waktuPeminjaman = $(this).data("waktu");
    var username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>";
    var noBarang = "<?php echo $item1['no_barang']; ?>"; 

    if (confirm("Apakah Anda yakin ingin meminjam barang ini?")) {
        $.ajax({
            type: "POST",
            url: "pinjam.php",
            data: {
                action: "approve",
                hari: hariPeminjaman,
                tanggal: tanggalPeminjaman,
                waktu: waktuPeminjaman,
                username: username,
                barang: noBarang,
            },
            success: function (response) {
                if (response.success) {
                    $("#status_peminjaman_biasa" + requestId).text("Dalam proses peminjaman");
                    location.reload();
                } else {
                    location.reload();
                }
            },
            error: function () {
                alert("Error processing approval.");
            }
        });
    }
});
</script>
<?php
include("inc_footer.php");
?>
</body>
</html>
