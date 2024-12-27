<?php

namespace Vahe\MalCrawler\Providers;

use Illuminate\Support\ServiceProvider;
use Vahe\MalCrawler\Services\Anime\CrawlAnime;
use Vahe\MalCrawler\Services\Anime\CrawlGenres;
use Vahe\MalCrawler\Services\Anime\CrawlRankings;
use Vahe\MalCrawler\Services\Anime\CrawlSeasons;
use Vahe\MalCrawler\Services\Anime\CrawlStudios;

class MalCrawlerServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * Регистрирует сервис mal-crawler и его зависимости в контейнере сервисов.
	 * Эти сервисы будут отвечать за парсинг жанров аниме, студий, рейтингов, сезонов и самих аниме.
	 */
	public function register(): void
	{
		$this->app->singleton('mal-crawler', function () {
			return [
			  'genres' => new CrawlGenres(),
			  'studios' => new CrawlStudios(),
			  'rankings' => new CrawlRankings(),
			  'seasons' => new CrawlSeasons(),
			  'anime' => new CrawlAnime(),
			];
		});

		$this->mergeConfigFrom(
		  __DIR__ . '/../../config/mal-crawler.php', 'malCrawler'
		);
	}

	/**
	 * Bootstrap any package services.
	 *
	 * Публикует конфигурационный файл mal-crawler для того, чтобы пользователь мог изменить настройки.
	 */
	public function boot(): void
	{
		$this->publishes([
		  __DIR__ . '/../config/mal-crawler.php' => config_path('mal-crawler.php'),
		]);
	}
}
