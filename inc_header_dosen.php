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
      <li class="<?php echo ($currentPage == 'beranda_dosen') ? 'active' : ''; ?>">
        <a href="beranda_dosen.php">
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name ">Beranda</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="beranda_dosen.php">Beranda</a></li>
        </ul>
      </li>
      <li class="<?php echo ($currentPage == 'daftar_barang2') ? 'active' : ''; ?>">
        <a href="daftar_barang2.php">
          <i class='bx bx-collection' ></i>
          <span class="link_name ">Daftar Barang</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="daftar_barang2.php">Daftar Barang</a></li>
        </ul>
      </li>
      <li class="<?php echo ($currentPage == 'dpeminjaman_khusus') ? 'active' : ''; ?>">
        <a href="dpeminjaman_khusus.php">
          <i class='bx bx bx-import'></i>
          <span class="link_name">Peminjaman</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name " href="dpeminjaman_khusus.php">Peminjaman</a></li>
        </ul>
      </li>
      <li class="<?php echo ($currentPage == 'dpengembalian_khusus') ? 'active' : ''; ?>">
        <a href="dpengembalian_khusus.php">
          <i class='bx bx bx-export'></i>
          <span class="link_name">Pengembalian</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name " href="dpengembalian_khusus.php">Pengembalian</a></li>
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
                $profile_name = "Dosen";
            }
          } else {
              $profile_name = "Guest";
          }
          ?>
          <div class="name-job">
              <a href="profil_admin.php">
                  <div class="profile_name"><?php echo $profile_name; ?></div>
                  <div class="job">Dosen</div>
              </a>
          </div>         
        <a href="logout.php"><i class='bx bx-log-out' id="logout"></i></a>
      </div>
    </li>
  </ul>
  </div>