<?php namespace Bluebanner\Core;

Use Bluebanner\Core\Model\Platform;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Model\Role;
use Bluebanner\Core\Model\User;

class CoreException extends \Exception {}
class PlatformNotFoundException extends \Exception {}
class AccountNotFoundException extends \Exception {}
class AccountArgumentsException extends \Exception {}

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
	
	public function platformAdd($array)
	{
		return Platform::create($array);
	}
	
	public function platformUpdate($array)
	{
		if (!array_key_exists('id', $array) || !$platform = Platform::find($array['id']))
			throw new PlatformNotFoundException("the platform with ID {$array['id']} not found!");
		
		return $platform->update($array);
	}
	
	public function platformRemove($id)
	{
		if (!$platform = Platform::find($id))
			throw new PlatformNotFoundException("the platform with ID {$id} not found!");

		return $platform->delete();
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
	
	public function accountAdd($array)
	{
		if (!array_key_exists('platform_id', $array))
			throw new AccountArgumentsException('should offer a platform id to create a Account');

		return Account::create($array);
	}
	
	public function accountUpdate($array)
	{
		if (!array_key_exists('id', $array) || !$account = Account::find($array['id']))
			throw new AccountNotFoundException("account with ID {$array['id']} not found");

		return $account->update($array);
	}
	
	public function accountRemove($id)
	{
		if (!$account = Account::find($id))
			throw new AccountNotFoundException("account with ID {$id} not found");
			
		return $account->delete();
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
