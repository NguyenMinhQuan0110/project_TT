<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List user</title>
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
                <li class="dashboard"><a href="<?php echo URLROOT ?>/home/formlistuser">Quản lý người dùng</a></li>
                <li><a href="<?php echo URLROOT ?>/don/index">Quản lý đơn</a></li>
                <li><a href="<?php echo URLROOT ?>/home/logout">Đăng xuất</a></li>
            </ul>
        </div>
        <div class="main">
            <?php if (isset($_SESSION["message"])): ?>
                <script>
                    alert("<?php echo $_SESSION['message']; ?>");
                </script>
                <?php unset($_SESSION["message"]); ?>
            <?php endif; ?>
            <?php echo $_SESSION["user_name"]; ?>
            <div class="tren">
                <form action="<?php echo URLROOT ?>/home/seachUser" method="get" style="margin-right: 348px;;">
                    <label for="">Mã/Tên Uesr</label>
                    <input type="text" name="keyword">
                    <input type="submit" value="Tìm kiếm">
                </form>
                <a href="<?php echo URLROOT ?>/home/showforminsertuser"><button style="background-color: #007EC6;">Thêm mới</button></a>
                <button id="deleteMultipleBtn" style="background-color: #EC221F; margin-left: 18px;">Xóa nhiều</button>
                <form id="deleteMultipleForm" action="<?php echo URLROOT ?>/home/deleteMultipleUser" method="post">
                    <input type="hidden" name="ids" id="idsInput">
                </form>
            </div>
            <table>
                <tr>
                    <th><img src="<?php echo URLROOT ?>/image/checkbox.png" alt="" style="width: 24px;height: 24px;"></th>
                    <th>Mã người dùng</th>
                    <th>Tên người dùng</th>
                    <th>Ngày sinh</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
                <?php foreach($data['users'] as $user) : ?>     
                <tr>
                    <td><img src="<?php echo URLROOT ?>/image/checkbox.png" alt="" style="width: 24px;height: 24px;"> </td>
                    <td><?php echo $user->id ?></td>
                    <td><?php echo $user->username ?></td>
                    <td><?php echo $user->birthday ?></td>
                    <td><?php echo $user->trangthai ?></td>
                    <td>
                        <a href="<?php echo URLROOT ?>/home/getUserById/<?php echo $user->id ?>"><button style="background-color: #14AE5C;">Sửa</button></a>
                        <a href="<?php echo URLROOT ?>/home/deleteUserById/<?php echo $user->id ?>" onclick=" return hoilai('<?php echo $user->username ?>')"><button style="background-color: #EC221F;">Xóa</button></a>
                    </td>
                </tr>
                <script>
                    function hoilai(username){
                        return confirm("Bạn chắc chắn muốn xóa "+username+" chứ ???");
                    }
                </script>
                <?php endforeach; ?>
            </table>
            <!-- Thêm phần phân trang -->
            <div class="pagination">
                <?php 
                // Định nghĩa $baseUrl dựa trên việc có keyword hay không
                $baseUrl = isset($data['keyword']) && !empty($data['keyword']) 
                    ? URLROOT . '/home/seachUser?keyword=' . urlencode($data['keyword']) 
                    : URLROOT . '/home/formlistuser';
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
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            const headerCheckBox=document.querySelector("th img");
            const rowCheckBoxs=document.querySelectorAll("td img");
            //Bắt sự kiện kick vào ảnh checkbox
            headerCheckBox.addEventListener("click",function(){
                let ischecked=headerCheckBox.getAttribute("src")==="<?php echo URLROOT ?>/image/checkbox.png";
                //Đảo trạng thái checkbox ở header
                headerCheckBox.setAttribute("src",ischecked?"<?php echo URLROOT ?>/image/checkked.png":"<?php echo URLROOT ?>/image/checkbox.png");
                //Đảo trạng thái checkbox ở các dòng
                rowCheckBoxs.forEach(function(item){
                    item.setAttribute("src", ischecked ? "<?php echo URLROOT ?>/image/checkked.png" : "<?php echo URLROOT ?>/image/checkbox.png");
                })
            })
            //Bắt sự kiện kick vào ảnh checkbox ở các dòng
            rowCheckBoxs.forEach(function(item){
                item.addEventListener("click",function(e){
                    let ischecked=item.getAttribute("src")==="<?php echo URLROOT ?>/image/checkbox.png";
                    item.setAttribute("src",ischecked?"<?php echo URLROOT ?>/image/checkked.png":"<?php echo URLROOT ?>/image/checkbox.png");
                })
            })
        })
        document.addEventListener("DOMContentLoaded", function() {
            // Nút thực hiện hành động, ví dụ: "Xóa nhiều"
            const deleteMultipleBtn = document.getElementById("deleteMultipleBtn");

            deleteMultipleBtn.addEventListener("click", function() {
                const checkedIds = []; // Mảng lưu trữ ID của các dòng được tick
                const listuserName=[];
                const rows = document.querySelectorAll("table tr:not(:first-child)"); // Lấy tất cả các dòng (trừ tiêu đề)

                rows.forEach(function(row) {
                    const checkboxImg = row.querySelector("td img"); // Lấy ảnh checkbox trong dòng
                    const isChecked = checkboxImg.getAttribute("src") === "<?php echo URLROOT ?>/image/checkked.png";
                    
                    if (isChecked) {
                        const id = row.children[1].textContent; // Lấy giá trị ID từ cột thứ 2 (cột Mã người dùng)
                        checkedIds.push(id);
                        const user_name=row.children[2].textContent;
                        listuserName.push(user_name);
                    }
                });
                if (checkedIds.length < 2) {
                    alert("Vui lòng chọn ít nhất 2 người dùng để xóa!");
                    return;
                }

                if (!confirm("Bạn có chắc muốn xóa những người dùng nay:"+ listuserName +" ?")) {
                    return;
                }

                document.getElementById("idsInput").value = JSON.stringify(checkedIds);//chuyển mảng thành chuỗi rồi chuyền cho input idsInput
                document.getElementById("deleteMultipleForm").submit();

            });
        });
    </script>
</body>
</html>