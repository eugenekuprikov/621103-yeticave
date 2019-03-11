<?php
require_once('init.php');
require_once('functions.php');

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
}
else {
    $sql = 'SELECT `id`, `name` FROM categories';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    }
}

$tpl_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $errors = [];

    $req_fields = ['email', 'password', 'name', 'message'];

    foreach ($req_fields as $field) {
        if (empty($form[$field]) || trim($form[$field]) == '') {
            $errors[] = "Не заполнено поле " . $field;
        }
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($link, $form['email']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Введите email в правильном формате';
        }

        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors[] = 'Пользователь с этим email уже зарегистрирован';
        }
        else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);

            if (isset($_FILES['avatar_img']['name'])) {
                $tmp_name = $_FILES['avatar_img']['tmp_name'];
                $avatar = $_FILES['avatar_img']['name'];
                $file_type = mime_content_type($tmp_name);
                if ($file_type !== "image/jpg" && $file_type !== "image/jpeg") {
                    $errors['file'] = 'Загрузите картинку в формате JPG или JPEG';
                }
                else {
                    $filename = uniqid() . '.jpg';
                    $user['avatar'] = $filename;
                    move_uploaded_file($tmp_name, 'img/' . $filename);
                }
            }
            else {
                $errors['file'] = 'Вы не загрузили файл';
            }

            if ($res && empty($errors)) {
                $sql = 'INSERT INTO users (reg_date, email, name, password, avatar, contacts) VALUES (NOW(), ?, ?, ?, ?, ?)';
                $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name'], $password, $user['avatar'], $form['message']]);
                $res = mysqli_stmt_execute($stmt);
        
                header("Location: /enter.php");
                exit(); 
            }
        }
    }
    $tpl_data['errors'] = $errors;
    $tpl_data['values'] = $form;
}

$page_content = include_template('reg.php', ['categories' => $categories], $tpl_data);

$layout_content = include_template('layout.php', [
    'content'    => $page_content,
    'categories' => $categories,
    'title'      => 'Регистрация'
]);

print($layout_content);
?>