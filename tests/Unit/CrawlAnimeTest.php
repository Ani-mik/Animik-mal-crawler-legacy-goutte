<?php

namespace Unit;

use Vahe\MalCrawler\Facades\MalCrawler;
use Vahe\MalCrawler\Tests\UnitTest;

class CrawlAnimeTest extends UnitTest
{
	protected string $responseDirectory;
	protected string $animeRangeResponseFile;

	protected function setUp(): void
	{
		parent::setUp();

		$this->responseDirectory = __DIR__ . '/../../storage/response/Anime/';
		$this->animeRangeResponseFile = $this->responseDirectory . 'anime_range_response.json';
	}

	public function testItCrawlsGenres()
	{
		$animeRangeResponse = MalCrawler::crawlAnimeRange();

		$animeRange = $this->decodeAndValidateJson($animeRangeResponse);

		$this->saveResponseToFile($animeRange, $this->animeRangeResponseFile);

		$this->assertFileExists($this->animeRangeResponseFile);

		$this->logMessage('Anime response saved successfully.');
	}
}
