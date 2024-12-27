<?php

namespace Vahe\MalCrawler\Services\Anime;

use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Http\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Vahe\MalCrawler\Services\BaseService;

class CrawlAnime extends BaseService
{
	protected HttpClientInterface $httpClient;

	public function __construct()
	{
		$this->httpClient = HttpClient::create();
	}

	/**
	 * Find the maximum anime ID on MyAnimeList
	 *
	 * @return int
	 * @throws TransportExceptionInterface
	 */
	public function findMaxAnimeId(): int
	{
		$low = 1;
		$high = config('malCrawler.anime_range_max_find', 10000);
		$step = $high;
		$baseUrl = config('malCrawler.base_url');
		$animeUrl = config('malCrawler.anime_url');
		$url = rtrim($baseUrl, '/') . $animeUrl . '/';

		while (true) {
			$response = $this->httpClient->request('GET', $url . $high);
			if ($response->getStatusCode() === 404) {
				break;
			}
			$low = $high + 1;
			$high += $step;
		}

		$lastValidId = $low - 1;

		while ($low <= $high) {
			$mid = intdiv($low + $high, 2);
			$response = $this->httpClient->request('GET', $url . $mid);

			if ($response->getStatusCode() === 200) {
				$lastValidId = $mid;
				$low = $mid + 1;
			} else {
				$high = $mid - 1;
			}
		}

		return $lastValidId;
	}

	/**
	 * Вернуть минимальный и максимальный ID в формате JSON
	 *
	 * @return JsonResponse
	 * @throws TransportExceptionInterface
	 */
	public function crawlAnimeRange(): JsonResponse
	{
		$maxId = $this->findMaxAnimeId();
		return response()->json([
		  'minId' => 1,
		  'maxId' => $maxId,
		]);
	}
}
