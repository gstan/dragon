<?php
/**
 * 通用方法，所有的通用方法写在这
 * author gstan
 * date 2013-02-05
 * email 474703907@qq.com
 */
function zaddslashes($string, $force = 0, $strip = FALSE) {
    defined ("MAGIC_QUOTES_GPC" ) or  define ( "MAGIC_QUOTES_GPC", "" );

    if (! MAGIC_QUOTES_GPC || $force) {
        if (is_array ( $string )) { 
            foreach ( $string as $key => $val ) {
                $string [$key] = zaddslashes ( $val, $force, $strip );
            }
        } else {
            $string =  ( $strip ? stripslashes ( $string ) : $string );
            $string = htmlspecialchars ( $string );
        }
    }    
    return $string;
}
/* 日期格式显示 */

function tdate($time, $type = 3, $friendly = 1) { 
    global $setting;
    $format[] = $type & 2 ? (!empty($setting['date_format']) ? $setting['date_format'] : 'Y-n-j') : '';
    $format[] = $type & 1 ? (!empty($setting['time_format']) ? $setting['time_format'] : 'H:i') : '';
    $timeoffset = $setting['time_offset'] * 3600 + $setting['time_diff'] * 60;
    $timestring = gmdate(implode(' ', $format), $time + $timeoffset);
    if ($friendly) {
        $time = time() - $time;
        if ($time <= 24 * 3600) {
            if ($time > 3600) {
                $timestring = intval($time / 3600) . '小时前';
            } elseif ($time > 60) {
                $timestring = intval($time / 60) . '分钟前';
            } elseif ($time > 0) { 
                $timestring = $time . '秒前';
            } else {
                $timestring = '现在前';
            }
        }
    }    
    return $timestring;
}
/*百分比通用显示*/
function precent($value,$all) {
	$back = "";
	if (empty($value) || empty($all)) return $back;
	$back = round($value/$all,4);
	$back = ($back * 100) . "%";
	return $back;
}

function import($file) {
	static $filemap = array();
	if (!isset($filemap[$file])) {
		require ($file);
	}

}
