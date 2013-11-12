<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Super
 *
 * This is validate api device info
 *
 * @package application
 * @subpackage libraries
 * @author htian(htian@suzhoukada.com)
 */


class P2i_device {

    //devide_code, {0-iphone4,1-iphone5,2-android,3-,4-ipad,5-android pad,6-desktop}
    CONST DESKTOP=0;
    public static $devices = array(
       self::DESKTOP=>array("width"=>800, "height"=>600, "max_width"=>2560, "max_height"=>1600, "screen_width"=>1280, "screen_height"=>800, "max_screen_width"=>2560, "max_screen_height"=>1600, "show_flash"=>true, "user_agent"=>"", "is_desktop"=>true),
    );

    public static function fm_size($size_str, $screen_str, $fullpage=false)
    {
        $is_mobile = false;
        $is_tablet = false;
        $is_desktop = false;

        $device_more_arr = array("is_mobile", "is_tablet", "is_desktop");
        $device =  P2i_device::$devices[self::DESKTOP];

        extract($device);
        if(!empty($size_str) && strpos($size_str,'x') !== false){
            list($w, $h) = explode('x', $size_str);
            $width = is_numeric($w) ? $w : $width;
            $height = is_numeric($h) ? $h : $height;
            $width = min($width, $max_width);
            $height = min($height, $max_height);
        }

        if(!empty($screen_str) && strpos($screen_str,'x') !== false){
            list($w, $h) = explode('x', strtolower($screen_str));
            $screen_width = ($w && is_numeric($w)) ? $w : $screen_width;
            $screen_height = ($h && is_numeric($h)) ? $h : $screen_height;
            $screen_width = min($screen_width, $max_screen_width);
            $screen_height = min($screen_height, $max_screen_height);
        }

        $width = min($width, $screen_width);
        $height = min($height, $screen_height);

        if($fullpage){
            $height = 0;
        }
        return (object)compact($device_more_arr, array_keys($device));
    }

    public static function size_limit($is_limit, $device){
        $device = (array)$device;
        extract($device);
        if($is_limit){
            $width = min($width, 320);
            $height = min($height, 480);
        }
        return (object)compact(array_keys($device));
    }
}
?>