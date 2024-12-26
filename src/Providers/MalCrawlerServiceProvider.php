<?php

namespace Vahe\MalCrawler\Providers;

use Illuminate\Support\ServiceProvider;
use Vahe\MalCrawler\Services\Anime\CrawlGenres;
use Vahe\MalCrawler\Services\Anime\CrawlRankings;
use Vahe\MalCrawler\Services\Anime\CrawlStudios;

class MalCrawlerServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		$this->app->singleton('mal-crawler', function () {
			return [
			  'genres' => new CrawlGenres(),
			  'studios' => new CrawlStudios(),
			  'rankings' => new CrawlRankings(),
			];
		});

		$this->mergeConfigFrom(
		  __DIR__ . '/../../config/mal-crawler.php', 'malCrawler'
		);
	}

	/**
	 * Bootstrap any package services.
	 */
	public function boot(): void
	{
		$this->publishes([
		  __DIR__ . '/../config/mal-crawler.php' => config_path('mal-crawler.php'),
		]);
	}
}
