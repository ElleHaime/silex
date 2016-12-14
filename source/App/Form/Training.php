<?php 

namespace App\Form;

use Silex\Application,
	App\Model\Training as TrainingModel,
	Symfony\Component\Validator\Constraints as Assert,
	Library\Utils\Misc as _U;

class Training
{
	public $app;
	protected $form;
	
	
	public function __construct(Application $app)
	{
		$this -> app = $app;
	}
	
	
	public function buildForm($data= [])
	{
		$model = new TrainingModel();
		
		$form = $this -> app['form.factory'] -> createBuilder('form', null, ['csrf_protection' => false])
				 -> add('name', 'text', ['constraints' => new Assert\NotBlank()])
				 -> add('url_name', 'text', ['constraints' => new Assert\NotBlank()])
				 -> add('intro', 'text', ['constraints' => new Assert\NotBlank()])
				 -> add('intro_hidden', 'text')
				 -> add('description', 'textarea', ['constraints' => new Assert\NotBlank()])
				 -> add('description_hidden', 'textarea')
				 -> add('header_big', 'text')
				 -> add('header_small', 'text')
				 -> add('status', 'choice', ['choices' => [1 => 'Опубликовать', 0 => 'Скрыть'], 
				 							 'expanded' => true,
				 							 'constraints' => new Assert\Choice([0,1])])
 				 -> add('status', 'choice', ['choices' => [1 => 'Новый', 0 => 'Старый'],
 							 				 'expanded' => true,
 							 				 'constraints' => new Assert\Choice([0,1])])
				 -> getForm();
		
		return $form;
	}
}

