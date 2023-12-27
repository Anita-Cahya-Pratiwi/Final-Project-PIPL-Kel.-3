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


$no_mutasi = isset($_GET['no_mutasi']) ? $_GET['no_mutasi'] : '';
$no_internal = '';
$tanggal_mutasi = ''; 
$jumlah_barang = ''; 
$unit_mutasi = ''; 
$id_pengelola = ''; 
$id_penerima = '';

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'edit') {
    $sql1 = "SELECT * FROM mutasi_aset WHERE no_mutasi = '$no_mutasi'";
    $q1   = mysqli_query($koneksi, $sql1);

    if ($q1 !== false) {
        if (mysqli_num_rows($q1) > 0) {
            $r1 = mysqli_fetch_array($q1);

            if (isset($r1['no_mutasi'], $r1['no_internal'], $r1['tanggal_mutasi'], $r1['jumlah_barang'], $r1['unit_mutasi'], $r1['id_pengelola'], $r1['id_penerima'])) {
                $no_mutasi    = $r1['no_mutasi'];
                $no_internal    = $r1['no_internal'];
                $tanggal_mutasi = $r1['tanggal_mutasi'];
                $jumlah_barang  = $r1['jumlah_barang'];
                $unit_mutasi    = $r1['unit_mutasi'];
                $id_pengelola    = $r1['id_pengelola'];
                $id_penerima    = $r1['id_penerima'];
            } else {
                echo "Error: Required columns not set in the result.";
            }
        } else {
            echo "No records found for no_mutasi = '$no_mutasi'.";
        }
    } else {
        echo "Error in query: " . mysqli_error($koneksi);
    }
}

if ((isset($_POST['simpan']))) {
    $no_mutasi    = $_POST['no_mutasi'];
    $no_internal  = $_POST['no_internal'];
    $tanggal_mutasi= $_POST['tanggal_mutasi'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $unit_mutasi   = $_POST['unit_mutasi'];
    $id_pengelola  = $_POST['id_pengelola'];
    $id_penerima   = $_POST['id_penerima'];

    $stmt = $koneksi->prepare("UPDATE mutasi_aset SET no_internal = ?, tanggal_mutasi = ?, jumlah_barang = ?, unit_mutasi = ?, id_pengelola = ?, id_penerima = ? WHERE no_mutasi = ?");

    if ($stmt === false) {
        die('Error in preparing the statement: ' . $koneksi->error);
    }

    $stmt->bind_param("ssisssi", $no_internal, $tanggal_mutasi, $jumlah_barang, $unit_mutasi, $id_pengelola, $id_penerima, $no_mutasi);

    $executeResult = $stmt->execute();

    if ($executeResult === false) {
        die('Error in executing the statement: ' . $stmt->error);
    }

    $success = "Aset termutasi berhasil diedit.";
    header("Location: dedit_mutasi.php?success=" . urlencode($success));
    exit();
}

$currentPage = 'kelola_mutasi';
include($headerFile);
include('css.php');
?>
<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text"> Edit Mutasi Aset</span>
    </div>
    <div class="main-content">
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Formulir Mutasi Aset</h5>
            </div>
            <div class="card-body" align="center"><b>Barang termutasi tidak dapat diedit kecuali data mutasi, hapus data jika ingin merubah barang</b></div>
            <div class="card-body">
                <form action="" method="post" id="formMutasi">
                <input type="hidden" class="form-control" id="no_mutasi" name="no_mutasi" value="<?php echo $no_mutasi ?>">
                    <div class="card-body">
                    <div class="mb-3 row">
                        <label for="no_internal" id = "noInternal" class="col-sm-2 col-form-label">No Internal</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_internal" name="no_internal" value="<?php echo $no_internal ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_mutasi" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_mutasi" name="tanggal_mutasi" value="<?php echo $tanggal_mutasi; ?>" required>
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
                            <input type="text" class="form-control" id="unit_mutasi" name="unit_mutasi" value="<?php echo $unit_mutasi ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id_pengelola" class="col-sm-2 col-form-label" >ID Pengelola</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_pengelola" name="id_pengelola" value="<?php echo $id_pengelola ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id_penerima" class="col-sm-2 col-form-label" >ID Penerima</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_penerima" name="id_penerima" value="<?php echo $id_penerima ?>" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" name = "simpan" class="btn btn-primary">Mutasikan</button>
                    </div>
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
