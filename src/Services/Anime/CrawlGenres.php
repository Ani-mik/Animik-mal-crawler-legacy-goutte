<?php

namespace Vahe\MalCrawler\Services\Anime;

use Goutte\Client;

class CrawlGenres
{
	protected Client $client;

	public function __construct()
	{
		$this->client = new Client();
	}

	/**
	 * Get genres from the specified URL
	 *
	 * @return array
	 */
	public function crawlGenres(): array
	{
		$baseUrl = function_exists('config') ? config('mal-crawler.base_url') : 'https://myanimelist.net';
		$genresUrl = function_exists('config') ? config('mal-crawler.genres_url') : '/anime.php';

		$url = $baseUrl . $genresUrl;

		$crawler = $this->client->request('GET', $url);

		return $crawler->filter('.anime-manga-search .genre-link')->first()->filter('.genre-name-link')->each(function ($node) {
			return [
			  'name' => $node->text(),
			  'link' => $node->attr('href'),
			];
		});
	}
}
