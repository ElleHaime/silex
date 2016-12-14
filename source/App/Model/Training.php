<?php 

namespace App\Model;

use Silex\Application,
	Library\BaseModel,
	App\Model\TrainingImage,
	App\Model\Event,
	Library\Utils\Misc as _U;


class Training extends BaseModel
{
	static $table_name = 'training';
	static $has_many = [
		['training_image', 'foreign_key' => 'training_id', 'class_name' => '\App\Model\TrainingImage'],
		['event', 'foreign_key' => 'training_id', 'class_name' => '\App\Model\Event']
	];
	

	public function fullDelete(array $id)
	{
		$posts = self::find('all', ['conditions' => ['id in (?)', $id]]);

		if ($posts) {
			foreach ($posts as $post) {
				$post -> deleteImages();
				$post -> deleteEvents();
			}
	
			try {
				self::table() -> delete(['id' => $id]);
				return true;
			} catch (\Exception $e) {
				$this -> errors -> add('killData', $e -> getMessage());
				return false;
			}
		}
		
		return;
	}
	
	
	public function deleteImages()
	{
		$images = $this -> training_image;

		if (!empty($images)) {
			foreach ($images as $img) {
				$img -> fullDelete();
			}
		}
		
		return $this;
	}
	
	
	public function deleteEvents()
	{
		$events = $this -> event;
		if (!empty($events)) {
			foreach ($events as $event) {
				$event -> fullDelete();
			}
		}
		
		return $this;
	}
	
	
	public function getShortList(array $params = [])
	{
		$query = $this -> app['db'] -> createQueryBuilder()
									-> select('training.id AS id,
												training.name AS name,
												training.url_name AS url_name,
												training.intro AS intro,
												training.id AS training_id,
												training.flag_new AS flag_new,
												image.image AS image,
												image.alter_text AS image_alter_text')
									-> from('training', 'training')
									-> leftJoin('training', 'training_image', 'image', 'training.id = image.training_id
									 									AND image.type = "header_small"');
		
		$data = $this -> app['db'] -> executeQuery($query) -> fetchAll(\PDO::FETCH_OBJ);
		
		return $data;
	}
	
	
	public function getTrainingByName($trainingName)
	{
		$data = self::find('first', ['conditions' => ['url_name = "' . trim($trainingName) . '"', 'limit' => 1]]);
		
		return $data;
	}
}
