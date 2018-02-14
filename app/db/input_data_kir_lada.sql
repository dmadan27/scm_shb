-- kir
-- INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
-- VALUES ('KIR-KP-20170104-1', '2017-01-04', 'sukardi sekincau', 'K', '1');

-- kir lada
-- CALL tambah_kir_lada (kd_kir, air, berat, abu);

-- 2017-01-02
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170102-1', '2017-01-02', 219, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170102-1',  17 , 1710, 3.23);
	-- 3, 307.1, 76900

-- 2017-01-05
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170105-1', '2017-01-05', 95, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170105-1', 17.15, 1666, 1.95);
	-- 1, 68.1, 77500

-- 2017-01-06
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170106-1', '2017-01-06', 1, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170106-1', 17.6, 1739, 1.13);
	-- 3, 299.7, 78100

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170106-2', '2017-01-06', 110, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170106-2', 16.2, 1620, 1.60);
	-- 2, 177, 78100

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170106-3', '2017-01-06', 221, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170106-3', 17.6, 1635, 2.19);
	-- 1, 89.7, 76750

-- 2017-01-08
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170108-1', '2017-01-08', 222, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170108-1', 23.6, 1392, 4.5);
	-- 3, 94, 68150

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170108-2', '2017-01-08', 95, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170108-2', 18.1, 1660, 2.36);
	-- 1, 52.2, 76400

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170108-3', '2017-01-08', 220, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170108-3', 16.9, 1435, 1.68);
	-- 1, 30.8, 75550

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170108-4', '2017-01-08', 181, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170108-4', 19.3, 1697, 1.71);
	-- 1, 32.8, 76200

-- 2017-01-12
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170112-1', '2017-01-12', 101, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170112-1', 17.15, 1590, 1.45);
	-- 2, 188.4, 78200

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170112-2', '2017-01-12', 218, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170112-2', 18.1, 1655, 3.63);
	-- 1, 54.4, 76500

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170112-3', '2017-01-12', 175, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170112-3', 18.1, 1540, 2.69);
	-- 6, 522.8, 76050

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170112-4', '2017-01-12', 2, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170112-4', 15.95, 1575, 2.46);
	-- 3, 262, 78200

-- 2017-01-14
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170114-1', '2017-01-14', 98, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170114-1', 17, 1630, 1.27);
	-- 1, 24.8, 77500

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170114-2', '2017-01-14', 105, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170114-2', 15.85, 1645, 1.46);
	-- 1, 63.6, 78700

-- 2017-01-16
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170116-1', '2017-01-16', 125, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170116-1', 18.1, 1636, 2.47);
	-- 6, 371.2, 76200

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170116-2', '2017-01-16', 132, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170116-2', 17, 1660, 2.15);
	-- 2, 184.2, 77500

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170116-3', '2017-01-16', 149, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170116-3', 17.5, 1660, 1.11);
	-- 6, 592.8, 78350

-- 2017-01-19
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170119-1', '2017-01-19', 216, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170119-1', 17.85, 1717, 3.5);
	-- 1, 50.8, 76100

-- 2017-01-20
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170120-1', '2017-01-20', 94, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170120-1', 17.25, 1687, 2.5);
	-- 2, 77.4, 76000

-- 2017-01-21
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170121-1', '2017-01-21', 132, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170121-1', 17.15, 1635, 1.06);
	-- 3, 220.2, 77000

-- 2017-01-23
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170123-1', '2017-01-23', 5, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170123-1', 16.55, 1655, 1.41);
	-- 3, 148.1, 77300

-- 2017-02-01
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170201-1', '2017-02-01', 105, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170201-1', 16.8, 1655, 1.85);
	-- 1, 78.5, 77000

-- 2017-02-02
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170202-1', '2017-02-02', 110, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170202-1', 17.6, 1500, 3.77);
	-- 5, 283.7, 74200

-- 2017-02-03
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170203-1', '2017-02-03', 120, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170203-1', 18.95, 1726, 1.82);
	-- 1, 60.3, 75500

-- 2017-02-06
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170206-1', '2017-02-06', 73, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170206-1', 17, 1756, 1.1);
	-- 1, 15.8, 76000

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170206-2', '2017-02-06', 217, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170206-2', 17, 1756, 1.1);
	-- 1, 68.8, 76000

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170206-3', '2017-02-06', 5, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170206-3', 17, 1756, 1.1);
	-- 1, 53.9, 75600

-- 2017-02-16
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170216-1', '2017-02-16', 104, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170216-1', 17, 1661, 2.5);
	-- 4, 367.1, 71000

-- 2017-02-20
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170220-1', '2017-02-20', 1, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170220-1', 16.45, 1770, 1.13);
	-- 3, 249.2, 72700

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170220-2', '2017-02-20', 1, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170220-2', 17, 1731, 1.47);
	-- 3, 304.9, 72000

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170220-3', '2017-02-20', 179, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170220-3', 16.8, 1653, 1.76);
	-- 1, 57.2, 70000

	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170220-4', '2017-02-20', 73, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170220-4', 17.15, 1603, 2.2);
	-- 3, 253.1, 68500

-- 2017-02-27
	INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) 
		VALUES ('KIR-LD-20170227-1', '2017-02-27', 81, 'L', '1');
	CALL tambah_kir_lada ('KIR-LD-20170227-1', 18, 1723, 2.33);
	-- 2, 121.9, 68625