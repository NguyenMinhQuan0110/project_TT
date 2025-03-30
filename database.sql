DELIMITER $$

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
	SELECT users.username,dons.loaidon,dons.ngaytao,dons.trangthai,dons.enddate,dons.title,dons.id FROM dons INNER JOIN users ON users.id=dons.userid WHERE dons.nguoiduyet=p_nguoiduyet LIMIT p_limits OFFSET p_offsets;
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


ALTER TABLE `dons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_nguoiduyet_id` (`nguoiduyet`),
  ADD KEY `FK_nguoitao_id` (`userid`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loginname` (`loginname`);


ALTER TABLE `dons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;


ALTER TABLE `dons`
  ADD CONSTRAINT `FK_nguoiduyet_id` FOREIGN KEY (`nguoiduyet`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_nguoitao_id` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;


