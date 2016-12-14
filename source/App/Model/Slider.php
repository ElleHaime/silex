<?php 

namespace App\Model;

use Silex\Application,
	Library\BaseModel;


class Slider extends BaseModel
{
	static $table_name = 'slider';
	
	public function getSlider()
	{
		$result = [];
		
		$slider = $this -> getAll(['order' => ['column' => 'sort_order']]);
		if (!empty($slider)) {
			foreach($slider as $slide) {
				if (file_exists(IMG_PATH . 'slider/' . $slide -> image)) $result[] = $slide;
			}
		} else {
			#TODO: default slider image in generic settings
			$result[] = ['image' => IMG_PATH . 'breaking_bad.jpg'];
		}
		
		return $result;
	}
	
	public function changePrioity()
	{
		
	}
	
}
