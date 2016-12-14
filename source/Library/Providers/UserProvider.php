<?php
namespace Library\Providers;
 
use Symfony\Component\Security\Core\User\UserProviderInterface,
	Symfony\Component\Security\Core\User\UserInterface,
	Symfony\Component\Security\Core\User\User,
	Symfony\Component\Security\Core\Exception\UsernameNotFoundException,
	Symfony\Component\Security\Core\Exception\UnsupportedUserException,
	Doctrine\DBAL\Connection,
	Library\Utils\Misc as _U;


class UserProvider implements UserProviderInterface
{
	public function __construct(Connection $conn, \Application $app)
	{
		$this -> db = $conn;
	}
	
	public function loadUserByUsername($username)
	{
		$query = $this -> db -> createQueryBuilder()
							-> select('id, username, password, roles')
							-> from('user', 'user')
							-> where('username = :username')
							-> setParameter('username', strtolower($username));
	
		$data = $query -> execute() -> fetch();
	
		if (empty($data)) {
			throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
		}

		return new User($data['username'], $data['password'], [$data['roles']], true, true, true, true);
	}
	
	
	public function refreshUser(UserInterface $user)
	{
		if (!$user instanceof User) {
			throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
		}
		
		return $this -> loadUserByUsername($user -> getUsername());
	}
	
	public function supportsClass($class)
	{
		return $class === 'Symfony\Component\Security\Core\User\User';
	}
	
}