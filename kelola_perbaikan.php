<?php
session_start();

if (!isset($_SESSION['level'])) {
    header("location: login.php?pesan=gagal");
    exit();
}

if ($_SESSION['level'] == "kalab") {
    $headerFile = "inc_header_kalab.php"; 
} else if ($_SESSION['level'] == "asistenlab") {
    $headerFile = "inc_header_asist.php"; 
}

$currentPage = 'kelola_perbaikan';
include($headerFile);

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'delete1') {
    $no_perbaikan = isset($_GET['no_perbaikan']) ? $_GET['no_perbaikan'] : '';

    $sql1 = "DELETE FROM perbaikan WHERE no_perbaikan = ?";
    $stmt1 = mysqli_prepare($koneksi, $sql1);

    if ($stmt1) {
        mysqli_stmt_bind_param($stmt1, "s", $no_perbaikan);

        try { 
            $result1 = mysqli_stmt_execute($stmt1);
            if ($result1) {
                $sukses1 = "Berhasil hapus data";
            } else {
                $error1 = "Gagal melakukan delete data: " . mysqli_error($koneksi);
            }
        } catch (mysqli_sql_exception $e) {
            $error2 = "Gagal menghapus data perbaikan: " . $e->getMessage();
        }

        mysqli_stmt_close($stmt1);
    } else {
        $error1 = "Failed to prepare the delete statement";
    }
}
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Kelola Perbaikan Barang</span>
    </div>
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Riwayat Perbaikan Barang</h5>
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
                                <a href="tambah_perbaikan.php"><button type="button" class="btn btn-primary">Tambahkan Perbaikan</button></a>
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
                                    <th scope="col">Tanggal Perbaikan</th>
                                    <th scope="col">Keterangan Perbaikan</th>
                                    <th scope="col">Status Perbaikan</th>
                                    <th scope="col">Tanggal Selesai</th>
                                    <th scope="col">Edit Data</th>
                                    <th scope="col">Hapus Data</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql2 = "SELECT * FROM perbaikan
                                    INNER JOIN barang ON perbaikan.no_barang = barang.no_barang
                                    ORDER BY perbaikan.no_perbaikan ASC";

                            $q2 = mysqli_query($koneksi, $sql2);
                            while ($r2 = mysqli_fetch_array($q2)) {
                                $no_perbaikan = $r2['no_perbaikan'];
                                $no_barang = $r2['no_barang'];
                                $uraian_barang = $r2['uraian_barang'];
                                $fisik_barang = $r2['fisik_barang'];
                                $tanggal_perbaikan = $r2['tanggal_perbaikan'];
                                $keterangan_perbaikan = $r2['keterangan_perbaikan'];
                                $status_perbaikan = $r2['status_perbaikan'];
                                $tanggal_perbaikan_selesai = $r2['tanggal_perbaikan_selesai'];
                            ?>
                            <tr>
                                <th scope="row"><?php echo $no_perbaikan ?></th>
                                <td scope="row"><?php echo $no_barang ?></td>
                                <td scope="row"><?php echo $uraian_barang ?></td>
                                <td scope="row"><?php echo $fisik_barang ?></td>
                                <td scope="row">
                                <?php echo ($tanggal_perbaikan != '0000-00-00') ? $tanggal_perbaikan : "-"; ?>
                                </td>
                                <td scope="row"><?php echo $keterangan_perbaikan ?></td>
                                <td scope="row"><?php echo $status_perbaikan ?></td>
                                <td scope="row">
                                    <?php echo ($tanggal_perbaikan_selesai != '0000-00-00') ? $tanggal_perbaikan_selesai : "-"; ?>
                                </td>
                                <td scope="row">
                                    <a href="edit_perbaikan.php?op=edit&no_perbaikan=<?php echo $no_perbaikan; ?>">
                                        <button type="button" class="btn btn-sm btn-warning">Edit Perbaikan</button>
                                    </a>
                                </td>
                                <td scope="row">
                                    <a href="kelola_perbaikan.php?op=delete1&no_perbaikan=<?php echo $no_perbaikan; ?>"
                                        onclick="return confirm('Ingin menghapus data perbaikan?')">
                                        <button type="button" class="btn btn-sm btn-danger">Hapus Perbaikan</button>
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
</section>
    <?php
    include("inc_footer.php");
    ?>
</body>
</html>
