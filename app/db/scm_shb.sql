# Rancangan Database #
# SHB Pembelian #
# Version 1.0 #

# ======================================================================== #

# TABEL #

# -- Data Master -- #

	-- tabel bagian

	-- tabel pekerjaan
	CREATE TABLE pekerjaan(
		id int NOT NULL AUTO_INCREMENT,
		nama varchar(255),
		ket text,

		CONSTRAINT pk_pekerjaan_id PRIMARY KEY(id)
	);

	-- tabel karyawan
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
		-- tgl_masuk date,
		-- bagian varchar(255), 
		id_jabatan int,
		-- gaji_pokok double(10,2)
		status char(1), -- 1: aktif/masih bekerja, 0: non-aktif/tidak bekerja lagi

		CONSTRAINT pk_karyawan_id PRIMARY KEY(id),
		CONSTRAINT fk_karyawan_id_jabatan FOREIGN KEY(id_jabatan) REFERENCES pekerjaan(id)
	);

	-- tabel riwayat pekerjaan

	-- tabel barang v.1
	CREATE TABLE barang(
		id int NOT NULL AUTO_INCREMENT,
		kd_barang varchar(25),
		nama varchar(50),
		ket text,
		jenis enum('BAHAN BAKU', 'BAHAN SEKUNDER', 'PRODUK'),
		satuan enum('KG', 'PCS'),
		foto text,

		CONSTRAINT pk_barang_id PRIMARY KEY(id)
	);

	-- tabel barang v.2
		-- bahan baku
		CREATE TABLE bahan_baku(
			id int NOT NULL AUTO_INCREMENT,
			kd_barang varchar(25),
			nama varchar(25),
			ket text,
			satuan enum('KG', 'PCS'),
			foto text,
		);

		-- produk
		CREATE TABLE produk(
			id int NOT NULL AUTO_INCREMENT,
			kd_barang varchar(25),
			nama varchar(25),
			ket text,
			satuan enum('KG', 'PCS'),
			foto text,
		);

	-- tabel transportasi
	CREATE TABLE transportasi(
		id int NOT NULL AUTO_INCREMENT,
		no_polis varchar(10),
		id_supir int, -- fk dari karyawan yg jabatannya supir
		pendamping varchar(255),
		tahun year,
		jenis varchar(255), -- truck, fuso
		muatan double(8,2), -- kg
		foto text,
		status char(1), -- 1: tersedia, 0: tidak tersedia

		CONSTRAINT pk_kendaraan_id PRIMARY KEY(id),
		CONSTRAINT fk_kendaraan_id_supir FOREIGN KEY(id_supir) REFERENCES karyawan(id)
	);

	-- tabel admin/user untuk karyawan
	CREATE TABLE user(
		username varchar(10) NOT NULL,
		password text NOT NULL,
		id_karyawan int,
		hak_akses text,
		status char(1), -- 1: aktif, 0: non-aktif

		CONSTRAINT pk_user_username PRIMARY KEY(username),
		CONSTRAINT fk_user_id_karyawan FOREIGN KEY(id_karyawan) REFERENCES karyawan(id)
	);

	-- tabel supplier
	CREATE TABLE supplier(
		id int NOT NULL AUTO_INCREMENT,
		nik varchar(16),
		npwp varchar(16),
		nama varchar(255),
		alamat text,
		telp varchar(20),
		email varchar(50),
		status char(1), -- 1: utama, 0: pengganti
		
		CONSTRAINT pk_supplier_id PRIMARY KEY(id)
	);

	-- tabel index supplier
	CREATE TABLE index_supplier(
		id int NOT NULL AUTO_INCREMENT,
		id_supplier int,
		id_supplier_utama int,

		CONSTRAINT pk_index_supplier_id PRIMARY KEY(id),
		CONSTRAINT fk_index_supplier_id_supplier FOREIGN KEY(id_supplier) REFERENCES supplier(id),
		CONSTRAINT fk_index_supplier_id_supplier_utama FOREIGN KEY(id_supplier_utama) REFERENCES supplier(id)	
	);

	-- tabel buyer
	CREATE TABLE buyer(
		id int NOT NULL AUTO_INCREMENT,
		npwp varchar(20),
		nama varchar(255),
		alamat text,
		telp varchar(20),
		email varchar(50),

		CONSTRAINT pk_buyer_id PRIMARY KEY(id)
	);

# ---------------------------- #

# -- Data Transaksional -- #
	
	-- tabel purchase order dan transaksi pembelian (purchasing)

		-- purchase order / po / pemesanan pembelian
		CREATE TABLE purchase_order(
			id int NOT NULL AUTO_INCREMENT,
			id_supplier int, -- fk dari index supplier
			tgl date, -- tgl pemesanan

		);

		-- detail PO
		CREATE TABLE detail_po(
			id int NOT NULL AUTO_INCREMENT,
			id_po int, -- fk dari purchase order
			-- id_barang int, -- fk dari barang
			-- id_bahan_baku int, -- fk dari bahan baku
			netto double(10,2), -- jumlah pemesanan
			delivery date, -- waktu pengiriman
		);

		-- pembelian / purchasing
		CREATE TABLE pembelian(
			id int NOT NULL AUTO_INCREMENT,
			id_po int, -- fk dari purchase order
			id_supplier int, -- fk dari index supplier
			invoice varchar(16), -- kombinasi PB-tgl-no_urut
			tgl date,
			payment_term char(1), -- cash/tunai: c, transfer: t
			status char(1), -- s: sukses, t: titipan
			pph double(12,2),
			-- total double(14,2),
			ket text,

			CONSTRAINT pk_pembelian_id PRIMARY KEY(id),
			CONSTRAINT fk_pembelian_id_supplier FOREIGN KEY(id_supplier) REFERENCES index_supplier(id),
		);

		-- tabel detail pembelian
		CREATE TABLE detail_pembelian(
			id int NOT NULL AUTO_INCREMENT,
			id_pembelian int,
			-- id_barang int,
			-- id_bahan_baku int,
			colly smallint,
			netto double(10,2),
			harga double(10,2),
			subtotal double(14,2),

			CONSTRAINT pk_detail_pembelian_id PRIMARY KEY(id),
			CONSTRAINT fk_detail_pembelian_id_pembelian FOREIGN KEY(id_pembelian) REFERENCES pembelian(id),
			-- CONSTRAINT fk_detail_pembelian_id_barang FOREIGN KEY(id_barang) REFERENCES barang(id)
		);

	-- tabel sales order dan transaksi penjualan

		-- sales order / po dari buyer / pemesanan penjualan
		CREATE TABLE sales_order(
			id int NOT NULL	AUTO_INCREMENT,
			id_buyer int, -- fk dari buyer
			no_kontrak varchar(50),
			tgl date,
			jumlah_karung int,
			ket_karung enum('JUMLAH PASTI', 'PERKIRAAN'),
			kemasan enum('KARUNG GONI', 'KARUNg PLASTIK'),
			netto double(10,2),
			kualitas int, -- fk dari barang (produk) / produk
			-- kualitas varchar,
			differential int, -- harga
			terminal date, -- month/date
			delivery date, -- tgl pengiriman
			catatan text, -- keterangan kontrak

			CONSTRAINT pk_sales_order_id PRIMARY KEY(id),
			CONSTRAINT fk_sales_order_id_buyer FOREIGN KEY(id_buyer) REFERENCES buyer(id),
			CONSTRAINT fk_sales_order_kualitas FOREIGN KEY(kualitas) REFERENCES
		);

		-- penjualan
		CREATE TABLE penjualan(
			id int NOT NULL AUTO_INCREMENT,
			id_so int, -- fk dari sales order

		);

		-- detail penjualan
		CREATE TABLE detail_penjualan(
			id int NOT NULL AUTO_INCREMENT,
			id_penjualan int,
			id_transportasi int,
			tgl date,
			colly int,
			netto double(10,2),

		);


# ---------------------------- #


# ======================================================================== #

# PROCEDURE #

	# Procedure tambah supplier
	CREATE PROCEDURE tambah_supplier(
		in nik_param varchar(16),
		in npwp_param varchar(20),
		in nama_param varchar(255),
		in telp_param varchar(20),
		in alamat_param text,
		in status_param char(1),
		in id_supplier_utama_param int
	)
	BEGIN
		DECLARE id_param int;

		-- get auto increment supplier
		SELECT `AUTO_INCREMENT` INTO id_param 
			FROM INFORMATION_SCHEMA.TABLES 
			WHERE TABLE_SCHEMA = 'scm_shb' AND TABLE_NAME = 'supplier';

		-- insert supplier
		INSERT INTO supplier 
			(nik, npwp, nama, telp, alamat, status) 
		VALUES 
			(nik_param, npwp_param, nama_param, telp_param, alamat_param, status_param);

		-- cek status
		IF status_param = '1' THEN -- jika utama, maka index sama
			INSERT INTO index_supplier (id_supplier, id_supplier_utama) VALUES (id_param, id_param);
		ELSE -- jika pengganti
			INSERT INTO index_supplier (id_supplier, id_supplier_utama) VALUES (id_param, id_supplier_utama_param);
		END IF;

	END;

-- ====================================== --

	# Procedure edit supplier
	CREATE PROCEDURE edit_supplier(
		in id_param int,
		in nik_param varchar(16),
		in npwp_param varchar(20),
		in nama_param varchar(255),
		in telp_param varchar(20),
		in alamat_param text,
		in status_param char(1),
		in id_supplier_utama_param int
	)
	BEGIN
		DECLARE id_supplier_utama_lama int;
		DECLARE id_index_param int;

		-- get id supplier utama lama
		SELECT id_supplier_utama INTO id_supplier_utama_lama FROM index_supplier WHERE id_supplier = id_param;

		-- get id index supplier
		SELECT id INTO id_index_param FROM index_supplier WHERE id_supplier = id_param;

		-- update data supplier
		UPDATE supplier SET 
			nik=nik_param, npwp=npwp_param, nama=nama_param,
			telp=telp_param, alamat=alamat_param, status=status_param
		WHERE id=id_param;

		-- cek supplier_utama
		IF id_supplier_utama_param != id_supplier_utama_lama THEN -- jika berbeda
			-- update data index supplier
			UPDATE index_supplier SET id_supplier_utama=id_supplier_utama_param 
			WHERE id=id_index_param;
		END IF;

	END;

-- ====================================== --


-- ====================================== --

# ======================================================================== #

# VIEW #

	# view supplier
	CREATE OR REPLACE VIEW v_supplier AS
		SELECT 
			sup.id, sup.nik, sup.npwp, sup.nama, sup.alamat, sup.telp, sup.email, 
			(CASE WHEN (sup.status = '1') THEN 'UTAMA' ELSE 'PENGGANTI' END) status,
			insup.id id_index, insup.id_supplier_utama, sup2.nama nama_supplier_utama
		FROM supplier sup
		JOIN index_supplier insup ON insup.id_supplier = sup.id
		JOIN supplier sup2 ON sup2.id = insup.id_supplier_utama
		ORDER BY status DESC, insup.id_supplier_utama ASC;

	-- ====================================== --

	# view karyawan
	CREATE OR REPLACE VIEW v_karyawan AS
		SELECT 
			k.id, k.no_induk, k.nik, k.npwp, k.nama, k.tempat_lahir, k.tgl_lahir,
			(CASE WHEN (k.jk = 'L') THEN 'LAKI-LAKI' ELSE 'PEREMPUAN' END) jk, 
			k.alamat, k.telp, k.email, k.foto, k.id_jabatan, p.jabatan,
			(CASE WHEN (k.status = '1') THEN 'AKTIF' ELSE 'NON-AKTIF' END) status
		FROM karyawan k
		JOIN pekerjaan p ON p.id = k.id_jabatan
		ORDER BY k.no_induk ASC, k.id_jabatan ASC;

	-- ====================================== --

	# view transportasi
	CREATE OR REPLACE VIEW v_transportasi AS
		SELECT 
			t.id, t.no_polis, t.id_supir, k.nama supir, t.pendamping, t.tahun, t.jenis, t.muatan, t.foto,
			(CASE WHEN (t.status = '1') THEN 'TERSEDIA' ELSE 'TIDAK TERSEDIA' END) status
		FROM transportasi t
		JOIN karyawan k ON k.id = t.id_supir
		ORDER BY id ASC;

-- ====================================== --

