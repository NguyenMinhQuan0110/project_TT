<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/insertform.css">
</head>
<body>
    <div class="bomodal" id="bomodal" style="display: flex;">
        <div class="modal">
            <div class="dau">
                <p>Thông báo </p>
                <span class="close" id="closeModal">&times;</span>
            </div>
            <p style="font-size: 18px;width: 90%;">Bạn có chắn chắn muốn duyệt mà không càn xem lý nội dung đơn chứ ?</p>
            <form action="<?php echo URLROOT ?>/don/duyetdon" method="post" style="margin-left: 37px; margin-top: 5%;">
                <input type="hidden" value="<?php echo $data["don"]->id ?>" name="donid">
                <input type="hidden" value="<?php echo $data["don"]->userid ?>" name="userid">
                <input type="hidden" value="<?php echo $data["don"]->title ?>" name="title">
                <input type="hidden" value="<?php echo $data["don"]->loaidon ?>" name="loaidon">
                <div class="button" style="margin-top: 2%; margin-left: 6%; display: flex;">
                    <input type="submit" class="btn_ok" value=" Ok" style="font-size: 16px;height: 50px;width: 220px;border: none;color: #CCCCCC;border-radius: 4px;">
                    <button type="button" class="btn_cancel" id="btn_cancel" style="border-radius: 4px;">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById("closeModal").addEventListener("click",function(e){
            window.history.back();
        })
        document.getElementById("btn_cancel").addEventListener("click",function(e){
            window.history.back();
        })
    </script>
</body>
</html>