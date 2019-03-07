<?php
require_once 'init.php';

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

    $sql = "SELECT `rates`.`id`, `user_id`, `users`.`name` AS user, `date_rate`, `summ_rate` FROM rates"
        . " JOIN users ON rates.user_id = users.id"
        . " ORDER BY date_rate DESC";
    $result = mysqli_query($link, $sql);

    if ($result) {
        $rates = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    $id = mysqli_real_escape_string($link, $_GET['announce_id']);
    $sql = "SELECT `lots`.`id`, `category_id`, `lots`.`name`, `description`, `categories`.`name` AS category, `initial_price`, `step_rate`, `picture_link` FROM lots" 
        . " JOIN categories ON lots.category_id = categories.id" 
        . " WHERE lots.id = '%s'";

    $sql = sprintf($sql, $id);
    if ($result = mysqli_query($link, $sql)) {

        if (!mysqli_num_rows($result)) {
            http_response_code(404);
            $page_content = include_template('error.php', ['error' => 'Лот с этим идентификатором не найден']);
        }
        else {
            $announce = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $page_content = include_template('lot.php', ['announce' => $announce, 'categories' => $categories, 'rates' => $rates]);   
        }
    }
    else {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    }

    if (isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;
        $errors = [];

        if (empty($form['cost'])) {
            $errors[] = 'Это поле надо заполнить';
        }

        if (!filter_var($form['cost'], FILTER_VALIDATE_INT) && $form['cost'] < 0) {
            $errors[] = 'Поле должно содержать целое положительное число';
        }

        if ($form['cost'] > $announce['initial_price'] + $announce['step_rate']) {
            $sql = 'INSERT INTO rates (lot_id, user_id, date_rate, summ_rate) VALUES (1, 1, NOW(), ?)';

            $stmt = db_get_prepare_stmt($link, $sql, [$rate['cost']]);

            $res = mysqli_stmt_execute($stmt);
        }
    }
}

$layout_content = include_template('layout.php', [
  'content' => $page_content,
  'categories' => $categories
]);

print($layout_content);