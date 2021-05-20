<?php
require_once "../core/functions.php";
if (!isset($full_list)) $full_list = catalogue_show();//вывод каталога на экран

if (isset($number_of_items) && $number_of_items == '' && (!isset($cleaning) || $cleaning == '')) {
    $control_message = 'необходимо задать кол-во позиций';
} else {
    $control_message = '';
}
if (isset($number_of_items) && $number_of_items <> '') {
    $control_message = '';
    catalogue($number_of_items);//генерация каталога товаров из случайного набора параметров
    $full_list = catalogue_show();//вывод каталога на экран
}
if (isset($cleaning) && $cleaning == 'full') {
    catalogue_clean();//полное удаление всех товаров из каталога
    $full_list = catalogue_show();//вывод каталога на экран
}
if (isset($show) && $show <> '') {
    $product_description = show_description($show);
    $text_description = $product_description[0];
    $path = $product_description[1];
    $product_photo = <<<_END
    <img class="product_photo" src="../$path$product_description[2]" alt="фотография футболки">
_END;
} else {
    $product_description = show_description('nothing');
    $text_description = $product_description[0];
    $product_photo = $product_description[1];
}
require "../core/view.php";