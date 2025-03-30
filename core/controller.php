<?php
class Controller {
    // Tải model
    protected function model($model) {
        require_once APPROOT . '/app/models/' . $model . '.php';
        return new $model();
    }

    // Tải view
    protected function view($view, $data = []) {
        if (file_exists(APPROOT . '/app/views/' . $view . '.php')) {
            require_once APPROOT . '/app/views/' . $view . '.php';
        } else {
            die('View không tồn tại');
        }
    }
}