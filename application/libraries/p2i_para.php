<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Super
 *
 * This is for format api parameters
 *
 * @package application
 * @subpackage libraries
 * @author htian(htian@suzhoukada.com)
 */
class P2i_para {

    public function __construct()
    {
        //add CI model to this class
        $this->CI =& get_instance();
    }

    /**
     * format $request to ApiPara object
     *
     * @param dict $request
     * @param int $call_type, 0-direct, 1=restful
     * @access public
     * @return void
     */
    function format_request($request, $call_type=0){
        $request_str = '&'.http_build_query($request);
        $arr = array();

        //parameters with 'p2i_' are p2i's parameters
        foreach (explode("&p2i_", $request_str) as $item){
            if ( ! $item){
                continue;
            }
            $epos = stripos($item, '=');
            $key =mb_substr($item, 0, $epos);
            $value = urldecode(mb_substr($item, $epos+1));
            $arr[$key] = $value;
        }

        ksort($arr);
        $url = urldecode($this->get_key_val($arr, 'url', ''));
        $size = $this->get_key_val($arr, 'size');
        $screen = $this->get_key_val($arr, 'screen');
        $fullpage = $this->get_key_val($arr, 'fullpage', false)?true:false;
        $imageformat = $this->get_key_val($arr, 'imageformat', 'png');
        $delay = $this->get_key_val($arr, 'wait', 0);
        $refresh = $this->get_key_val($arr, 'refresh', false);

        $this->CI->load->library('P2i_device');
        $p2i_device = P2i_device::fm_size($size, $screen, $fullpage);
        $api_arr = compact('url','p2i_device','fullpage','delay','refresh');

        $url = preg_replace('/\W/','',$url);
        $file_name = urlencode("{$url}{$size}{$screen}.{$imageformat}");
        $api_arr['image_path'] = P2I_FILE_PATH.$file_name;
        $api_arr['image_web_path'] = P2I_FILE_WEBPATH.$file_name;
        return (object)$api_arr;
    }

    /**
     * get value by key from array
     *
     * @param array $arr
     * @param string $key
     * @param string $default
     * @access private
     * @return string
     */
    private function get_key_val($arr, $key, $default=null){
        if (array_key_exists($key, $arr)){
            return $arr[$key];
        } else {
            return $default;
        }
    }
}

?>