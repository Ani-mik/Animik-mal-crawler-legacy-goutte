<?php

namespace Vahe\MalCrawler\Tests;

use PHPUnit\Framework\TestCase;
use Vahe\MalCrawler\Providers\MalCrawlerServiceProvider;

class UnitTest extends TestCase
{
	protected function getPackageProviders($app): array
	{
		return [
		  MalCrawlerServiceProvider::class
		];
	}
}
