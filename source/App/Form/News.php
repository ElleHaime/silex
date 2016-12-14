<?php 

namespace App\Form;

use Silex\Application,
	App\Model\News as NewsModel,
	Symfony\Component\Validator\Constraints as Assert,
	Library\Utils\Misc as _U;

class News
{
	public $app;
	protected $form;
	
	
	public function __construct(Application $app)
	{
		$this -> app = $app;
	}
	
	public function buildForm($data= [])
	{
		$model = new NewsModel();
		
		$form = $this -> app['form.factory'] -> createBuilder('form', null, ['csrf_protection' => false])
				 -> add('title', 'text')
				 -> add('intro', 'text', ['constraints' => new Assert\NotBlank()])
				 -> add('body', 'textarea')
				 -> add('date_posted', 'text')
				 -> add('status', 'choice', ['choices' => [1 => 'Опубликовать', 0 => 'Скрыть'], 
				 							 'expanded' => true,
				 							 'constraints' => new Assert\Choice([0,1])])
				 -> add('logo', 'text')
				 -> getForm();
		
		return $form;
	}
}

