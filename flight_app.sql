-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 25, 2016 lúc 02:32 CH
-- Phiên bản máy phục vụ: 5.7.14
-- Phiên bản PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `flight_app`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `airplane`
--

CREATE TABLE `airplane` (
  `airplanecode` char(3) NOT NULL,
  `airplanename` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `airplane`
--

INSERT INTO `airplane` (`airplanecode`, `airplanename`) VALUES
('SGN', 'Sai Gon'),
('HAN', 'Ha Noi'),
('HPH', 'Hai Phong'),
('HUI', 'Hue');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking`
--

CREATE TABLE `booking` (
  `bookingcode` char(6) NOT NULL,
  `timebooking` datetime DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `statusbooking` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `booking`
--

INSERT INTO `booking` (`bookingcode`, `timebooking`, `total`, `statusbooking`) VALUES
('RTGKXD', NULL, NULL, 0),
('BVMVOM', NULL, NULL, 0),
('RIWXVC', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flight`
--

CREATE TABLE `flight` (
  `flightcode` char(5) NOT NULL,
  `departure` char(3) NOT NULL,
  `destination` char(3) NOT NULL,
  `departday` date NOT NULL,
  `timestart` time NOT NULL,
  `class` char(1) NOT NULL,
  `pricetag` char(1) NOT NULL,
  `chairquantity` int(11) NOT NULL,
  `priceticket` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `flight`
--

INSERT INTO `flight` (`flightcode`, `departure`, `destination`, `departday`, `timestart`, `class`, `pricetag`, `chairquantity`, `priceticket`) VALUES
('BL001', 'SGN', 'HPH', '2016-10-25', '08:30:00', 'Y', 'E', 100, 100000),
('BL001', 'SGN', 'HPH', '2016-10-25', '08:30:00', 'Y', 'F', 50, 50000),
('BL001', 'SGN', 'HPH', '2016-10-25', '08:30:00', 'C', 'G', 10, 300000),
('BL002', 'HAN', 'DAD', '2016-10-27', '09:25:00', 'Y', 'E', 100, 100000),
('BL002', 'HAN', 'DAD', '2016-10-27', '09:25:00', 'Y', 'F', 30, 40000),
('BL002', 'HAN', 'DAD', '2016-10-27', '09:25:00', 'C', 'G', 15, 250000),
('BL003', 'HUI', 'SGN', '2016-11-06', '11:00:00', 'Y', 'E', 100, 90000),
('BL003', 'HUI', 'SGN', '2016-11-06', '11:00:00', 'Y', 'F', 50, 40000),
('BL003', 'HUI', 'SGN', '2016-11-06', '11:00:00', 'C', 'G', 15, 250000),
('BL004', 'SGN', 'HUI', '2016-11-20', '10:25:00', 'C', 'G', 25, 250000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flightdetails`
--

CREATE TABLE `flightdetails` (
  `bookcode` char(6) NOT NULL,
  `planecode` char(5) NOT NULL,
  `dayflight` datetime NOT NULL,
  `flightclass` char(1) NOT NULL,
  `flightprice` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `airplane`
--
ALTER TABLE `airplane`
  ADD PRIMARY KEY (`airplanecode`);

--
-- Chỉ mục cho bảng `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingcode`);

--
-- Chỉ mục cho bảng `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flightcode`,`departure`,`destination`,`departday`,`class`,`pricetag`),
  ADD KEY `flight_airplane` (`departure`);

--
-- Chỉ mục cho bảng `flightdetails`
--
ALTER TABLE `flightdetails`
  ADD PRIMARY KEY (`bookcode`,`planecode`,`dayflight`),
  ADD KEY `flightdetails_flight` (`planecode`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
