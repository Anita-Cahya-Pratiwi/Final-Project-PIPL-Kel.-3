<?php
session_start();

$currentPage = 'kelola_mutasi';

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
?>

  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Kelola Mutasi Aset</span>
    </div>
    <div class="main-content">
    <div class="mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Aset Termutasi</h5>
        </div>
        <div class="card-body">
        <?php
              if (isset($_GET['successMessage'])) {
            $successMessage = urldecode($_GET['successMessage']);
          ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
          <?php
          }
          ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">No Internal</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Uraian Barang</th>
                  <th scope="col">Fisik Barang</th>
                  <th scope="col">Spesifikasi</th>
                  <th scope="col">Jumlah Barang</th>
                  <th scope="col">Unit Mutasi</th>
                  <th scope="col">No. Barang</th>
                  <th scope="col">Pengelola</th>
                  <th scope="col">Status Pengelola</th>
                  <th scope="col">Penerima</th>
                  <th scope="col">Status Penerima</th>
                </tr>
            </thead>
            <tbody>
              <?php
                $sql2 = "SELECT*
                FROM
                mutasi_aset
                INNER JOIN barang ON mutasi_aset.no_barang = barang.no_barang
                INNER JOIN pengelola ON mutasi_aset.id_pengelola = pengelola.id_pengelola
                INNER JOIN penerima ON mutasi_aset.id_penerima = penerima.id_penerima
                ORDER BY
                no_internal ASC";

                $q2     = mysqli_query($koneksi, $sql2);
                $urut   = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                    $no_internal  = $r2['no_internal'];
                    $tanggal_mutasi     = $r2['tanggal_mutasi'];
                    $uraian_barang = $r2['uraian_barang'];
                    $fisik_barang = $r2['fisik_barang'];
                    $spesifikasi = $r2['spesifikasi'];
                    $jumlah_barang = $r2['jumlah_barang']; 
                    $unit_mutasi = $r2['unit_mutasi'];
                    $no_barang= $r2['no_barang'];
                    $nama_pengelola = $r2['nama_pengelola'];
                    $status_pengelola= $r2['status_pengelola'];
                    $nama_penerima= $r2['nama_penerima'];
                    $status_penerima= $r2['status_penerima'];
                  ?>
                  <tr>
                      <th scope="row"><?php echo $urut++ ?></th>
                      <td scope="row"><?php echo $no_internal ?></td>
                      <td scope="row"><?php echo $tanggal_mutasi ?></td>
                      <td scope="row"><?php echo $uraian_barang ?></td>
                      <td scope="row"><?php echo $fisik_barang ?></td>
                      <td scope="row"><?php echo $spesifikasi ?></td>
                      <td scope="row"><?php echo $jumlah_barang ?></td>
                      <td scope="row"><?php echo $unit_mutasi ?></td>
                      <td scope="row"><?php echo $no_barang ?></td>
                      <td scope="row"><?php echo $nama_pengelola ?></td>
                      <td scope="row"><?php echo $status_pengelola ?></td>
                      <td scope="row"><?php echo $nama_penerima ?></td>
                      <td scope="row"><?php echo $status_penerima ?></td>
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
