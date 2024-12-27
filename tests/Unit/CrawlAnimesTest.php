<?php

namespace Unit;

use Vahe\MalCrawler\Facades\MalCrawler;
use Vahe\MalCrawler\Tests\UnitTest;

class CrawlAnimesTest extends UnitTest
{
	protected string $responseDirectory;
	protected string $genresResponseFile;
	protected string $explicitGenresResponseFile;
	protected string $genreDescriptionResponseFile;
	protected string $themesResponseFile;
	protected string $demographicsResponseFile;

	protected function setUp(): void
	{
		parent::setUp();

		$this->responseDirectory = __DIR__ . '/../../storage/response/Anime/';
		$this->genresResponseFile = $this->responseDirectory . 'anime_range_response.json';

	}

	public function testItCrawlsGenres()
	{
		$genresResponse = MalCrawler::crawlAnimeRange();

		$genres = $this->decodeAndValidateJson($genresResponse);

		$this->saveResponseToFile($genres, $this->genresResponseFile);

		$this->assertFileExists($this->genresResponseFile);

		$this->logMessage('Genres response saved successfully.');
	}
}
