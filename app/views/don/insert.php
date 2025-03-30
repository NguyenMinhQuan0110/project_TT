<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Đơn </title>
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/insertform.css">
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
        <div class="main">
            <span style="font-size: 40px; color: red;" ><?php echo isset($data["error"])?$data["error"]:"" ?></span>
            <p>Thêm mới đơn</p>
            <form action="<?php echo URLROOT ?>/don/insert" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo $_SESSION["user_id"] ?>" name="userid">
                <div>
                    <label for="username">Tiêu đề <span style="color: red;">*</span></label>
                    <input type="text" id="username" name="title" required style="margin-left: 84px;">
                </div>
                <div style="display: flex; align-items: flex-start;">
                    <label for="username" style="top: 0;">Nội dung </label>
                    <textarea name="noidung" id="" style="height: 94px; width: 480px; margin-left: 86px;border-radius: 4px;"></textarea>
                </div>
                <div>
                    <label for="">Người duyệt <span style="color: red;">*</span></label>
                    <select id="cars" style="margin-left: 52px;" name="nguoiduyet">
                        <option value=""></option>
                        <?php foreach($data["nguoiduyet"] as $user) : ?>
                        <option value="<?php echo $user->id ?>"><?php echo $user->username ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div>
                    <label for="loaidon">Loại đơn <span style="color: red;">*</span></label>
                    <select id="cars" style="margin-left: 73px;" name="loaidon">
                        <option value=""></option>
                        <option value="Đơn nghỉ phép">Đơn nghỉ phép</option>
                        <option value="Đơn cấp vật tư máy móc">Đơn cấp vật tư máy móc</option>
                        <option value="Đơn thay đổi giờ làm">Đơn thay đổi giờ làm</option>
                        <option value="Đơn xin thanh toán công tác phí">Đơn xin thanh toán công tác phí</option>
                    </select>
                </div>
                <div>
                    <label for="username">Ngày bắt đầu <span style="color: red;">*</span></label>
                    <input type="date" id="username" name="startdate" required style="margin-left: 43px;">
                </div>
                <div>
                    <label for="username">Ngày kết thúc <span style="color: red;">*</span></label>
                    <input type="date" id="username" name="enddate" required style="margin-left: 38px;">
                </div>
                <div class="file-upload-container">
                    <label for="file-upload" class="file-label">
                        Đính kèm <span class="required">*</span>
                    </label>
                    <div class="custom-file-upload">
                        <span class="file-text"></span>
                        <span class="upload-icon" style="padding-right: 10px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                          </svg></span> <!-- Biểu tượng kẹp giấy -->
                        <input type="file" id="file-upload" name="dinhkem" onchange="updateFileName()">
                    </div>
                </div>              
                <input type="submit" id="next_button" value="Tiếp theo">
                <input type="button" id="delete_null_btn" value="Xóa trống">
            </form>
        </div>
    </div>
    <script>
        let isSave=false;
        document.getElementById("next_button").addEventListener("click", function(e){
            const nextButton=document.getElementById("next_button");
            const deleteNullBtn=document.getElementById("delete_null_btn");
            if(!isSave){
                e.preventDefault();//ngăn gửi form
                const inputs= document.querySelectorAll("form input");
                inputs.forEach(function(input){
                    if(input.type!=="submit"&& input.type!=="button"){
                        input.style.backgroundColor="#CCCCCC";
                        input.setAttribute("readonly","true");
                    }
                })
                const selects=document.querySelectorAll("form select");
                selects.forEach(function(select){
                    select.style.backgroundColor="#CCCCCC";
                    select.setAttribute("disabled","true");
                })
                const textarea =document.querySelector("textarea");
                textarea.style.backgroundColor="#CCCCCC";
                textarea.setAttribute("readonly","true");
                // 🔹 Vô hiệu hóa ô tải file
                const fileUploadBox = document.querySelector(".custom-file-upload"); // Lấy div bọc input file
                const fileInput = document.getElementById("file-upload");
                fileUploadBox.style.backgroundColor = "#CCCCCC";
                fileUploadBox.style.pointerEvents = "none"; // Không cho click
                fileInput.setAttribute("disabled", "true");
                nextButton.value="Lưu lai";
                deleteNullBtn.value="Quay lại"
                isSave=true;
            }else{
                const selects=document.querySelectorAll("form select");
                selects.forEach(function(select){
                    select.style.backgroundColor="#FFFFFF";
                    select.removeAttribute("disabled");
                });
                const textarea =document.querySelector("textarea");
                textarea.style.backgroundColor="#FFFFFF";
                textarea.removeAttribute("readonly");
                const fileUploadBox = document.querySelector(".custom-file-upload"); // Lấy div bọc input file
                const fileInput = document.getElementById("file-upload");
                fileUploadBox.style.backgroundColor = "#FFFFFF";
                fileUploadBox.style.pointerEvents = "auto"; // Cho click
                fileInput.removeAttribute("disabled");
                //cho gửi form nếu nhấn lần 1 bào button id=next_button
                document.querySelector("form").submit();
            }
        })
        document.getElementById("delete_null_btn").addEventListener("click", function(e){
            const nextButton=document.getElementById("next_button");
            const deleteNullBtn=document.getElementById("delete_null_btn");
            if(isSave){
                const inputs=document.querySelectorAll("form input");
                inputs.forEach(function(input){
                    if(input.type!=="submit"&& input.type!=="button"){
                        input.style.backgroundColor="#FFFFFF";
                        input.removeAttribute("readonly");
                    }
                });
                const selects=document.querySelectorAll("form select");
                selects.forEach(function(select){
                    select.style.backgroundColor="#FFFFFF";
                    select.removeAttribute("disabled");
                });
                const textarea =document.querySelector("textarea");
                textarea.style.backgroundColor="#FFFFFF";
                textarea.removeAttribute("readonly");
                const fileUploadBox = document.querySelector(".custom-file-upload"); // Lấy div bọc input file
                const fileInput = document.getElementById("file-upload");
                fileUploadBox.style.backgroundColor = "#FFFFFF";
                fileUploadBox.style.pointerEvents = "auto"; // Cho click
                fileInput.removeAttribute("disabled");
                nextButton.value="Tiếp theo";
                deleteNullBtn.value="Xóa trắng";
                isSave=false;
            }else{
                //load lại trang 
                location.reload();
            }
        })
        function updateFileName() {
            const input = document.getElementById("file-upload");
            const fileName = input.files.length > 0 ? input.files[0].name : "";
            document.querySelector(".file-text").textContent = fileName;
        }

    </script>
</body>
</html>