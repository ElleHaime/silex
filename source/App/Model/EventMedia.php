<?php 

namespace App\Model;

use Silex\Application,
	Library\BaseModel,
	Library\Utils\Misc as _U;


class EventMedia extends BaseModel
{
	static $table_name = 'event_media';
		
	
	public function getMedia($eventId, $mediaType)
	{
		$query = $this -> app['db'] -> createQueryBuilder()
									-> select('*')
									-> from('event_media')
									-> where('event_id = :eventId')
									-> andWhere('media_type = :mediaType')
									-> setParameter('eventId', (int)$eventId)
									-> setParameter('mediaType', $mediaType);
		$data = $query -> execute() -> fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, '\App\Model\EventMedia', [$this -> app]);
		
		return $data;
	}
}
