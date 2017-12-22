-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 22 Des 2017 pada 12.22
-- Versi Server: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scm_shb`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_bahan_baku` (IN `id_bahan_baku_param` INT, IN `kd_bahan_baku_param` INT, IN `nama_param` VARCHAR(50), IN `satuan_param` VARCHAR(10), IN `ket_param` TEXT, IN `foto_param` TEXT, IN `tgl_param` DATE, IN `stok_param` DOUBLE(12,2))  BEGIN
			DECLARE id_param int;

			SELECT `AUTO_INCREMENT` INTO id_param 
		    FROM INFORMATION_SCHEMA.TABLES 
		    WHERE TABLE_SCHEMA = 'scm_shb' AND TABLE_NAME = 'bahan_baku';
			
						INSERT INTO bahan_baku(
				kd_bahan_baku, nama, satuan, ket, foto, stok) 
			VALUES(
				kd_bahan_baku_param, nama_param, satuan_param, ket_param, foto_param, stok_param);

						INSERT INTO mutasi_bahan_baku(
				tgl, id_bahan_baku, brg_masuk, brg_keluar) 
			VALUES(tgl_param, id_param, 0, 0);
			
		END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_supplier` (IN `nik_param` VARCHAR(16), IN `npwp_param` VARCHAR(20), IN `nama_param` VARCHAR(255), IN `alamat_param` TEXT, IN `telp_param` VARCHAR(20), IN `email_param` VARCHAR(50), IN `status_param` CHAR(1), IN `id_supplier_utama_param` INT)  BEGIN
			DECLARE id_param int;

						SELECT `AUTO_INCREMENT` INTO id_param 
				FROM INFORMATION_SCHEMA.TABLES 
				WHERE TABLE_SCHEMA = 'scm_shb' AND TABLE_NAME = 'supplier';

						IF status_param = '1' THEN 								INSERT INTO supplier 
					(nik, npwp, nama, alamat, telp, email, status, supplier_utama) 
				VALUES 
					(nik_param, npwp_param, nama_param, alamat_param, 
					telp_param, email_param, status_param, id_param);
			ELSE 								INSERT INTO supplier 
					(nik, npwp, nama, alamat, telp, email, status, supplier_utama) 
				VALUES 
					(nik_param, npwp_param, nama_param, alamat_param, 
					telp_param, email_param, status_param, id_supplier_utama_param);
			END IF;	
		END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_user` (IN `username_param` VARCHAR(10), IN `password_param` TEXT, IN `jenis_param` CHAR(1), IN `status_param` CHAR(1), IN `pengguna_param` INT, IN `hak_akses_param` VARCHAR(50))  BEGIN
						INSERT INTO user(
				username, password, jenis, hak_akses, status) 
			VALUES(
				username_param, password_param, jenis_param, hak_akses_param, status_param);

			IF jenis_param = 'K' THEN 								INSERT INTO user_karyawan(username, id_karyawan) VALUES(username_param, pengguna_param);
			ELSE
								INSERT INTO user_buyer(username, id_buyer) VALUES(username_param, pengguna_param);
			END IF;
		END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id` int(11) NOT NULL,
  `kd_bahan_baku` varchar(25) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `satuan` enum('KG','PCS') DEFAULT NULL,
  `ket` text,
  `foto` text,
  `stok` double(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `buyer`
--

CREATE TABLE `buyer` (
  `id` int(11) NOT NULL,
  `npwp` varchar(20) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `foto` text,
  `status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `harga_basis`
--

CREATE TABLE `harga_basis` (
  `id` int(11) NOT NULL,
  `tgl` date DEFAULT NULL,
  `jenis` char(1) DEFAULT NULL,
  `harga_basis` double(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `no_induk` varchar(20) DEFAULT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `npwp` varchar(16) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jk` char(1) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `foto` text,
  `tgl_masuk` date DEFAULT NULL,
  `id_pekerjaan` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id`, `no_induk`, `nik`, `npwp`, `nama`, `tempat_lahir`, `tgl_lahir`, `jk`, `alamat`, `telp`, `email`, `foto`, `tgl_masuk`, `id_pekerjaan`, `status`) VALUES
(1, '1000000001', NULL, NULL, 'SYARIFUDIN HIFNI', 'BATURAJA', NULL, 'L', NULL, NULL, NULL, NULL, NULL, 1, '1'),
(2, '1000000002', '3273240102840006', NULL, 'MUHAMMAD HERRY SYARIFUDIN', 'KOTABUMI', '1984-02-01', 'L', 'JL. PENITIS NO. 464 B. RT/RW 005/005', NULL, NULL, NULL, NULL, 2, '1'),
(3, '1000000003', '1803102108660003', NULL, 'AMSON FHARDIAZ', 'BENGKULU', '1966-08-21', 'L', 'JL. RADEN INTAN NO. 87. RT/RW 001/001', NULL, NULL, NULL, NULL, 2, '1'),
(4, '1000000004', '1803104405850008', NULL, 'RATNA SARI', 'KOTABUMI', '1985-05-04', 'P', 'JL. RADEN INTAN NO. 90 RT/RW 001/001', NULL, NULL, NULL, NULL, 2, '1'),
(5, '1000000006', '1803105407880005', NULL, 'KARTIKA SARI', 'KOTABUMI', '1988-07-14', 'P', 'JL. ST RT GADING MARGA GG. H. HASSANUL AINI NO. 53', NULL, NULL, NULL, NULL, 2, '1'),
(6, '2000000001', '1803105004740008', NULL, 'LILIS', 'PERIANGAN BARU', '1974-04-10', 'P', 'JL. RADEN INTAN GG. SINGGAH MATA II NO. 05', NULL, NULL, NULL, NULL, 3, '1'),
(7, '3000000001', '1803100404830008', NULL, 'AHMAD A. GHANY SG', NULL, NULL, 'L', 'JL. RADEN INTAN NO. 148 RT/RW 003/006', NULL, NULL, NULL, NULL, 4, '1'),
(8, '4000000001', '1803101807770002', NULL, 'AHMAD LISORI', 'BATURAJA', '1977-06-18', 'L', 'JL. LINTAS SUMATRA NO. 139 A, BERNAH', NULL, NULL, NULL, NULL, 6, '1'),
(9, '5000000001', '1803103005750003', NULL, 'JAJANG SUTISNA', 'BANTEN', '1975-05-30', 'L', 'JL. LINTAS SUMATRA RT/RW 004/005. BERNAH', NULL, NULL, NULL, NULL, 5, '1'),
(10, '2000000002', '1803105210860004', NULL, 'LENI MARLINA', 'KOTABUMI', '1986-10-12', 'P', 'JL. RADEN INTAN GG. SINGGAH MATA 1 NO. 18 A', NULL, NULL, NULL, NULL, 7, '1'),
(11, '2000000003', '1803101407890002', NULL, 'INDRA KUSUMA', 'NEGARA TULANG BAWANG', '1989-07-14', 'L', 'LK III MARGOMULYO RT/RW 002/003', NULL, NULL, NULL, NULL, 8, '1'),
(12, '2000000004', '1803190808650001', NULL, 'KARIMAN HADI', 'MUARA DUA', '1965-08-08', 'L', 'MUARA DUA, 08 AGUSTUS 1965', NULL, NULL, NULL, NULL, 9, '1'),
(13, '3000000002', '1803105708890004', NULL, 'GIRA VENILIA', 'KOTABUMI', '1989-08-17', 'P', 'JL. RADEN INTAN NO. 60 B RT/RW 001/001', NULL, NULL, NULL, NULL, 10, '1'),
(14, '3000000003', '1803046612940001', NULL, 'YENI MAWARNI', 'KOTABUMI', '1994-12-26', 'P', 'JL. GOTONG ROYONG GG. RAFLESIA NO. 211 A', NULL, NULL, NULL, NULL, 10, '1'),
(15, '3000000004', '1803102608890001', NULL, 'CANDRA', 'KOTABUMI', '1989-08-26', 'L', 'JL. GOTONG ROYONG GG. RAFLESIA NO. 211 A', NULL, NULL, NULL, NULL, 11, '1'),
(16, '4000000002', '1803100102840007', NULL, 'SYAHRIL', 'SAKAL', '1984-02-01', 'L', 'BERNAH, RT/RW 004/005', NULL, NULL, NULL, NULL, 14, '1'),
(17, '5000000002', '1803100505850014', NULL, 'ERWAN', 'PERIANGAN BARU', '1985-05-05', 'L', 'BERNAH, RT/RW 004/006', NULL, NULL, NULL, NULL, 13, '1'),
(18, '8000000001', NULL, NULL, 'H. ALEK', NULL, NULL, 'L', NULL, NULL, NULL, NULL, NULL, 17, '1'),
(19, '8000000002', NULL, NULL, 'MUHAMAD RIFA\'I', NULL, NULL, 'L', NULL, NULL, NULL, NULL, NULL, 17, '1'),
(20, '8000000003', NULL, NULL, 'YATNO', NULL, NULL, 'L', NULL, NULL, NULL, NULL, NULL, 17, '1'),
(21, '8000000004', NULL, NULL, 'SAYUTI', NULL, NULL, 'L', NULL, NULL, NULL, NULL, NULL, 17, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int(11) NOT NULL,
  `no_polis` varchar(10) DEFAULT NULL,
  `id_supir` int(11) DEFAULT NULL,
  `pendamping` varchar(255) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `jenis` char(1) DEFAULT NULL,
  `muatan` double(8,2) DEFAULT NULL,
  `foto` text,
  `status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `komposisi`
--

CREATE TABLE `komposisi` (
  `id_produk` int(11) DEFAULT NULL,
  `id_bahan_baku` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi_bahan_baku`
--

CREATE TABLE `mutasi_bahan_baku` (
  `id` int(11) NOT NULL,
  `tgl` date DEFAULT NULL,
  `id_bahan_baku` int(11) DEFAULT NULL,
  `brg_masuk` double(12,2) DEFAULT NULL,
  `brg_keluar` double(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi_produk`
--

CREATE TABLE `mutasi_produk` (
  `id` int(11) NOT NULL,
  `tgl` date DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `brg_masuk` double(12,2) DEFAULT NULL,
  `brg_keluar` double(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `ket` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pekerjaan`
--

INSERT INTO `pekerjaan` (`id`, `nama`, `ket`) VALUES
(1, 'DIREKTUR UTAMA', NULL),
(2, 'WAKIL DIREKTUR', NULL),
(3, 'MANAGER ADMINISTRASI DAN KEUANGAN', NULL),
(4, 'KEPALA GUDANG', NULL),
(5, 'MANAGER TEKNISI DAN OPERASIONAL', NULL),
(6, 'MANAGER PENELITIAN KIR', NULL),
(7, 'STAFF ACOUNTING', NULL),
(8, 'STAFF IT', NULL),
(9, 'BAGIAN TRANSPORTASI DAN PEMBANTU UMUM', NULL),
(10, 'STAFF TIMBANGAN', NULL),
(11, 'STAFF COLOKAN SAMPLE', NULL),
(12, 'PENGURUS DAN PENGAWAS KEBUN', NULL),
(13, 'STAFF OVEN', NULL),
(14, 'STAFF KIR', NULL),
(15, 'OFFICE BOY', NULL),
(16, 'SATPAM', NULL),
(17, 'SUPIR', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `kd_produk` varchar(25) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `satuan` enum('KG','PCS') DEFAULT NULL,
  `ket` text,
  `foto` text,
  `stok` double(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `npwp` varchar(16) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `supplier_utama` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `username` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `jenis` char(1) DEFAULT NULL,
  `hak_akses` varchar(50) DEFAULT NULL,
  `status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`username`, `password`, `jenis`, `hak_akses`, `status`) VALUES
('aghany', '$2y$10$Fmb53c5iL7yEQQCgUH21aeoq7b.rFsNogcmMYOFGMlmw2W6sadyJa', 'K', 'BAGIAN GUDANG', '1'),
('liliss', '$2y$10$yntJ1sWqsdcCp8a0K1Zr0u/xQ2Z5oVv.LFu.wF9wCF5qus6tXlDxa', 'K', 'BAGIAN ADMINISTRASI DAN KEUANGAN', '1'),
('sarifhifni', '$2y$10$4v8SU4WKmqyBmRP97lz.1uXxkxX1Y./qu6wZFgsIQcGkUqAQ7bMYO', 'K', 'DIREKTUR', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_buyer`
--

CREATE TABLE `user_buyer` (
  `username` varchar(10) DEFAULT NULL,
  `id_buyer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_karyawan`
--

CREATE TABLE `user_karyawan` (
  `username` varchar(10) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_karyawan`
--

INSERT INTO `user_karyawan` (`username`, `id_karyawan`) VALUES
('sarifhifni', 1),
('liliss', 6),
('aghany', 7);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_buyer`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_buyer` (
`id` int(11)
,`npwp` varchar(20)
,`nama` varchar(255)
,`alamat` text
,`telp` varchar(20)
,`email` varchar(50)
,`status` varchar(9)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_karyawan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_karyawan` (
`id` int(11)
,`no_induk` varchar(20)
,`nik` varchar(16)
,`npwp` varchar(16)
,`nama` varchar(255)
,`tempat_lahir` varchar(255)
,`tgl_lahir` date
,`jk` varchar(9)
,`alamat` text
,`telp` varchar(20)
,`email` varchar(50)
,`foto` text
,`tgl_masuk` date
,`id_pekerjaan` int(11)
,`jabatan` varchar(50)
,`status` varchar(9)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_kendaraan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_kendaraan` (
`id` int(11)
,`no_polis` varchar(10)
,`id_supir` int(11)
,`supir` varchar(255)
,`pendamping` varchar(255)
,`tahun` year(4)
,`jenis` varchar(11)
,`muatan` double(8,2)
,`foto` text
,`status` varchar(14)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_supplier`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_supplier` (
`id` int(11)
,`nik` varchar(16)
,`npwp` varchar(16)
,`nama` varchar(255)
,`alamat` text
,`telp` varchar(20)
,`email` varchar(50)
,`status` varchar(9)
,`id_utama` int(11)
,`nama_utama` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_user` (
`username` varchar(10)
,`nama` varchar(255)
,`jenis` varchar(8)
,`hak_akses` varchar(50)
,`status` varchar(9)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_buyer`
--
DROP TABLE IF EXISTS `v_buyer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_buyer`  AS  select `buyer`.`id` AS `id`,`buyer`.`npwp` AS `npwp`,`buyer`.`nama` AS `nama`,`buyer`.`alamat` AS `alamat`,`buyer`.`telp` AS `telp`,`buyer`.`email` AS `email`,(case when (`buyer`.`status` = '1') then 'AKTIF' else 'NON-AKTIF' end) AS `status` from `buyer` order by `buyer`.`id` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_karyawan`
--
DROP TABLE IF EXISTS `v_karyawan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_karyawan`  AS  select `k`.`id` AS `id`,`k`.`no_induk` AS `no_induk`,`k`.`nik` AS `nik`,`k`.`npwp` AS `npwp`,`k`.`nama` AS `nama`,`k`.`tempat_lahir` AS `tempat_lahir`,`k`.`tgl_lahir` AS `tgl_lahir`,(case when (`k`.`jk` = 'L') then 'LAKI-LAKI' else 'PEREMPUAN' end) AS `jk`,`k`.`alamat` AS `alamat`,`k`.`telp` AS `telp`,`k`.`email` AS `email`,`k`.`foto` AS `foto`,`k`.`tgl_masuk` AS `tgl_masuk`,`k`.`id_pekerjaan` AS `id_pekerjaan`,`p`.`nama` AS `jabatan`,(case when (`k`.`status` = '1') then 'AKTIF' else 'NON-AKTIF' end) AS `status` from (`karyawan` `k` join `pekerjaan` `p` on((`p`.`id` = `k`.`id_pekerjaan`))) order by `k`.`no_induk`,`k`.`id_pekerjaan`,(case when (`k`.`status` = '1') then 'AKTIF' else 'NON-AKTIF' end) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_kendaraan`
--
DROP TABLE IF EXISTS `v_kendaraan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_kendaraan`  AS  select `k`.`id` AS `id`,`k`.`no_polis` AS `no_polis`,`k`.`id_supir` AS `id_supir`,`kry`.`nama` AS `supir`,`k`.`pendamping` AS `pendamping`,`k`.`tahun` AS `tahun`,(case when (`k`.`jenis` = 'C') then 'COLT DIESEL' else 'FUSSO' end) AS `jenis`,`k`.`muatan` AS `muatan`,`k`.`foto` AS `foto`,(case when (`k`.`status` = '1') then 'TERSEDIA' else 'TIDAK TERSEDIA' end) AS `status` from (`kendaraan` `k` join `karyawan` `kry` on((`kry`.`id` = `k`.`id_supir`))) order by `k`.`id`,(case when (`k`.`status` = '1') then 'TERSEDIA' else 'TIDAK TERSEDIA' end) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_supplier`
--
DROP TABLE IF EXISTS `v_supplier`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_supplier`  AS  select `s`.`id` AS `id`,`s`.`nik` AS `nik`,`s`.`npwp` AS `npwp`,`s`.`nama` AS `nama`,`s`.`alamat` AS `alamat`,`s`.`telp` AS `telp`,`s`.`email` AS `email`,(case when (`s`.`status` = '1') then 'UTAMA' else 'PENGGANTI' end) AS `status`,`s2`.`id` AS `id_utama`,`s2`.`nama` AS `nama_utama` from (`supplier` `s` join `supplier` `s2` on((`s2`.`id` = `s`.`supplier_utama`))) order by (case when (`s`.`status` = '1') then 'UTAMA' else 'PENGGANTI' end) desc,`s`.`id` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_user`
--
DROP TABLE IF EXISTS `v_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user`  AS  select `u`.`username` AS `username`,`k`.`nama` AS `nama`,(case when (`u`.`jenis` = 'k') then 'KARYAWAN' else 'BUYER' end) AS `jenis`,`u`.`hak_akses` AS `hak_akses`,(case when (`u`.`status` = '1') then 'AKTIF' else 'NON-AKTIF' end) AS `status` from ((`user` `u` join `user_karyawan` `uk` on((`uk`.`username` = `u`.`username`))) join `karyawan` `k` on((`uk`.`id_karyawan` = `k`.`id`))) group by `u`.`username` union select `u`.`username` AS `username`,`b`.`nama` AS `nama`,(case when (`u`.`jenis` = 'k') then 'KARYAWAN' else 'BUYER' end) AS `jenis`,`u`.`hak_akses` AS `hak_akses`,(case when (`u`.`status` = '1') then 'AKTIF' else 'NON-AKTIF' end) AS `status` from ((`user` `u` join `user_buyer` `ub` on((`ub`.`username` = `u`.`username`))) join `buyer` `b` on((`ub`.`id_buyer` = `b`.`id`))) group by `u`.`username` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harga_basis`
--
ALTER TABLE `harga_basis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_karyawan_id_pekerjaan` (`id_pekerjaan`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kendaraan_id_supir` (`id_supir`);

--
-- Indexes for table `komposisi`
--
ALTER TABLE `komposisi`
  ADD KEY `fk_komposisi_id_produk` (`id_produk`),
  ADD KEY `fk_komposisi_id_bahan_baku` (`id_bahan_baku`);

--
-- Indexes for table `mutasi_bahan_baku`
--
ALTER TABLE `mutasi_bahan_baku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mutasi_bahan_baku_id_bahan_baku` (`id_bahan_baku`);

--
-- Indexes for table `mutasi_produk`
--
ALTER TABLE `mutasi_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mutasi_produk_id_produk` (`id_produk`);

--
-- Indexes for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user_buyer`
--
ALTER TABLE `user_buyer`
  ADD KEY `fk_user_buyer_username` (`username`),
  ADD KEY `fk_user_karyawan_id_buyer` (`id_buyer`);

--
-- Indexes for table `user_karyawan`
--
ALTER TABLE `user_karyawan`
  ADD KEY `fk_user_karyawan_username` (`username`),
  ADD KEY `fk_user_karyawan_id_karyawan` (`id_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `harga_basis`
--
ALTER TABLE `harga_basis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mutasi_bahan_baku`
--
ALTER TABLE `mutasi_bahan_baku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mutasi_produk`
--
ALTER TABLE `mutasi_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `fk_karyawan_id_pekerjaan` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id`);

--
-- Ketidakleluasaan untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD CONSTRAINT `fk_kendaraan_id_supir` FOREIGN KEY (`id_supir`) REFERENCES `karyawan` (`id`);

--
-- Ketidakleluasaan untuk tabel `komposisi`
--
ALTER TABLE `komposisi`
  ADD CONSTRAINT `fk_komposisi_id_bahan_baku` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id`),
  ADD CONSTRAINT `fk_komposisi_id_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);

--
-- Ketidakleluasaan untuk tabel `mutasi_bahan_baku`
--
ALTER TABLE `mutasi_bahan_baku`
  ADD CONSTRAINT `fk_mutasi_bahan_baku_id_bahan_baku` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id`);

--
-- Ketidakleluasaan untuk tabel `mutasi_produk`
--
ALTER TABLE `mutasi_produk`
  ADD CONSTRAINT `fk_mutasi_produk_id_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);

--
-- Ketidakleluasaan untuk tabel `user_buyer`
--
ALTER TABLE `user_buyer`
  ADD CONSTRAINT `fk_user_buyer_username` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `fk_user_karyawan_id_buyer` FOREIGN KEY (`id_buyer`) REFERENCES `buyer` (`id`);

--
-- Ketidakleluasaan untuk tabel `user_karyawan`
--
ALTER TABLE `user_karyawan`
  ADD CONSTRAINT `fk_user_karyawan_id_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id`),
  ADD CONSTRAINT `fk_user_karyawan_username` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
