<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Inventori Lab Komputer UMRAH </title>
  <link rel="stylesheet" href="styles.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="sidebar close">
    <div class="logo-details">
      <img src="https://cdn-icons-png.flaticon.com/512/3557/3557901.png" width="50px" height="50px">
      <span class="logo_name">Inventori Lab Komputer UMRAH</span>
    </div>
    <ul class="nav-links">
      <li class = "<?php echo ($currentPage == 'beranda_admin') ? 'active' : ''; ?>">
        <a href="beranda_admin.php">
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name ">Beranda</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="beranda_admin.php">Beranda</a></li>
        </ul>
      </li>
      <li class ="<?php echo ($currentPage == 'daftar_barang1') ? 'active' : ''; ?>">
        <a href="daftar_barang1.php">
          <i class='bx bx-collection' ></i>
          <span class="link_name ">Daftar Barang</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="daftar_barang1.php">Daftar Barang</a></li>
        </ul>
      </li>
      <li class ="<?php echo ($currentPage == 'kelola_data_barang') ? 'active' : ''; ?>">
        <a href="kelola_data_barang.php">
          <i class='bx bx-data'></i>
          <span class="link_name ">Kelola Data Barang</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="kelola_data_barang.php">Kelola Data Barang</a></li>
        </ul>
      </li>
      <li class ="<?php echo ($currentPage == 'kelola_pindah_barang') ? 'active' : ''; ?>">
        <a href="kelola_pindah_barang.php">
          <i class='bx bx-transfer'></i>
          <span class="link_name ">Kelola Pemindahan Barang</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="kelola_pindah_barang.php">Kelola Pemindahan Barang</a></li>
        </ul>
      </li>
      <li class = "<?php echo ($currentPage == 'kelola_mutasi') ? 'active' : ''; ?>">
        <div class="iocn-link">
          <a href="kelola_mutasi.php">
            <i class='bx bx-edit-alt' ></i>
            <span class="link_name ">Kelola Mutasi Aset</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="kelola_mutasi.php">Kelola Mutasi Aset</a></li>
          <li class = "<?php echo ($currentPage == 'mutasi_aset') ? 'active' : ''; ?>"><a href="mutasi_aset.php">Mutasi Aset</a></li>
          <li class = "<?php echo ($currentPage == 'edit_mutasi') ? 'active' : ''; ?>"><a href="dedit_mutasi.php">Edit Mutasi Aset</a></li>
          <li class = "<?php echo ($currentPage == 'unduh_mutasi') ? 'active' : ''; ?>"><a href="unduh_mutasi.php">Unduh Mutasi Aset</a></li>
        </ul>
      </li>
      <li class = "<?php echo ($currentPage == 'kelola_peminjaman') ? 'active' : ''; ?>">
        <a href="kelola_peminjaman.php">
          <i class='bx bx-export'></i>
          <span class="link_name ">Kelola Peminjaman</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="kelola_peminjaman.php">Kelola Peminjaman</a></li>
        </ul>
      </li>
      <li class ="<?php echo ($currentPage == 'kelola_pengembalian') ? 'active' : ''; ?>">
        <a href="kelola_pengembalian.php">
          <i class='bx bx-import'></i>
          <span class="link_name ">Kelola Pengembalian</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="kelola_pengembalian.php">Kelola Pengembalian</a></li>
        </ul>
      </li>
      <div class="profile-details">
          <div class="profile-content">
            <a href="profil_admin.php">
            <img src="https://cdn-icons-png.flaticon.com/512/9385/9385289.png" alt="profileImg">
            </a>
          </div>
          <?php
          require ('link_db.php');
          if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $sql_adm = "SELECT * FROM user WHERE username = '$username'";
            $result_adm = mysqli_query($koneksi, $sql_adm);
        
            if ($result_adm && mysqli_num_rows($result_adm) > 0) {
                $userData = mysqli_fetch_assoc($result_adm);
                $profile_name = $userData['nama'];
            } else {
                $profile_name = "Admin";
            }
        } else {
            $profile_name = "Guest";
        }
        ?>
          <div class="name-job">
              <a href="profil_admin.php">
                  <div class="profile_name"><?php echo $profile_name; ?></div>
                  <div class="job">Admin</div>
              </a>
          </div>         
        <a href="logout.php"><i class='bx bx-log-out' id="logout"></i></a>
      </div>
    </li>
  </ul>
  </div>