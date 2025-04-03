<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/formlogin.css">
</head>
<body>
    <header>
        <h1>Shansin</h1>
        <p>Hệ thống quản lý đơn</p>
    </header>
    <div class="formlogin">
        <h1>Sanshin IT Solution</h1>
        <form action="<?php echo URLROOT; ?>/home/login" method="post">
            <div class="input_form">
                <label for="">Tên đăng nhập <span style="color: red;">*</span></label>
                
                <input type="text" id="username" name="loginname" placeholder="Tên đăng nhập" required>
            </div>
            <div class="input_form">
                <label for="" style="margin-left: 7.5%;">Mật khẩu <span style="color: red;">*</span></label>
                <input type="password" id="username" name="password" placeholder="Mật khẩu" required >
            </div>
            <div style="height: 60px;">
                <input type="submit" value="Login">
                <input type="button" id="btn_cleare" value="Clear">
            </div>
        </form>
        <span style="color: #F90A0A; margin-left: 153px;font-size: 14px"><?php echo isset($data['msg'])?$data['msg']:""; ?></span>
    </div>
    <script>
        document.getElementById("btn_cleare").addEventListener("click",function(e){
            location.reload();
        })
    </script>

</body>
</html>