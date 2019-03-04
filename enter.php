<?php
require_once('init.php');
require_once('functions.php');

if (!$link) {
    $error = mysqli_connect_error();
    show_error($page_content, $error);
}
else {
    $sql = 'SELECT `id`, `name` FROM categories';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        show_error($page_content, $error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;

        $required = ['email', 'password'];
        $errors = [];
        foreach ($required as $field) {
            if (empty($form[$field])) {
                $errors[$field] = 'Это поле надо заполнить';
            }
        }