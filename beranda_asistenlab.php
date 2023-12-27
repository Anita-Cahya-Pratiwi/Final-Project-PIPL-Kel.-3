<?php
session_start();

if ($_SESSION['level'] != "asistenlab") {
  header("location: login.php?pesan=gagal");
  exit();
}

$currentPage = 'beranda_asistenlab';
include("inc_header_asist.php");

?>

  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Beranda</span>
    </div>
    <div class="main-content">
      <h2>Selamat Datang di Halaman Beranda Inventori Lab Komputer UMRAH</h2>
      <p>Kampus UMRAH Senggarang merupakan Kampus yang saat ini menjadi Kampus Kedua UMRAH. Kampus yang terletak sejauh 24km dari pusat kota Tanjungpinang ini meliputi gedung UPA-TIK dan Perpustakaan, FT, FIKP, Lab Komputer, Auditorium, Masjid dan Kantin. 
        Dahulunya Kampus UMRAH Senggarang merupakan kampus utama tetapi telah dipindahkan ke Dompak sehingga hanya ada 2 fakultas pada kampus ini. Kampus dengan Luas sekitar 10 ha ini tampak jelas dari Laut Tanjungpinang. 
        Untuk menuju Kampus Senggarang bisa melalui bus UMRAH dari Pamedan dan Terminal Bintan Centre, selain itu bisa juga melalui jalur laut dari Pelantar 1 Tanjungpinang.
        di Lahan Kampus yang awalnya dibangun untuk Politeknik oleh Pemprov Riau ini berdiri megah 2 Gedung Fakultas dan Gedung UPA-TIK untuk memberikan kenyamanan bagi mahasiswa, tamu-tamu yang berkunjung ke UMRAH, Masjid yang bisa digunakan untuk sarana ibadah warga UMRAH dan Masyarakat Sekitar. 
        Kampus yang beratap biru ini merupakan bagian yang tak terpisahkan dari Pusat Pemerintahan Kota Tanjungpinang, Kawasan Senggarang.</p>
    </div>
  </section>
  <?php
  include("inc_footer.php");
  ?>
</body>
</html>
