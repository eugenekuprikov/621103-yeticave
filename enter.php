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

        $email = mysqli_real_escape_string($link, $form['email']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);

        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

        if (!count($errors) and $user) {
            if (password_verify($form['password'], $user['password'])) {
                $_SESSION['user'] = $user;
            }
            else {
                $errors['password'] = 'Неверный пароль';
            }
        }
        else {
            $errors['email'] = 'Такой пользователь не найден';
        }

        if (count($errors)) {
            $page_content = include_template('enter.php', ['form' => $form, 'categories' => $categories, 'errors' => $errors]);
        }
        else {
            header("Location: /enter.php");
            exit();
        }
    }
    else {
        if (isset($_SESSION['user'])) {
            $page_content = include_template('index.php', ['announce_list' => $announce_list, 'categories' => $categories]);
        }
        else {
            $page_content = include_template('enter.php', ['categories' => $categories]);
        }
    }
}

$layout_content = include_template('layout.php', [
  'content' => $page_content,
  'categories' => $categories,
  'title' => 'Вход'
]);

print($layout_content);
?>