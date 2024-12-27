<?php

namespace Unit;

use Vahe\MalCrawler\Facades\MalCrawler;
use Vahe\MalCrawler\Tests\UnitTest;

class CrawlSeasonsTest extends UnitTest
{
	protected string $responseDirectory;
	protected string $seasonsResponseFile;

	protected function setUp(): void
	{
		parent::setUp();

		$this->responseDirectory = __DIR__ . '/../../storage/response/Anime/';
		$this->seasonsResponseFile = $this->responseDirectory . 'seasons_response.json';
	}

	public function testItCrawlsGenres()
	{
		$seasonsResponse = MalCrawler::crawlSeasons();

		$seasons = $this->decodeAndValidateJson($seasonsResponse);

		$this->saveResponseToFile($seasons, $this->seasonsResponseFile);

		$this->assertFileExists($this->seasonsResponseFile);

		$this->logMessage('Seasons response saved successfully.');
	}
}
