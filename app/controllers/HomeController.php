<?php
class HomeController extends Controller {
    private $userModel;
    private $donModel;

    public function __construct() {
        $this->userModel = $this->model('User');
        $this->donModel=$this->model("Don");
    }

    public function showFormlogin(){
        $this->view("/login");
    }
    public function login(){
            $loginname=$_POST["loginname"];
            $password=md5($_POST["password"]);

            $userlogin= $this->userModel->getUserByLoginNameAndPassword($loginname,$password);
            if($userlogin){
                if ($userlogin->trangthai != "Đã khóa") {
                    $_SESSION["user_name"] = $userlogin->username;
                    $_SESSION["loai_user"] = $userlogin->loaiuser;
                    $_SESSION["phong_ban"] = $userlogin->phongban;
                    $_SESSION["user_id"] = $userlogin->id;
                    header("Location: " . URLROOT . "/home/index");
                    exit();
                } else {
                    $data = ['msg' => '※Người dùng này đã bị khóa'];
                    $this->view("/login", $data);
                }
            }else{
                $data=['msg'=>'※Tên đăng nhập hoặc mật khẩu lỗi. Vui lòng thử lại'];
                $this->view("/login",$data);
            }
    }
    public function logout(){
        session_destroy();
        header("Location: " . URLROOT . "/home/showFormlogin");
        exit();
    }
    public function index() {
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        $dons=$this->donModel->get30Don();
        $data=[
            "dons"=> $dons
        ];
        $this->view('home/index',$data);
    }
    public function formlistuser(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        // Số lượng người dùng trên mỗi trang
        $limit = 5; // Bạn có thể thay đổi số này
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Lấy số trang từ query string, mặc định là 1
        $offset = ($page - 1) * $limit; // Tính vị trí bắt đầu

        // Lấy tổng số người dùng
        $totalUsers = $this->userModel->getTotalAllUser(); // Cần thêm phương thức này trong model
        $totalPages = ceil($totalUsers / $limit); // Tính tổng số trang

        // Lấy danh sách người dùng theo trang
        $users = $this->userModel->getAllUser($limit, $offset); // Cần thêm phương thức này trong model

        $data = [
            "totalUsers"=>$totalUsers,
            "users" => $users,
            "currentPage" => $page,
            "totalPages" => $totalPages
        ];

        $this->view('home/listuser', $data);
    }
    public function showforminsertuser(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        if($_SESSION["loai_user"]=="người dùng"){
            $_SESSION["message"] = "Mày đéo có quyền!";
            header("Location: " . URLROOT . "/home/index");
            exit();
        }
        $this->view("home/insertuser");
    }
    public function insert(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        if($_SESSION["loai_user"]=="người dùng"){
            $_SESSION["message"] = "Mày đéo có quyền!";
            header("Location: " . URLROOT . "/home/index");
            exit();
        }
        $loginname=$_POST["loginname"];
        $username=$_POST["username"];
        $password=md5($_POST["password"]);
        $email=$_POST["email"];
        $birthday=$_POST["birthday"];
        $loaiuser=$_POST["loaiuser"];
        $phongban=$_POST["phongban"];
        $trangthai="Đang hoạt động";
        if($password && $username && $loginname && $email && $birthday && $loaiuser && $phongban){
            $newuser= $this->userModel->insert($loginname,$username,$password,$email,$birthday,$loaiuser,$phongban,$trangthai);
            if($newuser){
                $_SESSION["message"] = "Thêm mới thành công người dùng!";
                header("Location: " . URLROOT . "/home/formlistuser");
                exit();
            }
        }else{
            $data=["error"=>"thêm người dùng thất lại"];
            $this->view("home/insertuser",$data);
        }

    }
    public function getUserById($id){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        if($_SESSION["loai_user"]=="người dùng"){
            $_SESSION["message"] = "Bạn không có quyền!";
            header("Location: " . URLROOT . "/home/index");
            exit();
        }
        $getUserById= $this->userModel->getUserById($id);
        if($getUserById){
            $data=["user"=>$getUserById];
            $this->view("home/updateuser",$data);
        }
    }
    public function updateUser(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        if($_SESSION["loai_user"]=="người dùng"){
            $_SESSION["message"] = "Bạn không có quyền!";
            header("Location: " . URLROOT . "/home/index");
            exit();
        }
        $id=$_POST["id"];
        $loginname=$_POST["loginname"];
        $username=$_POST["username"];
        if($_POST["password"]){
            $password=md5($_POST["password"]);
        }else{
            $user=$this->userModel->getUserById($id);
            $password=$user->password;
        }
        $email=$_POST["email"];
        $birthday=$_POST["birthday"];
        $loaiuser=$_POST["loaiuser"];
        $phongban=$_POST["phongban"];
        if(isset($_POST["trangthai"])){
            $trangthai="Đã khóa";
        }else{
            $trangthai="Đang hoạt động";
        }
        if($password && $username && $loginname && $email && $birthday && $loaiuser && $phongban && $id){
            $nguoidung=$this->userModel->getUserById($id);
            if($_SESSION["loai_user"]!="admin"){
                if($_SESSION["loai_user"]==$nguoidung->loaiuser || $_SESSION["phong_ban"]!=$nguoidung->phongban){
                    $_SESSION["message"] = "Bạn không có quyền!";
                    header("Location: " . URLROOT . "/home/index");
                    exit();
                }
            }
            $updateUser=$this->userModel->updateUser($id,$loginname,$username,$password,$email,$loaiuser,$phongban,$birthday,$trangthai);
            if($updateUser){
                $_SESSION["message"] = "Sửa thành công người dùng!";
                header("Location: " . URLROOT . "/home/formlistuser");
                exit();
            }else{
                $data=[
                    "err"=>"Sửa thất bại"
                ];
                $this->view("home/updateuser",$data);
            }
        }
    }
    public function deleteUserById($id){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        if($_SESSION["loai_user"]=="người dùng"){
            $_SESSION["message"] = "Bạn không có quyền!";
            header("Location: " . URLROOT . "/home/index");
            exit();
        }
        $deleteUser=$this->userModel->deleteUserById($id);
        if($deleteUser){
            $_SESSION["message"] = "Xóa thành công người dùng!";
            header("Location: " . URLROOT . "/home/formlistuser");
            exit();
        }
    }
    public function seachUser(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        $keyword = $_GET["keyword"];
        $limit = 5; // Số lượng người dùng trên mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Lấy số trang từ query string
        $offset = ($page - 1) * $limit; // Tính vị trí bắt đầu

        if ($keyword) {
            $users = $this->userModel->seachUser($keyword, $limit, $offset); // Cần thêm phương thức này trong model
            $totalUsers = $this->userModel->getTotalSearchUser($keyword); // Cần thêm phương thức này trong model
            $totalPages = ceil($totalUsers / $limit);

            $data = [
                "users" => $users,
                "currentPage" => $page,
                "totalPages" => $totalPages,
                "keyword" => $keyword // Để giữ từ khóa tìm kiếm
            ];
            $this->view("home/listuser", $data);
        } else {
            header("Location: " . URLROOT . "/home/formlistuser");
            exit();
        }
    }
    public function deleteMultipleUser(){
        if(!isset($_SESSION["user_name"])){
            header("Location: " . URLROOT . "/home/showFormlogin");
            exit();
        }
        if($_SESSION["loai_user"]=="người dùng"){
            $_SESSION["message"] = "Bạn không có quyền!";
            header("Location: " . URLROOT . "/home/index");
            exit();
        }
        $id=json_decode($_POST["ids"]);//chuyển chuỗi thành mảng
        if($id){
            foreach($id as $i){
                $this->userModel->deleteUserById($i);
            }
            $_SESSION["message"] = "Xóa thành công người dùng!";
            header("Location: " . URLROOT . "/home/formlistuser");
            exit();
        }
    }
    public function page404(){
        $this->view("/manhinhloi");
    }
}