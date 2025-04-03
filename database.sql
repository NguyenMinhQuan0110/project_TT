-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 03, 2025 lúc 03:53 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `project_thuctap`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUserById` (IN `p_id` INT)   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error occurred during delete';
    END;

    START TRANSACTION;
    DELETE FROM dons WHERE dons.userid=p_id;
    DELETE FROM users WHERE id = p_id;
    
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `duyetdon` (IN `p_trangthai` VARCHAR(100), IN `p_id` INT, IN `p_ngayduyet` DATE)   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error occurred during update';
    END;

    START TRANSACTION;
    
    UPDATE dons 
    SET trangthai = p_trangthai,ngayduyet=p_ngayduyet
    WHERE id = p_id;
    
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get30Don` (IN `p_nguoiduyet` INT)   BEGIN
    SELECT users.username,dons.loaidon,dons.ngaytao,dons.trangthai,dons.ngayduyet,dons.title,dons.id FROM dons INNER JOIN users ON users.id=dons.userid WHERE dons.nguoiduyet=p_nguoiduyet ORDER BY dons.ngaytao DESC LIMIT 30;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllDon` (IN `p_limits` INT, IN `p_offsets` INT)   BEGIN
	SELECT users.username,dons.loaidon,dons.ngaytao,dons.trangthai,dons.ngayduyet,dons.title,dons.id,dons.nguoiduyet FROM dons INNER JOIN users ON users.id=dons.userid LIMIT p_limits OFFSET p_offsets;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllUser` (IN `p_limits` INT, IN `p_offsets` INT, IN `p_phongban` VARCHAR(100))   BEGIN
    SELECT * FROM users WHERE users.phongban=p_phongban
    LIMIT p_limits OFFSET p_offsets;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDonById` (IN `p_id` INT)   BEGIN
    SELECT * FROM dons WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDonByUserId` (IN `user_id` INT)   BEGIN
	SELECT * FROM dons WHERE userid=user_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTotalAllDon` ()   BEGIN
    SELECT COUNT(*) AS toltal FROM dons;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTotalAllUser` (IN `p_phongban` VARCHAR(100))   BEGIN
    SELECT COUNT(*) as toltal FROM users WHERE users.phongban=p_phongban;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTotalSearchDon` (IN `p_keyword` VARCHAR(100))   BEGIN
	SELECT COUNT(*) AS toltal FROM dons INNER JOIN users ON users.id=dons.userid 
    WHERE users.username LIKE  CONCAT('%', p_keyword, '%')
    OR dons.title LIKE  CONCAT('%', p_keyword, '%')
    OR dons.loaidon LIKE  CONCAT('%', p_keyword, '%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTotalSearchUser` (IN `p_keyword` VARCHAR(255), IN `p_phongban` VARCHAR(100))   BEGIN
    SELECT COUNT(*) as toltal FROM users 
    WHERE users.phongban=p_phongban AND( loginname LIKE CONCAT('%', p_keyword, '%')
    OR username LIKE CONCAT('%', p_keyword, '%')
    OR email LIKE CONCAT('%', p_keyword, '%'));
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserById` (IN `p_id` INT)   BEGIN
    SELECT * FROM users WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserByLoaiUserAndPhongBan` (IN `p_loaiuser` VARCHAR(100), IN `p_phongban` VARCHAR(100))   BEGIN
    SELECT * FROM users 
    WHERE loaiuser = p_loaiuser 
    AND phongban = p_phongban;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserByLoginNameAndPassword` (IN `p_loginname` VARCHAR(255), IN `p_password` VARCHAR(220))   BEGIN
    SELECT * FROM users 
    WHERE loginname = p_loginname 
    AND password = p_password;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertDon` (IN `p_title` VARCHAR(255), IN `p_noidung` TEXT, IN `p_nguoiduyet` INT, IN `p_loaidon` VARCHAR(100), IN `p_startdate` DATE, IN `p_enddate` DATE, IN `p_dinhkem` VARCHAR(500), IN `p_trangthai` VARCHAR(100), IN `p_userid` INT)   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error occurred during insert';
    END;

    START TRANSACTION;
    
    INSERT INTO dons (
        title, noidung, nguoiduyet, loaidon, 
        startdate, enddate, dinhkem, trangthai, userid
    ) VALUES (
        p_title, p_noidung, p_nguoiduyet, p_loaidon,
        p_startdate, p_enddate, p_dinhkem, p_trangthai, p_userid
    );
    
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUser` (IN `p_loginname` VARCHAR(255), IN `p_username` VARCHAR(255), IN `p_password` VARCHAR(220), IN `p_email` VARCHAR(225), IN `p_birthday` DATE, IN `p_loaiuser` VARCHAR(100), IN `p_phongban` VARCHAR(100), IN `p_trangthai` VARCHAR(100))   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error occurred during insert';
    END;

    START TRANSACTION;
    
    INSERT INTO users (
        loginname, username, password, email, 
        birthday, loaiuser, phongban, trangthai
    ) VALUES (
        p_loginname, p_username, p_password, p_email,
        p_birthday, p_loaiuser, p_phongban, p_trangthai
    );
    
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchDon` (IN `p_keyword` VARCHAR(100), IN `p_limits` INT, IN `p_offsets` INT)   BEGIN
	SELECT users.username,dons.loaidon,dons.ngaytao,dons.trangthai,dons.ngayduyet,dons.title,dons.id FROM dons INNER JOIN users ON users.id=dons.userid
    WHERE users.username LIKE  CONCAT('%', p_keyword, '%')
    OR dons.title LIKE  CONCAT('%', p_keyword, '%')
    OR dons.loaidon LIKE  CONCAT('%', p_keyword, '%')
    LIMIT p_limits OFFSET p_offsets;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchUser` (IN `p_keyword` VARCHAR(255), IN `p_limits` INT, IN `p_offsets` INT, IN `p_phongban` VARCHAR(100))   BEGIN
    SELECT * FROM users 
    WHERE users.phongban=p_phongban AND ( loginname LIKE CONCAT('%', p_keyword, '%')
    OR username LIKE CONCAT('%', p_keyword, '%')
    OR email LIKE CONCAT('%', p_keyword, '%'))
    LIMIT p_limits OFFSET p_offsets;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUser` (IN `p_id` INT, IN `p_loginname` VARCHAR(255), IN `p_username` VARCHAR(255), IN `p_password` VARCHAR(220), IN `p_email` VARCHAR(225), IN `p_loaiuser` VARCHAR(100), IN `p_phongban` VARCHAR(100), IN `p_birthday` DATE, IN `p_trangthai` VARCHAR(100))   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error occurred during update';
    END;

    START TRANSACTION;
    
    UPDATE users 
    SET loginname = p_loginname,
        username = p_username,
        password = p_password,
        email = p_email,
        loaiuser = p_loaiuser,
        phongban = p_phongban,
        birthday = p_birthday,
        trangthai = p_trangthai
    WHERE id = p_id;
    
    COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dons`
--

CREATE TABLE `dons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `noidung` text NOT NULL,
  `nguoiduyet` int(11) NOT NULL,
  `loaidon` varchar(100) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `dinhkem` varchar(500) NOT NULL,
  `trangthai` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(11) NOT NULL,
  `ngaytao` datetime NOT NULL DEFAULT current_timestamp(),
  `ngayduyet` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dons`
--

INSERT INTO `dons` (`id`, `title`, `noidung`, `nguoiduyet`, `loaidon`, `startdate`, `enddate`, `dinhkem`, `trangthai`, `userid`, `ngaytao`, `ngayduyet`) VALUES
(56, 'gfergreg', 'regergregr', 103, 'Đơn nghỉ phép', '2025-04-08', '2025-04-22', '1743577172_66335b3bb9ec6 - Copy (2).jpg', 'đã hủy', 103, '2025-04-02 13:59:32', '2025-04-02'),
(59, 'dvdfdv', 'vvff', 103, 'Đơn nghỉ phép', '2025-04-22', '2025-04-23', '1743580163_6633fca238df2.webp', 'đã duyệt', 103, '2025-04-02 14:49:23', '2025-04-02'),
(60, 'dvdfdv', 'vvff', 103, 'Đơn nghỉ phép', '2025-04-22', '2025-04-23', '1743580167_6633fca238df2.webp', 'đã hủy', 103, '2025-04-02 14:49:27', '2025-04-02'),
(61, 'vrgerfge', 'ffewfef', 6, 'Đơn nghỉ phép', '2025-04-22', '2025-04-08', '1743580998_66335b3bb9ec6.jpg', 'chưa duyệt', 103, '2025-04-02 15:03:18', NULL),
(62, 'dferfe', '', 103, 'Đơn nghỉ phép', '2025-04-08', '2025-04-09', '1743585915_6633fca238df2.webp', 'đã duyệt', 103, '2025-04-02 16:25:15', '2025-04-02'),
(63, 'gfbggewfe', '', 103, 'Đơn cấp vật tư máy móc', '2025-04-07', '2025-04-23', '1743586243_66335b3bb9ec6 - Copy (2).jpg', 'đã hủy', 112, '2025-04-02 16:30:43', '2025-04-02'),
(64, 'uhfofsdfnewkl', '', 103, 'Đơn nghỉ phép', '2025-04-09', '2025-04-16', '1743644811_3de6a81aad5f0c01554e-1714647805-183319avatar.jpg', 'đã hủy', 116, '2025-04-03 08:46:51', '2025-04-03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `loginname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(220) NOT NULL,
  `email` varchar(225) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `loaiuser` varchar(100) NOT NULL,
  `phongban` varchar(100) NOT NULL,
  `trangthai` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `loginname`, `username`, `password`, `email`, `birthday`, `loaiuser`, `phongban`, `trangthai`) VALUES
(10, 'fefreg', 'grgre', 'd41d8cd98f00b204e9800998ecf8427e', 'bfd@gmail.com', '2025-03-26', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(11, 'edd', 'ưdwqd', 'e10adc3949ba59abbe56e057f20f883e', 'wqd@gmail.com', '2025-03-19', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(12, 'ffe', 'êf', '8fa14cdd754f91cc6554c9e71929cce7', 'dsjshdsj@gmail.com', '2004-03-26', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(16, 'fefe', 'fffdf', 'd41d8cd98f00b204e9800998ecf8427e', 'fdvfv@gmail.com', '1999-03-24', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(43, 'phuongwibu ', 'Lê Vạn Phương', 'e10adc3949ba59abbe56e057f20f883e', 'phuongwb@gmail.com', '2003-03-10', 'người dùng', 'Kế toán', 'Đã khóa'),
(44, 'quyetrung', 'Nguyễn Văn Quyết', 'e10adc3949ba59abbe56e057f20f883e', 'quyetrung@gmail.com', '1990-03-24', 'người dùng', 'Kế toán', 'Đang hoạt động'),
(45, 'toanvap', 'Nguyễn Văn Toàn', 'e10adc3949ba59abbe56e057f20f883e', 'toanvap@gmail.com', '1995-03-27', 'người dùng', 'Kế toán', 'Đang hoạt động'),
(49, 'user2', 'TranThiB', 'abc456', 'tranthib@yahoo.com', '1988-11-20', 'quản lý', 'Nhân sự', 'Đang hoạt động'),
(50, 'user3', 'LeVanC', 'xyz789', 'levanc@outlook.com', '2000-03-10', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(55, 'user8', 'VuThiH', '789123', 'vuthih@yahoo.com', '1997-04-05', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(56, 'user9', 'DoVanI', 'pass456', 'dovani@gmail.com', '1993-06-22', 'nhân viên', 'Kế hoạch', 'Đang hoạt động'),
(57, 'user10', 'NgoThiK', 'abc789', 'ngothik@outlook.com', '1989-08-14', 'quản lý', 'Nhân sự', 'Đang hoạt động'),
(59, 'user12', 'LyThiM', 'pass321', 'lythim@yahoo.com', '1996-10-10', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(60, 'user13', 'PhanVanN', 'abc654', 'phanvann@outlook.com', '1987-03-25', 'quản lý', 'Kế hoạch', 'Đang hoạt động'),
(61, 'user14', 'DuongThiO', 'xyz987', 'duongthio@gmail.com', '1994-11-15', 'nhân viên', 'Nhân sự', 'Đang hoạt động'),
(64, 'user17', 'HaVanR', 'abc321', 'havanr@gmail.com', '1991-09-09', 'nhân viên', 'Kế hoạch', 'Đang hoạt động'),
(65, 'user18', 'KieuThiS', 'xyz654', 'kieuthis@outlook.com', '2002-02-14', 'nhân viên', 'Nhân sự', 'Đang hoạt động'),
(69, 'user22', 'TranVanW', 'abc987', 'tranvanw@yahoo.com', '1983-06-25', 'quản lý', 'Nhân sự', 'Đang hoạt động'),
(70, 'user23', 'LeThiX', 'xyz321', 'lethix@outlook.com', '1996-09-12', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(71, 'user24', 'PhamVanY', '123987', 'phamvany@gmail.com', '2000-11-05', 'nhân viên', 'Kế hoạch', 'Đang hoạt động'),
(73, 'user26', 'BuiVanAA', 'abc654', 'buivanaa@yahoo.com', '1994-03-22', 'nhân viên', 'Nhân sự', 'Đang hoạt động'),
(74, 'user27', 'DangThiBB', 'xyz987', 'dangthibb@gmail.com', '1999-07-14', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(75, 'user28', 'VuVanCC', 'pass123', 'vuvancc@outlook.com', '1987-10-10', 'quản lý', 'Kế hoạch', 'Đang hoạt động'),
(77, 'user30', 'NgoVanEE', 'xyz789', 'ngovanee@gmail.com', '2001-02-15', 'nhân viên', 'Nhân sự', 'Đang hoạt động'),
(78, 'user31', 'cTrinhThiFF', '123456', 'trinhthiff@yahoo.com', '1985-05-20', 'quản lý', 'Kế toán', 'Đã khóa'),
(79, 'user32', 'LyVanGG', 'pass789', 'lyvangg@outlook.com', '1997-08-08', 'nhân viên', 'Kế hoạch', 'Đã khóa'),
(89, 'minhgay', 'Lại Quang Minh', 'e10adc3949ba59abbe56e057f20f883e', 'minhgay@gmail.com', '2003-03-26', 'người dùng', 'Kế hoạch', 'Đã khóa'),
(90, 'bao', 'bao', 'e10adc3949ba59abbe56e057f20f883e', 'bao@gmail.com', '2005-03-10', 'người dùng', 'Nhân sự', 'Đã khóa'),
(96, 'đe', 'đe', '7cc2d02c95a718b919b73e97f7919787', 'de@gmail.com', '2025-04-22', 'quản lý', 'Nhân sự', 'Đang hoạt động'),
(97, 'dfewf', 'ềwfewfef', '261ce7d7f59783df971a96221b892986', 'fgeb@gmail.com', '2025-04-23', 'người dùng', 'Kế toán', 'Đang hoạt động'),
(103, 'minhquan', 'Nguyễn Minh Quân', 'e10adc3949ba59abbe56e057f20f883e', 'minhquan11003@gmail.com', '2003-10-01', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(104, 'tesst', 'tesst', '22c0766a85c365c67672ed9e7277ce03', 'tesst@gmail.com', '2025-04-02', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(106, 'dsvedg', 'ffvsfvf', '3cc0029bb23e546853eb5f0db0d20e1d', 'fcknfn@gmail.com', '2025-04-29', 'người dùng', 'Kĩ thuật', 'Đang hoạt động'),
(107, 'sjdifhuifhdoif', 'vl;òidhvuidjfbsk', '3297569182356c6dbbf58fafba7cfa4d', 'vhjbvkbsdkjv3@gmail.com', '2025-04-14', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(109, 'cvdsv', 'dcvdsc', '31e9d5054a3d51ae50ee256319ca5bae', '', '0000-00-00', 'quản lý', 'Nhân sự', 'Đang hoạt động'),
(112, 'tank', 'Trịnh Tuấn Anh', '15142bfc78384aa53cf00628326eaeeb', 'trinhtuananh1312003@gmail.com', '2025-04-15', 'người dùng', 'Kĩ thuật', 'Đang hoạt động'),
(113, 'admin', 'admin', 'f19b8dc2029cf707939e886e4b164681', 'admin@gmail.com', '2025-04-09', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(114, 'khgghods', 'kdndklfns', 'db7f468c1df999a93b1b9216bb2687ba', '', '0000-00-00', 'người dùng', 'Kĩ thuật', 'Đang hoạt động'),
(116, 'quanuser', 'quanuser', 'd11a704f0858d30751e3d56148799f76', 'minhquan11003@gmail.com', '2003-10-01', 'người dùng', 'Kĩ thuật', 'Đang hoạt động');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dons`
--
ALTER TABLE `dons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_nguoiduyet_id` (`nguoiduyet`),
  ADD KEY `FK_nguoitao_id` (`userid`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loginname` (`loginname`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dons`
--
ALTER TABLE `dons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `dons`
--
ALTER TABLE `dons`
  ADD CONSTRAINT `FK_nguoitao_id` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
