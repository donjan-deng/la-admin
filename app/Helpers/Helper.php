<?php

use App\Helpers\Code;

//返回成功
function success($data) {
    return result(Code::SUCCESS, Code::msg(Code::SUCCESS), $data);
}

//返回错误
function error($code = 422, $message = '', $data = []) {
    if (empty($message)) {
        return result($code, Code::msg($code), $data);
    } else {
        return result($code, $message, $data);
    }
}

function result($code, $message, $data) {
    return ['code' => $code, 'message' => $message, 'data' => $data];
}

/**
 * 生成随机数
 * @param number $length
 * @return number
 */
function generate_number($length = 6) {
    return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
}

/**
 * 生成随机字符串
 * @param number $length
 * @param string $chars
 * @return string
 */
function generate_string($length = 6, $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz') {
    $chars = str_split($chars);

    $chars = array_map(function($i) use($chars) {
        return $chars[$i];
    }, array_rand($chars, $length));

    return implode($chars);
}

/**
 * 生成数字订单编号
 * @return string
 */
function generate_number_order() {
    //return date('YmdHis') . mt_rand(10000000, 99999999);
    return date('Ymd') . mt_rand(10000, 99999);
}

/**
 * 密码生成
 */
function password($input, $hashKey = 'qcyd') {
    return hash_hmac('md5', trim($input), $hashKey);
}

/**
 * 密码验证
 */
function password_check($input, $password, $hashKey = 'qcyd') {
    return hash_hmac('md5', trim($input), $hashKey) == $password;
}

/**
 * 枚举修改器，如：状态等
 */
function get_format_state($key = 0, $enum = array(), $default = '--') {
    return array_key_exists($key, $enum) ? $enum[$key] : $default;
}

/**
 * 获取当前时间
 * @param type $format 时间格式  无返回timestamp
 * @return type
 */
function get_now_time($format = null) {
    $time = time();
    if ($format) {
        return date($format, $time);
    } else {
        return $time;
    }
}

function check_phone($phone) {
    if (preg_match("/^1[34578]\d{9}$/", $phone)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 计算百分比
 * @param type $num1
 * @param type $num2
 */
function calculate_percent($num1, $num2, $length = 2) {
    if ($num2 == 0) {
        return $num2;
    }
    $per = $num1 / $num2;
    $per = ceil($per * 10000);
    $per = $per / 100;
    return $per;
}

/**
 * xml to array 转换
 * @param type $xml
 * @return type
 */
function xml2array($xml) {
    return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
}

function get_sub_domain() {
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    $host = explode('.', $host);
    return $host[0];
}

/**
 * 根据后缀获取mimetype
 * @staticvar array $mime_types
 * @param type $ext
 * @return type
 */
function get_mime_type($ext) {
    static $mime_types = array(
        'apk' => 'application/vnd.android.package-archive',
        '3gp' => 'video/3gpp',
        'ai' => 'application/postscript',
        'aif' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'asc' => 'text/plain',
        'atom' => 'application/atom+xml',
        'au' => 'audio/basic',
        'avi' => 'video/x-msvideo',
        'bcpio' => 'application/x-bcpio',
        'bin' => 'application/octet-stream',
        'bmp' => 'image/bmp',
        'cdf' => 'application/x-netcdf',
        'cgm' => 'image/cgm',
        'class' => 'application/octet-stream',
        'cpio' => 'application/x-cpio',
        'cpt' => 'application/mac-compactpro',
        'csh' => 'application/x-csh',
        'css' => 'text/css',
        'dcr' => 'application/x-director',
        'dif' => 'video/x-dv',
        'dir' => 'application/x-director',
        'djv' => 'image/vnd.djvu',
        'djvu' => 'image/vnd.djvu',
        'dll' => 'application/octet-stream',
        'dmg' => 'application/octet-stream',
        'dms' => 'application/octet-stream',
        'doc' => 'application/msword',
        'dtd' => 'application/xml-dtd',
        'dv' => 'video/x-dv',
        'dvi' => 'application/x-dvi',
        'dxr' => 'application/x-director',
        'eps' => 'application/postscript',
        'etx' => 'text/x-setext',
        'exe' => 'application/octet-stream',
        'ez' => 'application/andrew-inset',
        'flv' => 'video/x-flv',
        'gif' => 'image/gif',
        'gram' => 'application/srgs',
        'grxml' => 'application/srgs+xml',
        'gtar' => 'application/x-gtar',
        'gz' => 'application/x-gzip',
        'hdf' => 'application/x-hdf',
        'hqx' => 'application/mac-binhex40',
        'htm' => 'text/html',
        'html' => 'text/html',
        'ice' => 'x-conference/x-cooltalk',
        'ico' => 'image/x-icon',
        'ics' => 'text/calendar',
        'ief' => 'image/ief',
        'ifb' => 'text/calendar',
        'iges' => 'model/iges',
        'igs' => 'model/iges',
        'jnlp' => 'application/x-java-jnlp-file',
        'jp2' => 'image/jp2',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'js' => 'application/x-javascript',
        'kar' => 'audio/midi',
        'latex' => 'application/x-latex',
        'lha' => 'application/octet-stream',
        'lzh' => 'application/octet-stream',
        'm3u' => 'audio/x-mpegurl',
        'm4a' => 'audio/mp4a-latm',
        'm4p' => 'audio/mp4a-latm',
        'm4u' => 'video/vnd.mpegurl',
        'm4v' => 'video/x-m4v',
        'mac' => 'image/x-macpaint',
        'man' => 'application/x-troff-man',
        'mathml' => 'application/mathml+xml',
        'me' => 'application/x-troff-me',
        'mesh' => 'model/mesh',
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'mif' => 'application/vnd.mif',
        'mov' => 'video/quicktime',
        'movie' => 'video/x-sgi-movie',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'mp4' => 'video/mp4',
        'mpe' => 'video/mpeg',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpga' => 'audio/mpeg',
        'ms' => 'application/x-troff-ms',
        'msh' => 'model/mesh',
        'mxu' => 'video/vnd.mpegurl',
        'nc' => 'application/x-netcdf',
        'oda' => 'application/oda',
        'ogg' => 'application/ogg',
        'ogv' => 'video/ogv',
        'pbm' => 'image/x-portable-bitmap',
        'pct' => 'image/pict',
        'pdb' => 'chemical/x-pdb',
        'pdf' => 'application/pdf',
        'pgm' => 'image/x-portable-graymap',
        'pgn' => 'application/x-chess-pgn',
        'pic' => 'image/pict',
        'pict' => 'image/pict',
        'png' => 'image/png',
        'pnm' => 'image/x-portable-anymap',
        'pnt' => 'image/x-macpaint',
        'pntg' => 'image/x-macpaint',
        'ppm' => 'image/x-portable-pixmap',
        'ppt' => 'application/vnd.ms-powerpoint',
        'ps' => 'application/postscript',
        'qt' => 'video/quicktime',
        'qti' => 'image/x-quicktime',
        'qtif' => 'image/x-quicktime',
        'ra' => 'audio/x-pn-realaudio',
        'ram' => 'audio/x-pn-realaudio',
        'ras' => 'image/x-cmu-raster',
        'rdf' => 'application/rdf+xml',
        'rgb' => 'image/x-rgb',
        'rm' => 'application/vnd.rn-realmedia',
        'roff' => 'application/x-troff',
        'rtf' => 'text/rtf',
        'rtx' => 'text/richtext',
        'sgm' => 'text/sgml',
        'sgml' => 'text/sgml',
        'sh' => 'application/x-sh',
        'shar' => 'application/x-shar',
        'silo' => 'model/mesh',
        'sit' => 'application/x-stuffit',
        'skd' => 'application/x-koan',
        'skm' => 'application/x-koan',
        'skp' => 'application/x-koan',
        'skt' => 'application/x-koan',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'snd' => 'audio/basic',
        'so' => 'application/octet-stream',
        'spl' => 'application/x-futuresplash',
        'src' => 'application/x-wais-source',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc' => 'application/x-sv4crc',
        'svg' => 'image/svg+xml',
        'swf' => 'application/x-shockwave-flash',
        't' => 'application/x-troff',
        'tar' => 'application/x-tar',
        'tcl' => 'application/x-tcl',
        'tex' => 'application/x-tex',
        'texi' => 'application/x-texinfo',
        'texinfo' => 'application/x-texinfo',
        'tif' => 'image/tiff',
        'tiff' => 'image/tiff',
        'tr' => 'application/x-troff',
        'tsv' => 'text/tab-separated-values',
        'txt' => 'text/plain',
        'ustar' => 'application/x-ustar',
        'vcd' => 'application/x-cdlink',
        'vrml' => 'model/vrml',
        'vxml' => 'application/voicexml+xml',
        'wav' => 'audio/x-wav',
        'wbmp' => 'image/vnd.wap.wbmp',
        'wbxml' => 'application/vnd.wap.wbxml',
        'webm' => 'video/webm',
        'wml' => 'text/vnd.wap.wml',
        'wmlc' => 'application/vnd.wap.wmlc',
        'wmls' => 'text/vnd.wap.wmlscript',
        'wmlsc' => 'application/vnd.wap.wmlscriptc',
        'wmv' => 'video/x-ms-wmv',
        'wrl' => 'model/vrml',
        'xbm' => 'image/x-xbitmap',
        'xht' => 'application/xhtml+xml',
        'xhtml' => 'application/xhtml+xml',
        'xls' => 'application/vnd.ms-excel',
        'xml' => 'application/xml',
        'xpm' => 'image/x-xpixmap',
        'xsl' => 'application/xml',
        'xslt' => 'application/xslt+xml',
        'xul' => 'application/vnd.mozilla.xul+xml',
        'xwd' => 'image/x-xwindowdump',
        'xyz' => 'chemical/x-xyz',
        'zip' => 'application/zip'
    );
    return isset($mime_types[$ext]) ? $mime_types[$ext] : 'application/octet-stream';
}

/**
 * 导出excel
 * @param type $data 数据
 * @param type $name 文件名,无需后缀
 */
function export_excel($data, $name, $isSave = false) {
    $name .= '.xls';
    $excel = new \PHPExcel();
    $excelArray = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
        "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ");
    $excel->setActiveSheetIndex(0);
    foreach ($data as $key => $value) {
        if ($key == 0) { //如果是第一行，先设置标题
            $index = 0;
            foreach ($value as $title => $tempData) {
                $excel->getActiveSheet()->setCellValue($excelArray[$index] . ($key + 1), $title);
                $index++;
            }
        }
        //主体数据
        $index = 0;
        foreach ($value as $keyCode => $tempData) {
            $excel->getActiveSheet()->setCellValue($excelArray[$index] . ($key + 2), $tempData);
            $index++;
        }
    }
    $excelWrite = new \PHPExcel_Writer_Excel5($excel);
    if ($isSave) {
        //$excelWrite->save("./upload/export/" . $name);
    } else {
        ob_end_clean();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="' . $name);
        header("Content-Transfer-Encoding:binary");
        $excelWrite->save("php://output");
        exit();
    }
}

/**
 * 获取时间范围
 * @param type $day eg.2017-11-1
 * @param type $type day,week,month
 * @return type
 */
function get_time_range($day, $type) {
    $time = strtotime($day . ' 00:00:00');
    switch ($type) {
        case 'week':
            //周的最后一天
            $etime = strtotime(date('Y-m-d 23:59:59', $time) . ' Sunday') + 86399;
            $stime = strtotime(date('Y-m-d 00:00:00', $etime) . ' -6 days');
            break;
        case 'month':
            $stime = strtotime(date('Y-m-01 00:00:00', $time));
            $etime = strtotime(date('Y-m-t 23:59:59', $time));
            break;
        case 'year':
            $stime = strtotime(date('Y-01-01 00:00:00', $time));
            $etime = strtotime(date('Y-12-31 23:59:59', $time));
            break;
        default :
            $stime = $time;
            $etime = $time + 86399;
            break;
    }
    return [date('Y-m-d H:i:s', $stime), date('Y-m-d H:i:s', $etime)];
}

/* * 获取上月的日期
 * @param $date
 * @return array
 */

function get_last_time_range($date, $type) {
    $timestamp = strtotime($date);
    switch ($type) {
        case 'week':
            //周的最后一天
            $beginLastweek = mktime(0, 0, 0, date('m'), date('d') - date('w') + 1 - 7, date('Y'));
            $endLastweek = mktime(23, 59, 59, date('m'), date('d') - date('w') + 7 - 7, date('Y'));
            $firstday = date('Y-m-d 00:00:00', $beginLastweek);
            $lastday = date('Y-m-d 23:59:59', $endLastweek);
            break;
        case 'month':
            $firstday = date('Y-m-01 00:00:00', strtotime(date('Y', $timestamp) . '-' . (date('m', $timestamp) - 1) . '-01'));
            $lastday = date('Y-m-d 23:59:59', strtotime("$firstday +1 month -1 day"));
            break;
        case 'year':
            $firstday = date('Y-01-01 00:00:00', strtotime((date('Y', $timestamp) - 1) . '-' . date('m', $timestamp) . '-01'));
            $lastday = date('Y-m-d 23:59:59', strtotime("$firstday +1 year -1 day"));
            break;
        default :
            $firstday = date("Y-m-d 00:00:00", strtotime("-1 day"));
            $lastday = date('Y-m-d 23:59:59', strtotime("-1 day"));
            break;
    }

    return array($firstday, $lastday);
}

//静态资源自动加版本号
function A($path, $secure = null) {
    $path .= '?ver=' . config('app.version');
    return asset($path, $secure);
}

//加载图片
function I($path, $model = -1, $w = 0, $h = 0, $q = 0) {
    $path = config('app.static') . $path;
    if ($model > -1) {
        $path .= "?imageView2/$model";
    }
    if ($w > 0) {
        $path .= "/w/$w";
    }
    if ($h > 0) {
        $path .= "/h/$h";
    }
    if ($q > 0) {
        $path .= "/q/$q";
    }
    return $path;
}

//获取IP
function get_ip() {
    $arr_ip_header = array(
        'HTTP_CDN_SRC_IP',
        'HTTP_PROXY_CLIENT_IP',
        'HTTP_WL_PROXY_CLIENT_IP',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR',
    );
    $client_ip = 'unknown';
    foreach ($arr_ip_header as $key) {
        if (isset($_SERVER)) {
            if (isset($_SERVER[$key]) && !empty($_SERVER[$key]) && strtolower($_SERVER[$key]) != 'unknown') {
                $client_ip = $_SERVER[$key];
                break;
            }
        } else {
            if (!empty(getenv($key)) && strtolower(getenv($key)) != 'unknown') {
                $client_ip = getenv($key);
                break;
            }
        }
    }
    return $client_ip;
}

/**
 * 输出完整SQL语句，查询前调用此函数
 */
function debug_sql() {
    \DB::listen(function($sql) {
        foreach ($sql->bindings as $i => $binding) {
            if ($binding instanceof \DateTime) {
                $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            } else {
                if (is_string($binding)) {
                    $sql->bindings[$i] = "'$binding'";
                }
            }
        }
        $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);
        $query = vsprintf($query, $sql->bindings);
        var_dump($query);
    });
}
