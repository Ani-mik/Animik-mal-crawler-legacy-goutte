<?php

namespace Vahe\MalCrawler\Services\Anime;

use Goutte\Client;
use Illuminate\Http\JsonResponse;
use Vahe\MalCrawler\Services\BaseService;

class CrawlGenres extends BaseService
{
	protected Client $client;

	public function __construct()
	{
		$this->client = new Client();
	}

	/**
	 * Получить жанры с указанного URL с ID
	 *
	 * Get genres from the specified URL with ID.
	 *
	 * Этот метод запрашивает данные о жанрах с указанного URL и возвращает их в формате JSON.
	 *
	 * This method fetches genre data from a specified URL and returns them in JSON format.
	 *
	 * @return JsonResponse
	 */
	public function crawlGenres(): JsonResponse
	{
		return $this->crawlGenreData('.anime-manga-search .genre-link', 0);
	}

	/**
	 * Получить явные жанры (например, Ecchi, Hentai) со страницы
	 *
	 * Get explicit genres (e.g., Ecchi, Hentai) from the page.
	 *
	 * Этот метод фильтрует и возвращает явные жанры в формате JSON.
	 *
	 * This method filters and returns explicit genres in JSON format.
	 *
	 * @return JsonResponse
	 */
	public function crawlExplicitGenres(): JsonResponse
	{
		return $this->crawlGenreData('.anime-manga-search .genre-link', 1);
	}

	/**
	 * Получить темы аниме
	 *
	 * Get Anime themes.
	 *
	 * Этот метод возвращает темы аниме, извлекая их с указанного URL.
	 *
	 * This method returns anime themes by extracting them from a specified URL.
	 *
	 * @return JsonResponse
	 */
	public function crawlThemes(): JsonResponse
	{
		return $this->crawlGenreData('.anime-manga-search .genre-link', 2);
	}

	/**
	 * Получить демографию аниме
	 *
	 * Get Anime demographics.
	 *
	 * Этот метод возвращает демографическую информацию о аниме.
	 *
	 * This method returns demographic data about anime.
	 *
	 * @return JsonResponse
	 */
	public function crawlDemographics(): JsonResponse
	{
		return $this->crawlGenreData('.anime-manga-search .genre-link', 3);
	}

	/**
	 * Получить описание жанра по malId
	 *
	 * Get description of a genre by malId.
	 *
	 * Этот метод извлекает описание жанра с указанным malId и возвращает его в формате JSON.
	 *
	 * This method extracts the description of a genre with the specified malId and returns it in JSON format.
	 *
	 * @param int $malId
	 * @return JsonResponse
	 */
	public function crawlGenreDescription(int $malId): JsonResponse
	{
		$baseUrl = config('malCrawler.base_url');
		$genresUrl = config('malCrawler.genre');
		$url = $baseUrl . $genresUrl . '/' . $malId;

		$crawler = $this->client->request('GET', $url);

		$description = $crawler->filter('#content .genre-description')->count() > 0
		  ? $crawler->filter('#content .genre-description')->text()
		  : null;

		if (empty($description)) {
			$description = config('malCrawler.not_found');
		} else {
			$description = trim($description);
		}

		return response()->json([
		  'malId' => $malId,
		  'description' => $description
		]);
	}

	/**
	 * Общий метод для извлечения жанров
	 *
	 * A General Method for Genre Extraction.
	 *
	 * Этот метод выполняет парсинг жанров с указанного URL и возвращает их в формате JSON.
	 * В зависимости от переданного индекса, он может фильтровать данные по категориям.
	 *
	 * This method parses genres from a specified URL and returns them in JSON format.
	 * Depending on the passed index, it can filter the data by categories.
	 *
	 * @param string $genreSelector
	 * @param int|null $index
	 * @return JsonResponse
	 */
	protected function crawlGenreData(string $genreSelector, ?int $index = null): JsonResponse
	{
		$url = config('malCrawler.base_url') . config('malCrawler.genres_url');

		$crawler = $this->client->request('GET', $url);

		$genreItems = $crawler->filter($genreSelector);
		if ($index !== null) {
			$genreItems = $genreItems->eq($index);
		}

		$idCounter = 1;

		$genres = $genreItems->filter('.genre-name-link')->each(function ($node) use (&$idCounter) {

			preg_match('/\/(\d+)\/(.+)/', $node->attr('href'), $matches);

			if (empty($matches[1])) {
				return null;
			}

			$name = $node->text();
			preg_match('/(.*) \((\d+[,0-9]*)\)/', $name, $nameMatches);

			$slug = isset($matches[2]) ? $this->generateSlug($matches[2]) : '';

			return [
			  'id' => $idCounter++,
			  'malId' => (int)$matches[1],
			  'slug' => $slug,
			  'name' => $nameMatches[1] ?? $name,
			  'titlesCount' => isset($nameMatches[2]) ? (int)str_replace(',', '', $nameMatches[2]) : 0,
			  'link' => $node->attr('href'),
			];
		});

		$genres = array_filter($genres);

		return response()->json(array_values($genres));
	}
}
