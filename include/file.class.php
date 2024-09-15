<?php
/**
 * DouPHP
 * --------------------------------------------------------------------------------------------------
 * 版权所有 2013-2024 漳州豆壳网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.douphp.com
 * --------------------------------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在遵守授权协议前提下对程序代码进行修改和使用；不允许对程序代码以任何形式任何目的的再发布。
 * 授权协议: http://www.douphp.com/license.html
 * --------------------------------------------------------------------------------------------------
 * Author: DouCo Co.,Ltd.
 * Release Date: 2023-01-13
 */
if (!defined('IN_DOUCO')) {
    die('Hacking attempt');
}
class File {
    var $file_dir; // 文件上传路径 结尾加斜杠
    var $full_file_dir; // 文件上传绝对路径
    var $thumb_dir; // 为空时默认跟主图在一个目录
    var $file_type; // 上传的类型，默认为：jpg gif png
    var $file_size_max; // 上传大小限制，单位是“KB”，默认为：2048KB
    var $quality; // 压缩图片质量
    
    /**
     * +----------------------------------------------------------
     * 构造函数
     * +----------------------------------------------------------
     * $file_dir 文件上传路径
     * $thumb_dir 缩略图路径
     * $file_type 上传文件类型
     * $file_size_max 上传最大限制单位KB
     * +----------------------------------------------------------
     */
    function __construct($file_dir = 'images/upload/', $thumb_dir = '', $file_type = 'jpg,jpeg,gif,png', $file_size_max = '2048', $quality = '100') {
        $this->file_dir = $file_dir; // 文件上传路径 结尾加斜杠
        $this->full_file_dir = ROOT_PATH . $file_dir; // 文件上传绝对路径
        if (!file_exists($this->full_file_dir)) mkdir($this->full_file_dir, 0777, true);
        $this->thumb_dir = $thumb_dir; // 缩略图路径（相对于$file_dir） 结尾加斜杠，留空则跟$file_dir相同
        $this->file_type = $file_type;
        $this->file_size_max = $file_size_max;
        $this->quality = $GLOBALS['_CFG']['quality'] ? $GLOBALS['_CFG']['quality'] : $quality;
    }
 
    // 构造函数.兼容PHP4
    function File($file_dir = 'images/upload/', $thumb_dir = '', $file_type = 'jpg,gif,png', $file_size_max = '2048', $quality = '100') {
        $this->__construct($file_dir, $thumb_dir, $file_type, $file_size_max, $quality);
    }
    
    /**
     * +----------------------------------------------------------
     * 文件上传与信息写入
     * +----------------------------------------------------------
     * $module 模块名称
     * $item_id 项目ID
     * $file_field 文件域
     * $type 文件类别
     * $custom_filename 自定义文件名
     * $thumb_width 缩略图宽度，只设置宽度或者高度，将会根据原始图片比例
     * $thumb_height 缩略图高度
     * $img_width 压缩图片宽度，只设置宽度或者高度，将会根据原始图片比例
     * $img_height 压缩图片高度
     * $img_watermark 压缩图片是否增加水印
     * $primary_key 主键
     * +----------------------------------------------------------
     */
    function box($module, $item_id, $file_field = 'image', $type = 'main', $custom_filename = '', $thumb_width = '', $thumb_height = '', $img_width = '', $watermark = '', $primary_key = 'id') {
        if ($_FILES[$file_field]['name'] != "") {
            // 在项目中判断是否已经存在文件编号，没有就生成一个
            if ($GLOBALS['dou']->field_exist($module, $file_field)) {
                $number = $GLOBALS['dou']->get_one("SELECT " . $file_field . " FROM " . $GLOBALS['dou']->table($module) . " WHERE $primary_key = '$item_id'");
            }
            $number = $number ? $number : $this->create_file_number();
            
            // 在文件库中判断是否存在文件编号
            if (!$GLOBALS['dou']->value_exist('file', 'number', $number)) {
                // 文件编号不存在则执行写入文件操作
                $file_name = $custom_filename ? $custom_filename : $this->create_file_name($item_id); // 创建一个随机不重复文件名
                $action = 'insert'; // 标注为写入操作
            } else {
                // 文件编号存在执行文件更新操作
                $file_address_from_sql = $GLOBALS['dou']->get_one("SELECT file FROM " . $GLOBALS['dou']->table('file') . " WHERE number = '$number'");
                $file_dir_from_sql = dirname($file_address_from_sql) . '/';
                $full_file_dir_from_sql = $file_dir_from_sql ? ROOT_PATH . $file_dir_from_sql : '';
                
                $file_name = $GLOBALS['dou']->get_file_name($file_address_from_sql);
                if (empty($file_name))
                    $file_name = $custom_filename ? $custom_filename : $this->create_file_name($item_id); // 空文件数据要随机生成一个文件名
                $action = 'update'; // 标注为升级操作
            }
         
            // 文件相对地址
            $file_dir = $file_dir_from_sql ? $file_dir_from_sql : $this->file_dir;
            $full_file_dir = $full_file_dir_from_sql ? $full_file_dir_from_sql : $this->full_file_dir;
            
            // 文件上传操作
            $full_file_name = $this->upload($file_field, $file_name, $full_file_dir, $type);
            
            // 压缩图片
            if ($img_width)
                $full_file_name = $this->resize($full_file_name, $img_width, '', '', '', $full_file_dir);
         
            // 判断是否给图片增加水印
            if ($watermark) {
                if (file_exists(ROOT_PATH . 'data/watermark.png')) {
                    $this->watermark($full_file_name, 'img', '', '#FFF', 12, '', '', '', $full_file_dir);
                } else {
                    $this->watermark($full_file_name, 'text', $watermark, '#FFF', 12, '', '', '', $full_file_dir);
                }
            }
            
            // 数据格式化
            $file = $file_dir . $full_file_name;
            clearstatcache(); // 获取文件大小前需要先清除文件状态缓存
            $size = filesize(ROOT_PATH . '/' . $file);
            $add_time = $action_time = time();
            
            // 缩略图
            if ($thumb_width || $thumb_height) {
                $thumb = $this->thumb($full_file_name, $thumb_width, $thumb_height, $full_file_dir);

                // 获取缩略图大小
                clearstatcache(); // 获取文件大小前需要先清除文件状态缓存
                $thumb_size = filesize($full_file_dir . $thumb);
            }
            $thumb_size = $thumb_size ? $thumb_size : 0;
            
            if ($action == 'insert') {
                // 写入文件数据
                $sql = "INSERT INTO " . $GLOBALS['dou']->table('file') . " (id, number, file, module, item_id, type, size, thumb_size, action_time, add_time)" . " VALUES (NULL, '$number', '$file', '$module', '$item_id', '$type', '$size', '$thumb_size', '$action_time',  '$add_time')";
            } elseif ($action == 'update') {
                // 更新文件数据
                $sql = "update " . $GLOBALS['dou']->table('file') . " SET file = '$file', size = '$size', thumb_size = '$thumb_size', action_time = '$action_time' WHERE number = '$number'";
             
                // 文件更新时间
                $GLOBALS['dou']->file_update_time();
            }
         
            // 执行SQL语句
            $GLOBALS['dou']->query($sql);
            
            return $number;
        }
    }
    
    /**
     * +----------------------------------------------------------
     * 图片上传的处理函数
     * +----------------------------------------------------------
     * $file_field 上传的图片域
     * $file_name 给上传的图片重命名
     * $file_dir 上传图片路径
     * +----------------------------------------------------------
     */
    function upload($file_field, $file_name = '', $full_file_dir = '', $type = 'main') {
        $full_file_dir = $full_file_dir ? $full_file_dir : $this->full_file_dir;
        
        if ($GLOBALS['dou']->check_read_write($full_file_dir) != 'write') {
            if ($type == 'content') {
                die($GLOBALS['_LANG']['file_dir_wrong']);
            } else {
                $GLOBALS['dou']->dou_msg($GLOBALS['_LANG']['file_dir_wrong']);
            }
        }
        
        // 没有命名规则默认以时间作为文件名
        if (empty($file_name))
            $file_name = $GLOBALS['dou']->create_rand_string('number', 6, time()); // 设定当前时间为图片名称
        
        if (@ empty($_FILES[$file_field]['name'])) {
            if ($type == 'content') {
                die($GLOBALS['_LANG']['file_empty']);
            } else {
                $GLOBALS['dou']->dou_msg($GLOBALS['_LANG']['file_empty']);
            }
        }

        $name = explode(".", $_FILES[$file_field]["name"]); // 将上传前的文件以“.”分开取得文件类型
        $img_count = count($name); // 获得截取的数量
        $img_type = $name[$img_count - 1]; // 取得文件的类型
        if (stripos($this->file_type, $img_type) === false) {
            if ($type == 'content') {
                die($GLOBALS['_LANG']['file_support'] . $this->file_type . $GLOBALS['_LANG']['file_support_no'] . $img_type);
            } else {
                $GLOBALS['dou']->dou_msg($GLOBALS['_LANG']['file_support'] . $this->file_type . $GLOBALS['_LANG']['file_support_no'] . $img_type);
            }
        }
        $full_file_name = $file_name . "." . $img_type; // 写入数据库的文件名
        $file_address = $full_file_dir . $full_file_name; // 上传后的文件名称
        $file_ok = move_uploaded_file($_FILES[$file_field]["tmp_name"], $file_address);
        if ($file_ok) {
            $img_size = $_FILES[$file_field]["size"];
            $img_size_kb = round($img_size / 1024);
            if ($img_size_kb > $this->file_size_max) {
                @unlink($file_address);
                if ($type == 'content') {
                    die($GLOBALS['_LANG']['file_out_size'] . $this->file_size_max . "KB");
                } else {
                    $GLOBALS['dou']->dou_msg($GLOBALS['_LANG']['file_out_size'] . $this->file_size_max . "KB");
                }
            } else {
                return $full_file_name;
            }
        } else {
            $GLOBALS['_LANG']['file_wrong'] = preg_replace('/d%/Ums', $this->file_size_max, $GLOBALS['_LANG']['file_wrong']);
            if ($type == 'content') {
                die($GLOBALS['_LANG']['file_wrong']);
            } else {
                $GLOBALS['dou']->dou_msg($GLOBALS['_LANG']['file_wrong']);
            }
        }
    }
 
    /**
     * +----------------------------------------------------------
     * 图片缩放
     * +----------------------------------------------------------
     * $src_file_name 原图片含扩展名文件名
     * $width 缩略图宽度
     * $height 缩略图高度
     * +----------------------------------------------------------
     */
    function thumb($src_file_name, $width = '128', $height = '128', $full_file_dir = '') {
        $full_file_dir = $full_file_dir ? $full_file_dir : $this->full_file_dir;
        
        $name = basename($src_file_name); // 不包含扩展名的文件名
        $ext = pathinfo($src_file_name, PATHINFO_EXTENSION); // 扩展名
        $thumb_name = substr($name, 0, strrpos($name, ".")) . "_thumb." . $ext;
     
        return $this->resize($src_file_name, $width, $height, $this->thumb_dir, $thumb_name, $full_file_dir);
    }
 
    /**
     * +----------------------------------------------------------
     * 图片缩放
     * +----------------------------------------------------------
     * $src_file_name 原图片含扩展名文件名
     * $width 缩略图宽度
     * $height 缩略图高度
     * $dst_path 目标目录，以斜杆结尾
     * $dst_file_name 目标文件名
     * +----------------------------------------------------------
     */
    function resize($src_file_name, $width = '', $height = '', $dst_path = '', $dst_file_name = '', $full_file_dir = '') {
        $full_file_dir = $full_file_dir ? $full_file_dir : $this->full_file_dir;
        
        $image = $full_file_dir . $src_file_name; // 获得图片源
        $img_info = $this->get_img_info($image); // 原图片参数
        if (!$dst_file_name)
            $dst_file_name = $src_file_name;
        
        // 创建一块画布，通过原图片文件或URL地址将图片载入画布
        if ($img_info["type"] == 1) {
            $src_image = imagecreatefromgif($image);
        } elseif ($img_info["type"] == 2) {
            $src_image = imagecreatefromjpeg($image);
        } elseif ($img_info["type"] == 3) {
            $src_image = imagecreatefrompng($image);
        } else {
            $src_image = "";
        }
        
        if (empty($src_image)) return false;
    
        // 目标图片宽度和高度可不设定，让其根据比例生成
        if (!$width && $img_info["width"] > $width) $width = ($img_info["width"] / $img_info["height"]) * $height;
        if (!$height) $height = ($img_info["height"] / $img_info["width"]) * $width;
        
        // 创建一块画布，将处理后的图片
        if (function_exists("imagecreatetruecolor")) {
            $dst_image = imagecreatetruecolor($width, $height);
            if ($img_info["type"] == 3) {
                imagealphablending($dst_image, false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
                imagesavealpha($dst_image, true);//这里很重要,意思是不要丢了$thumb图像的透明色;
            }
            ImageCopyResampled($dst_image, $src_image, 0, 0, 0, 0, $width, $height, $img_info["width"], $img_info["height"]);
        } else {
            $dst_image = imagecreate($width, $height);
            // 将一幅图片中的一块矩形区域拷贝到另一个图片中，$dst_image目标图片、$src_image原图片
            ImageCopyResized($dst_image, $src_image, 0, 0, 0, 0, $width, $height, $img_info["width"], $img_info["height"]);
        }
        
        if (file_exists($full_file_dir . $dst_path . $dst_file_name)) {
            @ unlink($full_file_dir . $dst_path . $dst_file_name);
        }
        
        // 以 JPEG 格式将图片输出到浏览器或文件
        if ($img_info["type"] == 3) {
            imagepng($dst_image, $full_file_dir . $dst_path . $dst_file_name); // php5.1以后quality改为0-9
        } else {
            ImageJPEG($dst_image, $full_file_dir . $dst_path . $dst_file_name, $this->quality);
        }
     
        // 释放与 image 关联的内存
        ImageDestroy($dst_image);
        ImageDestroy($src_image);
        
        return $dst_path . $dst_file_name;
    }
 
    /**
     * +----------------------------------------------------------
     * 添加水印
     * +----------------------------------------------------------
     * $src_file_name 原图片含扩展名文件名
     * $type 图片添加水印的方式，img代表以图片方式，text代表以文字方式添加水印
     * $watermark_value 水印值：图片路径或者文字
     * $dst_path 目标目录，以斜杆结尾
     * $dst_file_name 目标文件名
     * $text 给图片添加的水印文字
     * $text_color 水印文字的字体颜色
     * $font_size 水印文字大小
     * $font_file 具体的字体库，可带相对目录地址
     * +----------------------------------------------------------
     */
    function watermark($src_file_name, $type = 'img', $watermark_value = '', $text_color = '#FFF', $font_size = 12, $dst_path = '', $dst_file_name = '', $font_file = '', $full_file_dir = '') {
        $full_file_dir = $full_file_dir ? $full_file_dir : $this->full_file_dir;
        
        $font_file = $font_file ? $font_file : ROOT_PATH . 'data/simsun.ttf';
        $src_image = $full_file_dir . $src_file_name; // 获得图片源
        $src_info = @getimagesize($src_image);
        $src_image_width = $src_info[0];
        $src_image_height = $src_info[1];
        
        switch ($src_info[2]) {
            case 1:
                $src_img =imagecreatefromgif($src_image);
                break;
            case 2:
                $src_img =imagecreatefromjpeg($src_image);
                break;
            case 3:
                $src_img =imagecreatefrompng($src_image);
                break;
            default:
                die("不支持的图片文件类型");
                exit;
        }

        // 合成水印路径为空就覆盖原图
        if (!$dst_file_name)
            $dst_file_name = $src_file_name;

        if ($type == 'img') { // 图片水印
            $watermark_image = ROOT_PATH . 'data/watermark.png';
            if (!file_exists($watermark_image) || empty($watermark_image))
                return;

            $watermark_image_info = @getimagesize($watermark_image);
            $watermark_image_width  = $watermark_image_info[0];
            $watermark_image_height  = $watermark_image_info[1];

            if ($src_image_width < $watermark_image_width || $src_image_height < $watermark_image_height)
                return;

            switch ($watermark_image_info[2]) {
                case 1:
                    $watermark_img =imagecreatefromgif($watermark_image);
                    break;
                case 2:
                    $watermark_img =imagecreatefromjpeg($watermark_image);
                    break;
                case 3:
                    $watermark_img =imagecreatefrompng($watermark_image);
                    break;
                default:
                    die("不支持的水印图片文件类型");
                    exit;
            }

            $logo_width = $watermark_image_width;
            $logo_height = $watermark_image_height;
        } else { // $type == 'text' 文字水印
            $watermark_text = $watermark_value;

            $box = @imagettfbbox($font_size, 0, $font_file, $watermark_text);
            $logo_width = max($box[2], $box[4]) - min($box[0], $box[6]);
            $logo_height = max($box[1], $box[3]) - min($box[5], $box[7]);
        }

        $dst_img = @imagecreatetruecolor($src_image_width, $src_image_height);

        imagecopy($dst_img, $src_img, 0, 0, 0, 0, $src_image_width, $src_image_height);

        if ($type == 'img') { // 图片水印
            $x = $src_image_width - $logo_width - 10; // 文字所占区域左侧为基点
            $y = $src_image_height - $logo_height - 10; // 文字所占区域左上为基点
            imagecopy($dst_img, $watermark_img, $x, $y, 0, 0, $logo_width, $logo_height);
            imagedestroy($watermark_img);
        } else { // 文字水印
            $rgb = $this->hex2rgba($text_color, true);
            $color = imagecolorallocate($dst_img, $rgb[0], $rgb[1], $rgb[2]);
         
            $x = $src_image_width - $logo_width - 10; // 文字所占区域左侧为基点
            $y = $src_image_height - 10; // 文字所占区域左下为基点
            imagettftext($dst_img, $font_size, 0, $x+1, $y+1, '5592405', $font_file, $watermark_text); // 添加灰色投影
            imagettftext($dst_img, $font_size, 0, $x, $y, $color, $font_file, $watermark_text);
        }
        
        switch ($src_info[2]) {
            case 1:
                imagegif($dst_img, $full_file_dir . $dst_path . $dst_file_name);
                break;
            case 2:
                imagejpeg($dst_img, $full_file_dir . $dst_path . $dst_file_name);
                break;
            case 3:
                imagepng($dst_img, $full_file_dir . $dst_path . $dst_file_name);
                break;
            default:
                die("不支持的水印图片文件类型");
                exit;
        }

        imagedestroy($dst_img);
        imagedestroy($src_img);
     
        return $dst_path . $dst_file_name;
    }
    
    /**
     * +----------------------------------------------------------
     * 大文件分卷上传，最终以文件MD5值作为文件名，避免重复上传同一文件
     * +----------------------------------------------------------
     * $file_field 上传文件域
     * $blob_num 第几个文件块
     * $total_blob_num 文件块总数
     * $file_name 上传文件文件名
     * $file_md5_value 上传文件MD5值
     * $file_type 上传的类型
     * +----------------------------------------------------------
     */
    function bigfile($file_field, $blob_num, $total_blob_num, $file_name, $file_md5_value, $file_type = 'zip,rar') {
        // 验证获取的值
        $blob_num = $GLOBALS['check']->is_number($blob_num) ? $blob_num : exit;
        $total_blob_num = $GLOBALS['check']->is_number($total_blob_num) ? $total_blob_num : exit;
        $file_md5_value = preg_match("/^[A-Za-z0-9]+$/", $file_md5_value) ? $file_md5_value : exit;
     
        $name = explode(".", $file_name); // 将上传前的文件以“.”分开取得文件类型
        $img_count = count($name); // 获得截取的数量
        $img_type = $name[$img_count - 1]; // 取得文件的类型
        if (stripos($file_type, $img_type) === false) {
            exit;
        }
        
        // 有些服务器会不支持 pathinfo 导致程序错误，由于是程序错误，所以在ajax执行时并不会提示
        $big_file_name = $file_md5_value . '.' . substr(strrchr($file_name, '.'), 1);
        
        // 移动文件
        move_uploaded_file($_FILES[$file_field]['tmp_name'], $this->full_file_dir . $big_file_name . '__' . $blob_num);

        // 判断是否是最后一块，如果是则进行文件合成并且删除文件块
        if ($blob_num == $total_blob_num) {
            $fp = fopen($this->full_file_dir . $big_file_name, 'w+');
            for ($i = 1; $i <= $total_blob_num; $i++) {
                fwrite($fp, file_get_contents($this->full_file_dir . $big_file_name . '__' . $i));
            }
            fclose($fp);

            // 删除文件块
            for ($i = 1; $i <= $total_blob_num; $i++) {
                @unlink($this->full_file_dir . $big_file_name . '__' . $i);
            }
        }

        if ($blob_num == $total_blob_num) {
            if (file_exists($this->full_file_dir . $big_file_name)) {
                $data['code']      = 2;
                $data['msg']       = 'success';
                $data['file_path'] = ROOT_URL . $this->file_dir . $big_file_name;
            }
        } else {
            if (file_exists($this->full_file_dir . $big_file_name . '__' . $blob_num)) {
                $data['code']      = 1;
                $data['msg']       = 'waiting';
                $data['file_path'] = '';
            }
        }
        
        header('Content-type: application/json');
        echo json_encode($data);
    }
 
    /**
     * +----------------------------------------------------------
     * 创建一个随机且不重复的文件编号
     * +----------------------------------------------------------
     * $length 长度
     * +----------------------------------------------------------
     */
    function create_file_number($length = 7) {
        // 字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyz123456789';

        $number = '';
        for ( $i = 0; $i < $length; $i++ ) {
            $number .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        $number = $number . '.file';

        if ($GLOBALS['dou']->value_exist('file', 'number', $number)) {
            $this->create_file_number();
        } else {
            return $number;
        }
    }

    /**
     * +----------------------------------------------------------
     * 创建一个随机不重复的文件名
     * +----------------------------------------------------------
     * $item_id 项目ID
     * +----------------------------------------------------------
     */
    function create_file_name($item_id) {
        $file_name = $item_id . '_' . $GLOBALS['dou']->create_rand_string('number', 6, time());
        $value_exist = $GLOBALS['dou']->get_one("SELECT id FROM " . $GLOBALS['dou']->table('file') . " WHERE file LIKE '%$file_name%'");
     
        if ($value_exist) {
            $this->create_file_name();
        } else {
            return $file_name;
        }
    }
    
    /**
     * +----------------------------------------------------------
     * 获取上传图片信息
     * +----------------------------------------------------------
     * $image 原始图片地址
     * +----------------------------------------------------------
     */
    function get_img_info($image) {
        $image_size = getimagesize($image);
        $img_info["width"] = $image_size[0];
        $img_info["height"] = $image_size[1];
        $img_info["type"] = $image_size[2];
        $img_info["name"] = basename($image);
        $img_info["ext"] = pathinfo($image, PATHINFO_EXTENSION);
        
        return $img_info;
    }
 
    /**
     * +----------------------------------------------------------
     * 十六进制颜色转为RGB颜色值
     * +----------------------------------------------------------
     */
    function hex2rgba($color, $raw = false) {
        $default = 'rgb(0,0,0)';
        
        if (empty($color))
            return $default; 
        
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
        
        if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif (strlen($color) == 3) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }
 
        $rgb = array_map('hexdec', $hex);
 
        if ($raw) {
            $output = $rgb;
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
 
        return $output;
    }
}

?>