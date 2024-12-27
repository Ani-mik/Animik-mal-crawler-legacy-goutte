<?php

namespace Vahe\MalCrawler\Services\Anime;

use Goutte\Client;
use Illuminate\Http\JsonResponse;
use Vahe\MalCrawler\Services\BaseService;

class CrawlSeasons extends BaseService
{
	protected Client $client;

	public function __construct()
	{
		$this->client = new Client();
	}

	/**
	 * Получить сезоны с указанного URL
	 *
	 * Get seasons from the specified URL.
	 *
	 * @return JsonResponse
	 */
	public function crawlSeasons(): JsonResponse
	{
		return $this->crawlSeasonData('.js-categories-seasonal .anime-seasonal-byseason');
	}

	/**
	 * Общий метод для извлечения сезонов
	 *
	 * A General Method for Seasons Extraction.
	 *
	 * @param string $selector
	 * @return JsonResponse
	 */
	protected function crawlSeasonData(string $selector): JsonResponse
	{
		$url = config('malCrawler.base_url') . config('malCrawler.season_url');

		$crawler = $this->client->request('GET', $url);

		$idCounter = 1;

		$seasons = $crawler->filter($selector . ' a')->each(function ($node) use (&$idCounter) {

			$slug = $this->generateSlug(trim($node->text()));

			return [
			  'id' => $idCounter++,
			  'slug' => $slug,
			  'season' => trim($node->text()),
			  'url' => $node->attr('href'),
			];
		});

		$seasons = array_filter($seasons);
		return response()->json(array_values($seasons));
	}
}
