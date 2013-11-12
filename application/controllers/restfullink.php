<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Super API_Controller
 *
 * @package application
 * @subpackage controllers
 * @author htian(htian@suzhoukada.com)
 */
class RestfulLink extends API_Controller {

	/**
	 * get restful link return data
	 *
	 * @param dict $_REQUEST http request data.
	 * @return json the result of restfullink as:
	 * finished result: {"status":"finished", "image_url":"http://api.page2images.com/images/00/00/10923423.jpg", "duration":"32", "left_calls":"923023"}
	 */
	public function index()
	{
		header("Access-Control-Allow-Origin:*");
		$start_time = time();
		$p2ipara = $this->p2i_para->format_request($_REQUEST, 1);
		$path = $p2ipara->image_path;
		$is_file_existed = file_exists($path);
		if(empty($is_file_existed) OR $p2ipara->refresh){
			$p2icmd =  $this->p2i_command->get($p2ipara);
			@shell_exec($p2icmd);
			@chmod($path, FILE_WRITE_MODE);
			$this->resize_image($p2ipara, false);
		}

		$result_arr = array(
			"image_url"=> urlencode(site_url($p2ipara->image_web_path)),
			"duration"=> time()-$start_time
		);

		echo urldecode(json_encode($result_arr));
	}
}

/* End of file restfullink.php */
/* Location: ./application/controllers/restfullink.php */
