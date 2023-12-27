<?php
session_start();

$currentPage = 'dpeminjaman_khusus';

if (!isset($_SESSION['level'])) {
    header("location: login.php?pesan=gagal");
    exit();
  }

include("inc_header_dosen.php");
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Peminjaman</span>
    </div>
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Peminjaman</h5>
                </div>
                <div class="card-body">
                        <?php
                            if (isset($_GET['Message'])) {
                            $Message = urldecode($_GET['Message']);
                        ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $Message; ?>
                            </div>
                        <?php
                        }
                        ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                            <th scope="col">No. Peminjaman</th>
                            <th scope="col">ID Penerima</th>
                            <th scope="col">Nama Penerima</th>
                            <th scope="col">Status Penerima</th> 
                            <th scope="col">Tanggal Peminjaman</th>
                            <th scope="col">No Barang</th>
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
                            <th scope="col">Pengembalian</th>
                        </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql2 = "SELECT *
                                        FROM peminjaman_khusus
                                        INNER JOIN barang ON peminjaman_khusus.no_barang = barang.no_barang
                                        INNER JOIN penerima ON peminjaman_khusus.id_penerima = penerima.id_penerima
                                        INNER JOIN pengelola ON peminjaman_khusus.id_pengelola = pengelola.id_pengelola
                                        WHERE (peminjaman_khusus.id_penerima = ? AND peminjaman_khusus.status_peminjaman_khusus = 'Dipinjam') 
                                        OR (peminjaman_khusus.id_penerima = ? AND peminjaman_khusus.status_peminjaman_khusus = 'Dalam proses peminjaman') 
                                        OR (peminjaman_khusus.id_penerima = ? AND peminjaman_khusus.status_peminjaman_khusus = 'Ditolak')
                                        ORDER BY peminjaman_khusus.no_peminjaman_khusus ASC";

                                $username = $_SESSION['username'];
                                $stmt = mysqli_prepare($koneksi, $sql2);
                                mysqli_stmt_bind_param($stmt, "sss", $username, $username, $username);
                                mysqli_stmt_execute($stmt);

                                $result = mysqli_stmt_get_result($stmt);

                                while ($r2 = mysqli_fetch_array($result)) {
                                    $no_peminjaman_khusus = $r2['no_peminjaman_khusus'];
                                    $id_penerima = $r2['id_penerima'];
                                    $nama_penerima = $r2['nama_penerima'];  
                                    $status_penerima = $r2['status_penerima'];  
                                    $tanggal_peminjaman_khusus = $r2['tanggal_peminjaman_khusus'];
                                    $no_barang = $r2['no_barang'];
                                    $uraian_barang = $r2['uraian_barang'];                    
                                    $fisik_barang = $r2['fisik_barang']; 
                                    $sat = $r2['sat'];  
                                    $jumlah_barang = $r2['jumlah_barang'];
                                    $unit_peminjaman_khusus = $r2['unit_peminjaman_khusus'];
                                    $keperluan = $r2['keperluan'];
                                    $id_pengelola = $r2['id_pengelola'];
                                    $nama_pengelola = $r2['nama_pengelola'];
                                    $status_pengelola = $r2['status_pengelola'];  
                                    $status_peminjaman_khusus = $r2['status_peminjaman_khusus']; 
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
                                    <td scope="row"><?php echo $status_peminjaman_khusus ?></td>
                                        <?php
                                            if ($status_peminjaman_khusus == "Dipinjam") {
                                                ?>
                                                <td scope="row">
                                                <button type="button" class="btn btn-sm btn-success approval-btn-k" 
                                                    data-id="<?php echo $no_peminjaman_khusus; ?>" 
                                                    data-tanggal="<?php echo date('Y-m-d'); ?>" >
                                                    Kembalikan Barang
                                                </button>
                                                </td>
                                        <?php
                                            } else {?>
                                            <td scope="row">
                                            <button type="button" class="btn btn-sm btn-secondary">Kembalikan Barang</button>
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
    </div>
</section>

<?php
include("inc_footer.php");
?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(".approval-btn-k").click(function () {
    var requestId = $(this).data("id");
    var tanggalPengembalian = $(this).data("tanggal");

    if (confirm("Apakah Anda yakin ingin mengembalikan barang ini?")) {
        $.ajax({
            type: "POST",
            url: "kembalikank.php",
            data: {
                id: requestId,
                action: "approve",
                tanggal: tanggalPengembalian,
            },
            success: function (response) {
                if (response.success) {
                    $("#status_peminjaman_khusus" + requestId).text("Selesai");
                    location.reload(); 
                } else{ location.reload();}
            },
            error: function () {
                alert("Error processing approval.");
            }
        });
    }
});
</script>
</body>
</html>
