<?php

namespace Vahe\MalCrawler\Facades;

use Illuminate\Support\Facades\Facade;

class MalCrawler extends Facade
{
	protected static function getFacadeAccessor(): string
	{
		return 'mal-crawler';
	}

	public static function crawlGenres()
	{
		return app('mal-crawler')['genres']->crawlGenres();
	}

	public static function crawlExplicitGenres()
	{
		return app('mal-crawler')['genres']->crawlExplicitGenres();
	}

	public static function crawlThemes()
	{
		return app('mal-crawler')['genres']->crawlThemes();
	}

	public static function crawlDemographics()
	{
		return app('mal-crawler')['genres']->crawlDemographics();
	}

	public static function crawlGenreDescription(int $malId)
	{
		return app('mal-crawler')['genres']->crawlGenreDescription($malId);
	}

	public static function crawlStudios()
	{
		return app('mal-crawler')['studios']->crawlStudios();
	}
}
