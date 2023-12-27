<?php
session_start();

$currentPage = 'kelola_data_barang';

include ('inc_header_admin.php');

$op = isset($_GET['op']) ? $_GET['op'] : "";

if ($op == 'delete') {
    $no_barang = isset($_GET['no_barang']) ? $_GET['no_barang'] : '';

    if ($no_barang == '') {
        $error = "Data tidak ditemukan";
    } else {
        $sql = "DELETE FROM barang WHERE no_barang = ?";
        $stmt = mysqli_prepare($koneksi, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $no_barang);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $sukses = "Berhasil hapus data";
            } else {
                $error = "Gagal melakukan delete data: " . mysqli_error($koneksi);
            }

            mysqli_stmt_close($stmt);
        } else {
            $error = "Failed to prepare the delete statement";
        }
    }
}

if ($op == 'delete1') {
    $no_pengadaan = isset($_GET['no_pengadaan']) ? $_GET['no_pengadaan'] : '';

    if ($no_pengadaan == '') {
        $error1 = "Data tidak ditemukan";
    } else {
        // Check if there are related records in the barang table
        $sql_check_barang = "SELECT COUNT(*) FROM barang WHERE no_pengadaan = ?";
        $stmt_check_barang = mysqli_prepare($koneksi, $sql_check_barang);

        if ($stmt_check_barang) {
            mysqli_stmt_bind_param($stmt_check_barang, "s", $no_pengadaan);
            mysqli_stmt_execute($stmt_check_barang);
            mysqli_stmt_bind_result($stmt_check_barang, $count_related_barang);
            mysqli_stmt_fetch($stmt_check_barang);
            mysqli_stmt_close($stmt_check_barang);

            if ($count_related_barang > 0) {
                // There are related records in barang, cannot delete
                $error1 = "Tidak dapat menghapus. Terdapat data terkait di tabel barang.";
            } else {
                // No related records in barang, proceed with deletion
                $sql1 = "DELETE FROM pengadaan WHERE no_pengadaan = ?";
                $stmt1 = mysqli_prepare($koneksi, $sql1);

                if ($stmt1) {
                    mysqli_stmt_bind_param($stmt1, "s", $no_pengadaan);
                    $result1 = mysqli_stmt_execute($stmt1);

                    if ($result1) {
                        $sukses1 = "Berhasil hapus data";
                    } else {
                        $error1 = "Gagal melakukan delete data: " . mysqli_error($koneksi);
                    }

                    mysqli_stmt_close($stmt1);
                } else {
                    $error1 = "Gagal menyiapkan pernyataan delete";
                }
            }
        } else {
            $error1 = "Gagal menyiapkan pernyataan check barang";
        }
    }
}


$sqli = "SELECT * FROM pengadaan
ORDER BY no_pengadaan ASC";

$resulti = mysqli_query($koneksi, $sqli);
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Kelola Data Barang</span>
    </div>
    <div class="main-content">
        <div class="mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Data Barang</h5>
                </div>
                <?php if (isset($sukses) && $sukses): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php elseif (isset($error) && $error): ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo $error;?>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                <div class="row">
                <div class="col-md-4">
                    <td scope="row">
                        <a href="tambah_barang.php"><button type="button" class="btn btn-primary">Tambah Barang</button></a>
                    </td>
                </div>
                </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="barang">
                            <tbody>
                                <?php
                                $sql2 = "SELECT * FROM barang
                                        INNER JOIN ruang_lab ON barang.no_ruang_kib = ruang_lab.no_ruang_kib
                                        INNER JOIN pengadaan ON barang.no_pengadaan = pengadaan.no_pengadaan
                                        ORDER BY barang.no_barang ASC";

                                $q2 = mysqli_query($koneksi, $sql2);

                                $allItems = [];

                                while ($r2 = mysqli_fetch_array($q2)) {
                                    $itemData = [
                                        'no_barang' => $r2['no_barang'],
                                        'kode_bmn' => $r2['kode_bmn'],
                                        'uraian_barang' => $r2['uraian_barang'],
                                        'nup' => $r2['nup'],
                                        'kode_internal' => $r2['kode_internal'],
                                        'fisik_barang' => $r2['fisik_barang'],
                                        'spesifikasi' => $r2['spesifikasi'],
                                        'sumber_anggaran' => $r2['sumber_anggaran'],
                                        'sat' => $r2['sat'],
                                        'nilai' => $r2['nilai'],
                                        'kondisi' => $r2['kondisi'],
                                        'tercatat' => $r2['tercatat'],
                                        'keterangan_barang' => $r2['keterangan_barang'],
                                        'unit_kelola' => $r2['unit_kelola'],
                                        'no_surat_pengadaan' => $r2['no_surat_pengadaan'],
                                        'gambar' => $r2['gambar']
                                    ];
                                    $allItems[] = $itemData;
                                ?>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="pagination-container" id="pagination-container"></div>
                    </div>
                </div>
            </div>
        </div>
    <div class="main-content">
    <div class="mx-auto">
        <div class="card">
        <div class="card-header">
            <h5 class="card-title">Data Pengadaan</h5>
        </div>
        <?php if (isset($sukses1) && $sukses1): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php elseif (isset($error1) && $error1): ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo $error;?>
                    </div>
                <?php endif; ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No Pengadaan</th>
                            <th scope="col">No Surat Pengadaan</th>
                            <th scope="col">Tanggal Pengadaan</th>
                            <th scope="col">Tahun Pengadaan</th>
                            <th scope="col">Jumlah Barang</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Keterangan Pengadaan</th>
                            <th scope="col">Dokumen Scan</th>
                            <th scope="col">Edit Data</th>
                            <th scope="col">Hapus Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($r2 = mysqli_fetch_array($resulti)) {
                            $no_pengadaan = $r2['no_pengadaan'];
                            $no_surat_pengadaan = $r2['no_surat_pengadaan'];
                            $tanggal_pengadaan = $r2['tanggal_pengadaan'];
                            $tahun_pengadaan = $r2['tahun_pengadaan'];
                            $jumlah_barang = $r2['jumlah_barang'];
                            $satuan = $r2['satuan'];
                            $keterangan_pengadaan = $r2['keterangan_pengadaan'];
                            $dokumen_scan = $r2['dokumen_scan'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $no_pengadaan ?></th>
                                <td scope="row"><?php echo $no_surat_pengadaan ?></td>
                                <td scope="row"><?php echo $tanggal_pengadaan ?></td>
                                <td scope="row"><?php echo $tahun_pengadaan ?></td>
                                <td scope="row"><?php echo $jumlah_barang ?></td>
                                <td scope="row"><?php echo $satuan ?></td>
                                <td scope="row"><?php echo $keterangan_pengadaan ?></td>
                                <td scope="row"><?php echo $dokumen_scan ?></td>
                                <td scope="row">
                                    <a href="edit_pengadaan.php?op=edit1&no_pengadaan=<?php echo $no_pengadaan; ?>">
                                        <button type="button" class="btn btn-sm btn-warning">Edit Pengadaan</button>
                                    </a>
                                </td>
                                <td scope="row">
                                    <a href="kelola_data_barang.php?op=delete1&no_pengadaan=<?php echo $no_pengadaan; ?>"
                                        onclick="return confirm('Ingin menghapus data pengadaan?')">
                                        <button type="button" class="btn btn-sm btn-danger">Hapus Pengadaan</button>
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
</div>
    </div>
</section>
<script>
    const itemsPerPage = 25; 
    const allItems = <?php echo json_encode($allItems); ?>; 

    let currentPage = 1;

    function displayItems() {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const itemsToShow = allItems.slice(startIndex, endIndex);

        const tableBody = document.getElementById('barang');
        tableBody.innerHTML = '';

        const headerRow = document.createElement('tr');
            headerRow.innerHTML = 
                `<th scope="col">No Barang</th>
                <th scope="col">Kode BMN</th>
                <th scope="col">Uraian Barang</th>
                <th scope="col">NUP</th>
                <th scope="col">Kode Internal</th>
                <th scope="col">Fisik Barang</th>
                <th scope="col">Spesifikasi</th>
                <th scope="col">Sumber Anggaran</th>
                <th scope="col">SAT</th>
                <th scope="col">Nilai</th>
                <th scope="col">Kondisi</th>
                <th scope="col">Tercatat</th>
                <th scope="col">Keterangan Barang</th>
                <th scope="col">Unit Kelola</th>
                <th scope="col">No Surat Pengadaan</th>
                <th scope="col">Gambar</th>
                <th scope="col">Edit Data</th>
                <th scope="col">Hapus Data</th>`;

        tableBody.appendChild(headerRow);
        itemsToShow.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = 
                `<td>${item.no_barang}</td>
                <td>${item.kode_bmn}</td>
                <td>${item.uraian_barang}</td>
                <td>${item.nup}</td>
                <td>${item.kode_internal}</td>
                <td>${item.fisik_barang}</td>
                <td>${item.spesifikasi}</td>
                <td>${item.sumber_anggaran}</td>
                <td>${item.sat}</td>
                <td>${item.nilai}</td>
                <td>${item.kondisi}</td>
                <td>${item.tercatat}</td>
                <td>${item.keterangan_barang}</td>
                <td>${item.unit_kelola}</td>
                <td>${item.no_surat_pengadaan}</td>
                <td><img src="${item.gambar}" alt="Image" style="max-width: 80px; max-height: 80px;"></td>
                <td scope="row">
                <a href="edit_barang.php?op=edit&no_barang=${item.no_barang}"><button type="button" class="btn btn-warning">Edit Barang</button></a>
                </td>
                <td scope="row">
                <a href="kelola_data_barang.php?op=delete&no_barang=${item.no_barang}" onclick="return confirm('Ingin menghapus data?')"><button type="button" class="btn btn-danger">Hapus Barang</button></a>
                </td>`
            tableBody.appendChild(row);
        });
    }

    function updatePagination() {
        const totalPages = Math.ceil(allItems.length / itemsPerPage);
        const paginationContainer = document.getElementById('pagination-container');
        paginationContainer.innerHTML = 'Halaman :';

        const paginationList = document.createElement('ul');
        paginationList.classList.add('pagination');

        for (let i = 1; i <= totalPages; i++) {
            const listItem = document.createElement('li');
            if (i === currentPage) {
                listItem.innerHTML = '<button class="active">' + i + '</button>';
            } else {
                listItem.appendChild(createPaginationButton(i));
            }
            paginationList.appendChild(listItem);
        }

        paginationContainer.appendChild(paginationList);
    }

    function createPaginationButton(page) {
        const button = document.createElement('button');
        button.textContent = page;
        button.onclick = function () {
            currentPage = page;
            displayItems();
            updatePagination();
        };
        return button;
    }

    displayItems();
    updatePagination();
</script>
<?php
include("inc_footer.php");
?>
</body>

</html>
