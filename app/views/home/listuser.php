<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List user</title>
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/list_form.css">
    <style>
        .delete-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Nền mờ */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            border-radius: 5px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            overflow: hidden; /* Đảm bảo các góc bo tròn không bị tràn */
        }

        .modal-header {
            background-color: #007EC6; /* Màu xanh dương đậm */
            color: white;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .close-modal {
            cursor: pointer;
            font-size: 20px;
            color: white;
            font-weight: bold;
        }

        .close-modal:hover {
            color: #ddd;
        }

        .modal-body {
            padding: 20px;
            font-size: 16px;
            color: #333;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 10px 15px;
            border-top: 1px solid #ddd;
        }

        .btn-ok {
            background-color: #007EC6; /* Màu xanh dương */
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-ok:hover {
            background-color: #007EC6;
        }

        .btn-cancel {
            background-color: #FF3333; /* Màu đỏ */
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-cancel:hover {
            background-color: #e62e2e;
        }
    </style>
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
                <a href="<?php echo URLROOT ?>/home/showforminsertuser"><button style="background-color: #007EC6;display:<?php if($_SESSION["loai_user"]=="người dùng"){echo "none";} ?>" >Thêm mới</button></a>
                <button id="deleteMultipleBtn" style="background-color: #EC221F; margin-left: 18px;display:<?php if($_SESSION["loai_user"]=="người dùng"){echo "none";} ?>">Xóa nhiều</button>
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
                    <th style="display:<?php if($_SESSION["loai_user"]=="người dùng"){echo "none";} ?>">Hành động</th>
                </tr>
                <?php foreach($data['users'] as $user) : ?>     
                <tr>
                    <td><img src="<?php echo URLROOT ?>/image/checkbox.png" alt="" style="width: 24px;height: 24px;"> </td>
                    <td><?php echo $user->id ?></td>
                    <td><?php echo $user->username ?></td>
                    <td><?php echo $user->birthday ?></td>
                    <td><?php echo $user->trangthai ?></td>
                    <td style="display:<?php if($_SESSION["loai_user"]=="người dùng"){echo "none";} ?>">
                        <a href="<?php echo URLROOT ?>/home/getUserById/<?php echo $user->id ?>"><button style="background-color: #14AE5C;display:<?php if($_SESSION["phong_ban"]!=$user->phongban){echo "none";} ?>">Sửa</button></a>
                        <a href="<?php echo URLROOT ?>/home/deleteUserById/<?php echo $user->id ?>" onclick=" return hoilai('<?php echo $user->username ?>')"><button style="background-color: #EC221F;display:<?php if($_SESSION["phong_ban"]!=$user->phongban){echo "none";} ?>">Xóa</button></a>
                    </td>
                </tr>
                <script>
                    function hoilai(username){
                        return confirm("Bạn chắc chắn muốn xóa "+username+" chứ ???");
                    }
                </script>
                <?php endforeach; ?>
            </table>
            <div class="pagination">
                <?php 
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
    <div class="delete-modal" id="deleteModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Thông báo</h2>
                <span class="close-modal" id="closeModal">×</span>
            </div>
            <div class="modal-body">
                <p id="deleteMessage"></p>
            </div>
            <div class="modal-footer">
                <button id="confirmDeleteBtn" class="btn-ok">OK</button>
                <button id="cancelDeleteBtn" class="btn-cancel">Cancel</button>
            </div>
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function() {

    let selectedUsers = JSON.parse(sessionStorage.getItem("selectedUsers")) || [];
    const headerCheckBox = document.querySelector("th img");
    const rowCheckBoxes = document.querySelectorAll("td img");


    const deleteModal = document.getElementById("deleteModal");
    const deleteMessage = document.getElementById("deleteMessage");
    const closeModal = document.getElementById("closeModal");
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

    function showModal(message, callback) {
        deleteMessage.textContent = message;
        deleteModal.style.display = "flex";
        confirmDeleteBtn.onclick = function() {
            callback();
            hideModal();
        };
        cancelDeleteBtn.onclick = hideModal;
        closeModal.onclick = hideModal;
    }

    function hideModal() {
        deleteModal.style.display = "none";
    }


    const currentPageUserIds = Array.from(rowCheckBoxes).map(item => {
        const row = item.closest("tr");
        return row.children[1].textContent;
    });


    selectedUsers = selectedUsers.filter(user => currentPageUserIds.includes(user.id));


    rowCheckBoxes.forEach(function(item) {
        const row = item.closest("tr");
        const id = row.children[1].textContent;
        if (selectedUsers.some(user => user.id === id)) {
            item.setAttribute("src", "<?php echo URLROOT ?>/image/checkked.png");
        } else {
            item.setAttribute("src", "<?php echo URLROOT ?>/image/checkbox.png");
        }
    });


    headerCheckBox.addEventListener("click", function() {
        let isChecked = headerCheckBox.getAttribute("src") === "<?php echo URLROOT ?>/image/checkbox.png";
        headerCheckBox.setAttribute("src", isChecked ? "<?php echo URLROOT ?>/image/checkked.png" : "<?php echo URLROOT ?>/image/checkbox.png");

        rowCheckBoxes.forEach(function(item) {
            const row = item.closest("tr");
            const id = row.children[1].textContent;
            const username = row.children[2].textContent;
            item.setAttribute("src", isChecked ? "<?php echo URLROOT ?>/image/checkked.png" : "<?php echo URLROOT ?>/image/checkbox.png");

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


    rowCheckBoxes.forEach(function(item) {
        item.addEventListener("click", function(e) {
            const row = item.closest("tr");
            const id = row.children[1].textContent;
            const username = row.children[2].textContent;
            let isChecked = item.getAttribute("src") === "<?php echo URLROOT ?>/image/checkbox.png";
            item.setAttribute("src", isChecked ? "<?php echo URLROOT ?>/image/checkked.png" : "<?php echo URLROOT ?>/image/checkbox.png");

            if (isChecked) {
                if (!selectedUsers.some(user => user.id === id)) {
                    selectedUsers.push({ id: id, username: username });
                }
            } else {
                const index = selectedUsers.findIndex(user => user.id === id);
                if (index > -1) selectedUsers.splice(index, 1);
            }
            sessionStorage.setItem("selectedUsers", JSON.stringify(selectedUsers));
        });
    });


    const deleteMultipleBtn = document.getElementById("deleteMultipleBtn");
    deleteMultipleBtn.addEventListener("click", function() {
        if (selectedUsers.length < 2) {
            alert("Vui lòng chọn ít nhất 2 người dùng để xóa!");
            return;
        }

        const listUserNames = selectedUsers.map(user => user.username);
        showModal("Bạn có chắc muốn xóa những người dùng này: " + listUserNames.join(", ") + " ?", function() {
            const selectedIds = selectedUsers.map(user => user.id);
            document.getElementById("idsInput").value = JSON.stringify(selectedIds);
            document.getElementById("deleteMultipleForm").submit();
            sessionStorage.removeItem("selectedUsers");
        });
    });


    window.hoilai = function(username, id) {
        showModal("Bạn chắc chắn muốn xóa " + username + " chứ?", function() {
            window.location.href = "<?php echo URLROOT ?>/home/deleteUserById/" + id;
        });
        return false;
    };
});
</script>
</body>
</html>