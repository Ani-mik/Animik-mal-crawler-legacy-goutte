<?php

namespace Vahe\MalCrawler\Tests\Unit;

use Vahe\MalCrawler\Facades\MalCrawler;
use Vahe\MalCrawler\Tests\UnitTest;

class CrawlGenresTest extends UnitTest
{
	public function testItCrawlsGenres()
	{
		$logDirectory = __DIR__ . '/../../storage/Logs/Anime/';
		$logFile = $logDirectory . 'crawl_genres.log';

		file_put_contents($logFile, '');

		file_put_contents($logFile, "Starting test: Crawling genres using Facade\n", FILE_APPEND);

		$genres = MalCrawler::crawlGenres();

		file_put_contents($logFile, "Crawling completed, found " . count($genres) . " genres.\n", FILE_APPEND);

		$this->assertIsArray($genres);
		$this->assertNotEmpty($genres);
		$this->assertArrayHasKey('name', $genres[0]);
		$this->assertArrayHasKey('link', $genres[0]);

		file_put_contents($logFile, "Test passed successfully.\n", FILE_APPEND);

		file_put_contents($logFile, "\n" . print_r($genres, true), FILE_APPEND);
	}
}
