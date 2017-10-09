# Rancangan Database #
# SHB Pembelian #
# Version 1.0 #

# ======================================================================== #

# TABEL #

-- tabel supplier
CREATE TABLE supplier(
	id int not null AUTO_INCREMENT,
	nik varchar(16) UNIQUE,
	npwp varchar(20) UNIQUE,
	nama varchar(255),
	telp varchar(20),
	alamat text,
	
	CONSTRAINT pk_supplier_id PRIMARY KEY(id)
);

-- tabel supplier pengganti
-- 1 supplier punya n pengganti
-- 1 pengganti punya 1 supplier
CREATE TABLE p_supplier(
	id int NOT NULL AUTO_INCREMENT,
	id_supplier int,
	nik varchar(16) UNIQUE,
	npwp varchar(20) UNIQUE,
	nama varchar(255),
	telp varchar(20),
	alamat text,

	CONSTRAINT pk_p_supplier_id PRIMARY KEY(id),
	CONSTRAINT fk_p_supplier_id_supplier FOREIGN KEY(id_supplier) REFERENCES supplier(id)
);

-- tabel barang
CREATE TABLE barang(
	id int NOT NULL AUTO_INCREMENT,
	kd_barang varchar(25),
	nama varchar(50),
	ket text,

	CONSTRAINT pk_barang_id PRIMARY KEY(id)
);

-- tabel transaksi pembelian
-- 1 supplier/pengganti n pembelian
CREATE TABLE pembelian(
	id int NOT NULL AUTO_INCREMENT,
	invoice varchar(16) UNIQUE, -- kombinasi PB-tgl-no_urut
	tgl date,
	id_supplier int,
	id_p_supplier int,
	jenis char(1), -- payment term, cash/tunai: c, transfer: t
	status char(1), -- s: sukses, t: titipan
	pph double(12,2),
	total double(14,2),
	ket text,

	CONSTRAINT pk_pembelian_id PRIMARY KEY(id),
	CONSTRAINT fk_pembelian_id_supplier FOREIGN KEY(id_supplier) REFERENCES supplier(id),
	CONSTRAINT fk_pembelian_id_p_supplier FOREIGN KEY(id_p_supplier) REFERENCES p_supplier(id)
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
CREATE PROCEDURE tambah_p_supplier(
	in nik_supplier_param varchar(16),
	in nik_param varchar(16),
	in npwp_param varchar(20),
	in nama_param varchar(255),
	in telp_param varchar(20),
	in alamat_param text
)
BEGIN
	DECLARE id_supplier_param int;

	-- get id supplier
	SELECT id INTO id_supplier_param FROM supplier WHERE nik=nik_supplier_param;

	-- insert supplier pengganti
	INSERT INTO p_supplier 
		(id_supplier, nik, npwp, nama, telp, alamat) 
	VALUES 
		(id_supplier_param, nik_param, npwp_param, nama_param, telp_param, alamat_param);
END;

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



