/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 5.7.40-0ubuntu0.18.04.1 : Database - inv_web_it
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

/*Table structure for table `mst_kategori` */

DROP TABLE IF EXISTS `mst_kategori`;

CREATE TABLE `mst_kategori` (
  `kode_kategori` varchar(25) DEFAULT NULL,
  `nama` varchar(75) DEFAULT NULL,
  `jenis` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_kategori` */

insert  into `mst_kategori`(`kode_kategori`,`nama`,`jenis`) values 
('0','Tidak Ada Kategori','QTY'),
('ABS','MESIN ABSEN\r','S'),
('BAT','BATERAI\r','S'),
('BSC','BARCODE SCANNER\r','S'),
('CAM','CAMERA\r','S'),
('CON','CONVERTER\r','S'),
('CSS','CASING\r','S'),
('DEC','DECODER\r','S'),
('DVD','DVD RW\r','S'),
('END','ENDCLOSURE\r','S'),
('FAN','KIPAS\r','S'),
('HDD','HARDDISK\r','S'),
('HUB','USB HUB\r','S'),
('IPP','IP PHONE\r','S'),
('KBD','KEYBOARD\r','S'),
('KBM','SET KEBOARD MOUSE\r','S'),
('LAP','LAPTOP\r','S'),
('LCN','CARD\r','S'),
('LIS','LICENSE\r','S'),
('MBD','MOTHERBOARD\r','S'),
('MOD','MODEM\r','S'),
('MON','MONITOR\r','S'),
('MOS','MOUSE\r','S'),
('PRJ','PROJEKTOR\r','S'),
('PRN','PRINTER\r','S'),
('PRO','PROCESSOR\r','S'),
('PSU','PSU\r','S'),
('RAC','RAC\r','S'),
('RAM','RAM\r','S'),
('RSB','RASPBERRY\r','S'),
('RSW','ROUTER/SWICTH\r','S'),
('SCN','SCANER DOKUMEN\r','S'),
('SPR','SURGE PROTECTOR\r','S'),
('SSD','SSD\r','S'),
('STB','STABILIZER\r','S'),
('SVR','SERVER\r','S'),
('SWP','SWIPE CARD\r','S'),
('THN','THINCLIENT\r','S'),
('UPS','UPS\r','S'),
('VGA','VIDEO GRAFIK\r','S'),
('WBC','WEBCAM\r','S'),
('RJ45','RJ45-CONNECTOR','QTY'),
('TNG','TANGCRIMPING','S'),
('SFP','SFP MODULE',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
