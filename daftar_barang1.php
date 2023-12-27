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

$sqli = "SELECT * FROM barang
INNER JOIN ruang_lab ON barang.no_ruang_kib = ruang_lab.no_ruang_kib
INNER JOIN pengadaan ON barang.no_pengadaan = pengadaan.no_pengadaan
ORDER BY barang.no_barang ASC";

if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_POST['search']);
    $sqli = "SELECT * FROM barang 
    INNER JOIN ruang_lab ON barang.no_ruang_kib = ruang_lab.no_ruang_kib
    INNER JOIN pengadaan ON barang.no_pengadaan = pengadaan.no_pengadaan
    WHERE 
        uraian_barang LIKE '%$search%' OR 
        fisik_barang LIKE '%$search%' OR 
        no_barang LIKE '%$search%' OR 
        kondisi LIKE '%$search%' OR 
        keterangan_barang LIKE '%$search%' OR 
        unit_kelola LIKE '%$search%' 
    ORDER BY no_barang ASC";
}

$resulti = mysqli_query($koneksi, $sqli);
?>
<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Daftar Barang</span>
    </div>
    <div class="main-content">
        <form action="daftar_barang1.php" method="post">
        <div class="search-container">
            <input type="text" placeholder="Cari barang..." name="search">
            <button type="submit">Cari</button>
        </div>
        </form>
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Barang</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode BMN</th>
                                    <th scope="col">Uraian Barang</th>
                                    <th scope="col">NUP</th>
                                    <th scope="col">Kode Internal</th>
                                    <th scope="col">Fisik Barang</th>
                                    <th scope="col">Spesifikasi</th>
                                    <th scope="col">Sumber Anggaran</th>
                                    <th scope="col">SAT</th>
                                    <th scope="col">Nilai</th>
                                    <th scope="col">Kondisi</th>
                                    <th scope="col">Tercatat</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Unit Kelola</th>
                                    <th scope="col">No Surat Pengadaan</th>
                                    <th scope="col">Selengkapnya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($r2 = mysqli_fetch_array($resulti)) {
                                    $no_barang = $r2['no_barang'];
                                    $kode_bmn = $r2['kode_bmn'];
                                    $uraian_barang = $r2['uraian_barang'];
                                    $nup = $r2['nup'];
                                    $kode_internal = $r2['kode_internal'];
                                    $fisik_barang = $r2['fisik_barang'];
                                    $spesifikasi = $r2['spesifikasi'];
                                    $sumber_anggaran = $r2['sumber_anggaran'];
                                    $sat = $r2['sat'];
                                    $nilai = $r2['nilai'];
                                    $kondisi = $r2['kondisi'];
                                    $tercatat = $r2['tercatat'];
                                    $keterangan_barang = $r2['keterangan_barang'];
                                    $unit_kelola = $r2['unit_kelola'];
                                    $no_surat_pengadaan = $r2['no_surat_pengadaan'];
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $no_barang ?></th>
                                        <td scope="row"><?php echo $kode_bmn ?></td>
                                        <td scope="row"><?php echo $uraian_barang ?></td>
                                        <td scope="row"><?php echo $nup ?></td>
                                        <td scope="row"><?php echo $kode_internal ?></td>
                                        <td scope="row"><?php echo $fisik_barang ?></td>
                                        <td scope="row"><?php echo $spesifikasi ?></td>
                                        <td scope="row"><?php echo $sumber_anggaran ?></td>
                                        <td scope="row"><?php echo $sat ?></td>
                                        <td scope="row"><?php echo $nilai ?></td>
                                        <td scope="row"><?php echo $kondisi ?></td>
                                        <td scope="row"><?php echo $tercatat ?></td>
                                        <td scope="row"><?php echo $keterangan_barang ?></td>
                                        <td scope="row"><?php echo $unit_kelola ?></td>
                                        <td scope="row"><?php echo $no_surat_pengadaan ?></td>
                                        <td scope="row">
                                            <a href="informasi_barang1.php?id=<?php echo $no_barang; ?>"><button type="button" class="btn btn-primary">Lihat</button></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
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
