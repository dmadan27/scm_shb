# Database SCM SHB #
# Version 1.0 #

# ======================================================================== #

# ================= TABEL =================== #
	-- Data Karyawan
		-- Tabel Pekerjaan
		CREATE TABLE pekerjaan(
			id int NOT NULL AUTO_INCREMENT,
			nama varchar(50),
			ket text,

			CONSTRAINT pk_pekerjaan_id PRIMARY KEY(id)
		);

		-- Tabel Karyawan
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
			-- gaji_pokok double(10,2),
			status char(1), -- 1: aktif/masih bekerja, 0: non-aktif/tidak bekerja lagi

			CONSTRAINT pk_karyawan_id PRIMARY KEY(id),
			CONSTRAINT fk_karyawan_id_pekerjaan FOREIGN KEY(id_pekerjaan) REFERENCES pekerjaan(id)
		);

	-- Tabel Kendaraan
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
	);

	-- Tabel Bahan baku
	CREATE TABLE bahan_baku(
		id int NOT NULL AUTO_INCREMENT,
		kd_bahan_baku varchar(25),
		nama varchar(50),
		satuan enum('KG', 'PCS'),
		ket text,
		foto text,
		stok double(12,2),

		CONSTRAINT pk_bahan_baku_id PRIMARY KEY(id)
	);

	-- Tabel Produk
	CREATE TABLE produk(
		id int NOT NULL AUTO_INCREMENT,
		kd_produk varchar(25),
		nama varchar(50),
		satuan enum('KG', 'PCS'),
		ket text,
		foto text,
		stok double(12,2),

		CONSTRAINT pk_produk_id PRIMARY KEY(id)	
	);

	-- Tabel komposisi
	CREATE TABLE komposisi(
		id int NOT NULL AUTO_INCREMENT,
		id_produk int,
		id_bahan_baku int,

		CONSTRAINT pk_komposisi_id PRIMARY KEY(id),
		CONSTRAINT fk_komposisi_id_produk FOREIGN KEY(id_produk) REFERENCES produk(id),
		CONSTRAINT fk_komposisi_id_bahan_baku FOREIGN KEY(id_bahan_baku) REFERENCES bahan_baku(id)
	);

	-- Data Supplier
		-- Tabel Supplier
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

		-- -- Tabel detail supplier
		-- CREATE TABLE detail_supplier(
		-- 	id int NOT NULL AUTO_INCREMENT,
		-- 	id_supplier int, -- fk
		-- 	id_supplier_utama int, -- fk

		-- 	CONSTRAINT pk_detail_supplier_id PRIMARY KEY(id),
		-- 	CONSTRAINT fk_detail_supplier_id_supplier FOREIGN KEY(id_supplier) REFERENCES supplier(id),
		-- 	CONSTRAINT fk_detail_supplier_id_supplier_utama FOREIGN KEY(id_supplier_utama) REFERENCES supplier(id)
		-- );

	-- Tabel Buyer
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

	-- Data User
		-- Tabel Hak Akses
		-- CREATE TABLE hak_akses(
		-- 	id int NOT NULL AUTO_INCREMENT,
		-- 	hak_akses varchar(255),
		-- 	menu varchar(255),

		-- 	CONSTRAINT pk_hak_akses_id PRIMARY KEY(id)
		-- );

		-- Tabel user
		CREATE TABLE user(
			username varchar(10) NOT NULL,
			password text NOT NULL,
			jenis char(1), -- k: karyawan, b: buyer
			hak_akses varchar(50),
			status char(1), -- 1: aktif, 0: non-aktif

			CONSTRAINT pk_user_username PRIMARY KEY(username)
		);

		-- Tabel Detail hak akses user
		-- CREATE TABLE hak_akses(
		-- 	-- id int NOT NULL AUTO_INCREMENT,
		-- 	username varchar(10), -- fk
		-- 	hak_akses varchar(50),

		-- 	CONSTRAINT fk_hak_akses_username FOREIGN KEY(username) REFERENCES user(username)
		-- );
		
		-- Tabel user karyawan
		CREATE TABLE user_karyawan(
			-- id int NOT NULL AUTO_INCREMENT,
			username varchar(10), -- fk
			id_karyawan int, -- fk

			-- CONSTRAINT pk_user_karyawan_id PRIMARY KEY(id),
			CONSTRAINT fk_user_karyawan_username FOREIGN KEY(username) REFERENCES user(username),
			CONSTRAINT fk_user_karyawan_id_karyawan FOREIGN KEY(id_karyawan) REFERENCES karyawan(id)
		);
		
		-- Tabel user buyer
		CREATE TABLE user_buyer(
			-- id int NOT NULL AUTO_INCREMENT,
			username varchar(10), -- fk
			id_buyer int, -- fk

			-- CONSTRAINT pk_user_buyer_id PRIMARY KEY(id),
			CONSTRAINT fk_user_buyer_username FOREIGN KEY(username) REFERENCES user(username),
			CONSTRAINT fk_user_karyawan_id_buyer FOREIGN KEY(id_buyer) REFERENCES buyer(id)
		);

		-- Tabel user supplier
		-- CREATE TABLE user_supplier(
		-- 	-- id int NOT NULL AUTO_INCREMENT, 
		-- 	username varchar(10), -- fk
		-- 	id_supplier int, -- fk

		-- 	-- CONSTRAINT pk_user_supplier_id PRIMARY KEY(id),
		-- 	CONSTRAINT fk_user_supplier_username FOREIGN KEY(username) REFERENCES user(username)
		-- );

	-- Data KIR
		-- Tabel KIR
		CREATE TABLE kir(
			id int NOT NULL AUTO_INCREMENT,
			kd_kir varchar(25), -- KIR-kopi/lada-tgl-increment
			tgl date, -- tgl dan jam
			id_supplier int, -- fk
			jenis_bahan_baku char(1), -- jenis bahan baku (kopi/lada) k: kopi, l: lada
			status char(1), -- 1: sesuai standar/dibeli, 0: dibawah standar/tidak dibeli

			CONSTRAINT pk_kir_id PRIMARY KEY(id),
			CONSTRAINT fk_kir_id_supplier FOREIGN KEY(id_supplier) REFERENCES supplier(id)
		);

		-- Tabel KIR Kopi
		CREATE TABLE kir_kopi(
			-- id int NOT NULL AUTO_INCREMENT, 
			id_kir int, -- fk
			trase double(5,2),
			gelondong double(5,2),
			air double(5,2),
			ayakan double(5,2),
			kulit double(5,2),
			rendemen double(5,2),

			-- CONSTRAINT pk_kir_kopi_id PRIMARY KEY(id),
			CONSTRAINT fk_kir_kopi_id_kir FOREIGN KEY(id_kir) REFERENCES kir(id)
		);

		-- Tabel KIR Lada
		CREATE TABLE kir_lada(
			-- id int NOT NULL AUTO_INCREMENT,
			id_kir int, -- fk
			air double(5,2),
			berat int,
			abu double(5,2),

			-- CONSTRAINT pk_kir_lada_id PRIMARY KEY(id),
			CONSTRAINT fk_kir_lada_id_kir FOREIGN KEY(id_kir) REFERENCES kir(id)
		);

	-- Tabel Basis (optional)
	CREATE TABLE harga_basis(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		jenis char(1), -- k: basis kopi, l: basis lada hitam
		harga_basis double(12,2),

		CONSTRAINT pk_harga_basis_id PRIMARY KEY(id)
	);

	-- Tabel Analisa Harga
	CREATE TABLE analisa_harga(
		id int NOT NULL AUTO_INCREMENT,
		tgl date,
		id_kir int, -- fk
		id_basis int,
		harga_basis double(12,2),
		harga_beli double(12,2),

		CONSTRAINT pk_analisa_harga_id PRIMARY KEY(id),
		CONSTRAINT fk_analisa_harga_id_kir FOREIGN KEY(id_kir) REFERENCES kir(id)
	);

	-- Data Pembelian Bahan Baku
		-- Tabel Pembelian
		CREATE TABLE pembelian(
			id int NOT NULL AUTO_INCREMENT,
			tgl date,
			invoice varchar(25), -- kombinasi kode PB-tgl-increment
			id_supplier int, -- fk
			jenis_pembayaran char(1), -- c: cash, t: transfer
			jenis_pph double(5,2),
			pph double(12,2),
			ket text,
			status char(1), -- l: lunas, t: titipan
			-- user varchar(10),

			CONSTRAINT pk_pembelian_id PRIMARY KEY(id),
			CONSTRAINT fk_pembelian_id_supplier FOREIGN KEY(id_supplier) REFERENCES supplier(id)
		);

		-- Tabel Detail Pembelian
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
			CONSTRAINT fk_detail_pembelian_id_pembelian FOREIGN KEY(id_pembelian) REFERENCES pembelian(id),
			CONSTRAINT fk_detail_pembelian_id_bahan_baku FOREIGN KEY(id_bahan_baku) REFERENCES bahan_baku(id),
			CONSTRAINT fk_detail_pembelian_id_analisa_harga FOREIGN KEY(id_analisa_harga) REFERENCES analisa_harga(id)
		);

	-- Data Penjualan
		-- Tabel pemesanan (belum beres)
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
			-- differential int, -- harga
			-- terminal date, -- month/date
			waktu_pengiriman date, -- tgl pengiriman
			batas_waktu_pengiriman date,
			ket text, -- keterangan kontrak
			lampiran text, -- lampiran file kontrak
			status char(1), -- status kontrak/pemesanan, s: sukses, p: pending, r: reject
			-- user varchar(10),

			CONSTRAINT pk_pemesanan_id PRIMARY KEY(id),
			CONSTRAINT fk_pemesanan_id_buyer FOREIGN KEY(id_buyer) REFERENCES buyer(id),
			CONSTRAINT fk_pemesanan_id_produk FOREIGN KEY(id_produk) REFERENCES produk(id),
		);

		-- Tabel pengiriman (belum beres)
		CREATE TABLE pengiriman(
			id int NOT NULL AUTO_INCREMENT,
			tgl date,
			id_pemesanan int, -- fk
			id_kendaraan int, -- fk
			colly int,
			jumlah double(12,2),
			status char(1), -- status pengiriman. perjalanan/on delivery, terkirim

			CONSTRAINT pk_pengiriman_id PRIMARY KEY(id),
			CONSTRAINT fk_pengiriman_id_pemesanan FOREIGN KEY(id_pemesanan) REFERENCES pemesanan(id),
			CONSTRAINT fk_pengiriman_id_kendaraan FOREIGN KEY(id_kendaraan) REFERENCES kendaraan(id)
		);

		-- Tabel detail pengiriman (belum beres)
		-- CREATE TABLE detail_pengiriman(
		-- 	id int NOT NULL AUTO_INCREMENT,
		-- 	tgl date,
		-- 	id_pengiriman int, -- fk
		-- 	id_kendaraan int, -- fk
		-- 	colly int,
		-- 	netto double(12,2),
		-- 	status char(1), 
		-- );

	-- Data Persediaan
		-- Tabel Mutasi Bahan Baku
		CREATE TABLE mutasi_bahan_baku(
			id int NOT NULL AUTO_INCREMENT,
			tgl date,
			id_bahan_baku int, -- fk
			-- stok_awal double(12,2),
			brg_masuk double(12,2),
			brg_keluar double(12,2),
			-- stok_akhir double(12,2),

			CONSTRAINT pk_mutasi_bahan_baku_id PRIMARY KEY(id),
			CONSTRAINT fk_mutasi_bahan_baku_id_bahan_baku FOREIGN KEY(id_bahan_baku) REFERENCES bahan_baku(id)
		);

		CREATE TABLE mutasi_produk(
			id int NOT NULL AUTO_INCREMENT,
			tgl date,
			id_produk int, -- fk
			-- stok_awal double(12,2),
			brg_masuk double(12,2),
			brg_keluar double(12,2),
			-- stok_akhir double(12,2),

			CONSTRAINT pk_mutasi_produk_id PRIMARY KEY(id),
			CONSTRAINT fk_mutasi_produk_id_produk FOREIGN KEY(id_produk) REFERENCES produk(id)
		);

		-- Tabel peramalan (belum beres)
		CREATE TABLE peramalan(
			id int NOT NULL AUTO_INCREMENT,
			tgl date,
			bulan char(1),
			tahun year,
			id_produk int, -- fk
			hasil_peramalan double(12,2),
			jumlah_bahan_baku double(12,2),
		);

		-- Tabel produksi
		CREATE TABLE produksi(
			id int NOT NULL AUTO_INCREMENT,
			tgl date,
			id_produk int, -- fk
			jumlah double(12,2),
			hasil double(12,2),

			CONSTRAINT pk_produksi_id PRIMARY KEY(id),
			CONSTRAINT fk_produksi_id_barang_produk FOREIGN KEY(id_barang_produk) REFERENCES barang(id),
			CONSTRAINT fk_produksi_id_barang_bahan_baku FOREIGN KEY(id_barang_bahan_baku) REFERENCES barang(id)
		);

		CREATE TABLE safety_stok(
			id int NOT NULL AUTO_INCREMENT,
			id_peramalan int,
			safety_stok_produk double(12,2),
			safety_stok_bahan_baku double(12,2),

		);

# =========================================== #

# =============== PROCEDURE ================= #
	-- Data Supplier
		-- Tambah Supplier => Insert supplier seperti biasa
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

		-- Edit Supplier => update supplier seperti biasa

		-- Hapus Supplier => ?

	-- Data Buyer
		-- Tambah Buyer => Insert Buyer seperti biasa
		-- Edit Buyer => Update Buyer seperti biasa
		-- Hapus Buyer => ?

	-- Data Pekerjaan
		-- Tambah pekerjaan => Insert Karyawan seperti biasa
		-- Edit pekerjaan => update karyawan seperti biasa
		-- hapus pekerjaan => ?

	-- Data Karyawan
		-- Tambah Karyawan => Insert karyawan seperti biasa
		-- Edit Karyawan => Update Karyawan seperti biasa
		-- Hapus Karyawan => ?

	-- Data User
		-- Tambah User => Insert user, Insert hak_akses, Insert user_buyer/user_karyawan
		CREATE PROCEDURE tambah_user(
			in username_param varchar(10),
			in password_param text,
			in jenis_param char(1),
			in status_param char(1),
			in pengguna_param int,
			in hak_akses_param varchar(50)
		)
		BEGIN
			-- insert user
			INSERT INTO user(
				username, password, jenis, hak_akses, status) 
			VALUES(
				username_param, password_param, jenis_param, hak_akses_param, status_param);

			IF jenis_param = 'K' THEN -- jika jenis karyawan
				-- insert user_karyawan
				INSERT INTO user_karyawan(username, id_karyawan) VALUES(username_param, pengguna_param);
			ELSE
				-- insert user_buyer
				INSERT INTO user_buyer(username, id_buyer) VALUES(username_param, pengguna_param);
			END IF;
		END;

		-- Edit User => 

		-- Hapus User =>

	-- Data Bahan Baku
		-- Tambah Bahan Baku => Insert bahan baku, Insert mutasi bahan baku
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

		-- Edit Bahan Baku => Update Bahan Baku seperti biasa
		-- Hapus Bahan Baku => ??

	-- Data Produk
		-- Tambah Produk => Insert produk, insert komposisi, insert mutasi produk
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

		-- Edit produk => update produk, update komposisi 

		-- Hapus produk
	
	-- Data Komposisi
		-- Tambah komposisi => insert komposisi
		CREATE PROCEDURE tambah_komposisi(
			in kd_produk_param varchar(25),
			in id_bahan_baku_param int
		)
		BEGIN
			DECLARE id_produk_param int;

			SELECT id INTO id_produk_param FROM produk WHERE kd_produk = kd_produk_param;

			-- insert komposisi
			INSERT INTO komposisi(id_produk, id_bahan_baku) VALUES(id_produk_param, id_bahan_baku_param);
		END;

		-- Edit Komposisi
		-- CREATE PROCEDURE edit_komposisi(
		-- 	in id_param int,
		-- 	in kd_produk_param varchar(25),
		-- 	in id_bahan_baku_param int
		-- )
		-- BEGIN
		-- 	DECLARE id_produk_param int;

		-- 	SELECT id INTO id_produk_param FROM produk WHERE kd_produk = kd_produk_param;

		-- 	-- update komposisi
		-- 	UPDATE komposisi SET id_produk = id_produk_param, id_bahan_baku = id_bahan_baku_param WHERE id = id_param;
		-- END;
# =========================================== #

# ================== VIEW =================== #
# =========================================== #


# ======================================================================== #

# VIEW #

	# view supplier
	CREATE OR REPLACE VIEW v_supplier AS
		SELECT
			s.id, s.nik, s.npwp, s.nama, s.alamat, s.telp, s.email,
			(CASE WHEN (s.status = '1') THEN 'UTAMA' ELSE 'PENGGANTI' END) status,
			s2.id id_utama, s2.nama nama_utama
		FROM supplier s
		JOIN supplier s2 ON s2.id=s.supplier_utama
		ORDER BY status DESC, s.id ASC;

	-- ====================================== --

	# view Buyer
	CREATE OR REPLACE VIEW v_buyer AS
		SELECT id, npwp, nama, alamat, telp, email, 
			(CASE WHEN (status = '1') THEN 'AKTIF' ELSE 'NON-AKTIF' END) status
		FROM buyer
		ORDER BY id ASC;

	-- ====================================== --

	# view karyawans
	CREATE OR REPLACE VIEW v_karyawan AS
		SELECT 
			k.id, k.no_induk, k.nik, k.npwp, k.nama, k.tempat_lahir, k.tgl_lahir,
			(CASE WHEN (k.jk = 'L') THEN 'LAKI-LAKI' ELSE 'PEREMPUAN' END) jk, 
			k.alamat, k.telp, k.email, k.foto, k.tgl_masuk, k.id_pekerjaan, p.nama jabatan,
			(CASE WHEN (k.status = '1') THEN 'AKTIF' ELSE 'NON-AKTIF' END) status
		FROM karyawan k
		JOIN pekerjaan p ON p.id = k.id_pekerjaan
		ORDER BY k.no_induk ASC, k.id_pekerjaan ASC, status ASC;

	-- ====================================== --

	# view kendaraan
	CREATE OR REPLACE VIEW v_kendaraan AS
		SELECT 
			k.id, k.no_polis, k.id_supir, kry.nama supir, k.pendamping, k.tahun, 
			(CASE WHEN (k.jenis = 'C') THEN 'COLT DIESEL' ELSE 'FUSSO' END) jenis, 
			k.muatan, k.foto,
			(CASE WHEN (k.status = '1') THEN 'TERSEDIA' ELSE 'TIDAK TERSEDIA' END) status
		FROM kendaraan k
		JOIN karyawan kry ON kry.id = k.id_supir
		ORDER BY id ASC, status ASC;

	-- ====================================== --

	# view user
	CREATE OR REPLACE VIEW v_user AS
		-- karyawan
		SELECT 
			u.username, k.nama,
			(CASE WHEN (u.jenis = 'k') THEN 'KARYAWAN' ELSE 'BUYER' END) jenis,
			u.hak_akses, 
		    (CASE WHEN (u.status = '1') THEN 'AKTIF' ELSE 'NON-AKTIF' END) status
		FROM user u
		JOIN user_karyawan uk ON uk.username = u.username
		JOIN karyawan k ON uk.id_karyawan = k.id
		GROUP BY u.username

		UNION

		-- buyer
		SELECT 
			u.username, b.nama,
			(CASE WHEN (u.jenis = 'k') THEN 'KARYAWAN' ELSE 'BUYER' END) jenis,
			u.hak_akses,
		    (CASE WHEN (u.status = '1') THEN 'AKTIF' ELSE 'NON-AKTIF' END) status
		FROM user u
		JOIN user_buyer ub ON ub.username = u.username
		JOIN buyer b ON ub.id_buyer=b.id
		GROUP BY u.username;		

	-- ====================================== --

	# view produk
	CREATE OR REPLACE VIEW v_produk AS
		SELECT 
			p.id, p.kd_produk, p.nama, p.satuan, p.ket, p.foto, 
			GROUP_CONCAT(concat_ws(' - ', b.kd_bahan_baku, b.nama)) komposisi,
			p.stok
		FROM produk p
		JOIN komposisi k ON k.id_produk=p.id
		JOIN bahan_baku b ON b.id=k.id_bahan_baku
		GROUP BY p.id ASC;

	-- ====================================== --

	# view harga basis
	CREATE OR REPLACE VIEW v_harga_basis AS
		SELECT
			id, tgl,
			(CASE WHEN (jenis = 'k') THEN 'KOPI' ELSE 'LADA' END) jenis,
			harga_basis
		FROM harga_basis
		ORDER BY tgl DESC;

-- ====================================== --

