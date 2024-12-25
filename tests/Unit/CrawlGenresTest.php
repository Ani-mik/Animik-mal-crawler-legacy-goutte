<?php

namespace Vahe\MalCrawler\Tests\Unit;

use Vahe\MalCrawler\Facades\MalCrawler;
use Vahe\MalCrawler\Tests\UnitTest;

class CrawlGenresTest extends UnitTest
{
	protected string $responseDirectory;
	protected string $genresResponseFile;
	protected string $explicitGenresResponseFile;

	protected function setUp(): void
	{
		parent::setUp();

		$this->responseDirectory = __DIR__ . '/../../storage/response/Anime/';
		$this->genresResponseFile = $this->responseDirectory . 'genres_response.json';
		$this->explicitGenresResponseFile = $this->responseDirectory . 'explicit_genres_response.json';
	}

	public function testItCrawlsGenres()
	{
		$genresResponse = MalCrawler::crawlGenres();
		$explicitGenresResponse = MalCrawler::crawlExplicitGenres();

		$genres = $this->decodeAndValidateJson($genresResponse);
		$explicitGenres = $this->decodeAndValidateJson($explicitGenresResponse);

		$this->saveResponseToFile($genres, $this->genresResponseFile);
		$this->saveResponseToFile($explicitGenres, $this->explicitGenresResponseFile);

		$this->assertFileExists($this->genresResponseFile);
		$this->assertFileExists($this->explicitGenresResponseFile);
	}

	protected function decodeAndValidateJson($response)
	{
		$decodedJson = json_decode($response->getContent(), true);

		$this->assertJson($response->getContent());
		$this->assertNotEmpty($decodedJson);

		return $decodedJson;
	}

	protected function saveResponseToFile($data, $filePath): void
	{
		$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		file_put_contents($filePath, $json);
	}
}




