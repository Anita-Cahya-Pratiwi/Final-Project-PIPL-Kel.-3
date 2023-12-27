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

$itemId = isset($_GET['id']) ? $_GET['id'] : 0;

$sql1 = "SELECT * FROM mutasi_aset 
    INNER JOIN pengelola ON mutasi_aset.id_pengelola = pengelola.id_pengelola
    INNER JOIN penerima ON mutasi_aset.id_penerima = penerima.id_penerima
    WHERE no_internal = '$itemId'";
    $result1 = mysqli_query($koneksi, $sql1);
    $item1 = mysqli_fetch_assoc($result1);

    function formatTanggalIndonesia($tanggal) {
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int)$split[1] - 1] . ' ' . $split[0];
    }
    
    $tanggal_formatted = formatTanggalIndonesia($item1['tanggal_mutasi']);
?>

<style>
.surat{
    font-family: 'Times New Roman', Times, serif;
    background-color: #ccc;
    font-size: 20px;
    width: 21cm;
    height: 29.7cm;
    margin: 0 auto;
}

.rangkasurat {
    width: 100%;
    margin: 0 auto;
    background-color: #fff;
    height: fit-content;
    padding: 20px;
}

table {
    border-bottom: 5px solid #000;
    width: 100%;
    padding: 2px;
}

.tengah {
    text-align: center;
    line-height: 5px;
    padding-right: 40px;
}

.logo-container img {
    width: 120px;
    margin-left: 40px;
    padding-left: 10px;
    padding-top: 0px;
    padding-bottom: 40px;
    padding-right: 0px;
}

.isi {
    font-size: 13px;
    padding-left: 40px;
    padding-right: 40px;
}

@media print {
    @page {
        size: A4;
    }

    .surat {
        width: 21cm;
        height: 29.7cm;
        margin-left: 40px;
        font-family: 'Times New Roman', Times, serif;
        background-color: #ccc;
        font-size: 20px;
    }

    .rangkasurat {
        width: 100%;
        background-color: #fff;
        padding: 20px;
    }

    table {
        border-bottom: 5px solid #000;
        width: 100%;
        padding: 2px;
    }

    .tengah {
        text-align: center;
        line-height: 5px;
        padding-right: 40px;
    }

    .logo-container img {
        width: 120px;
        margin-left: 40px;
        padding-left: 10px;
        padding-top: 0px;
        padding-bottom: 40px;
        padding-right: 0px;
    }

    .isi {
        font-size: 16px;
        padding-left: 40px;
        padding-right: 40px;
    }
    .sidebar {
        display: none;
    }
    .home-section .home-content {
        display: none;
    }
    .home-section .main-content {
        margin-left: -120px;
    }
}
</style>
<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Unduh Mutasi Aset</span>
    </div>
    <div class="main-content">
            <div class="surat">
                <div class="rangkasurat">
                    <table>
                        <tr>
                            <td class="logo-container">
                                <img src="https://upload.wikimedia.org/wikipedia/id/9/96/Lambang_Universitas_Maritim_Raja_Ali_Haji.png" alt="Logo">
                            </td>
                            <td class="tengah" >
                                <h4>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</h4>
                                <p><b>UNIVERSITAS MARITIM RAJA ALI HAJI<b></p>
                                <p><b>LABORATORIUM KOMPUTER</b></p>
                                <p><b>FAKULTAS TEKNIK</b></p>
                                <h6 style = "font-size: 13px;">Jalan Politeknik Senggarang. Telp. (0771) 4500097; Fax. (0771) 4500097</h6>
                                <h6 style = "font-size: 13px;">PO.BOX 155 – Tanjungpinang 29111</h6>
                                <h6 style = "font-size: 13px;">Website : http://ft.umrah.ac.id e-mail : ft@umrah.ac.id</h6>
                            </td>
                        </tr>
                    </table>
                    <hr style = "margin-top: 5px; padding-top:2px;">
                    <div class="isi">                      
                        <p align = "right">Tanjungpinang, <?php echo $tanggal_formatted; ?></p>
                        <p align = "left">No Internal: <?php echo $item1['no_internal'];?></p>
                        <h5 align = "center" style="padding-top: 50px;">BORANG MUTASI ASET LABORATORIUM KOMPUTER</h5>
                        <p align = "justify" style="padding-top: 50px;">Tanggal <?php echo $tanggal_formatted; ?> dilakukan mutasi aset Laboratorium Komputer dari posisi dibawah
                        pengelolaan Lab. Komputer Teknik Informatika ke unit lain, dengan spesifikasi data barang sebagai berikut:</p> 
                        <div class="table-responsive">
                            <table class="table table-bordered">
                            <thead>
                            <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Uraian Barang</th>
                            <th scope="col">Fisik Barang</th>
                            <th scope="col">Spesifikasi</th>
                            <th scope="col">Jumlah Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                               $sql2 = "SELECT *
                               FROM mutasi_aset
                               INNER JOIN barang ON mutasi_aset.no_barang = barang.no_barang
                               WHERE mutasi_aset.no_internal = ? 
                               ORDER BY no_mutasi ASC";
                           
                                $stmt = mysqli_prepare($koneksi, $sql2);
                                mysqli_stmt_bind_param($stmt, "s", $itemId);
                                mysqli_stmt_execute($stmt);
                                $result2 = mysqli_stmt_get_result($stmt);
                                
                                $urut = 1;
                                while ($r2 = mysqli_fetch_array($result2)) {
                                    $uraian_barang_barang = $r2['uraian_barang'];
                                    $fisik_barang = $r2['fisik_barang'];
                                    $spesifikasi = $r2['spesifikasi'];
                                    $jumlah_barang_barang = $r2['jumlah_barang'];
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $urut++ ?></th>
                                        <td><?php echo $uraian_barang_barang ?></td>
                                        <td><?php echo $fisik_barang ?></td>
                                        <td><?php echo $spesifikasi ?></td>
                                        <td><?php echo $jumlah_barang_barang ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>  
                            </table>                           
                            <p>Di mutasikan pengelolaan dan tanggungjawabnya ke Unit <?php echo $item1['unit_mutasi'];?></p>
                            <table style="border-bottom: none; ">
                            <tr>
                            <td style="text-align: center; width:200px; padding-top: 80px;">Menyerahkan</td>
                            <td style="text-align: center; width:200px; padding-top: 80px;">Menerima</td>
                            </tr>
                            </table>
                            <div>
                            <!--<table class="table table-bordered"> pengukuran titik tengah by anita-->
                            <table style="border-bottom: none">
                            <tr>
                            <td style="text-align: center; width:200px; padding : 20px; padding-top: 100px;"><?php echo $item1['nama_pengelola'];?></td>
                            <td style="text-align: center; width:200px; padding : 20px; padding-top: 100px;"><?php echo $item1['nama_penerima']; ?></td>
                            </tr>
                            </table>
                            <!--</table>-->
                            </div>
                            <div>                            
                            <table style="border-bottom: none">
                            <tr>
                            <td style="text-align: center; width:200px; padding-top: 0px;"><?php echo $item1['status_pengelola']; ?></td>
                            <td style="text-align: center; width:200px; padding-top: 0px;"><?php echo $item1['status_penerima']; ?></td>
                            </tr>
                            </table>
                            </div>
                            <div>                            
                            <table style="border-bottom: none">
                            <tr>
                            <td style="text-align: center; height:150px; padding-top: 0px;"></td>
                            <td style="text-align: center; height:150px; padding-top: 0px;"></td>
                            </tr>
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
<script>
window.onload = function() {
    window.print();
}
</script>
</body>
</html>
