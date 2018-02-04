# Database SCM SHB #
# Version 2.0 #

# ======================================================================== #

# ================= TABEL =================== #
	-- Tabel pekerjaan
	CREATE TABLE pekerjaan(
		id int NOT NULL AUTO_INCREMENT,
		nama varchar(50),
		ket text,

		CONSTRAINT pk_pekerjaan_id PRIMARY KEY(id)
	);

	-- Tabel karyawan
	CREATE TABLE karyawan(
		id int NOT NULL AUTO_INCREMENT,
		no_induk varchar(20),
		nik varchar(16),
		npwp varchar(16),
		nama varchar(255),
		tempat_lahir varchar(255),
		tgl_lahir date,
		jk char(1), -- jenis kelamin. l: laki-laki, p: perempuan
		alamat text,
		telp varchar(20),
		email varchar(50),
		foto text,
		tgl_masuk date,
		id_pekerjaan int, -- fk
		status char(1), -- 1: aktif/masih bekerja, 0: non-aktif/tidak bekerja lagi

		CONSTRAINT pk_karyawan_id PRIMARY KEY(id),
		CONSTRAINT fk_karyawan_id_pekerjaan FOREIGN KEY(id_pekerjaan) REFERENCES pekerjaan(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel supplier
	CREATE TABLE supplier(
		id int NOT NULL AUTO_INCREMENT,
		nik varchar(16),
		npwp varchar(16),
		nama varchar(255),
		alamat text,
		telp varchar(20),
		email varchar(50),
		status char(1), -- 1: utama, 0: pengganti
		supplier_utama int, -- fk diri sendiri
		
		CONSTRAINT pk_supplier_id PRIMARY KEY(id)
	);

	-- Tabel buyer
	CREATE TABLE buyer(
		id int NOT NULL AUTO_INCREMENT,
		npwp varchar(20),
		nama varchar(255),
		alamat text,
		telp varchar(20),
		email varchar(50),
		foto text,
		status char(1), -- 1: aktif 0: non-aktif

		CONSTRAINT pk_buyer_id PRIMARY KEY(id)
	);

	-- Tabel bahan baku
	CREATE TABLE bahan_baku(
		id int NOT NULL AUTO_INCREMENT,
		kd_bahan_baku varchar(25),
		nama varchar(50),
		satuan enum('KG', 'PCS'),
		ket text,
		foto text,
		stok_akhir double(12,2),

		CONSTRAINT pk_bahan_baku_id PRIMARY KEY(id)
	);

	-- Tabel produk
	CREATE TABLE produk(
		id int NOT NULL AUTO_INCREMENT,
		kd_produk varchar(25),
		nama varchar(50),
		satuan enum('KG', 'PCS'),
		ket text,
		foto text,
		stok_akhir double(12,2),

		CONSTRAINT pk_produk_id PRIMARY KEY(id)	
	);

	-- Tabel komposisi
	CREATE TABLE komposisi(
		id int NOT NULL AUTO_INCREMENT,
		id_produk int,
		id_bahan_baku int,
		penyusutan double(5,2),

		CONSTRAINT pk_komposisi_id PRIMARY KEY(id),
		CONSTRAINT fk_komposisi_id_produk FOREIGN KEY(id_produk) REFERENCES produk(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_komposisi_id_bahan_baku FOREIGN KEY(id_bahan_baku) REFERENCES bahan_baku(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel harga basis
	CREATE TABLE harga_basis(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		jenis char(1), -- k: basis kopi, l: basis lada hitam
		harga_basis double(12,2),

		CONSTRAINT pk_harga_basis_id PRIMARY KEY(id)
	);

	-- Tabel kendaraan
	CREATE TABLE kendaraan(
		id int NOT NULL AUTO_INCREMENT,
		no_polis varchar(10),
		id_supir int, -- fk dari karyawan yg jabatannya supir
		pendamping varchar(255),
		tahun year,
		jenis char(1), -- c: colt diesel, f: fuso
		muatan double(8,2), -- kg
		foto text,
		status char(1), -- 1: tersedia, 0: tidak tersedia

		CONSTRAINT pk_kendaraan_id PRIMARY KEY(id),
		CONSTRAINT fk_kendaraan_id_supir FOREIGN KEY(id_supir) REFERENCES karyawan(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel User
	CREATE TABLE user(
		username varchar(10) NOT NULL,
		password text NOT NULL,
		-- jenis char(1), -- k: karyawan, b: buyer
		id_karyawan int,
		hak_akses varchar(50),
		status char(1), -- 1: aktif, 0: non-aktif

		CONSTRAINT pk_user_username PRIMARY KEY(username),
		CONSTRAINT fk_user_id_karyawan FOREIGN KEY(id_karyawan) REFERENCES karyawan(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel kir
	CREATE TABLE kir(
		id int NOT NULL AUTO_INCREMENT,
		kd_kir varchar(25), -- KIR-kopi/lada-tgl-increment
		tgl date, -- tgl dan jam
		id_supplier int, -- fk
		jenis_bahan_baku char(1), -- jenis bahan baku (kopi/lada) k: kopi, l: lada
		status char(1), -- 1: sesuai standar/dibeli, 0: dibawah standar/tidak dibeli

		CONSTRAINT pk_kir_id PRIMARY KEY(id),
		CONSTRAINT fk_kir_id_supplier FOREIGN KEY(id_supplier) REFERENCES supplier(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel kir_kopi
	CREATE TABLE kir_kopi(
		id int NOT NULL AUTO_INCREMENT, 
		id_kir int, -- fk
		trase double(5,2),
		gelondong double(5,2),
		air double(5,2),
		ayakan double(5,2),
		kulit double(5,2),
		rendemen double(5,2),

		CONSTRAINT pk_kir_kopi_id PRIMARY KEY(id),
		CONSTRAINT fk_kir_kopi_id_kir FOREIGN KEY(id_kir) REFERENCES kir(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel kir_lada
	CREATE TABLE kir_lada(
		id int NOT NULL AUTO_INCREMENT,
		id_kir int, -- fk
		air double(5,2),
		berat int,
		abu double(5,2),

		CONSTRAINT pk_kir_lada_id PRIMARY KEY(id),
		CONSTRAINT fk_kir_lada_id_kir FOREIGN KEY(id_kir) REFERENCES kir(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel analisa harga
	CREATE TABLE analisa_harga(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		id_kir int, -- fk
		id_harga_basis int, -- fk
		harga_basis double(12,2),
		harga_beli double(12,2),
		status char(1), -- status analisa harga

		CONSTRAINT pk_analisa_harga_id PRIMARY KEY(id),
		CONSTRAINT fk_analisa_harga_id_kir FOREIGN KEY(id_kir) REFERENCES kir(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_analisa_harga_id_harga_basis FOREIGN KEY(id_harga_basis) REFERENCES harga_basis(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel pembelian
	CREATE TABLE pembelian_bahan_baku(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		invoice varchar(25), -- kombinasi kode PB-tgl-increment
		id_supplier int, -- fk
		jenis_pembayaran char(1), -- c: cash, t: transfer
		jenis_pph double(5,2),
		pph double(12,2),
		total double(12,2),
		ket text,
		status char(1), -- l: lunas, t: titipan

		CONSTRAINT pk_pembelian_id PRIMARY KEY(id),
		CONSTRAINT fk_pembelian_id_supplier FOREIGN KEY(id_supplier) REFERENCES supplier(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel detail pembelian
	CREATE TABLE detail_pembelian(
		id int NOT NULL AUTO_INCREMENT,
		id_pembelian int, -- fk
		id_bahan_baku int, -- fk
		id_analisa_harga int, -- fk
		colly int,
		jumlah double(12,2),
		harga double(12,2),
		subtotal double(12,2),

		CONSTRAINT pk_detail_pembelian PRIMARY KEY(id),
		CONSTRAINT fk_detail_pembelian_id_pembelian FOREIGN KEY(id_pembelian) REFERENCES pembelian_bahan_baku(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_detail_pembelian_id_bahan_baku FOREIGN KEY(id_bahan_baku) REFERENCES bahan_baku(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_detail_pembelian_id_analisa_harga FOREIGN KEY(id_analisa_harga) REFERENCES analisa_harga(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel pemesanan
	CREATE TABLE pemesanan(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		no_kontrak varchar(50),
		id_buyer int, -- fk
		id_produk int, -- fk dari barang (produk)
		jumlah_karung int,
		ket_karung enum('JUMLAH PASTI', 'PERKIRAAN'),
		kemasan enum('KARUNG GONI', 'KARUNG PLASTIK'),
		jumlah double(12,2), -- jumlah barang (kg)
		waktu_pengiriman date, -- tgl pengiriman
		batas_waktu_pengiriman date,
		ket text, -- keterangan kontrak
		lampiran text, -- lampiran file kontrak
		status char(1), -- status kontrak/pemesanan, s: sukses, p: proses, w: pending, r: reject

		CONSTRAINT pk_pemesanan_id PRIMARY KEY(id),
		CONSTRAINT fk_pemesanan_id_buyer FOREIGN KEY(id_buyer) REFERENCES buyer(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_pemesanan_id_produk FOREIGN KEY(id_produk) REFERENCES produk(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel pengiriman
	CREATE TABLE pengiriman(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		id_pemesanan int, -- fk
		id_kendaraan int, -- fk
		colly int,
		jumlah double(12,2),
		status char(1), -- status pengiriman. perjalanan/on delivery, terkirim, sedang di proses

		CONSTRAINT pk_pengiriman_id PRIMARY KEY(id),
		CONSTRAINT fk_pengiriman_id_pemesanan FOREIGN KEY(id_pemesanan) REFERENCES pemesanan(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_pengiriman_id_kendaraan FOREIGN KEY(id_kendaraan) REFERENCES kendaraan(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel perencanaan pengadaan bahan baku
	CREATE TABLE perencanaan_bahan_baku(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		periode varchar(15),
		id_produk int, -- fk
		jumlah_perencanaan double(12,2),
		safety_stok_produk double(12,2),

		CONSTRAINT pk_perencanaan_bahan_baku_id PRIMARY KEY(id),
		CONSTRAINT fk_perencanaan_bahan_baku_id_produk FOREIGN KEY(id_produk) REFERENCES produk(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel mutasi bahan baku
	CREATE TABLE mutasi_bahan_baku(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		id_bahan_baku int, -- fk
		brg_masuk double(12,2),
		brg_keluar double(12,2),

		CONSTRAINT pk_mutasi_bahan_baku_id PRIMARY KEY(id),
		CONSTRAINT fk_mutasi_bahan_baku_id_bahan_baku FOREIGN KEY(id_bahan_baku) REFERENCES bahan_baku(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel mutasi produk
	CREATE TABLE mutasi_produk(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		id_produk int, -- fk
		brg_masuk double(12,2),
		brg_keluar double(12,2),

		CONSTRAINT pk_mutasi_produk_id PRIMARY KEY(id),
		CONSTRAINT fk_mutasi_produk_id_produk FOREIGN KEY(id_produk) REFERENCES produk(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel produksi
	CREATE TABLE produksi(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		id_produk int, -- fk
		hasil_produksi double(12,2),

		CONSTRAINT pk_produksi_id PRIMARY KEY(id),
		CONSTRAINT fk_produksi_id_produksi FOREIGN KEY(id_produk) REFERENCES produk(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

	-- Tabel detail produksi
	CREATE TABLE detail_produksi(
		id int NOT NULL AUTO_INCREMENT,
		id_produksi int, -- fk
		id_bahan_baku int, -- fk
		jumlah double(12,2),

		CONSTRAINT pk_detail_produksi_id PRIMARY KEY(id),
		CONSTRAINT fk_detail_produksi_id_produksi FOREIGN KEY(id_produksi) REFERENCES produksi(id)
			ON DELETE RESTRICT ON UPDATE CASCADE,
		CONSTRAINT fk_detail_produksi_id_bahan_baku FOREIGN KEY(id_bahan_baku) REFERENCES bahan_baku(id)
			ON DELETE RESTRICT ON UPDATE CASCADE
	);

# =========================================== #

# =============== PROCEDURE ================= #
	-- Tambah supplier
	CREATE PROCEDURE tambah_supplier(
		in nik_param varchar(16),
		in npwp_param varchar(20),
		in nama_param varchar(255),
		in alamat_param text,
		in telp_param varchar(20),
		in email_param varchar(50),
		in status_param char(1),
		in id_supplier_utama_param int
	)
	BEGIN
		DECLARE id_param int;

		-- get auto increment supplier
		SELECT `AUTO_INCREMENT` INTO id_param 
			FROM INFORMATION_SCHEMA.TABLES 
			WHERE TABLE_SCHEMA = 'scm_shb' AND TABLE_NAME = 'supplier';

		-- cek status
		IF status_param = '1' THEN -- jika utama, maka supplier utama sama
			-- insert supplier
			INSERT INTO supplier 
				(nik, npwp, nama, alamat, telp, email, status, supplier_utama) 
			VALUES 
				(nik_param, npwp_param, nama_param, alamat_param, 
				telp_param, email_param, status_param, id_param);
		ELSE -- jika pengganti
			-- insert supplier
			INSERT INTO supplier 
				(nik, npwp, nama, alamat, telp, email, status, supplier_utama) 
			VALUES 
				(nik_param, npwp_param, nama_param, alamat_param, 
				telp_param, email_param, status_param, id_supplier_utama_param);
		END IF;	
	END;

	-- Tambah bahan baku
	CREATE PROCEDURE tambah_bahan_baku(
		-- in id_bahan_baku_param int,
		in kd_bahan_baku_param varchar(25),
		in nama_param varchar(50),
		in satuan_param varchar(10),
		in ket_param text,
		in foto_param text,
		in tgl_param date,
		in stok_param double(12,2)
	)
	BEGIN
		DECLARE id_param int;

		SELECT `AUTO_INCREMENT` INTO id_param 
	    FROM INFORMATION_SCHEMA.TABLES 
	    WHERE TABLE_SCHEMA = 'scm_shb' AND TABLE_NAME = 'bahan_baku';
		
		-- Insert bahan baku
		INSERT INTO bahan_baku(
			kd_bahan_baku, nama, satuan, ket, foto, stok_akhir) 
		VALUES(
			kd_bahan_baku_param, nama_param, satuan_param, ket_param, foto_param, stok_param);

		-- Insert mutasi barang
		INSERT INTO mutasi_bahan_baku(
			tgl, id_bahan_baku, brg_masuk, brg_keluar) 
		VALUES(tgl_param, id_param, 0, 0);
	END;

	-- Tambah produk
	CREATE PROCEDURE tambah_produk(
		-- in id_produk_param int,
		in kd_produk_param varchar(25),
		in nama_param varchar(50),
		in satuan_param varchar(10),
		in ket_param text,
		in foto_param text,
		in tgl_param date,
		in stok_param double(12,2)
	)
	BEGIN
		DECLARE id_param int;

		SELECT `AUTO_INCREMENT` INTO id_param 
	    FROM INFORMATION_SCHEMA.TABLES 
	    WHERE TABLE_SCHEMA = 'scm_shb' AND TABLE_NAME = 'produk';

	    -- Insert produk
		INSERT INTO produk(
			kd_produk, nama, satuan, ket, foto, stok_akhir) 
		VALUES(
			kd_produk_param, nama_param, satuan_param, ket_param, foto_param, stok_param);

		-- Insert mutasi produk
		INSERT INTO mutasi_produk(
			tgl, id_produk, brg_masuk, brg_keluar) 
		VALUES(tgl_param, id_param, 0, 0);
	END;

	-- Tambah komposisi
	CREATE PROCEDURE tambah_komposisi(
		in kd_produk_param varchar(25),
		in id_bahan_baku_param int,
		in penyusutan_param double(5,2)
	)
	BEGIN
		DECLARE id_produk_param int;

		SELECT id INTO id_produk_param FROM produk WHERE kd_produk = kd_produk_param;

		-- insert komposisi
		INSERT INTO komposisi(id_produk, id_bahan_baku, penyusutan) VALUES(id_produk_param, id_bahan_baku_param, penyusutan_param);
	END;

	-- Tambah kir kopi
	CREATE PROCEDURE tambah_kir_kopi(
		in kd_kir_param varchar(25),
		in trase_param double(5,2),
		in gelondong_param double(5,2),
		in air_param double(5,2),
		in ayakan_param double(5,2),
		in kulit_param double(5,2),
		in rendemen_param double(5,2)
	)
	BEGIN
		DECLARE id_kir_param int;

		-- get id kir by kd_kir
		SELECT id INTO id_kir_param FROM kir WHERE kd_kir = kd_kir_param;

		-- insert kir kopi
		INSERT INTO kir_kopi (id_kir, trase, gelondong, air, ayakan, kulit, rendemen) 
		VALUES (id_kir_param, trase_param, gelondong_param, air_param, ayakan_param, kulit_param, rendemen_param);
	END;

	-- Tambah kir lada
	CREATE PROCEDURE tambah_kir_lada(
		in kd_kir_param varchar(25),
		in air_param double(5,2),
		in berat_param int,
		in abu_param double(5,2)
	)
	BEGIN
		DECLARE id_kir_param int;

		-- get id kir by kd_kir
		SELECT id INTO id_kir_param FROM kir WHERE kd_kir = kd_kir_param;

		-- insert kir kopi
		INSERT INTO kir_lada (id_kir, air, berat, abu) 
		VALUES (id_kir_param, air_param, berat_param, abu_param);
	END;

	-- Tambah Detail Pembelian
	CREATE PROCEDURE tambah_detail_pembelian(
		in invoice_param varchar(25),
		in tgl_param date,
		in id_bahan_baku_param int,
		in id_analisa_harga_param int,
		in colly_param int,
		in jumlah_param double(12,2),
		in harga_param double(12,2),
		in subtotal_param double(12,2)
	)
	BEGIN
		DECLARE id_pembelian_param int;
		DECLARE cek_tgl int;
		DECLARE get_brg_masuk double(12,2);

		SELECT id INTO id_pembelian_param FROM pembelian_bahan_baku WHERE invoice = invoice_param;

		-- insert detail
		INSERT INTO detail_pembelian 
			(id_pembelian, id_bahan_baku, id_analisa_harga, colly, jumlah, harga, subtotal)
		VALUES
			(id_pembelian_param, id_bahan_baku_param, id_analisa_harga_param, 
				colly_param, jumlah_param, harga_param, subtotal_param);

		-- get tgl mutasi
		SELECT COUNT(tgl) INTO cek_tgl FROM mutasi_bahan_baku WHERE tgl=tgl_param AND id_bahan_baku = id_bahan_baku_param;

		IF cek_tgl > 0 THEN -- jika tgl pembelian dan mutasi sesuai
			-- get barang masuk
			SELECT brg_masuk INTO get_brg_masuk FROM mutasi_bahan_baku WHERE id_bahan_baku = id_bahan_baku_param AND tgl = tgl_param;

			UPDATE mutasi_bahan_baku SET
				brg_masuk = (jumlah_param+get_brg_masuk)
			WHERE
				id_bahan_baku = id_bahan_baku_param AND tgl = tgl_param;

		ELSE -- jika tgl pembelian tidak ada yg sama dgn tgl mutasi
			-- insert mutasi bahan baku
			INSERT INTO mutasi_bahan_baku (tgl, id_bahan_baku, brg_masuk, brg_keluar)
			VALUES (tgl_param, id_bahan_baku_param, jumlah_param, '');

		END IF;
	END;

# =========================================== #

# ================== VIEW =================== #
	-- View karyawan
	CREATE OR REPLACE VIEW v_karyawan AS
		SELECT 
			k.id, k.no_induk, k.nik, k.npwp, k.nama, k.tempat_lahir, k.tgl_lahir,
			(CASE WHEN (k.jk = 'L') THEN 'LAKI-LAKI' ELSE 'PEREMPUAN' END) jk, 
			k.alamat, k.telp, k.email, k.foto, k.tgl_masuk, k.id_pekerjaan, p.nama jabatan,
			(CASE WHEN (k.status = '1') THEN 'AKTIF' ELSE 'NON-AKTIF' END) status
		FROM karyawan k
		JOIN pekerjaan p ON p.id = k.id_pekerjaan
		ORDER BY k.no_induk ASC, k.id_pekerjaan ASC, status ASC;

	-- View supplier
	CREATE OR REPLACE VIEW v_supplier AS
		SELECT
			s.id, s.nik, s.npwp, s.nama, s.alamat, s.telp, s.email,
			(CASE WHEN (s.status = '1') THEN 'UTAMA' ELSE 'PENGGANTI' END) status,
			s2.id id_utama, s2.nama nama_utama
		FROM supplier s
		JOIN supplier s2 ON s2.id=s.supplier_utama
		ORDER BY status DESC, s.id ASC;

	-- View buyer
	CREATE OR REPLACE VIEW v_buyer AS
		SELECT id, npwp, nama, alamat, telp, email, 
			(CASE WHEN (status = '1') THEN 'AKTIF' ELSE 'NON-AKTIF' END) status,
			foto
		FROM buyer
		ORDER BY id ASC;

	-- View bahan baku

	-- View produk
	CREATE OR REPLACE VIEW v_produk AS
		SELECT 
			p.id, p.kd_produk, p.nama, p.satuan, p.ket, p.foto, 
			GROUP_CONCAT(concat_ws(' - ', b.kd_bahan_baku, b.nama)) komposisi,
			p.stok_akhir
		FROM produk p
		JOIN komposisi k ON k.id_produk=p.id
		JOIN bahan_baku b ON b.id=k.id_bahan_baku
		GROUP BY p.id 
		ORDER BY p.id ASC;

	-- View harga basis
	CREATE OR REPLACE VIEW v_harga_basis AS
		SELECT
			id, tgl,
			(CASE WHEN (jenis = 'k') THEN 'KOPI' ELSE 'LADA' END) jenis,
			harga_basis
		FROM harga_basis
		ORDER BY tgl DESC;

	-- View kendaraan
	CREATE OR REPLACE VIEW v_kendaraan AS
		SELECT 
			k.id, k.no_polis, k.id_supir, kry.nama supir, k.pendamping, k.tahun, 
			(CASE WHEN (k.jenis = 'C') THEN 'COLT DIESEL' ELSE 'FUSSO' END) jenis, 
			k.muatan, k.foto,
			(CASE WHEN (k.status = '1') THEN 'TERSEDIA' ELSE 'TIDAK TERSEDIA' END) status
		FROM kendaraan k
		JOIN karyawan kry ON kry.id = k.id_supir
		ORDER BY id ASC, status ASC;

	-- View User
	CREATE OR REPLACE VIEW v_user AS
		SELECT
			u.username, k.nama, p.nama jabatan, u.hak_akses,
			(CASE WHEN (u.status = '1') THEN 'AKTIF' ELSE 'NON-AKTIF' END) status
		FROM user u
		JOIN karyawan k ON k.id = u.id_karyawan
		JOIN pekerjaan p ON p.id = k.id_pekerjaan
		ORDER BY u.id_karyawan ASC;

	-- View kir
	CREATE OR REPLACE VIEW v_kir AS
		SELECT
			k.id, k.kd_kir, k.tgl, 
			k.id_supplier, s.nik, s.npwp, s.nama nama_supplier,
			(CASE WHEN (k.jenis_bahan_baku = 'K') THEN 'KOPI ASALAN' ELSE 'LADA HITAM ASALAN' END) jenis_bahan_baku,
			(CASE WHEN (k.status = '1') THEN 'SESUAI STANDAR' ELSE 'DIBAWAH STANDAR' END) status
		FROM kir k
		JOIN supplier s ON s.id = k.id_supplier
		ORDER BY k.tgl DESC;

	-- View kir kopi

	-- View kir lada

	-- view analisa harga
	CREATE OR REPLACE VIEW v_analisa_harga AS
		SELECT
			ah.id id_analisa_harga, ah.tgl tgl_analisa, 
    		k.id id_kir, k.kd_kir kd_kir, 
    		(CASE WHEN (k.jenis_bahan_baku = "K") THEN "KOPI ASALAN" ELSE "LADA HITAM ASALAN" END) jenis_kir,
    		hb.id id_harga_basis, 
    		(CASE WHEN (hb.jenis = "K") THEN "BASIS KOPI" ELSE "BASIS LADA" END) jenis_basis, 
    		hb.harga_basis hb_harga_basis, ah.harga_basis harga_basis, ah.harga_beli harga_beli,
    		s.id id_supplier, s.nama nama_supplier, s.nik, s.npwp, s.supplier_utama,
		    (CASE WHEN (ah.status = "1") THEN "SUDAH DIBAYAR" ELSE "BELUM DIBAYAR" END) status_analisa
		FROM analisa_harga ah
		JOIN kir k ON k.id = ah.id_kir
		JOIN harga_basis hb ON hb.id = ah.id_harga_basis
		JOIN supplier s ON s.id = k.id_supplier
		ORDER BY ah.tgl DESC;

	-- View pembelian

	-- View pemesanan
	CREATE OR REPLACE VIEW v_pemesanan AS
		SELECT
			p.id id_pemesanan, p.tgl, p.no_kontrak,
		    p.id_buyer, b.nama nama_buyer,
		    p.id_produk, pr.nama nama_produk, pr.satuan satuan_produk,
		    p.jumlah_karung, p.ket_karung, p.kemasan, p.jumlah,
		    p.waktu_pengiriman, p.batas_waktu_pengiriman, p.ket, p.lampiran,
		    (CASE 
		     	WHEN (p.status = 'S') THEN 'SUKSES'
		     	WHEN (p.status = 'P') THEN 'PROSES' 
		     	WHEN (p.status = 'W') THEN 'PENDING'
		     	ELSE 'REJECT' 
		     END) status
		FROM pemesanan p
		JOIN buyer b ON b.id = p.id_buyer
		JOIN produk pr ON pr.id = p.id_produk
		ORDER BY p.tgl DESC; 

	-- View pengiriman

	-- View perencanaan pengadaan bahan baku
	CREATE OR REPLACE VIEW v_perencanaan_bahan_baku AS
		SELECT
			pbb.id, pbb.tgl, pbb.periode, 
			pr.id id_produk, pr.kd_produk, pr.nama nama_produk, pr.satuan satuan_produk,
		    pbb.jumlah_perencanaan, pbb.safety_stok_produk,
		   	GROUP_CONCAT(concat_ws(' - ', bb.kd_bahan_baku, bb.nama)) komposisi
		FROM perencanaan_bahan_baku pbb
		JOIN produk pr ON pr.id = pbb.id_produk
		JOIN komposisi k ON k.id_produk = pr.id
		JOIN bahan_baku bb ON bb.id = k.id_bahan_baku
		GROUP BY pbb.id
		ORDER BY pbb.periode DESC;

# =========================================== #

# ======================================================================== #