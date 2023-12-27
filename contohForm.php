<?php
session_start();
include("link_db.php");
include("inc_header_admin.php");

if (isset($_POST['btn']) && isset($_POST['pilih'])) {
    $a = $_POST['pilih'];
    $jml = count($a);

    $no_internal = $_POST['no_internal'];
    $tanggal_mutasi = $_POST['tanggal_mutasi'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $unit_mutasi = $_POST['unit_mutasi'];
    $id_pengelola = $_POST['id_pengelola'];
    $id_penerima = $_POST['id_penerima'];

    $sql = $koneksi->prepare("INSERT INTO mutasi_aset (no_internal, tanggal_mutasi, jumlah_barang, unit_mutasi, no_barang, id_pengelola, id_penerima) VALUES (?, ?, ?, ?, ?, ?, ?)");

    for ($i = 0; $i < $jml; $i++) {
        $sql->bind_param("ssisiss", $no_internal, $tanggal_mutasi, $jumlah_barang, $unit_mutasi, $a[$i], $id_pengelola, $id_penerima);
        $sql->execute();
    }
    $sql->close();
}
?>

<section class="home-section">
<div class="main-content">
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Formulir Mutasi Aset</h5>
            </div>
            <div class="card-body" align="center"><b>Pilih checklist barang pada tabel terlebih dahulu</b></div>
            <div class="card-body">
                <form action="" method="post" id="formMutasi">
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqli = "SELECT * FROM barang
                                INNER JOIN ruang_lab ON barang.no_ruang_kib = ruang_lab.no_ruang_kib
                                INNER JOIN pengadaan ON barang.no_pengadaan = pengadaan.no_pengadaan
                                ORDER BY barang.no_barang ASC";
                                
                                $resulti = mysqli_query($koneksi, $sqli);

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
                                    <td scope="row" class="checkboxz">
                                        <input type="checkbox" name="pilih[]" value="<?php echo $no_barang; ?>">
                                        <label for="checkbox"><p><?php echo $no_barang; ?></p></label>
                                    </td>
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
                    <div class="mb-3 row">
                        <label for="no_internal" class="col-sm-2 col-form-label">No Internal</label>
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
                    <button type="submit" name = "btn" class="btn btn-primary">Simpan Data</button>
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