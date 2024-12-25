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
		$baseUrl = config('malCrawler.base_url');
		$genresUrl = config('malCrawler.genres_url');

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
