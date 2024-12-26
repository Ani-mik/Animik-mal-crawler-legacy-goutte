<?php

namespace Vahe\MalCrawler\Tests;

use Orchestra\Testbench\TestCase;
use Vahe\MalCrawler\Providers\MalCrawlerServiceProvider;

/**
 * @doesNotPerformAssertions
 */
class UnitTest extends TestCase
{
	/**
	 * Common log file for all tests.
	 *
	 * @var string
	 */
	protected string $mainLogFile;

	protected function setUp(): void
	{
		parent::setUp();

		$this->mainLogFile = $this->generateLogFilePath();

		$directory = dirname($this->mainLogFile);
		if (!is_dir($directory)) {
			mkdir($directory, 0777, true);
		}

		file_put_contents($this->mainLogFile, "Log file created at: " . date('Y-m-d H:i:s') . PHP_EOL);
	}

	/**
	 * Generate a path for a log file with a unique name
	 *
	 * @return string
	 */
	protected function generateLogFilePath(): string
	{
		$timestamp = date('Y-m-d_H');
		return __DIR__ . "/../storage/Logs/malCrawler_{$timestamp}.log";
	}

	/**
	 * Log messages to a common log file.
	 *
	 * @param string $message
	 * @return void
	 */
	protected function logMessage(string $message): void
	{
		$logMessage = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
		file_put_contents($this->mainLogFile, $logMessage, FILE_APPEND);
	}

	protected function getPackageProviders($app): array
	{
		return [
		  MalCrawlerServiceProvider::class
		];
	}

	protected function getPackageAliases($app): array
	{
		return [
		  'MalCrawler' => \Vahe\MalCrawler\Facades\MalCrawler::class,
		];
	}

	public function testExample()
	{
		$this->logMessage('Test message');
		$this->assertTrue(true);
	}

	/**
	 * Decodes and validates the JSON response.
	 */
	protected function decodeAndValidateJson($response)
	{
		$decodedJson = json_decode($response->getContent(), true);
		$this->assertJson($response->getContent());
		$this->assertNotEmpty($decodedJson);
		return $decodedJson;
	}

	/**
	 * Saves data to a file in JSON format.
	 */
	protected function saveResponseToFile($data, $filePath): void
	{
		if (!file_exists($filePath)) {
			$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
			file_put_contents($filePath, $json);
		}

		$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		file_put_contents($filePath, $json);
	}
}
