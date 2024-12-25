<?php

namespace Vahe\MalCrawler\Providers;

use Illuminate\Support\ServiceProvider;
use Vahe\MalCrawler\Services\Anime\CrawlGenres;

class MalCrawlerServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		$this->app->singleton('mal-crawler', function () {
			return new CrawlGenres();
		});

		$this->mergeConfigFrom(
		  __DIR__.'/../../config/mal-crawler.php', 'malCrawler'
		);

		//		$this->mergeConfigFrom(
		//		  __DIR__ . '/../../config/mal-crawler.php', 'mal-crawler'
		//		);
	}

	/**
	 * Bootstrap any package services.
	 */
	public function boot(): void
	{
		$this->publishes([
		  __DIR__.'/../config/mal-crawler.php' => config_path('mal-crawler.php'),
		]);
	}
}
