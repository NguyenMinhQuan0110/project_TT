<?php
class App {
    protected $controller = 'Home';
    protected $method = 'showFormlogin';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Xử lý controller
        if (isset($url[0]) && file_exists(APPROOT .'/app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {//hàm $url[0] để viết hoa chữ cái đầu của chuỗi
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        } else {
            $this->controller = 'HomeController';
        }

        // Thay đổi đường dẫn require_once để phù hợp
        require_once APPROOT . '/app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller();

        // Xử lý method
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Xử lý params
        $this->params = $url ? array_values($url) : [];

        // Gọi method với các tham số
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}