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
    case "mecanism_by_frame":
        $result = MecanismByFrame($income_data->lang_id,$params->good_id_frame);
        $answer['info'] = $result;
        break;
    case "default_cover_by_mecanism":
      $result = DefaultCoverByMecanism($income_data->lang_id,$params->good_id_frame,$params->good_id_mecanism);
      $answer['info'] = $result;
        break;
    case "cover_list_by_mecanism":
        $result = CoverListByMecanism($income_data->lang_id,$params->good_id_mecanism);
        $answer['info'] = $result;
        break;
    case "mecanisms_list_by_series":
        $result = MecanismListBySeries($income_data->lang_id,$params->good_id_frame);
        $answer['info'] = $result;
        break;
    case "frame_vertical_horizont":
        $result = FrameVerticalHorizont($income_data->lang_id,$params->good_id_frame);
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
        $data = $con->queryNoDML("SELECT `goods`.`goodID` AS 'good_id_frame',`series`.`text` AS 'series', `models`.`text` AS 'model', `colors`.`text` AS 'color', `default_colors`.`default_colorID` AS 'def_color_id' ,`good_pathes`.`path` AS 'path',`price_goods`.`cost` AS 'price' FROM `goods`
                                         JOIN `goodTypes` JOIN `good_series` JOIN `good_models` JOIN `good_colors`
                                         JOIN `series` JOIN `models` JOIN `colors` JOIN `good_size` JOIN `good_pathes` 
                                         JOIN `price_goods` JOIN `default_colors`  WHERE

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
                                         AND `goods`.`goodID` = `price_goods`.`goodID`
                                         AND `series`.`seriesID` = `default_colors`.`seriesID`
                                         AND `models`.`modelID` = `default_colors`.`modelID`
                                         ");
//        $data = $con->queryNoDML("SELECT `goods`.`goodID` AS 'good_id',`series`.`text` AS 'series', `models`.`text` AS 'model', `colors`.`text` AS 'color',`good_pathes`.`path` AS 'path' FROM `goods`
//
//                                         INNER JOIN `goodTypes` ON `goodTypes`.`goodTypeID` = `goods`.`good_typeID`
//                                         INNER JOIN `good_series` ON `good_series`.`goodID` = `goods`.`goodID`
//                                         INNER JOIN `good_models` ON `good_models`.`goodID` = `goods`.`goodID`
//                                         INNER JOIN `good_colors` ON `good_colors`.`goodID` = `goods`.`goodID`
//                                         INNER JOIN `series` ON `series`.`seriesID` = `good_series`.`seriesID`
//                                         INNER JOIN `models` ON `models`.`modelID` = `good_models`.`modelID`
//                                         INNER JOIN `colors` ON `colors`.`colorID` = `good_colors`.`colorID`
//                                         INNER JOIN `good_size` ON `good_size`.`goodID` = `goods`.`goodID`
//                                         INNER JOIN `good_pathes` ON `good_pathes`.`goodID` = `goods`.`goodID`

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

function MecanismByFrame($lang_id,$good_id_frame){
    $con = new Z_MySQL();
    $frames = array(LOGUS_SERIES,SIRIUS_SERIES,APOLLO_SERIES,QUADRO_SERIES);
    $good_type_mecanism = GOOD_TYPE_MECANISM;

    $series_id = $con->queryNoDML("SELECT `good_series`.`seriesID` AS 'series_id' FROM `good_series` WHERE `good_series`.`goodID` = '{$good_id_frame}'")[0]['series_id'];

    $model_id = $con->queryNoDML("SELECT `good_models`.`modelID` AS 'model_id' FROM `good_models` WHERE `good_models`.`goodID` = '{$good_id_frame}'")[0]['model_id'];

    //$color_id = $con->queryNoDML("SELECT `good_colors`.`colorID` AS 'color_id' FROM `good_colors` WHERE `good_colors`.`goodID` = '{$good_id_frame}'")[0]['color_id'];

    $def_color_id = $con->queryNoDML("SELECT `default_colors`.`default_colorID` AS 'def_color_id' FROM `default_colors` WHERE `seriesID` = '{$series_id}' AND `modelID` = '{$model_id}'")[0]['def_color_id'];


    if (in_array($series_id, $frames)) {
        $mecanism_list =  $con->queryNoDML("SELECT `goods`.`goodID` AS 'good_id_mecanism', `mecanisms`.`text` AS 'mecanism_name', `good_pathes`.`path` AS 'path',
                                                  `price_goods`.`cost` AS 'price' FROM `goods`
                                                   JOIN `goodTypes` JOIN `good_mecanisms` JOIN `mecanisms` JOIN `good_pathes`
                                                   JOIN `price_goods` JOIN `good_colors` JOIN `good_series` 
                                                   
                                                  WHERE `mecanisms`.`langID` = '{$lang_id}'
                                                  AND (`good_colors`.`colorID` = '{$def_color_id}' OR `good_colors`.`colorID` = '0')
                                                  AND `goodTypes`.`langID` = '{$lang_id}'
                                                  AND `goods`.`good_typeID` = '{$good_type_mecanism}'
                                                  AND `goodTypes`.`goodTypeID` = `goods`.`good_typeID`
                                                  AND `good_mecanisms`.`goodID` = `goods`.`goodID`
                                                  AND `mecanisms`.`mecanismID` = `good_mecanisms`.`mecanismID`
                                                  AND `good_pathes`.`goodID` = `goods`.`goodID`
                                                  AND `price_goods`.`goodID` = `goods`.`goodID`
                                                  AND `good_colors`.`goodID` = `goods`.`goodID`
                                                  AND `good_series`.`goodID` = `goods`.`goodID`");
       if($mecanism_list){
         return $mecanism_list;
       }else{
         return FALSE;
       }
    }
//    else{
//        $mecanism_list = $con->queryNoDML("SELECT `goods`.`goodID` AS 'good_id', `mecanisms`.`text` AS 'mecanism_name', `good_pathes`.`path` AS 'path',
//                                                  `price_goods`.`cost` AS 'price' FROM `goods`
//                                                   JOIN `goodTypes` JOIN `good_mecanisms` JOIN `mecanisms` JOIN `good_pathes`
//                                                   JOIN `price_goods` JOIN `good_colors` JOIN `good_series`
//
//                                                  WHERE `mecanisms`.`langID` = '{$lang_id}'
//                                                  AND (`good_colors`.`colorID` = '{$color_id}' OR `good_colors`.`colorID` = '0')
//                                                  AND `good_series`.`seriesID` = '{$series_id}'
//                                                  AND `goodTypes`.`langID` = '{$lang_id}'
//                                                  AND `goods`.`good_typeID` = '{$good_type_mecanism}'
//                                                  AND `goodTypes`.`goodTypeID` = `goods`.`good_typeID`
//                                                  AND `good_mecanisms`.`goodID` = `goods`.`goodID`
//                                                  AND `mecanisms`.`mecanismID` = `good_mecanisms`.`mecanismID`
//                                                  AND `good_pathes`.`goodID` = `goods`.`goodID`
//                                                  AND `price_goods`.`goodID` = `goods`.`goodID`
//                                                  AND `good_colors`.`goodID` = `goods`.`goodID`
//                                                  AND `good_series`.`goodID` = `goods`.`goodID`");
//        if($mecanism_list){
//            return $mecanism_list;
//        }else{
//            return FALSE;
//        }
//    }
}
//print_r(MecanismByFrame('3','7'));

function DefaultCoverByMecanism($lang_id,$good_id_frame,$good_id_mecanism){
    $con = new Z_MySQL();
    $frames = array(LOGUS_SERIES,SIRIUS_SERIES,APOLLO_SERIES,QUADRO_SERIES);
    $good_type_cover = GOOD_TYPE_COVER;

    $color_id = $con->queryNoDML("SELECT `good_colors`.`colorID` AS 'color_id' FROM `good_colors` WHERE `good_colors`.`goodID` = '{$good_id_frame}'")[0]['color_id'];

    $mecanism_id = $con->queryNoDML("SELECT `good_mecanisms`.`mecanismID` AS 'mecanism_id' FROM `good_mecanisms` WHERE `good_mecanisms`.`goodID` = '{$good_id_mecanism}'")[0]['mecanism_id'];



    $default_cover = $con->queryNoDML("SELECT `goods`.`goodID` AS 'good_id', `series`.`text` AS 'series',
                                              `good_pathes`.`path` AS 'path', `price_goods`.`cost` AS 'price' FROM `goods`
                                              
                                              JOIN `goodTypes` JOIN `good_mecanisms` JOIN `good_pathes` JOIN `price_goods`
                                              JOIN `good_colors` JOIN `good_series` JOIN `series`
                                              
                                               WHERE `goodTypes`.`goodTypeID` = '{$good_type_cover}'
                                               AND `good_mecanisms`.`mecanismID` = '{$mecanism_id}'
                                               AND (`good_colors`.`colorID` = '{$color_id}' OR `good_colors`.`colorID` = '0')
                                               AND `good_mecanisms`.`goodTypeID` = '{$good_type_cover}'
                                               AND  `goodTypes`.`langID` = '{$lang_id}'
                                               AND `series`.`langID` = '{$lang_id}'
                                               AND `goodTypes`.`goodTypeID` = `goods`.`good_typeID`
                                               AND `good_mecanisms`.`goodID` = `goods`.`goodID`
                                               AND `good_pathes`.`goodID` = `goods`.`goodID`
                                               AND `price_goods`.`goodID` = `goods`.`goodID`
                                               AND `good_colors`.`goodID` = `goods`.`goodID`
                                               AND `good_series`.`goodID` = `goods`.`goodID`
                                               AND `series`.`seriesID` = `good_series`.`seriesID`");

    if($default_cover){
        return $default_cover;
    }
    else{
        return FALSE;
    }


    $default_cover = $con->queryNoDML("SELECT `goods`.`goodID` AS 'good_id', `series`.`text` AS 'series',
                                              `good_pathes`.`path` AS 'path', `price_goods`.`cost` AS 'price' FROM `goods`

                                              JOIN `goodTypes` JOIN `good_mecanisms` JOIN `good_pathes` JOIN `price_goods`
                                              JOIN `good_colors` JOIN `good_series` JOIN `series`

                                               WHERE `goodTypes`.`goodTypeID` = '{$good_type_cover}'
                                               AND `good_mecanisms`.`mecanismID` = '{$mecanism_id}'
                                               AND (`good_colors`.`colorID` = '{$color_id}' OR `good_colors`.`colorID` = '0')
                                               AND `good_series`.`seriesID` = '{$series_id}'
                                               AND `good_mecanisms`.`goodTypeID` = '{$good_type_cover}'
                                               AND  `goodTypes`.`langID` = '{$lang_id}'
                                               AND `series`.`langID` = '{$lang_id}'
                                               AND `goodTypes`.`goodTypeID` = `goods`.`good_typeID`
                                               AND `good_mecanisms`.`goodID` = `goods`.`goodID`
                                               AND `good_pathes`.`goodID` = `goods`.`goodID`
                                               AND `price_goods`.`goodID` = `goods`.`goodID`
                                               AND `good_colors`.`goodID` = `goods`.`goodID`
                                               AND `good_series`.`goodID` = `goods`.`goodID`
                                               AND `series`.`seriesID` = `good_series`.`seriesID`");
}
//print_r(DefaultCoverByMecanism('3','10'));
function  CoverListByMecanism($lang_id,$good_id_mecanism){
    $con = new Z_MySQL();
    $good_type_cover = GOOD_TYPE_COVER;

    $series_id = $con->queryNoDML("SELECT `good_series`.`seriesID` AS 'series_id' FROM `good_series` WHERE `good_series`.`goodID` = '{$good_id_mecanism}'")[0]['series_id'];
    $mecanism_id = $con->queryNoDML("SELECT `good_mecanisms`.`mecanismID` AS 'mecanism_id' FROM `good_mecanisms` WHERE `good_mecanisms`.`goodID` = '{$good_id_mecanism}'")[0]['mecanism_id'];

    $cover_list = $con->queryNoDML("SELECT `goods`.`goodID` AS 'good_id', `series`.`text` AS 'series',
                                              `good_pathes`.`path` AS 'path', `price_goods`.`cost` AS 'price' FROM `goods`
                                              
                                              JOIN `goodTypes` JOIN `good_mecanisms` JOIN `good_pathes` JOIN `price_goods`
                                              JOIN `good_colors` JOIN `good_series` JOIN `series`
                                              
                                               WHERE `goodTypes`.`goodTypeID` = '{$good_type_cover}'
                                               AND `good_mecanisms`.`mecanismID` = '{$mecanism_id}'
                                               AND `good_series`.`seriesID` = '{$series_id}'
                                               AND `good_mecanisms`.`goodTypeID` = '{$good_type_cover}'
                                               AND  `goodTypes`.`langID` = '{$lang_id}'
                                               AND `series`.`langID` = '{$lang_id}'
                                               AND `goodTypes`.`goodTypeID` = `goods`.`good_typeID`
                                               AND `good_mecanisms`.`goodID` = `goods`.`goodID`
                                               AND `good_pathes`.`goodID` = `goods`.`goodID`
                                               AND `price_goods`.`goodID` = `goods`.`goodID`
                                               AND `good_colors`.`goodID` = `goods`.`goodID`
                                               AND `good_series`.`goodID` = `goods`.`goodID`
                                               AND `series`.`seriesID` = `good_series`.`seriesID`");
    if($cover_list){
        return $cover_list;
    }
    else{
        return FALSE;
    }
}

function MecanismListBySeries($lang_id,$good_id_frame){
    $con = new Z_MySQL();
    $good_type_mecanism = GOOD_TYPE_MECANISM;
    $series_id = $con->queryNoDML("SELECT `good_series`.`seriesID` AS 'series_id' FROM `good_series` WHERE `good_series`.`goodID` = '{$good_id_frame}'")[0]['series_id'];
    $mecanism_list =  $con->queryNoDML("SELECT `goods`.`goodID` AS 'good_id', `mecanisms`.`text` AS 'mecanism_name', `good_pathes`.`path` AS 'path',
                                                  `price_goods`.`cost` AS 'price' FROM `goods`
                                                   JOIN `goodTypes` JOIN `good_mecanisms` JOIN `mecanisms` JOIN `good_pathes`
                                                   JOIN `price_goods` JOIN `good_colors` JOIN `good_series` 
                                                   
                                                  WHERE `mecanisms`.`langID` = '{$lang_id}'
                                                  AND `good_series`.`seriesID` = '{$series_id}'
                                                  AND `goodTypes`.`langID` = '{$lang_id}'
                                                  AND `goods`.`good_typeID` = '{$good_type_mecanism}'
                                                  AND `goodTypes`.`goodTypeID` = `goods`.`good_typeID`
                                                  AND `good_mecanisms`.`goodID` = `goods`.`goodID`
                                                  AND `mecanisms`.`mecanismID` = `good_mecanisms`.`mecanismID`
                                                  AND `good_pathes`.`goodID` = `goods`.`goodID`
                                                  AND `price_goods`.`goodID` = `goods`.`goodID`
                                                  AND `good_colors`.`goodID` = `goods`.`goodID`
                                                  AND `good_series`.`goodID` = `goods`.`goodID`");
    if($mecanism_list){
        return $mecanism_list;
    }
    else{
        return FALSE;
    }
}


function FrameVerticalHorizont($lang_id,$good_id_frame){
    $con = new Z_MySQL();
    $good_type_frame = GOOD_TYPE_FRAME;
    $series_id = $con->queryNoDML("SELECT `good_series`.`seriesID` AS 'series_id' FROM `good_series` WHERE `good_series`.`goodID` = '{$good_id_frame}'")[0]['series_id'];
    $model_id = $con->queryNoDML("SELECT `good_models`.`modelID` AS 'model_id' FROM `good_models` WHERE `good_models`.`goodID` = '{$good_id_frame}'")[0]['model_id'];
    $color_id = $con->queryNoDML("SELECT `good_colors`.`colorID` AS 'color_id' FROM `good_colors` WHERE `good_colors`.`goodID` = '{$good_id_frame}'")[0]['color_id'];



    $data = $con->queryNoDML("SELECT MAX(`good_size`.`v_size`) AS 'max_vertical',MAX(`good_size`.`h_size`) AS 'max_horizontal' FROM `good_size`
                                     JOIN `goods` JOIN `good_series` JOIN `good_models` JOIN `good_colors`
                                     
                                     WHERE `good_series`.`seriesID` = '{$series_id}'
                                     AND `good_models`.`modelID` = '{$model_id}'
                                     AND `good_colors`.`colorID` = '{$color_id}'
                                     AND `goods`.`goodID` = `good_size`.`goodID`
                                     AND `good_series`.`goodID` = `goods`.`goodID`
                                     AND `good_models`.`goodID` = `goods`.`goodID`
                                     AND `good_colors`.`goodID` = `goods`.`goodID`");
    if($data){
        return $data;
    }
    else{
        return FALSE;
    }


}
