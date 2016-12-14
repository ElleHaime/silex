<?php 

namespace App\Model;

use Silex\Application,
	Library\BaseModel,
	Library\Utils\Misc as _U,
	Library\Utils\Image as _I;


class TrainingImage extends BaseModel
{
	static $table_name = 'training_image';
	static $belongs_to = [
		['training', 'foreign_key' => 'training_id', 'class_name' => '\App\Model\Training']
	];
	
	
	public function fullDelete()
	{
		return;
	}
	
	
	public function saveImage($image, $trainingUrl, $fileName = false, $type = NULL)
	{
		if (!$fileName) $fileName = $this -> genFileName($image);
		$path = $this -> app['appConfig'] -> upload -> trainingPath . $trainingUrl;
		
		try {
			// save to filesystem
			$image -> move($path, $fileName);
			chmod($path . $fileName, 0755);
			
			// save to database
			$data = ['training_id' => $trainingId,
					 'image' => $filename,
					 'type' => $type];  
			self::create($data);
			
			return $filename;
				
		} catch(\Exception $e) {
			$this -> errors -> add('image', $e -> getMessage());
			return false;
		}
	}
	
	
	public function getImages($trainingId)
	{
		$query = $this -> app['db'] -> createQueryBuilder()
									-> select('*')
									-> from('training_image')
									-> where('training_id = :trainingId')
									-> setParameter('trainingId', (int)$trainingId);
		$data = $query -> execute() -> fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, '\App\Model\TrainingImage', [$this -> app]);
		
		return $data;
	}
}