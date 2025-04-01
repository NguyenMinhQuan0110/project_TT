
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get30Don` ()   BEGIN
    SELECT users.username,dons.loaidon,dons.ngaytao,dons.trangthai,dons.ngayduyet,dons.title,dons.id FROM dons INNER JOIN users ON users.id=dons.userid ORDER BY dons.ngaytao DESC LIMIT 30;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllDonByNguoiDuyet` (IN `p_limits` INT, IN `p_offsets` INT, IN `p_nguoiduyet` INT)   BEGIN
	SELECT users.username,dons.loaidon,dons.ngaytao,dons.trangthai,dons.ngayduyet,dons.title,dons.id FROM dons INNER JOIN users ON users.id=dons.userid WHERE dons.nguoiduyet=p_nguoiduyet LIMIT p_limits OFFSET p_offsets;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllUser` (IN `p_limits` INT, IN `p_offsets` INT)   BEGIN
    SELECT * FROM users 
    LIMIT p_limits OFFSET p_offsets;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDonById` (IN `p_id` INT)   BEGIN
    SELECT * FROM dons WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDonByUserId` (IN `user_id` INT)   BEGIN
	SELECT * FROM dons WHERE userid=user_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTotalAllDonByNguoiDuyet` (IN `p_nguoiduyet` INT)   BEGIN
    SELECT COUNT(*) AS toltal FROM dons WHERE dons.nguoiduyet=p_nguoiduyet;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTotalAllUser` ()   BEGIN
    SELECT COUNT(*) as toltal FROM users;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTotalSearchDon` (IN `p_keyword` VARCHAR(100))   BEGIN
	SELECT COUNT(*) AS toltal FROM dons INNER JOIN users ON users.id=dons.userid 
    WHERE users.username LIKE  CONCAT('%', p_keyword, '%')
    OR dons.title LIKE  CONCAT('%', p_keyword, '%')
    OR dons.loaidon LIKE  CONCAT('%', p_keyword, '%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTotalSearchUser` (IN `p_keyword` VARCHAR(255))   BEGIN
    SELECT COUNT(*) as toltal FROM users 
    WHERE loginname LIKE CONCAT('%', p_keyword, '%')
    OR username LIKE CONCAT('%', p_keyword, '%')
    OR email LIKE CONCAT('%', p_keyword, '%');
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
	SELECT users.username,dons.loaidon,dons.ngaytao,dons.trangthai,dons.enddate,dons.title,dons.id FROM dons INNER JOIN users ON users.id=dons.userid
    WHERE users.username LIKE  CONCAT('%', p_keyword, '%')
    OR dons.title LIKE  CONCAT('%', p_keyword, '%')
    OR dons.loaidon LIKE  CONCAT('%', p_keyword, '%')
    LIMIT p_limits OFFSET p_offsets;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchUser` (IN `p_keyword` VARCHAR(255), IN `p_limits` INT, IN `p_offsets` INT)   BEGIN
    SELECT * FROM users 
    WHERE loginname LIKE CONCAT('%', p_keyword, '%')
    OR username LIKE CONCAT('%', p_keyword, '%')
    OR email LIKE CONCAT('%', p_keyword, '%')
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
(33, 'gregewfefe', 'fdfvefefefe', 3, 'Đơn nghỉ phép', '2025-03-19', '2025-03-28', '1743132201_3de6a81aad5f0c01554e-1714647805-183319avatar.jpg', 'chưa duyệt', 2, '2025-03-28 14:22:53', NULL),
(34, 'đơn xin nghỉ phép', 'em muốn nghỉ 1 tuần tới', 2, 'Đơn nghỉ phép', '2025-03-27', '2025-03-29', '1743137949_3de6a81aad5f0c01554e-1714647805-183319avatar.jpg', 'đã hủy', 2, '2025-03-28 14:22:53', '2025-03-30'),
(35, 'máy hỏng', 'Máy điều hóa ở phòng 304 bị bỏng', 2, 'Đơn cấp vật tư máy móc', '2025-03-25', '2025-03-27', '1743141996_66337acdef3c7.jpg', 'đã hủy', 2, '2025-03-28 14:22:53', '2025-03-31'),
(36, 'mai chuyển trọ giúp tôi ', 'Mai tầm 9h sáng qua giúp tôi chuyển trọ', 7, 'Đơn xin thanh toán công tác phí', '2025-03-26', '2025-03-27', '1743142776_3de6a81aad5f0c01554e-1714647805-183319avatar.jpg', 'đã duyệt', 2, '2025-03-28 14:22:53', '2025-03-28'),
(39, 'sfesdff', 'dfedsfff', 6, 'Đơn cấp vật tư máy móc', '2025-04-02', '2025-04-03', '1743155451_66335b3bb9ec6 - Copy.jpg', 'đã huy', 47, '2025-03-28 16:50:51', '2025-03-28'),
(40, 'tối 8r hay 9 h đây', 'ruihr rì ihfreufh bire ibri irhiefhr ibhri rbirfh bfirf ibrif rbiri', 3, 'Đơn thay đổi giờ làm', '2025-03-27', '2025-03-29', '1743166003_6633fca238df2.webp', 'đã hủy', 3, '2025-03-28 19:46:43', '2025-03-28'),
(41, 'hoighroighroi', 'gjhierghoiegheoifhewoifhewfouewhoeiwfh', 3, 'Đơn xin thanh toán công tác phí', '2025-03-19', '2025-03-29', '1743171418_3de6a81aad5f0c01554e-1714647805-183319avatar.jpg', 'đã duyệt', 2, '2025-03-28 21:16:58', '2025-03-29'),
(42, 'bẻvrvgre', 'rbgrgregrege4rgerg', 3, 'Đơn thay đổi giờ làm', '2025-03-19', '2025-03-25', '1743172923_fc38746393fb3da564ea-1714383945-181341avatar.webp', 'đã duyệt', 2, '2025-03-28 21:42:03', '2025-03-29'),
(43, 'sdvdv', 'vfvfvrevrbvewvewfefqwfcwvefewdewfervrf', 3, 'Đơn cấp vật tư máy móc', '2025-03-27', '2025-03-28', '1743174177_Toan-4.jpg', 'đã duyệt', 2, '2025-03-28 22:02:57', '2025-03-28'),
(44, 'nveoignerogi', 'hrfriehrifuhfoui', 3, 'Đơn cấp vật tư máy móc', '2025-03-26', '2025-03-26', '1743175599_Toan-4.jpg', 'đã hủy', 2, '2025-03-28 22:26:39', '2025-03-29'),
(45, 'ibkj', 'kihougvgvhklkjkhvjb', 3, 'Đơn nghỉ phép', '2025-03-26', '2025-03-28', '1743176057_66335b3bb9ec6.jpg', 'đã duyệt', 2, '2025-03-28 22:34:17', '2025-03-29'),
(46, 'rfrggr', 'gregrgrff', 2, 'Đơn nghỉ phép', '2025-03-27', '2025-03-29', '1743176212_715071871f45f3d8c61ae31bc0cc9501.png', 'đã hủy', 2, '2025-03-28 22:36:52', '2025-03-29'),
(47, 'uibiubijkb', 'ỳcgvugyibhvjboibjkhionk', 2, 'Đơn nghỉ phép', '2025-03-26', '2025-03-19', '1743177676_fc38746393fb3da564ea-1714383945-181341avatar.webp', 'đã duyệt', 2, '2025-03-28 23:01:16', '2025-03-30'),
(48, 'Đơn xin vô Dis', 'Cho e vô dis với ạ', 2, 'Đơn cấp vật tư máy móc', '2025-03-17', '2025-03-26', '1743177874_tải xuống.jpg', 'đã hủy', 3, '2025-03-28 23:04:34', '2025-03-29'),
(49, 'ieheiuvheri', 'reviojvorevjrpvjovk[v\r\nvreovrjpvorv\r\nvmkrevmrvpr', 2, 'Đơn nghỉ phép', '2025-03-17', '2025-03-28', '1743242373_6633fca238df2.webp', 'đã hủy', 2, '2025-03-29 16:59:33', '2025-03-29'),
(50, 'ertvbr', 'êffefv\r\nhiwecho\r\ncnrcnkc\r\ncrkc', 2, 'Đơn nghỉ phép', '2025-03-17', '2025-03-28', '1743243115_z4172066407511_8501b679d713a0851ee164819dc573fb.jpg', 'chưa duyệt', 2, '2025-03-29 17:11:55', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `loginname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(220) NOT NULL,
  `email` varchar(225) NOT NULL,
  `birthday` date NOT NULL,
  `loaiuser` varchar(100) NOT NULL,
  `phongban` varchar(100) NOT NULL,
  `trangthai` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `loginname`, `username`, `password`, `email`, `birthday`, `loaiuser`, `phongban`, `trangthai`) VALUES
(2, 'minhquan', 'Nguyễn Minh Quân', 'e10adc3949ba59abbe56e057f20f883e', 'minhquan11003@gmail.com', '2003-10-01', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(3, 'tank', 'Trịnh Tuấn Anh', 'e10adc3949ba59abbe56e057f20f883e', 'trinhtuananh1312003@gmail.com', '2003-03-04', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(4, 'huythang', 'Nguyễn Bùi Huy Thắng', 'e10adc3949ba59abbe56e057f20f883e', 'thang@gmail.com', '2012-03-07', 'người dùng', 'Kĩ thuật', 'Đang hoạt động'),
(6, 'nhatduy', 'Trần Nhật Duy', 'e10adc3949ba59abbe56e057f20f883e', 'duy49725@gmail.com', '2003-03-12', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(7, 'khuonglieu', 'Lư Tiến Khương', 'e10adc3949ba59abbe56e057f20f883e', 'khuonglol12@gmail.com', '2003-03-18', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(8, 'beachmouse', 'Phan Hải Sơn', 'e10adc3949ba59abbe56e057f20f883e', 'son@gamil.com', '2003-03-12', 'người dùng', 'Kĩ thuật', 'Đang hoạt động'),
(10, 'fefreg', 'grgre', 'd41d8cd98f00b204e9800998ecf8427e', 'bfd@gmail.com', '2025-03-26', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(11, 'edd', 'ưdwqd', 'e10adc3949ba59abbe56e057f20f883e', 'wqd@gmail.com', '2025-03-19', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(12, 'ffe', 'êf', '8fa14cdd754f91cc6554c9e71929cce7', 'dsjshdsj@gmail.com', '2004-03-26', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(16, 'fefe', 'fffdf', 'd41d8cd98f00b204e9800998ecf8427e', 'fdvfv@gmail.com', '1999-03-24', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(26, 'dcdvd', 'dcdvd', 'd41d8cd98f00b204e9800998ecf8427e', 'dcdvd@gmail.com', '2001-03-18', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(30, 'dfdf', 'dfdf', 'd41d8cd98f00b204e9800998ecf8427e', 'dfdf@gmail.com', '2001-03-02', 'người dùng', 'Nhân sự', 'Đang hoạt động'),
(43, 'phuongwibu ', 'Lê Vạn Phương', 'e10adc3949ba59abbe56e057f20f883e', 'phuongwb@gmail.com', '2003-03-10', 'người dùng', 'Kế toán', 'Đang hoạt động'),
(44, 'quyetrung', 'Nguyễn Văn Quyết', 'e10adc3949ba59abbe56e057f20f883e', 'quyetrung@gmail.com', '1990-03-24', 'người dùng', 'Kế toán', 'Đang hoạt động'),
(45, 'toanvap', 'Nguyễn Văn Toàn', 'e10adc3949ba59abbe56e057f20f883e', 'toanvap@gmail.com', '1995-03-27', 'người dùng', 'Kế toán', 'Đang hoạt động'),
(46, 'hoang', 'Vũ Việt Hoàng', 'e10adc3949ba59abbe56e057f20f883e', 'hoang@gmail.com', '2003-03-24', 'người dùng', 'Kĩ thuật', 'Đang hoạt động'),
(47, 'admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@gmail.com', '2000-03-19', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(48, 'user1', 'NguyenVanA', 'pass123', 'nguyenvana@gmail.com', '1995-05-15', 'nhân viên', 'Kĩ thuật', 'Đang hoạt động'),
(49, 'user2', 'TranThiB', 'abc456', 'tranthib@yahoo.com', '1988-11-20', 'quản lý', 'Nhân sự', 'Đang hoạt động'),
(50, 'user3', 'LeVanC', 'xyz789', 'levanc@outlook.com', '2000-03-10', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(54, 'user7', 'DangVanG', 'xyz456', 'dangvang@outlook.com', '1985-02-18', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(55, 'user8', 'VuThiH', '789123', 'vuthih@yahoo.com', '1997-04-05', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(56, 'user9', 'DoVanI', 'pass456', 'dovani@gmail.com', '1993-06-22', 'nhân viên', 'Kế hoạch', 'Đang hoạt động'),
(57, 'user10', 'NgoThiK', 'abc789', 'ngothik@outlook.com', '1989-08-14', 'quản lý', 'Nhân sự', 'Đang hoạt động'),
(58, 'user11', 'TrinhVanL', 'xyz123', 'trinhvanl@gmail.com', '2001-01-30', 'nhân viên', 'Kĩ thuật', 'Đang hoạt động'),
(59, 'user12', 'LyThiM', 'pass321', 'lythim@yahoo.com', '1996-10-10', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(60, 'user13', 'PhanVanN', 'abc654', 'phanvann@outlook.com', '1987-03-25', 'quản lý', 'Kế hoạch', 'Đang hoạt động'),
(61, 'user14', 'DuongThiO', 'xyz987', 'duongthio@gmail.com', '1994-11-15', 'nhân viên', 'Nhân sự', 'Đang hoạt động'),
(62, 'user15', 'TaVanP', '123789', 'tavanp@hotmail.com', '1999-07-07', 'nhân viên', 'Kĩ thuật', 'Đang hoạt động'),
(63, 'user16', 'ChuThiQ', 'pass654', 'chuthiq@yahoo.com', '1986-05-20', 'quản lý', 'Kế toán', 'Đang hoạt động'),
(64, 'user17', 'HaVanR', 'abc321', 'havanr@gmail.com', '1991-09-09', 'nhân viên', 'Kế hoạch', 'Đang hoạt động'),
(65, 'user18', 'KieuThiS', 'xyz654', 'kieuthis@outlook.com', '2002-02-14', 'nhân viên', 'Nhân sự', 'Đang hoạt động'),
(66, 'user19', 'LuuVanT', 'pass987', 'luuvant@gmail.com', '1984-12-01', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(67, 'user20', 'MaiThiU', '123654', 'maithiu@yahoo.com', '1995-08-28', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(68, 'user21', 'NguyenThiV', 'pass321', 'nguyenthiv@gmail.com', '1990-04-18', 'nhân viên', 'Kĩ thuật', 'Đang hoạt động'),
(69, 'user22', 'TranVanW', 'abc987', 'tranvanw@yahoo.com', '1983-06-25', 'quản lý', 'Nhân sự', 'Đang hoạt động'),
(70, 'user23', 'LeThiX', 'xyz321', 'lethix@outlook.com', '1996-09-12', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(71, 'user24', 'PhamVanY', '123987', 'phamvany@gmail.com', '2000-11-05', 'nhân viên', 'Kế hoạch', 'Đang hoạt động'),
(72, 'user25', 'HoangThiZ', 'pass654', 'hoangthiz@hotmail.com', '1988-01-30', 'quản lý', 'Kĩ thuật', 'Đang hoạt động'),
(73, 'user26', 'BuiVanAA', 'abc654', 'buivanaa@yahoo.com', '1994-03-22', 'nhân viên', 'Nhân sự', 'Đang hoạt động'),
(74, 'user27', 'DangThiBB', 'xyz987', 'dangthibb@gmail.com', '1999-07-14', 'nhân viên', 'Kế toán', 'Đang hoạt động'),
(75, 'user28', 'VuVanCC', 'pass123', 'vuvancc@outlook.com', '1987-10-10', 'quản lý', 'Kế hoạch', 'Đang hoạt động'),
(76, 'user29', 'DoThiDD', 'abc456', 'dothidd@hotmail.com', '1992-12-28', 'nhân viên', 'Kĩ thuật', 'Đang hoạt động'),
(77, 'user30', 'NgoVanEE', 'xyz789', 'ngovanee@gmail.com', '2001-02-15', 'nhân viên', 'Nhân sự', 'Đang hoạt động'),
(78, 'user31', 'cTrinhThiFF', '123456', 'trinhthiff@yahoo.com', '1985-05-20', 'quản lý', 'Kế toán', 'Đã khóa'),
(79, 'user32', 'LyVanGG', 'pass789', 'lyvangg@outlook.com', '1997-08-08', 'nhân viên', 'Kế hoạch', 'Đã khóa'),
(88, 'duck', 'Nguyễn Minh Đức', 'e10adc3949ba59abbe56e057f20f883e', 'duck@gmail.com', '2003-03-25', 'người dùng', 'Kĩ thuật', 'Đã khóa'),
(89, 'minhgay', 'Lại Quang Minh', 'e10adc3949ba59abbe56e057f20f883e', 'minhgay@gmail.com', '2003-03-26', 'người dùng', 'Kế hoạch', 'Đã khóa'),
(90, 'bao', 'bao', 'e10adc3949ba59abbe56e057f20f883e', 'bao@gmail.com', '2005-03-10', 'người dùng', 'Nhân sự', 'Đã khóa'),
(91, 'fvf', 'vèvrv', 'a75001832b9705f4ecd9f2d67881a6c1', 'vrvrv', '2025-04-01', 'người dùng', 'Kĩ thuật', 'Đang hoạt động'),
(92, 'dvvef', 'ềwdưd', 'e10adc3949ba59abbe56e057f20f883e', 'fchofchn@gmail.com', '2025-03-26', 'người dùng', 'Kế toán', 'Đang hoạt động'),
(93, 'ohorighog', 'rtrtrhtrht', 'e10adc3949ba59abbe56e057f20f883e', 'goet@gmail.com', '2025-03-26', 'người dùng', 'Nhân sự', 'Đang hoạt động');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `dons`
--
ALTER TABLE `dons`
  ADD CONSTRAINT `FK_nguoiduyet_id` FOREIGN KEY (`nguoiduyet`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_nguoitao_id` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;


