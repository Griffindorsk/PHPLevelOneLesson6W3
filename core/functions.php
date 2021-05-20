<?php
function mysql_noconnection() {echo "<p>Подключение к базе не удалось выполнить.</p>";};
function mysql_norequestresult() {echo "<p>Запрос к базе не удалось выполнить.</p>";};
function product_generation($connection) {//формирование записи из случайного набора данных
    $pr_number = "A" . rand(10000,99999);
    $pr_name = "футболка";
    $gender = rand(1,777);
    ($gender % 2 == 0) ? $gender = "М": $gender = "Ж";//случайная выборка пола
    $size = (int)(rand(1000, 9999) / 1000);//случайная выборка размера футболки
    switch ($size) {
        case 4:
            $size = 'S';
            break;
        case 5:
            $size = 'M';
            break;
        case 6:
            $size = 'L';
            break;
        case 7:
            $size = 'XL';
            break;
        default:
            if ($size < 4) $size = 'XS';
            if ($size > 7) $size = 'XXL';
    }
    
    $color = rand(1,12);//случайная выборка индекса цвета
    $color_request = "SELECT color FROM colors WHERE id_color=$color";
    $color_request_result = $connection->query($color_request);//запрос имени цвета к базе доступных цветов
    if (!$color_request_result) {
        mysql_norequestresult();//предупреждение, если запрос к базе не удался
    } else {
        $data_returned = $color_request_result->fetch_array(MYSQLI_ASSOC);//выборка из 1-й полученной строки в ассоциативный массив
        $color = htmlspecialchars($data_returned['color']);//получение имени цвета
    }
    
    //находим фотографию, которая соответствует выбранному цвету
    $photo_request = "SELECT photoname FROM images WHERE color=\"$color\"";
    $photo_request_result = $connection->query($photo_request);//запрос к базе на выполнение
    if (!$photo_request_result) {
        mysql_norequestresult();//предупреждение, если запрос к базе не удался
    } else {
        $data_returned = $photo_request_result->fetch_array(MYSQLI_ASSOC);//выборка из 1-й полученной строки в ассоциативный массив
        $photo = htmlspecialchars($data_returned['photoname']);//получение имени файла с фотографией товара
    }
    $price = rand(300, 2000);//случайная цена
    $on_stock = rand(0, 50);//случайное кол-во на складе
    $selected = 0;//сколько выбрано для заказа

    $description_index = rand(1,5);//случайная выборка индекса описания

    $add_data_request = "INSERT INTO `catalogue` (`id`, `pr_number`, `pr_name`, `gender`, `size`, `color`, `photo`, `price`, `on_stock`, `selected`, `description`) VALUES (NULL,'$pr_number','$pr_name','$gender','$size','$color','$photo','$price','$on_stock','$selected', '$description_index')";
    $db_update_result = $connection->query($add_data_request);//запрос к базе на выполнение
    if (!$db_update_result) {
        mysql_norequestresult();//предупреждение, если запрос к базе не удался
    }   
}
function catalogue($quantity) {
    require "../config/credibilities.php";
    $connection = new mysqli($hostname, $username, $passname, $dbname);//подключаемся к базе
    if ($connection->connect_error) {
        mysql_noconnection();//предупреждение, если подключение не удалось
    } else {
        for ($i = 1; $i <= $quantity; $i++) {
            product_generation($connection);
        }
    }
    $connection->close();
}

function catalogue_show() {
    require "../config/credibilities.php";
    $connection = new mysqli($hostname, $username, $passname, $dbname);//подключаемся к базе
    if ($connection->connect_error) {
        mysql_noconnection();//предупреждение, если подключение не удалось
    } else {
        $products_request = "SELECT id,pr_number,pr_name,gender,size,color,photo,price FROM catalogue WHERE id>0";
        $products_request_result = $connection->query($products_request);//запрос к базе на выполнение
        if (!$products_request_result) {
            mysql_norequestresult();//предупреждение, если запрос к базе не удался
        } else {
            $rows_number = $products_request_result->num_rows;//получение количества строк в результате запроса
            $full_list = '';
            for ($i = 1; $i <= $rows_number; $i++) {
                $data_returned = $products_request_result->fetch_array(MYSQLI_ASSOC);//выборка из строки в массив
                $id = htmlspecialchars($data_returned['id']);
                $pr_number = htmlspecialchars($data_returned['pr_number']);
                $pr_name = htmlspecialchars($data_returned['pr_name']);
                $gender = htmlspecialchars($data_returned['gender']);
                $size = htmlspecialchars($data_returned['size']);
                $color = htmlspecialchars($data_returned['color']);
                $photo = htmlspecialchars($data_returned['photo']);
                $price = htmlspecialchars($data_returned['price']);
                // $description_index = htmlspecialchars($data_returned['description']);

                $path_request = "SELECT iconpath FROM images WHERE photoname=\"$photo\"";
                $path_request_result = $connection->query($path_request);
                if (!$path_request_result) {
                    mysql_norequestresult();//предупреждение, если запрос к базе не удался
                } else {
                    $path_data_returned = $path_request_result->fetch_array(MYSQLI_ASSOC);
                    $path_to_icon = htmlspecialchars($path_data_returned['iconpath']);
                }
                $row = $i + 1;
                $full_list = $full_list . <<<_END
<div style="grid-area: $row/1" class="items"><a href="index.php?show=$id">$pr_number</a></div>
<div style="grid-area: $row/2" class="items"><a href="index.php?show=$id">$pr_name</a></div>
<div style="grid-area: $row/3" class="items"><a href="index.php?show=$id">$gender</a></div>
<div style="grid-area: $row/4" class="items"><a href="index.php?show=$id">$size</a></div>
<div style="grid-area: $row/5" class="items"><a href="index.php?show=$id">$color</a></div>
<img style="grid-area: $row/6" class="items" src="../$path_to_icon$photo" alt="иконка футболки">
<div style="grid-area: $row/7" class="items"><a href="index.php?show=$id">$price</a></div>
<div style="grid-area: $row/8" class="items col8"><a href="#">выбрать</a></div>
_END;
                //echo "<p>$pr_number $pr_name $gender $size $color $photo $price</p>";
            }
        }
    }
    $connection->close();
    return $full_list;
}
function show_description($show) {
    if ($show == 'nothing') {
        $product_description = ['','',''];
    } else {
        require "../config/credibilities.php";
        $connection = new mysqli($hostname, $username, $passname, $dbname);//подключаемся к базе
        if ($connection->connect_error) {
            mysql_noconnection();//предупреждение, если подключение не удалось
        } else {
            $description_index_request = "SELECT `photo`,`description` FROM catalogue WHERE id=$show";
            $description_index_request_result = $connection->query($description_index_request);
            if (!$description_index_request_result) {
                mysql_norequestresult();//предупреждение, если запрос к базе не удался
            } else {
                $data_from_catalogue = $description_index_request_result->fetch_array(MYSQLI_ASSOC);
                $description_index = htmlspecialchars($data_from_catalogue['description']);
                $description_text_request = "SELECT `description` FROM descriptions WHERE id_description=$description_index";
                $description_text_request_result = $connection->query($description_text_request);
                if (!$description_text_request_result) {
                    mysql_norequestresult();//предупреждение, если запрос к базе не удался
                } else {
                    $description_data = $description_text_request_result->fetch_array(MYSQLI_ASSOC);
                    $description_text = htmlspecialchars($description_data['description']);
                }
                $photoname = htmlspecialchars($data_from_catalogue['photo']);
 
                $pathtophoto_request = "SELECT `imagepath` FROM images WHERE photoname=\"$photoname\"";
                $pathtophoto_request_result = $connection->query($pathtophoto_request);
                if (!$pathtophoto_request_result) {
                    mysql_norequestresult();//предупреждение, если запрос к базе не удался
                } else {
                    $photo_data = $pathtophoto_request_result->fetch_array(MYSQLI_ASSOC);
                    $pathtophoto = htmlspecialchars($photo_data['imagepath']);
                }
                // $product_description = [$description_text, $pathtophoto, $photoname];
                $product_description = [$description_text, 'products/images/', $photoname];
            }
        }
    }
    return $product_description;
}

function catalogue_clean() {
    require "../config/credibilities.php";
    $connection = new mysqli($hostname, $username, $passname, $dbname);//подключаемся к базе
    if ($connection->connect_error) {
        mysql_noconnection();//предупреждение, если подключение не удалось
    } else {
        $delete_request = "DELETE FROM catalogue WHERE id>0";
        $delete_request_result = $connection->query($delete_request);//запрос имени цвета к базе доступных цветов
        if (!$delete_request_result) {
            mysql_norequestresult();//предупреждение, если запрос к базе не удался
        } else {
            //echo "<p>данные из каталога удалены</p>";
        }
    }
    $connection->close();
}


//         $request = "SELECT * FROM pictures WHERE id=$id_selected";//запрос к базе данных
//             $requestResult = $connection->query($request);//отправка запроса к базе данных
//             if (!$requestResult) {
//                 mysql_norequestresult();//предупреждение, если запрос к базе не удался 
//             } else {
//                 $resultRowsNumber = $requestResult->num_rows;//получение количества строк в результате запроса
//                 echo "<p>количество файлов с заданным индексом: " . $resultRowsNumber . "</p>";//поиск идет по primary_index и более одного результата быть не может, но для универсальности добавлен перебор как если бы было много записей с заданным параметром
//                 for ($i = 0; $i < $resultRowsNumber; $i++) {
//                     $requestRow = $requestResult->fetch_array(MYSQLI_ASSOC);//выборка параметров из строки в ассоциативный массив (ООП стиль)
//                     $fileName = htmlspecialchars($requestRow['filename']);//имя файла
//                     $filePath = htmlspecialchars($requestRow['path_large']);//путь к файлу
//                     $imgAlt = htmlspecialchars($requestRow['description']);//описание картинки
//                     $views = htmlspecialchars($requestRow['views']);//количество запросов картинки
//                     $views = $views + 1;
//                     echo <<<_END
//                     <img src="$filePath/$fileName" alt="$imgAlt" style="width: 400px;">
// _END;
//                     $requestToAdd = "UPDATE `pictures` SET views=$views WHERE id=$id_selected";
//                     $requestToAddResult = $connection->query($requestToAdd);
//                     if (!$requestToAddResult) {
//                         echo "<p>что-то пошло не так при попытке записи</p>";
//                     } else {
//                         echo "<p>общее количество просмотров этой картинки: $views</p>";
//                     }
//                 }
//                 unset($id_selected);
//                 unset($views);
//                 $requestResult->close();
//                 $connection->close();
//             }
//         }
//     }

// }