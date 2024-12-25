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

	protected string $loggingDirectory;
	protected string $genresLoggingFile;
	protected string $explicitGenresLoggingFile;
	protected string $genreDescriptionLoggingFile;

	protected function setUp(): void
	{
		parent::setUp();

		$this->responseDirectory = __DIR__ . '/../../storage/response/Anime/';
		$this->genresResponseFile = $this->responseDirectory . 'genres_response.json';
		$this->explicitGenresResponseFile = $this->responseDirectory . 'explicit_genres_response.json';
		$this->genreDescriptionResponseFile = $this->responseDirectory . 'genres_description.json';

		$this->themesResponseFile = $this->responseDirectory . 'themes_response.json';
		$this->demographicsResponseFile = $this->responseDirectory . 'demographics_response.json';

		$this->loggingDirectory = __DIR__ . '/../../storage/Logs/Anime/';
		$this->genresLoggingFile = $this->loggingDirectory . 'genres_response.log';
		$this->explicitGenresLoggingFile = $this->loggingDirectory . 'explicit_genres_response.log';
		$this->genreDescriptionLoggingFile = $this->loggingDirectory . 'genres_description.log';

		$this->themesLoggingFile = $this->loggingDirectory . 'themes_response.log';
		$this->demographicsLoggingFile = $this->loggingDirectory . 'demographics_response.log';
	}

	public function testItCrawlsGenres()
	{
		$genresResponse = MalCrawler::crawlGenres();
		$explicitGenresResponse = MalCrawler::crawlExplicitGenres();
		$genreDescriptionResponse = MalCrawler::crawlGenreDescription(1);

		$themesResponse = MalCrawler::crawlThemes();
		$demographics = MalCrawler::crawlDemographics();

		$genres = $this->decodeAndValidateJson($genresResponse);
		$explicitGenres = $this->decodeAndValidateJson($explicitGenresResponse);
		$genreDescription = $this->decodeAndValidateJson($genreDescriptionResponse);

		$themes = $this->decodeAndValidateJson($themesResponse);
		$demographics = $this->decodeAndValidateJson($demographics);

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

		$this->logMessage($this->genresLoggingFile, 'Genres response saved successfully.');
		$this->logMessage($this->explicitGenresLoggingFile, 'Explicit genres response saved successfully.');
		$this->logMessage($this->genreDescriptionLoggingFile, 'Genre description response saved successfully.');

		$this->logMessage($this->themesLoggingFile, 'Themes response saved successfully.');
		$this->logMessage($this->demographicsLoggingFile, 'Demographics response saved successfully.');
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

	protected function logMessage($filePath, $message): void
	{
		$logMessage = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
		file_put_contents($filePath, $logMessage, FILE_APPEND);
	}
}
