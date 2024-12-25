<?php

namespace Vahe\MalCrawler\Facades;

use Illuminate\Support\Facades\Facade;

class MalCrawler extends Facade
{
	protected static function getFacadeAccessor(): string
	{
		return 'mal-crawler';
	}
}
