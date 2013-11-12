<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Super
 *
 * This is for generate cutycapt command string
 *
 * @package application
 * @subpackage libraries
 * @author htian(htian@suzhoukada.com)
 */
class P2i_command {

    /**
     * generate cutycapt string by ApiPara
     *
     * @param Apipara $p2ipara
     * @param string $folder
     * @access public
     * @return string
     */
    function get($p2ipara){
    	$baseCommand = P2I_COMMAND;
        if($p2ipara->url){
            $baseCommand .= ' --url="'.$p2ipara->url.'"';
        }

        $baseCommand .= " --out={$p2ipara->image_path}";

        if($p2ipara->p2i_device->screen_width){
            $baseCommand .= ' --min-width='.$p2ipara->p2i_device->screen_width;
        }

        if($p2ipara->p2i_device->screen_height){
            $baseCommand .= ' --min-height='.$p2ipara->p2i_device->screen_height;
        }

        if($p2ipara->delay){
            $baseCommand .= ' --delay='.$p2ipara->delay*1000;
        }

        if($p2ipara->p2i_device->screen_width && $p2ipara->p2i_device->screen_height){
            $baseCommand .= ' --header=X_SCREEN_DIMENSIONS:'.$p2ipara->p2i_device->screen_width.'x'.$p2ipara->p2i_device->screen_height;
        }

        if($p2ipara->p2i_device->show_flash){
            $baseCommand .= ' --plugins=on';
        }

        return $baseCommand;
    }
}

?>