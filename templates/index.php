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

$page_content = include_template('main.php', ['announce_list' => $announce_list]);
$layout_content = include_template('layout.php', [
  'content' => $page_content,
  'categories' => $categories,
  'title' => 'Главная'
]);

print($layout_content);
?>
