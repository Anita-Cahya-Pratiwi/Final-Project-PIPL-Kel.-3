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

$currentPage = 'kelola_peminjaman';
include($headerFile);

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'delete1') {
    $no_peminjaman_biasa = isset($_GET['no_peminjaman_biasa']) ? $_GET['no_peminjaman_biasa'] : '';

        $sql1 = "DELETE FROM peminjaman_biasa WHERE no_peminjaman_biasa = ?";
        $stmt1 = mysqli_prepare($koneksi, $sql1);

        if ($stmt1) {
            mysqli_stmt_bind_param($stmt1, "s", $no_peminjaman_biasa);
        
        try{ $result1 = mysqli_stmt_execute($stmt1);
            if ($result1) {
                $sukses1 = "Berhasil hapus data";
            } else {
                $error1 = "Gagal melakukan delete data: " . mysqli_error($koneksi);
            }
        }
        catch (mysqli_sql_exception $e) {
            $error1 = "Gagal menghapus data peminjaman: " . $e->getMessage();
        }

        mysqli_stmt_close($stmt1);
        } else {
            $error1 = "Failed to prepare the delete statement";
        }
}

if ($op == 'delete2') {
    $no_peminjaman_khusus = isset($_GET['no_peminjaman_khusus']) ? $_GET['$no_peminjaman_khusus'] : '';

        $sql2 = "DELETE FROM ruang_lab WHERE no_peminjaman_khusus = ?";
        $stmt2 = mysqli_prepare($koneksi, $sql2);

        if ($stmt2) {
            mysqli_stmt_bind_param($stmt2, "s", $no_peminjaman_khusus);

        try {$result2 = mysqli_stmt_execute($stmt2);
            if ($result2) {
                $sukses2 = "Berhasil hapus data";
            } else {
                $error2 = "Gagal melakukan delete data: " . mysqli_error($koneksi);
            }
        }
        catch (mysqli_sql_exception $e) {
            $error2 = "Gagal menghapus data peminjaman: " . $e->getMessage();
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
      <span class="text">Kelola Peminjaman Barang</span>
    </div>
    <div class="main-content">
    <div class="mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Peminjaman Mahasiswa</h5>
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
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead>
                <tr>
                <th scope="col">No. Peminjaman</th>
                  <th scope="col">Hari</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">NIM</th>
                  <th scope="col">Nama</th>
                  <th scope="col">No Barang</th>
                  <th scope="col">Uraian Barang</th>
                  <th scope="col">Fisik Barang</th>
                  <th scope="col">Waktu Peminjaman</th>
                  <th scope="col">Status Peminjaman</th>
                  <th scope="col" colspan="2">Persetujuan</th>
                </tr>
            </thead>
            <tbody>
              <?php
                $sql2 = "SELECT * FROM peminjaman_biasa
                INNER JOIN barang ON peminjaman_biasa.no_barang = barang.no_barang
                INNER JOIN penerima ON peminjaman_biasa.id_penerima = penerima.id_penerima
                WHERE status_peminjaman_biasa = 'Dalam proses peminjaman' OR status_peminjaman_biasa = 'Dipinjam' OR status_peminjaman_biasa = 'Ditolak'
                ORDER BY no_peminjaman_biasa ASC";

                $q2     = mysqli_query($koneksi, $sql2);
                while ($r2 = mysqli_fetch_array($q2)) {
                    $no_peminjaman_biasa  = $r2['no_peminjaman_biasa'];
                    $hari    = $r2['hari'];
                    $tanggal_peminjaman_biasa = $r2['tanggal_peminjaman_biasa'];
                    $id_penerima = $r2['id_penerima'];
                    $nama_penerima = $r2['nama_penerima']; 
                    $no_barang = $r2['no_barang'];
                    $uraian_barang = $r2['uraian_barang'];
                    $fisik_barang = $r2['fisik_barang'];
                    $waktu_peminjaman_biasa = $r2['waktu_peminjaman_biasa'];
                    $status_peminjaman_biasa = $r2['status_peminjaman_biasa'];
                  ?>
                    <tr>
                        <th scope="row"><?php echo $no_peminjaman_biasa ?></th>
                        <td scope="row"><?php echo $hari ?></td>
                        <td scope="row"><?php echo $tanggal_peminjaman_biasa ?></td>
                        <td scope="row"><?php echo $id_penerima ?></td>
                        <td scope="row"><?php echo $nama_penerima ?></td>
                        <td scope="row"><?php echo $no_barang ?></td>
                        <td scope="row"><?php echo $uraian_barang ?></td>
                        <td scope="row"><?php echo $fisik_barang ?></td>
                        <td scope="row"><?php echo $waktu_peminjaman_biasa ?></td>
                        <td scope="row" id="status_peminjaman_biasa<?php echo $no_peminjaman_biasa; ?>"><?php echo $status_peminjaman_biasa ?></td>
                        <?php
                        if ($status_peminjaman_biasa == "Dalam proses peminjaman") {
                            ?>
                            <td scope="row">
                                <button type="button" class="btn btn-sm btn-success approval-btn" data-id="<?php echo $no_peminjaman_biasa; ?>">Setujui</button>
                            </td>
                            <td scope="row">
                                <button type="button" class="btn btn-sm btn-danger rejection-btn" data-id="<?php echo $no_peminjaman_biasa; ?>">Tolak</button>
                            </td>
                            <?php
                        } else{
                            ?>
                            <td scope="row">
                                <button type="button" class="btn btn-sm btn-secondary">Setujui</button>
                            </td>
                            <td scope="row">
                                <button type="button" class="btn btn-sm btn-secondary">Tolak</button>
                            </td>
                            <?php
                        }
                        ?>
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
            <h5 class="card-title">Peminjaman Dosen</h5>
        </div>
            <?php if (isset($sukses2)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses2; ?>
                </div>
            <?php elseif (isset($error2)):  ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo $error2;?>
                </div>
            <?php endif; ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">No. Peminjaman</th>
                    <th scope="col">ID Penerima</th>
                    <th scope="col">Nama Penerima</th>
                    <th scope="col">Status Penerima</th> 
                    <th scope="col">Tanggal Peminjaman</th>
                    <th scope="col">No. Barang</th>
                    <th scope="col">Uraian Barang</th>
                    <th scope="col">Fisik Barang</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Jumlah Barang</th> 
                    <th scope="col">Unit Peminjaman</th>
                    <th scope="col">Keperluan</th>
                    <th scope="col">ID Pengelola</th>
                    <th scope="col">Nama Pengelola</th> 
                    <th scope="col">Status Pengelola</th>
                    <th scope="col">Status Peminjaman</th>
                    <th scope="col" colspan="2">Persetujuan</th>
                </tr>
            </thead>
            <tbody>
              <?php
                    $sql = "SELECT *
                    FROM peminjaman_khusus
                    INNER JOIN barang ON peminjaman_khusus.no_barang = barang.no_barang
                    INNER JOIN penerima ON peminjaman_khusus.id_penerima = penerima.id_penerima
                    INNER JOIN pengelola ON peminjaman_khusus.id_pengelola = pengelola.id_pengelola
                    WHERE peminjaman_khusus.status_peminjaman_khusus IN ('Dalam proses peminjaman', 'Dipinjam', 'Ditolak')
                    ORDER BY no_peminjaman_khusus ASC";

                $result     = mysqli_query($koneksi, $sql);

                while ($r = mysqli_fetch_array($result)) {
                    $no_peminjaman_khusus = $r['no_peminjaman_khusus'];
                    $id_penerima = $r['id_penerima'];
                    $nama_penerima = $r['nama_penerima'];  
                    $status_penerima = $r['status_penerima'];  
                    $tanggal_peminjaman_khusus = $r['tanggal_peminjaman_khusus'];
                    $no_barang = $r['no_barang'];
                    $uraian_barang = $r['uraian_barang'];                    
                    $fisik_barang = $r['fisik_barang']; 
                    $sat = $r['sat'];  
                    $jumlah_barang = $r['jumlah_barang'];
                    $unit_peminjaman_khusus = $r['unit_peminjaman_khusus'];
                    $keperluan = $r['keperluan'];
                    $id_pengelola = $r['id_pengelola'];
                    $nama_pengelola = $r['nama_pengelola'];
                    $status_pengelola = $r['status_pengelola'];  
                    $status_peminjaman_khusus = $r['status_peminjaman_khusus'];
                ?>
                  <tr>
                        <th scope="row"><?php echo $no_peminjaman_khusus ?></th>
                        <td scope="row"><?php echo $id_penerima ?></td>
                        <td scope="row"><?php echo $nama_penerima ?></td>
                        <td scope="row"><?php echo $status_penerima ?></td>
                        <td scope="row"><?php echo $tanggal_peminjaman_khusus ?></td>
                        <td scope="row"><?php echo $no_barang ?></td>
                        <td scope="row"><?php echo $uraian_barang ?></td>
                        <td scope="row"><?php echo $fisik_barang ?></td>
                        <td scope="row"><?php echo $sat ?></td>
                        <td scope="row"><?php echo $jumlah_barang ?></td>
                        <td scope="row"><?php echo $unit_peminjaman_khusus ?></td>
                        <td scope="row"><?php echo $keperluan ?></td>
                        <td scope="row"><?php echo $id_pengelola ?></td>
                        <td scope="row"><?php echo $nama_pengelola ?></td>
                        <td scope="row"><?php echo $status_pengelola ?></td>
                        <td scope="row" id="status_peminjaman_khusus<?php echo $no_peminjaman_khusus; ?>"><?php echo $status_peminjaman_khusus ?></td>
                        <?php
                        if ($status_peminjaman_khusus == "Dalam proses peminjaman") {
                            ?>
                            <td scope="row">
                                <button type="button" class="btn btn-sm btn-success approval-btn-khusus" data-id="<?php echo $no_peminjaman_khusus; ?>">Setujui</button>
                            </td>
                            <td scope="row">
                                <button type="button" class="btn btn-sm btn-danger rejection-btn-khusus" data-id="<?php echo $no_peminjaman_khusus; ?>">Tolak</button>
                            </td>
                            <?php
                        } else {
                            ?>
                            <td scope="row">
                                <button type="button" class="btn btn-sm btn-secondary" disabled>Setujui</button>
                            </td>
                            <td scope="row">
                                <button type="button" class="btn btn-sm btn-secondary" disabled>Tolak</button>
                            </td>
                            <?php
                        }
                        ?>
                        </tr>
                        <?php
                        }
                        ?>
                  </tr>
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
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script>
    $(document).ready(function () {
        $(".approval-btn").click(function () {
            var requestId = $(this).data("id");

            if (confirm("Apakah Anda yakin ingin menyetujui peminjaman ini?")) {
                $.ajax({
                    type: "POST",
                    url: "approval.php",
                    data: { id: requestId, action: "approve" },
                    success: function (response) {
                        $("#status_peminjaman_biasa" + requestId).text("Dipinjam");
                        location.reload();
                    },
                    error: function () {
                        alert("Error processing approval.");
                    }
                });
            }
        });

        $(".rejection-btn").click(function () {
            var requestId = $(this).data("id");

            if (confirm("Apakah Anda yakin ingin menolak peminjaman ini?")) {
                $.ajax({
                    type: "POST",
                    url: "rejection.php",
                    data: { id: requestId, action: "reject" },
                    success: function (response) {
                        $("#status_peminjaman_biasa" + requestId).text("Ditolak");
                        location.reload();
                    },
                    error: function () {
                        alert("Error processing rejection.");
                    }
                });
            }
        });

    $(".approval-btn-khusus").click(function () {
            var requestId = $(this).data("id");

            if (confirm("Apakah Anda yakin ingin menyetujui peminjaman ini?")) {
                $.ajax({
                    type: "POST",
                    url: "approval_khusus.php",
                    data: { id: requestId, action: "approve" },
                    success: function (response) {
                        $("#status_peminjaman_khusus" + requestId).text("Dipinjam");
                        location.reload();
                    },
                    error: function () {
                        alert("Error processing approval.");
                    }
                });
            }
    });

        $(".rejection-btn-khusus").click(function () {
            var requestId = $(this).data("id");

            if (confirm("Apakah Anda yakin ingin menolak peminjaman ini?")) {
                $.ajax({
                    type: "POST",
                    url: "rejection_khusus.php",
                    data: { id: requestId, action: "reject" },
                    success: function (response) {
                        $("#status_peminjaman_khusus" + requestId).text("Ditolak");
                        location.reload();
                    },
                    error: function () {
                        alert("Error processing rejection.");
                    }
                });
            }
        });
});
</script>
</body>
</html>
