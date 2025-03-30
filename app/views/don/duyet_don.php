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
            <p>Duyệt đơn</p>
            <form action="<?php echo URLROOT ?>/don/duyetdon" method="post">
                <input type="hidden" value="<?php echo $data["don"]->id ?>" name="donid">
                <input type="hidden" value="<?php echo $data["don"]->userid ?>" name="userid">
                <div>
                    <label for="username">Tiêu đề <span style="color: red;">*</span></label>
                    <input type="text" id="username" name="title" value="<?php echo $data["don"]->title ?>" required style="margin-left: 84px;background-color: #CCCCCC;" readonly>
                </div>
                <div style="display: flex; align-items: flex-start;">
                    <label for="username" style="top: 0;">Nội dung </label>
                    <textarea name="noidung" id="" style="height: 94px; width: 480px; margin-left: 86px;border-radius: 4px;background-color: #CCCCCC;" readonly><?php echo $data["don"]->title ?></textarea>
                </div>
                <div>
                    <label for="username">Loại đơn <span style="color: red;">*</span></label>
                    <input type="text" name="loaidon" value="<?php echo $data["don"]->loaidon ?>" style="margin-left: 73px;background-color: #CCCCCC;width: 240px;">
    
                </div>
                <div>
                    <label for="username">Ngày bắt đầu <span style="color: red;">*</span></label>
                    <input type="text" id="username" value="<?php echo $data["don"]->startdate ?>" name="datestart" required style="margin-left: 43px;width: 189px;background-color: #CCCCCC;" readonly>
                </div>
                <div>
                    <label for="username">Ngày kết thúc <span style="color: red;">*</span></label>
                    <input type="text" id="username" value="<?php echo $data["don"]->enddate ?>" name="dateend" required style="margin-left: 38px;width: 189px;background-color: #CCCCCC;" readonly>
                </div>
                <div class="file-upload-container">
                    <label for="file-upload" class="file-label">
                        Đính kèm <span class="required">*</span>
                    </label>
                    <div class="custom-file-upload" style="border: none;">
                        <span style="color: #00AAFF;" id="showAnh"><?php echo $data["don"]->dinhkem ?></span>
                    </div>
                </div>              
                <input type="submit" id="next_button" value="Duyệt đơn">
                <input type="button" id="huy_btn" value="Hủy đơn">
            </form>
        </div>
    </div>
    <!--Viết Modal-->
    <div class="bomodal" id="boAnh">
        <div class="modal" style="height: 60%;">
            <div class="dau">
                <p> </p>
                <span class="close" id="closeAnh">&times;</span>
            </div>
            <img src="<?php echo URLROOT ?>/image/<?php echo  $data["don"]->dinhkem ?>" alt="" style="width: 100%;height: 100%;">
        </div>
    </div>
    <div class="bomodal" id="bomodal">
        <div class="modal">
            <div class="dau">
                <p>Thông báo </p>
                <span class="close" id="closeModal">&times;</span>
            </div>
            <form action="<?php echo URLROOT ?>/don/huydon" method="post" style="margin-left: 37px; margin-top: 5%;">
                <input type="hidden" value="<?php echo $data["don"]->id ?>" name="donid">
                <input type="hidden" value="<?php echo $data["don"]->userid ?>" name="userid">
                <input type="hidden" value="<?php echo $data["don"]->title ?>" name="title">
                <input type="hidden" value="<?php echo $data["don"]->loaidon ?>" name="loaidon">
                <div>
                    <label for="">Lý do hủy đơn</label>
                    <input type="text" name="lydohuy" style="height: 76px; width: 540px;font-size:20px;margin-top: 1%; border-radius: 4px;">
                </div>
                <div class="button" style="margin-top: 2%; margin-left: 25%;">
                    <input type="submit" class="btn_ok" value=" Ok" style="font-size: 16px;height: 50px;width: 220px;border: none;color: #CCCCCC;border-radius: 4px;">
                </div>
            </form>
        </div>
    </div>
    <script>
        const boAnh =document.getElementById("boAnh");
        const bomodal =document.getElementById("bomodal");
        const closeAnh =document.getElementById("closeAnh");
        const closeModal =document.getElementById("closeModal");
        document.getElementById("showAnh").addEventListener("click",function(e){
            boAnh.style.display="flex";
            closeAnh.addEventListener("click",function(e){
                boAnh.style.display="none";
            });
        })
        document.getElementById("huy_btn").addEventListener("click",function(e){
            bomodal.style.display="flex";
            closeModal.addEventListener("click",function(e){
                bomodal.style.display="none";
            });
        })
    </script>
</body>
</html>