<?php 

namespace App\Model;

use Silex\Application,
	Library\BaseModel,
	Library\Utils\Misc as _U,
	Library\Utils\Image as _I;


class News extends BaseModel
{
	const SETTINGS_LIMIT_NAME 		= 'homepage_news_limit';
	static $table_name = 'news';

	
	public function saveLogo($logo, $fileName = false)
	{
		if (!$fileName) $fileName = $this -> genFileName($logo);
		$path = $this -> app['appConfig'] -> upload -> newsPath;
		
		try {
			$logo -> move($path, $fileName);
			chmod($path . $fileName, 0755);
			return true;
			
		} catch(\Exception $e) {
			$this -> errors -> add('logo', $e -> getMessage()); 
			return false; 
		}
	}
	
	
	public function deleteLogo($logo)
	{
		if (file_exists($this -> app['appConfig'] -> upload -> newsPath . $logo)) {
			@unlink($this -> app['appConfig'] -> upload -> newsPath . $logo);
		}
		
		return $this;
	}
	
	
	public function fullDelete(array $id)
	{
		$posts = self::find('all', ['conditions' => ['id in (?) and logo is not null', $id]]);
	
		if ($posts) {
			foreach ($posts as $post) {
				if (file_exists($this -> app['appConfig'] -> upload -> newsPath . $post -> logo)) {
					@unlink($this -> app['appConfig'] -> upload -> newsPath . $post -> logo);
				}
			}
		}
		
		try {
			self::table() -> delete(['id' => $id]);
			return true;
		} catch (\Exception $e) {
			$this -> errors -> add('killData', $e -> getMessage());
			return false;
		}
	}
}