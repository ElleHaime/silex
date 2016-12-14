<?php 

namespace Library;

use Silex\Application,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
	Library\Utils\Misc as _U,
	ActiveRecord\Errors as ArErrors,
	ActiveRecord\Model as ArModel;

abstract class BaseModel extends ArModel
{
	const STATUS_ENTITY_ACTIVE 		= 1;
	const STATUS_ENTITY_INACTIVE 	= 0;

	public $errors	= [];
	protected $app		= false;
	protected $source	= false;
	
	
	public function setApp(Application $app)
	{
		$this -> app = $app;
		$this -> initSource();
		
		return $this;
	}
	
	
	public function initSource()
	{
		$className = (new \ReflectionClass($this)) -> getShortName();
		$this -> source = strtolower($className);
		self::$table_name = $this -> source;
	}

	
	public function getAll(array $params = [])
	{
		$orderCondColumn = '';
		$orderCondOrder = '';
		$limitCondNumber = '';
		
		$query = $this -> app['db'] -> createQueryBuilder()
									-> select('*')
									-> from($this -> source);
		
		if (isset($params['order'])) {
			isset($params['order']['column']) ? $orderCondColumn = $this -> source . '.' . $params['order']['column']
											   : $orderCondColumn = $this -> source . '.id';
			isset($params['order']['sort']) ? $orderCondOrder = $params['order']['sort'] : $orderCondOrder = 'ASC';

			$query -> addOrderBy($orderCondColumn, $orderCondOrder);
		}
		
		if (isset($params['limit'])) {
			isset($params['limit']['number']) ? $limitCondNumber = $params['limit']['number'] : $limitCondNumber = 10;
			$query -> setMaxResults($limitCondNumber);
		}
		
		$data = $this -> app['db'] -> executeQuery($query) -> fetchAll(\PDO::FETCH_OBJ);
		
		return $data;
	}
	
	
	public function updateStatus(array $id, $status = 1)
	{
		if (!empty($id)) {
			try {
				$attributes = ['status' => $status];
				self::table() -> update($attributes, ['id' => $id]);
				return true;
			} catch (\Exception $e) {
				$this -> errors -> add('updateStatus', $e -> getMessage());
				return false;
			}
		}
	
		return true;
	}
	
	
	public function getErros()
	{
		return $this -> errors;
	}
	
	
	public function getSource()
	{
		return $this -> source;
	}
	
	
	
	public function genFileName($image, $fileName = false)
	{
		if (!$fileName) {
			$fileName = _I::genFilename($image -> guessExtension());
		}
		return $fileName;
	}
}
