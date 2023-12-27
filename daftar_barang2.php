<?php
session_start();
include ("link_db.php");
$currentPage = 'daftar_barang2';

if (!isset($_SESSION['level'])) {
    header("location: login.php?pesan=gagal");
    exit();
}
if ($_SESSION['level'] == "dosen") {
    $headerFile = "inc_header_dosen.php"; 
} else if ($_SESSION['level'] == "mahasiswa") {
    $headerFile = "inc_header_mahasiswa.php";
}

$sqli = "SELECT * FROM barang
INNER JOIN ruang_lab ON barang.no_ruang_kib = ruang_lab.no_ruang_kib
INNER JOIN pengadaan ON barang.no_pengadaan = pengadaan.no_pengadaan
WHERE keterangan_barang ='OPERASIONAL'
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


if (isset($_POST['btn']) && isset($_POST['pinjam'])) {
    $a = $_POST['pinjam'];
    $jml = count($a);

    $id_penerima = $_POST['id_penerima'];
    $tanggal_peminjaman_khusus = $_POST['tanggal_peminjaman_khusus'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $unit_peminjaman_khusus = $_POST['unit_peminjaman_khusus'];
    $keperluan = $_POST['keperluan'];

    // Prepare the statement outside the loop
    $stmt = $koneksi->prepare("INSERT INTO peminjaman_khusus (id_penerima, tanggal_peminjaman_khusus, no_barang, jumlah_barang, unit_peminjaman_khusus, keperluan, id_pengelola, status_peminjaman_khusus) VALUES (?, ?, ?, ?, ?, ?, '197308282021211006', 'Dalam proses peminjaman')");

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('Error in preparing the statement.');
    }

    for ($i = 0; $i < $jml; $i++) {

        $stmt->bind_param("ississ", $id_penerima, $tanggal_peminjaman_khusus, $a[$i], $jumlah_barang, $unit_peminjaman_khusus, $keperluan);

        $executeResult = $stmt->execute();

        if ($executeResult === false) {
            die('Error in executing the statement: ' . $stmt->error);
        }

        $stmt->reset();
    }

    $stmt->close();

    $Message = "Barang dalam proses peminjaman.";
    header("Location: dpeminjaman_khusus.php?Message=" . urlencode($Message));
    exit();
}

include($headerFile);
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Daftar Barang</span>
    </div>
    <div class="main-content">
        <form action="daftar_barang2.php" method="post">
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
                    <?php
                        if ($_SESSION['level'] == "dosen") {
                    ?>              
                    <div class="card-body">
                    <div class="col-md-12">
                            <td scope="row">
                                <button type="button" class="btn btn-primary" onclick="scrollToForm()">Input Peminjaman</button>
                            </td>
                        </div>  
                    </div>
                    <?php
                    }
                    ?>
                    <div class="card-body">
                    <form action="" method="post" id="formPinjam">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Uraian Barang</th>
                                    <th scope="col">NUP</th>
                                    <th scope="col">Fisik Barang</th>
                                    <th scope="col">Spesifikasi</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Unit Kelola</th>
                                    <th scope="col">Selengkapnya</th>
                                    <?php
                                    if ($_SESSION['level'] == "dosen") {
                                    ?>
                                    <th scope="col">Pinjam Barang</th>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($r2 = mysqli_fetch_array($resulti)) {
                                    $no_barang = $r2['no_barang'];
                                    $uraian_barang = $r2['uraian_barang'];
                                    $nup = $r2['nup'];
                                    $fisik_barang = $r2['fisik_barang'];
                                    $spesifikasi = $r2['spesifikasi'];
                                    $keterangan_barang = $r2['keterangan_barang'];
                                    $unit_kelola = $r2['unit_kelola'];
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $no_barang ?></th>
                                        <td scope="row"><?php echo $uraian_barang ?></td>
                                        <td scope="row"><?php echo $nup ?></td>
                                        <td scope="row"><?php echo $fisik_barang ?></td>
                                        <td scope="row"><?php echo $spesifikasi ?></td>
                                        <td scope="row"><?php echo $keterangan_barang ?></td>
                                        <td scope="row"><?php echo $unit_kelola ?></td>
                                        <td scope="row">
                                            <a href="informasi_barang2.php?id=<?php echo $no_barang; ?>"><button type="button" class="btn btn-primary">Lihat</button></a>
                                        </td>
                                        <?php
                                        if ($_SESSION['level'] == "dosen") {
                                            $status = "Tersedia";

                                            $sqlPeminjaman = "SELECT status_peminjaman_biasa FROM peminjaman_biasa WHERE no_barang = '$no_barang'";
                                            $resultPeminjaman = mysqli_query($koneksi, $sqlPeminjaman);
                                            $lastPeminjaman = mysqli_fetch_assoc($resultPeminjaman);

                                            $sqlPeminjamank = "SELECT status_peminjaman_khusus FROM peminjaman_khusus WHERE no_barang = '$no_barang'";
                                            $resultPeminjamank = mysqli_query($koneksi, $sqlPeminjamank);
                                            $lastPeminjamank = mysqli_fetch_assoc($resultPeminjamank);

                                            $sqlPerbaikan = "SELECT status_perbaikan FROM perbaikan WHERE no_barang = '$no_barang'";
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
                                            if ($status =="Tersedia"){
                                            ?>
                                            <td scope="row" class="checkboxz">
                                                <input type="checkbox" name="pinjam[]" id="pinjam<?php echo $no_barang ?>" value="<?php echo $no_barang?>">
                                                <label for="pinjam<?php echo $no_barang ?>"><?php echo "<p><strong>Status:</strong> $status</p>";?></label>
                                            </td>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if ($status !="Tersedia"){
                                            ?>
                                            <td scope="row" class="checkboxz">
                                                <input type="checkbox" name="pinjam[]" id="pinjam<?php echo $no_barang ?>" value="<?php echo $no_barang?>" disabled>
                                                <label for="pinjam<?php echo $no_barang?>"><?php echo "<p><strong>Status:</strong> $status</p>";?></label>
                                            </td>
                                            <?php
                                            }
                                            }
                                            ?>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                    <div class="mb-3 row">
                        <label for="id_penerima" class="col-sm-2 col-form-label">ID Peminjam</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_penerima" name="id_penerima" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_peminjaman_khusus" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_peminjaman_khusus" name="tanggal_peminjaman_khusus" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah_barang" class="col-sm-2 col-form-label">Jumlah Barang</label>
                        <div class="col-sm-10">
                        <select class="form-control" name="jumlah_barang" id="jumlah_barang">
                          <option value="1" selected><?php echo "1"; ?></option>
                        </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="unit_peminjaman_khusus" class="col-sm-2 col-form-label">Unit Peminjaman</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="unit_peminjaman_khusus" name="unit_peminjaman_khusus" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="keperluan" class="col-sm-2 col-form-label">Keperluan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keperluan" name="keperluan" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" name = "btn" class="btn btn-primary"?>Pinjam Barang</button>
                    </div>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include("inc_footer.php");
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
function scrollToForm() {
    const formElement = document.getElementById('unit_peminjaman_khusus');

    formElement.scrollIntoView({ behavior: 'smooth' });
}
</script>
</body>
</html>
