-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05 Jan 2018 pada 03.31
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_komposisi` (IN `id_param` INT, IN `kd_produk_param` VARCHAR(25), IN `id_bahan_baku_param` INT)  BEGIN
			DECLARE id_produk_param int;

			SELECT id INTO id_produk_param FROM produk WHERE kd_produk = kd_produk_param;

						UPDATE komposisi SET id_produk = id_produk_param, id_bahan_baku = id_bahan_baku_param WHERE id = id_param;
		END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_bahan_baku` (IN `kd_bahan_baku_param` VARCHAR(25), IN `nama_param` VARCHAR(50), IN `satuan_param` VARCHAR(10), IN `ket_param` TEXT, IN `foto_param` TEXT, IN `tgl_param` DATE, IN `stok_param` DOUBLE(12,2))  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_komposisi` (IN `kd_produk_param` VARCHAR(25), IN `id_bahan_baku_param` INT)  BEGIN
			DECLARE id_produk_param int;

			SELECT id INTO id_produk_param FROM produk WHERE kd_produk = kd_produk_param;

						INSERT INTO komposisi(id_produk, id_bahan_baku) VALUES(id_produk_param, id_bahan_baku_param);
		END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_produk` (IN `kd_produk_param` VARCHAR(25), IN `nama_param` VARCHAR(50), IN `satuan_param` VARCHAR(10), IN `ket_param` TEXT, IN `foto_param` TEXT, IN `tgl_param` DATE, IN `stok_param` DOUBLE(12,2))  BEGIN
			DECLARE id_param int;

			SELECT `AUTO_INCREMENT` INTO id_param 
		    FROM INFORMATION_SCHEMA.TABLES 
		    WHERE TABLE_SCHEMA = 'scm_shb' AND TABLE_NAME = 'produk';

		    			INSERT INTO produk(
				kd_produk, nama, satuan, ket, foto, stok) 
			VALUES(
				kd_produk_param, nama_param, satuan_param, ket_param, foto_param, stok_param);

						INSERT INTO mutasi_produk(
				tgl, id_produk, brg_masuk, brg_keluar) 
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

--
-- Dumping data untuk tabel `bahan_baku`
--

INSERT INTO `bahan_baku` (`id`, `kd_bahan_baku`, `nama`, `satuan`, `ket`, `foto`, `stok`) VALUES
(4, 'KP-ASALAN', 'KOPI ASALAN', 'KG', 'KOPI ROBUSTA', 'barang/dee1d4a187091ddbdb3522af2b0c13f049573d4a.jpg', 100.00),
(5, 'KP-SUTA', 'KOPI SUTON A', 'KG', 'TEST', NULL, 100.00),
(6, 'KP-SUTB', 'KOPI SUTON B', 'KG', NULL, NULL, 100.00);

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

--
-- Dumping data untuk tabel `buyer`
--

INSERT INTO `buyer` (`id`, `npwp`, `nama`, `alamat`, `telp`, `email`, `foto`, `status`) VALUES
(1, '010716652059000', 'PT. OLAM INDONESIA', 'JL. KH. AGUS ANANG NO. 36 WAY LUNIK PANJANG BANDAR LAMPUNG', '08117204730', 'Wahyu.Astuti@olamnet.com', NULL, '1'),
(2, '018689786056000', 'PT. LOUIS DREYFUS INDONESIA', 'JL. SOEKARNO HATTA BANDAR LAMPUNG', NULL, 'melissa.florence@ldcom.com', NULL, '1'),
(3, '021930441057000', 'PT. NEDD COFFE INDONESIA', 'JL. SOEKARNO HATTA KM. 07 CAMPANG RAYA TANJUNG KARANG TIMUR', NULL, 'commercial@nedcoffee.id', NULL, '1'),
(4, '18689992058000', 'PT. INDO CAFCO', 'JL. P. TIRTAYASA KP. GALIH LK II RT 02 KEL. CAMPANG RAYA KEC. T. KARANG TIMUR BANDAR LAMPUNG 35122', '0721350737', 'misro@ecomtrading.com', NULL, '1'),
(5, NULL, 'PT. SAMSON JAYA', 'JL. SUTAMI NO. 13 BANDAR LAMPUNG', NULL, NULL, NULL, '1'),
(6, NULL, 'PT. ARMAJARO INDONESIA', 'JL. IR. SUTAMI KM. 03 WAY LAGA PANJANG BANDAR LAMPUNG', NULL, 'yusac@armajaro.co.id', NULL, '1'),
(7, NULL, 'PT. PUTRA BALI ADYAMULIA', 'JL. GATOT SUBROTO NO. 79 A BANDAR LAMPUNG', NULL, 'lampung@putra-bali.com', NULL, '1'),
(8, '014872915123000', 'PT. SARIMAKMUR TUNGGAL MANDIRI', 'JL. SOEKARNO HATTA NO. 17 BANDAR LAMPUNG INDONESIA', NULL, 'accounting_smlpg@bdl.nusa.net.id', NULL, '1'),
(9, NULL, 'CV. MULTI ORGANIK INDONESIA', 'JL. SOEKARN HATTA KM. 07 GG. MULTI', NULL, NULL, NULL, '1'),
(10, NULL, 'PT. INDOCOM CITRA PERSADA', 'JL. IR. SUTAMI BANDAR LAMPUNG', NULL, NULL, NULL, '1');

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

--
-- Dumping data untuk tabel `harga_basis`
--

INSERT INTO `harga_basis` (`id`, `tgl`, `jenis`, `harga_basis`) VALUES
(1, '2017-12-27', 'K', 25750.00),
(2, '2017-12-27', 'L', 78900.00);

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
  `id` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `id_bahan_baku` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `komposisi`
--

INSERT INTO `komposisi` (`id`, `id_produk`, `id_bahan_baku`) VALUES
(7, 12, 4);

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

--
-- Dumping data untuk tabel `mutasi_bahan_baku`
--

INSERT INTO `mutasi_bahan_baku` (`id`, `tgl`, `id_bahan_baku`, `brg_masuk`, `brg_keluar`) VALUES
(4, '2017-12-23', 4, 0.00, 0.00),
(5, '2017-12-26', 5, 0.00, 0.00),
(6, '2017-12-26', 6, 0.00, 0.00);

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

--
-- Dumping data untuk tabel `mutasi_produk`
--

INSERT INTO `mutasi_produk` (`id`, `tgl`, `id_produk`, `brg_masuk`, `brg_keluar`) VALUES
(12, '2017-12-26', 12, 0.00, 0.00);

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

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `kd_produk`, `nama`, `satuan`, `ket`, `foto`, `stok`) VALUES
(12, 'KP-DEF80', 'KOPI DEF 80', 'KG', 'AGFSDGSD', NULL, 150000.00);

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

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nik`, `npwp`, `nama`, `alamat`, `telp`, `email`, `status`, `supplier_utama`) VALUES
(1, NULL, '819774985326000', 'EKO PAJAR DIANTO', 'Tiga Serangkai Rt 010/005 Ogan Campang Abung Pekurun', '081379405914', NULL, '1', 1),
(2, NULL, '461003279326000', 'RAHMAN ADI CANDRA', 'TANJUNG BARU RT 002/005 TANJUNG BARU BUKIT KEMUNING', '081313739222', NULL, '1', 2),
(3, NULL, '730522612302000', 'PIRMANSYAH', 'PEDATARAN ULU OGAN DUSUN 01 RT 01/01', '085267672627', NULL, '1', 3),
(4, NULL, '7166761796302000', 'HELWANA', 'PEDATARAN ULU OGAN DUSUN 01 RT 01/01', '085267676227', NULL, '1', 4),
(5, NULL, '739552230326000', 'SAMSUL', 'BATU KODOK SUKA MULYO RT 010/004 TANJUNG RAJA', '082178825528', NULL, '1', 5),
(6, NULL, '163710072326000', 'ERWIN', 'CAMPANG DELAPAN RT 001/001 CAMPANG LAPAN BANJIT', '081369255838', NULL, '1', 6),
(7, NULL, '544568470326000', 'MUHAMMAD SAAD', 'PEMANGKU 02 SUKANANTI WAY TENONG', '081369215546', NULL, '1', 7),
(8, NULL, '698866241326000', 'SURIYATI', 'PEMANGKU 02 SUKANANTI WAYTENONG', '081369215546', NULL, '1', 8),
(9, NULL, '818542110326000', 'MERI YANTI', 'JL. LINTAS LIWA PURA LAKSANA RT 005/003 PURALAKSANA WAY TENONG', '081279950914', NULL, '1', 9),
(10, NULL, NULL, 'SIKAMAN', 'JL. LINTAS LIWA PURA LAKSANA RT 005/003 PURA LAKSANA WAY TENONG', '081279950914', NULL, '1', 10),
(11, NULL, '642948038326000', 'SAIDI ANWAR', 'SIDO KAYO RT 002/002 ABUNG TINGGI LAMPUNG UTARA', '082183483335', NULL, '1', 11),
(12, NULL, '819438110302000', 'KHAIRUL FUADI', 'DUSUN 1 PEDATARAN ULU OGAN', '081271129377', NULL, '1', 12),
(13, NULL, '084888205321000', 'MARKIS', 'GIHAM SUKAMAJU RT 001/001 SEKINCAU', '081539930559', NULL, '1', 13),
(14, NULL, '1464685743260000', 'RUSMAN', 'JL. PASAR BUNGIN RT 001/006 PURA MEKAR GEDUNG SURIAN', '0811795544', NULL, '1', 14),
(15, NULL, '778500819326000', 'SUWANTI NINGSIIH', 'JL. PASAR BUNGIN RT 001/006 PURA MEKAR GEDUNG SURIAN', '0811795544', NULL, '1', 15),
(16, NULL, '495186249905000', 'ENI SUPARTINI', 'PERUM PURI KAMPIAL BLOK C NO. 77 BENOA BADUNG', '0811795544', NULL, '1', 16),
(17, NULL, '084887587321000', 'NEDI', 'CIPTALAGA RT 010/004 CIPTA WARAS GEDUNG SURIAN', '0811795544', NULL, '1', 17),
(18, NULL, '153758743326000', 'RIDWAN', 'DESA SUBIK RT. 002/001 SUBIK ABUNG TENGAH', '082374883804', NULL, '1', 18),
(19, NULL, '156451551326000', 'MUHAMAD SEMAR', 'SUMBER ALAM KEC. AIR HITUAM LAMMPUNG', '085789737967', NULL, '1', 19),
(20, NULL, '667503452326000', 'H WARSONO', 'MUARA JAYA 2 KEC. KEBUN TEBU PEMANGKU MUARA JAYA', '085269250729', NULL, '1', 20),
(21, NULL, '541741716326000', 'SUWANDI WARSONO', 'MUARA JAYA 2 KEC. KEBUN TEBU PEMANGKU MUARA JAYA', NULL, NULL, '1', 21),
(22, NULL, '755021086326000', 'DESI NUR WANTO', 'MUARA JAYA 2 KEC. KEBUN TEBU PEMANGKU MUARA JAYA', '085269250792', NULL, '1', 22),
(23, NULL, '150365682326000', 'SIRAJUDIN', 'DUDUN CAMPUR SARI 1 ARGOMULYO BANJIT', '082375253446', NULL, '1', 23),
(24, NULL, '761711704302000', 'E. NENGGOLAN', 'GUNUNG RAYA WARKUK RANAU SELATAN', '082182159036', NULL, '1', 24),
(25, NULL, '794119750329000', 'HAIDAR HASNI', 'JL. RADEN INTAN NO. 5 WAY MENGAKU BALIK BUKIN LAMBAR', '081272070462', NULL, '1', 25),
(26, NULL, '711631960327000', 'HJ. FITRI HAYANI', 'KAMPUNG MUARA AMAN DESA KAMPUNG MUARA AMAN LEBONG UTARA', NULL, NULL, '1', 26),
(27, NULL, '758517395327000', 'PIPIET IRIANTO', 'KAMPUNG MUARA AMAN DESA KAMPUNG MUARA AMAN LEBONG UTARA', NULL, NULL, '1', 27),
(28, NULL, '710597782326000', 'KOMARUDIN', 'DESA SUKAMMULYA RT 002/002 TANJUNG RAYA', '082282736519', NULL, '1', 28),
(29, NULL, '554647628326000', 'IHROM', 'AGUNG RAYA RT 001/006 PURAJAYA KEBUN TEBU', '085269503561', NULL, '1', 29),
(30, NULL, NULL, 'AHMAD EFENDI', 'SINAR SARI RT 006/0003 OGAN CAMPANG ABUNG PEKURUN', '085658906079', NULL, '1', 30),
(31, NULL, '155454564326000', 'LISUS GANI', 'DUSUN 01 DESA SEKIPI RT 001/001 ABUNG TINGGI', '082183113888', NULL, '1', 31),
(32, NULL, '714187226326000', 'ACENG', 'BATU KEBAYAN KEC. BELALAU LAMPUNG BARAT', '082371846718', NULL, '1', 32),
(33, NULL, '812543726326000', 'AHMAD SARKONI', 'SUBIK RT 002/002 SUBIK ABUNG TENGAH', '081279554719', NULL, '1', 33),
(34, NULL, '084479070302000', 'GUSRI AMULI', 'JL. HORO SENANG KOMPLEK BARURAJA PERMAI BLOK 0 NO. 22 BTA', '085267646500', NULL, '1', 34),
(35, NULL, '710091992326000', 'HAYATUL', 'JL. SUMBER JAYA KEL. DWI KORA BUKIT KEMUNING', '081379330005', NULL, '1', 35),
(36, NULL, '823025424326000', 'APRIL SENIADI', 'DESA DWIKORA RT 003/005 DWIKORA BUKIT KEMUNING', NULL, NULL, '1', 36),
(37, NULL, '824737068326000', 'SULTAN KURNAIN', 'DESA DWIKORA RT 003/005 DWIKORA BUKIT KEMUNING', NULL, NULL, '1', 37),
(38, NULL, NULL, 'LISNAWATI', 'DESA DWIKORA RT 003/005 DWIKORA BUKIT KEMUNING', NULL, NULL, '1', 38),
(39, NULL, NULL, 'CECEP HAMBALI', 'LINGKUNGAN III RT 001/001', '081379330005', NULL, '1', 39),
(40, NULL, '724734553327000', 'ARLAN', 'JL. LINTAS KAPAHIYANG KEL. TEBAT MONOK BENGKULU', '081373181906', NULL, '1', 40),
(41, NULL, '459448882326000', 'LINA ARDIANA', 'MEKAR JAYA RT 005/003 KEL. SUMBER ALAM AIR HITAM LAMBAR', '085609222040', NULL, '1', 41),
(42, NULL, '802313759326000', 'NADA ELWAN', 'KALI PASIR OGAN JAYA RT 001/001 OGAN JAYA PEKURUN', '085766651622', NULL, '1', 42),
(43, NULL, '819747692326000', 'SOLEHUDIN GOJALI', 'KARANG SUTRA RT 011/004 SUKASARI TANJUNG RAJA', '085379891038', NULL, '1', 43),
(44, NULL, ' 722278488326000', 'HUSAIN', 'SUMBER ALAM RT 005/004 DESA SUMBER ALAM KEC. AIR HITAM', '081540832156', NULL, '1', 44),
(45, NULL, '541740726326000', 'IYA MAHYUDIN', 'DESA MEKAR JAYA KEC. GEDUNG SURIAN RT 002/002 LAMPUNG BARAT', '0855269403287', NULL, '1', 45),
(46, NULL, '747581486326000', 'PONIMAN', 'SUKA UTAMA 1 RT 001/001 SUKA JAYA SUMBER JAYA LAMBAR', NULL, NULL, '1', 46),
(47, NULL, '820738177326000', 'JONSON', 'TULUNG BALAK RT 002/002 TULUNG BALAK TANJUNG RAJA', '085380281122', NULL, '1', 47),
(48, NULL, '821297231326000', 'ISKANDAR', 'SINDANG MARGA RT 003/003 TANJUNG RAJA', NULL, NULL, '1', 48),
(49, NULL, NULL, 'NANA WAWAN', 'MUARA DUA', NULL, NULL, '1', 49),
(50, NULL, '168231678302000', 'M. JAILANI', 'KIWIS RAYA WARKUK RANAU SELATAN OKU SELATAN', '085210658083', NULL, '1', 50),
(51, NULL, '820749018302000', 'IMYURID', 'DUSUN 1 BERINGIN MUARA JAYA OGAN KEMERING ULU SUMSEL', NULL, NULL, '1', 51),
(52, NULL, '822107900326000', 'IRWANSYAH', 'CIPTA SARI RT 001/003 KEL. TUGU MULYA KEC. KEBUN TEBU', '0853681000986', NULL, '1', 52),
(53, NULL, '168612091326000', 'TABRANI', 'DESA PULAU PANGGUNG RT 004/004 ABUNG TINGGI LAMMPUNG UTARA', '081369010420', NULL, '1', 53),
(54, NULL, '803993385326000', 'SEPRIYADI', 'TALANG BARU RT 002/002 TALANG BOJONG KOTABUMI', '085279285253', NULL, '1', 54),
(55, NULL, '767839392326000', 'A RONI MURNI', 'JL. SUTTAN PN RAJO ASLI NO. 16 RT 001/001 KOTABUMI ILIR', '082375261199', NULL, '1', 55),
(56, NULL, '769371881326000', 'UNTUNG S', 'POKTAN SRI REJEKI SUKAPURA SUMBER JAYA', NULL, NULL, '1', 56),
(57, NULL, '457595494326000', 'NOVI HERMANSYAH', 'DURENAN RT 001/004 KEL. MUARA JAYA 1 KEC. TEBU', '081379352812', NULL, '1', 57),
(58, NULL, '808777080326000', 'GUSLAL HADIANTO', 'AGUNG RAYA RT 001/006 PURA JAYA KEBUN TEBU', '081379352812', NULL, '1', 58),
(59, NULL, '722356185326000', 'JUMAIRI BABAS', 'PEMANGKU 1 RT 001/001 WAY PETAI SUMBER JAYA', NULL, NULL, '1', 59),
(60, NULL, '1803110510770003', 'SAPARUDIN', 'DESA SUBIK RT 002/001 SUBIK ABUNG TENGAH', '085268856006', NULL, '1', 60),
(61, NULL, '820738177326000', 'JONSON', 'TULUNG BALAK RT 002/002 TULUNG BALAK TANJUNG RAJA', '085380281122', NULL, '1', 61),
(62, NULL, '142318807327000', 'RONA HADI', 'DUSUN BARUMANIS KEC. BARUMANIS ULU LEBONG', NULL, NULL, '1', 62),
(63, NULL, '803993385326000', 'SEPRIYADI', 'TALANG BARU RT 002/002 TALANG BOJONG KOTABUMI', '085279285253', NULL, '1', 63),
(64, NULL, '820811446302000', 'SAHRIL ALI', 'JL. BUMI KAWA DUSUN II KEC. LENGKITI OGAN KOMERING ULU', '008237862684', NULL, '1', 64),
(65, NULL, '169731577326000', 'H HAMZAH TURAYA', 'BANGI SRI AGUNG RT 01/07 ABUNG KUNANG LAMPUNG UTARA', NULL, NULL, '1', 65),
(66, NULL, '725873178326000', 'SARDI', 'SIDOKAYO RT 001/001 KEL. SIDOKAYO ABUNG TINGGI LAMPUNG UTARA', '081272300092', NULL, '1', 66),
(67, NULL, '762225266313000', 'TAMRI', 'DESA TANAH ABANG SEMENDE DARAT LAUT', NULL, NULL, '1', 67),
(68, NULL, '642198659325000', 'SUHENDI', 'DUSUN SIDOHARJO 2 NEGARA RATU RT 18/06 NATAR LAMPUNG SELATAN', NULL, NULL, '1', 68),
(69, NULL, NULL, 'HELMUDIN', 'MARGA SETIA RT 001/001 SUKARAJA WAY TENONG', '08127284856', NULL, '1', 69),
(70, NULL, '75988480236000', 'ASRIN', 'WAY PETAY SUMBER JAYA LAMPUNG BARAT', '081541480379', NULL, '1', 70),
(71, NULL, '154261432327000', 'TASLIM', 'TEBAT KARET KEPAHIYANG BENGKULU', '081271192952', NULL, '1', 71),
(72, NULL, '084891944321000', 'WIRAWAN', 'MARGA WIWIWTAN TUGU SARI SUMBER JAYA LAMPUNG BARAT', '081379707711', 'NULL', '1', 72);

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
('indraa', '$2y$10$4El7mXcaBAs0DrJsq1alDeLKeURlGOOcO6h/I.FB5S0N4lRtV4wYO', 'K', 'ADMINISTRATOR', '1'),
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
('aghany', 7),
('indraa', 11);

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
-- Stand-in structure for view `v_harga_basis`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_harga_basis` (
`id` int(11)
,`tgl` date
,`jenis` varchar(4)
,`harga_basis` double(12,2)
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
-- Stand-in structure for view `v_produk`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_produk` (
`id` int(11)
,`kd_produk` varchar(25)
,`nama` varchar(50)
,`satuan` enum('KG','PCS')
,`ket` text
,`foto` text
,`komposisi` text
,`stok` double(12,2)
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
-- Struktur untuk view `v_harga_basis`
--
DROP TABLE IF EXISTS `v_harga_basis`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_harga_basis`  AS  select `harga_basis`.`id` AS `id`,`harga_basis`.`tgl` AS `tgl`,(case when (`harga_basis`.`jenis` = 'k') then 'KOPI' else 'LADA' end) AS `jenis`,`harga_basis`.`harga_basis` AS `harga_basis` from `harga_basis` order by `harga_basis`.`tgl` desc ;

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
-- Struktur untuk view `v_produk`
--
DROP TABLE IF EXISTS `v_produk`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_produk`  AS  select `p`.`id` AS `id`,`p`.`kd_produk` AS `kd_produk`,`p`.`nama` AS `nama`,`p`.`satuan` AS `satuan`,`p`.`ket` AS `ket`,`p`.`foto` AS `foto`,group_concat(concat_ws(' - ',`b`.`kd_bahan_baku`,`b`.`nama`) separator ',') AS `komposisi`,`p`.`stok` AS `stok` from ((`produk` `p` join `komposisi` `k` on((`k`.`id_produk` = `p`.`id`))) join `bahan_baku` `b` on((`b`.`id` = `k`.`id_bahan_baku`))) group by `p`.`id` ;

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
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `harga_basis`
--
ALTER TABLE `harga_basis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
-- AUTO_INCREMENT for table `komposisi`
--
ALTER TABLE `komposisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `mutasi_bahan_baku`
--
ALTER TABLE `mutasi_bahan_baku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mutasi_produk`
--
ALTER TABLE `mutasi_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
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
