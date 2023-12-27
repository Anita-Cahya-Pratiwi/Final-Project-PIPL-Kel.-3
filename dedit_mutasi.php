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

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'delete') {
    $no_mutasi = isset($_GET['no_mutasi']) ? $_GET['no_mutasi'] : '';

    // Update keterangan_barang
    $updateKeteranganQuery = "UPDATE barang SET keterangan_barang = 'OPERASIONAL' WHERE no_barang = (SELECT no_barang FROM mutasi_aset WHERE no_mutasi = ?)";
    $updateKeteranganStmt = mysqli_prepare($koneksi, $updateKeteranganQuery);

    if ($updateKeteranganStmt) {
        mysqli_stmt_bind_param($updateKeteranganStmt, "s", $no_mutasi);

        try {
            $updateResult = mysqli_stmt_execute($updateKeteranganStmt);
            if ($updateResult) {
                $sukses = "Berhasil menghapus mutasi, barang kembali menjadi operasional";

                $deleteQuery = "DELETE FROM mutasi_aset WHERE no_mutasi = ?";
                $deleteStmt = mysqli_prepare($koneksi, $deleteQuery);

                if ($deleteStmt) {
                    mysqli_stmt_bind_param($deleteStmt, "s", $no_mutasi);

                    try {
                        $result = mysqli_stmt_execute($deleteStmt);
                        if (!$result) {
                            $error = "Gagal melakukan delete data: " . mysqli_stmt_error($deleteStmt);
                        }
                    } catch (mysqli_sql_exception $e) {
                        $error = "Gagal menghapus data pemindahan: " . $e->getMessage();
                    }

                    mysqli_stmt_close($deleteStmt);
                } else {
                    $error = "Failed to prepare the delete statement";
                }
            } else {
                $error = "Gagal update keterangan_barang: " . mysqli_stmt_error($updateKeteranganStmt);
            }
        } catch (mysqli_sql_exception $e) {
            $error = "Gagal update keterangan_barang: " . $e->getMessage();
        }

        mysqli_stmt_close($updateKeteranganStmt);
    } else {
        $error = "Failed to prepare the update statement";
    }
}


?>

  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Edit Mutasi Aset</span>
    </div>
    <div class="main-content">
    <div class="mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Aset Termutasi</h5>
        </div>
        <div class="card-body">
            <?php
                if (isset($_GET['success'])) {
                $success = urldecode($_GET['success']);
            ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success ?>
            </div>
            <?php
            }
            ?>
           <?php if (isset($sukses)) : ?>
                <div class="alert alert-success" role="alert">
                    <?= $sukses ?>
                </div>
            <?php elseif (isset($error)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>
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
                  <th scope="col" colspan="2">Tindakan</th>
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
                while ($r2 = mysqli_fetch_array($q2)) {
                    $no_mutasi  = $r2['no_mutasi'];
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
                      <th scope="row"><?php echo $no_mutasi?></th>
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
                    <td scope="row">
                        <a href="edit_mutasi.php?op=edit&no_mutasi=<?php echo $no_mutasi; ?>">
                            <button type="button" class="btn btn-sm btn-warning">Edit Mutasi</button>
                        </a>
                    </td>
                    <td scope="row">
                        <a href="dedit_mutasi.php?op=delete&no_mutasi=<?php echo $no_mutasi; ?>"
                            onclick="return confirm('Ingin menghapus data mutasi?')">
                            <button type="button" class="btn btn-sm btn-danger">Hapus Mutasi</button>
                        </a>
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
