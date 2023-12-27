<?php
session_start();
include ("link_db.php");

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

$sqli = "SELECT * FROM barang
INNER JOIN ruang_lab ON barang.no_ruang_kib = ruang_lab.no_ruang_kib
INNER JOIN pengadaan ON barang.no_pengadaan = pengadaan.no_pengadaan
WHERE keterangan_barang = 'OPERASIONAL'
ORDER BY barang.no_barang ASC";

if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_POST['search']);
    $sqli = "SELECT * FROM barang 
    INNER JOIN ruang_lab ON barang.no_ruang_kib = ruang_lab.no_ruang_kib
    INNER JOIN pengadaan ON barang.no_pengadaan = pengadaan.no_pengadaan
    WHERE 
        (uraian_barang LIKE '%$search%' OR 
        fisik_barang LIKE '%$search%' OR 
        no_barang LIKE '%$search%' OR 
        kondisi LIKE '%$search%' OR 
        keterangan_barang LIKE '%$search%' OR 
        unit_kelola LIKE '%$search%') AND keterangan_barang = 'OPERASIONAL'
    ORDER BY no_barang ASC";
}

$resulti = mysqli_query($koneksi, $sqli);

if (isset($_POST['btn']) && isset($_POST['pilih'])) {
    $a = $_POST['pilih'];
    $jml = count($a);

    $no_internal = $_POST['no_internal'];
    $tanggal_mutasi = $_POST['tanggal_mutasi'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $unit_mutasi = $_POST['unit_mutasi'];
    $id_pengelola = $_POST['id_pengelola'];
    $id_penerima = $_POST['id_penerima'];

    $stmt = $koneksi->prepare("INSERT INTO mutasi_aset (no_internal, tanggal_mutasi, jumlah_barang, unit_mutasi, no_barang, id_pengelola, id_penerima) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die('Error in preparing the statement.');
    }

    for ($i = 0; $i < $jml; $i++) {

        $stmt->bind_param("ssisiss", $no_internal, $tanggal_mutasi, $jumlah_barang, $unit_mutasi, $a[$i], $id_pengelola, $id_penerima);

        $executeResult = $stmt->execute();

        if ($executeResult === false) {
            die('Error in executing the statement: ' . $stmt->error);
        }

        $updateKeteranganQuery = "UPDATE barang SET keterangan_barang = 'TIDAK OPERASIONAL, termutasi' WHERE no_barang = ?";
        $updateKeteranganStmt = $koneksi->prepare($updateKeteranganQuery);
        $updateKeteranganStmt->bind_param("s", $a[$i]);
        $updateKeteranganStmt->execute();
        $updateKeteranganStmt->close();
        
        $stmt->reset();
    }

    $stmt->close();

    $successMessage = "Aset berhasil dimutasi.";
    header("Location: kelola_mutasi.php?successMessage=" . urlencode($successMessage));
    exit();
}

$currentPage = 'kelola_mutasi';
include($headerFile);
include('css.php');
?>
<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text"> Mutasi Aset</span>
    </div>
        <div class="tombol-mutasikan">
          <div class="col-md-12">
              <td scope="row">
                  <button type="button" class="btn btn-primary" onclick="scrollToForm()">Input Mutasi</button>
              </td>
          </div>
      </div>
    <div class="main-content">
    <form action="mutasi_aset.php" method="post">
            <div class="search-container">
                <input type="text" placeholder="Cari barang..." name="search">
                <button type="submit">Cari</button>
            </div>
    </form>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Formulir Mutasi Aset</h5>
            </div>
            <div class="card-body" align="center"><b>Pilih chekclist barang pada tabel terlebih dahulu</b></div>
            <div class="card-body">
                <form action="" method="post" id="formMutasi">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Gambar</th>
                                    <th scope="col">Uraian Barang</th>
                                    <th scope="col">NUP</th>
                                    <th scope="col">Fisik Barang</th>
                                    <th scope="col">Spesifikasi</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Unit Kelola</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($r2 = mysqli_fetch_array($resulti)) {                               
                                $no_barang = $r2['no_barang'];      
                                $gambar = $r2['gambar'];                                                          
                                $uraian_barang = $r2['uraian_barang'];
                                $nup = $r2['nup'];
                                $fisik_barang = $r2['fisik_barang'];
                                $spesifikasi = $r2['spesifikasi'];
                                $keterangan_barang = $r2['keterangan_barang'];
                                $unit_kelola = $r2['unit_kelola'];

                                ?>
                                <tr>
                                    <td scope="row" class="checkboxz">
                                        <input type="checkbox" id="pilih<?php echo $no_barang; ?>" name="pilih[]" value="<?php echo $no_barang; ?>">
                                        <label for="pilih<?php echo $no_barang; ?>"><p><?php echo $no_barang; ?></p></label>
                                    </td>
                                    <td scope="row"><img src="<?php echo $gambar; ?>" width="80px" height="80px"></td>
                                    <td scope="row"><?php echo $uraian_barang ?></td>
                                    <td scope="row"><?php echo $nup ?></td>
                                    <td scope="row"><?php echo $fisik_barang ?></td>
                                    <td scope="row"><?php echo $spesifikasi ?></td>
                                    <td scope="row"><?php echo $keterangan_barang ?></td>
                                    <td scope="row"><?php echo $unit_kelola ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                    <div class="mb-3 row">
                        <label for="no_internal" id = "noInternal" class="col-sm-2 col-form-label">No Internal</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_internal" name="no_internal" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_mutasi" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_mutasi" name="tanggal_mutasi" required>
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
                        <label for="unit_mutasi" class="col-sm-2 col-form-label">Unit Mutasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="unit_mutasi" name="unit_mutasi" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id_pengelola" class="col-sm-2 col-form-label">ID Pengelola</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_pengelola" name="id_pengelola" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id_penerima" class="col-sm-2 col-form-label">ID Penerima</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_penerima" name="id_penerima" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" name = "btn" class="btn btn-primary">Mutasikan</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
<script>
function scrollToForm() {
    const formElement = document.getElementById('noInternal');

    formElement.scrollIntoView({ behavior: 'smooth' });
}
</script>
<?php
include("inc_footer.php");
?>
</body>
</html>
