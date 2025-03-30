<?php
class App {
    protected $controller = 'HomeController'; 
    protected $method = 'showFormlogin';      
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        if (empty($url)) {
            require_once APPROOT . '/app/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller();
            call_user_func_array([$this->controller, $this->method], $this->params);
            return;
        }

        // Xử lý controller
        if (isset($url[0]) && file_exists(APPROOT . '/app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        } else {
            // Nếu controller không tồn tại, chuyển về HomeController và method page404
            $this->controller = 'HomeController';
            $this->method = 'page404';
            $this->params = [];
            require_once APPROOT . '/app/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller();
            call_user_func_array([$this->controller, $this->method], $this->params);
            return;
        }

        // Load controller file và khởi tạo instance
        require_once APPROOT . '/app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller();

        // Xử lý method
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        } else if (isset($url[1])) {
            // Nếu method không tồn tại trong controller đã tồn tại, chuyển về page404
            $this->method = 'page404';
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