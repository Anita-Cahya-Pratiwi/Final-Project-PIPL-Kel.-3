<?php
session_start();

$currentPage = 'dpengembalian_biasa';

if (!isset($_SESSION['level'])) {
    header("location: login.php?pesan=gagal");
    exit();
  }

include("inc_header_mahasiswa.php");
?>

  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Pengembalian</span>
    </div>
    <div class="main-content">
    <div class="mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Pengembalian</h5>
        </div>
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
                  <th scope="col">Status Pengembalian</th>
                  <th scope="col">Waktu Pengembalian</th>
                </tr>
            </thead>
            <tbody>
              <?php
                $sql2 = "SELECT * FROM peminjaman_biasa
                INNER JOIN barang ON peminjaman_biasa.no_barang = barang.no_barang
                INNER JOIN penerima ON peminjaman_biasa.id_penerima = penerima.id_penerima
                LEFT JOIN user ON peminjaman_biasa.id_penerima = user.username
                WHERE penerima.id_penerima = ? AND status_peminjaman_biasa = 'selesai'
                ORDER BY no_peminjaman_biasa ASC";

                $username = $_SESSION['username'];
                $stmt = mysqli_prepare($koneksi, $sql2);
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                
                $result = mysqli_stmt_get_result($stmt);
                
                while ($r2 = mysqli_fetch_array($result)) {
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
                    $waktu_pengembalian_biasa = $r2['waktu_pengembalian_biasa'];
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
                    <td scope="row"><?php echo $status_peminjaman_biasa ?></td>
                    <td scope="row"><?php echo $waktu_pengembalian_biasa ?></td>                   
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
