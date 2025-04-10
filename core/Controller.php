<?php
class Controller {
    protected $config;

    public function render() {
        $this->view('layout', $this->config);
    }

    public function view($view, $data = []) {
        require_once "view/$view.php";
    }

    public function model($model) {
        require_once "model/$model.php";
        return new $model;
    }
}
