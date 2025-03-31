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
    document.getElementById("closeModal").addEventListener("click",function(e){
        window.history.back();
    })
</script>
</body>
</html>