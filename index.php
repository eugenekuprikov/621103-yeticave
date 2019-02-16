<?php
require_once('functions.php');
require_once('data.php');
require_once('init.php');

if (!$link) {
  $error = mysqli_connect_error();
  $content = include_template('error.php', ['error' => $error]);
}
else {
  $sql = 'SELECT `id`, `name` FROM categories';
  $result = mysqli_query($link, $sql);

  if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
  else {
    $error = mysqli_error($link);
    $content = include_template('error.php', ['error' => $error]);
  }
}

$sql = 'SELECT `categories.name`, `lots.id`, `lots.name`, `initial_price`, `picture_link` FROM lots'
  . 'JOIN categories ON lots.category_id = category_id'
  . 'WHERE completion_date BETWEEN "2019-02-12" AND "2019-03-01"'
  . 'ORDER BY date_creation DESC LIMIT 6';

  if ($res = mysqli_query($link, $sql)) {
      $announce_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
      $content = include_template('main.php', ['announce_list' => $announce_list]);
  }

$is_auth = rand(0, 1);

$user_name = 'Eugene';

function sum_format($price) {
  $price_int = ceil($price);
  if ($price_int < 1000) {
    $price_result = $price_int;
  } else {
    $price_result = number_format($price_int, 0, ' ', ' ');
  }
  $price_result = $price_result . ' ' . '<b class="rub">p</b>';
  return $price_result;
}

function time_left() {
  date_default_timezone_set("Europe/Moscow");
  $end_ts = strtotime("tomorrow midnight");
  $ts = time();
  $ts_diff = $end_ts - $ts;
  $hours = floor($ts_diff / 3600);
  $minutes = floor(($ts_diff % 3600) / 60);
  $handm = $hours . ':' . $minutes;
  return $handm;
}

$page_content = include_template('main.php', ['announce_list' => $announce_list]);
$layout_content = include_template('layout.php', [
  'content' => $page_content,
  'categories' => $categories,
  'title' => 'Главная'
]);

print($layout_content);
?>
