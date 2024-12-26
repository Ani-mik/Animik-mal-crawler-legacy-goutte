<?php

namespace Vahe\MalCrawler\Services\Anime;

use Goutte\Client;
use Illuminate\Http\JsonResponse;
use Vahe\MalCrawler\Services\BaseService;

class CrawlRankings extends BaseService
{
	protected Client $client;

	public function __construct()
	{
		$this->client = new Client();
	}

	/**
	 * Get rankings from the specified URL
	 *
	 * @return JsonResponse
	 */
	public function crawlRankings(): JsonResponse
	{
		return $this->crawlRankingData('.anime-manga-search .genre-link');
	}

	/**
	 * A General Method for Rankings Extraction
	 *
	 * @param string $selector
	 * @return JsonResponse
	 */
	protected function crawlRankingData(string $selector): JsonResponse
	{
		$url = config('malCrawler.base_url') . config('malCrawler.genres_url');

		$crawler = $this->client->request('GET', $url);

		$rankingItems = $crawler->filter($selector)->eq(5);

		$idCounter = 1;

		$rankings = $rankingItems->filter('.genre-name-link')->each(function ($node) use (&$idCounter) {

			$name = $node->text();

			$slug = isset($name) ? $this->generateSlug($name) : null;

			return [
			  'id' => $idCounter++,
			  'slug' => $slug,
			  'name' => $name,
			];
		});

		$rankings = array_filter($rankings);
		return response()->json(array_values($rankings));
	}
}
