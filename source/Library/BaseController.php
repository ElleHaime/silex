<?php 

namespace Library;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	App\Model\Event,
	App\Model\Contact,
	Library\Utils\Misc as _U;
	

class BaseController
{
	use \Library\Traits\SidePanel;
	
	public $renderBarch		= [];
	public $errors			= false;
	public $baseModel		= false;
	
	
	public function __construct()
	{
		$this -> renderBatch['settings']['section'] = [];
	}
	
	
	public function loadWrapper(Application $app)
	{
		$this -> loadSidePanel($app);
		
		$contacts = new \stdClass();
		$cRaw = Contact::find('all');
		
		if (!empty($cRaw)) {
			foreach ($cRaw as $key => $value) {
				$cType = $value -> type; 
				if (!isset($contacts -> $cType)) {
					$contacts -> $cType = new \stdClass();
				}			
				$cSubtype = $value -> subtype;
				if (!empty($cSubtype) && !isset($contacts -> $cSubtype)) {
					$contacts -> $cType -> $cSubtype = $value -> value;
				} elseif (empty($cSubtype)) {
					$contacts -> $cType = $value -> value;
				}
			}
		}

		$this -> renderBatch['contacts'] = $contacts;
		$this -> renderBatch['settings']['host_name'] = $_SERVER['HTTP_HOST'];
	}
	
	
	public function getFormErrors(\Symfony\Component\Form\Form $form)
	{
		$errors = [];
		
		foreach ($form -> getIterator() as $key => $child) {
			foreach ($child -> getErrors() as $error) {
				$errors[$key] = $error -> getMessage();
			}
		}
		
		return $errors;
	}
	
	
	public function index(Application $app)
	{
		$model = (new $this -> baseModel) -> setApp($app);
		
		$this -> renderBatch['list'] = $model::find('all', ['order' => 'id']);
		return $app['twig'] -> render('protected/' . $model -> getSource() . '/list.twig', $this -> renderBatch);
	}
	
	
	public function delete(Application $app, Request $request)
	{
		$result = ['state' => 'OK', 'ids' => [], 'errors' => []];
		$data = json_decode($request -> getContent(), true);
// 		$data = ['ids' => [3]];
		if (!empty($data)) {
			$model = (new $this -> baseModel) -> setApp($app);
			
			if ($killData = $model -> fullDelete($data['ids'])) {
				$result['ids'] = $data['ids'];
			} else {
				$result['state'] = 'FAIL';
				$result['errors'] = $model -> errors;
			}
		}
		return $app -> json($result, 200, array('Content-Type' => 'application/json'));
	}
	
	
	public function updateStatus(Application $app, Request $request)
	{
		$result = ['state' => 'OK', 'ids' => [], 'errors' => []];
		$data = json_decode($request -> getContent(), true);
	
		if (!empty($data)) {
			$model = (new $this -> baseModel) -> setApp($app);
			
			if ($upData = $model -> updateStatus($data['ids'], $data['newStatus'])) {
				$result['ids'] = $data['ids'];
			} else {
				$result['state'] = 'FAIL';
				$result['errors'] = $model -> errors;
			}
		}
		return $app -> json($result, 200, array('Content-Type' => 'application/json'));
	}
}