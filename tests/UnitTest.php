<?php

namespace Vahe\MalCrawler\Tests;

use Orchestra\Testbench\TestCase;
use Vahe\MalCrawler\Providers\MalCrawlerServiceProvider;

/**
 * @doesNotPerformAssertions
 */
class UnitTest extends TestCase
{
	protected function getPackageProviders($app): array
	{
		return [
		  MalCrawlerServiceProvider::class
		];
	}
	protected function getPackageAliases($app): array
	{
		return [
		  'MalCrawler' => \Vahe\MalCrawler\Facades\MalCrawler::class,
		];
	}

	public function testExample()
	{
		$this->assertTrue(true);
	}
}
