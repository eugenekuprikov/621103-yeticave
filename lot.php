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
            $page_content = include_template('lot.php', ['announce' => $announce, 'categories' => $categories]);   
        }
    }
    else {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    }
}

$layout_content = include_template('layout.php', [
  'content' => $page_content,
  'categories' => $categories
]);

print($layout_content);