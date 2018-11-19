<?php
require_once "z_config.php";
require_once "z_mysql.php";
require_once "errors.php";
require 'PHPMailer/PHPMailerAutoload.php';

//get send data //
$all_data = file_get_contents('php://input');
$income_data = json_decode($all_data);
$params = $income_data->params;
$answer = ["token" => $income_data->token, "user_id" => $income_data->user_id, "error" => 0, "lang_id" => $income_data->lang_id, "info" => []];
switch ($params->command) {
    case "frame_list":
        $result = FrameList($income_data->lang_id);
        $answer['info'] = $result;
        break;
}

if ($answer['error'] > 0) {
    $answer['error'] = getError($answer['error'], $income_data->lang_id);
}
echo json_encode($answer);

function FrameList($lang_id){
    $con = new Z_MySQL();
    $good_type_frame = GOOD_TYPE_FRAME;
    if($lang_id == 1 || $lang_id == 2 || $lang_id == 3){
        $data = $con->queryNoDML("SELECT `goods`.`goodID` AS 'good_id',`series`.`text` AS 'series', `models`.`text` AS 'model', `colors`.`text` AS 'color',`good_pathes`.`path` AS 'path' FROM `goods`
                                         JOIN `goodTypes` JOIN `good_series` JOIN `good_models` JOIN `good_colors`
                                         JOIN `series` JOIN `models` JOIN `colors` JOIN `good_size` JOIN `good_pathes` WHERE

                                         `goodTypes`.`goodTypeID` = '{$good_type_frame}'
                                         AND `series`.`langID` = '{$lang_id}'
                                         AND `models`.`langID` = '{$lang_id}'
                                         AND `colors`.`langID` = '{$lang_id}'
                                         AND `goodTypes`.`langID` = '{$lang_id}'
                                         AND `good_size`.`v_size` = '1'
                                         AND `good_size`.`h_size` = '1'
                                         AND `goodTypes`.`goodTypeID` = `goods`.`good_typeID`
                                         AND `good_series`.`goodID` = `goods`.`goodID`
                                         AND `good_models`.`goodID` = `goods`.`goodID`
                                         AND `good_colors`.`goodID` = `goods`.`goodID`
                                         AND `series`.`seriesID` = `good_series`.`seriesID`
                                         AND `models`.`modelID` = `good_models`.`modelID`
                                         AND `colors`.`colorID` = `good_colors`.`colorID`
                                         AND `good_size`.`goodID` = `goods`.`goodID`
                                         AND `goods`.`goodID` = `good_pathes`.`goodID`
                                         ");
//        $data = $con->queryNoDML("SELECT `series`.`text` AS 'series', `models`.`text` AS 'model', `colors`.`text` AS 'color', `goods`.`part_number` AS 'code' FROM `goods`
//
//                                         INNER JOIN `goodTypes` ON `goodTypes`.`goodTypeID` = `goods`.`good_typeID`
//                                         INNER JOIN `good_series` ON `good_series`.`goodID` = `goods`.`goodID`
//                                         INNER JOIN `good_models` ON `good_models`.`goodID` = `goods`.`goodID`
//                                         INNER JOIN `good_colors` ON `good_colors`.`goodID` = `goods`.`goodID`
//                                         INNER JOIN `series` ON `series`.`seriesID` = `good_series`.`seriesID`
//                                         INNER JOIN `models` ON `models`.`modelID` = `good_models`.`modelID`
//                                         INNER JOIN `colors` ON `colors`.`colorID` = `good_colors`.`colorID`
//                                         INNER JOIN `good_size` ON `good_size`.`goodID` = `goods`.`goodID`
//
//                                         WHERE `goodTypes`.`goodTypeID` = '{$good_type_frame}' AND `series`.`langID` = '{$lang_id}'
//                                          AND `models`.`langID` = '{$lang_id}' AND `colors`.`langID` = '{$lang_id}'
//                                          AND `goodTypes`.`langID` = '{$lang_id}' AND `good_size`.`v_size` = '1'
//                                          AND `good_size`.`h_size` = '1'
//                                         ");
        if($data){
            return $data;
        }else{
            return FALSE;
        }
    }else{
        return FALSE;
    }
}
//print_r(FrameList(3));
