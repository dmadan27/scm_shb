# Uji coba #

# Data Supplier - Pengganti Supplier

# 1
	# data supplier
	INSERT INTO supplier (nik, npwp, nama, telp, alamat) 
		VALUES ('3400100100100101', '34.001.001.0-001.000', 'BUDI GUNAWAN', '087822678679', 'KOTABUMI');
	# data pengganti
	CALL tambah_p_supplier('3400100100100101', '3500100100100101', '35.001.001.0-001.001', 'AAAAA AAAA', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100101', '3500100100100102', '35.001.001.0-001.002', 'BBBBB AAAA', '087822678699', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100101', '3500100100100103', '35.001.001.0-001.003', 'CCCCC AAAA', '087822678619', 'KOTABUMI');

# 2
	# data supplier
	INSERT INTO supplier (nik, npwp, nama, telp, alamat) 
		VALUES ('3400100100100102', '34.001.001.0-001.001', 'ASEP SUPARMAN', '087822678647', 'KOTABUMI');
	# data pengganti
	CALL tambah_p_supplier('3400100100100102', '3500200100100101', '35.002.001.0-001.001', 'DDDDD DDDD', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100102', '3500200100100102', '35.002.001.0-001.002', 'EEEEE DDDD', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100102', '3500200100100103', '35.002.001.0-001.003', 'EEEEE DDDD', '087822678689', 'KOTABUMI');

# 3
	# data supplier
	INSERT INTO supplier (nik, npwp, nama, telp, alamat) 
		VALUES ('3400100100100103', '34.001.001.0-001.002', 'SUKIMAN', '0878546982', 'KOTABUMI');
	# data pengganti
	CALL tambah_p_supplier('3400100100100103', '3500300100100101', '35.003.001.0-001.001', 'FFFFF FFFF', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100103', '3500300100100102', '35.003.001.0-001.002', 'GGGGG FFFF', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100103', '3500300100100103', '35.003.001.0-001.003', 'HHHHH FFFF', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100103', '3500300100100104', '35.003.001.0-001.004', 'IIIII FFFF', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100103', '3500300100100105', '35.003.001.0-001.005', 'JJJJJ FFFF', '087822678689', 'KOTABUMI');

# 4
	# data supplier
	INSERT INTO supplier (nik, npwp, nama, telp, alamat) 
		VALUES ('3400100100100104', '34.001.001.0-001.003', 'SUPRIYADI', '087512698354', 'KOTABUMI');
	# data pengganti
	CALL tambah_p_supplier('3400100100100104', '3500400100100101', '35.004.001.0-001.001', 'GGGGG GGGG', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100104', '3500400100100102', '35.004.001.0-001.002', 'KKKKK GGGG', '087822678689', 'KOTABUMI');

# 5
	# data supplier
	INSERT INTO supplier (nik, npwp, nama, telp, alamat) 
		VALUES ('3400100100100105', '34.001.001.0-001.004', 'JOJO BOROJOL', '085696478231', 'KOTABUMI');
	# data pengganti
	CALL tambah_p_supplier('3400100100100104', '3500500100100101', '34.005.001.0-001.001', 'GGGGG FFFF', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100104', '3500500100100102', '34.005.001.0-001.002', 'KKKKK GGGG', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100104', '3500500100100103', '34.005.001.0-001.003', 'EEEEE DDDD', '087822678689', 'KOTABUMI');
	CALL tambah_p_supplier('3400100100100104', '3500500100100104', '34.005.001.0-001.004', 'DDDDD DDDD', '087822678689', 'KOTABUMI');

# 6
	# data supplier
	INSERT INTO supplier (nik, npwp, nama, telp, alamat) 
		VALUES ('3400100100100106', '34.001.001.0-001.005', 'KAMU GANTENG', '082166853493', 'KOTABUMI');
	# data pengganti
	CALL tambah_p_supplier('3400100100100106', '3600600100100101', '34.006.001.0-001.001', 'BBBBB BBBB', '087822678689', 'KOTABUMI');

# ======================================================================== #

# Data Barang

	INSERT INTO barang (kd_barang, nama, ket) 
	VALUES ('K-A', 'KOPI ASALAN', '');

	INSERT INTO barang (kd_barang, nama, ket) 
	VALUES ('KR-A', 'KOPI ROBUSTA ASALAN', '');

	INSERT INTO barang (kd_barang, nama, ket) 
	VALUES ('LH-A', 'LADA HITAM ASALAN', '');

# ======================================================================== #

# Data Pembelian - Detail Pembelian

# 1
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170828-1', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 2
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170828-2', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 3
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170828-3', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 4
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170828-4', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 5
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170828-5', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 6
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170828-6', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 7
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170829-1', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 8
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170829-2', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 9
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170829-3', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 10
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170829-4', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 11
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170829-5', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# 12
	# data pembelian
	INSERT INTO pembelian 
		(invoice, tgl, id_supplier, id_p_supplier, jenis, status, pph, total, ket) 
	VALUES 
		('PB-20170829-6', '', 0, NULL, '', '', 0, 0, '');
	# data detail pembelian
	CALL tambah_detail_pembelian('', 0, 0, 0, 0, 0);

# ======================================================================== #
