<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Super CI_Controller
 *
 * This is api.
 *
 * @package application
 * @subpackage core
 * @author htian(htian@suzhoukada.com)
 */
class API_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}


	/**
	 * use _imageSizePara data
	 *
	 * @param string $path image path
	 *		Apipara $p2ipara
	 *		string $type 'json' or 'image'
	 * @access public
	 */
	function resize_image($p2ipara, $show_image=True){
		$path = $p2ipara->image_path;
		$is_file_existed = file_exists($path);
		if(empty($is_file_existed)){
			exit();
		}

		$screen_width = $p2ipara->p2i_device->screen_width;
		$screen_height = $p2ipara->p2i_device->screen_height;
		$width = $p2ipara->p2i_device->width;
		$height = $p2ipara->p2i_device->height;

		$img = $this->image_moo->load($path);
		if(empty($p2ipara->fullpage) && empty($width))
		{
			$min_w = min($screen_width, $img->width);
			$min_h = min($screen_height, $img->height);
			$img->crop(0,0, $min_w, $min_h);
			$img->save($path, true);
		}
		else
		{
			if($screen_width < $img->width)
			{
				 $img->crop(0,0, $p2ipara->screen_w,  $img->height);
				 $img->save($path, true);
			}
		}

		$img = $this->image_moo->load($path);
		$target_size_w = $width;
		$target_size_h = $height;
		if($width!=0 && $height!=0)
		{
			//do nothing
		}
		else if($width!=0 && $height==0){
			if($width < $img->width)
			{
				$target_size_h = ($width/$img->width)*$img->height;
			}else{

				$target_size_h = $img->height;
			}
		}
		else if($width==0 && $height!=0){
			if($height < $img->height)
			{
				$target_size_w = ($height/$img->height)*$img->width;
			}else{

				$target_size_w = $img->width;
			}
		}
		else if($width==0 && $height==0)
		{
			$target_size_w = $img->width;
			$target_size_h = $img->height;
		}

		if($target_size_w > 800*15)
		{
			$target_size_w = 800*15;
		}

		if($target_size_h > 800*15)
		{
			$target_size_h = 800*15;
		}
		$img->resize($target_size_w,$target_size_h, true);
		$img->save($path, true);

		$img = $this->image_moo->load($path);
		if($show_image){
			$img->save_dynamic(get_name_from_path($path));
		}
	}
}
