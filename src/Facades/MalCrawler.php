<?php

namespace Vahe\MalCrawler\Facades;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Facade;

class MalCrawler extends Facade
{

	protected static function getFacadeAccessor(): string
	{
		return 'mal-crawler';
	}

	/**
	 * Краулит жанры аниме.
	 *
	 * Crawls anime genres.
	 *
	 * @return JsonResponse
	 */
	public static function crawlGenres(): JsonResponse
	{
		return app('mal-crawler')['genres']->crawlGenres();
	}

	/**
	 * Краулит явные жанры аниме (например, для фильмов с откровенным содержанием).
	 * Использует метод для краулинга жанров и фильтрует явные жанры.
	 *
	 * Crawls explicit anime genres (e.g., for adult content).
	 * Uses the genre crawling method and filters explicit genres.
	 *
	 * @return JsonResponse
	 */
	public static function crawlExplicitGenres(): JsonResponse
	{
		return app('mal-crawler')['genres']->crawlExplicitGenres();
	}

	/**
	 * Краулит темы аниме (например, романтика, приключения).
	 * Использует метод для краулинга жанров и фильтрует по темам.
	 *
	 * Crawls anime themes (e.g., romance, adventure).
	 * Uses the genre crawling method and filters by themes.
	 *
	 * @return JsonResponse
	 */
	public static function crawlThemes(): JsonResponse
	{
		return app('mal-crawler')['genres']->crawlThemes();
	}

	/**
	 * Краулит демографические группы аниме (например, шонен, сёнен, сэйнен и т.д.).
	 * Использует метод для краулинга жанров и фильтрует по демографическим группам.
	 *
	 * Crawls anime demographics (e.g., shonen, shoujo, seinen, etc.).
	 * Uses the genre crawling method and filters by demographics.
	 *
	 * @return JsonResponse
	 */
	public static function crawlDemographics(): JsonResponse
	{
		return app('mal-crawler')['genres']->crawlDemographics();
	}

	/**
	 * Краулит описание жанра по его malId.
	 * Используется для получения описания жанра, явного жанра или темы.
	 *
	 * Crawls genre description by its malId.
	 * Used for getting the description of a genre, explicit genre, or theme.
	 *
	 * @param int $malId
	 * @return JsonResponse
	 */
	public static function crawlGenreDescription(int $malId): JsonResponse
	{
		return app('mal-crawler')['genres']->crawlGenreDescription($malId);
	}

	/**
	 * Краулит студии аниме.
	 *
	 * Crawls anime studios.
	 *
	 * @return JsonResponse
	 */
	public static function crawlStudios(): JsonResponse
	{
		return app('mal-crawler')['studios']->crawlStudios();
	}

	/**
	 * Краулит информацию о студии по её malId.
	 *
	 * Crawls studio information by its malId.
	 *
	 * @param int $malId
	 * @return JsonResponse
	 */
	public static function crawlStudioInformation(int $malId): JsonResponse
	{
		return app('mal-crawler')['studios']->crawlStudioInformation($malId);
	}

	/**
	 * Краулит рейтинги аниме.
	 *
	 * Crawls anime rankings.
	 *
	 * @return JsonResponse
	 */
	public static function crawlRankings(): JsonResponse
	{
		return app('mal-crawler')['rankings']->crawlRankings();
	}

	/**
	 * Краулит сезоны аниме.
	 *
	 * Crawls anime seasons.
	 *
	 * @return JsonResponse
	 */
	public static function crawlSeasons(): JsonResponse
	{
		return app('mal-crawler')['seasons']->crawlSeasons();
	}

	/**
	 * Краулит диапазон ID аниме.
	 *
	 * Crawls the anime ID range.
	 *
	 * @return JsonResponse
	 */
	public static function crawlAnimeRange(): JsonResponse
	{
		return app('mal-crawler')['anime']->crawlAnimeRange();
	}
}
