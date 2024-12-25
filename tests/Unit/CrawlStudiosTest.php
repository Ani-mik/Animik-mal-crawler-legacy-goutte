<?php

namespace Unit;

use Vahe\MalCrawler\Facades\MalCrawler;
use Vahe\MalCrawler\Tests\UnitTest;

class CrawlStudiosTest extends UnitTest
{
	protected string $responseDirectory;
	protected string $studiosResponseFile;

	protected string $loggingDirectory;
	protected string $studiosLoggingFile;

	protected function setUp(): void
	{
		parent::setUp();

		$this->responseDirectory = __DIR__ . '/../../storage/response/Anime/';
		$this->studiosResponseFile = $this->responseDirectory . 'studios_response.json';

		$this->loggingDirectory = __DIR__ . '/../../storage/Logs/Anime/';
		$this->studiosLoggingFile = $this->loggingDirectory . 'studios_response.log';
	}

	public function testItCrawlsStudios()
	{
		$studiosResponse = MalCrawler::crawlStudios();

		file_put_contents($this->studiosLoggingFile, 'Response Content: ' . $studiosResponse->getContent() . PHP_EOL, FILE_APPEND);

		$studios = $this->decodeAndValidateJson($studiosResponse);

		$this->saveResponseToFile($studios, $this->studiosResponseFile);

		$this->assertFileExists($this->studiosLoggingFile);

		$this->logMessage($this->studiosLoggingFile, 'Genres response saved successfully.');
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
