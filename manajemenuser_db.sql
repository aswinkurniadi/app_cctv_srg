-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2024 at 09:07 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manajemenuser_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cctv`
--

CREATE TABLE `cctv` (
  `id_cctv` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `nm_cctv` varchar(288) NOT NULL,
  `url_rtsp` text NOT NULL,
  `url_directory` text NOT NULL,
  `latitude` varchar(288) NOT NULL,
  `longitude` varchar(288) NOT NULL,
  `almt` text NOT NULL,
  `stts` int(2) NOT NULL,
  `date_created` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cctv`
--

INSERT INTO `cctv` (`id_cctv`, `id_group`, `nm_cctv`, `url_rtsp`, `url_directory`, `latitude`, `longitude`, `almt`, `stts`, `date_created`) VALUES
(2, 1, 'cctv 1', 'rtsp', '/stream3/file.m3u8', '-7.681699169249661', '111.33013265507813', '889J+83 Ngariboyo, Magetan Regency, East Java, Indonesia', 1, '1724213070'),
(4, 1, 'kantor 2', 'rtsp', '/stream3/file.m3u8', '-7.627257007923846', '111.33150594609376', 'Jl. Gajah Mada No.34, Waru Kulon, Milangasri, Panekan, Kabupaten Magetan, Jawa Timur 63352, Indonesia', 1, '1724215418');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id_group` int(11) NOT NULL,
  `nm` varchar(288) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id_group`, `nm`) VALUES
(1, 'Kantor'),
(2, 'Kantor B');

-- --------------------------------------------------------

--
-- Table structure for table `live_cctv`
--

CREATE TABLE `live_cctv` (
  `id_live` int(11) NOT NULL,
  `id_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `live_cctv`
--

INSERT INTO `live_cctv` (`id_live`, `id_group`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama` varchar(288) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama`) VALUES
(2, 'Profile Company'),
(3, 'User'),
(4, 'Menu'),
(5, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id_profile` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `almt` text NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `email` varchar(288) NOT NULL,
  `logo` varchar(288) NOT NULL,
  `deskripsi` text NOT NULL,
  `time_zone` varchar(288) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id_profile`, `name`, `almt`, `no_telp`, `email`, `logo`, `deskripsi`, `time_zone`) VALUES
(1, 'SARANGAN VISION', 'KPR Taman Asri Blok F7 No 7 Magetan', '082334442017', 'saranganvision@gmail.com', 'logo.png', 'Layanan Internet dan TV Digital', 'Asia/Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id_setting` int(11) NOT NULL,
  `domain` varchar(288) NOT NULL,
  `url_xampp` varchar(288) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id_setting`, `domain`, `url_xampp`) VALUES
(1, 'https://saranganvision.my.id:842', 'C:\\xampp\\htdocs\\cctv');

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id_sub_menu` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nama` varchar(288) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` (`id_sub_menu`, `id_menu`, `nama`, `url`) VALUES
(1, 2, 'display profile', 'profilecompany/index'),
(2, 2, 'edit profile', 'profilecompany/edit_profile_perusahaan'),
(3, 3, 'index', 'user/'),
(4, 3, 'edit user', 'user/edit'),
(5, 3, 'ubah password', 'user/changePassword'),
(6, 4, 'menu', 'menu/index'),
(7, 4, 'tambah menu', 'menu/add'),
(8, 4, 'ubah menu', 'menu/update'),
(9, 4, 'hapus menu', 'menu/delete'),
(10, 4, 'sub menu', 'menu/sub_menu'),
(11, 4, 'tambah sub menu', 'menu/add_sub_menu'),
(12, 4, 'ubah sub menu', 'menu/sub_menu_update'),
(13, 4, 'hapus sub menu', 'menu/delete_sub_menu'),
(14, 5, 'manajemen user', 'admin/index'),
(15, 5, 'ubah user', 'admin/edit_user_management'),
(16, 5, 'hapus user', 'admin/delete_user_management'),
(17, 5, 'detail access', 'admin/detail_access');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(288) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `id_role` int(11) NOT NULL,
  `is_active` int(2) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `name`, `email`, `image`, `password`, `id_role`, `is_active`, `date_created`) VALUES
(7, 'administrator', 'aswin kurniadi', 'direktur@gmail.com', 'default2.jpg', '$2y$10$f/Nf4WIaWNmXEPLAniBwNeNSl7IAO1zWCNkAl9xNrcj07bZghisxa', 1, 1, 1689864030),
(14, 'user', 'Aswin Kurniadi', 'admin@gmail.com', 'default.jpg', '$2y$10$eqZeNpKhpOvWPRIzQi7TZOT5SdsbMvQfVN2PHELmeuW8BGkHpPd6G', 2, 1, 1689492754);

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE `user_access` (
  `id_user_access` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_sub_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access`
--

INSERT INTO `user_access` (`id_user_access`, `id_role`, `id_sub_menu`) VALUES
(10, 1, 1),
(11, 1, 2),
(12, 1, 3),
(13, 1, 4),
(14, 1, 5),
(15, 1, 6),
(16, 1, 7),
(17, 1, 8),
(18, 1, 9),
(19, 1, 10),
(20, 1, 11),
(21, 1, 12),
(22, 1, 13),
(23, 1, 14),
(24, 1, 15),
(25, 1, 16),
(26, 1, 17),
(27, 2, 1),
(28, 2, 3),
(29, 2, 4),
(30, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_role`, `role`) VALUES
(1, 'Direktur'),
(2, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cctv`
--
ALTER TABLE `cctv`
  ADD PRIMARY KEY (`id_cctv`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id_group`);

--
-- Indexes for table `live_cctv`
--
ALTER TABLE `live_cctv`
  ADD PRIMARY KEY (`id_live`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id_profile`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id_sub_menu`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- Indexes for table `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`id_user_access`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cctv`
--
ALTER TABLE `cctv`
  MODIFY `id_cctv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `live_cctv`
--
ALTER TABLE `live_cctv`
  MODIFY `id_live` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id_profile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id_sub_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_access`
--
ALTER TABLE `user_access`
  MODIFY `id_user_access` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
