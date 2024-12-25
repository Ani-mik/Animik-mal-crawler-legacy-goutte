<?php

namespace Vahe\MalCrawler\Services\Anime;

use Goutte\Client;
use Illuminate\Http\JsonResponse;
use Vahe\MalCrawler\Services\BaseService;

class CrawlStudios extends BaseService
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
	public function crawlStudios(): JsonResponse
	{
		return $this->crawlStudioData('.anime-manga-search .genre-link');
	}

	/**
	 * A General Method for Genre Extraction
	 *
	 * @param string $selector
	 * @return JsonResponse
	 */
	protected function crawlStudioData(string $selector): JsonResponse
	{
		$baseUrl = config('malCrawler.base_url');
		$genresUrl = config('malCrawler.studio_url');

		$url = $baseUrl . $genresUrl;

		$crawler = $this->client->request('GET', $url);

		$studioItems = $crawler->filter($selector);

		$idCounter = 1;

		$studios = $studioItems->filter('.genre-name-link')->each(function ($node) use (&$idCounter) {

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

		$studios = array_filter($studios);

		return response()->json(array_values($studios));
	}
}
