<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class DonController extends Controller{
    private $donModel;
    private $userModel;

    public function __construct()
    {
        $this->donModel=$this->model("Don");
        $this->userModel=$this->model("User");
    }

    public function index(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        $limit=5;
        $page=isset($_GET["page"])?$_GET["page"]:1;
        $offset=($page - 1) * $limit;
        $tottalDon=$this->donModel->getTotalAllDon();
        $totalPages = ceil($tottalDon / $limit);
        $dons=$this->donModel->getAllDon($limit,$offset);
        $data=[
            "tottalDon"=>$tottalDon,
            "dons" => $dons,
            "currentPage" => $page,
            "totalPages" => $totalPages,
            "limit"=>$limit
        ];
        $this->view("don/index",$data);
    }
    public function showForminsert(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        $loaiuser="quản lý";
        $phongban=$_SESSION["phong_ban"];
        $nguoiduyet=$this->donModel->getUserByLoaiUserAndPhongBan($loaiuser,$phongban);
        if($nguoiduyet){
            $data=[
                "nguoiduyet"=>$nguoiduyet,
            ];
            $this->view("don/insert",$data);
        }
    }
    public function insert(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        $userid=$_POST["userid"];
        $title=$_POST["title"];
        $noidung=$_POST["noidung"];
        $nguoiduyet=$_POST["nguoiduyet"];
        $loaidon=$_POST["loaidon"];
        $startdate=$_POST["startdate"];
        $enddate=$_POST["enddate"];
        $trangthai="chưa duyệt";
        $dinhkem=time()."_". basename($_FILES["dinhkem"]["name"]);
        $target_dir = "image/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa tồn tại
        }

        $target_path = $target_dir . $dinhkem;

        if ($title && $noidung && $nguoiduyet && $loaidon && $startdate && $enddate && $dinhkem) {
            move_uploaded_file($_FILES["dinhkem"]["tmp_name"], $target_path);
            $this->donModel->insertDon($title, $noidung, $nguoiduyet, $loaidon, $startdate, $enddate, $dinhkem,$trangthai,$userid);
            $_SESSION["message"] = "Thêm mới đơn thành công!";
            $nguoiduyetInfo= $this->userModel->getUserById($nguoiduyet);
            if ($nguoiduyetInfo) {
                $this->sendEmailNotification($nguoiduyetInfo->email, $title, $loaidon, $_SESSION["user_name"],"Bạn có một đơn càn duyệt","","Vui lòng kiểm tra hệ thống để xử lý.");
            }
            header("Location: " . URLROOT . "/don/index");
            exit();
        } else {
            $data = ["error" => "Yêu cầu bạn điền đầy đủ các mục!"];
            $this->view("don/insert", $data);
        }
    }
    public function getDonById($id){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        $don=$this->donModel->getDonById($id);
        $data=[
            "don"=>$don
        ];
        $this->view("don/duyet_don",$data);
    }
    public function duyetdon(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        $donid=$_POST["donid"];
        $userid=$_POST["userid"];
        $title=$_POST["title"];
        $loaidon=$_POST["loaidon"];
        $trangthai="đã duyệt";
        $ngayduyet=date("Y-m-d");
        $donduyet=$this->donModel->duyetdon($trangthai,$donid,$ngayduyet);
        if(!$donduyet){
            $data = ["error" => "Duyệt đơn thất bại!"];
            $this->view("don/duyet_don", $data);
        }
        $nguoitao=$this->userModel->getUserById($userid);
        if ($nguoitao) {
            $this->sendEmailNotification($nguoitao->email, $title, $loaidon, $_SESSION["user_name"],"<strong>Đơn của bạn đã được duyệt</strong>","","");
        }
        $_SESSION["message"] = "Duyệt đơn thành công!";

        header("Location: " . URLROOT . "/don/index");
        exit();
    }
    public function huydon(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        $donid=$_POST["donid"];
        $userid=$_POST["userid"];
        $title=$_POST["title"];
        $loaidon=$_POST["loaidon"];
        $lydohuy=$_POST["lydohuy"];
        $trangthai="đã hủy";
        $ngayduyet=date("Y-m-d");
        $donduyet=$this->donModel->duyetdon($trangthai,$donid,$ngayduyet);
        if(!$donduyet){
            $data = ["error" => "Duyệt đơn thất bại!"];
            $this->view("don/duyet_don", $data);
        }
        $nguoitao=$this->userModel->getUserById($userid);
        if ($nguoitao) {
            $this->sendEmailNotification($nguoitao->email, $title, $loaidon, $_SESSION["user_name"],"<strong>Đơn của bạn đã bị hủy</strong>",$lydohuy,"");
        }
        $_SESSION["message"] = "Hủy đơn thành công!";

        header("Location: " . URLROOT . "/don/index");
        exit();
    }
    private function sendEmailNotification($email, $tieude, $loaidon,$nguoitao,$noidung,$lydohuy,$nhacnguoiduyet) {
        $mail = new PHPMailer(true);
        
        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Thay đổi nếu dùng dịch vụ khác
            $mail->SMTPAuth = true;
            $mail->Username = 'minhquan11003@gmail.com'; // Email của bạn
            $mail->Password = 'kmkq wjlw bgil bsep'; // Mật khẩu ứng dụng (App Password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Thiết lập mã hóa UTF-8
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64'; // Đảm bảo encode đúng các ký tự

        
            // Cấu hình thông tin gửi
            $mail->setFrom('minhquan11003@gmail.com', 'Hệ thống quản lý đơn');
            $mail->addAddress($email); // Gửi đến email của người duyệt
        
            // Nội dung Email
            $mail->isHTML(true);
            $mail->Subject = 'Sanshin';
            // Xây dựng nội dung Body động
            $body = "<p>Xin chào,</p>";
            if (!empty($noidung)) {
                $body .= "<p>$noidung.</p>";
            }
            if (!empty($lydohuy)) {
                $body .= "<p><strong>Lý do:</strong> $lydohuy.</p>";
            }
            $body .= "
                <p><strong>Người gửi:</strong> $nguoitao</p>
                <p><strong>Tiêu đề:</strong> $tieude</p>
                <p><strong>Loại đơn:</strong> $loaidon</p>
            ";
            if (!empty($nhacnguoiduyet)) {
                $body .= "<p>$nhacnguoiduyet</p>";
            }
            $body .= "
                <p>Trân trọng,</p>
                <p>Hệ thống quản lý đơn</p>
            ";

            $mail->Body = $body;
        
            // Gửi email
            $mail->send();
        } catch (Exception $e) {
            error_log("Không thể gửi email: {$mail->ErrorInfo}");
        }
    }
           
}