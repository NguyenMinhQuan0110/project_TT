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
                        <a href="<?php echo URLROOT ?>/home/deleteUserById/<?php echo $user->id ?>" onclick=" return hoilai('<?php echo $user->username ?>')"><button style="background-color: #EC221F;display:<?php if($_SESSION["loai_user"]=="người dùng"){echo "none";} ?>">Xóa</button></a>
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
        document.addEventListener("DOMContentLoaded", function() {
            // Khôi phục trạng thái từ sessionStorage (hoặc localStorage nếu bạn muốn)
            const selectedUsers = JSON.parse(sessionStorage.getItem("selectedUsers")) || []; // Mảng object {id, username}
            const headerCheckBox = document.querySelector("th img");
            const rowCheckBoxes = document.querySelectorAll("td img");

            // Khôi phục trạng thái checkbox cho các dòng
            rowCheckBoxes.forEach(function(item) {
                const row = item.closest("tr");
                const id = row.children[1].textContent; // Cột ID
                if (selectedUsers.some(user => user.id === id)) {
                    item.setAttribute("src", "<?php echo URLROOT ?>/image/checkked.png");
                }
            });

            // Bắt sự kiện click vào checkbox header
            headerCheckBox.addEventListener("click", function() {
                let isChecked = headerCheckBox.getAttribute("src") === "<?php echo URLROOT ?>/image/checkbox.png";
                headerCheckBox.setAttribute("src", isChecked ? "<?php echo URLROOT ?>/image/checkked.png" : "<?php echo URLROOT ?>/image/checkbox.png");

                rowCheckBoxes.forEach(function(item) {
                    const row = item.closest("tr");
                    const id = row.children[1].textContent;
                    const username = row.children[2].textContent; // Cột Username
                    item.setAttribute("src", isChecked ? "<?php echo URLROOT ?>/image/checkked.png" : "<?php echo URLROOT ?>/image/checkbox.png");

                    // Cập nhật danh sách selectedUsers
                    if (isChecked) {
                        if (!selectedUsers.some(user => user.id === id)) {
                            selectedUsers.push({ id: id, username: username });
                        }
                    } else {
                        const index = selectedUsers.findIndex(user => user.id === id);
                        if (index > -1) selectedUsers.splice(index, 1);
                    }
                });
                sessionStorage.setItem("selectedUsers", JSON.stringify(selectedUsers));
            });

            // Bắt sự kiện click vào checkbox ở các dòng
            rowCheckBoxes.forEach(function(item) {
                item.addEventListener("click", function(e) {
                    const row = item.closest("tr");
                    const id = row.children[1].textContent;
                    const username = row.children[2].textContent;
                    let isChecked = item.getAttribute("src") === "<?php echo URLROOT ?>/image/checkbox.png";
                    item.setAttribute("src", isChecked ? "<?php echo URLROOT ?>/image/checkked.png" : "<?php echo URLROOT ?>/image/checkbox.png");

                    // Cập nhật danh sách selectedUsers
                    if (isChecked) {
                        if (!selectedUsers.some(user => user.id === id)) {
                            selectedUsers.push({ id: id, username: username });
                        }
                    } else {
                        const index = selectedUsers.findIndex(user => user.id === id);
                        if (index > -1) selectedUsers.splice(index, 1);
                    }
                    sessionStorage.setItem("selectedUsers", JSON.stringify(selectedUsers));
        rubble });
            });

            // Xử lý nút "Xóa nhiều"
            const deleteMultipleBtn = document.getElementById("deleteMultipleBtn");
            deleteMultipleBtn.addEventListener("click", function() {
                if (selectedUsers.length < 2) {
                    alert("Vui lòng chọn ít nhất 2 người dùng để xóa!");
                    return;
                }

                // Lấy danh sách tất cả username từ selectedUsers (bao gồm các trang khác)
                const listUserNames = selectedUsers.map(user => user.username);

                if (!confirm("Bạn có chắc muốn xóa những người dùng này: " + listUserNames.join(", ") + " ?")) {
                    return;
                }

                // Chỉ gửi mảng ID qua form
                const selectedIds = selectedUsers.map(user => user.id);
                document.getElementById("idsInput").value = JSON.stringify(selectedIds);
                document.getElementById("deleteMultipleForm").submit();

                // Xóa danh sách đã chọn khỏi sessionStorage sau khi submit
                sessionStorage.removeItem("selectedUsers");
            });
        });
    </script>
</body>
</html>