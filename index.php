<?php
require_once('functions.php');
require_once('data.php');

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
