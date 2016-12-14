<?php 

namespace App\Controller;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	App\Model\Event,
	App\Model\News,
	App\Model\TrainingImage,
	App\Model\Training as TrainingModel,
	Library\BaseController,
	Library\Utils\Misc as _U;


class Training extends BaseController implements ControllerProviderInterface
{
	public $section 		= 'training';
	
	
	public function __construct()
	{
		$this -> renderBatch['settings']['section'] = $this -> section;
		$this -> renderBatch['settings']['navigation'] = [['url' => '/training', 'title' => 'Тренинги']];
	}
	
	
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];
	
		$factory -> get('/', 'App\Controller\Training::index');
		$factory -> get('/{trainingName}', 'App\Controller\Training::showTraining');
	
		return $factory;
	}
	
	
	public function index(Application $app)
	{
		$this -> loadWrapper($app);
		
		$this -> renderBatch['trainings'] = (new TrainingModel()) -> setApp($app) -> getShortList(['limit' => ['number' => 12]]);
		
		return $app['twig'] -> render('training/index.twig', $this -> renderBatch);
	}

	
	public function showTraining(Application $app, Request $request, $trainingName)
	{
		$this -> loadWrapper($app);

		if ($training = (new TrainingModel()) -> setApp($app) -> getTrainingByName(trim($trainingName))) {
			$this -> renderBatch['training'] = $training;
			$this -> renderBatch['training_image'] = $training -> training_image;
			$this -> renderBatch['nearestEvent'] = (new Event()) -> setApp($app) -> getNearestById($training -> id);
			$this -> renderBatch['settings']['navigation'][] = ['url' => $request -> getRequestUri(), 'title' => $training -> name];
			
			return $app['twig'] -> render('training/training.twig', $this -> renderBatch);			
		} else {
			#oooooops, no such trainings			
		}
	}
}