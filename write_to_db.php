<?php

require_once "z_config.php";
require_once "z_mysql.php";
require_once "errors.php";
require 'PHPMailer/PHPMailerAutoload.php';

$con = new Z_MySQL();
$file = 'a1.csv';
$i = 0;
$handle = fopen($file, "r");
if($handle){
    while (($row = fgetcsv($handle, 4096)) !== false) {
        // print_r($row);
        if (empty($fields)) {
            $fields = $row;
            continue;
        }
        foreach ($row as $k=>$value) {
            $array[$i][$fields[$k]] = $value;
        }
        $i++;
    }
}
//echo "<pre>";
//print_r($array);
//echo "</pre>";
foreach ($array as $key=>$value) {
    $part_number = $value['Part number'];
    $desc = $value['Description'];
    $seria = $value['Series'];

    $con->queryDML("INSERT INTO `good_description` (`good_despID`,`text`,`langID`) VALUES (NULL,'$desc','1')");
    $last_id = $con->lastID();
    $con->queryDML("INSERT INTO `good_description` (`good_despID`,`text`,`langID`) VALUES ('{$last_id}','$desc','2')");
    $con->queryDML("INSERT INTO `good_description` (`good_despID`,`text`,`langID`) VALUES ('{$last_id}','$desc','3')");

    $con->queryDML("INSERT INTO `goods` (`goodID`,`part_number`,`good_despID`,`good_typeID`) VALUES (NULL,'$part_number','$last_id','1')");
    $good_id = $con->lastID();

    $series_id = $con->queryNoDML("SELECT `series`.`seriesID` AS 'series_id' FROM `series` WHERE `text` = '$seria' AND `langID` = '1'")[0]['series_id'];

    $con->queryDML("INSERT INTO `good_series` (`goodID`,`seriesID`) VALUES ('{$good_id}','{$series_id}')");
}
