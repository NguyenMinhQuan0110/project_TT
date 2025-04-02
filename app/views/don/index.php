<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Đơn</title>
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/list_form.css">
</head>
<body>
    <header>
        <h1>Shansin</h1>
        <p>Hệ thống quản lý đơn</p>
    </header>
    <div class="than">
        <div class="menu">
            <ul>
                <li><a href="<?php echo URLROOT ?>/home/index">Trang chủ</a></li>
                <li><a href="<?php echo URLROOT ?>/home/formlistuser">Quản lý người dùng</a></li>
                <li class="dashboard"><a href="<?php echo URLROOT ?>/don/index">Quản lý đơn</a></li>
                <li><a href="<?php echo URLROOT ?>/home/logout">Đăng xuất</a></li>
            </ul>
        </div>
            <?php if (isset($_SESSION["message"])): ?>
                <script>
                    alert("<?php echo $_SESSION['message']; ?>");
                </script>
                <?php unset($_SESSION["message"]); ?>
            <?php endif; ?>
        <div class="main">
            <div class="tren">
                <form action="<?php echo URLROOT ?>/don/searchDon" method="get" style="margin-right: 348px;">
                    <label for="">Tên Uesr/Loại đơn/Nội dung</label>
                    <input type="text" name="keyword">
                    <input type="submit" value="Tìm kiếm">
                </form>
                <a href="<?php echo URLROOT ?>/don/showForminsert"><button style="background-color: #007EC6;width: 133px;">Thêm mới đơn</button></a>
            </div>
            <table>
                <tr>
                    <th>STT</th>
                    <th>Người dùng</th>
                    <th>Loại đơn</th>
                    <th>Ngày lập</th>
                    <th>Trạng thái</th>
                    <th>Ngày duyệt</th>
                    <th>Mô tả</th>
                </tr>
                <?php $stt=$data['limit']*($data['currentPage']-1)+1; ?>
                <?php foreach($data['dons'] as $don) : ?>
                        <tr style="background-color:<?php if($don->trangthai=="chưa duyệt"){echo "#90FF98";}elseif($don->trangthai=="đã hủy"){echo "#FFB5B5";} ?>;">
                            <td><a href="<?php echo URLROOT ?>/don/getDonById/<?php echo $don->id ?>" style="text-decoration: none;color: #333;"><?php echo $stt++ ?></a></td>
                            <td><a href="<?php echo URLROOT ?>/don/getDonById/<?php echo $don->id ?>" style="text-decoration: none;color: #333;"><?php echo $don->username ?></a></td>
                            <td><a href="<?php echo URLROOT ?>/don/getDonById/<?php echo $don->id ?>" style="text-decoration: none;color: #333;"><?php echo $don->loaidon?></a></td>
                            <td><a href="<?php echo URLROOT ?>/don/getDonById/<?php echo $don->id ?>" style="text-decoration: none;color: #333;"><?php echo $don->ngaytao?></a></td>
                            <td><a href="<?php echo URLROOT ?>/don/getDonById/<?php echo $don->id ?>" style="text-decoration: none;color: #333;"><?php echo $don->trangthai ?></a></td>
                            <td><a href="<?php echo URLROOT ?>/don/getDonById/<?php echo $don->id ?>" style="text-decoration: none;color: #333;"><?php echo $don->ngayduyet ?></a></td> 
                            <td style="display: flex;justify-content: space-between; /* Đẩy nội dung và nút sang hai phía */"><span><a href="<?php echo URLROOT ?>/don/getDonById/<?php echo $don->id ?>" style="text-decoration: none;color: #333;"><?php echo $don->title ?></a></span>
                                <div class="buttons" style="display: <?php if($don->trangthai!="chưa duyệt"){echo "none";} ?>;">
                                    <a href="<?php echo URLROOT ?>/don/getDonByIdDuyetNhanh/<?php echo $don->id ?>"><button style="background-color: #14AE5C;display:<?php if($_SESSION["loai_user"]=="người dùng"||$_SESSION["user_id"]!=$don->nguoiduyet){echo "none";} ?>">Duyệt</button></a>
                                    <a href="<?php echo URLROOT ?>/don/getDonByIdHuy/<?php echo $don->id ?>"><button style="background-color: #EC221F;display:<?php if($_SESSION["loai_user"]=="người dùng"||$_SESSION["user_id"]!=$don->nguoiduyet){echo "none";} ?>">Hủy</button></a>
                                </div>
                            </td>
                        </tr>
                <?php endforeach; ?>
            </table>
            <div class="pagination">
                <?php
                    $baseUrl = isset($data['keyword']) && !empty($data['keyword']) 
                    ? URLROOT . '/don/searchDon?keyword=' . urlencode($data['keyword']) 
                    : URLROOT . '/don/index';
                ?>
                <?php if ($data['currentPage'] > 1): ?>
                    <a href="<?php echo $baseUrl . '&page=' . ($data['currentPage'] - 1); ?>" class="prev">← Previous</a>
                <?php endif; ?>

                <?php if ($data['currentPage'] > 3): ?>
                    <a href="<?php echo $baseUrl . '&page=1'; ?>">1</a>
                    <?php if ($data['currentPage'] > 4): ?>
                        <span class="dots">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = max(1, $data['currentPage'] - 2); $i <= min($data['totalPages'], $data['currentPage'] + 2); $i++): ?>
                    <a href="<?php echo $baseUrl . '&page=' . $i; ?>" class="<?php echo $i == $data['currentPage'] ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($data['currentPage'] < $data['totalPages'] - 2): ?>
                    <?php if ($data['currentPage'] < $data['totalPages'] - 3): ?>
                        <span class="dots">...</span>
                    <?php endif; ?>
                    <a href="<?php echo $baseUrl . '&page=' . $data['totalPages']; ?>"><?php echo $data['totalPages']; ?></a>
                <?php endif; ?>

                <?php if ($data['currentPage'] < $data['totalPages']): ?>
                    <a href="<?php echo $baseUrl . '&page=' . ($data['currentPage'] + 1); ?>" class="next">Next →</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>