<?php
require_once('init.php');
require_once('functions.php');

if (!isset($_SESSION['user'])) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}

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
        $announce = $_POST;

        $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
        $dict = ['lot-name' => 'Наименование лота', 'category' => 'Категория', 'message' => 'Описание', 'lot-rate' => 'Начальная цена', 'lot-step' => 'Шаг ставки', 'lot-date' => 'Дата завершения лота'];
        $errors = [];
        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        if (!preg_match('/^\d+$/', $_POST['lot-rate'])) {
            $errors['lot-rate'] = 'Поле должно содержать только цифры';
        }

        if (!preg_match('/^\d+$/', $_POST['lot-step'])) {
            $errors['lot-step'] = 'Поле должно содержать только цифры';
        }

        if (!check_date_format($_POST['lot-date'])) {
            $errors['lot-date'] = 'Введите правильно дату';
        }

        if (isset($_FILES['announce_img']['name'])) {
            $tmp_name = $_FILES['announce_img']['tmp_name'];
            $picture_link = $_FILES['announce_img']['name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);
            if ($file_type !== "image/jpg" && $file_type !== "image/jpeg") {
                $errors['file'] = 'Загрузите картинку в формате JPG или JPEG';
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
            $page_content = include_template('add.php', ['announce' => $announce, 'categories' => $categories, 'errors' => $errors, 'dict' => $dict]);
        }
        else {
            $sql = 'INSERT INTO lots (category_id, author_id, date_creation, name, description, initial_price, completion_date, step_rate, picture_link) VALUES (?, 1, NOW(), ?, ?, ?, ?, ?, ?)';

            $stmt = db_get_prepare_stmt($link, $sql, [$announce['category'], $announce['lot_name'], $announce['message'], $announce['lot_rate'], $announce['lot_date'], $announce['lot_step'], $announce['announce_img']]);
        
            $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $announce_id = mysqli_insert_id($link);
            header("Location: lot.php?id=" . $announce_id);
        }
        else {
            $page_content = include_template('error.php', ['error' => mysqli_error($link)]);
        }
        }
    }
    else {
        $page_content = include_template('add.php', ['categories' => $categories]);
}
}

$layout_content = include_template('layout.php', [
  'content' => $page_content,
  'categories' => $categories
]);

print($layout_content);
?>