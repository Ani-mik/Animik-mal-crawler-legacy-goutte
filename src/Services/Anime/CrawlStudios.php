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
	 * Получить студии с указанного URL
	 *
	 * Get studios from the specified URL.
	 *
	 * @return JsonResponse
	 */
	public function crawlStudios(): JsonResponse
	{
		return $this->crawlStudioData('.anime-manga-search .genre-link');
	}

	/**
	 * Получить информацию о студии по её malId
	 *
	 * Get description of a studio by malId.
	 *
	 * @param int $malId
	 * @return JsonResponse
	 */
	public function crawlStudioInformation(int $malId): JsonResponse
	{
		$baseUrl = config('malCrawler.base_url');
		$genresUrl = config('malCrawler.studio_url');
		$url = $baseUrl . $genresUrl . '/' . $malId;

		$crawler = $this->client->request('GET', $url);

		$title = $crawler->filter('.title-name')->count() > 0
		  ? $crawler->filter('.title-name')->text()
		  : null;

		$slug = $this->generateSlug($title);

		$image = $crawler->filter('#content .content-left .logo img')->count() > 0
		  ? $crawler->filter('#content .content-left .logo img')
		  : null;

		$imageSrc = $image?->attr('data-src') ?? $image?->attr('src') ?? 'https://cdn.myanimelist.net/images/company_no_picture.png';

		if ($imageSrc === config('malCrawler.no_studio_picture')) {
			$imageSrc = null;
		}

		$imageAlt = $image?->attr('alt');

		$infoNode = $crawler->filter('#content .content-left .mb16')->eq(1);

		$info = [];

		if ($infoNode->count() > 0) {
			$infoNode->filter('.spaceit_pad')->each(function ($item) use (&$info) {
				$label = $item->filter('span.dark_text')->count() > 0
				  ? trim($item->filter('span.dark_text')->text(), ':')
				  : null;

				$value = $item->filter('span.dark_text')->count() > 0
				  ? trim(str_replace($item->filter('span.dark_text')->text(), '', $item->text()))
				  : $item->text();

				if ($label) {
					$info[strtolower(str_replace(' ', '_', $label))] = trim($value);
				}
			});
		}

		$japanese = $info['japanese'] ?? null;
		if ($japanese) {
			$info['japanese'] = $this->decodeUnicode($japanese);
		}

		$description = null;
		$crawler->filter('#content .content-left .mb16')->eq(1)->filter('.spaceit_pad')->each(function ($item) use (&$description) {
			$text = trim($item->text());

			if ($item->filter('span.dark_text')->count() === 0 && strlen($text) > 10) {
				$description = $text;
			}
		});

		$info['description'] = $description ?? null;

		return response()->json([
		  'malId' => $malId,
		  'slug' => $slug,
		  'title' => $title,
		  'image' => [
			'src' => $imageSrc,
			'alt' => $imageAlt,
		  ],
		  'info' => $info,
		]);
	}

	/**
	 * Общий метод для извлечения студий
	 *
	 * A General Method for Studio Extraction.
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
