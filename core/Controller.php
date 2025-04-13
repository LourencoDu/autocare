<?php
class Controller {
    protected $config;

    public function render() {
        $data = $this->config;
        extract($data);
        require_once 'view/layout.php';
    }

    public function model($model) {
        require_once "model/$model.php";
        return new $model;
    }
}
