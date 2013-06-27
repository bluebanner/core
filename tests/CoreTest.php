<?php 

use Mockery as m;

class CoreTest extends TestCase
{
	public function tearDown()
	{
		m::close();
	}
	
	public function testBasicSeedResult()
	{
		$this->assertEquals(2, Core::platformList()->count());
		$this->assertEquals(2, Core::accountList()->count());
		$this->assertEquals(1, Core::accountListByPlatform(1)->count());
		$this->assertEquals(1, Core::accountListByPlatform(2)->count());
		$this->assertEquals(1, Core::roleList()->count());
		$this->assertEquals(1, Core::userList()->count());
		$this->assertEquals(1, Core::userListByRole(1)->count());
		
		$this->assertInstanceOf('Bluebanner\Core\Model\Platform', Core::platformFind(1));
		$this->assertInstanceOf('Bluebanner\Core\Model\Platform', Core::platformFindByName('amazon us'));
		$this->assertInstanceOf('Bluebanner\Core\Model\Platform', Core::platformFindByAbbr('AMUS'));
		
		$this->assertInstanceOf('Bluebanner\Core\Model\Account', Core::accountFind(1));
		$this->assertInstanceOf('Bluebanner\Core\Model\Platform', Core::accountFind(1)->platform);
		$this->assertInstanceOf('Bluebanner\Core\Model\Account', Core::accountFindByName('amazon'));
		$this->assertInstanceOf('Bluebanner\Core\Model\Account', Core::accountFindByAbbr(''));
		
		$this->assertInstanceOf('Bluebanner\Core\Model\User', Core::userFind(1));
		$this->assertInstanceOf('Bluebanner\Core\Model\User', Core::userFindByUsername('admin'));
	}
	
	public function testPlatformCRUD()
	{
		$this->assertInstanceOf('Bluebanner\Core\Model\Platform', $platform = Core::platformAdd(array('name' => 'test platform', 'abbreviation' => 'TEST')));
		$this->assertTrue(Core::platformUpdate(array('id' => $platform->id, 'name' => 'test platform update')));
		$this->assertEquals('TEST', $platform->abbreviation);
		$this->assertTrue(Core::platformRemove($platform->id));
	}
	
	public function testAccountCRUD()
	{
		$this->assertInstanceOf('Bluebanner\Core\Model\Account', $platform = Core::AccountAdd(array('platform_id' => 1, 'name' => 'test account', 'abbreviation' => 'TEST')));
		$this->assertTrue(Core::accountUpdate(array('id' => $platform->id, 'name' => 'test account update')));
		$this->assertEquals('TEST', $platform->abbreviation);
		$this->assertTrue(Core::accountRemove($platform->id));
	}
}