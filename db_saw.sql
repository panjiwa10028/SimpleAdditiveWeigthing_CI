-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 11, 2016 at 01:10 AM
-- Server version: 5.5.52-0ubuntu0.14.04.1
-- PHP Version: 5.6.23-1+deprecated+dontuse+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_saw`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `login_terakhir` datetime NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `email`, `password`, `foto`, `login_terakhir`) VALUES
(1, 'Reni', 'reni@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'admin-1-foto-133761935.png', '2016-10-11 00:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE IF NOT EXISTS `berita` (
  `id_berita` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin` tinyint(4) NOT NULL,
  `judul_berita` varchar(100) NOT NULL,
  `isi_berita` text NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `tanggal_post` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_berita`),
  KEY `FK_berita` (`id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `id_admin`, `judul_berita`, `isi_berita`, `gambar`, `tanggal_post`) VALUES
(5, 1, 'Lorem ipsum dolor', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam \r\nnonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat \r\nvolutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation \r\nullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. \r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse \r\nmolestie consequat, vel illum dolore eu feugiat nulla facilisis at vero \r\neros et accumsan et iusto odio dignissim qui blandit praesent luptatum \r\nzzril delenit augue duis dolore te feugait nulla facilisi. </p><p>Nam \r\nliber tempor cum soluta nobis eleifend option congue nihil imperdiet \r\ndoming id quod mazim placerat facer possim assum. Typi non habent \r\nclaritatem insitam; est usus legentis in iis qui facit eorum claritatem.\r\n Investigationes demonstraverunt lectores legere me lius quod ii legunt \r\nsaepius. Claritas est etiam processus dynamicus, qui sequitur mutationem\r\n consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc\r\n putamus parum claram, anteposuerit litterarum formas humanitatis per \r\nseacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis \r\nvidentur parum clari, fiant sollemnes in futurum.</p>', 'berita-5-gambar-842013888.jpg', '2016-01-10 02:25:04'),
(6, 1, 'Mirum est notare quam littera gothica', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. </p><p>Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 'berita-6-gambar-392876519.jpg', '2016-01-10 08:41:56'),
(7, 1, 'Many desktop publishing packages and web page', '<p>It is a long established fact that a reader will be distracted by the\r\n readable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using ''Content here, content here'', making it \r\nlook like readable English. </p><p>Many desktop publishing packages and \r\nweb page editors now use Lorem Ipsum as their default model text, and a \r\nsearch for ''lorem ipsum'' will uncover many web sites still in their \r\ninfancy. Various versions have evolved over the years, sometimes by \r\naccident, sometimes on purpose (injected humour and the like).</p>', 'berita-7-gambar-827745225.jpg', '2016-01-10 12:12:57'),
(8, 1, 'Nam liber tempor cum soluta nobis', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam \r\nnonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat \r\nvolutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation \r\nullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. \r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse \r\nmolestie consequat, vel illum dolore eu feugiat nulla facilisis at vero \r\neros et accumsan et iusto odio dignissim qui blandit praesent luptatum \r\nzzril delenit augue duis dolore te feugait nulla facilisi. </p><p>Nam \r\nliber tempor cum soluta nobis eleifend option congue nihil imperdiet \r\ndoming id quod mazim placerat facer possim assum. Typi non habent \r\nclaritatem insitam; est usus legentis in iis qui facit eorum claritatem.\r\n Investigationes demonstraverunt lectores legere me lius quod ii legunt \r\nsaepius. Claritas est etiam processus dynamicus, qui sequitur mutationem\r\n consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc\r\n putamus parum claram, anteposuerit litterarum formas humanitatis per \r\nseacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis \r\nvidentur parum clari, fiant sollemnes in futurum.</p>', 'berita-8-gambar-578043619.jpg', '2016-01-10 12:13:35'),
(9, 1, ' Investigationes demonstraverunt lectores legere', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam \r\nnonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat \r\nvolutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation \r\nullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. \r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse \r\nmolestie consequat, vel illum dolore eu feugiat nulla facilisis at vero \r\neros et accumsan et iusto odio dignissim qui blandit praesent luptatum \r\nzzril delenit augue duis dolore te feugait nulla facilisi. </p><p>Nam \r\nliber tempor cum soluta nobis eleifend option congue nihil imperdiet \r\ndoming id quod mazim placerat facer possim assum. Typi non habent \r\nclaritatem insitam; est usus legentis in iis qui facit eorum claritatem.\r\n Investigationes demonstraverunt lectores legere me lius quod ii legunt \r\nsaepius. Claritas est etiam processus dynamicus, qui sequitur mutationem\r\n consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc\r\n putamus parum claram, anteposuerit litterarum formas humanitatis per \r\nseacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis \r\nvidentur parum clari, fiant sollemnes in futurum.</p>', 'berita-9-gambar-125678168.jpg', '2016-01-10 12:53:49');

-- --------------------------------------------------------

--
-- Table structure for table `hasil`
--

CREATE TABLE IF NOT EXISTS `hasil` (
  `id_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `id_responden` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`id_hasil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_responden`
--

CREATE TABLE IF NOT EXISTS `jenis_responden` (
  `id_jenis_responden` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis_responden` varchar(100) NOT NULL,
  PRIMARY KEY (`id_jenis_responden`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jenis_responden`
--

INSERT INTO `jenis_responden` (`id_jenis_responden`, `nama_jenis_responden`) VALUES
(1, 'Ayam Kampung');

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE IF NOT EXISTS `penyakit` (
  `id_penyakit` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_responden` int(11) NOT NULL,
  `nama_penyakit` varchar(100) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id_penyakit`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `id_jenis_responden`, `nama_penyakit`, `score`) VALUES
(1, 1, 'Ayan', 4);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE IF NOT EXISTS `petugas` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `login_terakhir` datetime NOT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telp`, `email`, `password`, `foto`, `login_terakhir`, `status`) VALUES
(10, 'Reni', 'P', 'Yogyakarta', '1992-01-01', 'Glagahsari Yogyakarta', '085266111111', 'reni@gmail.com', '4d0cea8a117bfc10c2a845f1f1e6c02b4db093ed', '', '2016-01-01 23:00:00', 'Aktif'),
(11, 'Agus', 'L', 'Yogyakarta', '2016-10-01', 'Jl Margo Tirto Pandeyan, Umbulharjo', '+6285293198481', 'panjiwahyudi93@gmail.com', 'c49e09d45a9c71b586b7735e6b6afcbf91818aee', '', '0000-00-00 00:00:00', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `responden`
--

CREATE TABLE IF NOT EXISTS `responden` (
  `id_responden` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_responden` int(11) NOT NULL,
  `nama_responden` varchar(100) NOT NULL,
  `foto` text NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`id_responden`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `responden`
--

INSERT INTO `responden` (`id_responden`, `id_jenis_responden`, `nama_responden`, `foto`, `tanggal`) VALUES
(1, 1, 'Ayam A', '', '2016-10-01');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `FK_berita` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
