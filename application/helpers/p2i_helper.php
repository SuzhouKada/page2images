<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('get_name_from_path')){
    /**
     * get name from path
     *
     * @param string $path
     * @access public
     * @return string file name
     */
    function get_name_from_path($path){
        return str_replace('/', '', mb_substr($path, strrpos($path, '/')));
    }
}