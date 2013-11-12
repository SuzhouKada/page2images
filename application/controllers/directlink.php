<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Super API_Controller
 *
 * @package application
 * @subpackage controllers
 * @author htian(htian@suzhoukada.com)
 */
class Directlink extends API_Controller {

    /**
     * get direct link return data
     *
     * @param dict $_REQUEST http request data.
     * @return image files
     */
    public function index()
    {
        //format request value
        $p2ipara = $this->p2i_para->format_request($_REQUEST);
        $path = $p2ipara->image_path;
    	$is_file_existed = file_exists($path);
		if($is_file_existed && empty($p2ipara->refresh)){
			$this->image_moo->load($path)
				->save_dynamic(get_name_from_path($path));
		} else {
			$p2icmd =  $this->p2i_command->get($p2ipara);
			@shell_exec($p2icmd);
			@chmod($path, FILE_WRITE_MODE);
			$this->resize_image($p2ipara);
		}
    }
}

/* End of file directlink.php */
/* Location: ./application/controllers/directlink.php */
