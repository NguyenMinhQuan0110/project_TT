<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Users </title>
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
                <li class="dashboard"><a href="<?php echo URLROOT ?>/home/formlistuser">Quản lý người dùng</a></li>
                <li><a href="<?php echo URLROOT ?>/don/index">Quản lý đơn</a></li>
                <li><a href="<?php echo URLROOT ?>/home/logout">Đăng xuất</a></li>
            </ul>
        </div>
        <div class="main">
            <span style="color: red; font-size: 30px;" ><?php isset($data["err"])?$data["err"]:""; ?></span>
            <p>Thêm người dùng</p>
            <form action="<?php echo URLROOT ?>/home/updateUser" method="post">
                <input type="hidden" name="id" value="<?php echo $data["user"]->id ?>">
                <div>
                    <label for="username">Tên đăng nhập <span style="color: red;">*</span></label>
                    <input type="text"  name="loginname" required style="margin-left: 33px;background-color:#CCCCCC ;"value="<?php echo $data["user"]->loginname ?>" readonly>
                </div>
                <div>
                    <label for="username">Tên người dùng <span style="color: red;">*</span></label>
                    <input type="text" id="username" name="username" value="<?php echo $data["user"]->username ?>" required style="margin-left: 29px;">
                </div>
                <div>
                    <label for="username">Mật khẩu <span style="color: red;">*</span></label>
                    <input type="password" id="password" name="password" required style="margin-left: 68px;">
                </div>
                <div>
                    <label for="username">Email </label>
                    <input type="email" id="username" name="email" value="<?php echo $data["user"]->email ?>" required style="margin-left: 100px;">
                </div>
                <div>
                    <label for="username">Ngày sinh </label>
                    <input type="date" id="username" name="birthday" value="<?php echo $data["user"]->birthday ?>" required style="margin-left: 72px;">
                </div>
                <div>
                    <label for="username">Loại người dung <span style="color: red;">*</span></label>
                    <select id="cars" style="margin-left: 19px;" name="loaiuser">
                        <option value="<?php echo $data["user"]->loaiuser ?>"><?php echo $data["user"]->loaiuser ?></option>
                        <option value="quản lý">quản lý</option>
                        <option value="người dùng">người dùng</option>
                      </select>
                </div>
                <div>
                    <label for="username">Phòng ban <span style="color: red;">*</span></label>
                    <select id="cars" style="margin-left: 53px;" name="phongban">
                        <option value="<?php echo $data["user"]->phongban ?>"><?php echo $data["user"]->phongban ?></option>
                        <option value="Kĩ thuật">Kĩ thuật</option>
                        <option value="Nhân sự">Nhân sự</option>
                        <option value="Kế toán">Kế toán</option>
                        <option value="Kế hoạch">Kế hoạch</option>   
                      </select>
                </div>
                <div>
                    <label for="username">Khóa tài khoản</label>
                    <input type="checkbox" style="width: 100px;" name="trangthai" <?php if($data["user"]->trangthai=="Đã khóa"){echo "checked";} ?>>
                </div>
                <input type="submit" id="next_button" value="Tiếp theo">
                <input type="button" id="delete_null_btn" value="Xóa trống">
            </form>
        </div>
    </div>
    <!--Viết Modal-->
    <div class="bomodal" id="bomodal">
        <div class="modal">
            <div class="dau">
                <p>Thông báo </p>
                <span class="close" id="closeModal">&times;</span>
            </div>
            <p>Bạn có chắn chắn muốn lưu lại thay đổi không?</p>
            <div class="button">
                <button class="btn_ok" id="btn_ok">Ok</button>
                <button class="btn_cancel" id="btn_cancel">Cancel</button>
            </div>
        </div>
    </div>
    <script>
        let isSave=false;
        const bomodal =document.getElementById("bomodal");
        const closeModal =document.getElementById("closeModal");
        const btn_ok=document.getElementById("btn_ok");
        const btn_cancel=document.getElementById("btn_cancel");
        function hienModal(){
            bomodal.style.display="flex";
        }
        function anModal(){
            bomodal.style.display="none";
        }

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
                nextButton.value="Lưu lai";
                deleteNullBtn.value="Quay lại"
                isSave=true;
            }else{
                //Ngăn gửi form ngay lập tức
                e.preventDefault();
                const selects=document.querySelectorAll("form select");
                selects.forEach(function(select){
                    select.removeAttribute("disabled");
                });
                //Hiển thị Modal
                hienModal();

            }
        })
        //Xử lý khi nhấn nút trong modal
        //Khi ấn nút có
        document.getElementById("btn_ok").addEventListener("click",function(e){
            anModal();
            document.querySelector("form").submit();
        })
        //Khi nhấn dấu X
        closeModal.addEventListener("click",anModal);
        //Khi nhấn nút cancel
        btn_cancel.addEventListener("click",anModal);
        document.getElementById("delete_null_btn").addEventListener("click", function(e){
            const nextButton=document.getElementById("next_button");
            const deleteNullBtn=document.getElementById("delete_null_btn");
            if(isSave){
                const inputs=document.querySelectorAll("form input:not([name='namelogin'])");
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
                nextButton.value="Tiếp theo";
                deleteNullBtn.value="Xóa trắng";
                isSave=false;
            }else{
                //load lại trang 
                location.reload();
            }
        })
    </script>
    
</body>
</html>