<?php 

namespace App\Model;

use Silex\Application,
	Library\BaseModel,
	Library\Utils\Misc as _U,
	Symfony\Component\Security\Core\User\UserInterface,
	Symfony\Component\Security\Core\User\User as UserBase,
	Symfony\Component\Security\Core\Exception\UsernameNotFoundException,
	Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class UUser extends BaseModel
{
	static $table_name = 'user';
	
	
	public function __construct(Application $app, $username)
	{
		parent::__construct();
		$this -> salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
	}
	
	public function getUser()
	{
		_U::dump('User::getUser()');
	}
	
	
	public function createUser()
	{
		_U::dump('User::createUser()');
	}
	
	
	public function updateUser()
	{
	}
	 
	
	public function checkUserPassword()
	{
	}
	
	
	private function encodeUserPassword()
	{
	}

	
	public function validate()
	{
	}
	
	
	public function isLoggedIn()
	{
	}
	
	
	public function hasRole($role)
	{
		return in_array(strtoupper($role), $this -> getRoles(), true);
	}
	
	
	public function setSalt($salt)
	{
		$this -> salt = $salt;
	}
	
	public function getSalt()
	{
	}
}