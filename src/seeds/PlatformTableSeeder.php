<?php namespace Bluebanner\Core;

use Illuminate\Database\Seeder;
use Bluebanner\Core\Model\Platform;
use Bluebanner\Core\Model\Role;
use Bluebanner\Core\Model\Account;
use Bluebanner\Core\Model\User;
use Illuminate\Support\Facades\Hash;

class PlatformTableSeeder extends Seeder
{
	
	public function run()
	{
		
		User::truncate();
		Account::truncate();
		Role::truncate();
		Platform::truncate();
		
		
		$amazon_us = Platform::create(array(
			'name'	=> 'amazon us',
			'abbreviation' => 'AMUS'
		));
		
		$ebay_us = Platform::create(array(
			'name'	=> 'eBay us',
			'abbreviation' => 'EBUS'
		));
		
		Account::create(array(
			'platform_id' => $amazon_us->id,
			'name'	=> 'amazon',
			'abbreviation' => '',
			'service_email' => '',
			'bill_email' => '',
			'api_configuration' => '{"access_key_id":"AKIAJZI5EXGOZV22NQJQ","secret_acces_key":"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","app_name":"BetterStuff LowerPrice","app_version":"2010-10-01","merchant_id":"A2KV19AYUKS3X0","marketplace_id":"ATVPDKIKX0DER","service_url":"https://mws.amazonservices.com"}'
		));
		
		
		Account::create(array(
			'platform_id' => $ebay_us->id,
			'name'	=> 'betterstuff',
			'abbreviation' => '',
			'service_email' => '',
			'bill_email' => '',
			'api_configuration' => '{"dev_id":"46d5d0a6-5f24-4ebc-b139-450395acd02b","app_id":"Hisgadge-d279-4135-895a-fd0d9b56a570","cert_id":"8db99fff-956d-494d-84a6-156488bc3c44","token":"AgAAAA**AQAAAA**aAAAAA**fID7Tw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wMk4SjCpiHqQWdj6x9nY+seQ**a3QBAA**AAMAAA**jfcuIEhkKx59mD0Audj1LN8isPNa6JP4UkSV3GbwRStA6ibuDI+iZZrkWtcYfE8kCMR5bbHq+aW/ZSqW72YBcR8aGacg9NT1cedw6A257XTVzO4J8VIb3rVr7x4oDX5nWK7Md44SgCeEu4lEDKbo0Pfj9hCw2YXzyOhzjPKgkOgLLh03OICAsGHQ0oM0sATMX1MaBw5Cn2Dz8/fY/iE641gI0HnKiavZ8bMhCXqQpeuUVKXVHYfVNgIC7xhOu7BQ7+D6ehLFocwqODnMRVjwr4v1AIISBRoKuKd4wEEV0qCASo/xCTCIfIsvQbbTWhBhiKZj+pVSHUgwWIKhQf4VxXSnw9VIGI0v7xdvD2V/EK+SAV+w1DI24gNOUt8PAsN207i2gcSFffwUQcR73cC8B+ovMTKYAJJQW4XR2Z3/MBHmK76+l6Qyi+CA/+6rtyQKL4AJ1iK9/7KqseEcVPQTYnJCdP120393PpcW9pRuEcrt2Ski4ie/bifAaddsR1tDwtK6RRsATyM28RCQi3iiKYrjUVlTKRx98HCFY03MlKK77AVSJGFtikKO4dYdT8AH308E1QF5Q2z8vGW8Q+0CMlW45ds/Cq270Feh9lNGUv5OQjcr9lN58jfOXooHt8p+JUnrq2RySDf7biaAlPzrbenxqMd4dM3Trkw+Bpbiz74p0lWUjgecyEZBMGsyYqoSzn8b84knQOMksmp75+aro0ZfkWyoSrxlrGcfQNm+zpFGa95O8tHBJFqSPUAm7S8/"}'
		));
		
		$admin = Role::create(array(
			'name'	=> 'ROLL_ADMIN'
		));
		
		User::create(array(
			'username' => 'admin',
			'password' => Hash::make('admin'),
			'email' => '',
			'role_id' => $admin->id,
			'firstname' => 'Mars',
			'lastname' => 'Zhou'
		));
		
	}
}
