<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Users </title>
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
            <p>Thêm người dùng</p>
            <span style="font-size: 30px;color: #F90A0A;"><?php echo isset($data['error'])?$data['error']:""; ?></span>
            <form action="<?php echo URLROOT ?>/home/insert" method="post">
                <div>
                    <label for="username">Tên đăng nhập <span style="color: red;">*</span></label>
                    <input type="text" id="loginname" name="loginname"  style="margin-left: 33px;">
                    <span class="error" id="loginnameError" style="font-size: 14px;color: #F90A0A;margin-left: 22%;display: none; margin-top: 18px;">※Tên đăng nhập không được để trống</span>
                </div>
                <div>
                    <label for="username">Tên người dùng <span style="color: red;">*</span></label>
                    <input type="text" id="username" name="username"  style="margin-left: 29px;">
                    <span class="error" id="usernameError" style="font-size: 14px;color: #F90A0A;margin-left: 22%;display: none; margin-top: 18px;">※Tên người dùng không được để trống</span>
                </div>
                <div>
                    <label for="username">Mật khẩu <span style="color: red;">*</span></label>
                    <input type="password" id="password" name="password"  style="margin-left: 68px;">
                    <span class="error" id="passwordError" style="font-size: 14px;color: #F90A0A;margin-left: 22%;display: none; margin-top: 18px;">※Mật khẩu có 8 ký tự bao gồm ký tự chữ, số, đặc biệt</span>
                </div>
                <div>
                    <label for="username">Email </label>
                    <input type="email" id="username" name="email"  style="margin-left: 100px;">
                </div>
                <div>
                    <label for="username">Ngày sinh </label>
                    <input type="date" id="username" name="birthday"  style="margin-left: 72px;">
                </div>
                <div>
                    <label for="username">Loại người dung <span style="color: red;">*</span></label>
                    <select id="loaiuser" style="margin-left: 19px;" name="loaiuser">
                        <option value=""></option>
                        <option value="quản lý">quản lý</option>
                        <option value="người dùng">người dùng</option>
                  </select>
                  <span class="error" id="loaiuserError" style="font-size: 14px;color: #F90A0A;margin-left: 22%;display: none; margin-top: 18px;">※Bạn phải chọn loại user</span>
                </div>
                <div>
                    <label for="username">Phòng ban <span style="color: red;">*</span></label>
                    <select id="phongban" style="margin-left: 53px;" name="phongban">
                        <option value=""></option>
                        <option value="Kĩ thuật">Kĩ thuật</option>
                        <option value="Nhân sự">Nhân sự</option>
                        <option value="Kế toán">Kế toán</option>  
                        <option value="Kế hoạch">Kế hoạch</option> 
                      </select>
                      <span class="error" id="phongbanError" style="font-size: 14px;color: #F90A0A;margin-left: 22%;display: none; margin-top: 18px;">※Bạn phải chọn phong ban cho user</span>
                </div>
                <input type="submit" id="next_button" value="Tiếp theo">
                <input type="button" id="delete_null_btn" value="Xóa trống">
            </form>
        </div>
    </div>
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
                const loginname=document.getElementById("loginname").value;
                if(loginname==""){
                    document.getElementById("loginnameError").style.display="flex";
                    document.getElementById("loginname").style.border="1px solid red";
                    return;
                }else{
                    document.getElementById("loginnameError").style.display="none";
                    document.getElementById("loginname").style.border="1px solid";
                }
                const username=document.getElementById("username").value;
                if(username==""){
                    document.getElementById("usernameError").style.display="flex";
                    document.getElementById("username").style.border="1px solid red";
                    return;
                }else{
                    document.getElementById("usernameError").style.display="none";
                    document.getElementById("username").style.border="1px solid";
                }
                const password=document.getElementById("password").value;
                let regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                if(!regex.test(password)){
                    document.getElementById("passwordError").style.display="flex";
                    document.getElementById("password").style.border="1px solid red";
                    return;
                }else{
                    document.getElementById("passwordError").style.display="none";
                    document.getElementById("password").style.border="1px solid";
                }
                const loaiuser=document.getElementById("loaiuser").value;
                if(loaiuser==""){
                    document.getElementById("loaiuserError").style.display="flex";
                    document.getElementById("loaiuser").style.border="1px solid red";
                    return;
                }else{
                    document.getElementById("loaiuserError").style.display="none";
                    document.getElementById("loaiuser").style.border="1px solid";
                }
                const phongban=document.getElementById("phongban").value;
                if(phongban==""){
                    document.getElementById("phongbanError").style.display="flex";
                    document.getElementById("phongban").style.border="1px solid red";
                    return;
                }else{
                    document.getElementById("phongbanError").style.display="none";
                    document.getElementById("phongban").style.border="1px solid";
                }
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
                const selects=document.querySelectorAll("form select");
                selects.forEach(function(select){
                    select.removeAttribute("disabled");
                });
                e.preventDefault();
                //Hiển thị Modal
                hienModal();
            }
        })
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