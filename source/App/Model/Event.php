<?php 

namespace App\Model;

use Silex\Application,
	Library\BaseModel,
	App\Model\EventMedia,
	Library\Utils\Misc as _U;


class Event extends BaseModel
{	
	static $table_name = 'event';
	static $belongs_to = [
		['training', 'foreign_key' => 'training_id', 'class_name' => '\App\Model\Training']
	];
	static $has_many = [
		['event_media', 'foreign_key' => 'event_id', 'class_name' => '\App\Model\EventMedia'],
	];
	
	
	
	public function fullDelete()
	{
		return;
	}
	
	
	public function getEventRange($startRange = false, $endRange = false)
	{
		//!$startRange ? $startDateCondition = date('Y-m-d H:i:s', strtotime('first day of this month midnight'))
		!$startRange ? $startDateCondition = date('Y-m-d H:i:s')
					 : $startDateCondition = date('Y-m-d H:i:s', strtotime($startRange));
		if ($endRange) {
			$endDateCondition = date('Y-m-d H:i:s', strtotime($endRange));
		}

		$query = $this -> app['db'] -> createQueryBuilder()
							 -> select('event.start_date AS start_date, 
							 			event.end_date AS end_date, 
							 			training.name AS name, 
							 			training.url_name AS url_name,
							 			training.intro AS intro,
							 			training.id AS training_id,
							 			training.flag_new AS flag_new,
							 			image.image AS image,
							 			image.alter_text AS image_alter_text')
							 -> from('event', 'event')
 							 -> innerJoin('event', 'training', 'training', 'event.training_id = training.id')
							 -> leftJoin('event', 'training_image', 'image', 'event.training_id = image.training_id
							 														AND image.type = "header_big"');
		if ($endRange) {
			$query -> where('event.start_date > "' . $startDateCondition . '" AND event.start_date < "' . $endDateCondition . '"')
 				   -> orWhere('event.end_date > "' . $startDateCondition . '" AND event.end_date < "' . $endDateCondition . '"');
		} else {
			$query -> where('event.start_date > "' . $startDateCondition . '"')
				   -> orWhere('event.end_date > "' . $startDateCondition . '"');
		}
		$query -> andWhere('event.status = ' . parent::STATUS_ENTITY_ACTIVE)
 			   -> addOrderBy('event.start_date');
			
		$data = $this -> app['db'] -> executeQuery($query) -> fetchAll(\PDO::FETCH_OBJ);

		if (!empty($data)) {
# TODO: add post/future flag for range by date
		}
		
		return $data;
	}
	
	
	public function getNearestById($training_id)
	{
		$data = self::find('first', ['conditions' => ['training_id = ' . $training_id . ' AND start_date > CURDATE()']]);
		
		return $data;

	}
	
	
	public function getAllMedia()
	{
		// find_by_sql
		$query = $this -> app['db'] -> createQueryBuilder()
							 -> select('event.id AS event_id,
							 			event.start_date AS start_date,
							 			event.logo AS logo,
							 			media.media_type AS media_type,
										training.name AS name,
										training.url_name AS url_name,
										count(media.id) AS media_count')
							 -> from('event', 'event')
							 -> innerJoin('event', 'training', 'training', 'event.training_id = training.id')
							 -> leftJoin('event', 'event_media', 'media', 'event.id = media.event_id')
							 -> groupBy('event.id')
							 -> orderBy('event.start_date', 'DESC');
		$data = $this -> app['db'] -> executeQuery($query) -> fetchAll(\PDO::FETCH_OBJ);

		return $data;
	}
	
	
	public function getEventMedia($eventId, $mediaType = 'image')
	{
		$data = self::first(['joins' => ['training', 'event_media']]);
	
		return $data;
	}
	
	
	public function getMedia($eventId, $mediaType)
	{
		$media = (new EventMedia()) -> setApp($this -> app) -> getMedia($eventId, $mediaType);
	
		return $media;
	}
}
