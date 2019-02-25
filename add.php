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

    $page_content = include_template('add.php', ['categories' => $categories]);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $announce = $_POST['announce'];

        $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
        $dict = ['lot-name' => 'Наименование лота', 'category' => 'Категория', 'message' => 'Описание', 'lot-rate' => 'Начальная цена', 'lot-step' => 'Шаг ставки', 'lot-date' => 'Дата завершения лота'];
        $errors = [];
        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        if (isset($_FILES['announce_img']['name'])) {
            $tmp_name = $_FILES['announce_img']['tmp_name'];
            $picture_link = $_FILES['announce_img']['name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);
            if ($file_type !== "image/jpg") {
                $errors['file'] = 'Загрузите картинку в формате JPG';
            }
            else {
                $filename = uniqid() . '.jpg';
                $announce['picture_link'] = $filename;
                move_uploaded_file($tmp_name, 'img/' . $filename);
            }
        }
        else {
            $errors['file'] = 'Вы не загрузили файл';
        }

        if (count($errors)) {
            $page_content = include_template('add.php', ['announce' => $announce, 'errors' => $errors, 'dict' => $dict]);
        }
        else {
            $page_content = include_template('lot.php', ['announce' => $announce]);
        }

?>