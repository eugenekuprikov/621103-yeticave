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

        $sql = 'INSERT INTO lots (category_id, author_id, date_creation, name, description, initial_price, completion_date, step_rate, picture_link) VALUES (?, 1, NOW(), ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($link, $sql, [$announce['category'], $announce['name'], $announce['description'], $announce['initial_price'], $announce['completion_date'], $announce['step_rate'], $announce['picture_link']]);
        
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $announce_id = mysqli_insert_id($link);
            header("Location: lot.php?id=" . $announce_id);
        }
        else {
            $page_content = include_template('error.php', ['error' => mysqli_error($link)]);
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