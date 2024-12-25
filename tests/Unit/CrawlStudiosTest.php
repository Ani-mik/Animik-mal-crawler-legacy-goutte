<?php

namespace Unit;

use Vahe\MalCrawler\Facades\MalCrawler;
use Vahe\MalCrawler\Tests\UnitTest;

class CrawlStudiosTest extends UnitTest
{
	protected string $responseDirectory;
	protected string $studiosResponseFile;

	protected function setUp(): void
	{
		parent::setUp();

		$this->responseDirectory = __DIR__ . '/../../storage/response/Anime/Studios/';
		$this->studiosResponseFile = $this->responseDirectory . 'studios_response.json';
		$this->studiosInformationResponseFile = $this->responseDirectory . 'studios_information_response.json';
	}

	public function testItCrawlsStudios()
	{
		$studiosResponse = MalCrawler::crawlStudios();
		$studiosInformationResponse = MalCrawler::crawlStudioInformation(2);

		$studios = $this->decodeAndValidateJson($studiosResponse);
		$studiosInformation = $this->decodeAndValidateJson($studiosInformationResponse);

		$this->saveResponseToFile($studios, $this->studiosResponseFile);
		$this->saveResponseToFile($studiosInformation, $this->studiosInformationResponseFile);

		$this->assertFileExists($this->studiosResponseFile);
		$this->assertFileExists($this->studiosInformationResponseFile);

		$this->logMessage('Studios response saved successfully.');
		$this->logMessage('Studio Information response saved successfully.');
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
