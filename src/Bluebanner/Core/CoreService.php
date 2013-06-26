<?php namespace Bluebanner\Core;

Use Bluebanner\Core\Model\Platform;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Model\Role;
use Bluebanner\Core\Model\User;

class CoreException extends \Exception {}

class CoreService
{
	
	const VERSION = '1.0-alpha-1-SNAPSHOT';
	
	/**
	 * @return $version of this module
	 */
	public function version()
	{
		return self::VERSION;
	}
	
	public function platformList()
	{
		return Platform::all();
	}
	
	public function platformFind($id)
	{
		return Platform::find($id);
	}
	
	public function platformFindByName($name)
	{
		return Platform::where('name', '=', $name)->first();
	}
	
	public function platformFindByAbbr($abbr)
	{
		return Platform::where('abbreviation', '=', $abbr)->first();
	}
	
	public function accountList()
	{
		return Account::all();
	}
	
	public function accountListByPlatform($platform_id)
	{
		return Account::where('platform_id', '=', $platform_id);
	}
	
	public function accountFind($id)
	{
		return Account::find($id);
	}
	
	public function accountFindByName($name)
	{
		return Account::where('name', '=', $name)->first();
	}
	
	public function accountFindByAbbr($abbr)
	{
		return Account::where('abbreviation', '=', $abbr)->first();
	}
	
	public function roleList()
	{
		return Role::all();
	}
	
	public function userList()
	{
		return User::all();
	}
	
	public function userListByRole($role_id)
	{
		return User::where('role_id', '=', $role_id);
	}
	
	public function userFind($id)
	{
		return User::find($id);
	}
	
	public function userFindByUsername($username)
	{
		return User::where('username', '=', $username)->first();
	}
}
