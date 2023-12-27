-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Des 2023 pada 16.41
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventori_lab`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `no_barang` int(10) NOT NULL,
  `kode_bmn` varchar(15) DEFAULT NULL,
  `uraian_barang` varchar(30) DEFAULT NULL,
  `nup` varchar(10) DEFAULT NULL,
  `kode_internal` varchar(30) DEFAULT NULL,
  `fisik_barang` varchar(50) DEFAULT NULL,
  `spesifikasi` varchar(50) DEFAULT NULL,
  `sumber_anggaran` varchar(150) NOT NULL,
  `sat` varchar(10) DEFAULT NULL,
  `nilai` varchar(30) DEFAULT NULL,
  `kondisi` varchar(100) DEFAULT NULL,
  `tercatat` varchar(15) DEFAULT NULL,
  `keterangan_barang` varchar(150) DEFAULT NULL,
  `no_ruang_kib` int(11) NOT NULL,
  `no_pengadaan` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`no_barang`, `kode_bmn`, `uraian_barang`, `nup`, `kode_internal`, `fisik_barang`, `spesifikasi`, `sumber_anggaran`, `sat`, `nilai`, `kondisi`, `tercatat`, `keterangan_barang`, `no_ruang_kib`, `no_pengadaan`, `gambar`) VALUES
(1, '2.0.2.3.12.27.1', 'Tool set', '1', 'LabTI/1.1.1.1/1', 'Crimping tool set', 'Crimping tools jaringan', 'FT 2023', 'buah', '100.000', 'Baik', 'TCT', 'OPERASIONAL', 10, 1, 'https://m.media-amazon.com/images/I/612QyexhYES._AC_UF894,1000_QL80_.jpg'),
(2, '2.0.2.3.12.27.1', 'Tool set', '2', 'LabTI/1.1.1.1/2', 'Crimping tool set', 'Crimping tools jaringan', 'FT 2023', 'buah', '100.000', 'Baik', 'TCT', 'OPERASIONAL', 10, 1, 'https://m.media-amazon.com/images/I/612QyexhYES._AC_UF894,1000_QL80_.jpg'),
(3, '2.0.2.3.12.27.1', 'Tool set', '3', 'LabTI/1.1.1.1/3', 'Crimping tool set', 'Crimping tools jaringan', 'FT 2023', 'buah', '100.000', 'Baik', 'TCT', 'OPERASIONAL', 10, 1, 'https://m.media-amazon.com/images/I/612QyexhYES._AC_UF894,1000_QL80_.jpg'),
(4, '2.0.2.3.12.27.1', 'Tool set', '4', 'LabTI/1.1.1.1/4', 'Crimping tool set', 'Crimping tools jaringan', 'FT 2023', 'buah', '100.000', 'Baik', 'TCT', 'OPERASIONAL', 10, 1, 'https://m.media-amazon.com/images/I/612QyexhYES._AC_UF894,1000_QL80_.jpg'),
(5, '2.0.2.3.12.27.1', 'Tool set', '5', 'LabTI/1.1.1.1/5', 'Crimping tool set', 'Crimping tools jaringan', 'FT 2023', 'buah', '100.000', 'Baik', 'TCT', 'OPERASIONAL', 10, 1, 'https://m.media-amazon.com/images/I/612QyexhYES._AC_UF894,1000_QL80_.jpg'),
(6, '2.0.2.3.12.26.2', 'Laptop', '1', 'Server/017/1', 'Acer Aspire A514 54G 32GF', 'ssd 512 gb, ram 8gb ddr4 3200hz, 2gb vga nvidia mx', 'FT 2020', 'buah', '6.700.000', 'Baik', 'ACC', 'OPERASIONAL', 17, 2, 'https://www.softcom.co.id/wp-content/uploads/2022/11/black.jpg'),
(7, '2.0.2.3.12.29.3', 'Monitor', '1', 'LabTI/2.2.2.2/1', 'ASUS ROG STIX SG49VQ', 'Curved 49 inc, 144 hz, FreeSync 2 HDR, DisplayHDR™', 'FT 2023', 'Unit', '19.950.000', 'Baik', 'ACC', 'TIDAK OPERASIONAL, termutasi', 17, 3, 'https://www.guru3d.com/data/publish/220/a67391d5dbb8d514b5f3ea0d8f1edbc47c7736/2002554178.jpg'),
(8, '2.0.2.3.12.29.3', 'Monitor', '2', 'LabTI/2.2.2.2/2', 'ASUS ROG STIX SG49VQ', 'Curved 49 inc, 144 hz, FreeSync 2 HDR, DisplayHDR™', 'FT 2023', 'Unit', '19.950.000', 'Baik', 'ACC', 'TIDAK OPERASIONAL, termutasi', 17, 3, 'https://www.guru3d.com/data/publish/220/a67391d5dbb8d514b5f3ea0d8f1edbc47c7736/2002554178.jpg'),
(9, '2.0.2.3.12.29.3', 'Monitor', '3', 'LabTI/2.2.2.2/3', 'ASUS ROG STIX SG49VQ', 'Curved 49 inc, 144 hz, FreeSync 2 HDR, DisplayHDR™', 'FT 2023', '', '19.950.000', 'Baik', 'ACC', 'OPERASIONAL', 17, 3, 'https://www.guru3d.com/data/publish/220/a67391d5dbb8d514b5f3ea0d8f1edbc47c7736/2002554178.jpg'),
(10, '2.0.2.1.12.27.2', 'Monitor', '1', 'LabTI/3.3.3.3/1', 'Monitor Acer 23.8 inch RG241Y_P', 'FHD 165Hz', 'FT 2021', 'Unit', '1.800.000', 'Baik', 'ACC', 'OPERASIONAL', 12, 3, 'https://static-ecapac.acer.com/media/catalog/product/n/i/nitro_monitor_rg1_rg241yp-rg271p_gallery_01_um.qr1sn.p01.png?optimize=high&bg-color=255,255,255&fit=bounds&height=500&width=500&canvas=500:500&format=jpeg'),
(11, '2.0.2.1.12.27.2', 'Keyboard', '2', 'LabTI/3.3.3.3/2', 'Logitech K120 ', 'Keyboard USB', 'FT 2021', 'buah', '145.000', 'Baik', 'ACC', 'OPERASIONAL', 12, 4, 'https://www.risccomputer.co.id/wp-content/uploads/2022/02/k120-gallery-01-new.png'),
(12, '2.0.2.1.12.27.2', 'Mouse', '3', 'LabTI/3.3.3.3/3', 'Logitech G250 HERO', 'Logitech G520 HERO USB', 'FT 2021', 'buah', '749.000', 'Baik', 'ACC', 'OPERASIONAL', 12, 4, 'https://resource.logitechg.com/d_transparent.gif/content/dam/gaming/en/non-braid/hyjal-g502-hero/g502-hero-gallery-1-nb.png'),
(13, '2.0.2.1.12.27.2', 'Mini PC', '4', 'LabTI/3.3.3.3/4', 'Mini PC', 'Mini Pc N9n N100 Intel Alderlake Gen12 8gb Ddr5 25', 'FT 2021', 'Unit', '3.000.000', 'Baik', 'ACC', 'OPERASIONAL', 12, 4, 'https://images.tokopedia.net/img/cache/700/VqbcmM/2023/6/28/08be7ec4-cdec-41b9-b69c-c27809b466f5.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi_aset`
--

CREATE TABLE `mutasi_aset` (
  `no_mutasi` int(11) NOT NULL,
  `no_internal` varchar(50) NOT NULL,
  `tanggal_mutasi` date NOT NULL,
  `jumlah_barang` int(10) NOT NULL,
  `unit_mutasi` varchar(35) NOT NULL,
  `no_barang` int(11) NOT NULL,
  `id_pengelola` varchar(20) NOT NULL,
  `id_penerima` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mutasi_aset`
--

INSERT INTO `mutasi_aset` (`no_mutasi`, `no_internal`, `tanggal_mutasi`, `jumlah_barang`, `unit_mutasi`, `no_barang`, `id_pengelola`, `id_penerima`) VALUES
(81, '2023/LBTI/LBTF/1', '2023-12-27', 1, 'Laboratorium Teknik Elektro', 7, '197308282021211006', '198604102019032014'),
(82, '2023/LBTI/LBTF/1', '2023-12-27', 1, 'Laboratorium Teknik Elektro', 8, '197308282021211006', '198604102019032014');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemindahan`
--

CREATE TABLE `pemindahan` (
  `no_pemindahan` int(11) NOT NULL,
  `no_barang` int(11) NOT NULL,
  `tanggal_pemindahan` date NOT NULL,
  `no_ruang_asal` int(11) NOT NULL,
  `no_ruang_tujuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman_biasa`
--

CREATE TABLE `peminjaman_biasa` (
  `no_peminjaman_biasa` int(11) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `tanggal_peminjaman_biasa` date NOT NULL,
  `id_penerima` varchar(20) NOT NULL,
  `no_barang` int(11) NOT NULL,
  `waktu_peminjaman_biasa` time NOT NULL,
  `status_peminjaman_biasa` varchar(35) NOT NULL,
  `tanggal_pengembalian_biasa` date NOT NULL,
  `waktu_pengembalian_biasa` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman_biasa`
--

INSERT INTO `peminjaman_biasa` (`no_peminjaman_biasa`, `hari`, `tanggal_peminjaman_biasa`, `id_penerima`, `no_barang`, `waktu_peminjaman_biasa`, `status_peminjaman_biasa`, `tanggal_pengembalian_biasa`, `waktu_pengembalian_biasa`) VALUES
(38, 'Rabu', '2023-12-27', '2101020051', 1, '21:28:43', 'Selesai', '2023-12-27', '21:29:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman_khusus`
--

CREATE TABLE `peminjaman_khusus` (
  `no_peminjaman_khusus` int(11) NOT NULL,
  `id_penerima` varchar(20) NOT NULL,
  `tanggal_peminjaman_khusus` date NOT NULL,
  `no_barang` int(11) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `unit_peminjaman_khusus` varchar(50) NOT NULL,
  `keperluan` varchar(255) NOT NULL,
  `id_pengelola` varchar(20) NOT NULL,
  `status_peminjaman_khusus` varchar(45) NOT NULL,
  `tanggal_pengembalian_khusus` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerima`
--

CREATE TABLE `penerima` (
  `id_penerima` varchar(20) NOT NULL,
  `nama_penerima` varchar(50) NOT NULL,
  `status_penerima` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penerima`
--

INSERT INTO `penerima` (`id_penerima`, `nama_penerima`, `status_penerima`) VALUES
('198404022014041001', 'Hendra Kurniawan, S.Kom., M.Sc.Eng., Ph.D.', 'Dosen'),
('198604102019032014', 'Rusfa, S.T., M.T.', 'Kepala Lab. Elektro'),
('198902222018031001', 'Ferdi Chahyadi, S.Kom., M.Cs', 'Kepala UPT PTIK'),
('2101020014', 'Yurike Anggraini', 'Mahasiswa'),
('2101020051', 'Azmira', 'Mahasiswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengadaan`
--

CREATE TABLE `pengadaan` (
  `no_pengadaan` int(11) NOT NULL,
  `no_surat_pengadaan` varchar(25) NOT NULL,
  `tanggal_pengadaan` date NOT NULL,
  `tahun_pengadaan` year(4) NOT NULL,
  `jumlah_barang` varchar(11) DEFAULT NULL,
  `satuan` varchar(15) NOT NULL,
  `keterangan_pengadaan` text NOT NULL,
  `dokumen_scan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengadaan`
--

INSERT INTO `pengadaan` (`no_pengadaan`, `no_surat_pengadaan`, `tanggal_pengadaan`, `tahun_pengadaan`, `jumlah_barang`, `satuan`, `keterangan_pengadaan`, `dokumen_scan`) VALUES
(1, '111.ABC', '2023-12-27', '2023', '5', 'set', 'Tanjungpinang', 'https://lh3.googleusercontent.com/-J2tnmcC-XXg/YYyTQaYvNGI/AAAAAAAABII/_wV5Byc1x-gXvBvwBoxH1c0PNNMbq7r-ACLcBGAsYHQ/Mediaeducations.com.png'),
(2, '222.ABC', '2023-12-26', '2023', '1', 'unit', 'Tanjungpinang', 'https://lh3.googleusercontent.com/-J2tnmcC-XXg/YYyTQaYvNGI/AAAAAAAABII/_wV5Byc1x-gXvBvwBoxH1c0PNNMbq7r-ACLcBGAsYHQ/Mediaeducations.com.png'),
(3, '333.ABC', '2023-12-29', '2023', '3', 'unit', 'Tanjungpinang', 'https://lh3.googleusercontent.com/-J2tnmcC-XXg/YYyTQaYvNGI/AAAAAAAABII/_wV5Byc1x-gXvBvwBoxH1c0PNNMbq7r-ACLcBGAsYHQ/Mediaeducations.com.png'),
(4, '444.ABC', '2023-12-27', '2023', '4', 'set', 'Tanjungpinang', 'https://lh3.googleusercontent.com/-J2tnmcC-XXg/YYyTQaYvNGI/AAAAAAAABII/_wV5Byc1x-gXvBvwBoxH1c0PNNMbq7r-ACLcBGAsYHQ/Mediaeducations.com.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengelola`
--

CREATE TABLE `pengelola` (
  `id_pengelola` varchar(20) NOT NULL,
  `nama_pengelola` varchar(40) NOT NULL,
  `status_pengelola` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengelola`
--

INSERT INTO `pengelola` (`id_pengelola`, `nama_pengelola`, `status_pengelola`) VALUES
('197308282021211006', 'Tekad Matulatan, S.Sos., S.Kom., M.Inf.T', 'Kepala Lab. Komputer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perbaikan`
--

CREATE TABLE `perbaikan` (
  `no_perbaikan` int(11) NOT NULL,
  `tanggal_perbaikan` date NOT NULL,
  `no_barang` int(11) NOT NULL,
  `keterangan_perbaikan` varchar(255) NOT NULL,
  `status_perbaikan` text NOT NULL,
  `tanggal_perbaikan_selesai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perbaikan`
--

INSERT INTO `perbaikan` (`no_perbaikan`, `tanggal_perbaikan`, `no_barang`, `keterangan_perbaikan`, `status_perbaikan`, `tanggal_perbaikan_selesai`) VALUES
(1, '2023-12-07', 1, 'Kerusakan pada skrup dan perlu diganti', 'Selesai', '2023-12-15'),
(2, '2023-12-16', 1, 'Perbaikan pada pegas', 'Selesai', '2023-12-16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruang_lab`
--

CREATE TABLE `ruang_lab` (
  `no_ruang_kib` int(11) NOT NULL,
  `unit_kelola` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ruang_lab`
--

INSERT INTO `ruang_lab` (`no_ruang_kib`, `unit_kelola`) VALUES
(10, 'Ruang Lab. T.I. 1'),
(11, 'Ruang Lab. T.I. 2'),
(12, 'Ruang Lab. T.I. 3'),
(17, 'Ruang Server');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `level` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `level`, `keterangan`) VALUES
(1, 'Yurike Anggraini', '2101020014', 'ec3681d49c0564d817349c00882dffb4', 'mahasiswa', 'nim-00'),
(2, 'Anita Cahya Pratiwi', '2101020048', 'f9e1f8113bdab7fdff329c5b8deb333d', 'admin', 'nim-00'),
(3, 'Azmira', '2101020051', '00dc63f15c800e73df4de005662ce5a9', 'mahasiswa', 'nim-00'),
(4, 'Rismawati', '2101020036', '98b5ffc7cef557a6208c410b9306f1ca', 'admin', 'nim-00'),
(5, 'Amanda Faatihah Aulia', '2101020100', 'e30a5c2203ff59cf671c32b42489bda6', 'asistenlab', 'nim-00'),
(6, 'Hendra Kurniawan ', '198404022014041001', '6512bd43d9caa6e02c990b0a82652dca', 'dosen', '11'),
(7, 'Tekad Matulatan', '197308282021211006', '9e3487f54585bf091cbf20e74b62de2f', 'kalab', 'nip-00'),
(8, 'Ferdi Chahyadi', '198902222018031001', '900150983cd24fb0d6963f7d28e17f72', 'dosen', 'abc');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`no_barang`),
  ADD KEY `no_ruang_kib` (`no_ruang_kib`),
  ADD KEY `no_pengadaan` (`no_pengadaan`),
  ADD KEY `no_ruang_kib_2` (`no_ruang_kib`),
  ADD KEY `no_pengadaan_2` (`no_pengadaan`);

--
-- Indeks untuk tabel `mutasi_aset`
--
ALTER TABLE `mutasi_aset`
  ADD PRIMARY KEY (`no_mutasi`),
  ADD KEY `no_barang` (`no_barang`),
  ADD KEY `id_pengelola` (`id_pengelola`),
  ADD KEY `id_penerima` (`id_penerima`);

--
-- Indeks untuk tabel `pemindahan`
--
ALTER TABLE `pemindahan`
  ADD PRIMARY KEY (`no_pemindahan`),
  ADD KEY `no_ruang_kib` (`no_ruang_asal`),
  ADD KEY `no_barang` (`no_barang`),
  ADD KEY `no_ruang_tujuan` (`no_ruang_tujuan`);

--
-- Indeks untuk tabel `peminjaman_biasa`
--
ALTER TABLE `peminjaman_biasa`
  ADD PRIMARY KEY (`no_peminjaman_biasa`),
  ADD KEY `id_penerima` (`id_penerima`),
  ADD KEY `no_barang` (`no_barang`);

--
-- Indeks untuk tabel `peminjaman_khusus`
--
ALTER TABLE `peminjaman_khusus`
  ADD PRIMARY KEY (`no_peminjaman_khusus`),
  ADD KEY `no_barang` (`no_barang`),
  ADD KEY `id_penerima` (`id_penerima`);

--
-- Indeks untuk tabel `penerima`
--
ALTER TABLE `penerima`
  ADD PRIMARY KEY (`id_penerima`);

--
-- Indeks untuk tabel `pengadaan`
--
ALTER TABLE `pengadaan`
  ADD PRIMARY KEY (`no_pengadaan`);

--
-- Indeks untuk tabel `pengelola`
--
ALTER TABLE `pengelola`
  ADD PRIMARY KEY (`id_pengelola`);

--
-- Indeks untuk tabel `perbaikan`
--
ALTER TABLE `perbaikan`
  ADD PRIMARY KEY (`no_perbaikan`),
  ADD KEY `no_barang` (`no_barang`);

--
-- Indeks untuk tabel `ruang_lab`
--
ALTER TABLE `ruang_lab`
  ADD PRIMARY KEY (`no_ruang_kib`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `no_barang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=387;

--
-- AUTO_INCREMENT untuk tabel `mutasi_aset`
--
ALTER TABLE `mutasi_aset`
  MODIFY `no_mutasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `pemindahan`
--
ALTER TABLE `pemindahan`
  MODIFY `no_pemindahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `peminjaman_biasa`
--
ALTER TABLE `peminjaman_biasa`
  MODIFY `no_peminjaman_biasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `peminjaman_khusus`
--
ALTER TABLE `peminjaman_khusus`
  MODIFY `no_peminjaman_khusus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `pengadaan`
--
ALTER TABLE `pengadaan`
  MODIFY `no_pengadaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`no_ruang_kib`) REFERENCES `ruang_lab` (`no_ruang_kib`),
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`no_pengadaan`) REFERENCES `pengadaan` (`no_pengadaan`);

--
-- Ketidakleluasaan untuk tabel `pemindahan`
--
ALTER TABLE `pemindahan`
  ADD CONSTRAINT `pemindahan_ibfk_1` FOREIGN KEY (`no_barang`) REFERENCES `barang` (`no_barang`),
  ADD CONSTRAINT `pemindahan_ibfk_2` FOREIGN KEY (`no_ruang_asal`) REFERENCES `ruang_lab` (`no_ruang_kib`),
  ADD CONSTRAINT `pemindahan_ibfk_3` FOREIGN KEY (`no_ruang_tujuan`) REFERENCES `ruang_lab` (`no_ruang_kib`);

--
-- Ketidakleluasaan untuk tabel `peminjaman_khusus`
--
ALTER TABLE `peminjaman_khusus`
  ADD CONSTRAINT `peminjaman_khusus_ibfk_1` FOREIGN KEY (`id_penerima`) REFERENCES `penerima` (`id_penerima`),
  ADD CONSTRAINT `peminjaman_khusus_ibfk_2` FOREIGN KEY (`no_barang`) REFERENCES `barang` (`no_barang`);

--
-- Ketidakleluasaan untuk tabel `perbaikan`
--
ALTER TABLE `perbaikan`
  ADD CONSTRAINT `perbaikan_ibfk_1` FOREIGN KEY (`no_barang`) REFERENCES `barang` (`no_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
