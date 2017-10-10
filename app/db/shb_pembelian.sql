# Rancangan Database #
# SHB Pembelian #
# Version 1.0 #

# ======================================================================== #

# TABEL #

-- tabel supplier
CREATE TABLE supplier(
	id int NOT NULL AUTO_INCREMENT,
	nik varchar(16) UNIQUE,
	npwp varchar(20) UNIQUE,
	nama varchar(255),
	telp varchar(20),
	alamat text,
	foto text,
	status char(1), -- 1: inti, 0: pengganti
	
	CONSTRAINT pk_supplier_id PRIMARY KEY(id)
);

-- tabel index supplier
CREATE TABLE index_supplier(
	id int NOT NULL AUTO_INCREMENT,
	id_supplier int,
	id_supplier_inti int,

	CONSTRAINT pk_index_supplier_id PRIMARY KEY(id),
	CONSTRAINT fk_index_supplier_id_supplier FOREIGN KEY(id_supplier) REFERENCES supplier(id),
	CONSTRAINT fk_index_supplier_id_supplier_inti FOREIGN KEY(id_supplier_inti) REFERENCES supplier(id)	
);

-- tabel karyawan
CREATE TABLE karyawan(
	id int NOT NULL AUTO_INCREMENT,
	nik varchar(16) UNIQUE,
	npwp varchar(20) UNIQUE,
	nama varchar(255),
	telp varchar(20),
	email varchar(50),
	alamat text,
	foto text,
	jabatan varchar(255),
	-- gaji pokok
	status char(1), -- 1: aktif/masih bekerja, 0: non-aktif/tidak bekerja lagi

	CONSTRAINT pk_karyawan_id PRIMARY KEY(id)
);

-- tabel buyer
CREATE TABLE buyer(
	id int NOT NULL AUTO_INCREMENT,
	nik varchar(16) UNIQUE,
	npwp varchar(20) UNIQUE,
	nama varchar(255),
	telp varchar(20),
	email varchar(50),
	alamat text,
	foto text,

	CONSTRAINT pk_buyer_id PRIMARY KEY(id)
);

-- tabel admin/user untuk karyawan
CREATE TABLE user(
	username varchar(10) NOT NULL,
	password text NOT NULL,
	id_karyawan int,
	status char(1), -- 1: aktif, 0: non-aktif

	CONSTRAINT pk_user_username PRIMARY KEY(username),
	CONSTRAINT fk_user_id_karyawan FOREIGN KEY(id_karyawan) REFERENCES karyawan(id)
);

-- tabel barang
CREATE TABLE barang(
	id int NOT NULL AUTO_INCREMENT,
	kd_barang varchar(25),
	nama varchar(50),
	ket text,
	jenis enum('BAHAN BAKU', 'BAHAN SEKUNDER', 'PRODUK'),

	CONSTRAINT pk_barang_id PRIMARY KEY(id)
);

-- tabel transaksi pembelian
-- 1 supplier/pengganti n pembelian
CREATE TABLE pembelian(
	id int NOT NULL AUTO_INCREMENT,
	invoice varchar(16) UNIQUE, -- kombinasi PB-tgl-no_urut
	tgl date,
	id_supplier int,
	jenis char(1), -- payment term, cash/tunai: c, transfer: t
	status char(1), -- s: sukses, t: titipan
	pph double(12,2),
	total double(14,2),
	ket text,

	CONSTRAINT pk_pembelian_id PRIMARY KEY(id),
	CONSTRAINT fk_pembelian_id_supplier FOREIGN KEY(id_supplier) REFERENCES index_supplier(id),
);

-- tabel detail pembelian
CREATE TABLE detail_pembelian(
	id int NOT NULL AUTO_INCREMENT,
	id_pembelian int,
	id_barang int,
	colly smallint,
	netto double(10,2),
	harga double(10,2),
	subtotal double(14,2),

	CONSTRAINT pk_detail_pembelian_id PRIMARY KEY(id),
	CONSTRAINT fk_detail_pembelian_id_pembelian FOREIGN KEY(id_pembelian) REFERENCES pembelian(id),
	CONSTRAINT fk_detail_pembelian_id_barang FOREIGN KEY(id_barang) REFERENCES barang(id)
);


# ======================================================================== #

# PROCEDURE #

# Procedure tambah p_supplier
CREATE PROCEDURE tambah_supplier(
	in nik_param varchar(16),
	in npwp_param varchar(20),
	in nama_param varchar(255),
	in telp_param varchar(20),
	in alamat_param text,
	in foto_param text,
	in status_param char(1),
	in id_supplier_inti_param int,
)
BEGIN
	-- get auto increment supplier
	SELECT `AUTO_INCREMENT` INTO id_param 
		FROM INFORMATION_SCHEMA.TABLES 
		WHERE TABLE_SCHEMA = 'scm_shb' AND TABLE_NAME = 'supplier';

	-- insert supplier
	INSERT INTO supplier 
		(nik, npwp, nama, telp, alamat, foto, status) 
	VALUES 
		(nik_param, npwp_param, nama_param, telp_param, alamat_param, foto_param, status_param);

	-- cek status
	IF status_param = '1' THEN -- jika inti, maka index sama
		INSERT INTO index_supplier (id_supplier, id_supplier_inti) VALUES (id_param, id_param);
	ELSE -- jika pengganti
		INSERT INTO index_supplier (id_supplier, id_supplier_inti) VALUES (id_param, id_supplier_inti_param);
	END IF;

END;

-- ====================================== --

# Procedure 

-- ====================================== --



# Procedure tambah detail pembelian
CREATE PROCEDURE tambah_detail_pembelian(
	in invoice_param varchar(16),
	in id_barang_param int,
	in colly_param smallint,
	in netto_param double(10,2),
	in harga_param double(10,2),
	in subtotal_param double(14,2)
)
BEGIN
	DECLARE id_pembelian_param int;

	-- get id pembelian
	SELECT id INTO id_pembelian_param FROM pembelian WHERE invoice=invoice_param;

	-- insert detail pembelian
	INSERT INTO detail_pembelian 
		(id_pembelian, id_barang, colly, netto, harga, subtotal) 
	VALUES 
		(id_pembelian_param, id_barang_param, colly_param, netto_param, harga_param, subtotal_param);
END;

-- ====================================== --

# ======================================================================== #

# VIEW #



