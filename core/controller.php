<?php
if (isset($_GET['cat_volume'])) {
    ($_GET['cat_volume'] <> '') ? $number_of_items = (int)htmlspecialchars($_GET['cat_volume']) : $number_of_items = '';
}
if (isset($_GET['clean'])) {
    ($_GET['clean'] <> '') ? $cleaning = htmlspecialchars($_GET['clean']) : $cleaning = '';
}
if (isset($_GET['show'])) {
    ($_GET['show'] <> '') ? $show = htmlspecialchars($_GET['show']) : $show = '';
}

require "../core/model.php";