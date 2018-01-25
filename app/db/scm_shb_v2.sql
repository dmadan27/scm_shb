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

	-- Tabel kir_kopi

	-- Tabel kir_lada

	-- Tabel analisa harga

	-- Tabel pembelian

	-- Tabel detail pembelian

	-- Tabel pemesanan

	-- Tabel pengiriman

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
			kd_bahan_baku, nama, satuan, ket, foto, stok) 
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
			kd_produk, nama, satuan, ket, foto, stok) 
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
			p.stok
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

	-- View pembelian

	-- View pemesanan

	-- View pengiriman

	-- View perencanaan pengadaan bahan baku
	-- CREATE OR REPLACE VIEW v_perencanaan_bahan_baku AS
	-- 	SELECT
	-- 		p.id id_perencanaan_bahan_baku, p.tgl, p.periode,
	-- 		pr.id id_produk, pr.kd_produk kd_produk, pr.nama nama_produk, pr.satuan satuan_produk,
	-- 		p.jumlah_perencanaan,
	-- 		GROUP_CONCAT(concat_ws(' ', concat_ws(' - ', bb.nama, dp.jumlah_bahan_baku), bb.satuan)) jumlah_bahan_baku
	-- 	FROM peramalan p
	-- 	JOIN detail_peramalan dp ON dp.id_peramalan = p.id
	-- 	JOIN produk pr ON pr.id = p.id_produk
	-- 	JOIN bahan_baku bb ON bb.id = dp.id_bahan_baku
	-- 	GROUP BY p.id
	-- 	ORDER BY p.id ASC;

# =========================================== #

# ======================================================================== #