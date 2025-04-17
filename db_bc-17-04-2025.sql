/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 5.7.27-0ubuntu0.16.04.1-log : Database - inv_web_it
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`inv_web_it` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `inv_web_it`;

/*Table structure for table `barang_his` */

DROP TABLE IF EXISTS `barang_his`;

CREATE TABLE `barang_his` (
  `kode_barang` varchar(25) DEFAULT NULL,
  `tanggal_edit` date DEFAULT NULL,
  `jam_edit` time DEFAULT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mst_approval` */

DROP TABLE IF EXISTS `mst_approval`;

CREATE TABLE `mst_approval` (
  `id_user` int(11) NOT NULL,
  `id_approval` int(11) NOT NULL,
  `urutan` int(1) NOT NULL,
  `jenis` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mst_barang` */

DROP TABLE IF EXISTS `mst_barang`;

CREATE TABLE `mst_barang` (
  `kode_kategori` varchar(75) DEFAULT NULL,
  `kode_merk` varchar(75) DEFAULT NULL,
  `kode_type` varchar(75) DEFAULT NULL,
  `kode_barang` varchar(75) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `tanggal_pembelian` varchar(25) DEFAULT NULL,
  `harga_beli` decimal(17,2) DEFAULT NULL,
  `keterangan` text,
  `status_barang` varchar(15) DEFAULT NULL,
  `tanggal_lokasi_akhir` varchar(25) DEFAULT NULL,
  `lokasi_terakhir` varchar(100) DEFAULT NULL,
  `keterangan_acct` text,
  `opname` varchar(25) DEFAULT NULL,
  `barang_stock` varchar(20) DEFAULT NULL,
  `serial_number` varchar(150) DEFAULT NULL,
  `harga_asuransi` decimal(17,2) DEFAULT NULL,
  `tanggal_input` varchar(25) DEFAULT NULL,
  `user_input` varchar(25) DEFAULT NULL,
  `tanggal_update` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mst_kategori` */

DROP TABLE IF EXISTS `mst_kategori`;

CREATE TABLE `mst_kategori` (
  `kode_kategori` varchar(25) DEFAULT NULL,
  `nama` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mst_kode_dokumen` */

DROP TABLE IF EXISTS `mst_kode_dokumen`;

CREATE TABLE `mst_kode_dokumen` (
  `kode_dokumen` varchar(50) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `status_inout` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kode_dokumen`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mst_merk` */

DROP TABLE IF EXISTS `mst_merk`;

CREATE TABLE `mst_merk` (
  `kode_merk` varchar(75) NOT NULL,
  `nama` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`kode_merk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mst_personil` */

DROP TABLE IF EXISTS `mst_personil`;

CREATE TABLE `mst_personil` (
  `nip` int(35) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `dept` varchar(50) DEFAULT NULL,
  `singkatan_dept` varchar(15) DEFAULT NULL,
  `aktif` int(5) DEFAULT NULL,
  `nama_kecil` varchar(50) DEFAULT NULL,
  `kd_store` varchar(25) DEFAULT NULL,
  `lokasi` varchar(25) DEFAULT NULL,
  `is_store` varchar(10) DEFAULT NULL,
  `tgl_buka` varchar(25) DEFAULT NULL,
  `tgl_tutup` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mst_status_barang` */

DROP TABLE IF EXISTS `mst_status_barang`;

CREATE TABLE `mst_status_barang` (
  `status_barang` varchar(15) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mst_type` */

DROP TABLE IF EXISTS `mst_type`;

CREATE TABLE `mst_type` (
  `kode_type` varchar(75) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`kode_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mutasi_rusak_d` */

DROP TABLE IF EXISTS `mutasi_rusak_d`;

CREATE TABLE `mutasi_rusak_d` (
  `nomor_transaksi` varchar(50) NOT NULL,
  `no_urut` char(15) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `status_barang_old` varchar(50) DEFAULT NULL,
  `keterangan_barang` text,
  `qty_out` char(15) DEFAULT NULL,
  `qty_in` char(15) DEFAULT NULL,
  `saldo_awal` char(15) DEFAULT NULL,
  PRIMARY KEY (`nomor_transaksi`,`no_urut`,`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mutasi_rusak_h` */

DROP TABLE IF EXISTS `mutasi_rusak_h`;

CREATE TABLE `mutasi_rusak_h` (
  `nomor_transaksi` varchar(25) NOT NULL,
  `user_input` varchar(35) DEFAULT NULL,
  `tanggal_input` varchar(25) DEFAULT NULL,
  `tanggal_proses` varchar(25) DEFAULT NULL,
  `keterangan` text,
  `tanggal_batal` varchar(25) DEFAULT NULL,
  `keterangan_batal` text,
  PRIMARY KEY (`nomor_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `opname_d` */

DROP TABLE IF EXISTS `opname_d`;

CREATE TABLE `opname_d` (
  `nomor_transaksi` varchar(25) NOT NULL,
  `no_urut` char(5) NOT NULL,
  `kode_barang` varchar(55) NOT NULL,
  `qty` char(15) DEFAULT NULL,
  `keterangan_barang` text,
  PRIMARY KEY (`nomor_transaksi`,`no_urut`,`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `opname_h` */

DROP TABLE IF EXISTS `opname_h`;

CREATE TABLE `opname_h` (
  `nomor_transaksi` varchar(25) NOT NULL,
  `user_input` varchar(16) DEFAULT NULL,
  `keterangan` text,
  `tanggal_proses` varchar(25) DEFAULT NULL,
  `tanggal_input` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`nomor_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `permission_roles` */

DROP TABLE IF EXISTS `permission_roles`;

CREATE TABLE `permission_roles` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `status` tinyint(1) DEFAULT '1',
  `parent_id` int(11) DEFAULT NULL,
  `link` varchar(150) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

/*Table structure for table `personil_upgrade` */

DROP TABLE IF EXISTS `personil_upgrade`;

CREATE TABLE `personil_upgrade` (
  `nip` int(15) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `perubahan_barang` */

DROP TABLE IF EXISTS `perubahan_barang`;

CREATE TABLE `perubahan_barang` (
  `kd_barang_lama` varchar(25) DEFAULT NULL,
  `kd_barang_baru` varchar(25) DEFAULT NULL,
  `lokasi_lama` text,
  `lokasi_baru` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `display_name` varchar(30) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_user_roles_role_Name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `roles_users` */

DROP TABLE IF EXISTS `roles_users`;

CREATE TABLE `roles_users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `session` */

DROP TABLE IF EXISTS `session`;

CREATE TABLE `session` (
  `id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `stock` */

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `kode_barang` varchar(25) NOT NULL,
  `saldo_awal` int(15) DEFAULT NULL,
  `in` int(15) DEFAULT NULL,
  `out` int(15) DEFAULT NULL,
  PRIMARY KEY (`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `stock_rusak` */

DROP TABLE IF EXISTS `stock_rusak`;

CREATE TABLE `stock_rusak` (
  `kode_barang` varchar(25) NOT NULL,
  `saldo_awal` int(15) DEFAULT NULL,
  `in` int(15) DEFAULT NULL,
  `out` int(15) DEFAULT NULL,
  PRIMARY KEY (`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tanda_terima_d` */

DROP TABLE IF EXISTS `tanda_terima_d`;

CREATE TABLE `tanda_terima_d` (
  `nomor_transaksi` varchar(15) NOT NULL,
  `no_urut` int(5) NOT NULL,
  `kode_barang` varchar(35) DEFAULT NULL,
  `status_barang_old` varchar(10) DEFAULT NULL,
  `status_barang` varchar(10) DEFAULT NULL,
  `keterangan_barang` text,
  `qty` int(12) DEFAULT NULL,
  `harga_asuransi` double(17,2) DEFAULT NULL,
  `saldo_awal` int(12) DEFAULT NULL,
  PRIMARY KEY (`nomor_transaksi`,`no_urut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tanda_terima_h` */

DROP TABLE IF EXISTS `tanda_terima_h`;

CREATE TABLE `tanda_terima_h` (
  `kode_dokumen` varchar(5) DEFAULT NULL,
  `nomor_transaksi` varchar(25) NOT NULL,
  `keterangan` text,
  `tanggal` date DEFAULT NULL,
  `tujuan` text,
  `pengirim` varchar(35) DEFAULT NULL,
  `tanggal_pengiriman` date DEFAULT NULL,
  `penerima` varchar(35) DEFAULT NULL,
  `tanggal_input` datetime DEFAULT NULL,
  `user_input` varchar(25) DEFAULT NULL,
  `jumlah_detail` int(15) DEFAULT NULL,
  `manual` varchar(15) DEFAULT NULL,
  `tanggal_batal` datetime DEFAULT NULL,
  `keterangan_batal` text,
  `tgl_terima_it` date DEFAULT NULL,
  PRIMARY KEY (`nomor_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `roles_id` int(11) DEFAULT NULL,
  `pmb` varchar(15) DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `no_pmb` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

/* Trigger structure for table `mutasi_rusak_d` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_stok_rusak` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'sa'@'%' */ /*!50003 TRIGGER `update_stok_rusak` AFTER INSERT ON `mutasi_rusak_d` FOR EACH ROW BEGIN
	SET @stok_qty = NEW.qty_in;
	SET @saldo_awal = NEW.saldo_awal;
	
	SET @check_status_brg = (SELECT barang_stock FROM inv_web_it.mst_barang WHERE kode_barang = NEW.kode_barang);
	SET @check_kode_brg = (SELECT COUNT(kode_barang) AS count_kode_brg FROM inv_web_it.stock_rusak WHERE kode_barang = NEW.kode_barang);
	
	IF @check_kode_brg = 0 THEN
		INSERT INTO inv_web_it.stock_rusak (kode_barang,saldo_awal,`in`,`out`)
		VALUES(NEW.kode_barang,@saldo_awal,@stok_qty,0);
	else 
		UPDATE inv_web_it.stock_rusak
		SET `in` = `in` + @stok_qty
		WHERE kode_barang = NEW.kode_barang;
	END IF;

	if @check_status_brg='True' then
		UPDATE inv_web_it.stock
		SET `out` = `out` - @stok_qty
		WHERE kode_barang = NEW.kode_barang;			
	else 
		update inv_web_it.mst_barang
		SET status_barang='R',
		tanggal_update=NOW()
		where kode_barang =  NEW.kode_barang;
	end IF;
	
    END */$$


DELIMITER ;

/* Trigger structure for table `tanda_terima_d` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_stok` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'sa'@'%' */ /*!50003 TRIGGER `update_stok` AFTER INSERT ON `tanda_terima_d` FOR EACH ROW BEGIN
	SET @kd_dokumen = (SELECT kode_dokumen FROM inv_web_it.tanda_terima_h WHERE nomor_transaksi = NEW.nomor_transaksi);
	SET @stok_qty = NEW.qty;
	SET @saldo_awal = NEW.saldo_awal;

	SET @check_status_brg = (SELECT barang_stock FROM inv_web_it.mst_barang WHERE kode_barang = NEW.kode_barang);
	SET @check_kode_brg = (SELECT COUNT(kode_barang) AS count_kode_brg FROM inv_web_it.stock WHERE kode_barang = NEW.kode_barang);
	
	
	IF @check_status_brg = 'True' THEN
		IF @kd_dokumen = 'IN' THEN
			IF @check_kode_brg = 0 THEN
				INSERT INTO inv_web_it.stock (kode_barang,saldo_awal,`in`,`out`)
				VALUES(NEW.kode_barang,@saldo_awal,@stok_qty,0);	
			else
				UPDATE inv_web_it.stock
				SET `in` = `in` + @stok_qty
				WHERE kode_barang = NEW.kode_barang;
			end if;
		ELSE				
			UPDATE inv_web_it.stock
			SET `out` = `out` + @stok_qty
			WHERE kode_barang = NEW.kode_barang;
		END IF;
	end if;
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
