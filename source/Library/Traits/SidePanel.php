<?php 

namespace Library\Traits;

use Silex\Application,
	App\Model\Event,
	App\Model\Slider,
	Library\Utils\Misc as _U;
	

trait SidePanel
{
	public function loadSidePanel(\Silex\Application $app)
	{
		$events = (new Event()) -> setApp($app) -> getEventRange();
		if (!empty($events)) $this -> renderBatch['events'] = $events;
	}
}