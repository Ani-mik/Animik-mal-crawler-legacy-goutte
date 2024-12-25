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
	 * Get genres from the specified URL with ID
	 *
	 * @return JsonResponse
	 */
	public function crawlGenres(): JsonResponse
	{
		return $this->crawlGenreData('.anime-manga-search .genre-link', 0);
	}

	/**
	 * Get explicit genres (eg Ecchi, Hentai) from the page
	 *
	 * @return JsonResponse
	 */
	public function crawlExplicitGenres(): JsonResponse
	{
		return $this->crawlGenreData('.anime-manga-search .genre-link', 1);
	}

	/**
	 * Get Anime themes
	 *
	 * @return JsonResponse
	 */
	public function crawlThemes(): JsonResponse
	{
		return $this->crawlGenreData('.anime-manga-search .genre-link', 2);
	}

	/**
	 * Get Anime Demographics
	 *
	 * @return JsonResponse
	 */
	public function crawlDemographics(): JsonResponse
	{
		return $this->crawlGenreData('.anime-manga-search .genre-link', 3);
	}

	/**
	 * Get description of a genre by malId
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
	 * A General Method for Genre Extraction
	 *
	 * @param string $genreSelector
	 * @param int|null $index
	 * @return JsonResponse
	 */
	protected function crawlGenreData(string $genreSelector, ?int $index = null): JsonResponse
	{
		$baseUrl = config('malCrawler.base_url');
		$genresUrl = config('malCrawler.genres_url');

		$url = $baseUrl . $genresUrl;

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
