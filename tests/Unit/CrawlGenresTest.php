<?php

namespace Vahe\MalCrawler\Tests\Unit;

use Vahe\MalCrawler\Facades\MalCrawler;
use Vahe\MalCrawler\Tests\UnitTest;

class CrawlGenresTest extends UnitTest
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
		$this->genresResponseFile = $this->responseDirectory . 'genres_response.json';
		$this->explicitGenresResponseFile = $this->responseDirectory . 'explicit_genres_response.json';
		$this->genreDescriptionResponseFile = $this->responseDirectory . 'genres_description_response.json';
		$this->themesResponseFile = $this->responseDirectory . 'themes_response.json';
		$this->demographicsResponseFile = $this->responseDirectory . 'demographics_response.json';
	}

	public function testItCrawlsGenres()
	{
		$genresResponse = MalCrawler::crawlGenres();
		$explicitGenresResponse = MalCrawler::crawlExplicitGenres();
		$genreDescriptionResponse = MalCrawler::crawlGenreDescription(1);
		$themesResponse = MalCrawler::crawlThemes();
		$demographicsResponse = MalCrawler::crawlDemographics();

		$genres = $this->decodeAndValidateJson($genresResponse);
		$explicitGenres = $this->decodeAndValidateJson($explicitGenresResponse);
		$genreDescription = $this->decodeAndValidateJson($genreDescriptionResponse);
		$themes = $this->decodeAndValidateJson($themesResponse);
		$demographics = $this->decodeAndValidateJson($demographicsResponse);

		$this->saveResponseToFile($genres, $this->genresResponseFile);
		$this->saveResponseToFile($explicitGenres, $this->explicitGenresResponseFile);
		$this->saveResponseToFile($genreDescription, $this->genreDescriptionResponseFile);
		$this->saveResponseToFile($themes, $this->themesResponseFile);
		$this->saveResponseToFile($demographics, $this->demographicsResponseFile);

		$this->assertFileExists($this->genresResponseFile);
		$this->assertFileExists($this->explicitGenresResponseFile);
		$this->assertFileExists($this->genreDescriptionResponseFile);
		$this->assertFileExists($this->themesResponseFile);
		$this->assertFileExists($this->demographicsResponseFile);

		$this->logMessage('Genres response saved successfully.');
		$this->logMessage('Explicit genres response saved successfully.');
		$this->logMessage('Genre description response saved successfully.');
		$this->logMessage('Themes response saved successfully.');
		$this->logMessage('Demographics response saved successfully.');
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
