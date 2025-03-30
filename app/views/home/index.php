<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/dashboard.css">
</head>
<body>
    <header>
        <h1>Shansin</h1>
        <p>Hệ thống quản lý đơn</p>
    </header>
    <div class="than">
        <div class="menu">
            <ul>
                <li class="dashboard"><a href="<?php echo URLROOT ?>/home/index">Trang chủ</a></li>
                <li><a href="<?php echo URLROOT ?>/home/formlistuser">Quản lý người dùng</a></li>
                <li><a href="<?php echo URLROOT ?>/don/index">Quản lý đơn</a></li>
                <li><a href="<?php echo URLROOT ?>/home/logout">Đăng xuất</a></li>
            </ul>
        </div>
            <?php if (isset($_SESSION["message"])): ?>
                <script>
                    alert("<?php echo $_SESSION['message']; ?>");
                </script>
                <?php unset($_SESSION["message"]); ?>
            <?php endif; ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">STT</th>
                        <th style="width: 110px;">Người dùng</th>
                        <th style="width: 171px;">Loại đơn</th>
                        <th style="width: 110px;">Ngày lập</th>
                        <th style="width: 110px;">Trạng thái</th>
                        <th style="width: 108px;">Ngày duyệt</th>
                        <th style="width: 408px;">Mô tả</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt=1 ?>
                    <?php foreach($data['dons'] as $don) : ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $don->username; ?></td>
                            <td><?php echo $don->loaidon; ?></td>
                            <td><?php echo $don->ngaytao; ?></td>
                            <td style="font-weight: bold;"><?php echo $don->trangthai; ?></td>
                            <td><?php echo $don->ngayduyet; ?></td>
                            <td style="font-weight: bold;"><?php echo $don->title; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
</body>
</html>