<?php

namespace Unit;

use Vahe\MalCrawler\Facades\MalCrawler;
use Vahe\MalCrawler\Tests\UnitTest;

class CrawlRankingsTest extends UnitTest
{
	protected string $responseDirectory;
	protected string $rankingsResponseFile;

	protected function setUp(): void
	{
		parent::setUp();

		$this->responseDirectory = __DIR__ . '/../../storage/response/Anime/';
		$this->rankingsResponseFile = $this->responseDirectory . 'rankings_response.json';
	}

	public function testItCrawlsGenres()
	{
		$rankingsResponse = MalCrawler::crawlRankings();

		$rankings = $this->decodeAndValidateJson($rankingsResponse);

		$this->saveResponseToFile($rankings, $this->rankingsResponseFile);

		$this->assertFileExists($this->rankingsResponseFile);

		$this->logMessage('Genres response saved successfully.');
	}
}
