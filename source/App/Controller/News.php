<?php 

namespace App\Controller;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	App\Model\Event,
	App\Model\News as NewsModel,
	Library\BaseController,
	Library\Utils\Misc as _U;


class News extends BaseController implements ControllerProviderInterface
{
	public $section 		= 'news';
	
	
	public function __construct()
	{
		$this -> renderBatch['settings']['section'] = $this -> section;
		$this -> renderBatch['settings']['navigation'] = [['url' => '/news', 'title' => 'Новости']];
	}
	
	
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];
		$factory -> get('/', 'App\Controller\News::index') -> bind('news');
		$factory -> get('/{postId}', 'App\Controller\News::showPost');
	
		return $factory;
	}
	
	
	public function index(Application $app)
	{
		$this -> loadWrapper($app);
		$this -> renderBatch['news'] = NewsModel::find('all', ['order' => 'id desc']);
		
		return $app['twig'] -> render('news/index.twig', $this -> renderBatch);
	}
	
	
	public function showPost(Application $app, Request $request, $postId)
	{
		$this -> loadWrapper($app);
	
		if ($post = NewsModel::find((int)$postId)) {
			$this -> renderBatch['post'] = $post;

			if (empty($post -> title)) {
				$navTitle = date('d/m', strtotime($post -> date_posted)); 
			} else {
				$navTitle = $post -> title;
			}
			$this -> renderBatch['settings']['navigation'][] = ['url' => $request -> getRequestUri(), 'title' => $navTitle];
				
			return $app['twig'] -> render('news/post.twig', $this -> renderBatch);
		} else {
			#oooooops, no such trainings
		}
	}
}