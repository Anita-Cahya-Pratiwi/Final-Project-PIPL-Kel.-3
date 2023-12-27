<?php
session_start();

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

$currentPage = 'kelola_pindah_barang';
include($headerFile);

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'delete1') {
    $no_pemindahan = isset($_GET['no_pemindahan']) ? $_GET['no_pemindahan'] : '';

        $sql1 = "DELETE FROM pemindahan WHERE no_pemindahan = ?";
        $stmt1 = mysqli_prepare($koneksi, $sql1);

        if ($stmt1) {
            mysqli_stmt_bind_param($stmt1, "s", $no_pemindahan);
        
        try{ $result1 = mysqli_stmt_execute($stmt1);
            if ($result1) {
                $sukses1 = "Berhasil hapus data";
            } else {
                $error1 = "Gagal melakukan delete data: " . mysqli_error($koneksi);
            }
        }
        catch (mysqli_sql_exception $e) {
            $error2 = "Gagal menghapus data pemindahan: " . $e->getMessage();
        }

        mysqli_stmt_close($stmt1);
        } else {
            $error1 = "Failed to prepare the delete statement";
        }
}

if ($op == 'delete2') {
    $no_ruang_kib = isset($_GET['no_ruang_kib']) ? $_GET['no_ruang_kib'] : '';

        $sql2 = "DELETE FROM ruang_lab WHERE no_ruang_kib = ?";
        $stmt2 = mysqli_prepare($koneksi, $sql2);

        if ($stmt2) {
            mysqli_stmt_bind_param($stmt2, "s", $no_ruang_kib);

        try {$result2 = mysqli_stmt_execute($stmt2);
            if ($result2) {
                $sukses2 = "Berhasil hapus data";
            } else {
                $error2 = "Gagal melakukan delete data: " . mysqli_error($koneksi);
            }
        }
        catch (mysqli_sql_exception $e) {
            $error2 = "Gagal menghapus data ruang: " . $e->getMessage();
        }

            mysqli_stmt_close($stmt2);
        } else {
            $error2 = "Failed to prepare the delete statement";
        }
}
?>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Kelola Pemindahan Barang</span>
    </div>
    <div class="main-content">
    <div class="mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Riwayat Pemindahan Barang</h5>
        </div>
        <?php if (isset($sukses1)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses1; ?>
                </div>
            <?php elseif (isset($error1)):  ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo $error1;?>                
                </div>
            <?php endif; ?>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <td scope="row">
                        <a href="pindah_barang.php"><button type="button" class="btn btn-primary">Tambahkan Pemindahan</button></a>
                    </td>
                </div>
            </div>
            <p><!--jarak--></p>
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">No. Barang</th>
                  <th scope="col">Uraian Barang</th>
                  <th scope="col">Fisik Barang</th>
                  <th scope="col">Tanggal Pemindahan</th>
                  <th scope="col">Ruang Asal</th>
                  <th scope="col">Ruang Tujuan</th>
                  <th scope="col">Edit Data</th>
                  <th scope="col">Hapus Data</th>
                </tr>
            </thead>
            <tbody>
              <?php
                $sql2 = "SELECT p.*, barang.uraian_barang, barang.fisik_barang, r_asal.unit_kelola AS ruang_asal, r_tujuan.unit_kelola AS ruang_tujuan
                FROM pemindahan p
                INNER JOIN barang ON p.no_barang = barang.no_barang
                INNER JOIN ruang_lab r_asal ON p.no_ruang_asal = r_asal.no_ruang_kib
                INNER JOIN ruang_lab r_tujuan ON p.no_ruang_tujuan = r_tujuan.no_ruang_kib
                ORDER BY p.no_pemindahan";

                $q2     = mysqli_query($koneksi, $sql2);
                while ($r2 = mysqli_fetch_array($q2)) {
                    $no_pemindahan  = $r2['no_pemindahan'];
                    $no_barang  = $r2['no_barang'];
                    $uraian_barang  = $r2['uraian_barang'];
                    $fisik_barang  = $r2['fisik_barang'];
                    $tanggal_pemindahan     = $r2['tanggal_pemindahan'];
                    $ruang_asal = $r2['ruang_asal'];
                    $ruang_tujuan = $r2['ruang_tujuan'];
                  ?>
                  <tr>
                      <th scope="row"><?php echo $no_pemindahan ?></th>
                      <td scope="row"><?php echo $no_barang ?></td>
                      <td scope="row"><?php echo $uraian_barang ?></td>
                      <td scope="row"><?php echo $fisik_barang ?></td>
                      <td scope="row"><?php echo $tanggal_pemindahan ?></td>
                      <td scope="row"><?php echo $ruang_asal ?></td>
                      <td scope="row"><?php echo $ruang_tujuan ?></td>
                      <td scope="row">
                      <a href="edit_pemindahan.php?op=edit&no_pemindahan=<?php echo $no_pemindahan; ?>"><button type="button" class="btn btn-warning">Edit Pemindahan</button></a>
                      </td>
                      <td scope="row">
                        <a href="kelola_pindah_barang.php?op=delete1&no_pemindahan=<?php echo $no_pemindahan; ?>" onclick="return confirm('Ingin menghapus data pemindahan?')"><button type="button" class="btn btn-danger">Hapus Pemindahan</button></a>
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
    <div class="main-content">
    <div class="mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Data Unit Kelola</h5>
        </div>
            <?php if (isset($sukses2)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses2; ?>
                </div>
            <?php elseif (isset($error2)):  ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo "Gagal menghapus data, foreign key dari data lain. Cobalah ganti atau hapus data barang terkait terlebih dahulu!";?>
                </div>
            <?php endif; ?>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <td scope="row">
                        <a href="tambah_ruang.php"><button type="button" class="btn btn-primary">Tambahkan Ruang</button></a>
                    </td>
                </div>
            </div>
            <p><!--jarak--></p>
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead>
                <tr>
                  <th scope="col">No. Ruang / No. KIB</th>
                  <th scope="col">Unit Kelola</th>
                  <th scope="col">Edit Data</th>
                  <th scope="col">Hapus Data</th>
                </tr>
            </thead>
            <tbody>
              <?php
                $sql2 = "SELECT * FROM ruang_lab
                ORDER BY no_ruang_kib";

                $q2     = mysqli_query($koneksi, $sql2);
                while ($r2 = mysqli_fetch_array($q2)) {
                    $no_ruang_kib  = $r2['no_ruang_kib'];
                    $unit_kelola  = $r2['unit_kelola'];
                  ?>
                  <tr>
                      <th scope="row"><?php echo $no_ruang_kib ?></th>
                      <td scope="row"><?php echo $unit_kelola ?></td>
                      <td scope="row">
                      <a href="edit_ruang.php?op=edit&no_ruang_kib=<?php echo $no_ruang_kib; ?>"><button type="button" class="btn btn-warning">Edit Ruang</button></a>
                      </td>
                      <td scope="row">
                      <a href="kelola_pindah_barang.php?op=delete2&no_ruang_kib=<?php echo $no_ruang_kib; ?>" onclick="return confirm('Ingin menghapus data ruang?')"><button type="button" class="btn btn-danger">Hapus Ruang</button></a>
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
  </section>
  <?php
  include("inc_footer.php");
  ?>
</body>
</html>
